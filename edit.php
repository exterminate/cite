<?php	
session_start();
require 'core/init.php';

header('Content-type: application/json');

$validate = new Validate();

/* don't think I need these two */
$description = Input::get('description'); 
$doi = Input::get('doi');
$stubId = Input::get('stubId');
$title = Input::get('title');

if($_SESSION['login']->isLoggedIn()) {

    $stub = $dbHandler->getStub('stubId', $stubId);
          
    // validate input
    $validate->check($_POST, array(  
            'title' => array(
                    'required'  => true,
                    'max'       => 300,
                    'min'     => 2			
                    ),
            'description' => array(
                    'required'  => true,
                    'max'       => 5000		
                    ),
            'doi' => array(
                    'doi'       => true
                    )
            )
    );

    if($validate->passed()) {
              
        //update table
        $dbHandler->updateNew('links', 'stubTitle', $title, 'StubId', $stubId);
        $dbHandler->updateNew('links', 'description', $description, 'StubId', $stubId);
        $dbHandler->updateNew('links', 'doi', $doi, 'StubId', $stubId);         
        
        //email watchers
        if(!empty($doi)) {
            $emailHandler = new EmailHandler();
            $emailHandler->sendMail(
// change the email - hard coded temporarily                        
                'ian.coates@gmail.com',
                'A paper you were watching has been published',
                $_SESSION['name'] . "has just published " . $stub->stubTitle . ".\nGo to " . $rootURL.$stub->stubId . " to see the article." // add "Why not submit your stub now!"
            );
            
// do we unset all those emails now??
        }
        // success, do this or start a session message
        echo json_encode(array('emailValid' => 'false')); // Uh oh, we don't got the email	
    } else {
        //validation failed.   
        echo json_encode(array('emailValid' => 'false')); // Uh oh, we don't got the email
    }

}


?>

