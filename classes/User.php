<?php

class User {
	
	public $firstName, $surname, $orcid, $accesLevel, $email;
	
	
	public function __construct($firstName, $surname, $orcid, $accesLevel, $email) {
		$this->firstName = $firstName;
		$this->surname = $surname;
		$this->orcid = $orcid;
		$this->accessLevel = $accessLevel;
		$this->email = $email;
	}
	
	

	

	
}