<! DOCTYPE html>
<html>
<body>
<style>
h1 {
	color: white;
	text-align: center;
	background: #ff6f00;
}
</style>
<h1>Advertisement data form</h1>
<form action="upload.php?id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">
	<fieldset style='width: 30%; height: 160'>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<br><br>
		Website link: <input type="text" name="website_link" id="website_link" required>
		<br><br>
		Title: <input type="text" name="title" id="title" required>
		<br><br>
		<input type="submit" value="Upload Image" name="submit">
		<br><br>
	</fieldset>
</form>
<form method="get" action="index.php">
	<button type="submit">< Go back</button>
</form>
</body>