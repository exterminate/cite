<?php
require 'core/init.php';

$URL = "/git/cite/";


if(Input::exists()) {

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

	
	if($validate->passed()) {
		
		// add to database
		
		try {
			
			$stub = new Stub($handler);
			//add to database
			$deeplinkValidate = $validate->checkDB($handler,create_deeplink(8));
			$uniquecode = $validate->checkDB($handler,create_deeplink(12));
			$stub->addStub(
				$deeplinkValidate,
				trim(escape(Input::get('name'))),
				trim(escape(Input::get('email'))),
				trim(escape(Input::get('orcid'))),
				trim(escape(Input::get('description'))),
				$uniquecode);

			// Send deeplink for email
			
			$from = "citeitnow@gmail.com"; // sender
		    $subject = "Stub submitted successfully";
		    $message = "Thank you for submitting your stub.\nTo add a DOI at a later date please save this email and click the link when ready.\nhttp://localhost/git/cite/update/" . $deeplinkValidate . "\nWhen you are prompted, add your DOI and this unique code to update: " . $uniquecode . "\nYou can check your DOI is valid by going to http://dx.doi.org/[your DOI]";
		    
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

//id, linkid, name, email, orcid (required), datesubmitted, doi, datedoi


include 'layout/head.php';
include 'layout/header.php';
?>
	<script src="lib/jquery.maskedinput.js" type="text/javascript"></script>
		<script>

			$(document).ready(function(){			
				$('#orcid').mask("9999-9999-9999-9999", {placeholder : ".", completed: function(){
					searchOrcid(this.val());
				}});
				$('#orcidValidateButton').click(function(){
					searchOrcid($('#orcid').val());
				});

			});
			
			function searchOrcid(id){
				$.post("classes/OrcidId.php", {id : id}, function(data){
					if(data['error'] != undefined){
						alert(data['error']);
					} else{
						$('#name').val(data.name);
						$('#email').val(data.email);
					}
				}).fail(function(x,s,e){
						alert("Error retrieving data from server: " + s + e);
				});
			}
			/*
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
	*/
		</script>

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
		<button id='orcidValidateButton'>Fill from Orcid Profile</button>
		<div id=out></div>
<?php
include 'layout/footer.php';
?>
