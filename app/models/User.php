<?php

class User extends Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function create($username, $email, $passwordHash)
    {
        $sql = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $passwordHash);

        //Execute the statement and insert the new account.
        return $stmt->execute();
    }


    public function update($passwordHash, $username)
    {
        $sql = "UPDATE user SET password=? WHERE username=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$passwordHash, $username]);
    }


    public function lastId()
    {
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function read($username)
    {

 
        //Retrieve the user account information for the given username.
        $sql = "SELECT id, username, email, password FROM user WHERE username = :username";
        $stmt = $this->db->prepare($sql);

        //Bind value.
        $stmt->bindValue(':username', $username);

        //Execute.
        $stmt->execute();

        //Fetch row.
         return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkEmail($email)
    {
        $db = DB::getInstance();
        $sql = "SELECT COUNT(email) AS num FROM user WHERE email = :email";
        $stmt = $db->prepare($sql);

        //Bind the provided username to our prepared statement.
        $stmt->bindValue(':email', $email);

        //Execute.
        $stmt->execute();

        //Fetch the row.
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['num'] > 0) {
            die('That email already exists!');
        }
    }

}