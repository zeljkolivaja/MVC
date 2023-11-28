<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\Image;


class ImageController extends Controller
{
    private $image;
    private $session;

    public function __construct()
    {
        parent::__construct();
        SessionController::forbidIFLoggedOut();
        $this->session = SessionController::getInstance();
        $this->image = new Image;
    }

    public function index(?string $message = null): void
    {
        $images = $this->image->read();
        $this->view->render('image/index', ["images" => $images, "message" => $message]);
    }

    public function insert(): void
    {
        $this->checkCSRF();

        // $imageName = $_POST["name"];
        $validation = $this->image->imageValidation($_FILES["image"]);

        if ($validation !== true) {
            $this->index($validation);
            exit;
        }

        $this->image->saveImage($_POST["name"]);

        \Core\ROUTER::redirect("image");
    }

    public function delete(): void
    {
        $this->checkCSRF();
        $this->image->deleteImage();
        \Core\ROUTER::redirect("image");
    }

    private function checkCSRF(): void
    {
        if (
            $_POST["csrf"] == null or
            $this->session->checkCsrf($_POST["csrf"]) == false
        ) {
            $error = new ErrorController;
            $error->forbidden();
        }
    }
}
