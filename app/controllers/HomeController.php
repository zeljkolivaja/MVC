<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\Image;

class HomeController extends Controller
{

    private $image;

    public function __construct()
    {
        //we check for the rememberme cookie in the parent controller
        parent::__construct();
        $this->image = new Image;
    }

    public function index(): void
    {
        $this->view->render('home/index');
    }

    public function getTotalImages(): void
    {
        $totalImages = $this->image->getTotalImages();
        echo json_encode($totalImages);
    }
}
