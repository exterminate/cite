<?php

class Stub {
	public $id, $deeplink, $name, $email, $orcid, 
		$datesubmitted, $doi, $datedoi, $description;
	public function __construct($handler) {
		$this->handler = $handler;		
	}

	public function addStub($deeplink,$name,$email,$orcid,$description) {
		$sql = "INSERT INTO links (deeplink, name, email, orcid, description, datesubmitted) 
			VALUES (:deeplink, :name, :email, :orcid, :description, NOW())";
			
		$query = $this->handler->prepare($sql);
		$query->execute(array(
			':deeplink' 	=> $deeplink,
			':name' 		=> $name,
			':email' 		=> $email,
			':orcid'		=> $orcid,
			':description' 	=> $description
		));

	}


	public function count($deeplink) {
		$query = $this->handler->query("SELECT * FROM links WHERE deeplink = '$deeplink'");
		return $query->rowCount();
	}

	public function redirect($code) {
		//$code = mysql_real_escape_string($code);
		$query = $this->handler->query("SELECT * FROM links WHERE deeplink = '$code'");
		while ($r = $query->fetch(PDO::FETCH_OBJ)) {
			if(strlen($r->doi) != 0) {
				header("Location: http://dx.doi.org/".$r->doi);
			} else {
				// return a message to say that "this stub does not have 
				// a DOI associated with it. Update it with your deeplink"
				return "\$message";
			}

		}
		/*
		if(code_exists($code)){
			$url_query = mysql_query("SELECT url FROM urls WHERE code= '$code'");;
			$url = mysql_result($url_query, 0, 'url');
			header('Location: '.$url);
		}*/
	}
}
