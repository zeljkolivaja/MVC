<?php

class User extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($username, $email, $passwordHash, $city, $street)
    {
        $sql = "INSERT INTO user (username, email, password, city, street) VALUES (:username, :email, :password, :city, :street)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $passwordHash);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':street', $street);

        return $stmt->execute();
    }

    public function update($passwordHash, $id)
    {
        $sql = "UPDATE user SET password=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$passwordHash, $id]);
    }

    public function delete($id)
    {
        $sql = ("DELETE FROM user WHERE id = :id");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function lastId()
    {
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function read($id)
    {
        $sql = "SELECT username, email, password FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findWithEmail($email)
    {
        $sql = "SELECT id, username, password FROM user WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkEmail($email)
    {
        $sql = "SELECT COUNT(email) AS num FROM user WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['num'] > 0) {
            return false;
        }

        return "true";
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

        if (!$this->checkEmail($email)) {
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