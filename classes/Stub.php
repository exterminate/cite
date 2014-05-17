<?php

class Stub {
	//public $id, $deeplink, $name, $email, $orcid, 
	//	$datesubmitted, $doi, $datedoi, $description, $r;


	public function __construct($handler) {
		$this->handler = $handler;		
	}

	public function addStub($deeplink,$name,$email,$orcid,$description,$uniquecode) {
		$sql = "INSERT INTO links (deeplink, name, email, orcid, description, datesubmitted, uniquecode) 
			VALUES (:deeplink, :name, :email, :orcid, :description, NOW(), :uniquecode)";
			
		$query = $this->handler->prepare($sql);
		$query->execute(array(
			':deeplink' 	=> $deeplink,
			':name' 		=> $name,
			':email' 		=> $email,
			':orcid'		=> $orcid,
			':description' 	=> $description,
			':uniquecode'	=> $uniquecode
		));

	}

	public function updateStub($doi,$deeplink,$uniquecode) {
		$sql = "UPDATE links SET doi = ?, datedoi = NOW() WHERE deeplink = ? AND uniquecode = ?";
		$query = $this->handler->prepare($sql);
		$query->execute(array($doi,$deeplink,$uniquecode));
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

	public function obtainData($field, $code) { // changed to require another field to make it more versatile :Ian
		$query = $this->handler->query("SELECT * FROM links WHERE $field = '$code'");
		while ($r = $query->fetchAll()) {
			return $this->r = $r;
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

	public function showStubs() { // is this being used?
		$query = $this->handler->query("SELECT views FROM links");
		while ($r = $query->fetch(PDO::FETCH_OBJ)) {
			echo $r->description;
		}
	}

	public function showAllStubs() {
		$query = $this->handler->query("SELECT * FROM links");
		while($r = $query->fetch(PDO::FETCH_OBJ)) {
			echo "<tr title='".$r->description."'>";
				echo "<td>".$r->deeplink."</td>";
				echo "<td>".$r->name."</td>";
				echo "<td>".$r->email."</td>";
				echo "<td>".$r->orcid."</td>";
				$now = new DateTime(date("Y-m-d H:i:s"));
				$stubPosted = new DateTime($r->datesubmitted);
				$interval = $now->diff($stubPosted);
				echo "<td title='".$r->datesubmitted."'>".$interval->format('%y year, %m month and %d days ago')."</td>";
			echo "</tr>";
		}
	}

	public function countStubsType($table,$column) {
		$sql = "SELECT " . $column . " FROM " . $table;		
		$query = $this->handler->query($sql);
		return $query->rowCount();
	}

}
