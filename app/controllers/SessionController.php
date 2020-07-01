<?php

class SessionController extends Controller
{


    // I like this approach. The only thing I did differently was, rather than relying solely on 
    // $_SESSION['userid'], I also set a $_SESSION['selector'] to check against auth_tokens. 
    // This way I'm able to invalidate any active sessions (e.g. in the case of a password reset) 
    // without having to wait for the PHP session to expire. 


    private static $_instance = null;

    private function __construct()
    {
        # code...
    }


    public static function getInstance()
    {

        if (!isset(self::$_instance)) {
            self::$_instance = new SessionController();
        }
        return self::$_instance;
    }

    public function setSession($id, $username, $email, $csrf)
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
