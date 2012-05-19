<?php
chdir(dirname(__DIR__));
require_once (getenv('ZF2_PATH') ?: 'vendor/ZendFramework/library') . '/Zend/Loader/AutoloaderFactory.php';

use Zend\Loader\AutoloaderFactory,
Zend\ServiceManager\ServiceManager,
Zend\Mvc\Service\ServiceManagerConfiguration;

// setup autoloader
AutoloaderFactory::factory();

// get application stack configuration
$configuration = include 'config/application.config.php';

// setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfiguration($configuration['service_manager']));
$serviceManager->setService('ApplicationConfiguration', $configuration);
$serviceManager->get('ModuleManager')->loadModules();

// Retrieve service_manager configuration from ModuleManager and set into the ServiceManager instance

// This doesn't work
// $mergedServiceManagerConfiguration = $serviceManager->get('Configuration')->service_manager->toArray();
// $smConfiguration = new ServiceManagerConfiguration($mergedServiceManagerConfiguration);
// $smConfiguration->configureServiceManager($serviceManager);

// This does work
$mergedServiceManagerConfiguration = $serviceManager->get('Configuration')->service_manager->toArray();
if (isset($mergedServiceManagerConfiguration['services'])) {
    foreach ($mergedServiceManagerConfiguration['services'] as $name => $service) {
        $serviceManager->setInvokableClass($name, $service);
    }
}
if (isset($mergedServiceManagerConfiguration['factories'])) {
    foreach ($mergedServiceManagerConfiguration['factories'] as $name => $factoryClass) {
        $serviceManager->setFactory($name, $factoryClass);
    }
}
if (isset($mergedServiceManagerConfiguration['abstractFactories'])) {
    foreach ($mergedServiceManagerConfiguration['abstractFactories'] as $factoryClass) {
        $serviceManager->addAbstractFactory($factoryClass);
    }
}
if (isset($mergedServiceManagerConfiguration['aliases'])) {
    foreach ($mergedServiceManagerConfiguration['aliases'] as $name => $service) {
        $serviceManager->setAlias($name, $service);
    }
}
if (isset($mergedServiceManagerConfiguration['shared'])) {
    foreach ($mergedServiceManagerConfiguration['shared'] as $name => $value) {
        $serviceManager->setShared($name, $value);
    }
}

// run application
$serviceManager->get('Application')->bootstrap()->run()->send();