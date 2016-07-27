<?php

namespace Core\Connection;

use \App\User;
use \App\Models\Control;
use \Core\Loger\Loger;

abstract class ConnectionAbstract
{
    /**
     *
     * @var int
     */
    protected $_countObject = 0;

    /**
     *
     * @var string
     */
    protected $_path;

    /**
     *
     * @var string
     */
    protected $_file;

    /**
     *
     * @var mixed
     */
    protected $_log;

    /**
     * @const int
     */
    const OBJECT_COUNT = 100;

    public function __construct()
    {
        $this->_log = new Loger();
    }

    /**
     *
     * @return $this
     */
    protected function _findFile()
    {
        $path = storage_path('dump');
        if (@mkdir($path, 0755, true) || is_dir($path)) {
            $files = scandir($path);
            if (is_array($files) && !empty($files)) {
                unset($files[0], $files[1]);
                foreach ($files as $file) {
                    if ($file == 'data.json') {
                        $this->_file = $path . DIRECTORY_SEPARATOR . $file;
                    } else {
                        throw new \Exception('Request is failed');
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param  array $count
     *
     * @return $this
     */
    protected function _setSession($count)
    {
        \DB::table('sessions')->update($count);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function _getSession($name)
    {
        $query = \DB::table('sessions')->where('name', '=', $name)->first();

        return $query->value;
    }

    /**
     * @param $file
     *
     * @return $this
     */
    protected function _decodeFile($file)
    {
        if (file_exists($file)) {
            $content = file_get_contents($file);

            return json_decode($content);
        } else {
            throw new \Exception('Request is failed');
        }
    }

    /**
     *
     * @return mixed
     */
    protected function _databaseConnection()
    {
        $result = [];
        $skip   = $this->_getSession('counter');
        $count  = count($this->_file) - 1;
        if (is_array($this->_file)) {
            for ($i = $skip; $i <= $count; $i++) {
                foreach ($this->_file[$i] as $key => $value) {
                    $result[$i][$key] = $value;
                    if ($key == 'card_id') {
                        $result[$i]['password'] = md5($value);
                    }
                }
            }
             $this->_setSession(['name' => 'counter', 'value' => $count+1]);
        } else {
            \Exception('error');
        }

        \DB::beginTransaction();
        try {
            if ($user = \DB::table('users')->where('card_id', '=', $result[$count]['card_id'])->first()) {
                if ($user->status = 'allow') {
                    $this->_setUserInformation($user);
                    dd('Student ' . $user->card_id . ' is coming');
                } else {
                    $this->_log->log("Student $user->card_id is coming to lab");
                    dd('Student ' . $user->card_id . ' is coming not permitted');
                    //-----------------------------------------
                }
            }
            //save connected users
            \DB::table('users')->insert($result);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception('Request error');
        }

        \DB::commit();

        $user = \DB::table('users')->where('card_id', '=', $result[$count]['card_id'])->first();
        $this->_setUserInformation($user);
        dd('hi');
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    protected function _setUserInformation($user)
    {
        $now    = date("Y-m-d H:i:s");
        $insert = [];
        if ($user != null) {
            if ($control = User::find($user->id)->control()->first()) {
                if ($control->is_coming == '1') {
                    $insert = [
                        'user_id'     => $user->id,
                        'output_time' => $now,
                        'blocked'     => 0,
                        'token'       => ($user->remember_token != null) ? $user->remember_token : null,
                        'is_coming'   => 0,
                    ];
                    $this->_log->factoryLog('output', $user->card_id);
                } else {
                    $insert = [
                        'user_id'    => $user->id,
                        'input_time' => $now,
                        'blocked'    => 0,
                        'token'      => ($user->remember_token != null) ? $user->remember_token : null,
                        'is_coming'  => 1,
                    ];
                    $this->_log->factoryLog('input', $user->card_id);
                }
                \DB::table('control')->update($insert);
                \DB::commit();
            } else {
                $insert = [
                    'user_id'    => $user->id,
                    'input_time' => $now,
                    'blocked'    => 0,
                    'token'      => ($user->remember_token != null) ? $user->remember_token : null,
                    'is_coming'  => 1,
                ];
                $this->_log->factoryLog('input', $user->card_id);
                \DB::table('control')->insert($insert);
                \DB::commit();
            }
        }

        return true;
    }

    /**
     *
     * @return mixed
     */
    protected function _prepareToConnection()
    {
        $this->_findFile();
        if ($this->_file != null) {
            $this->_file = $this->_decodeFile($this->_file);
            if ($this->_getSession('counter') < count($this->_file)) {
                $response = $this->_databaseConnection();
            } else {
                return false;
            }
        }
        return true;
    }

}