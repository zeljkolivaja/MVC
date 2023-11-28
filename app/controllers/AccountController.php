<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class AccountController extends Controller
{
    protected $user;
    protected $session;
    protected $validateUser;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User;
        $this->validateUser = new AccountValidationController;
        $this->session = SessionController::getInstance();
    }

    public function indexLogin(?string $message = null, ?string $email = null): void
    {
        SessionController::forbidIFLoggedIn();
        SessionController::generateCSRF();
        $this->view->render('account/signin', ["message" => $message, "email" => $email]);
    }

    public function indexRegister(?string $message = null, array $userData = []): void
    {
        SessionController::forbidIFLoggedIn();
        $this->view->render('account/signup', ["message" => $message, "userData" => $userData]);
    }

    public function indexChangePassword(?string $message = null): void
    {
        SessionController::forbidIFLoggedOut();
        $this->view->render('account/changePassword', ["message" => $message]);
    }

    public function menage(): void
    {
        SessionController::forbidIFLoggedOut();
        $this->view->render('account/menage');
    }
}
