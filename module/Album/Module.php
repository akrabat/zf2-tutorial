<?php

namespace Album;

use Zend\Module\Manager;
use Zend\Module\Consumer\AutoloaderProvider;
use Zend\Form\View\HelperLoader as FormHelperLoader;


class Module implements AutoloaderProvider
{

    public function init(Manager $moduleManager)
    {
        $sharedEvents = $moduleManager->events()->getSharedCollections();
        $sharedEvents->attach('bootstrap', 'bootstrap', array($this, 'onBootstrap'));
    }



    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $app     = $e->getParam('application');
        $locator = $app->getLocator();
        $this->helperLoader = $locator->get('Zend\View\HelperLoader');

        $app->events()->attach('route', array($this, 'onRouteFinish'), -100);
    }

    public function onRouteFinish($e)
    {
        $matches    = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        $namespace  = substr($controller, 0, strpos($controller, '\\'));

        if ($namespace !== __NAMESPACE__) {
            return;
        }
        
        // only register form view helpers for this namespace
        $this->helperLoader->registerPlugins(new FormHelperLoader());
    }

}
