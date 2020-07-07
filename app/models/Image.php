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

        $stmt->bindValue(':name', $imageName);
        $stmt->bindValue(':path', $imagePath);
        $stmt->bindValue(':user_id', $userId);

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
        image.name as imageName,
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
        try {

        $sql = "SELECT * FROM image";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();   
        return $count;

        } catch (\Throwable $th) {
            return $message = "No images found";
        }
        
     }

     public function bulkDeleteImages($id)
     {
        $sql = ("SELECT * from image WHERE user_id = :id");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $images = $stmt->fetchAll();
        foreach ($images as $image) {
        $dirPath = ROOT . DS  . str_replace("/",DS ,$image->path);
        unlink($dirPath);
        }
     }

     public function delete($imageId, $path)
     {
        $sql = ("DELETE from image WHERE id = :id");
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $imageId);
        $stmt->execute();
        unlink($path);

     }
}
