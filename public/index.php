<?php

//defining constant so the app works in different OS
define('DS', DIRECTORY_SEPARATOR);

//root of the project
// C:\xampp\htdocs\MVC\index.php
define('ROOT', dirname(__FILE__, 2));

require_once ROOT . DS . 'config' . DS . 'config.php';
require_once ROOT . DS . 'config' . DS . 'siteSettings.php';
require_once ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';

//defining where will the spl_autoload_register look for classes to instantiate
require_once ROOT . DS . 'core' . DS . 'Autoload.php';

session_start();

// defining array which will get user input after our app url
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

//sending the $url array to Router class, where the data will be parsed so we can extract
//which controller/action/params user wants to load

if (ENV !== 'localhost') {
    array_shift($url);
};
Router::route($url);
