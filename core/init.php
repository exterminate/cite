<?php

require 'classes/User.php';
require 'classes/DB.php';
require 'classes/Stub.php';
require 'classes/Input.php';
require 'includes/functions.php';
require 'classes/Validate.php';

// modify to get links to work
$rootURL = "http://localhost/git/cite/";

try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die("sorry, database problem");
}

$dbHandler = new DB($handler);

?>