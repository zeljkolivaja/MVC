<?php

class LoginController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }


    public function indexAction()
    {

        $this->view->render('login/index');
    }

 

    public function signinAction()
    {

        $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

        $this->validate($username, $passwordAttempt);

 
        //instantiate the user model, check does the user exist, save it in $user
        $userModel = new User;
        $user= $userModel->read($username, $passwordAttempt);

     

        //If $row is FALSE.
        if ($user === false) {
            //Could not find a user with that username!
            //PS: You might want to handle this error in a more user-friendly manner!
            die('Incorrect username!');
        }

 
        if ($user) {
            //User account found. Check to see if the given password matches the
            //password hash that we stored in our users table.
            //Compare the passwords.
            $validPassword = password_verify($passwordAttempt, $user['password']);


            if (!$validPassword) {
                //$validPassword was FALSE. Passwords do not match.
                die('Incorrect username / password combination!');
            }


            //If $validPassword is TRUE, the login has been successful.
            if (empty($_POST["rememberme"])) {

                //Provide the user with a login session.

                $session = SessionController::getInstance();
                $session->setSession($user['id'], $user['username'], $user['email']);

                //Redirect to our protected page, which we called home.php
                $this->view->render('home/index');
                exit;

            } else {
                $this->generateLoginToken($user['id']);
                $session = SessionController::getInstance();
                $session->setSession($user['id'], $user['username'], $user['email']);

                //Redirect to our protected page, which we called home.php
                $this->view->render('home/index');

                exit;
            }
        }
    }


    public static function generateLoginToken($userId)
    {


        $selector = base64_encode(random_bytes(9));
        $authenticator = random_bytes(33);


        $token = hash('sha256', $authenticator);

        $userModel = new User;
        $userModel->createToken($selector,$token,$userId);
        
    
        setcookie(
            'remember',
            $selector . ':' . base64_encode($authenticator),
            time() + 864000,
            '/'
            // false,
            // true // TLS-only
        );
    }


    // https://stackoverflow.com/questions/3128985/php-login-system-remember-me-persistent-cookie

    public function logoutAction()
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


    public function validate($username, $passwordAttempt)
    {


        if ($username == null) {
            die("You must enter username");
        }

        if ($passwordAttempt == null) {
            die("You must enter password");
        }

        // if ($_POST["email"] === "") {
        //     die("You must enter email");
        // }

        // if ($_POST["password"] === "") {
        //     die("You must enter password");
        // }

        // if ($_POST["password"] != $_POST["password2"]) {
        //     die("Your password doesnt match");
        // }

        //napraviti provjeru da li vec postoji username ili email 


        // $email = $_POST["email"];

        // $db = DB::getInstance();
        // $sql = "SELECT COUNT(email) AS num FROM user WHERE email = :email";
        // $stmt = $db->prepare($sql);

        // //Bind the provided username to our prepared statement.
        // $stmt->bindValue(':email', $email);

        // //Execute.
        // $stmt->execute();

        // //Fetch the row.
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // //If the provided username already exists - display error.
        // //TO ADD - Your own method of handling this error. For example purposes,
        // //I'm just going to kill the script completely, as error handling is outside
        // //the scope of this tutorial.
        // if ($row['num'] > 0) {
        //     die('That email already exists!');
        // }


        return true;
    }
}
