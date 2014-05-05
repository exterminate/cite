<?php
require 'classes/Input.php';
require 'classes/Validate.php';
require 'classes/Stub.php';
require 'includes/functions.php';

if(Input::exists()) {

	try {
		$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
		die("sorry, database problem");
	}


	$validate = new Validate();
	$validate->check($_POST, array( 
		'name' => array(
			'required' 	=> true,
			'min' => 2,
			'max' => 50
			), 
		'email' => array(
			'required' 	=> true,
			'max' => 60,
			'email' => true			
			),
		'orcid' => array(
			'required' 	=> true,
			'min' => 16,
			'max' => 20			
			),
		'description' => array(
			'required' 	=> true,
			'min' => 2,
			'max' => 1000
			)
		)
	);

	//if successful then die()
	if($validate->passed()) {
		
		// add to database
		
		try {
			
			$stub = new Stub($handler);
			//add to database
			$deeplinkValidate = $validate->checkDB($handler,create_deeplink(8));
			$stub->addStub(
				$deeplinkValidate,
				trim(escape(Input::get('name'))),
				trim(escape(Input::get('email'))),
				trim(escape(Input::get('orcid'))),
				trim(escape(Input::get('description'))));

			// Send deeplink for email
			// combine deeplink and orcid into md5 


			// Redirect to stub page
			header("Location: ".$deeplinkValidate);
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

//id, linkid, name, email, orcid (required), datesubmitted, doi, datedoi
?>

<form action="" method="post">
	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?php echo Input::get('name'); ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="email">E-mail</label>
		<input type="text" name="email" id="email" value="<?php echo Input::get('email'); ?>">
	</div>

	<div class="field">
		<label for="orcid">ORCID ID</label>
		<input type="text" name="orcid" id="orcid" value="<?php echo Input::get('orcid'); ?>">
	</div>
	<div class="field">
		<label for="description">Describe your work</label>
		<textarea name="description" id="description"><?php echo Input::get('description');?></textarea>
	</div>
	<input type="submit" name="submit" value="Submit">
</form>