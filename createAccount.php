<?php
session_start();
require('core/init.php');
include ('layout/head.php');
include('layout/header.php');

$user = new User(
    Input::get('firstName'),
    Input::get('surname'),
    Input::get('orcid'),
    Input::get('accessLevel'),
    Input::get('email')
);

$dbHandler->registerUser($user, $_SESSION['password']);
session_destroy();
?>

<script src='lib/mustache.js'></script>

<script>
    $.get('templates/accountCreatedConfirmation.mustache.html', function(template){
       $('#content').html(Mustache.to_html(template, user)); 
    });
</script>

<div id='content'></div>
