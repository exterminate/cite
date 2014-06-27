<?php

$rootURL = "http://localhost/git/cite/";

foreach(glob("classes/*.php") as $filename) {
	require $filename;	
}
require 'includes/functions.php';
// modify to get links to work


try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die("sorry, database problem");
}

$dbHandler = new DB($handler);

// login script
$_SESSION['login'] = new LoginHandler();
if(Input::exists() && Input::get('submit') == 'login') {
	
	$validate = new Validate();
	$validate->check($_POST, array( 
		'email' => array(
			'required' 	=> true,
			'max' 		=> 60,
			'email' 	=> true			
			),
		'password' => array(
			'required' 	=> true,
			'min' 		=> 6,
			'max' 		=> 20	
			)
		)
	);
	
	if($validate->passed()) {
		$_SESSION['login']->login(Input::get('email'), Input::get('password'), $dbHandler);
		
	}
}

?>