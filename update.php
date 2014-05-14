<?php

require 'core/init.php';

$URL = "/git/cite/";

if(isset($_GET['stub'])) {
	$deepLink = $_GET['stub'];
} else {
	die("Nothing to update here...");
}

if(Input::exists()) {



}


include 'layout/head.php';
include 'layout/header.php';

?>

<div class='mainContent'>
			<form action="" method="post">
				<table>
					<tr>
						<td><label for="deeplink">Stub ID</label></td>
						<td><input class="input" type="text" name="deeplink" id="deeplink" value="<?php echo $deepLink; ?>" autocomplete="off"></td>
						<td><img height='32'/></td>
					</tr>


					<tr>
						<td><label for="unique_code">Enter unique code</label></td>
						<td><input class="input" type="text" name="unique_code" id="unique_code" value="<?php echo Input::get('unique_code'); ?>"></td>
						<td><img height='32'/></td>
					</tr>
					<tr>
						<td colspan='2'><center><input type="submit" name="submit" id="submit" value="Submit"></center></td>
					</tr>
				</table>
			</form>
		</div>
		<!-- Do we need this on this form? :Ian <div id='orcidOut'></div>-->
<?php
include 'layout/footer.php';
?>