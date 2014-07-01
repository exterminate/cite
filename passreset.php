<?php
session_start();
require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';

if(Input::exists()) {
	$validate = new Validate();
	
}

?>
<h2>Reset password</h2>
<p>We will e-mail you with a new password.</p>

<form action="" method="POST">
	<label for="email">Enter e-mail address:</label><br>
	<input type="email" name="email"><br>
	<label for="human">What is 3 + 2?</label><br>
	<input type="text" name="human"><br>
	<input type="submit" name="reset" value="Reset"><br>
</form>	

<?php

include 'layout/footer.php';

?>


