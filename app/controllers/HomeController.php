<?php

class HomeController extends Controller
{

    public function __construct()
    {
        //we check for the rememberme cookie in the parent controller
        parent::__construct();

        
    }


    public function index()
    {

        //  unset($_SESSION['userid']);

        // echo $_SESSION["userid"];
        
 
        $imageModel = new Image;
        $totalImages = $imageModel->getTotalImages();

        $this->view->render('home/index', ['totalImages' => $totalImages]);
    }

    public function getTotalImages()
    {
       
        $imageModel = new Image;
        $totalImages = $imageModel->getTotalImages();
        echo $totalImages;

    }
}
