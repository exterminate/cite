<?php

require 'core/init.php';


// add session class/table
include 'layout/head.php';
include 'layout/header.php';	

if(Input::exists()) {

	$stubs = $dbHandler->getStubs('links','email', '=', Input::get('email'));
	echo "<pre>";
	print_r($stubs);
	echo "</pre>";
}
?>

<p>Request a one-time code. This will be sent to your inbox. </p>

<p><a href="">Get code</a></p>

<form action="" method="post">
	<table>
		<tr>
			<td><label for="email">Email address</label></td>
			<td><input type="email" name="email" id="email"></td>
		<tr>	
		<tr>
			<td><label for="deepLink">Enter code</label></td>
			<td><input type="text" name="deepLink" id="deepLink"></td>
		<tr>				
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Edit"></td>
		</tr>
	</table>		
</form>


<?php

include 'layout/footer.php';

?>