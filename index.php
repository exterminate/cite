<?php
require 'core/init.php';




// if there is a deeplink { show stub }
if(isset($_GET['stub']) && !empty($_GET['stub'])) { 

	$stub = $dbHandler->getStub("stubId", $_GET['stub']);

	if($stub == null) { 	// no such stub
		die("This stub does not exist.");		
	} else { // show stub or redirect
		$dbHandler->incrementViews($stub);
		if($stub->doi == ""){
			/*
				no DOI associated with the stub
			*/

		} else{
			/*
				redirect to the DOI indicated
			*/
			header("Location: http://dx.doi.org/".$stub->doi);
		}		

	include 'layout/head.php';
	include 'layout/header.php';
?>
	<script src='lib/mustache.js'></script>
	<script>
		$(document).ready(function(){
			var json = $.parseJSON('<?php echo json_encode($stub, JSON_FORCE_OBJECT); ?>');
		
			var template = 	"<section class='stub'>"+
								"<h3>{{stubTitle}}</h3>"+
								"<ul>"+								
									"<li class='name'>{{firstName}} {{surname}}</li>"+
									"<li class='orcid'>{{orcid}}</li>"+
									"<li class='stubId'>{{stubId}}</li>"+
									"<li class='description'>{{description}}</li>"+
									"<li class='datesubmitted'>{{datesubmitted}}"+
								"</ul>"+
							"</section><br>";
							

			var html = Mustache.to_html(template, json);
			console.log(json);

			$('#display').html(html);
		});
	</script>
	<div id="display">
		
	</div>
	

<?php		
		
	}
	
	
	
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
