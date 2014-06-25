<?php
session_start();
require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';


if($loginHandler->isLoggedIn()) {
    
}

include 'layout/footer.php';
?>
