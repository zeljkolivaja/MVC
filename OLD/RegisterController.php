<?php

class RegisterController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }


    public function index()
    {
      
        

        $this->view->render('registration/index');
    }

    public function signup()
    {
        // validate the input
        $this->validate();
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


    public function validate()
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

      
          

        $db = DB::getInstance();
        $sql = "SELECT COUNT(email) AS num FROM user WHERE email = :email";
        $stmt = $db->prepare($sql);

        //Bind the provided username to our prepared statement.
        $stmt->bindValue(':email', $email);

        //Execute.
        $stmt->execute();

        //Fetch the row.
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //If the provided username already exists - display error.
        //TO ADD - Your own method of handling this error. For example purposes,
        //I'm just going to kill the script completely, as error handling is outside
        //the scope of this tutorial.
        if ($row['num'] > 0) {
            die('That email already exists!');
        }


        return true;
    }
}
