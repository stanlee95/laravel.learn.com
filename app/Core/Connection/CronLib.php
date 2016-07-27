<?php

namespace Core\Connection;


class CronLib extends ConnectionAbstract
{

    /**
     *
     * @return $this
     */
    public function cronStart()
    {
		return $this->_prepareToConnection();  
	}

    /**
     *
     * @return $this
     */
    public function dumpClear()
    {
        return $this->_clearDump();
    }
}