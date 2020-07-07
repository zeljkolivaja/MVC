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
}
