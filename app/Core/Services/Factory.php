<?php

namespace Core\Services;

use Core\Connection\ConnectionAbstract;

class Factory
{
    /**
     * @var array
     */
    private static $_services = [];

    /**
     * @param string $alias
     *
     * @return ConnectionAbstract
     */
    public function getService($alias)
    {
        if (!array_key_exists($alias, self::$_services)) {
            $className = implode('\\', array_map('ucfirst', explode('/', $alias))) . 'Service';
            $className = __NAMESPACE__ . '\\' . $className;

            self::$_services[$alias] = new $className();
        }

        return self::$_services[$alias];
    }
}