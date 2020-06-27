<?php

class SeedController
{

    private $Seed;

    public function __construct()
    {
        $this->Seed = new Seed;
    }

    public function index()
    {
        $tables = $this->Seed->read();

        if ($tables == false) {
            die("Database " .DB_NAME. " is already populated");
        }else{
            die("You have successfully populated the " .DB_NAME. " database");
        }   
    }
}
