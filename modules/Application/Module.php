<?php

namespace Application;

use InvalidArgumentException,
    Zend\Config\Config;

class Module
{
    public function init()
    {
        $this->initAutoloader();
    }

    public function initAutoloader()
    {
        require __DIR__ . '/autoload_register.php';
    }

    public function getConfig($env = null)
    {
        $config = new Config(include __DIR__ . '/configs/module.config.php');
        if (null === $env) {
            return $config;
        }
        if (!isset($config->{$env})) {
            throw new InvalidArgumentException(sprintf(
                'Unrecognized environment "%s" provided to "%s"',
                $env,
                __METHOD__
            ));
        }

        return $config->{$env};
    }

    public function getClassmap()
    {
        return include __DIR__ . '/classmap.php';
    }
}
