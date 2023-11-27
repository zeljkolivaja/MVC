<?php

namespace App\Controllers;

use App\Models\Seed;

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
            die("Database " . DB_NAME . " is already populated. To seed again please
            delete all tables from the database");
        } else {
            die("You have successfully populated the " . DB_NAME . " database");
        }
    }
}
