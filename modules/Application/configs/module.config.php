<?php

$production = array(
    'bootstrap_class' => 'Application\Bootstrap',
    'layout' => 'layouts/layout.phtml',
    'display_exceptions' => false,
    'di' => array(
        'instance' => array(
            'alias' => array(
                'view' => 'Zend\View\PhpRenderer',
            ),
            'Zend\View\HelperLoader' => array('parameters' => array(
                    'map' => array(
                        'url' => 'Application\View\Helper\Url',
                    ),
            )),
            'Zend\View\HelperBroker' => array('parameters' => array(
                    'loader' => 'Zend\View\HelperLoader',
            )),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options' => array(
                        'script_paths' => array(
                            'application' => __DIR__ . '/../views',
                        ),
                    ),
                    'broker' => 'Zend\View\HelperBroker',
                ),
            ),
    )),
    'routes' => array(
        'default' => array(
            'type' => 'Zend\Mvc\Router\Http\Regex',
            'options' => array(
                'regex' => '/(?P<controller>[^/]+)?(/(?P<action>[^/]*)?)?',
                'defaults' => array(
                    'action' => 'index',
                ),
                'spec' => '/%controller%/%action%',
            ),
        ),
        'home' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/',
                'defaults' => array(
                    'controller' => 'album',
                    'action' => 'index',
                ),
            ),
        ),
    ),
);

$staging = $production;
$testing = $production;
$development = $production;

// overrides for "testing" environment
$testing['display_exceptions'] = true;

// overrides for "development" environment
$development['display_exceptions'] = true;

$config = compact('production', 'staging', 'testing', 'development');
return $config;
