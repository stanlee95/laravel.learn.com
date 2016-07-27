<?php

namespace Core\Loger;


class Loger extends LogerAbstract
{

    /**
     *
     * @var mixed
     */
    protected $_connection;

    /**
     * @param string $content
     *
     * @return mixed
     */
    protected function _createOrCheckLogFile($content = null)
    {
        $path     = storage_path('logs');
        $fullPath = $path . DIRECTORY_SEPARATOR . 'loger_attendace_system.txt';
        if (@mkdir($path, 0755, true) || is_dir($path)) {
            if (file_exists($fullPath)) {
                $this->_writeLog($fullPath, $content);
            } else {
                file_put_contents($fullPath, ' ');
            }
        } else {
            throw new \Exception('File not exists');
        }
    }

    /**
     * @param string $path
     * @param string $content
     *
     * @return boolean
     */
    protected function _writeLog($path, $content = null)
    {
        $now = date("Y-m-d | H:i:s");
        $fh = fopen($path, 'a');
        fputs($fh, "$now | Log: " . $content . "\r\n");
        fclose($fh);

        return true;
    }

    /**
     * @param string $content
     *
     * @return mixed
     */
    public function log($content)
    {
        if($content != null) {
            return $this->_createOrCheckLogFile($content);
        } else {
            throw new \Exception('Content is required');
        }
    }

    /**
     * @param string $type
     * @param string $id
     *
     * @return mixed
     */
    public function factoryLog($type = 'input', $id = null)
    {
        if ($id != null) {
            switch ($type) {
                case 'input' :
                    $this->_inputLog($id);
                    break;
                case 'output':
                    $this->_outputLog($id);
                    break;
            }
        } else {
            throw new \Exception('Card-ID is required');
        }
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    protected function _inputLog($id)
    {
       return $this->_createOrCheckLogFile("Student $id is coming to lab");
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    protected function _outputLog($id)
    {
        return $this->_createOrCheckLogFile("Student $id is living from lab");
    }

}