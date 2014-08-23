<?php
session_start();
require 'core/init.php';

include 'layout/head.php';
include 'layout/header.php';
include 'layout/head.php';

/* put code to process contact */



?>

<h1>Contact us</h1>

<!-- form to put somewhere -->
<form action="" method="POST">
	<label for="name">Name:</label><br>
	<input type="text" name="name" size="34" <?php if($_SESSION['login']->isLoggedIn()) {echo 'readonly value="'.$_SESSION['name'].'"';} ?>"><br>
	<label for="email">E-mail:</label><br>
	<input type="email" name="email" size="34" <?php if($_SESSION['login']->isLoggedIn()) {echo 'readonly value="'.$_SESSION['email'].'"';} ?>"><br>
	<label for="comment">Comment:</label><br>
	<textarea name="comment"></textarea><br>
	<label for="human">What is 3 + 2?</label><br>
	<input type="text" name="human"><br>
	<input type="submit" name="submit" value="Send">
</form>	
	
<?php
include 'layout/footer.php';
?>