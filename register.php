<?php

require('core/init.php');
include('layout/head.php');
include('layout/header.php');
include('orcid/OrcidHandler.php');
require_once('lib/php-console-master/src/PhpConsole/__autoload.php');
PhpConsole\Helper::register();

session_start();

$orcid = Input::get('orcid');
$_SESSION['password']= Input::get('password');

$user = getUser($orcid);
PC::debug($user);

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
