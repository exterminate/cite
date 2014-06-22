<?php
session_start();
unset($_SESSION["name"]);
unset($_SESSION["secretCode"]);
unset($_SESSION["email"]);
header("Location: index.php");
exit();
?>