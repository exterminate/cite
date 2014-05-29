<form action="" method="post">
	<table>
		<tr>
			<td><label for="name">Name</label></td>
			<td><input type="text" name="name" id="name" value="<?php echo $editStub->showBits('name'); ?>"></td>
		</tr>
		<tr>
			<td><label for="email">Email address</label></td>
			<td><input type="email" name="email" id="email" value="<?php echo $editStub->showBits('email'); ?>"></td>
		<tr>
		<tr>
			<td><label for="orcid">ORCID</label></td>
			<td><input type="text" name="orcid" id="orcid" value="<?php echo $editStub->showBits('orcid'); ?>"></td>
		<tr>	
		<tr>
			<td><label for="doi">DOI</label></td>
			<td><input type="text" name="doi" id="doi" value="<?php echo $editStub->showBits('doi'); ?>"></td>
		<tr>				
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Save"></td>
		</tr>
	</table>		
</form>