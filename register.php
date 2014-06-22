<?php

require('core/init.php');
include('layout/head.php');
include('layout/header.php');
include('orcid/OrcidHandler.php');

$orcid = Input::get('orcid');

//session_start();

$_SESSION['password'] = Input::get('password');
//PC::debug($_SESSION['password']);
$user = getUser($orcid);


?>
<script src='lib/mustache.js'></script>
<script>
    var user = $.parseJSON('<?php  echo json_encode($user, JSON_FORCE_OBJECT) ?>');
    
    $.get('templates/register.mustache.html', function(template){
        $('#register').html(Mustache.to_html(template, user));
    })
    .fail(function(jqXhr){
        console.log("Failed to load mustache template: " + jqHxr.responseText)
    });
    
    
</script>
<div id='register'></div>
