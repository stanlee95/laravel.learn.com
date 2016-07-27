<?php

namespace App\Providers;

use Core\Service\Factory;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * @var string
     */
    protected $_nameSpace = 'Core\Connection';


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
     /*   $this->app['core_service_factory'] = $this->app->share(function ($app) {
            return new Factory($app);
        });*/
        /*die('asdasd');
        foreach ($this->_services as $serviceName) {
            $this->_register($serviceName);
        }*/
    }

    /**
     * @param $serviceClass
     *
     * @return string
     */
    protected function _register($serviceClass)
    {
        $this->app->singleton(
            $this->_getServiceName($serviceClass),
            function ($app) use ($serviceClass) {
                $serviceClass = '\\' . $this->_nameSpace . '\\' . $serviceClass;
                var_dump($serviceClass); die;

                return new $serviceClass();
            }
        );
    }

    /**
     * @param $serviceName
     *
     * @return string
     */
    protected function _getServiceName($serviceName)
    {
        return 'Core' . $serviceName . 'Service';
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides1()
    {
        return array_map(
            function ($item) {
                return 'Core\Service\Install';
                return $this->_getServiceName($item);
            },
            $this->_services
        );
    }

}
