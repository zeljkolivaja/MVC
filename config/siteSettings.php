<?php

//change this to "online for live server"
define('ENV', 'localhost');

if (ENV === "localhost") {
    $getProjectRoot = explode('\\', ROOT);
    define('PROOT', "/" . end($getProjectRoot) . "/");
    define('IMAGEDIR', (str_replace("\\", "/", ROOT)) . "/public/images/");
    define('ERRORS', (str_replace("\\", "/", ROOT)) . "/tmp/logs/errors.log");
    define('CSSDIR', "/MVC/css/");
    define('JSDIR', "/MVC/js/");
} elseif (ENV === "online") {
    define('PROOT', '/');
    define('IMAGEDIR', '/images/');
    define('CSSDIR', "/css/");
    define('JSDIR', "/js/");
}

// debug, true for localhost
define('DEBUG', true);
// default controller when no other specified
define('DEFAULT_CONTROLLER', 'HomeController');
// default layout
define('DEFAULT_LAYOUT', 'default');
define('SITE_TITLE', 'Image Gallery');
