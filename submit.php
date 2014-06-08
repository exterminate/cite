<?php
    require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
    PhpConsole\Helper::register();
require 'core/init.php';

$URL = "/cite/";


if(Input::exists()) {

	$validate = new Validate();
	$validate->check($_POST, array( 
		'stubTitle' => array(
				'required' => true,
				'min' => 10,
				'max' => 140
			),
		'firstName' => array(
			'required' 	=> true,
			'min' => 2,
			'max' => 50
			), 
		'surname' => array(
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

		$inputArray = array(
				'stubId' => $dbHandler->getUniqueCode('stubId'),
				'stubTitle' => Input::get('stubTitle'),
				'firstName' => Input::get('firstName'),
				'surname' => Input::get('surname'),
				'email' => Input::get('email'),
				'orcid' => Input::get('orcid'),
				'description' => Input::get('description'),
				'deepLink' => $dbHandler->getUniqueCode('deepLink'),
				'datesubmitted' => date('Y-m-d H:i:s')			
			);

		$stub = new Stub($inputArray);

		// add to database
		
		try {

			//add to database			
			$dbHandler->put('links', $stub);

			// Send deeplink for email
			require 'classes/EmailHandler.php';
			$email = new EmailHandler();
			$email->sendMail(
				trim(escape(Input::get('email'))),
				"Stub submitted successfully",
				"Thank you for submitting your stub.\nTo add a DOI at a later date please save this email and click the link when ready.\nhttp://localhost/git/cite/update/" . $stub->stubId . "\nWhen you are prompted, add your DOI and this unique code to update: " . $stub->deepLink . "\nYou can check your DOI is valid by going to http://dx.doi.org/[your-DOI]"
				);
			
			
			// Redirect to stub page
			header("Location: ". $rootURL.$stub->stubId);
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
	<script src="<?php echo $rootURL; ?>lib/jquery.maskedinput.js" type="text/javascript"></script>	
		<script>

			$(document).ready(function(){

				clearDetails();

				$('#clearButton').click(function(){
					clearDetails();
				});

				$('#orcid').mask("9999-9999-9999-9999", {placeholder : ".", completed: function(){
					
					searchOrcid(this.val(), 'orcid');
				}});

				//this button is disabled as the search currently returns poor results
				$('#getOrcidByNameButton').click(function(){
					var firstName = $('#firstName').val();
					var surname = $('#surname').val();
					if(firstName != "" && surname != ""){
						searchOrcid(firstName + " " + surname, 'name');
					}
				});

				$('#getOrcidByIdButton').click(function(){
					var orcid = $('#orcid').val()
					if(orcid != ""){
						searchOrcid(orcid, 'orcid');
					}
				});

				$('#getOrcidByEmailButton').click(function(){
					var email = $('#email').val();
					if(isValidEmailAddress(email)){
						searchOrcid( email, 'email');
					} else{	
						displaySearchError("show", "Please enter a valid email address!");
					}
				});


				$('#orcidSelect').change(function(){
                    var key = $('#orcidSelect').val();
                    $('#firstName').val(searchResults[key].firstName);
                    $('#surname').val(searchResults[key].surname);

                    var email = searchResults[key].email;
                    if(email == ""){
                    	$('#email').val('');
						$('#email').attr('placeholder', "Email set to private");
                    } else{
                    	$('#email').val(searchResults[key].email);
                	}
                  
                    $('#orcid').val(searchResults[key].id);
                });
                
                $('#clear').click(function(){
                    clearDetails();
                    $('#input').val("");
                });

			});

			function isValidEmailAddress(emailAddress) {
			    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
			    return pattern.test(emailAddress);
			};

			function clearDetails(){
				$('#stubTitle').val("");
                $('#name').val("");
                $('#email').val("");
                $('#orcid').val("");
                $('#orcidSelect').find("option").remove();
                $('#orcidSelect').hide(200);
                $('#error').hide(200);
               	displaySearchError("hide");
            }

            function displaySearchError(visible, text){
            	if(text !== undefined){
            		$('#searchErr').html(text);
            	}
            	if(visible == "show"){
                	$('#searchErr').css('opacity', '1');
				} else if (visible == "hide"){
					$('#searchErr').css('opacity', '0');
				}
            }

            var privateMsg = "Is the email address in your Orcid profile set to private?";
			
			function searchOrcid(query, type){			

           		$.post("<?php echo $rootURL; ?>orcid/searchOrcid.php", {query : query, type : type}, function(data){
                    //console.log(JSON.stringify(data));
                    searchResults = data.searchResults;
                    

                    if(data.error !== undefined){
                    	//php script returns an error (i.e. no search hits returned)
                        displaySearchError("show", data.error + "<br/>" + privateMsg);
                        $('#error').html(data.error).show(200);
                        $('#orcidSelect').hide(200);
                    } else if(searchResults[0] == null){
                    	//(defensive) php script has returned a blank array (should never happen)
                    	alert("This is an non-critical error," + 
                    		" no search results were found from your query but"+
                    		"something has gone wrong behind the scenes! Sorry!");                        
                    } else{
                    	displaySearchError("hide");                    	
                        if(Object.keys(searchResults).length == 1){                        	
                        	$('#firstName').val(searchResults[0].firstName);
                        	$('#surname').val(searchResults[0].surname);
                        	$('#orcid').val(searchResults[0].id);
                            if(searchResults[0].email === null){
                            	displaySearchError("show", "We could not find an email associated with this Orcid ID."+ "<br/>" + privateMsg);
                            } else{
                            	$('#email').val(searchResults[0].email);
                            }
                        } else{
                        
                            $('#orcidSelect').show(200);
                                
                            $.each(searchResults, function(key, val){
                                $('#orcidSelect')
                                    .append($("<option></option>")
                                    .attr("value", key)
                                    .text(val.firstName + " " + val.surname));
                            });
                        }
                    }
                })
	            .fail(function(a, b, c){
	                displaySearchError("show", "Error contacting server, please try again, " + a.responseText + ", " + b + ", " + c);	               
	            });
            }
			

		</script>

		<div class='mainContent'>		
			<form action="" method="post">	
				<label>Stub Title:
					<input class='input' type='text' name='stubTitle' id='stubTitle' value="<?php echo Input::get('stubTitle'); ?>" autocomplete="off" required>
				</label>
				<br/>
				<label for="firstName">First Name
					<input class="input" type="text" name="firstName" id="firstName" value="<?php echo Input::get('firstName'); ?>" autocomplete="off" required>										
				</label>
				<br/>
				<label>Surname
					<input class='input' type='text' name='surname' id='surname' value='<?php echo Input::get("surname"); ?>' autocomplete="off" required>
				</label>
					<button type='button' id='getOrcidByNameButton' disabled hidden>Search Orcid by name</button>
				<br/>
		
				<label for="email">E-mail
					<input class="input" type="email" name="email" id="email" value="<?php echo Input::get('email'); ?>" required>						
					<button type='button' id='getOrcidByEmailButton'>Search Orcid by email</button>					
				</label>
				<br/>
			
				<label for="orcid">ORCID ID
					<input class="input" type="text" name="orcid" id="orcid" value="<?php echo Input::get('orcid'); ?>" required>						
					<button type='button' id='getOrcidByIdButton'>Search Orcid by ID</button>
				</label>
				<br/>
				<label>
					<select id="orcidSelect" size='10' hidden></select>
				</label>
				<div id='searchErr' class='error'></div>
				<br/>
			
				<label for="description">Describe your work<br/>
					<textarea class="input" name="description" id="description" required><?php echo Input::get('description');?></textarea>						
				</label>
				<br/>
			
				<input type="submit" name="submit" id="submit" value="Submit">
				<button type="button" id='clearButton'>Clear</button>
			</form>
		</div>		
		<div id=out></div>
<?php
include 'layout/footer.php';
?>
