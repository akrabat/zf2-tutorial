<?php

namespace Album;

use InvalidArgumentException,
    Zend\Config\Config,
    Zend\Module\Manager as ModuleManager;

class Module
{

    public function init2(ModuleManager $moduleManager)
    {
        try {
            \Zend\Loader\AutoloaderFactory::factory(array(
                'Zend\Loader\ClassMapAutoloader' => array(
                    __DIR__ . '/autoload_classmap.php',
                ),
                'Zend\Loader\StandardAutoloader' => array(
                    __NAMESPACE__ => __DIR__
                ),
            ));
        } catch (Exception $e) {
            LDBG($e);
            exit;
        }
        LDBG(\Zend\Loader\AutoloaderFactory::getRegisteredAutoloaders());exit;
    }

    public function init(ModuleManager $moduleManager)
    {
        // add a listener to the module manager's init.post event to autoload once
        // we have loaded all the configs
        $moduleManager->events()->attach('init.post', function($e) use ($moduleManager)
            {
                $is_live_site = $moduleManager->getMergedConfig(false)->is_live_site;
                if ($is_live_site) {
                    require __DIR__ . '/autoload_register.php';
                } else {
                    $standardAutoloader = new \Zend\Loader\StandardAutoloader();
                    $standardAutoloader->registerNamespace(__NAMESPACE__, __DIR__);
                    $standardAutoloader->register();
                }
            });
    }

    public function getConfig($env = null)
    {
        $config = new Config(include __DIR__ . '/configs/module.config.php');
        if (null === $env) {
            return $config;
        }
        if (!isset($config->{$env})) {
            throw new InvalidArgumentException(sprintf(
                    'Unrecognized environment "%s" provided to "%s"', $env, __METHOD__
            ));
        }

        return $config->{$env};
    }

}
