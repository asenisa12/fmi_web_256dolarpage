<!DOCTYPE html>
<html>
<body>

<form action="upload.php?length=<?php echo $_GET['length'];?>&id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>