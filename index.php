<?php
session_start();
/*
	session_start();
	if(strtotime("now") > $SESSION['time']) {
		// perhaps we need a html (or JS) 60 min refresh
		session_destroy(); // ends session, the author has had 60 mins
	}
	*/

	require 'core/init.php';

	// if there is a deeplink { show stub }
	if(isset($_GET['stub']) && !empty($_GET['stub'])) { 

		$stub = $dbHandler->getStub("stubId", $_GET['stub']);

		if($stub == null) { 	// no such stub
			die("This stub does not exist.");		
		} else { // show stub or redirect
			$dbHandler->incrementViews($stub);		
			include 'layout/head.php';
			include 'layout/header.php';
		}
?>
	<script src='lib/mustache.js'></script>
	<script>
		$(document).ready(function(){
			var stub = $.parseJSON('<?php echo json_encode($stub); ?>');
			console.log(stub);

			var doiURL = "http://dx.doi.org/" + stub.doi;
			
			if(stub.doi !== ""){
				/*
					There is a DOI associated with this stub, so we will wait 5 secs then redirect
				*/

				var timeout = 5000;
				setTimeout(function(){
					window.location = doiURL;
				}, timeout);

				var remainingTime = 5;
				var message = "Thank you for visiting! This stub has been completed and you will be redirected in ";
				$('#display').append("<div>If you are not redirected automatically, please click on the stub!</div>");
				$('#message').html(message + remainingTime);

				setInterval(function(){
					$('#message').html(message + --remainingTime);					
				}, 1000)

				/*
					Bind a click event to the stub for manual redirect
				*/
				$('#display').click(function(){
					window.location = doiURL;
				});
			} else{
				$('#editForm').fadeIn(500);
				$('#editButton').click(function(){
					$('#emailLabel').fadeIn(500);
				});
				
				$('#showInterestedFormButton').fadeIn(500);
			}

			/*
				Get the Mustache template from file and apply it
			*/
			$.get("templates/indexStub.mustache.html", function(template){
					$('#display').append(Mustache.to_html(template, stub));
			})
			.fail(function(a,b,c){
				console.log("Failed to load Mustache template, " + a.responseText);
			});						

			$('#showInterestedFormButton').click(function(){
				$('#registerInterestForm').fadeIn(500);
			});
			
			$('#registerInterestButton').click(function(){
				var registerInterest = $.post('registerInterest.php', {stubId : stub.stubId, interestedEmail: $('#interestedInput').val()});
				registerInterest.done(function(data){
					/*
					 * See JsonFactory::success() for the correct JSON form
					 */
					if (data.success) {
						console.log(data.message)
					} else{
						console.log(data.message);//data.errorMsg
					}					
				});
				registerInterest.fail(function(jqXhr){
					console.log("Error contacting server: " + jqXhr.responseText);
				});
			});
		});
	</script>
	<div id="display">
		<div id='message'></div>
	</div>
			
	<button type='button' id='showInterestedFormButton' hidden>This idea looks like it has potential!</button>
	<form id='registerInterestForm' hidden>
		<label>Get notified via email when the final article is published
			<input type='email' id='interestedInput' placeholder='Enter your email address'>
			<button type='button' id='registerInterestButton'>Alert me!</button>
		</label>						
	</form>
	

<?php		
	
	}
	// else if there is no deeplink { show homepage }
	else {
		include 'layout/head.php';
		include 'layout/header.php';
		if(isset($_SESSION['error'])) {
			echo "<p class='errorMessage'>".$_SESSION['error']."</p>";
			unset($_SESSION['error']);
		}
		include 'layout/homepage.php';
	}

	include 'layout/footer.php';

?>
