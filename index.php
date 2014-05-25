<?php
require 'core/init.php';



// if there is a deeplink { show stub }
if(isset($_GET['stub']) && !empty($_GET['stub'])) { 

	$stub = new Stub($handler);
	if($stub->count($_GET['stub']) == 0) { 	// no such stub
		die("This stub does not exist.");
	} else { // show stub or redirect
		$stub->addViews($_GET['stub']);
		$stub->redirect($_GET['stub']);
		$stub->obtainData('deeplink', trim(escape(Input::get('stub'))));

	include 'layout/head.php';
	include 'layout/header.php';
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
	include 'layout/head.php';
	include 'layout/header.php';
	include 'layout/homepage.php';
	echo '<a href="submit/">Submit</a>';
}



include 'layout/footer.php';

?>
