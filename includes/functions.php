<?php

// may change the name of this file later

function create_deeplink($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $deeplink = '';
    for ($i = 0; $i < $length; $i++) {
        $deeplink; .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $deeplink;
}

function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

?>
