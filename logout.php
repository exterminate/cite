<?php
session_start();
unset($_SESSION["name"]);
unset($_SESSION["secretCode"]); 
header("Location: index.php");
exit();
?>