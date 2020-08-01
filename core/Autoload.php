<?php

function autoload($className)
{
    if (file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
        require_once ROOT . DS . 'core' . DS . $className . '.php';
    } else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
        require_once ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php';
    } else if (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
        require_once ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php';
    }
}

spl_autoload_register('autoload');