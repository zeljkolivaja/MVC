<?php

class Controller extends Application
{

    public $view;

    //class which every controller inherits, it inherits application class where application and php
    // ini setting are defined, also we check for remember me cookie if user session is empty
    // if there is one and its valid we login the user and generate new token
    public function __construct()
    {
        parent::__construct();
        $this->view = new View();

        if (empty($_SESSION['userid']) && !empty($_COOKIE['remember'])) {

            $token = new Token;
            $token->regenerate();

        }
    }

    //just practicing some magic methods

    // public function __get($property)
    // {

    //     throw new Exception("Property {$property} does not exist", 1);
    // }

    // public function __set($name, $value)
    // {
    //     throw new Exception("Property '{$name}' which you are trying to set
    //     with the value '{$value}' does not exist", 1);
    // }

    // public function __isset($name)
    // {
    //     // return isset($this->$name);

    //     $getter = 'get' . ucfirst($name);

    //     if (method_exists($this, $getter)) {
    //         return !is_null($this->$getter());
    //     } else {
    //         return isset($this->$name);
    //     }

    // }

    // public function __call($name, $arguments)
    // {
    //     //one example of using __call would be to redirect to some other method, for example
    //     // if ($name ==="username"){return $this->name()}
    //     throw new Exception("Method '{$name}' does not exist", 1);
    // }

}