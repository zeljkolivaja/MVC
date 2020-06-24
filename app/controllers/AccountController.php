<?php

class AccountController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexLogin($message = NULL)
    {
        $this->view->render('account/signin', ["message" => $message]);
    }

    public function indexRegister($message = NULL)
    {
        $this->view->render('account/signup', ["message" => $message]);
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
        if (!SessionController::loggedIn()) {
            die("Access denied");
        }
        $this->view->render('account/menage');
    }

    public function login()
    {

        $email = $_POST["email"];
        $password = $_POST["password"];

        $userModel = new User;
        $user = $userModel->findWithEmail($email);

        $validation = $this->validateLogin($email, $password, $user);

        if ($validation !== "validated") {

            $this->indexLogin($validation);
            exit;
        }

        //If $validateLogin passes we proceed to login the user
        if (empty($_POST["rememberme"])) {

            $session = SessionController::getInstance();
            $session->setSession($user['id'], $user['username'], $user['email']);
            ROUTER::redirect("home/index");
            exit;
        } else {

            $token = new TokenController;
            $token->create($user['id']);
            $session = SessionController::getInstance();
            $session->setSession($user['id'], $user['username'], $user['email']);
            ROUTER::redirect("home/index");
            exit;
        }
    }

    public function logout($message = NULL)
    {

        if (!SessionController::loggedIn()) {
            die("Access denied");
        }

        $session = SessionController::getInstance();
        $session->destroySession();

        setcookie(
            'remember',
            '',
            time() - 42000,
            '/'
        );

        $this->indexLogin($message);
    }

    public function register()
    {
        // validate the input
        $validation = $this->validateRegistration();

        if ($validation !== "validated") {
            $this->indexRegister($validation);
            exit;
        }

        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $city = $_POST["city"];
        $street = $_POST["street"];

        //Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //Prepare our INSERT statement.
 
        $userModel = new User;
        $result = $userModel->create($username, $email, $passwordHash, $city, $street);
        $id = $userModel->lastId();

        $session = SessionController::getInstance();
        $session->setSession($id, $username, $email);

        if ($result) {
            $this->view->render('home/index');
        }
    }

    public function delete()
    {
        if (!SessionController::loggedIn()) {
            die("Access denied");
        }

        $id = $_POST["id"];
        //gets the all user images store on hard drive
        $imageModel = new Image;
        $imageModel->bulkDeleteImages($id);

        //deletes the user from the DB and deletes all his images 
        $userModel = new User;
        $userModel->delete($id);
        $this->logout();
    }

    public function updatePassword()
    {
        $passwordNew = $_POST["passwordNew"];
        $passwordNew2 = $_POST["passwordNew2"];
        $passwordOld = $_POST["passwordOld"];

        $id = $_SESSION["userid"];

        $userModel = new User;
        $user = $userModel->read($id);
        $realPassword = $user['password'];


        $validation = $this->validateUpdatePassword(
            $passwordNew,
            $passwordNew2,
            $passwordOld,
            $realPassword
        );


        if ($validation) {

            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($passwordNew, PASSWORD_BCRYPT);
            $result = $userModel->update($passwordHash, $id);

            //If the signup process is successful.
            if ($result) {
                $message = "You have changed your password";
                $this->logout($message);
            }
        }
    }

    public function validateLogin($email, $password, $user)
    {

        $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

        if ($email == null) {
            $message = "You must enter email";
            return $message;
            // die("You must enter username");
        }

        if ($password == null) {
            $message = "You must enter password";
            return $message;
        }


        if ($user === false) {
            $message = "Could not find a user with that email adress!";
            return $message;
        }

        $validPassword = password_verify($password, $user['password']);


        if (!$validPassword) {
            //$validPassword was FALSE. Passwords do not match.
            $message = "Password incorrect!";
            return $message;
        }

        return "validated";
    }

    public function validateRegistration()
    {

        if ($_POST["username"] === "") {
            $message = "You must enter username";
            return $message;
        }

        if ($_POST["email"] === "") {
            $message = "You must enter email";
            return $message;
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format";
            return $message;
        }

        if ($_POST["password"] === "") {
            $message = "You must enter password";
            return $message;
        }

        if ($_POST["password"] != $_POST["password2"]) {
            $message = "Your password doesnt match";
            return $message;
        }


        $email = $_POST["email"];
        $userModel = new User;

        if (!$userModel->checkEmail($email)) {
            $message = "Email already registered";
            return $message;
        }

        return "validated";
    }


    public function validateUpdatePassword($passwordNew, $passwordNew2, $passwordOld, $realPassword)
    {

        if ($passwordNew != $passwordNew2) {
            $message = "Your new password doesnt match";
            $this->indexChangePassword($message);
            exit;
        }


        $validPassword = password_verify($passwordOld, $realPassword);
        if (!$validPassword) {
            $message = "Your old password is incorrect";
            $this->indexChangePassword($message);
            exit;
        }

        return true;
    }


}
