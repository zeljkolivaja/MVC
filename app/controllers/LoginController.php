<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Token;

class LoginController extends AccountController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login(): void
    {
        $this->session->checkCsrf($_POST["csrf"]);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $validation = $this->validateUser->validateLogin();

        if ($validation !== true) {
            $this->indexLogin($validation, $email);
            exit;
        }

        $user = $this->user->findWithEmail($email);

        if ($user === false) {
            $message = "Could not find a user with that email adress!";
            $this->indexLogin($message, $email);
            exit;
        }

        $validPassword = password_verify($_POST['password'], $user['password']);

        if (!$validPassword) {
            //$validPassword was FALSE. Passwords do not match.
            $message = "Password incorrect!";
            $this->indexLogin($message, $email);
            exit;
        }

        //we proceed to login the user
        if (empty($_POST["rememberme"])) {
            $this->session->setSession($user['id'], $user['username'], $email);
            \Core\ROUTER::redirect("home/index");
            exit;
        } else {
            $token = new Token;
            $token->create($user['id']);
            $this->session->setSession($user['id'], $user['username'], $email);
            \Core\ROUTER::redirect("home/index");
            exit;
        }
    }
}
