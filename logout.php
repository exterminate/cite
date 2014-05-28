<?php
session_start();
unset($_SESSION["username"]);  
header("Location: " . $rootURL . "admin.php");
?>