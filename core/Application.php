<?php

// klasa koju ce nasljediti controlleri

class Application
{


    public function __construct()
    {
        $this->_set_reporting();
    }

    //postavljamo error reporting, u config.php definiramo konstantu DEBUG cija je vrijednost boolean,
    // te pomocu nje kontroliramo error reporting ovisno jesmo li u developmentu ili live
    private function _set_reporting()
    {
        if (DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('log_errors', 1);
            ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'errors.log');
        }
    }
}
