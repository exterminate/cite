<?php

class Stub {
	public $id, $deeplink, $name, $email, $orcid, 
		$datesubmitted, $doi, $datedoi;
	public function __construct() {
		//$this->entry = "{$this->name} posted: {$this->message}";
	}

	public function addStub() {
		$sql = "INSERT INTO links (deeplink, name, email, orcid, datesubmitted) 
			VALUES (:deeplink, :name, :email, :orcid, NOW())";
		$query = $handler->prepare($sql);
		$query->execute(array(
			'' => 
			':name' 	=> $this->name,
			':email' 	=> $this->$email
			//etc
		));

	}
}