<?php

class Stub {
	//public $id, $deeplink, $name, $email, $orcid, 
	//	$datesubmitted, $doi, $datedoi, $description, $r;


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
		$query = $this->handler->query("SELECT * FROM links WHERE deeplink = '$code'");
		while ($r = $query->fetch(PDO::FETCH_OBJ)) {
			if(strlen($r->doi) != 0) {
				header("Location: http://dx.doi.org/".$r->doi);
			} else {
				// return a message to say that "this stub does not have 
				// a DOI associated with it. Update it with your deeplink"
				return $this->r = $r;
			}

		}
	}

	public function addViews($code) {
		$query = $this->handler->query("SELECT views FROM links WHERE deeplink = '$code'");
		$r = $query->fetch(PDO::FETCH_OBJ);
		$newViews = $r->views + 1;		
		$sql = "UPDATE links SET views = ? WHERE deeplink = ?";
		$query = $this->handler->prepare($sql);
		$query->execute(array($newViews,$code));
	}
	
	public function showBits($input) {
		return $this->r->$input;
	}

	public function showStubs() {
		echo "STUBS";
		$query = $this->handler->query("SELECT views FROM links");
		while ($r = $query->fetch(PDO::FETCH_OBJ)) {
			echo $r->description;
		}
	}

	public function countStubsType($table,$column) {
		$sql = "SELECT " . $column . " FROM " . $table;
		
		$query = $this->handler->query("SELECT views FROM links");
		return $query->rowCount();
	}

}
