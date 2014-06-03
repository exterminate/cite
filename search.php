<?php
// search page
// Should probably add this to the index page <= I'll just get it working first :Ian

require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';

?>

	<script src="../lib/jquery.maskedinput.js" type="text/javascript"></script>
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
		});

		function searchDB(query, type){
			/*
				Note this only finds exact matches at present
			*/
			$.post("../searchSQL.php", {query : query, type : type, admin : false}, function(data){
				console.log(data);
				$('#output').empty();
				printJSONToTable(data, $('#output'));	
			})
			.fail(function(a,b,c){
				console.log("Error contacting server: " + a.responseText + b + ", " + c);
			});
	}

		function printJSONToTable(data, outputElement){
			var table = $('<table>').attr("class", "table").attr("id", "resultsTable");

			if(data.error != null){
				$(outputElement).append("Error: " + data.error);
			} else {
				var length = Object.keys(data).length;

				//populate the header row
				var headerRow = $("<tr>");
				$.each(data[0], function(key, val){				
					$(headerRow).append($("<th>").text(key));
				})

				$(table).append($(headerRow));

				//populate the body rows
				for(var i = 0; i < length; i++){
					var row = $("<tr>");

					$.each(data[i], function(key, val){
						var cell = $("<td>").text(val);
						$(row).append($(cell));
					});				

					$(table).append($(row))
				}


				$(outputElement).append($(table));		
			}
		}
			
	</script>

	<div>
		<form>			
			<label for='searchQuery'>Search for:
				<input type='text' name='searchQuery' id='searchQuery'>
				<button id='searchButton' type='button'>Search</button>
				<select id='typeSelect'>
					<option value='email'>Email</option>
					<option value='name'>Name</option>
					<option value='orcid'>Orcid</option>
					<option value='deeplink'>Stub ID</option>					
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
