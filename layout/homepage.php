<script src='lib/mustache.js'></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/jquery.slick/1.3.6/slick.css"/>
<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.slick/1.3.6/slick.min.js"/></script>
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
	});	
</script>


<div class="welcome">
	<h1>Welcome to Cite</h1>
	<h2>Never lose the opportunity to share your work</h2>
</div>

<div class="bodytext">
	<p>Want to reference a work that you haven't quite put the finishing touches on yet? Or that seminal paper you will write in five years time after years of groundbreaking research? You can do it easily using Cite.pub!</p>
	<ol class='circles-list'>
	  	<li><a href='submit/'>Create a stub</a> on Cite.pub using your Orcid ID</li>
		<li>Cite the unique URL in your publication</li>
	  	<li>Publish your seminal work</li>
	  	<li>Complete your stub with the DOI of the new paper. The original URL will forward readers straight through!</li>
	</ol>
	<p>Would you like to cite future work you discuss in your current paper but have not yet written up or possibly not even done?</p>
	<p>If you use Cite you can create a DOI-like stub that will stay online until you are ready to publish. Once you do, update your record and we will redirect the reader straight to the publisher where the paper is published.</p>
</div>
<div id='recentStubs'>
	Recently Submitted:<br>
</div>
