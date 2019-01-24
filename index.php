<html>


<h1>The $400 homepage</h1>
<style>

h1 {
	color: #003333;
	font-size: 60px;
	text-align: left;
	font-weight: 1900;
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
<body style="background-color:powderblue;">


<script type="text/javascript">
	pixel_ids = []; 
	function pixel_click(clicked_id)
	{
		var childs = document.getElementById(clicked_id).children;
		for (i = 0; i < childs.length; i++) {
			childs[i].style.width = "40px";
            childs[i].style.height = "40px";
			childs[i].style.border='4px solid #003333';
		}
		pixel_ids.push(clicked_id);

	}
	function open_pixel_link(link)
    {
        var win = window.open(link);
		win.focus();
    }


	document.onkeydown = function(evt) {
		evt = evt || window.event;
		if (evt.keyCode == 13) {
			openInNewTab();
		}
	};

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
		pixel_ids=[];
		var win = window.open(url);
		win.focus();
	}
</script>


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
	while ($row = mysqli_fetch_array($response)) 
	{
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
		echo "\t<div id=\"".$id."\" ";
		if($row['link'] == "None")
		{
			echo "onClick=\"pixel_click(this.id)\"";
		}
		else
		{
			echo "onClick=\"open_pixel_link('".$row['link']."')\"";
		}
		echo "><img src=".$row['image_path']." > </div>\n";
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
