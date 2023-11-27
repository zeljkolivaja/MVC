<?php

namespace Core;

use Core\View;
use App\Models\Token;

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
}
