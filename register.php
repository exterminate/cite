<?php
session_start();

require('core/init.php');
include('layout/head.php');
include('layout/header.php');
include('orcid/OrcidHandler.php');

$orcid = Input::get('orcid');

if(Input::exists()) {

	$validate = new Validate();
	$validate->check($_POST, array( 
                'orcid' => array(
			'required' 	=> true,
			'orcid' 	=> true			
			),
		'password' => array(
			'required' 	=> true,
			'min' 		=> 6,
			'max' 		=> 20	
			)
		)
	);
	
	if($validate->passed()) {
		
 

            $_SESSION['password'] = Input::get('password');
            //PC::debug($_SESSION['password']);
            $user = getUser($orcid);
        

?>
<script src='lib/mustache.js'></script>
<script>
    var user = $.parseJSON('<?php  echo json_encode($user, JSON_FORCE_OBJECT) ?>');
    
    $.get('templates/register.mustache.html', function(template){
        $('#content').html(Mustache.to_html(template, user));
    })
    .fail(function(jqXhr){
        console.log("Failed to load mustache template: " + jqHxr.responseText)
    });
    
    
</script>
<div id='content'></div>


<?php
        } else {
            foreach($validate->errors() as $error) {
		echo $error . "<br>";
	    }
        }
}
include('layout/footer.php');
?>