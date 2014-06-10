<?php
session_start();
require 'core/init.php';


if(Input::exists()) {

	$user = new User($dbHandler, Input::get('username'), Input::get('password'));
	$user->login();
	
} 




if(isset($_SESSION['username'])) {
	
	
	
	// delete stub
	if(Input::get('delete')) {
		
		$dbHandler->deleteStub(trim(escape(Input::get('delete'))));
		echo "ho";
		header("Location: admin.php");
		exit;
	}
	
	include 'layout/head.php';
	include 'layout/header.php';	
	echo "<p><a href='admin.php'>Admin</a></p>";
	
	// edit a stub
	if(Input::get('edit')) {
		$stub = $dbHandler->getStub('stubId', trim(escape(Input::get('edit'))));
		echo "<p>Editing stub " . Input::get('edit') . "</p>";
		//$editStub->obtainData('deeplink', trim(escape(Input::get('edit'))));
		echo "<p>Created: " . $stub->datesubmitted . "</p>";
		include 'layout/edit.php';


		//$editStub->editStub(trim(escape(Input::get('edit'))));
		//header("Location: admin.php");
		//exit;
	} else {	
	
	
		echo "<p>" . $_SESSION['username'] . " is logged in - <a href='" . $rootURL . "logout.php'>Logout</a></p>";

		$stubs = $dbHandler->getStubs('links', 'stubId', 'LIKE', '%');
		
		/*if($stubs == null){  
    		$stubs = array("error" => "No results found matching ".$type." = ".$query);//nothing to output this on this page
    	}*/
		echo "<p>" . $dbHandler->count('links', 'stubId', 'LIKE', '%') . " stubs have been created</p>";

		echo "<table class='table' width='100%'>";
		echo "<tr>";
			echo "<th>stubId</th>";
			echo "<th>firstName</th>";
			echo "<th>surname</th>";
			echo "<th>email</th>";
			echo "<th>orcid</th>";
			echo "<th>datesubmitted</th>";
			echo "<th>delete</th>";
			echo "<th>edit</th>";
		echo "</tr>";	
		foreach($stubs as $stub) {
			echo "<tr>";
			echo "<td>" . $stub->stubId . "</td>";
			echo "<td>" . $stub->firstName . "</td>";
			echo "<td>" . $stub->surname . "</td>";
			echo "<td>" . $stub->email . "</td>";
			echo "<td>" . $stub->orcid . "</td>";
			echo "<td>" . $stub->datesubmitted . "</td>";
			echo "<td><a href='?delete=" . $stub->stubId ."'>X</a></td>";
			echo "<td><a href='?edit=" . $stub->stubId ."'>X</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	
	}

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
