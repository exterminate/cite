<?php
session_start();
// search page

require 'core/init.php';
include 'layout/head.php';


if(Input::exists()) {

	//$user = new User($dbHandler);
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
		$dbHandler->login(Input::get('email'), Input::get('password'));
	}
} 

if(isset($_SESSION['name'])) {
	include 'layout/header.php'; 
?>

	
	<p><?= $_SESSION['name']?> is logged in.</p>
	
<?php
	$user = $dbHandler->getUser('secretCode', $_SESSION['secretCode']);
	$stubs = $dbHandler->getStubs('links', 'email', '=', $_SESSION['email']);
		
		
		echo "<p>" . $dbHandler->count('links', 'email', '=', '%') . " stubs have been created</p>";

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

	

} else {
	include 'layout/header.php'; 
	echo "<h1>You are not logged in.</h1>";
	
}


	include 'layout/footer.php';

?>
