<?php	

require 'core/init.php';
require 'classes/author.php';
header('Content-type: application/json');

$stubEmail = $_POST['stubEmail'];
$validate = new Validate();

if(isset($_POST['inputEmail']) && isset(Input::get('code'))){
	//if email exists in the database
	
	$validate->check($_POST, array(  
		'inputEmail' => array(
			'required' 	=> true,
			'max' => 80,
			'email' => true			
			),
		'code' => array(
			'required' 	=> true,
			'min' => 12,
			'max' => 12	
			)
		)
	);

	if($validate->passed()) {
		$getStub = $dbHandler->getStub('email', escape(trim($_POST['inputEmail'])));
		if($getStub != null) {
			
			$author = new Author(escape(trim($_POST['inputEmail'])), Input::get('code'), $dbHandler);
			if(Input::get('code') === $author->deepLink) {
				// start session
				session_start();
		        $_SESSION['authorEmail'] = $author->email;
		        $_SESSION['time'] = $author->time;

				echo json_encode(array('emailValid' => 'true')); // Hey, we got the email
			}
		} else
			echo json_encode(array('emailValid' => 'false')); // Uh oh, we don't got the email
	}
		
elseif(isset(Input::get('inputEmail')) && !isset(Input::get('code'))){ // send email and get code
	$validate->check($_POST, array(  
	'inputEmail' => array(
		'required' => true,
		'max' => 80,
		'email' => true			
	));
	if($validate->passed()) {
		// let's create a deeplink for the author
		$author = new Author(escape(trim($_POST['inputEmail'])), $dbHandler->getUniqueCode('deepLink','authors'), $dbHandler);
		$author->createLoginSession();
			
		
		$email = new EmailHandler();
		$email->sendMail(
			Input::get('email'),
			"Code to edit your stub",
			"Go back to the stub and use the code " . $author->deepLink . ". ";
		);
	}

	//moce these eventually
		//if code is valid
		echo json_encode(array('login' => 'true'));
	//else 
		echo json_encode(array('login' => 'false'));

}


// code for inserting into index.php << added
/*
if(strtotime("now") > $SESSION['time']) {
	// perhaps we need a html (or JS) 60 min refresh
	session_destroy(); // ends session, the author has had 60 mins
}*/
echo json_encode(array('login' => 'false'));

?>
