<?php
session_start();    
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
        
        //get the appropriate stub from the database using the stubId posted in
        $stub = $dbHandler->getStub("stubId", Input::get('stubId'));
          
        //append the interested email to the stub
        array_push($stub->interestedEmails, Input::get('interestedEmail'));
     
        //write the stub back to the database
        $dbHandler->updateNew('links', 'interestedEmails', $stub->interestedEmails, 'stubId', Input::get('stubId'));
        
        //if db write is successful
        echo JsonFactory::success(true, "Interest successfully registered!");       
      
    
    } else {
        echo JsonFactory::success(false, "Failed to register interest!");
    }
}

?>