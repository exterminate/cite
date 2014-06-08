<?php
    require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
    PhpConsole\Helper::register();
require 'core/init.php';

if(isset($_GET['stub'])) {
	$stubId = $_GET['stub'];
} else {
	die("Nothing to update here...");
}

if(Input::exists()) {
	$validate = new Validate();
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
			
			$stub = new Stub($dbHandler->getStub('stubId', $_GET['stub']));
			PC::debug($stub);
			// update databse

			if(!strlen($stub->doi) > 0) { // does this stub already have a DOI?

				//does the deeplink match with the one in the database
				if(trim(escape(Input::get('doi'))) == $stub->deepLink) {

					$stub->doi = trim(escape(Input::get('doi')));
					$stub->datedoi = date('Y-m-d H:i:s');
					$dbHandler->change('links', $stub);

					// send mail
					require 'classes/EmailHandler.php';
					$email = new EmailHandler();
					$email->sendMail(
						$stub->email, // send to
					    "Stub submitted updated",
					    "Thank you for updating your stub.\nClicking on ".$rootURL.trim(escape(Input::get('stubId'))). " will send you to your article\nWe look forward to your next submission.\n"
				    );
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


include 'layout/head.php';
include 'layout/header.php';

?>

<div class='mainContent'>
			<form action="" method="post">
				<table>
					<tr>
						<td><label for="stubId">Stub ID</label></td>
						<td><input class="input" type="text" name="stubId" id="stubId" value="<?php echo $stubId; ?>" autocomplete="off"></td>
						<td><img height='32'/></td>
					</tr>
					<tr>
						<td><label for="doi">Enter DOI</label></td>
						<td><input class="input" type="text" name="doi" id="doi" value="<?php echo Input::get('doi'); ?>"></td>
						<td><img height='32'/></td>
					</tr>
					<tr>
						<td><label for="deepLink">Enter unique code</label></td>
						<td><input class="input" type="text" name="deepLink" id="deepLink" value="<?php echo Input::get('deepLink'); ?>"></td>
						<td><img height='32'/></td>
					</tr>
					<tr>
						<td colspan='2'><center><input type="submit" name="submit" id="submit" value="Submit"></center></td>
					</tr>
				</table>
			</form>
		</div>
		<!-- Do we need this on this form? :Ian <div id='orcidOut'></div>-->
<?php
include 'layout/footer.php';
?>