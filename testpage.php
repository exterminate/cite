<?php

// test page // delete later

require 'classes/DB.php';

$db = new DB();

echo "<pre>";

// returns array
// (table, column, specific)
print_r( $db->read('links','deeplink','b9s0aJPq') ); 
echo "</pre>";

echo "<br>";

// returns first item in array once read is called
// alternatively, you could do $db->first()['name'];
echo $db->first('name'); 


echo "<br>";

// returns the number of items in range
// (table, column, specific)
echo $db->count('links','deeplink','b9s0aJPq');

echo "<br>";

$db->write(
	'links', array(
		
		)
	);


?>