<?php

namespace Album;

use Zend\Form\View\HelperLoader as FormHelperLoader;
use Album\Model\AlbumTable;

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

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(

                // One possible way to inject an AlbumTable into the controller/
                // rather than pulling it from the ServiceManager

                // 'controllers' => array (
                //     'album' => function($sm) {
                //         $controller = new AlbumController();
                //         $controller->setAlbumTable($sm->get('album-table'));
                //         return $controller;
                //     }
                // ),

                'album-table' =>  function($sm) {
                    $dbAdapter = $sm->get('db-adapter');
                    $table = new AlbumTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }

}
