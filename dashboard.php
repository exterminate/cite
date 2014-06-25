<?php
session_start();
require 'core/init.php';
include 'layout/head.php';


if($loginHandler->isLoggedIn()) { 

	include 'layout/header.php';
	$user = $dbHandler->getUser('secretCode', $_SESSION['secretCode']);
	$stubs = $dbHandler->getStubs('links', 'email', '=', $_SESSION['email']);	
	echo "<p>You have created " . $dbHandler->count('links', 'email', '=', $_SESSION['email']) . " stubs.</p>";	
?>
	
	<script src='../lib/mustache.js'></script>
	<script>
		var stubs = $.parseJSON('<?php echo json_encode($stubs); ?>');
		console.log(stubs);
		
		$.get('../templates/dashboardStub.mustache.html', function(template){
			$('#content').html(Mustache.to_html(template, {stubs: stubs}));	
		});
	</script>
	
	<p><?php echo $_SESSION['name']; ?> is logged in.</p>
	<div id='content'></div>
	
<?php	
	
} else {
	include 'layout/header.php'; 
	echo "<h1>You are not logged in.</h1>";	
}

include 'layout/footer.php';

?>


