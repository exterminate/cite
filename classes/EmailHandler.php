<?php

class EmailHandler {
	
	private $email = "citeitnow@gmail.com";

	public function sendMail($to, $subject, $message) {
		if(!mail($to, $subject, $message,"From: $this->email\n")) {
		    	echo "Mail fail!";
		}
	}
}

?>