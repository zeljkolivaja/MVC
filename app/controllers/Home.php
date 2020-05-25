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


        $columns = $db->findFirst('contacts', [
            'conditions' => ["lname = ?", "fname = ?"],
            'bind' => ['Livaja', 'Zeljko']
         ]);

         dnd($columns);

        
         $this->view->render('home/index');
    }
}
