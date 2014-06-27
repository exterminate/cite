<?php
session_start();
header('Content-type: application/json');  
require 'core/init.php';

$user = Input::get('user');

$stubInput = (array) $user;

$stubInput['stubTitle'] = Input::get('title');
$stubInput['description'] = Input::get('description');
$stubInput['datesubmitted'] = date('Y-m-d H:i:s');

$stub = new Stub($stubInput);    

$dbHandler->put('links', $stub);

echo json_encode(array("message" => "Stub written successfully"));

?>
