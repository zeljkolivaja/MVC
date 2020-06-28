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

        $user = $this->user->findWithEmail($email);

        $validation = $this->validateLogin($user);

        if ($validation !== "validated") {
            $this->indexLogin($validation);
            exit;
        }

        //If $validateLogin passes we proceed to login the user
        if (empty($_POST["rememberme"])) {
            $this->session->setSession($user['id'], $user['username'], $user['email']);
            ROUTER::redirect("home/index");
            exit;
        } else {
            $token = new TokenController;
            $token->create($user['id']);
            $this->session->setSession($user['id'], $user['username'], $user['email']);
            ROUTER::redirect("home/index");
            exit;
        }
    }

    public function logout($message = NULL)
    {
        if (!SessionController::loggedIn()) {
            die("Access denied");
        }

        $this->session->destroySession();

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
 
        $result = $this->user->create($username, $email, $passwordHash, $city, $street);
        $id = $this->user->lastId();

        $this->session->setSession($id, $username, $email);

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
        $this->user->delete($id);
        $this->logout();
    }

    public function updatePassword()
    {
        $passwordNew = $_POST["passwordNew"];
        $passwordNew2 = $_POST["passwordNew2"];
        $passwordOld = $_POST["passwordOld"];

        $id = $_SESSION["userid"];

        $user = $this->user->read($id);
        $realPassword = $user['password'];

        $this->checkPasswordMatch($passwordNew,$passwordNew2);
        $validation = $this->validateUpdatePassword($passwordOld,$realPassword);
    
        if ($validation) {
            //Hash the password as we do NOT want to store our passwords in plain text.
            $passwordHash = password_hash($passwordNew, PASSWORD_BCRYPT);
            $result = $this->user->update($passwordHash, $id);
            //If the signup process is successful.
            if ($result) {
                $message = "You have changed your password";
                $this->logout($message);
            }
        }
    }

    public function validateLogin($user)
    {
        
        if ($_POST['email']==null) {
            $message = "You must enter email";
            return $message;
            // die("You must enter username");
        }

        if ($_POST['password']==null) {
            $message = "You must enter password";
            return $message;
        }

        if ($user === false) {
            $message = "Could not find a user with that email adress!";
            return $message;
        }

        $validPassword = password_verify($_POST['password'], $user['password']);

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

        if (strlen($_POST["password"] < 8)) {
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

    public function validateUpdatePassword($passwordOld, $realPassword)
    {

        $validPassword = password_verify($passwordOld, $realPassword);
        if (!$validPassword) {
            $message = "Your old password is incorrect";
            $this->indexChangePassword($message);
            exit;
        }

        return true;
    }

    public function checkPasswordMatch($pass1, $pass2)
    {
        if ($pass1 != $pass2) {
            $message = "Your new password doesnt match";
            $this->indexChangePassword($message);
            exit;
        }
    }
}
