<?php

class HomeController extends Controller
{

    private $image;

    public function __construct()
    {
        //we check for the rememberme cookie in the parent controller
        parent::__construct();
        $this->image = new Image;
    }

    public function index()
    {
        //unset($_SESSION['userid']);
        $this->view->render('home/index');
    }

    public function getTotalImages()
    {
        $totalImages = $this->image->getTotalImages();
        echo json_encode($totalImages);
    }

}