<?php

class ErrorController extends Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function pageNotFound($message)
    {
        $this->view->render('error/pageNotFound', ["message" => $message]);
        die();
    }

    public function forbidden()
    {
        $this->view->render('error/forbidden');
        die();
    }

}