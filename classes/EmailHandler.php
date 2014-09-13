<?php

class EmailHandler {
	
	private $email = "citeitnow@gmail.com";

	public function sendEmail($to, $subject, $message) {
		//commenting this out to prevent accidental spam during development
		$headers = "";
		$headers.= "MIME-version: 1.0\n";
		$headers.= "Content-type: text/html; charset= iso-8859-1\n";
		$headers = "From: $this->email\r\n";
		$headers .= "Reply-To: no-reply@cite.pub\r\n";
		$headers .= "Return-Path: no-reply@cite.pub\r\n";
		
		if(!mail($to, $subject, $message, $headers)) {
		    	echo "Mail fail!";
		}
		
	}
}

?>