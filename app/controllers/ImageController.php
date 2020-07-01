<?php

class ImageController extends Controller
{
    private $image;
    private $session;


    public function __construct()
    {
        parent::__construct();

        if (!SessionController::loggedIn()) {
            die("Access denied");
        }
        $this->session = SessionController::getInstance();

        $this->image = new Image;
    }

    public function index($message = NULL)
    {

        $images = $this->image->read();

        $this->view->render('image/index', ["images" => $images, "message" => $message]);
    }

    public function insert()
    {
        $this->checkCSRF();

        $imageName = $_POST["name"];
        $this->imageValidation($_FILES["image"]);

        $fileName = $_FILES["image"]["name"];
        $fileTmpName = $_FILES["image"]["tmp_name"];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestination = IMAGEDIR . $fileNameNew;
        //store images to hard drive
        move_uploaded_file($fileTmpName, $fileDestination);

        $path = "public/images/" . $fileNameNew;

        //insert image into database
        $this->image->insert($path, $imageName);

        ROUTER::redirect("image");
    }

   
    public function delete()
    {

        $this->checkCSRF();

        $ImageId = $_POST["imageId"];
        $imageOwnerId = $_POST["imageOwnerId"];
        $path = $_POST["path"];

        $dirPath = ROOT . DS . str_replace("/", DS, $path);

        if ($_SESSION["userid"] == $imageOwnerId) {
            $this->image->delete($ImageId, $dirPath);
        }

        ROUTER::redirect("image");
    }


    private function imageValidation($file)
    {
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];

        $size = getimagesize($fileTmpName);
        if (!$size) {

            $message = "File type error";
            $this->index($message);
            exit;
        }

        $valid_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if (!in_array($size[2],  $valid_types)) {
            $message = "Image must be JPEG or PNG";
            $this->index($message);
            exit;
        }

        if ($fileError != 0) {
            $message = "Error uploading file";
            $this->index($message);
            exit;
        }

        if ($fileSize > 5097152) {
            $message = "file to big";
            $this->index($message);
            exit;
        }
    }

    private function checkCSRF()
    {
        if (!isset($_POST["csrf"]) or !$this->session->checkCsrf($_POST["csrf"])) {
            die("Access denied");
            exit;
        }
    }

}
