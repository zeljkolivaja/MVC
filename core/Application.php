<?php

declare(strict_types=1);

namespace Core;

class Application
{


    public function __construct()
    {
        $this->_set_reporting();
    }


    //class where we set error reporting (dependant on DEBUG constant in config setting)
    private function _set_reporting(): void
    {
        if (DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
        } else {
            error_reporting(0);
            ini_set('display_errors', FALSE);
            ini_set('log_errors', TRUE);
            //in xammp erorrs are being written to C\xampp\apache\logs\error.log
            ini_set('error_log', ERRORS);
        }
    }
}
