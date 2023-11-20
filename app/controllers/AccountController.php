<?php

class AccountController extends Controller
{
    protected $user;
    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User;
        $this->session = SessionController::getInstance();
    }

    public function indexLogin($message = null, $email = null)
    {
        SessionController::forbidIFLoggedIn();
        SessionController::generateCSRF();
        $this->view->render('account/signin', ["message" => $message, "email" => $email]);
    }

    public function indexRegister($message = null, $userData = [])
    {
        SessionController::forbidIFLoggedIn();
        $this->view->render('account/signup', ["message" => $message, "userData" => $userData]);
    }

    public function indexChangePassword($message = null)
    {
        SessionController::forbidIFLoggedOut();
        $this->view->render('account/changePassword', ["message" => $message]);
    }

    public function menage()
    {
        SessionController::forbidIFLoggedOut();
        $this->view->render('account/menage');
    }
}
