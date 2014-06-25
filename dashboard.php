<?php
session_start();
// search page

require 'core/init.php';
include 'layout/head.php';

if(Input::exists()) {

	$validate = new Validate();
	$validate->check($_POST, array( 
		'email' => array(
			'required' 	=> true,
			'max' 		=> 60,
			'email' 	=> true			
			),
		'password' => array(
			'required' 	=> true,
			'min' 		=> 6,
			'max' 		=> 20	
			)
		)
	);
	
	if($validate->passed()) {
		$dbHandler->login(Input::get('email'), Input::get('password'));
	}
} 


/*
*    with new loginHandler try $loginHandler = new LoginHandler();
*     if(LoginHandler::isLoggedIn()) { etc....................... }
*/

$loginHandler = new LoginHandler();
if(LoginHandler::isLoggedIn()) { 
	include 'layout/header.php';
	$user = $dbHandler->getUser('secretCode', $loginHandler->sessionSecretCode);
	$stubs = $dbHandler->getStubs('links', 'email', '=', $loginHandler->sessionEmail);	
		
?>
	
	<script src='../lib/mustache.js'></script>
	<script>
		var stubs = $.parseJSON('<?php echo json_encode($stubs); ?>');
		console.log(stubs);
		
		$.get('../templates/dashboardStub.mustache.html', function(template){
			$('#content').html(Mustache.to_html(template, {stubs: stubs}));	
		});
	</script>
	
	<p><?= $loginHandler->sessionName?> is logged in.</p>
	<div id='content'></div>
	
<?php

	$user = $dbHandler->getUser('secretCode', $loginHandler->sessionSecretCode);
	$stubs = $dbHandler->getStubs('links', 'email', '=', $loginHandler->sessionEmail);
		
	echo "<p>You have created " . $dbHandler->count('links', 'email', '=', $loginHandler->sessionEmail) . " stubs.</p>";
	
} else {
	include 'layout/header.php'; 
	echo "<h1>You are not logged in.</h1>";
	
}


	include 'layout/footer.php';

?>


