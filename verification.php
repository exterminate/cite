<?php
session_start();
require('core/init.php');


$validate = new Validate();
	$validate->check($_GET, array( 
		'em' => array(
			'required' 	=> true,
			'max' 		=> 60,
			'email' 	=> true			
			),
		'dl' => array(
			'required' 	=> true,
			'min' 		=> 12,
			'max' 		=> 12	
			)
		)
	);
        
include('layout/head.php');
include('layout/header.php');

if($validate->passed()) {
        $dbHandler->verifyUser(Input::get('em'), Input::get('dl'));
        echo $_SESSION['name']." you are now logged in.";
}


include 'layout/footer.php';
?>

