<?php

class Controller extends Application{


    protected $_controller, $_action;
    public $view;


    // kreiramo klasu pomocu koje cemo instancirati nase kontrolere
    // u >__construct prosljedjujemo dva parametra, zeljeni kontroler i akciju
    // takodjer vrtimo i construct application klase koju nasljedjujemo te instanciramo view 


    public function __construct($controller , $action)
    {
        parent::__construct();
        $this->_controller = $controller;
        $this->_action = $action;
        $this->view = new View();
    }
}