<?php
    
require 'core/init.php';

header('Content-type: application/json');

if(Input::exists()) {

    $validate = new Validate();
    $validate->check($_POST, array( 
            'interestedEmail' => array(
                    'required' 	=> true,
                    'email' 	=> true			
                    ),
            'stubId' => array(
                    'required' 	=> true,
                    'min' 	=> 8,
                    'max' 	=> 8	
                    )
            )
    );
    
    if($validate->passed()) {
        
        $stubId = Input::get('stubId');
        $interestedEmail = Input::get('interestedEmail');

        //get the appropriate stub from the database using the stubId posted in
        $stub = $dbHandler->getStub("stubId", $stubId);
        
        // unserialize the email array
        $array = unserialize($stub->emailUpdate);
        
        //append the interested email to the stub
        array_push($array, $interestedEmail);
        
        //write the stub back to the database
        $stub->update('links', 'emailUpdate', serialize($array));
        
        //if db write is successful
        echo json_encode(array("interestRegistered" => true));
        
        //if db write fails
        //echo json_encode(array("interestRegistered" => false, "errorMsg" => "Failed to write email to database"));
    
    } else {
        echo json_encode(array("interestRegistered" => false, "errorMsg" => "Failed to write email to database"));
    }
}

?>