<?php

class AccountController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexLogin()
    {
        $this->view->render('account/signin');
    }

    public function indexRegister()
    {
        $this->view->render('account/signup');
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

        extract($_POST);
        //instantiate the user model, check does the user exist, save it in $user
        $userModel = new User;
        $user = $userModel->read($username);
        $this->validateLogin($username, $password, $user);

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
        $this->validateRegistration();
        extract($_POST);

        //Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //Prepare our INSERT statement.
        //Remember: We are inserting a new row into our users table.

        $userModel = new User;
 
        $result = $userModel->create($username, $email, $passwordHash);
        $id = $userModel->lastId();

        $session = SessionController::getInstance();
        $session->setSession($id, $username, $email);

        //If the signup process is successful.
        if ($result) {
            //What you do here is up to you!
            $this->view->render('home/index');
        }
    }

    public function updatePassword()
    {
        // validate the input
        // $this->validateRegistration();
        extract($_POST);

        if ($passwordNew != $passwordNew2) {
            die("New password doesnt match");
        }

        $username = $_SESSION["username"];

        $userModel = new User;
 
        $user = $userModel->read($username);

        $validPassword = password_verify($passwordOld, $user['password']);

        if ($validPassword) {

            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($passwordNew, PASSWORD_BCRYPT);
            $result = $userModel->update($passwordHash, $username);

            //If the signup process is successful.
            if ($result) {
                //What you do here is up to you!
                $this->logout();
                // $message = "You have successfully changed your password";
                ROUTER::redirect("home/index");
            }
        }
    }

    public function validateLogin($username, $password, $user)
    {

        $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

        if ($username == null) {
            die("You must enter username");
        }

        if ($password == null) {
            die("You must enter password");
        }

        // var_dump($user);
        // die();

        if ($user === false) {
            //Could not find a user with that username!
            //PS: You might want to handle this error in a more user-friendly manner!
            die('Incorrect username!');
        }

        $validPassword = password_verify($password, $user['password']);


        if (!$validPassword) {
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }

        return true;
    }

    public function validateRegistration()
    {

        if ($_POST["username"] === "") {
            die("You must enter username");
        }

        if ($_POST["email"] === "") {
            die("You must enter email");
        }

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format");
        }

        if ($_POST["password"] === "") {
            die("You must enter password");
        }

        if ($_POST["password"] != $_POST["password2"]) {
            die("Your password doesnt match");
        }

        //napraviti provjeru da li vec postoji username ili email 

        $email = $_POST["email"];
        $userModel = new User;
 
        $userModel->checkEmail($email);


        return true;
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
