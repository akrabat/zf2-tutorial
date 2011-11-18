<?php
return new Zend\Config\Config(array(
    'module_paths' => array(
        realpath(__DIR__ . '/../modules'),
    ),
    'modules' => array(
        'Album',
        'Application',
    ),
    'module_listener_options' => array(
        'config_cache_enabled' => false,
        'cache_dir' => realpath(__DIR__ . '/../data/cache'),
    ),
));
