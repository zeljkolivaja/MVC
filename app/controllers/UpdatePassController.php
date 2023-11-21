<?php

class UpdatePassController extends AccountController
{

    private $logout;

    public function __construct()
    {
        parent::__construct();
        $this->logout = new LogoutController;
    }

    public function updatePassword()
    {

        $this->session->checkCsrfandLogin();
        $passwordNew = $_POST["passwordNew"];
        $passwordNew2 = $_POST["passwordNew2"];
        $passwordOld = $_POST["passwordOld"];
        $id = $_SESSION["userid"];
        $user = $this->user->read($id);
        $realPassword = $user['password'];

        if ($passwordNew != $passwordNew2) {
            $this->indexChangePassword("Your new password does not match");
            exit;
        }

        $validation = $validation = $this->validateUser->validateUpdatePassword($passwordOld, $realPassword);
        if ($validation) {
            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($passwordNew, PASSWORD_BCRYPT);
            $result = $this->user->update($passwordHash, $id);
        } else {
            $this->indexChangePassword("Your old password is incorrect");
            exit;
        }

        if ($result) {
            $this->logout->logout();
        }
    }
}
