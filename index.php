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

			var doiURL = "http://dx.doi.org/" + json.doi;

			$('#display').on('click', '.stub', function(){
				window.location = doiURL;
			});

			if(json.doi !== null){
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
			} 
		
		
			var template = 	"<section class='stub'>"+
								"<h3>{{stubTitle}}</h3>"+
								"<ul>"+								
									"<li class='name'>{{firstName}} {{surname}}</li>"+
									"<li class='orcid'>{{orcid}}</li>"+
									"<li class='stubId'>{{stubId}}</li>"+
									"<li class='description'>{{description}}</li>"+
									"<li class='datesubmitted'>{{datesubmitted}}</li>"+
									"{{#doi}}<li class='doi'>{{doi}}</li>{{/doi}}"+
									"{{#datedoi}}<li class='datedoi'>{{datedoi}}</li>{{/datedoi}}"+
								"</ul>"+
							"</section><br>";
							

			var html = Mustache.to_html(template, json);
			console.log(json);

			$('#display').append(html);
		});
	</script>
	<div id="display">
		<div id='message'></div>
	</div>
	

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
