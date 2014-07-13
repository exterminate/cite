<?php

/*
 * This is the API that retrieves
 * JSON data to the client
 */

require 'core/init.php';

if(Input::exists()) {
    $token = Input::get('token');
    $uniqueId = Input::get('uniqueId');
    $stubId = Input::get('uniqueId');
    
    $dbHandler = api($token, $uniqueId, $stubId);
    
}


?>