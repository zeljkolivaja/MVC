<?php

class ImageController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        
        if (!SessionController::loggedIn()) {
            die("Access denied");
        }

    }


    public function index()
    {
        //  if (!SessionController::loggedIn()) {
        //    die("You are not logged in");
        // }
        $ImageModel = new Image;
        $images = $ImageModel->read();

        $this->view->render('image/index', ["images" => $images]);
    }


    public function insert()
    {
        //validacija
        // jos image name odvalidirati treba !!!!
        $imageName = $_POST["name"];

        $this->imageValidation($_FILES["image"]);

        $fileName = $_FILES["image"]["name"];
        $fileTmpName = $_FILES["image"]["tmp_name"];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestination = IMAGEDIR . $fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);



        $path = "public/images/" . $fileNameNew;

        $ImageModel = new Image;
        $ImageModel->insert($path, $imageName);

        ROUTER::redirect("home/index");
    }


    public function delete()
    {
        if (!SessionController::loggedIn()) {
            die("Access denied");
        }


        $ImageId = $_POST["imageId"];
        $imageOwnerId = $_POST["imageOwnerId"];
        $path = $_POST["path"];
        
        $dirPath = WEB_ROOT . str_replace("/","\\" ,$path);
        

        if ($_SESSION["userid"] == $imageOwnerId) {
            $imageModel = new Image;
            $imageModel->delete($ImageId, $dirPath);
        }

        ROUTER::redirect("image");

    }


    public function imageValidation($file)
    {
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];


        $size = getimagesize($fileTmpName);
        if (!$size) {
            die("file type error");
        }

        $valid_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if (!in_array($size[2],  $valid_types)) {
            die("Image must be JPEG or PNG");
        }

        if ($fileError != 0) {
            die("error uploading file");
        }

        if ($fileSize > 5097152) {
            die("file to big");
        }
    }
}
