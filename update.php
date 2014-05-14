<?php

require 'core/init.php';

$URL = "/git/cite/";

if(isset($_GET['stub'])) {
	$deepLink = $_GET['stub'];
} else {
	die("Nothing to update here...");
}

if(Input::exists()) {
	$validate = new Validate();
	$validate->check($_POST, array( 
		'deeplink' => array(
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
		'unique_code' => array(
			'required' 	=> true,
			'min' => 12,
			'max' => 12	
			)
		)
	);

	if($validate->passed()) {
		
		// add to database
		
		try {
			
			$stub = new Stub($handler);
			// update databse
			
			$stub->addStub(
				$deeplinkValidate,
				trim(escape(Input::get('name'))),
				trim(escape(Input::get('email'))),
				trim(escape(Input::get('orcid'))),
				trim(escape(Input::get('description'))),
				$uniquecode);

			// Send "You have updated you stub it will now redirect to your article"
			
			$from = "citeitnow@gmail.com"; // sender
		    $subject = "Stub submitted successfully";
		    $message = "Thank you for submitting your stub.\nTo add a DOI at a later date please save this email and click the link when ready.\n
		    <a href='http://localhost/git/cite/update.php'>http://localhost/git/cite/update/" . $deeplink . "</a>\n
		    When you are prompted, add your DOI and this unique code to update: " . $uniquecode . "\n";
		    
		    // send mail
		    if(!mail(trim(escape(Input::get('email'))),$subject,$message,"From: $from\n")) {
		    	echo "Mail fail!";
		    }

			// Redirect to stub page
			header("Location: ". $URL.$deeplinkValidate);
			exit();

			
		} catch(Exception $e) {
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
						<td><label for="deeplink">Stub ID</label></td>
						<td><input class="input" type="text" name="deeplink" id="deeplink" value="<?php echo $deepLink; ?>" autocomplete="off"></td>
						<td><img height='32'/></td>
					</tr>
					<tr>
						<td><label for="doi">Enter DOI</label></td>
						<td><input class="input" type="text" name="doi" id="doi" value="<?php echo Input::get('doi'); ?>"></td>
						<td><img height='32'/></td>
					</tr>
					<tr>
						<td><label for="unique_code">Enter unique code</label></td>
						<td><input class="input" type="text" name="unique_code" id="unique_code" value="<?php echo Input::get('unique_code'); ?>"></td>
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