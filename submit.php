<?php
session_start();    
require 'core/init.php';

header('Content-type: application/json');

$user = Input::get('user');
var_dump($user);
$stubInput = (array) $user;
$stubInput['stubTitle'] = Input::get('title');
$stubInput['description'] = Input::get('description');
$stubInput['datesubmitted'] = date('Y-m-d H:i:s');


$stub = new Stub($stubInput);    

$dbHandler->put('links', $stub);

echo json_encode(array("message" => "Stub written successfully"));

?>
