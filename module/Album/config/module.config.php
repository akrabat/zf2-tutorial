<?php
return array(
    'di' => array(

        'instance' => array(
            'Album\Controller\AlbumController' => array(
                'parameters' => array(
                    'albumTable' => 'Album\Model\AlbumTable',
                ),
            ),
            'Album\Model\AlbumTable' => array(
                'parameters' => array(
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                )
            ),
            'Zend\Db\Adapter\Adapter' => array(
                'parameters' => array(
                    'driver' => array(
                        'driver' => 'Pdo',
                        'dsn'            => 'mysql:dbname=zf2tutorial;hostname=localhost',
                        'username'       => 'rob',
                        'password'       => '123456',
                        'driver_options' => array(
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                        ),
                    ),
                )
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'album' => __DIR__ . '/../view',
                    ),
                ),
            ),

            /**
             * View helper(s)
             */
            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'zfcUserIdentity' => 'ZfcUser\View\Helper\ZfcUserIdentity',
                        'zfcUserLoginWidget' => 'ZfcUser\View\Helper\ZfcUserLoginWidget',
                    ),
                ),
            ),

            // Setup the router and routes
            'Zend\Mvc\Router\RouteStackInterface' => array(
                'parameters' => array(
                    'routes' => array(
                        'album' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/album[/:action]',
                                'constraints' => array(
                                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'Album\Controller\AlbumController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),
);
