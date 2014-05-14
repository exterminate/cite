<?php
    header('Content-type: application/json');
	
    $url = "http://pub.orcid.org/";
    $id = $_POST['id'];    
        
    $ch = curl_init($url.$id);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/orcid+json"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$data = curl_exec($ch);
    $json = json_encode($data);
	$array = json_decode($data, true);
    curl_close($ch);
	
	echo $json;
?>