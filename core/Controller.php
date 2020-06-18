<?php

class Controller extends Application{


    public $view;


    // kreiramo klasu pomocu koje cemo instancirati nase kontrolere
    // u >__construct prosljedjujemo dva parametra, zeljeni kontroler i akciju
    // takodjer vrtimo i construct application klase koju nasljedjujemo te instanciramo view 


    public function __construct()
    {
        parent::__construct();
        $this->view = new View();

        //if the user session does not exist but there is a remember cookie
        //check it and if valid log the user in and create new session

        if (empty($_SESSION['userid']) && !empty($_COOKIE['remember'])) {

            $token = new TokenController;
            $token->regenerate();
 
        }
    }
}