<html>
<body background="#FFFFFF">
<style>
<h1>Defined: {DIMENSION}</h1>

h1 {
	color: white;
	text-align: left;
	background: #ff6f00;
}
h4 {
	color: white;
	text-align: right;

	background: #000000;
}
p {
	text-align: center;
}
.info {
	text-align: center;
}
</style>
<h1>The $400 homepage</h1>
<p>
<?php
require_once('sql_conn.php');
require_once('defines.php');

$query = 'select * from Pixels';

$dir = "./images";

$response = @mysqli_query($dbc, $query);

if ($response) {
	if(! $opendir = opendir($dir)) {
		echo "opendir error<br>";
	}
	while ($row = mysqli_fetch_array($response)) {
		// if($row['id'] % DIMENSION == 0) {
		// 	echo "<br>\n";
		// }

		$id = "id".$row['id'];
		echo "<style>\n";
        echo "\t#".$id."\n";
        echo "\t{\n";
        echo "\t\tposition: absolute;\n";
        echo "\t\tleft: ".$row['posx']."px;\n";
        echo "\t\ttop:  ".$row['posy']."px;\n";
        echo "\t}\n";
        echo "\t#".$id." img { width: ".$row['width']."px; height: ".$row['height']."px; }\n";
    	echo "</style>\n";
		echo "\t<div id=\"".$id."\" ><img src=".$row['image_path']."> </div>\n";
		// echo "\t<img src=".$row['image_path'].">\n";

	}
}
else {
	echo "Couldn't issue database query";
	echo mysqli_error($dbc);
}
mysqli_close($dbc);
?>
</p>
</body>
</html>
