<?php


//defining constant so the app works in different OS

use test\TestController;

define('DS', DIRECTORY_SEPARATOR);

//root of the project
// C:\xampp\htdocs\MVC\index.php
define('ROOT', dirname(__FILE__) );

// including config.php and functions.php
require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php');


//defining where will the spl_autoload_register look for classes to instantiate
function autoload($className){
    if ( file_exists(ROOT . DS . 'core' . DS . $className . '.php') ) {
        require_once(ROOT . DS . 'core' . DS . $className . '.php');
    }else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    }else if(file_exists(ROOT . DS . 'app' . DS .  'models' . DS . $className . '.php')){
        require_once(ROOT . DS . 'app' .  DS . 'models' . DS . $className . '.php');
    }

}


spl_autoload_register('autoload');

session_start();
 
// defining array which will get user input after our app url
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

//sending the $url array to Router class, where the data will be parsed so we can extract 
//which controller/action/params user wants to load
Router::route($url);