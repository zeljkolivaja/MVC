<?php

class Image extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($imagePath, $imageName)
    {
        $userId = $_SESSION['userid'];

        $sql = "INSERT INTO image (name, path, user_id) VALUES (:name, :path, :user_id)";
        $stmt = $this->db->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':name', $imageName);
        $stmt->bindValue(':path', $imagePath);
        $stmt->bindValue(':user_id', $userId);

        //Execute the statement and insert the new pciture.
        return $stmt->execute();
    }

    public function read()
    {
        $sql = ("SELECT user.id, 
        user.username, 
        user.email,
        user.city,
        user.street,
        image.id as imageId, 
        image.name,
        image.path, 
        image.user_id as imageUserId
        FROM user 
        INNER JOIN image
        ON user.id = image.user_id");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalImages()
    {
        $sql = "SELECT * FROM image";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $count = $stmt->rowCount();
         
        return $count;
     }

     public function delete($imageId, $path)
     {
        $sql = ("DELETE from image WHERE id = :id");
        $stmt = $this->db->prepare($sql);

        //Bind our variables.
        $stmt->bindValue(':id', $imageId);
        $stmt->execute();
        unlink($path);

     }
}
