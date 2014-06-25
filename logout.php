<?php
session_start();
//require 'core/init.php';
require 'classes/loginHandler.php';
$loginHandler = new LoginHandler();
$loginHandler->logOut();
?>