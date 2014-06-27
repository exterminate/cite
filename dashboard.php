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
		function displayStubs(){
		var stubs = $.parseJSON('<?php echo json_encode($stubs); ?>');
		console.log("Stubs:");
		console.log(stubs);
			
		
			$.get('templates/dashboardStub.mustache.html', function(template){
				$('#content').html(Mustache.to_html(template, {stubs: stubs}));	
			});
		}
		
		displayStubs();
	</script>
	<script>
		var user = $.parseJSON('<?php echo json_encode($user); ?>');
		console.log("user: ");
		console.log(user);
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
				});
				post.fail(function(jqXhr){
					console.log(jqXhr.responseText);
				});
			});
		});
			
		
	</script>
	<p><?php echo $_SESSION['name']; ?> is logged in.</p>
	<button id='createNewStubButton'>Create New</button>
	<div id='newStub' class='dashboard' hidden>
		<p><label>Title: </label><input id='title' type='text'></p>
		<p><label>Description: </label>
			<textarea id='description'></textarea>
		</p>
		<button id='submitStubButton'>Submit</button>
	</div>
	
	<div id='content'></div>
	
<?php	
	
} else {
	include 'layout/header.php'; 
	echo "<h1>You are not logged in.</h1>";	
}

include 'layout/footer.php';

?>


