<?php
ini_set('display_errors', true);
error_reporting(-1);

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

require_once '../library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\ClassMapAutoloader' => array(
        __DIR__ . '/../library/autoload_classmap.php',
        
    ),
    'Zend\Loader\StandardAutoloader' => array(),
));


// Configuration
$appConfig = include __DIR__ . '/../configs/application.config.php';

$moduleLoader = new Zend\Loader\ModuleAutoloader($appConfig->module_paths);
$moduleLoader->register();

$moduleManager = new Zend\Module\Manager(
    $appConfig->modules,
    new Zend\Module\ManagerOptions($appConfig->module_config)
);

// Get the merged config object
$config = $moduleManager->getMergedConfig();

// Create application, bootstrap, and run
$bootstrap   = new $config->bootstrap_class($config);
$application = new Zend\Mvc\Application;
$bootstrap->bootstrap($application);

$application->run()->send();
