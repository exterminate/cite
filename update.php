<?php
session_start();
    require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
    PhpConsole\Helper::register();
require 'core/init.php';

if(isset($_GET['stub'])) {
	$stubId = $_GET['stub'];
} else {
	die("Nothing to update here...");
}

include 'layout/head.php';
include 'layout/header.php';

$validate = new Validate();

if(isset($_POST['login'])) {
	$validate->check($_POST, array( 
		'email' => array(
			'required' => true,
			'max' => 60,
			'email' => true			
			),
		'deepLink' => array(
			'required' 	=> true,
			'min' => 12,
			'max' => 12	
			)
		)
	);
	if($validate->passed()) {
		// if good let's start a sesson
		require 'classes/author.php';
		$author = new Author(Input::get('email'),Input::get('deepLink'), $dbHandler);
		$author->createLoginSession();
	}
}

if(isset($_SESSION['username'])) {

	if(Input::exists()) {
		
		$validate->check($_POST, array( 
			'stubId' => array(
				'required' 	=> true,
				'min' => 8,
				'max' => 8
				), 
			'doi' => array(
				'required' 	=> true,
				'max' => 50,
				'min' => 10,
				'doi' => true			
				),
			'deepLink' => array(
				'required' 	=> true,
				'min' => 12,
				'max' => 12	
				)
			)
		);
	
		if($validate->passed()) {
			
			// add to database
			
			try {
				
				$stub = $dbHandler->getStub('stubId', Input::get('stubId'));
				
				// update databse
	
				if(!strlen($stub->doi) > 0) { // does this stub already have a DOI?
	
					//does the deeplink match with the one in the database
					if(trim(escape(Input::get('deepLink'))) == $stub->deepLink) {
	
						$stub->doi = trim(escape(Input::get('doi')));
						$stub->datedoi = date('Y-m-d H:i:s');
						$dbHandler->update('links', 'doi', $stub);
						$dbHandler->update('links', 'datedoi', $stub);
				
						// send mail
						require 'classes/EmailHandler.php';
						$email = new EmailHandler();
						$email->sendMail(
							$stub->email, // send to
						    "Stub submitted updated",
						    "Thank you for updating your stub.\nClicking on ".$rootURL.trim(escape(Input::get('stubId'))). " will send you to your article\nWe look forward to your next submission.\n"
					    );
					} else {
						echo "error 1";
					}
				    
	
					// Redirect to stub page
					header("Location: ". $rootURL.trim(escape(Input::get('stubId'))));
					exit();
				} else {
					die("There's aready a DOI for this stub!");
				}
	
				
			} catch(Exception $e) {
				echo "error here";
				die($e->getMessage());
			}
		} else {  
			foreach($validate->errors() as $error) {
				echo $error . "<br>";
			}
		}
	
	
	}

	// display stub to edit
	$stub = $dbHandler->getStub('stubId', Input::get('stubId'));
	echo "<p>Currently editing " . $stub->stubId . " by " . $stub->firstName . " " . $stub->surname . "</p>";
	echo "<p>You are logged in for X more minutes.</p>";
?>	


	<form action="" method="post">
		<table>
			<tr>
				<td><label for="stubTitle">Stub title</label></td>
				<td><input class="input" type="text" name="stubTitle" id="stubTitle" value="<?php echo $stub->stubTitle; ?>" autocomplete="off"></td>
				<td><img height='32'/></td>
			</tr>
			<tr>
				<td><label for="doi">DOI</label></td>
				<td><input class="input" type="text" name="doi" id="doi" value="<?php echo $stub->doi; ?>"></td>
				<td><img height='32'/></td>
			</tr>
			<tr>
				<td><label for="description">Description</label></td>
				<td><textarea class="input" name="description" id="description"><?php echo $stub->description; ?></textarea></td>
				<td><img height='32'/></td>
			</tr>
			<tr>
				<td colspan='2'><center><input type="submit" name="submit" id="submit" value="Update"></center></td>
			</tr>
		</table>
	</form>

<?php

} else {

	include 'layout/authorlogin.php'; // gets login form

}


?>

<div class='mainContent'> <!-- probably needs to wrapped around the page -->
</div>
	
<?php
include 'layout/footer.php';
?>
