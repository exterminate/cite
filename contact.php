<?php
session_start();
require 'core/init.php';

include 'layout/head.php';
include 'layout/header.php';



include 'layout/head.php';
?>

<!-- form to put somewhere -->
<form action="" method="POST">
	<label for="name">Name:</label><br>
	<input type="text" name="name" value="<?php echo $_SESSION['name']; ?>"><br>
	<label for="email">E-mail:</label><br>
	<input type="email" name="email" value="<?php echo $_SESSION['email']; ?>"><br>
	<label for="comment">Comment:</label><br>
	<textarea name="comment"></textarea><br>
	<label for="human">What is 3 + 2?</label><br>
	<input type="text" name="human"><br>
	<input type="submit" name="submit" value="Send">
</form>	
	

</form>
