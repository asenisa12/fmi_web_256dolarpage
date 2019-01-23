<head>
<body>
<style>
li {
    color: red;
}
</style>
<?php
require_once('sql_conn.php');

$website_link = $_POST['website_link'];
$title = $_POST['title'];

$target_dir = "./uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$query = "update Pixels set image_path = '$target_file', link = '$website_link',
               title = '$title' where id = ".$_GET['id'].";";

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        #echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<li>File is not an image.</li><br>";
        $uploadOk = 0;
    }
}
// Check if website link is empty
if ($website_link == '') {
    echo "<li>Empty website links are not allowed. Please return and try again.</li><br>";
    $uploadOk = 0;
}

if ($_GET['id'] >= 2500) {
    echo "<li>Wrong id provided. Please do not manually edit the URL.</li><br>";
    $uploadOk = 0;
}

// Check if title is empty
if ($title == '') {
    echo "<li>Empty titles are not allowed. Please return and try again.</li><br>";
    $uploadOk = 0;
}

// // Check if file already exists
// if (file_exists($target_file)) {
//     echo "<li style='color:red;'>Sorry, file already exists.</li><br>";
//     $uploadOk = 0;
// }
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<li style='color:red;'>Sorry, your file is too large.</li><br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<li>Sorry, only JPG, JPEG, PNG & GIF files array_key_exists(key, array) allowed.</li><br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    echo "<br>".$target_file."<br>";
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "<li style='color:red;'>Sorry, there was an error uploading your file.</li><br>";
    }
}

if($uploadOk == 1) {
    $response = @mysqli_query($dbc, $query);
    if ($response) {
        echo "Database updated successfully<br>";
        header("Location: index.php");
    }
    else {
        echo "<li>Couldn't issue database query</li><br>";
        echo mysqli_error($dbc);
    }
    mysqli_close($dbc);
}
else {
echo "<form method=\"get\" action=\"index.php\">
        <button type=\"submit\">< Go back</button>
      </form>";
}
?>
</body>
</head>