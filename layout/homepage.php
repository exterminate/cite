<script src='lib/mustache.js'></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/jquery.slick/1.3.6/slick.css"/>
<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.slick/1.3.6/slick.min.js"/></script>
<script src="<?php echo $rootURL; ?>lib/jquery.maskedinput.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		var json = $.parseJSON('<?php echo json_encode($dbHandler->getRecentStubs("links", 10), JSON_FORCE_OBJECT); ?>');

		length = Object.keys(json).length;
		var outputElement = $('#recentStubs');

		$.get("templates/stub.mustache.html", function(template){			
			for(var i = 0; i < length; i++){
				$(outputElement).append(Mustache.to_html(template, json[i]));
			}
			$('#recentStubs').slick({
				dots: true,
				arrows: true,
				speed: 500,
				autoplay: true,
 				autoplaySpeed: 5000,
 				slidesToShow: 3
			});

		})
		.fail(function(a,b,c){
			console.log("Failed to load Mustache template, " + a.responseText);
		});
		
		$('#orcid').mask("9999-9999-9999-9999",{placeholder : "."});
		
		var validOrcid = false, validPass1 = false, validPass2 = false;
		$('#orcid').blur(function(){
			if($(this).val() != ""){
				$('#orcidLbl').find('.err').html('&#10003');
				validOrcid = true;
			} else{
				$('#orcidLbl').find('.err').html('Please enter a 16 digit OrcID.');
				validOrcid = false;
			}			
		});
		
		$('#password1').blur(function(){			
			if($(this).val().length < 6){
				$('#pass1Lbl').find('.err').html("Password must be at least 6 characters long!");
				validPass1= false;
			} else{
				$('#pass1Lbl').find('.err').html('&#10003');
				validPass1 = true;
			}
		});
		
		$('#password2').blur(function(){
			if ($('#password1').val().length < 6) {
				$('#pass1Lbl').find('.err').html("Password must be at least 6 characters long!");
				validPass1 = false;
			} else{
				if ($('#password1').val() != $('#password2').val()) {				
					$('#pass2Lbl').find('.err').html("Passwords don't match!");
					validPass2 = false;
				} else{
					$('#pass2Lbl').find('.err').html('&#10003');
					$('#pass1Lbl').find('.err').html('&#10003');
					validPass1 = true;
					validPass2 = true;
				}				
			}
		});		
		
		$('#getStartedButton').click(function(evt){				
			
			if (!(validOrcid && validPass1 && validPass2)) {			
				alert("Error");
				evt.preventDefault();
			}			
		});
	});	
</script>


<div class="welcome">
	<h1>Welcome to Cite</h1>
	<h2>Never lose the opportunity to share your work</h2>
</div>

<div class="bodytext">
	<p>Want to reference a work that you haven't quite put the finishing touches on yet? Or that seminal paper you will write in five years time after years of groundbreaking research? You can do it easily using Cite.pub!</p>
	<br>
	<ol class='circles-list'>
	  	<li><a href='submit/'>Create a stub</a> on Cite.pub using your Orcid ID</li>
		<li>Cite the unique URL in your publication</li>
	  	<li>Publish your seminal work</li>
	  	<li>Complete your stub with the DOI of the new paper. The original URL will forward readers straight through!</li>
	</ol>
	
	<div id="register" class='getStarted'>
	<h2>Get started now!</h2>
		<form action='register.php' method='post'>
			<label id='orcidLbl'><span>Enter your OrcID:</span>
				<input id='orcid' name='orcid' type='text'>				
				<span class='err'></span>
				Don't have and OrcID? <a href='http://orcid.org'>Get one here!</a>
			</label><br><br>	
			<label id='pass1Lbl'><span>Create a password:</span>
				<input id='password1' name='password' type='password'>
				<span class='err'></span>
			</label><br><br>
			<label id='pass2Lbl'>
				<span>Re-type your password:</span>
				<input id='password2' type='password'>
				<span class='err'></span>
			</label><br><br>
			<input id='getStartedButton' type='submit' value='Get started!'>
		</form>
	</div>
</div>
<div id='recentStubs'>
	Recently Submitted:<br>
</div>
