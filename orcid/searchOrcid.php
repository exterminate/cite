<?php
    require_once('../lib/php-console-master/src/PhpConsole/__autoload.php');
    PhpConsole\Helper::register();
   

    header('Content-type: application/json');
    
    $query = $_POST['query'];
    $type = $_POST['type'].":";
    $host = 'http://pub.orcid.org/v1.1/search/orcid-bio?q=';
    $hits = "10";
    $searchString = $host.$type.$query."&rows=".$hits;
    
    $ch = curl_init($searchString);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/orcid+json"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
    $data = curl_exec($ch);
    curl_close($ch);
    
    $array = json_decode($data,true);
    //echo json_encode($data);
    
    $results = array();   
    $results['searchString'] = $searchString;
    $results['searchResults'] = array();
    
    foreach($array['orcid-search-results']['orcid-search-result'] as $k => $v){
        $fname = $v['orcid-profile']['orcid-bio']['personal-details']['given-names']['value'];
        $sname = $v['orcid-profile']['orcid-bio']['personal-details']['family-name']['value'];       
        $id = $v['orcid-profile']['orcid-identifier']['path'];

        $email = "";

        //this horrible section is to check each nested element, because if one is missing the whole thing dies

        if(array_key_exists('orcid-profile', $v)){
            if(array_key_exists('orcid-bio', $v['orcid-profile'])){
                if(array_key_exists('contact-details', $v['orcid-profile']['orcid-bio'])){
                    if(array_key_exists('email',  $v['orcid-profile']['orcid-bio']['contact-details'])){
                        foreach($v['orcid-profile']['orcid-bio']['contact-details']['email'] as $x => $arr){
                            if($arr['primary']){
                                $email = $arr['value'];
                            }
                        }

                    }
                }
            }
        }

        array_push($results['searchResults'],
            array(
                "fname" => $fname,
                "sname" => $sname,
                "email" => $email,
                "id" => $id
            )
        );
    }

    //use Chrome PHP console to print $results to browser console
    //PC::debug($results);

    if(empty($results['searchResults'])){
        echo (json_encode(array("error" => "No Orcid Profiles found matching ".$query)));
    } else{
        echo (json_encode($results, JSON_FORCE_OBJECT));
    }
    
?>