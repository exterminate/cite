<?php
session_start();
require 'classes/User.php';
//require 'classes/Stub.php';
require 'classes/Input.php';
require 'classes/Validate.php';
require 'includes/functions.php';

if(Input::exists()) {
	try {
		$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
		die("sorry, database problem");
	}

	$user = new User(Input::get('username'),Input::get('password'));

}
// login to admin so we can delete spam,
// fix broken links etc.

?>
