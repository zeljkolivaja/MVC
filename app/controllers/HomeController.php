<?php

class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        // trenutno cookie provjerava u parent controlleru

        // if (empty($_SESSION['userid']) && !empty($_COOKIE['remember'])) {

        //     $token = new TokenController;
        //     $token->regenerate();
 
        // }
      
    }


    public function index()
    {

        // unset($_SESSION['userid']);

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
