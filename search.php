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
			$('#orcid').mask("9999-9999-9999-9999", {placeholder : ".", completed: function(){
				//alert("finished typing orcid");
			}});

			$('#submit').click(function(){

				var query = $('#orcid').val();				

				$.post("../searchSQL.php", {query : query, type : "orcid"}, function(data){
					console.log(data);
					$('#output').empty();
					printJSONToTable(data, $('#output'));	
				})
				.fail(function(a,b,c){
					console.log("Error contacting server: " + a.responseText + b + ", " + c);
				});
			});
		});

		function printJSONToTable(data, outputElement){
			var table = $('<table>').attr("class", "table").attr("id", "resultsTable");

			var length = Object.keys(data).length;

			//populate the header rows
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
			
	</script>

	<div>
		<label for='orcid'>Enter ORCID
			<input type='text' name='orcid' id='orcid'>
		</label>		

		<button id='submit'>Submit</button>
	</div>

	<div id='output'>
	</div>

<?php   	

	include 'layout/footer.php';

?>
