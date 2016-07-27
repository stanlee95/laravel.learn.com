<?php

namespace Core\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Core\Services\Factory
 */
class CoreConnectionFactoryFacade extends Facade
{

    public function __construct()
    {
        dd('darou');
    }
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Core\Services\Factory';
    }
}