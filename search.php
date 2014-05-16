<?php
//search page
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
