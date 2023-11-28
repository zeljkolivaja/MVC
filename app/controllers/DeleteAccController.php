<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Image;

class DeleteAccController extends AccountController
{
    private $logout;

    public function __construct()
    {
        parent::__construct();
        $this->logout = new LogoutController;
    }

    public function delete(): void
    {
        $this->session->checkCsrfandLogin();
        $id = $_POST["id"];
        //gets the all user images stored on hard drive
        $imageModel = new Image;
        $imageModel->bulkDeleteImages($id);
        //deletes the user from the DB and deletes all his images
        $this->user->delete($id);
        $this->logout->logout();
    }
}
