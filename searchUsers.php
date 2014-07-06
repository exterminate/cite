<?php
    session_start();
	header('Content-type: application/json');
        require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
	PhpConsole\Helper::register();
	require 'core/init.php';
        
        $public = Input::get('public');    
        $email = $_SESSION['email'];
        
        if($email != ""){
            if($public == 'true'){
                $user = $dbHandler->getPublicUser('email', $email);          
            } else{
                $user = $dbHandler->getUser('email', $email);             
            }
            echo json_encode($user);
        } else{
            echo JsonFactory::message('error');
        }
?>