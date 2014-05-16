<?php
// search page
// Should probably add this to the index page <= I'll just get it working first :Ian

require 'core/init.php';

if(Input::exists()) {
  
  $validate = new Validate();
	$validate->check($_POST, array( 
		'orcid' => array(
			'required' 	=> true,
			'orcid' => true
			)
		)
	);
	
	if($validate->passed()) {
	  try {
	    // let's get some search results!
	    $stub = new Stub($handler);
	    $stub->obtainData(trim(escape(Input::get('orcid')))); //fetches array(?) :Ian
            
            // will this print an array of stubs created by the same orcid user? <= Test :Ian
            echo "<pre>";
            print_r($stub->showBits('doi'));
            echo "</pre>";

	 
	     
	  } catch(Exception $e) {
			die($e->getMessage());
		}
	 
	}
	
}
?>

<form>
<label for='search'>Enter ORCID</label>
<input type='text' name='orcid' id='search'>
<!-- Add human checking tool -->
<input type='submit' name='submit' id='submit' value='Search'>
</form>


<?php

// print search results here

if(isset($stub->showBits('doi'))) {
  print_r($stub->showBits('doi'));
  // make nice, show table, edit, delete, update <= These should all send deeplinks to the author :Ian
	
}

?>
