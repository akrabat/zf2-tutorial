<?php
return array(
    'di' => array(

        'instance' => array(
            'alias' => array(
                'album' => 'Album\Controller\AlbumController',
            ),
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
                        'username' => 'rob',
                        'password' => '123456',
                        'dsn'   => 'mysql:dbname=zf2tutorial;hostname=localhost',
                    ),
                )
            ),
            'old-Zend\Db\Adapter\Adapter' => array(
                'parameters' => array(
                    'driver' => array(
                        'driver'   => 'PdoMysql',
                        'host'     => 'localhost',
                        'username' => 'rob',
                        'password' => '123456',
                        'database' => 'zf2tutorial',
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
        ),
    ),
);
