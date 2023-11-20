<?php

class AccountValidationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validateLogin()
    {
        if ($_POST['email'] == null) {
            $message = "You must enter email";
            return $message;
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format";
            return $message;
        }

        if ($_POST['password'] == null or strlen($_POST['password']) < 8) {
            $message = "Password must be at least 8 characters long";
            return $message;
        }

        return true;
    }

    public function validateRegistration()
    {

        if ($_POST["username"] == null) {
            $message = "You must enter username";
            return $message;
        }

        if ($_POST["email"] == null) {
            $message = "You must enter email";
            return $message;
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format";
            return $message;
        }

        if ($_POST["password"] == null) {
            $message = "You must enter password";
            return $message;
        }

        $passLenght = $_POST["password"];

        if (strlen($passLenght) < 8) {
            $message = "Password must be at least 8 characters long";
            return $message;
        }

        if ($_POST["password"] != $_POST["password2"]) {
            $message = "Your password doesnt match";
            return $message;
        }

        $email = $_POST["email"];

        $user = new User;
        if (!$user->checkEmail($email)) {
            $message = "Email already registered";
            return $message;
        }

        return true;
    }

    public function validateUpdatePassword($passwordOld, $realPassword)
    {

        if (password_verify($passwordOld, $realPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public function formatData()
    {
        return [
            "username" => trim(preg_replace('/\s+/', ' ', $_POST["username"])),
            "email" => $_POST["email"],
            "city" => trim(preg_replace('/\s+/', ' ', $_POST["city"])),
            "street" => trim(preg_replace('/\s+/', ' ', $_POST["street"])),
        ];
    }
}
