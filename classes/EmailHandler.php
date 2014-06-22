<?php

class EmailHandler {
	
	private $email = "citeitnow@gmail.com";

	public function sendEmail($to, $subject, $message) {
		//commenting this out to prevent accidental spam during development
		/*
		if(!mail($to, $subject, $message,"From: $this->email\n")) {
		    	echo "Mail fail!";
		}
		*/
	}
}

?>