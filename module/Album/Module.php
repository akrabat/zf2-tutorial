<?php

namespace Album;

use Zend\Form\View\HelperLoader as FormHelperLoader;

class Module
{
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
        $application        = $e->getParam('application');
        $sharedEventManager = $application->events()->getSharedManager();
        $sharedEventManager->attach('Album', 'dispatch', array($this, 'onAlbumDispatched'), 2);
        // (change 2 to -2 if you want to call the listener before the action is dispatched)
    }

    public function onAlbumDispatched($e)
    {
        // This is only called if a controller within our module has been dispatched
        $app            = $e->getParam('application');
        $serviceManager = $app->getServiceManager();
        $helperLoader   = $serviceManager->get('Zend\View\HelperLoader');

        $helperLoader->registerPlugins(new FormHelperLoader());
    }

}
