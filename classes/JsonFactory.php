<?php

class JsonFactory {
    
    public static function message($message){
        
        /*
         *  Return a JSON string of the form:
         *      {
         *          "message" : $message
         *      }
         */
        
        return json_encode(array("message" => $message));
    }
    
    public static function success($success, $message){
        /*
         *  Return a JSON string of the form:
         *      {
         *          "success" : boolean,
         *          "message" : $message
         *      }
         */
        
        return json_encode(array("success" => $success, "message" => $message));
    }
}
