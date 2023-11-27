<?php

function autoload($className)
{
    if (file_exists(ROOT . DS . $className . '.php')) {
        require_once ROOT . DS . $className . '.php';
    }
}

spl_autoload_register('autoload');
