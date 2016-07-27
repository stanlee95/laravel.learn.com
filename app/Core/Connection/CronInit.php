<?php

namespace Core\Connection;

use \Core\Connection\CronLib;

class CronInit
{
    /**
     *
     * @var mixed
     */
    protected $_connection;

    /**
     *
     * @return $this
     */
    public function __construct(CronLib $object)
    {
        $this->_connection = $object;
    }

    /**
     *
     * @return mixed
     */
    public function connectToDump()
    {
        return $this->_connection->cronStart();
    }

    /**
     *
     * @return mixed
     */
    public function clearDump()
    {
        return $this->_connection->dumpClear();
    }
}