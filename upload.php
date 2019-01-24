<?php
require_once('sql_conn.php');
require_once('defines.php');
class Crop
{
    public $top=0;
    public $right=0;
    public $bottom=0;
    public $left=0;
    public $id="";

    public function __construct($t, $r, $b, $l, $i) {
        $this->top=strval($t);
        $this->right=strval($r);
        $this->bottom=strval($b);
        $this->left=strval($l);
        $this->id=strval($i);

    }
};


$target_dir = "/opt/lampp/htdocs/project/uploads/";
$id_count = intval($_GET["length"]);
$img_ids  = explode(",", $_GET["id"]);
sort($img_ids);
$row_size = 1;
$col_size = 1;
$crops = array(); 
if($id_count>0)
{
    $prev_id = intval($img_ids[0]);
    $x=0;
    $y=0;
    for ($i=0; $i<$id_count; $i++)
    {
        $cur_id = intval($img_ids[$i]);
        if($cur_id > $prev_id+1)
        {
            $x=0;
            $y++;
        }
        $crop = new Crop($y*SIZE,($x+1)*SIZE, ($y+1)*SIZE, $x*SIZE, $img_ids[$i]);
        array_push($crops, $crop);
        $x++;
        $prev_id = intval($img_ids[$i]);
    }
    $col_size = $y+1;
    $row_size = $x;
}



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

        $new_x = 0;
        $new_y = 0;
        if($id_count>0)
        {
            $posx=@mysqli_query($dbc,"select posx from Pixels where id=".$img_ids[0]);
            $posy=@mysqli_query($dbc,"select posy from Pixels where id=".$img_ids[0]);

            if (mysqli_num_rows($posx) > 0) {
                while($row = mysqli_fetch_assoc($posx)) {
                    $new_x = $row["posx"];
                }
            }
            if (mysqli_num_rows($posy) > 0) {
                while($row = mysqli_fetch_assoc($posy)) {
                    $new_y = $row["posy"];
                }
            }

        }
        //Pixels(id int primary key, link varchar(255), image_path varchar(255), width int, height int, posx int, posy int, top int, righ int, bottom int, lef int);
        for ($i=0; $i<$id_count; $i++)
        {

            $query =   "update ".TABLE_NAME;
            $query .= " set image_path='http://localhost/project/uploads/".$_FILES["fileToUpload"]["name"]."',";
            $query .= " link='".$_POST['website_link']."',";
            $query .= " width=".strval($row_size*SIZE).",";
            $query .= " height=".strval($col_size*SIZE).",";
            $query .= " top=".$crops[$i]->top.",";
            $query .= " righ=".$crops[$i]->right.",";
            $query .= " bottom=".$crops[$i]->bottom.",";
            $query .= " lef=".$crops[$i]->left.",";
            $query .= " posx=".$new_x.",";
            $query .= " posy=".$new_y."";
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

mysqli_close($dbc);
header("Location: http://localhost/project/index.php");
?>