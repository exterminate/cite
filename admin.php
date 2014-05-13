<?php
session_start();
require 'core/init.php';


if(Input::exists()) {
	
	$user = new User($handler, Input::get('username'), Input::get('password'));
	$user->login();
	
} 
// login to admin so we can delete spam,
// fix broken links etc.

if(isset($_SESSION['username'])) {
	echo $_SESSION['username'] . " is logged in";

	$stub = new Stub($handler);
	//echo "<p>" . $stub->countStubsType("links", "deeplink") . "Stubs have been created</p>";
	
	$stub->count('ngGJDz9y');
	
	//$stub->showStubs();
	/*while($r = $stub->showStubs()) {
		echo $r->description;
		echo "<br>";
	}*/
	//die();
}



?>


<p>Quick form to text validation and User class</p>
<p><a href="logout.php">Logout</a></p>
<form action="" method="post">
	<div class="field">
		<label for="username">Name</label>
		<input type="text" name="username" id="username" value="<?php echo Input::get('username'); ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
	</div>

	<input type="submit" name="submit" value="Submit">
</form>