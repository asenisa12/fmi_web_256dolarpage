<! DOCTYPE html>
<html>
<style>
h1 {
	color: #003333;
	text-align: left;
}

.button {
  background-color: #003333;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

</style>
<h1>Advertisement data form</h1>
<body style="background-color:powderblue;">
<form action="upload.php?length=<?php echo $_GET['length'];?>&id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">
	<fieldset style='width: 30%; text-align: center; height: 160'>
		<input  type="file" name="fileToUpload" id="fileToUpload">
		<br><br>
		Website link: <input type="text" name="website_link" id="website_link" required>
		<br><br>
		<input class="button" type="submit" value="Upload Image" name="submit">
		<br><br>
	</fieldset>
</form>
</body>

</html>