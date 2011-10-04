<?php
return new Zend\Config\Config(array(
    'module_paths' => array(
        realpath(__DIR__ . '/../modules'),
    ),
    'modules' => array(
        'Album',
        'Application',
    ),
    'module_config' => array( 
        'enable_config_cache'  => false,
        'cache_dir'     => realpath(__DIR__ . '/../data/cache'),
    ),
));
