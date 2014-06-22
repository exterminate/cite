<?php	

require 'core/init.php';
require 'classes/author.php';
header('Content-type: application/json');

$updatedStub = new Stub($_POST['input']);

/*
//check that the user is logged in

//write the updated stub to the database

//if written successfully
echo json_encode(array("editSuccessful" => "true"));

//if update fails
echo json_encode(array("editSuccessful" => "false", "errorMsg" => "reason for update failure here"));


*/










$validate = new Validate();

if(isset(Input::get('inputEmail')) && isset(Input::get('code'))){ //email and code passed
	
	// validate input
	$validate->check($_POST, array(  
		'inputEmail' => array(
			'required'  => true,
			'max'       => 80,
			'email'     => true			
			),
		'code' => array(
			'required'  => true,
			'min'       => 12,
			'max'       => 12	
			)
		)
	);

	if($validate->passed()) {
		
		$author = new Author($dbHandler);
		$authorDetails = $author->getAuthorDetails(Input::get('email'), Input::get('deepLink'));
		if($authorDetails != null) {
			if($authorDetails->time > strtotime("now")) {
				// start session
				session_start();
			        $_SESSION['authorEmail'] = $authorDetails->email;
			        $_SESSION['time'] = $authorDetails->time;
				echo json_encode(array('emailValid' => 'true')); // Hey, we got the email
			}
		} else
			echo json_encode(array('emailValid' => 'false')); // Uh oh, we don't got the email	
	} else
		echo json_encode(array('emailValid' => 'false')); // Uh oh, we don't got the email
	
}elseif(isset(Input::get('inputEmail')) && !isset(Input::get('code'))){ // send email and get code
	$validate->check($_POST, array(  
	'inputEmail' => array(
		'required' => true,
		'max' => 80,
		'email' => true			
	)));
	if($validate->passed()) {
		// let's create a deeplink for the author
		$author = new Author($dbHandler);
		$author->createLoginSession(escape(trim($_POST['inputEmail'])), $dbHandler->getUniqueCode('deepLink','authors'));
			
		
		$email = new EmailHandler();
		$email->sendMail(
			Input::get('email'),
			"Code to edit your stub",
			"Go back to the stub and use the code " . $author->deepLink . ". "
		);
		echo json_encode(array('login' => 'true'));
	} else 
		echo json_encode(array('login' => 'false'));

}


// code for inserting into index.php << added
/*
if(strtotime("now") > $SESSION['time']) {
	// perhaps we need a html (or JS) 60 min refresh
	session_destroy(); // ends session, the author has had 60 mins
}*/


?>

