<?php

class Crop
{
    public $top=0;
    public $left=0;
    public $right=0;
    public $bottom=0;
};


$target_dir = "/opt/lampp/htdocs/project/uploads/";




$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        require_once('sql_conn.php');
        require_once('defines.php');


        $id_count = intval($_GET["length"]);

        $img_ids  = explode(",", $_GET["id"]);

        for ($i=0; $i<$id_count; $i++)
        {

            $query =   "update ".TABLE_NAME;
            $query .= " set image_path='http://localhost/project/uploads/".$_FILES["fileToUpload"]["name"]."'";
            echo "icence ".$img_ids[$i]."\n";
            $query .= " where id=".$img_ids[$i];
            $response = @mysqli_query($dbc, $query);
            if(!$response)
            {
                echo "error in query ".$query;
            }

        }

        $dir = "./images";

        $response = @mysqli_query($dbc, $query);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>