<?php
require 'classes/Input.php';
require 'classes/Validate.php';
require 'classes/Stub.php';
require 'includes/functions.php';

include 'head.php';
include 'header.php';

// if there is a deeplink { show stub }
if(isset($_GET['stub']) && !empty($_GET['stub'])) { 

	try {
		$handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo $e->getMessage();
		die("sorry, database problem");
	}

	$stub = new Stub($handler);
	if($stub->count($_GET['stub']) == 0) { 	// no such stub
		die("This stub does not exist.");
	} else { // show stub or redirect
		$stub->addViews($_GET['stub']);
		$stub->redirect($_GET['stub']);
?>
	<div>
		<ul>
			<li>Unique ID: <?php echo $stub->showBits("deeplink"); ?></li>
			<li>Stub author: <?php echo $stub->showBits("name"); ?></li>
			<li>Author email: <?php echo $stub->showBits("email"); ?></li>
			<li>OrcID: <?php echo $stub->showBits("orcid"); ?></li>
			<li>Research description: <?php echo $stub->showBits("description"); ?></li>
			<li>Views: <?php echo $stub->showBits("views"); ?></li>
		</ul>	
	</div>
	

<?php		
		
	}
	
	
	
}
// else if there is no deeplink { show homepage }
else {
	echo "<br>no stub home<br>";
}



include 'footer.php';
echo "<hr>HOME";
?>
