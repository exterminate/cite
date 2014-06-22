<?php
require 'core/init.php';

$validate = new Validate();
	$validate->check($_GET, array( 
		Input::get('em') => array(
			'required' 	=> true,
			'max' 		=> 60,
			'email' 	=> true			
			),
		Input::get('dl') => array(
			'required' 	=> true,
			'min' 		=> 6,
			'max' 		=> 20	
			)
		)
	);
	
if($validate->passed()) {
        $dbHandler->login(Input::get('email'), Input::get('password'));
}

?>

