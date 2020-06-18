<?php

Class Model
{

    public $db;

    public function __construct() {
        $this->db = DB::getInstance();
     }
}