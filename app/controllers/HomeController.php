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
        //  unset($_SESSION['userid']);
        $totalImages = $this->image->getTotalImages();
        $this->view->render('home/index', ['totalImages' => $totalImages]);
    }

    public function getTotalImages()
    {
        $totalImages = $this->image->getTotalImages();
        echo $totalImages;
    }
}
