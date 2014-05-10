<?php
require 'classes/Input.php';
require 'classes/Validate.php';
require 'classes/Stub.php';
require 'includes/functions.php';

include 'layout/head.php';
include 'layout/header.php';

if(Input::exists()) {

	try {
		$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', '');
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
<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>

			$(document).ready(function(){
			
				$("#submit").attr("disabled", true);
					
					var valid = [false, false, false, false];
				
					$(".input").blur(function(e){
					
						var currentValid = false;
						if($(e.target).attr("id") == "name"){
							//check if name is valid
							
							if($(e.target).val() != ""){
								valid[0] = true;
								currentValid = true;
							} else{
								valid[0] = false;
								currentValid = false;
							}
						}
						else if($(e.target).attr("id") == "email"){
							//check if email is valid

							if(isValidEmailAddress($(e.target).val())){
								valid[1] = true;
								currentValid = true;
							} else{
								valid[1] = false;
								currentValid = false;
							}
						} else if($(e.target).attr("id") == "orcid"){
							//check if orcid id is valid
							if($(e.target).val().length == 16){
								valid[2] = true;
								currentValid = true;
							} else{
								valid[2] = false;
								currentValid = false;
							}
						} else if($(e.target).attr("id") == "description"){
							if($(e.target).val().length >= 2){
								valid[3] = true;
								currentValid = true;
							} else{
								valid[3] = false;
								currentValid = false;
							}
						}
						
						if(currentValid){
							$(e.target).parents("tr").find("img").attr("src", "img/tick.png");
						} else{
							$(e.target).parents("tr").find("img").attr("src", "img/cross.png");
						}
						
						checkSubmitButton();
					});
					
					function checkSubmitButton(){
					
						var enabled = true;
					
					for(var i = 0; i < 4; i++){
						if(!valid[i]){
							enabled = false;
						}
					}
					
					if(enabled){
						$("#submit").attr("disabled", false);
					} else {
						$("#submit").attr("disabled", true);
					}
				}
			});
			
			
			
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	};
		</script>
	</head>
	<body>
		<div class='mainContent'>
			<form action="" method="post">
				<table>
					<tr>
						<td><label for="name">Name</label></td>
						<td><input class="input" type="text" name="name" id="name" value="<?php echo Input::get('name'); ?>" autocomplete="off"></td>
						<td><img height='32'/></td>
					</tr>


					<tr>
						<td><label for="email">E-mail</label></td>
						<td><input class="input" type="text" name="email" id="email" value="<?php echo Input::get('email'); ?>"></td>
						<td><img height='32'/></td>
					</tr>

					<tr>
						<td><label for="orcid">ORCID ID</label></td>
						<td><input class="input" type="text" name="orcid" id="orcid" value="<?php echo Input::get('orcid'); ?>"></td>
						<td><img height='32'/></td>
					</tr>
					
					<tr>
						<td><label for="description">Describe your work</label></td>
						<td><textarea class="input" name="description" id="description"><?php echo Input::get('description');?></textarea></td>
						<td><img height='32'/></td>
					</tr>
					<tr>
						<td colspan='2'><center><input type="submit" name="submit" id="submit" value="Submit"></center></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
