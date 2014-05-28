<?php
// search page
// Should probably add this to the index page <= I'll just get it working first :Ian

require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';

?>

<form action="" method="post">
<table>
	<tr>
		<td><label for='search'>Enter ORCID</label></td>
		<td><input type='text' name='orcid' id='search'></td>
		<!-- Add human checking tool -->
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type='submit' name='submit' id='submit' value='Search'></td>
	</td>
</table>
</form>

<?php

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
		    $results = $stub->obtainData('orcid', trim(escape(Input::get('orcid')))); //fetches array(?) :Ian

?>
<table class="table">
	<tr>
		<th>Description</th>
		<th>Date submitted</th>
		<th>DOI</th>
		<th>Views</th>
	</tr>
<?		   
		    foreach($results as $result) {
		    	echo "\t<tr>";
		    	echo "\n\t\t<td>" . $result['description'] . "</td>\n\t\t<td>" . $result['datesubmitted'] . "</td>\n\t\t<td>";
		    	if(strlen($result['doi']) > 0) {
		    		echo "<a href='http://dx.doi.org/" . $result['doi'] . "'>" . $result['doi'] . "</a>";
		    	} else {
		    		echo "<a href='" . $rootURL . "update/" . $result['deeplink'] . "'>Update</a>";
		    	}
		    	echo "</td>\n\t\t<td>" . $result['views'] . "</td>";
		    	echo "\n\t</tr>\n";
		    }
		    
	            
?>

</table>

<?php
	     
		} catch(Exception $e) {
			die($e->getMessage());
		}
	 
	}
	
}

include 'layout/footer.php';

?>
