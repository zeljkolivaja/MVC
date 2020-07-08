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

    public function indexLogin($message = NULL, $email = NULL)
    {

        SessionController::forbidIFLoggedIn();
        $this->view->render('account/signin', ["message" => $message , "email" => $email]);
    }

    public function indexRegister($message = NULL, $userData = [])
    {

        SessionController::forbidIFLoggedIn();
        $this->view->render('account/signup', ["message" => $message, "userData" => $userData]);
    }

    public function indexChangePassword($message = NULL)
    {
        if (!SessionController::loggedIn()) {
            die("Access denied");
        }

        $this->view->render('account/changePassword', ["message" => $message]);
    }


    public function menage()
    {
        SessionController::forbidIFLoggedOut();
        $this->view->render('account/menage');
    }

    public function login()
    {

        $validation = $this->validateLogin();
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);


        if ($validation !== "validated") {
            $this->indexLogin($validation, $email);
            exit;
        }

         $user = $this->user->findWithEmail($email);

        if ($user === false) {
            $message = "Could not find a user with that email adress!";
            $this->indexLogin($message,$email);
            exit;
        }

        $validPassword = password_verify($_POST['password'], $user['password']);

        if (!$validPassword) {
            //$validPassword was FALSE. Passwords do not match.
            $message = "Password incorrect!";
            $this->indexLogin($message,$email);
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

        setcookie(
            'remember',
            '',
            time() - 42000,
            '/'
        );

        // $this->indexLogin($message);
        ROUTER::redirect("home/index");
    }

    public function register()
    {

        $validation = $this->validateRegistration();

        $userData =  [
            "username" => trim( preg_replace('/\s+/', ' ', $_POST["username"])),
            "email" => $_POST["email"],
            "city" => trim( preg_replace('/\s+/', ' ', $_POST["city"])),
            "street"=> trim( preg_replace('/\s+/', ' ', $_POST["street"]))
        ];

        if ($validation !== "validated") {
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
        $this->checkCsrfandLogin();
        $id = $_POST["id"];
        //gets the all user images store on hard drive
        $imageModel = new Image;
        $imageModel->bulkDeleteImages($id);

        //deletes the user from the DB and deletes all his images 
        $this->user->delete($id);
        $this->logout();
    }

    public function updatePassword()
    {
        $this->checkCsrfandLogin();

        $passwordNew = $_POST["passwordNew"];
        $passwordNew2 = $_POST["passwordNew2"];
        $passwordOld = $_POST["passwordOld"];

        $id = $_SESSION["userid"];

        $user = $this->user->read($id);
        $realPassword = $user['password'];

        $this->checkPasswordMatch($passwordNew, $passwordNew2);
        $validation = $this->validateUpdatePassword($passwordOld, $realPassword);

        if ($validation) {
            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($passwordNew, PASSWORD_BCRYPT);
            $result = $this->user->update($passwordHash, $id);
            //If the signup process is successful.
            if ($result) {
                $this->logout();
            }
        }
    }

    private function validateLogin()
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

        return "validated";
    }

    private function validateRegistration()
    {

        if ($_POST["username"] == NULL) {
            $message = "You must enter username";
            return $message;
        }

        if ($_POST["email"] == NULL) {
            $message = "You must enter email";
            return $message;
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format";
            return $message;
        }

        if ($_POST["password"] == NULL) {
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


        if (!$this->user->checkEmail($email)) {
            $message = "Email already registered";
            return $message;
        }

        return "validated";
    }

    private function validateUpdatePassword($passwordOld, $realPassword)
    {

        $validPassword = password_verify($passwordOld, $realPassword);
        if (!$validPassword) {
            $message = "Your old password is incorrect";
            $this->indexChangePassword($message);
            exit;
        }

        return true;
    }

    private function checkPasswordMatch($pass1, $pass2)
    {
        if ($pass1 != $pass2) {
            $message = "Your new password doesnt match";
            $this->indexChangePassword($message);
            exit;
        }
    }

    private function checkCsrfandLogin()
    {
        if (
            !SessionController::loggedIn() or
            !isset($_POST["csrf"]) or
            !$this->session->checkCsrf($_POST["csrf"])
        ) {
            die("Access denied");
            exit;
        }
    }

}
