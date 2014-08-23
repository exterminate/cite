<script src='lib/mustache.js'></script>
<script src="<?php echo $rootURL; ?>lib/jquery.maskedinput.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		
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
	<h1>Never lose the opportunity to share your work</h1>
	<h2>Welcome to Cite</h2>
</div>

<div class="bodytext">
	<p>Want to reference a work that you haven't quite put the finishing touches on yet? Or that seminal paper you will write in five years time after years of groundbreaking research? You can do it easily using Cite.pub!</p>
	<br><br>
	<hr>
	<br>
	<h1>How does it work?</h1>
	<!--
	<ol class='circles-list'>
	  	<li><a href='submit/'>Create a stub</a> on Cite.pub using your Orcid ID</li>
		<li>Cite the unique URL in your publication</li>
	  	<li>Publish your seminal work</li>
	  	<li>Complete your stub with the DOI of the new paper. The original URL will forward readers straight through!</li>
	</ol>
	-->
	
	<div class="parts">
		<div class="part">
			<h3>Create a stub</h3>
			<p>Just give us a title and a description of the work, if you wish. That's all you need!</p>
		</div>
		<div class="part">
			<h3>Cite the unique URL</h3>
			<p>Once you have created a stub we will give you a unique <span class="what" title="website address">URL</span> for it. You can add a citation to in any paper you write.</p>
		</div>
		<div class="part">
			<h3>Publish your seminal work</h3>
			<p>Great, it's finally ready to publish in a top quality journal. We can update other researchers when it's ready.</p>
		</div>
		<div class="part">
			<h3>Complete your stub</h3>
			<p>Tell us the <span class="what" title="Digital Object Identifier">DOI</span> and we will update the <span class="what" title="website address">URL</span> we gave you so that anyone who sees your original citation will be directed to your published work.</p>
		</div>		
	</div>
	
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