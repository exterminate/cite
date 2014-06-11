<?php	

	header('Content-type: application/json');

	$stubEmail = $_POST['stubEmail'];

	if(isset($_POST['inputEmail']) && !isset($_POST['code'])){
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
