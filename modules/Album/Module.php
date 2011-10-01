<?php

namespace Album;

use InvalidArgumentException,
    Zend\Config\Config,
    Zend\Module\Manager as ModuleManager;

class Module
{
    public function init(ModuleManager $moduleManager)
    {
        $this->initAutoloader();
    }

    public function initAutoloader()
    {
        \Zend\Loader\AutoloaderFactory::factory(array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__
                ),
            ),
        ));
    }

    public function getConfig($env = null)
    {
        $config = new Config(include __DIR__ . '/configs/module.config.php');
        if (null === $env) {
            return $config;
        }
        if (!isset($config->{$env})) {
            throw new InvalidArgumentException(sprintf(
                'Unrecognized environment "%s" provided to "%s\%s"',
                $env,
                __NAMESPACE__,
                __METHOD__
            ));
        }

        return $config->{$env};
    }

}
