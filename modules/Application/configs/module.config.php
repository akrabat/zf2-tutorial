<?php
$production = array(
    'bootstrap_class'    => 'Application\Bootstrap',
    'display_exceptions' => false,
    'is_live_site' => true,

    'di' => array( 'instance' => array(
        'alias' => array(
            'view'  => 'Zend\View\PhpRenderer',
        ),

        'Zend\View\HelperLoader' => array('parameters' => array(
            'map' => array(
                'url' => 'Application\View\Helper\Url',
            ),
        )),
        'Zend\View\HelperBroker' => array('parameters' => array(
            'loader' => 'Zend\View\HelperLoader',
        )),
        'Zend\View\PhpRenderer' => array('methods' => array(
            'setResolver' => array(
                'resolver' => 'Zend\View\TemplatePathStack',
                'options' => array(
                    'script_paths' => array(
                        'site' => __DIR__ . '/../views',
                    ),
                ),
            ),
        ),
        'parameters' => array( 
            'broker' => 'Zend\View\HelperBroker',
        )),
    )),

    'routes' => array(
        'default' => array(
            'type'    => 'Regex',
            'options' => array(
                'regex' => '/(?P<controller>[^/]+)?(/(?P<action>[^/]*)?)?',
                'defaults' => array(
                    'controller' => 'album',
                    'action'     => 'index',
                ),
                'spec' => '/%controller%/%action%',
            ),
        ),
        'home' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/',
                'defaults' => array(
                    'controller' => 'album',
                    'action'     => 'index',
                ),
            ),
        ),
    ),
);

$staging     = $production;
$testing     = $production;
$development = $production;

$testing['display_exceptions']     = true;
$testing['is_live_site']     = false;

$development['display_exceptions'] = true;
$development['is_live_site']     = false;

$config = compact('production', 'staging', 'testing', 'development');
return $config;
