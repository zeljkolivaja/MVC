<?php


// postavljamo konstantu DS koja odgovara direcotry separatoru (\, /) koji moze biti razlicit 
// ovisno o operativnom sustavu, ovako ce uvijek biti tocan jer ce ga php echoati ovisno o OS.u
define('DS', DIRECTORY_SEPARATOR);

// postavljamo konstantnu ROOT koja odgovara root.u projekta, tako da nemoramo svaki puta pisati cijelo path
// C:\xampp\htdocs\ruah\index.php
define('ROOT', dirname(__FILE__) );

// loadamo configuration i helper funkcije
require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php');


//autoloadanje klasa da ih nemoramo svaki puta includati
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

// da bi session upamtio podatke koji su dostupni na citavoj stranici moramo ga zapoceti
session_start();
 
// kreiramo array sa vrijednostima nakon trenutne skripte npr ruah/name/12 ce nam dati
// arrays [0 = > name , 1 => 12]
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];
 
//routanje requesta
Router::route($url);