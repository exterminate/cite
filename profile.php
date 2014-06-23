<?php
session_start();
require 'core/init.php';

include 'layout/head.php';
include 'layout/header.php';

if(isset($_SESSION['name']) && !isset(Input::get('orcid'))) {
	// see your profile	
	$user = $dbHandler->getUser('secretCode', $_SESSION['secretCode']);
	echo "<strong>Profile: </strong>".$_SESSION['name']."<br>\n";
	echo "<strong>E-mail: </strong>".$user->email."<br>\n";
	echo "<p>You have ".count($table, $field, $operator, $code)." stubs";
	// what else do we want to display?
	
} elseif(isset(Input::get('orcid'))) {
	// see someone else's profile
	$validate = new Validate();
	$validate->check($_GET, array( 
                'orcid' => array(
			'required' 	=> true,
			'orcid' 	=> true			
			)
		)
	);
	if($validate->passed()) {
		$user = $dbHandler->getUser('orcid', Input::get('orcid')); // if this method works then reconsider for index.php
		echo "<strong>Profile: </strong>".$user->firstName." ". $user->surname ."<br>\n";
		echo "<p>" . $user->orcid . "</p>";
		echo "<p>" . $user->firstName . " " . $user->surname . " has ".count($table, $field, $operator, $code)." stubs";
		
		// loop over stubs
		
		// here
	} else {
		echo "You have not entered a valid OrcID.";
	}
} else {
	echo "You are not logged in.";
}

include 'layout/footer.php';

?>
