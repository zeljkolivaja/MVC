<?php

namespace App\Models;

class Image extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($webPath, $imageName, $filePath)
    {
        $userId = $_SESSION['userid'];

        $sql = "INSERT INTO image (name, path, user_id, file_path) VALUES (:name, :path, :user_id, :file_path)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':name', $imageName);
        $stmt->bindValue(':path', $webPath);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':file_path', $filePath);

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
        image.user_id as imageUserId,
        image.file_path as dirPath
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

    public function saveImage($imageName)
    {

        $fileName = $_FILES["image"]["name"];
        $fileTmpName = $_FILES["image"]["tmp_name"];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestination = IMAGEDIR . $fileNameNew;
        //store images to hard drive
        move_uploaded_file($fileTmpName, $fileDestination);


        if (ENV === "localhost") {
            $webPath = PROOT . 'images/' . $fileNameNew;
        } else {
            $webPath = "images/" . $fileNameNew;
        }
        //insert image into database
        $this->insert($webPath, $imageName, $fileDestination);
    }

    public function deleteImage()
    {
        $ImageId = $_POST["imageId"];
        $imageOwnerId = $_POST["imageOwnerId"];
        $dirPath = $_POST["dirPath"];

        if ($_SESSION["userid"] == $imageOwnerId) {
            $this->delete($ImageId, $dirPath);
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
            $path = "public/" . $image->path;
            $dirPath = ROOT . DS . str_replace("/", DS, $path);
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

    public function imageValidation($file)
    {
        $imageName = $_POST["name"];

        if ($imageName == null) {
            $message = "You must enter image name";
            return $message;
        }

        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];

        $size = getimagesize($fileTmpName);

        if (!$size) {
            $message = "File type error";
            return $message;
        }

        $valid_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if (!in_array($size[2], $valid_types)) {
            $message = "Image must be JPEG or PNG";
            return $message;
        }

        if ($fileError != 0) {
            $message = "Error uploading file";
            return $message;
        }

        if ($fileSize > 5000000) {
            $message = "file to big";
            return $message;
        }

        return true;
    }
}
