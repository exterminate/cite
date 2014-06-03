<?php

	header('Content-type: application/json');

	require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
    PhpConsole\Helper::register();
	require 'core/init.php';

    $query = Input::get('query');
    $type = Input::get('type');
    $admin = Input::get('admin');

    //PC::debug($query.", ".$type);

  	try {
	    // let's get some search results!
	    $stub = new Stub($handler);
	    $results = $stub->obtainData($type, $query); //fetches array(?) :Ian

	    //PC::debug($results);

	    if($results == null){  

	    	$toReturn = array("error" => "No results found matching ".$type." = ".$query);

	    }else{

	    	if($admin == 'true'){
	    		/*
					Return the whole table if admin is true.
					Each array in $results is 2 arrays back to back, one numerically indexed, the other associatively indexed
		    		so we will split the array in half and return only the associative part
	    		*/
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
		    } else{
		    	/*
		    		Return only the publically visible part of the stub if not an admin search
		    	*/
		    	$toReturn = array();
		    	foreach($results as $key => $val){
		    		$temp = array();   		
			    	$temp['Name'] = $val['name'];
			    	$temp['Email'] = $val['email'];
			    	$temp['Orcid'] = $val['orcid'];
		    		$temp['Description'] = $val['description'];
		    		$temp['Date Created'] = $val['datesubmitted'];
		    		$temp['DOI'] = $val['doi'];
		    		$temp['Date Completed'] = $val['datedoi'];
		    		$temp['Stub ID'] = $val['deeplink'];
			    	
			    	array_push($toReturn, $temp);
		    	}
		    }
		} 

	    //PC::debug($toReturn);
	    echo json_encode($toReturn, JSON_FORCE_OBJECT);		    
	} catch(Exception $e) {
		die($e->getMessage());
	}	 
	

	
?>