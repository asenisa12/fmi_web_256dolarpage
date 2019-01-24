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


<script type="text/javascript">
	pixel_ids = []; 
	function pixel_click(clicked_id)
	{
		var childs = document.getElementById(clicked_id).children;
		for (i = 0; i < childs.length; i++) {
			childs[i].style.width = "97px";
            childs[i].style.height = "97px";
			childs[i].style.border='2px solid #E8272C';
		}
		pixel_ids.push(clicked_id);

	}

	function openInNewTab() 
	{
		var url = "http://localhost/project/input_form.php?length="+pixel_ids.length.toString();
		url+="&id="
		for(var i=0; i<pixel_ids.length; i++)
		{
			url+=pixel_ids[i].substring(2);
			if(i<pixel_ids.length-1)
				url+=",";
		}
		var win = window.open(url);
		win.focus();
	}
</script>

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
		echo "\t<style>\n";
        echo "\t#".$id."\n";
        echo "\t{\n";
        echo "\t\tposition: absolute;\n";
        echo "\t\tleft:".$row['posx']."px;\n";
		echo "\t\ttop:".$row['posy']."px;\n";
		echo "\t\tclip: rect(".$row['top']."px,".$row['righ']."px,".$row['bottom']."px,".$row['lef']."px)\n";
        echo "\t}\n";
        echo "\t#".$id." img { width: ".$row['width']."px; height: ".$row['height']."px; }\n";
    	echo "\t</style>\n";
		echo "\t<div id=\"".$id."\"  onClick=\"pixel_click(this.id)\"><img src=".$row['image_path']." > </div>\n";
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
<button  onClick="openInNewTab()">upload</button>
</body>
</html>
