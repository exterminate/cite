<?php

$rootURL = "http://localhost/cite/";
/*
require 'classes/User.php';
require 'classes/DB.php';
require 'classes/Stub.php';
require 'classes/Input.php';
require 'includes/functions.php';
require 'classes/Validate.php';
*/

foreach(glob("classes/*.php") as $filename) {
	require $filename;	
}
require 'includes/functions.php';
// modify to get links to work


try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', '');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die("sorry, database problem");
}

$dbHandler = new DB($handler);

?>