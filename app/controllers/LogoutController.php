<?php

class LogoutController extends AccountController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function logout()
    {
        SessionController::forbidIFLoggedOut();
        $this->session->destroySession();
        setcookie('remember', '', time() - 42000, '/');
        ROUTER::redirect("home/index");
    }

}