<?php

class AccountController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexLogin($message = "")
    {
        $this->view->render('account/signin', ["message" => $message]);
    }

    public function indexRegister($message = "")
    {
        $this->view->render('account/signup', ["message" => $message]);
    }

    public function indexChangePassword()
    {
        $this->view->render('account/changePassword');
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

        //instantiate the user model, check does the user exist, save it in $user
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
        //Remember: We are inserting a new row into our users table.

        $userModel = new User;

        $result = $userModel->create($username, $email, $passwordHash, $city, $street);
        $id = $userModel->lastId();

        $session = SessionController::getInstance();
        $session->setSession($id, $username, $email);

        //If the signup process is successful.
        if ($result) {
            //What you do here is up to you!
            $this->view->render('home/index');
        }
    }

    public function delete()
    {

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
        // validate the input
        // $this->validateRegistration();
        extract($_POST);

        if ($passwordNew != $passwordNew2) {
            die("New password doesnt match");
        }

        $id = $_SESSION["userid"];

        $userModel = new User;

        $user = $userModel->read($id);

        $validPassword = password_verify($passwordOld, $user['password']);

        if ($validPassword) {

            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($passwordNew, PASSWORD_BCRYPT);
            $result = $userModel->update($passwordHash, $id);

            //If the signup process is successful.
            if ($result) {
                //What you do here is up to you!
                $this->logout();
                // $message = "You have successfully changed your password";
                ROUTER::redirect("home/index");
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

    public function logout()
    {

        $session = SessionController::getInstance();
        $session->destroySession();

        setcookie(
            'remember',
            '',
            time() - 42000,
            '/'
        );

        $this->view->render('home/index');
    }
}
