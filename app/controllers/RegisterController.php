<?php

class RegisterController extends AccountController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function register()
    {
        $validation = $this->user->validateRegistration();
        $userData = $this->user->formatData();

        if ($validation !== true) {
            $this->indexRegister($validation, $userData);
            exit;
        }

        $password = $_POST["password"];
        //Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $result = $this->user->create($userData["username"], $userData["email"], $passwordHash, $userData["city"], $userData["street"]);
        $id = $this->user->lastId();
        $this->session->setSession($id, $userData["username"], $userData["email"]);

        if ($result) {
            $this->view->render('home/index');
        }
    }

}