<?php

namespace Core;

use PDO;

class DB extends PDO
{
    private static $_instance = null;


    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
            parent::__construct($dsn, DB_USER, DB_PASSWORD);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            // Handle the exception, log the error, or take appropriate action
            $errorMessage = "Database connection failed: " . $e->getMessage();
            \App\Controllers\ErrorController::logError($errorMessage);
        }
    }


    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
}
