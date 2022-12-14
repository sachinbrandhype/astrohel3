<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification {
   	
   	//private static $API_SERVER_KEY = 'AAAAqi3wrzA:APA91bHEciCM2djh7TuZSK6x5EIyI9MXFf64WgfgMnWCzfqaXbRAe7ujGbcf3qP5pmD1A3AcP_1Kb-03P8nwOAPzRa01fqhwBZcqdSqzOt3ZUmuHYrpPc4sgvS8SYB8IFWK-Irza32Pi';
   	private static $API_SERVER_KEY = 'AAAAb0zS7Yo:APA91bHpdehHo2KvTHjjwr4WryWMSwSJH0TRw-rhZymhP6xv0BvdXqRtxwe6AUT2glPRRVzvNQIk8W7yBhGF0m1WodmC_YsrT1tRDfyjLCWOfj7EkayN8fhJddDYUTI4MkJvXaVC2pgY';
    private static $is_background = "TRUE";
    public function __construct() {     
     
    }
    public function sendPushNotificationToFCMSever($registatoin_ids, $message) {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
 	
        $fields = array(
            'registration_ids' => array($registatoin_ids),
            'data' => $message,
            'notification' => $message
        );
//print_r($fields);die;
        $headers = array(
            'Authorization:key=' . self::$API_SERVER_KEY,
            'Content-Type:application/json'
        );  
         
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
     
        $result = curl_exec($ch); 
     
        // Close connection      
        curl_close($ch);
        return $result;
       // print_r($result);
    }
}