<?php

require_once 'core/init.php';


//id, linkid, name, email, orcid (required), datesubmitted, doi, datedoi
?>

<form action="" method="post">
	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="" autocomplete="off">
	</div>

	<div class="field">
		<label for="email">E-mail</label>
		<input type="text" name="email" id="email">
	</div>

	<div class="field">
		<label for="orcid">ORCID ID</label>
		<input type="text" name="orcid" id="orcid">
	</div>
	<div class="field">
		<label for="description">Describe your work</label>
		<textarea name="description" id="description"></textarea>
	</div>
	<input type="submit" value="Register">
</form>