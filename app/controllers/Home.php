<?php

class Home extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }


    public function indexAction()
    {

        $db = DB::getInstance();
         $fields = [
            'fname' => 'mile',
            'lname' => 'milic'
         ];


        $contactsQ = $db->delete('contacts', 3);

        
         $this->view->render('home/index');
    }
}
