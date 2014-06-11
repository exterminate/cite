<?php
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
			var json = $.parseJSON('<?php echo json_encode($stub, JSON_FORCE_OBJECT); ?>');
			console.log(json);

			var doiURL = "http://dx.doi.org/" + json.doi;

			

			if(json.doi !== ""){
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
				$('#display').on('click', '.stub', function(){
					window.location = doiURL;
				});
			} 

			/*
				Get the Mustache template from file and apply it
			*/
				$.get("templates/stub.mustache.html", function(template){				
						$('#display').append(Mustache.to_html(template, json));
				})
				.fail(function(a,b,c){
					console.log("Failed to load Mustache template, " + a.responseText);
				});		

				$('#editButton').click(function(){
					$('#emailLabel').fadeIn(500);
				});

				$('#emailButton').click(function(){	
					$.post('edit.php', {stubEmail: json.email, inputEmail : $('emailInput').val()}, function(data){
						if(data.emailValid == 'true'){
							$('#codeLabel').fadeIn(500);
							console.log('Email is valid, sending code!');
						} else{
							console.log("No stubs with that email address!");
						}
					})
					.fail(function(jqXhr, b, c){
						console.log("Failed to retrieve data from server: " + jqXhr.responseText);
					});
				});

				$('#codeButton').click(function(){
					$.post('edit.php', {code : $('#codeInput').val()}, function(data){
						if(data.login == 'true'){
							//start editing the stub
							console.log('Code accepted, start editing the stub');
						} else{
							console.log("Code is incorrect!");
						}
					})
					.fail(jqXhr, b, c){
						console.log("Failed to receive data from server: " + jqXhr.responseText)
					}

				});


		});
	</script>
	<div id="display">
		<div id='message'></div>
	</div>

	<form id='editForm' hidden>
		<button type='button' id='editButton'>Edit</button>
		<label id='emailLabel' hidden>
			<input type='email' id='emailInput'>
			<button type='button' id='emailButton'>Get code</button>
		</label>
		<label id='codeLabel' hidden>
			<input type='text' id='codeInput'>
			<button type='button' id='codeButton'>Submit code</button>
		</label>
	</form>

<?php		
	
	}
	// else if there is no deeplink { show homepage }
	else {
		include 'layout/head.php';
		include 'layout/header.php';
		include 'layout/homepage.php';
		echo '<a href="submit/">Submit</a>';
	}



include 'layout/footer.php';

?>
