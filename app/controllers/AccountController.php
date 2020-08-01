<?php

class AccountController extends Controller
{
    private $user;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User;
        $this->session = SessionController::getInstance();
    }

    public function indexLogin($message = null, $email = null)
    {
        SessionController::forbidIFLoggedIn();
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

    public function login()
    {
        // $validation = $this->validateLogin();
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $validation = $this->user->validateLogin();

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
            ROUTER::redirect("home/index");
            exit;
        } else {
            $token = new Token;
            $token->create($user['id']);
            $this->session->setSession($user['id'], $user['username'], $user['email']);
            ROUTER::redirect("home/index");
            exit;
        }
    }

    public function logout()
    {
        SessionController::forbidIFLoggedOut();
        $this->session->destroySession();
        setcookie('remember', '', time() - 42000, '/');
        ROUTER::redirect("home/index");
    }

    public function register()
    {
        $validation = $this->user->validateRegistration();
        $userData = $this->user->formatData();

        if ($validation !== true) {
            $this->indexRegister($validation, $userData);
            exit;
        }

        $password = $_POST["password"];
        //Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $result = $this->user->create($userData["username"], $userData["email"], $passwordHash, $userData["city"], $userData["street"]);
        $id = $this->user->lastId();
        $this->session->setSession($id, $userData["username"], $userData["email"]);

        if ($result) {
            $this->view->render('home/index');
        }
    }

    public function delete()
    {
        $this->session->checkCsrfandLogin();
        $id = $_POST["id"];
        //gets the all user images stored on hard drive
        $imageModel = new Image;
        $imageModel->bulkDeleteImages($id);
        //deletes the user from the DB and deletes all his images
        $this->user->delete($id);
        $this->logout();
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

        $validation = $this->user->validateUpdatePassword($passwordOld, $realPassword);
        if ($validation) {
            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($passwordNew, PASSWORD_BCRYPT);
            $result = $this->user->update($passwordHash, $id);
        } else {
            $this->indexChangePassword("Your old password is incorrect");
            exit;
        }

        if ($result) {
            $this->logout();
        }

    }

}