<?php

if(isset($_GET['code']) && !empty($_GET['code'])){
	$code = $_GET['code'];
	redirect($code);
	die();
}

?>