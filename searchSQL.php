<?php

	header('Content-type: application/json');

	require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
    PhpConsole\Helper::register();
	require 'core/init.php';

    $orcid = Input::get('query');
    $type = Input::get('type');

  	try {
	    // let's get some search results!
	    $stub = new Stub($handler);
	    $results = $stub->obtainData($type, $orcid); //fetches array(?) :Ian

	    //each array in $results is 2 arrays back to back, one numerically indexed, the other associatively indexed
	    //so we will split the array in half and return only the associative part

	    $toReturn = array();
	    foreach($results as $key => $val){
	    	$temp = array();
	    	foreach($val as $x => $y){
	    		if(!is_int($x)){
	    			$temp[$x] = $y;
	    		}
	    	}
			array_push($toReturn, $temp);
	    }

	    //PC::debug($toReturn);
	    echo json_encode($toReturn, JSON_FORCE_OBJECT);		    
	} catch(Exception $e) {
		die($e->getMessage());
	}	 
	

	
?>