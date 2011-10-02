<?php
$production = array(
    'di' => array( 'instance' => array(
        'alias' => array(
            'album'        => 'Album\Controller\AlbumController',
        ),

        'Album\Controller\AlbumController' => array(
            'parameters' => array(
                'router' => 'Zend\Mvc\Router\Http\TreeRouteStack',
                'table'  => 'Album\Model\DbTable\Albums',
            ),
        ),

        'Album\Model\DbTable\Albums' => array(
            'parameters' => array(
                'config' => 'Zend\Db\Adapter\Mysqli',
        )),

        'Zend\Db\Adapter\Mysqli' => array(
            'parameters' => array(
                'config' => array(
                    'host' => 'localhost',
                    'username' => 'rob',
                    'password' => '123456',
                    'dbname' => 'zf2tutorial',
                    ),
        )),

        'Zend\View\PhpRenderer' => array(
            'methods' => array(
                'setResolver' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options' => array(
                        'script_paths' => array(
                            'Album' => __DIR__ . '/../views',
                        ),
                    ),
            ),
        )),
    )),
);

$staging     = $production;
$testing     = $production;
$development = $production;

$config = compact('production', 'staging', 'testing', 'development');
return $config;
