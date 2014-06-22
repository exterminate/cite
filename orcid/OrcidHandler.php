<?php


    function getUser($id){
        $host = 'http://pub.orcid.org/v1.1/';
            
        $ch = curl_init($host.$id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/orcid+json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         
        $data = curl_exec($ch);
        curl_close($ch);
       
        $array = json_decode($data,true);
        
        
        //no OrcID found with this ID, return an empty user
        if(array_key_exists('error-desc', $array)){
            return new User(
                                "",
                                "",
                                $id,
                                "unverified",
                                ""
                            );
        } else{
            //we've found your orcid profile, return the user details
            return new User(
                           getFirstName($array),
                           getSurname($array),
                           $id,
                           "unverified",
                           getEmail($array)                          
                       );       
        }
           
    }
    
    function getFirstName($orcidJson){
        return $orcidJson['orcid-profile']['orcid-bio']['personal-details']['given-names']['value'];
    }
    
    function getSurname($orcidJson){
        return $orcidJson['orcid-profile']['orcid-bio']['personal-details']['family-name']['value'];
    }
    
    function getEmail($orcidJson){
        if(array_key_exists('orcid-profile', $orcidJson)){
            if(array_key_exists('orcid-bio', $orcidJson['orcid-profile'])){
                if(array_key_exists('contact-details', $orcidJson['orcid-profile']['orcid-bio'])){
                    if(array_key_exists('email',  $orcidJson['orcid-profile']['orcid-bio']['contact-details'])){
                        foreach($orcidJson['orcid-profile']['orcid-bio']['contact-details']['email'] as $x => $arr){
                            if($arr['primary']){
                                return $arr['value'];
                            }
                        }
                    }
                }
            }
        }
        return "";
    }
?>