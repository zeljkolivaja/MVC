 <?php


// postavljamo status debug konstante
define('DEBUG', true);

// our database name
define('DB_NAME', 'gallery');

//database user
define('DB_USER', 'Zeljko');

//database password
define('DB_PASSWORD', 'Zeljko');

//our host, use ip adress to avoid dns lookup
define('DB_HOST', '127.0.0.1');


// definiramo koji je defaultni kontroler
 define('DEFAULT_CONTROLLER', 'HomeController');

// ako u kontroleru nismo naveli koji layout zelimo koristiti, koristi se ovaj
 define('DEFAULT_LAYOUT', 'default');

// ako nismo setali siteTitle koristi se ovaj
 define('SITE_TITLE', 'MVC framework');

//za development, a za live promjenimo u '/'
 define('PROOT', '/MVC2/');

//za storati slike
define('IMAGEDIR', 'C:/xampp/htdocs/MVC2"/public/images/');


