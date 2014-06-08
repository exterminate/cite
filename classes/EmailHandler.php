<?php

class EmailHandler {
	
	function __construct($from, $subject, $message) {
		$this->from = $from;
		$this->subject = $subject;
		$this->message = $message;
	}

	public function sendMail() {
		if(!mail(trim(escape(Input::get('email'))),$this->subject,$this->message,"From: $this->from\n")) {
		    	echo "Mail fail!";
		}
	}
}

?>