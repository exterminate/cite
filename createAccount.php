<?php

require('core/init.php');

$user = new User(
    Input::get('firstName'),
    Input::get('surname'),
    Input::get('orcid'),
    Input::get('accessLevel'),
    Input::get('email')
);



$dbHandler->registerUser($user, Input::get('password'));


?>
