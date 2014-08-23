<?php
session_start();
require 'core/init.php';
include 'layout/head.php';


if($_SESSION['login']->isLoggedIn()) { 
	include 'layout/header.php';		
?>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
	<script src='lib/mustache.js'></script>
	<script>
		//display the users stubs as loaded from the database	
		
		var userPost = $.post('searchUsers.php', {public : 'true'});
		
		var user = "";
			
		userPost.done(function(data){				
			user = data;
			console.log("user: ");
			console.log(user);
			displayStubs();	
		});

		function displayStubs(){
			var post = $.post('searchStubs.php', {query : user.email, type : 'email'});
			post.done(function(stubs){				
				if (stubs.message == null) {
					/*
					 *	We've found some stubs for this user, lets display them
					 */
					var length = Object.keys(stubs).length;
					var wordEnding = "";
					if (length > 1) {
						wordEnding = "s";
					}
					$('#count').html("You have created " + length + " stub"+wordEnding);
					stubs = stubs.reverse();
					console.log(stubs);
					$.get('templates/dashboardStub.mustache.html', function(template){
						$('#content').html(Mustache.to_html(template, {stubs: stubs}));	
					});
				} else{
					/*
					 *	This poor user has no stubs yet, lets point them in the right direction
					 */
					$('#content').html("You haven't created any stubs yet. Why not <a id='getStartedLink' href='#'>get started?</a>");
				}				
											
			});
		}
		
		$(document).ready(function(){		

			$('#content').on('click', '#getStartedLink', function(){
				$('#createNewStubButton').trigger('click');	
			});
			
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
					});
				
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
				resetForm();
				
			});
			
			
		});
		
		function resetForm() {
			$('.input').val("");
			$('#newStub').fadeOut(500);
			$('#createNewStubButton').fadeIn(500);
		}
		
		var editing = null;
		function editStub(stubId){				
			var stub = $('#stub'+stubId);
			
			if (editing == null) {
				
				console.log("Editing " + stubId);
				
				var editButton = stub.find('.control').find('.editButton');
				editButton.text("Finish editing and save").attr('id', 'saveEdit');
				
				var editable = [stub.find('.title').find('span'),
						stub.find('.doi').find('span'),
						stub.find('.description').find('span')];
				
				$.each(editable.reverse(), function(i, element){
					$(element)
						.attr('contenteditable', true)
						.animate({backgroundColor: '#ffff00'}, 'slow')
						.animate({backgroundColor: '#ffffff'}, 'slow')
						.focus();
				});
				
				editing = stubId;
			} else if(editing == stubId){
				finishEditing(stub);			
			} else{
				console.log("Edit button for " + stubId + "clicked, but already editing stub " + editing + "!");
				alert("You can only edit one stub at a time!\nFinish editing stub " + editing + " first");	
			}			
		}
		
		function finishEditing(stub){
			var stubId = stub.find('.stubId').find('span').text();
			
			var editable = [stub.find('.title').find('span'),
					stub.find('.doi').find('span'),
					stub.find('.description').find('span')];
			
			$.each(editable, function(i, element){
					$(element)
						.attr('contenteditable', false)	
						.animate({backgroundColor: '#eee'}, 'slow');
						
				});
			
			stub.find('.control').find('.editButton').text("Edit");
			console.log("Finished editing " + stubId);
			editing = null;
			
			var editedTitle = editable[0].text();
			var editedDoi = editable[1].text();
			var editedDescription = editable[2].text();
			
			console.log("Edited title: " + editedTitle);
			console.log("Edited DOI: " + editedDoi);
			console.log("Edited description: " + editedDescription);
			
			
			$('.control').on("click", '#saveEdit', function(event){
				console.log("Clicked!");
				var post = $.post('edit.php',
					{
						title: editedTitle, //$('#title').val(),
						description: editedDescription, //$('#description').val(),
						doi: editedDoi, // $('#doi').val()
						stubId: stubId
					});		
			});
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
			
			<button type='button' id='submitStubButton'>Submit</button>
			<button type='button' id='cancelButton'>Cancel</button>
		</form>
	</div>
	
	<div id='count'></div>
	<div id='content'></div>
	
<?php	
	
} else {
	include 'layout/header.php'; 
	echo "<h1>You are not logged in.</h1>";	
}

include 'layout/footer.php';

?>


