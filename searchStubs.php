<?php

	header('Content-type: application/json');

	require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
	PhpConsole\Helper::register();
	require 'core/init.php';

	$query = Input::get('query');
	$type = Input::get('type');
	
	    // let's get some search results!
	$stubs = $dbHandler->getStubs('links', $type, "=", $query);
	
	if($stubs == null){  
		echo JsonFactory::message("No results found matching ".$type." = ".$query);
	} else{
		echo json_encode($stubs);	
	}	  	
?>