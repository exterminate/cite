<?php

class User {

	private $_db;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
	}

}