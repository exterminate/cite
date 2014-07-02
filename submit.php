<?php
header('Content-type: application/json');
require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
	PhpConsole\Helper::register();
require 'core/init.php';

$user = Input::get('user');

$stubInput = (array) $user;

$stubInput['stubTitle'] = Input::get('title');
$stubInput['description'] = Input::get('description');
$stubInput['datesubmitted'] = date('Y-m-d H:i:s');
$stubInput['stubId'] = $dbHandler->getUniqueCode('stubId', 'links');

$stub = new Stub($stubInput);

PC::debug($stub);

$dbHandler->put('links', $stub);

echo JsonFactory::message("Stub added successfully");

?>
