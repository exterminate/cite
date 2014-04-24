<?php

class DB {

	private function __construct() {
		try {
			$this->_pdo = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
			
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}	

	public function fetch($string) {
		return $string->fetchAll(PDO::FETCH_ASSOC);
	}


}
/* 
*  COLUMNS NEEDED
*  id, linkid, name, email, orcid (required), datesubmitted, doi, datedoi
*  any more?
*/

?>