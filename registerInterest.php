<?php
    
    require 'core/init.php';
    
    header('Content-type: application/json');
    
    $stubId = Input::get('stubId');
    $interestedEmail = Input::get('interestedEmail');;
    
    if(isset($stubId) && isset($interestedEmail)){
        //get the appropriate stub from the database using the stubId posted in
        $stub = $dbHandler->getStub("stubId", $stubId);
        
        //append the interested email to the stub
        array_push($stub->interestedEmails, $interestedEmail);
        
        //write the stub back to the database
        
        //if db write is successful
        echo json_encode(array("interestRegistered" => true));
        
        //if db write fails
        //echo json_encode(array("interestRegistered" => false, "errorMsg" => "Failed to write email to database"));
    }

?>