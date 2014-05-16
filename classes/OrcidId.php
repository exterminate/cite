<?php
    header('Content-type: application/json');
	
    $url = "http://pub.orcid.org/";
    $id = $_POST['id'];    
    
    
    $ch = curl_init($url.$id);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/orcid+json"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$data = curl_exec($ch);
	$array = json_decode($data, true);
    curl_close($ch);
	
	$firstName = $array['orcid-profile']['orcid-bio']['personal-details']['given-names']['value'];
	$surname = $array['orcid-profile']['orcid-bio']['personal-details']['family-name']['value'];
	$name = $firstName." ".$surname;
	
	$email = "";
	
	if(array_key_exists('orcid-profile', $array)){
		if(array_key_exists('orcid-bio', $array['orcid-profile'])){
			if(array_key_exists('contact-details', $array['orcid-profile']['orcid-bio'])){
				if(array_key_exists('email',  $array['orcid-profile']['orcid-bio']['contact-details'])){
					foreach($array['orcid-profile']['orcid-bio']['contact-details']['email'] as $x => $arr){
						if($arr['primary']){
							$email = $arr['value'];
						}
					}
					
				}
			}
		}
	}	
	echo json_encode(array("name" => $name, "email" => $email));
	//echo "<pre>".print_r($array)."</pre>";
?>