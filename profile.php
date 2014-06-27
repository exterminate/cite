<?php
session_start();
require 'core/init.php';

include 'layout/head.php';
include 'layout/header.php';

if(isset($_SESSION['name']) && !isset($_GET['orcid'])) {
	// see your profile
	
	$user = $dbHandler->getUser('email', $_SESSION['email']);
	
	echo "<p><strong>Profile: </strong>".$_SESSION['name']."</p>\n";
	echo "<p><strong>OrcID</strong>" . $user->orcid . "</p>";
	echo "<p><strong>E-mail: </strong>".$user->email."</p>\n";
	echo "<p>You have ".$dbHandler->count('links', 'email', '=', $user->email)." stubs</p>";
	echo '<input type="button" value="Back" onclick="history.back(-1)" />';
	// what else do we want to display?
	
} elseif(isset($_GET['orcid'])) {
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
		
		if($user != null){
			
			echo "<p><strong>Profile: </strong>".$user->firstName." ". $user->surname ."</p>\n";
			echo "<p><strong>OrcID: </strong>" . $user->orcid . "</p>";
			echo "<p>" . $user->firstName . " " . $user->surname . " has ".$dbHandler->count('links', 'email', '=', $user->email)." stubs</p>";
			echo '<input class="button" type="button" value="Back" onclick="history.back(-1)" />';
		} else {
			
			echo "<p>There are no matching stubs with the OrcID ". Input::get('orcid') ."</p>";
		}
		
	} else {
		echo "You have not entered a valid OrcID.";
	}
} else {
	echo "You are not logged in.";
}

include 'layout/footer.php';

?>
