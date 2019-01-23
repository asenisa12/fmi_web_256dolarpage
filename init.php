<?php
require_once('defines.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$conn) {
	die("Connection failed".mysqli_connect_error());
}
else {
	echo "Connection successfull\n";
}

// Create database
$create_db_query = 'create database '.DB_NAME.';';
if (mysqli_query($conn, $create_db_query)) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . mysqli_error($conn);
    die();
}

$use_db_query = 'use '.DB_NAME.';';
mysqli_query($conn, $use_db_query);

$create_table_query =  'create table '.TABLE_NAME.'(id int primary key, link varchar(255)';
$create_table_query .= ', image_path varchar(255), width int, height int, posx int, posy int);';

if (mysqli_query($conn, $create_table_query)) {
    echo "Table created successfully\n";
} else {
    echo "Error creating table: " . mysqli_error($conn);
    die();
}

echo "Initializing database\n";
$default_image = '\'http://localhost/project/images/click.jpg\'';
$default_size = 100;
$id = 0;
for($y = 100; $y < DIMENSION*$default_size; $y+=$default_size) 
{
	for($x = 0; $x < DIMENSION*$default_size; $x+=$default_size) 
	{
		$query =  'insert into '.TABLE_NAME.' values('.$id.', \'None\', '.$default_image.',';
		$query .= $default_size.','.$default_size.','.$x.','.$y.');';
		if(!mysqli_query($conn, $query)) {
			echo "Some error occured: ".mysqli_error($conn);
			die();
		}
		$id++;
	}


}
?>