<?php

class SessionController extends Controller
{

    private static $_instance = null;

    private function __construct()
    {
      
    }


    public static function getInstance()
    {

        if (!isset(self::$_instance)) {
            self::$_instance = new SessionController();
        }
        return self::$_instance;
    }

    public function setSession($id, $username, $email, $csrf="")
    {
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
}
