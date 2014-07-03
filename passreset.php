<?php
session_start();
require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';

if(Input::exists()) {
	$validate = new Validate();
	$validate->check($_POST, array( 
                'email' => array(
			'required' 	=> true,
			'email' 	=> true			
			)
		)
	);
	if($vaidate->passed()) {
		// does this user exist?
		// no
		$dbHandler->getUser('email', Input::get('email'));
		//check the above returns a user
		
		// yes
		$newPassword = $dbHandler->getUniqueCode('stubId', 'links');
		$dbHandler->updateNew('users', 'password', md5($newPassword), 'email', Input::get('email'));
		$email = new EmailHandler();
		$email->sendEmail(
			'to',
			'subject',
			'message'
		);
	} else {
		$_SESSION['error'] = "Sorry, this email isn't valid";
	}

	
}

?>
<h2>Reset password</h2>
<p>We will e-mail you with a new password.</p>

<?php
if(isset($_SESSION['error'])) {
	echo "<p>" . $_SESSION['error'] . "</p>";
	unset($_SESSION['error']);
}

$num1 = rand(1,4);
$num2 = rand(1,4);
$_SESSION['sum'] = $num1 + $num2;
?>

<form action="" method="POST">
	<label for="email">Enter e-mail address:</label><br>
	<input type="email" name="email"><br>
	<label for="human">What is <?=$num1?> + <?=$num1?>?</label><br>
	<input type="text" name="human" size="2"><br>
	<input type="submit" name="reset" value="Reset"><br>
</form>	

<?php

include 'layout/footer.php';

?>


