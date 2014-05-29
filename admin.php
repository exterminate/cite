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
	
	include 'layout/head.php';
	include 'layout/header.php';
	
	if(Input::get('delete')) {
		$stub->deleteStub(trim(escape(Input::get('delete'))));
		header("Location: admin.php");
		exit;
	}
	
	/* to finish and test
	if(Input::get('edit')) {
		$stub->editStub(trim(escape(Input::get('edit'))));
		header("Location: admin.php");
		exit;
	}	
	*/
	
	echo "<p>" . $_SESSION['username'] . " is logged in - <a href='" . $rootURL . "logout.php'>Logout</a></p>";

	$stub = new Stub($handler);
	echo "<p>" . $stub->countStubsType("links", "deeplink") . " stubs have been created</p>";

	echo "<table class='table' width='100%'>";
	echo "<tr>";
		echo "<th>deeplink</th>";
		echo "<th>name</th>";
		echo "<th>email</th>";
		echo "<th>orcid</th>";
		echo "<th>datesubmitted</th>";
		echo "<th>delete</th>";
		echo "<th>edit</th>";
	echo "</tr>";	
	$stub->showAllStubs();
	echo "</table>";

	


} else {
	include 'layout/head.php';
	include 'layout/header.php';
?>


<p>Quick form to text validation and User class</p>

<form action="" method="post">
	<table>
		<tr>
			<td><label for="username">Name</label></td>
			<td><input type="text" name="username" id="username" value="<?php echo Input::get('username'); ?>" autocomplete="off"></td>
		</tr>
		<tr>
			<td><label for="password">Password</label></td>
			<td><input type="password" name="password" id="password"></td>
		<tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Submit"></td>
		</tr>
	</table>		
</form>

<?php

}

include 'layout/footer.php';
?>
