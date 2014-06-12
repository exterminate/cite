<?php

class Author {
    public $email;
    public $deepLink;
    public $time;

    function __construct($handler) {
        $this->handler = $handler;
    }

    public function createLoginSession($email, $deepLink) {
        $sql = "INSERT INTO authors (email, deepLink, time) VALUES (:email, :deepLink, :time)";
        $query = $this->handler->prepare($sql);
        $query->execute(array(
            ":email" => $email,
            ":deepLink" => $deepLink,
            ":time" => strtotime("now") + 3600
        ));
    }


    public function getAuthorDetails($sessionEmail) { // insert session into this
        $query = $this->handler->query("SELECT * FROM author WHERE email = '$sessionEmail'");

        while ($r = $query->fetchAll(PDO::FETCH_ASSOC)) {
            
            if($r[0] != null){
                return $r[0];         
            } else{
                return null;
            }
        }   
    }
}

?>
