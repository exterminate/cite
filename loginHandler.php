<?php

require 'core/init.php';
require 'classes/author.php';
header('Content-type: application/json');

$email = $_POST['email'];

if(isset($email) && isset($code)){
	//user has input both their email and a code, so we are ready to log them in

	//if login successful
	echo json_encode(array("login" => "true"));

	//if login unsuccessful
	echo json_encode(array("login" => "false", "errorMsg" => "reason for login fail here"));

} else if (isset($email)){
	//user has only input their email address, so send out an email containing a unique login code

	//if email with code sends successfully
	echo json_encode(array("emailSent" => "true"));

	//if email fails for any reason
	echo json_encode(array("emailSent" => "false"));
}
