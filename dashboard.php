<?php
session_start();
require 'core/init.php';
include 'layout/head.php';


if($_SESSION['login']->isLoggedIn()) { 


	include 'layout/header.php';	
	$user = $dbHandler->getUser('email', $_SESSION['email']);	
	$stubs = $dbHandler->getStubs('links', 'email', '=', $_SESSION['email']);	
	echo "<p>You have created " . $dbHandler->count('links', 'email', '=', $_SESSION['email']) . " stubs.</p>";	
?>
	
	<script src='lib/mustache.js'></script>
	<script>
		//display the users stubs as loaded from the database
		
		var user = $.parseJSON('<?php echo json_encode($user); ?>');
		console.log("user: ");
		console.log(user);	
		
		function displayStubs(){			
			//var stubs = $.parseJSON('<?php echo json_encode($stubs); ?>');
			
			var post = $.post('searchSQL.php', {query : user.email, type : 'email'});
			post.done(function(stubs){
				stubs = stubs.reverse();
				console.log(stubs);
				$.get('templates/dashboardStub.mustache.html', function(template){
					$('#content').html(Mustache.to_html(template, {stubs: stubs}));	
				});
				console.log('display stubs');				
			});
		}
		
		displayStubs();		
		
		$(document).ready(function(){
			$('#createNewStubButton').click(function(){			
				$('#newStub').fadeIn(500);
				$(this).fadeOut(500);
			});
			
			$('#submitStubButton').click(function(){				
				var post = $.post('submit.php',
						{
							title: $('#title').val(),
							description: $('#description').val(),
							user: user
						}
				);
				
				post.done(function(data){
					console.log(data.message);
					$('#newStub').fadeOut(500);
					$('#createNewStubButton').fadeIn(500);
					setTimeout(displayStubs, 1000);					
				});
				post.fail(function(jqXhr){
					console.log(jqXhr.responseText);
				});
			});
			
			$('#cancelButton').click(function(){
				clearForm();
				$('#newStub').fadeOut(500);
			});
		});
		
		function clearForm() {
			$('.input').val("");
		}
			
		
	</script>
	<p><?php echo $_SESSION['name']; ?> is logged in.</p>
	<button id='createNewStubButton'>Create New</button>
	<div id='newStub' class='dashboard' hidden>
		<form method="POST">
			<label>Title: </label><br>
			<input id='title' class='input' type='text'><br>
			<label>Description: </label><br>
			<textarea id='description' class='input'></textarea><br>
			
			<button id='submitStubButton'>Submit</button>
			<button id='cancelButton'>Cancel</button>
		</form>
	</div>
	
	<div id='content'></div>
	
<?php	
	
} else {
	include 'layout/header.php'; 
	echo "<h1>You are not logged in.</h1>";	
}

include 'layout/footer.php';

?>


