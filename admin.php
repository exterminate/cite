<?php
session_start();
require 'classes/User.php';
//require 'classes/Stub.php';
require 'classes/Input.php';
require 'classes/Validate.php';
require 'includes/functions.php';

if(Input::exists()) {
	try {
		$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
		die("sorry, database problem");
	}

	$user = new User(Input::get('username'),Input::get('password'));
	$user->login();
}
// login to admin so we can delete spam,
// fix broken links etc.

?>


<p>Quick form to text validation and User class</p>

<form action="" method="post">
	<div class="field">
		<label for="username">Name</label>
		<input type="text" name="username" id="username" value="<?php echo Input::get('username'); ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">E-mail</label>
		<input type="password" name="password" id="password">
	</div>
	
	<input type="submit" name="submit" value="Submit">
</form>