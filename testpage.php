<?php

echo date('Y-m-d H:i:s');

echo "<br>";

$value = "0000-0003-3540-6353";
$pattern = '/[0-9]\{4,4}\-[0-9]{4,4}\-[0-9]{4,4}\-[0-9X]{4,4}/';
							
if(preg_match($pattern, $value)) {
        echo " not a valid ORCID.";
}
/*
// test page // delete later

require 'classes/DB.php';

$db = new DB();

echo "<pre>";

// returns array
// (table, column, specific)
print_r( $db->get('links','deeplink','b9s0aJPq') ); 
echo "</pre>";

echo "<br>";

// returns first item in array once read is called
// alternatively, you could do $db->first()['name'];
echo $db->getFirst('name'); 


echo "<br>";

// returns the number of items in range
// (table, column, specific)
echo $db->count('links','deeplink','b9s0aJPq');

echo "<br>";

$db->put(
	'links', array(
		
		)
	);

*/
?>
