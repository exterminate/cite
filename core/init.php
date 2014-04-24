<?php
//session_start();

try {
	$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
	die("sorry, database problem");
}

/*
spl_autoload_register(function($class) {
	require_once 'classes/' . $class . '.php';
});
*/
//require_once 'includes/functions.php';
?>