<?php 	

	class Stub{
		
		public $stubId = "";
		public $stubTitle = "";
		public $firstName = "";
		public $surname = "";
		public $email = "";
		public $orcid = "";
		public $description = "";
		public $datesubmitted = "";
		public $doi = "";
		public $datedoi = "";
		public $deepLink = "";
		public $views = "";
		public $interestedEmails = array();

		function __construct($array){
			if(array_key_exists("stubId", $array)){
				$this->stubId = $array['stubId'];
			}

			if(array_key_exists("stubTitle", $array)){
				$this->stubTitle = $array['stubTitle'];
			}

			if(array_key_exists("firstName", $array)){
				$this->firstName = $array['firstName'];
			}

			if(array_key_exists("surname", $array)){
				$this->surname = $array['surname'];
			}

			if(array_key_exists("email", $array)){
				$this->email = $array['email'];
			}

			if(array_key_exists("orcid", $array)){
				$this->orcid = $array['orcid'];
			}

			if(array_key_exists("description", $array)){
				$this->description = $array['description'];
			}

			if(array_key_exists("datesubmitted", $array)){
				$this->datesubmitted = $array['datesubmitted'];
			}

			if(array_key_exists("doi", $array)){
				$this->doi = $array['doi'];
			}

			if(array_key_exists("datedoi", $array)){
				$this->datedoi = $array['datedoi'];
			}

			if(array_key_exists("deepLink", $array)){
				$this->deepLink = $array['deepLink'];
			}

			if(array_key_exists("views", $array)){
				$this->views = $array['views'];
			}
			
			if(array_key_exists("interestedEmails", $array)){				
				$this->interestedEmails = unserialize($array['interestedEmails']);
			}
		}
		/*
		function toArray(){

			$array = array(
				'stubId' => $this->stubId,
				'firstName' => $this->firstName,
				'surname' => $this->surname,
				'email' => $this->email,
				'orcid' => $this->orcid,
				'description' => $this->description,
				'datesubmitted' => $this->datesubmitted,
				'doi' => $this->doi,
				'datedoi' => $this->datedoi,
				'deepLink' => $this->deepLink,
				'views' => $this->views,
				'interestedEmails' => $this->interestedEmails
				);

			
			return $array;
		}
		*/
	}
?>

