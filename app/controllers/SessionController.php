<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;

class SessionController extends Controller
{

    private static $_instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): static
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }

    public static function generateCSRF(): void
    {
        $_SESSION['csrf'] = base64_encode(openssl_random_pseudo_bytes(32));
    }

    public function setSession(int $id, string $username, string $email): void
    {
        $_SESSION["username"] = $username;
        $_SESSION['userid'] = $id;
        $_SESSION['email'] = $email;
    }

    public function checkCsrf(string $csrf): bool
    {
        if ($_SESSION["csrf"] != $csrf) {
            return false;
        }
        return true;
    }

    public function destroySession(): void
    {
        session_destroy();
    }

    public static function loggedIn(): bool
    {
        if (!empty($_SESSION['userid'])) {
            return true;
        }
        return false;
    }

    public static function forbidIFLoggedOut(): void
    {
        if (!self::loggedIn()) {
            $error = new ErrorController;
            $error->forbidden();
        }
    }

    public static function forbidIFLoggedIn(): void
    {
        if (SessionController::loggedIn()) {
            \Core\ROUTER::redirect("home/index");
        }
    }

    public function checkCsrfandLogin(): void
    {
        if (
            self::loggedIn() == false or
            $_POST["csrf"] == null or
            $this->checkCsrf($_POST["csrf"]) == false
        ) {
            $error = new ErrorController;
            $error->forbidden();
        }
    }
}
