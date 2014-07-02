<?php
session_start();
// search page
// Should probably add this to the index page <= I'll just get it working first :Ian

require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';

?>
	<script src="lib/jquery.maskedinput.js" type="text/javascript"></script>
	<script src='lib/mustache.js'></script>
	<script>
		$(document).ready(function(){
			$('#typeSelect').change(function(){
				console.log($(this).val());
				if($(this).val() == "orcid"){
					$('#searchQuery').mask("9999-9999-9999-9999", {placeholder : ".", completed: function(){
						searchDB($(this).val(), "orcid");
					}});
				} else{
					$('#searchQuery').unmask();
				}
			});

			$('#searchButton').click(function(){
				var query = $('#searchQuery').val();
				var type = $('#typeSelect').val();
				searchDB(query, type);
			});

			/*
				This needs unusual syntax because the content is added dynamically
				We have to bind the on click handler to the content after the page is created
			*/
			$('#output').on('click', '.stub', function(){				
				console.log($(this).find('.stubId').text());
				$(location).attr('href', "" + $(this).find('.stubId').text());
			});
		});

		function searchDB(query, type){
			/*
				Note this only finds exact matches at present
			*/
			$.post("searchStubs.php", {query : query, type : type}, function(data){
				console.log(data);
				$('#output').empty();
				printJSONToTable(data, $('#output'));	
			})
			.fail(function(a,b,c){
				console.log("Error contacting server: " + a.responseText + ", " + b + ", " + c);
			});
		}

		function printJSONToTable(data, outputElement){	
			if(data.message != null){
				$(outputElement).append(data.message);
			} else {
				var length = Object.keys(data).length;

				$.get("templates/stub.mustache.html", function(template){			
					for(var i = 0; i < length; i++){
						$(outputElement).append(Mustache.to_html(template, data[i]));
					}
				})
				.fail(function(a,b,c){
					console.log("Failed to load Mustache template, " + a.responseText);
				});									
			}
		}
			
	</script>

	<div>
		<form method="POST" action="">			
			<label for='searchQuery'>Search for:<br>
				<input type='text' name='searchQuery' id='searchQuery'>
				<button id='searchButton' type='button'>Search</button>
				<select id='typeSelect'>
					<option value='email'>Email</option>
					<option value='surname'>Surname</option>
					<option value='orcid'>Orcid</option>
					<option value='deeplink'>Stub ID</option>	
					<option value='stubTitle'>Stub Title</option>				
				</select>
			</label>	

			
		</form>
	</div>
	<br/>
	<div id='output'>
	</div>

<?php   	

	include 'layout/footer.php';

?>
