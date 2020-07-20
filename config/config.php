 <?php


    //change this to "online for live server"
    define('ENV', 'localhost');

    if (ENV === "localhost") {
        $getProjectRoot = explode('\\', ROOT);
        define('PROOT', "/" . end($getProjectRoot) . "/");
        define('IMAGEDIR', (str_replace("\\", "/", ROOT)) . "/public/images/");
        define('ERRORS', (str_replace("\\", "/", ROOT)) . "/tmp/logs/errors.log");
    } elseif (ENV === "online") {
        define('PROOT', '/');
        define('IMAGEDIR', 'public/images/');
    }

    // debug, true for localhost
    define('DEBUG', true);
    // default controller when no other specified
    define('DEFAULT_CONTROLLER', 'HomeController');
    // default layout
    define('DEFAULT_LAYOUT', 'default');
    define('SITE_TITLE', 'Image Gallery');


    // THINGS TO CHANGE FOR ONLINE OR ON ANOTHER PC

    // our database name
    define('DB_NAME', 'vjezba');
    //database user
    define('DB_USER', 'Zeljko');
    //database password
    define('DB_PASSWORD', 'Zeljko');
    //our host, use ip adress to avoid dns lookup
    define('DB_HOST', '127.0.0.1');
