<?php
session_start();
    require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
    PhpConsole\Helper::register();
require 'core/init.php';


if(Input::exists()) {

	$user = new User($dbHandler);
	$validate = new Validate();
	$validate->check($_POST, array( 
		'email' => array(
			'required' 	=> true,
			'max' 		=> 60,
			'email' 	=> true			
			),
		'password' => array(
			'required' 	=> true,
			'min' 		=> 6,
			'max' 		=> 20	
			)
		)
	);
	
	if($validate->passed()) {
		//ian.coates@gmail.com
		echo Input::get('email')." ". Input::get('password');
		$user->login(Input::get('email'), Input::get('password'));
		echo "ian.coates@gmail.com";
	}
} 
PC::debug($_SESSION['name']);
if(isset($_SESSION['name'])) {
	
	// delete stub
	if(Input::get('delete')) {
		$dbHandler->deleteStub(trim(escape(Input::get('delete'))));
		header("Location: admin.php");
		die();
		exit;
	}
	
	include 'layout/head.php';
	include 'layout/header.php';	
	echo "<p><a href='admin.php'>Admin</a></p>";
	
	// edit a stub
	if(Input::get('edit')) {
		$stub = $dbHandler->getStub('stubId', trim(escape(Input::get('edit'))));
		echo "<p>Editing stub: " . Input::get('edit') . "<br>Created: " . $stub->datesubmitted . "</p>";
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
			<td><label for="email">E-mail</label></td>
			<td><input type="email" name="email" id="email" value="<?php echo Input::get('email'); ?>" autocomplete="off"></td>
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
