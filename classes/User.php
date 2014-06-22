<?php

class User {
	
	public $firstName, $surname, $orcid, $accessLevel, $email;
	
	
	public function __construct($firstName, $surname, $orcid, $accessLevel, $email) {
		$this->firstName = $firstName;
		$this->surname = $surname;
		$this->orcid = $orcid;
		$this->accessLevel = $accessLevel;
		$this->email = $email;
	}
	
	

	

	
}