<?php

class Validate {

	private $_passed = false,
			$_errors = array(),
			$_db = null,
			$_orcidProfile = null;

	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
		
			if($item == "orcid"){
				//validate orcid here
			}
			
		
			foreach($rules as $rule => $rule_value) {
				$value = trim($source[$item]);
				$item = escape($item);
			
				if($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required");
				} elseif(!empty($rule)) {
					switch($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$item} must be a minimum of {$rule_value} characters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$item} must be a maximum of {$rule_value} characters.");
							}
						break;
						case 'email':
							if(filter_var($value, FILTER_VALIDATE_EMAIL) == false) {
								$this->addError("{$value} is not a valid email address.");
							}
						case 'doi':
							// Validate DOI
							/*if(filter_var($value, FILTER_VALIDATE_EMAIL) == false) {
								$this->addError("{$value} is not a valid email address.");
							}*/	
						break;

					}
				}
			}
		}

		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}

	public function checkDB($handler, $deeplink) { //delete?
		//GETTING ROW COUNT
		$query = $handler->query("SELECT * FROM links WHERE deeplink = '$deeplink'");
		
		while($query->rowCount() == 0) {
			return $deeplink;
		}

	}

}