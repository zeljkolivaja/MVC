<?php

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

    public function index($message = null)
    {
        $images = $this->image->read();
        $this->view->render('image/index', ["images" => $images, "message" => $message]);
    }

    public function insert()
    {
        $this->checkCSRF();

        // $imageName = $_POST["name"];
        $validation = $this->image->imageValidation($_FILES["image"]);

        if ($validation !== true) {
            $this->index($validation);
            exit;
        }

        $this->image->saveImage($_POST["name"]);

        ROUTER::redirect("image");
    }

    public function delete()
    {
        $this->checkCSRF();
        $this->image->deleteImage();
        ROUTER::redirect("image");
    }

    private function checkCSRF()
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
