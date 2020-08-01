<?php

class SessionController extends Controller
{

    private static $_instance = null;

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new SessionController();
        }
        return self::$_instance;
    }

    public function setSession($id, $username, $email)
    {
        $csrf = base64_encode(openssl_random_pseudo_bytes(32));

        $_SESSION["username"] = $username;
        $_SESSION['userid'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['csrf'] = $csrf;
    }

    public function checkCsrf($csrf)
    {
        if ($_SESSION["csrf"] != $csrf) {
            return false;
        }
        return true;
    }

    public function destroySession()
    {
        session_destroy();
    }

    public static function loggedIn()
    {
        if (!empty($_SESSION['userid'])) {
            return true;
        }
        return false;
    }

    public static function forbidIFLoggedOut()
    {
        if (!self::loggedIn()) {
            $error = new ErrorController;
            $error->forbidden();
        }
    }

    public static function forbidIFLoggedIn()
    {
        if (SessionController::loggedIn()) {
            ROUTER::redirect("home/index");
        }
    }

    public function checkCsrfandLogin()
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