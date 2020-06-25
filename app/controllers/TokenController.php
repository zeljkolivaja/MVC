<?php

Class TokenController
{
    private $Token;

    public function __construct()
    {
        $this->Token = new Token;
    }

    public function create($userId)
    {    
        $this->Token->create($userId);    
    }

    public function regenerate()
    {
        $this->Token->regenerate();       
    }
    
}