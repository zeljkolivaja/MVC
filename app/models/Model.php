<?php

namespace app\Models;

class Model
{

    public $db;

    public function __construct()
    {
        $this->db = \Core\DB::getInstance();
    }
}
