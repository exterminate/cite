<?php 	
	class Stub{
		
		public $stubId;
		public $firstName;
		public $surname;
		public $email;
		public $orcid;
		public $description;
		public $dateSubmitted;
		public $doi;
		public $dateDoi;
		public $deepLink;
		public $views;

		function __construct($array){
			$this->stubId = $array['stubId'];
			$this->firstName = $array['firstName'];
			$this->surname = $array['surname'];
			$this->email = $array['email'];
			$this->orcid = $array['orcid'];
			$this->description = $array['description'];
			$this->dateSubmitted = $array['dateSubmitted'];
			$this->doi = $array['doi'];
			$this->dateDoi = $array['dateDoi'];
			$this->deeplink = $array['deepLink'];
			$this->views = $views['views'];
		}
	}
?>

