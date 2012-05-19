<?php

return array(
    // 'db' information should probably be in config/autoload/db.global.config.php
    'db' => array(
        'driver' => 'Pdo',
        'dsn'            => 'mysql:dbname=zf2tutorial;hostname=localhost',
        'username'       => 'rob',
        'password'       => '123456',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'album' => 'Album\Controller\AlbumController'
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'album',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);
