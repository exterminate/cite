<?php	

	header('Content-type: application/json');

	if(isset($_POST['email'])){
		//if email exists in the database
			echo json_encode(array('emailValid' => 'true'));
		//else
			echo json_encode(array('emailValid' => 'false'));
	else if(isset($_POST['code'])){
		//if code is valid
			echo json_encode(array('login' => 'true'));
		//else 
			echo json_encode(array('login' => 'false'));

	}

	
	

?>