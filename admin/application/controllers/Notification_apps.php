<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		exit(0);
}
class Notification_apps extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Api_Model','w_m');
		$this->load->library('form_validation');
		
			
	}


	// one hour before reminder notification
	public function send_video_chat_notificationonehour()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		// $endTime = date('Y-m-d H:i:s',strtotime("+60 minutes", $date));
		// $endTime
		$list_bookings = $this->db->query("SELECT a.id,a.booking_date_time,b.name AS user_name,a.online_mode,a.booking_date,a.booking_time,c.name AS expert_name,c.device_token as expert_device_token ,c.device_type  as expert_device_type,c.voip_token as expert_void_token,a.name As u_name,b.device_token as user_token,b.device_type as user_device_type,b.voip_token as user_void_token FROM booking a JOIN user b ON b.id=a.user_id JOIN expert_management c ON c.id = a.expert_id WHERE `booking_date` = '$date1' AND a.status = '0' AND a.one_hour_notification = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
				// Send to doctor Notification
				$btime = strtotime($key->booking_date_time);
				$b60_befor = strtotime("-61 minutes", $btime);
				if ($date >= $b60_befor) 
				{
					$title1 = "[Reminder] Online ".$key->online_mode." Consultant ";
					$message1 = "Your online consult start in ".date('d M Y',strtotime($key->booking_date)).' '.$key->booking_time.' with '.$key->u_name;
					$selected_android_user1 = array();
					if($key->expert_device_type == 'android')
			        {   
			            if($key->expert_device_token!='abc')
			            {
			            	array_push($selected_android_user1, $key->expert_device_token);
			            }
			            
			        }
					elseif ($key->expert_device_type == 'ios') 
	                {
						//$this->send_ios_notification($key->doctor_device_token,$message1,$key->booking_mode);
	                }
	                if(count($selected_android_user1))
			        {
			        	$notification_type1 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title1.'","msg":"'.$message1.'","type":"no"}';
			            $message2 = array(
			                    'body' => $message1,
			                    'title' => $title1,
			                    'sound' => 'default'
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user1,$message2);
			    	}
				

					// send to patient notification
					$title2 = "[Reminder] Online ".$key->online_mode." Consultant";
					$message2 = "Your online consult start in ".date('d M Y',strtotime($key->booking_date)).' '.$key->booking_time.' with '.$key->expert_name;
					$selected_android_user2 = array();
					if($key->user_device_type == 'android')
			        {   
			        	if($key->user_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->user_token);
			            }
			            
			        }
					elseif ($key->user_device_type == 'ios') 
	                {
						//$this->send_ios_notification($key->user_token,$message2,$key->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    'title' => $title2,
			                    'sound' => 'default'
			                );
						$a = $this->sendMessageThroughFCM($selected_android_user2,$message3);
			        }
					$this->db->query("UPDATE `booking` SET `one_hour_notification` = '1' WHERE `id`=$key->id ");
				}
			}		
		}
	}

	public function send_video_chat_notification15minutes()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		//$endTime = date('Y-m-d H:i:s',strtotime("+60 minutes", $date));
		// $endTime
		$list_bookings = $this->db->query("SELECT a.id,a.booking_date_time,b.name AS user_name,a.online_mode,a.booking_date,a.booking_time,c.name AS expert_name,c.device_token as expert_device_token ,c.device_type  as expert_device_type,c.voip_token as expert_void_token,a.name As u_name,b.device_token as user_token,b.device_type as user_device_type,b.voip_token as user_void_token FROM booking a JOIN user b ON b.id=a.user_id JOIN expert_management c ON c.id = a.expert_id WHERE `booking_date` = '$date1' AND a.status = '0' AND a.fifteen_minutes_notification = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
				// Send to expert Notification
				$btime = strtotime($key->booking_date_time);
				$b15_befor = strtotime("-16 minutes", $btime);
				if ($date >= $b15_befor) 
				{
					$title1 = "[Reminder] Online ".$key->online_mode." Consultant ";
					$message1 = "Your online consult start in ".date('d M Y',strtotime($key->booking_date)).' '.$key->booking_time.' with '.$key->u_name;
					$selected_android_user1 = array();
					if($key->expert_device_type == 'android')
			        {   
			            if($key->expert_device_token!='abc')
			            {
			            	array_push($selected_android_user1, $key->expert_device_token);
			            }
			            
			        }
					elseif ($key->expert_device_type == 'ios') 
	                {
						//$this->send_ios_notification($key->doctor_device_token,$message1,$key->booking_mode);
	                }
	                if(count($selected_android_user1))
			        {
			        	$notification_type1 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title1.'","msg":"'.$message1.'","type":"no"}';
			            $message2 = array(
			                    'body' => $message1,
			                    'title' => $title1,
			                    'sound' => 'default'
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user1,$message2);
			    	}
				

					// send to patient notification
					$title2 = "[Reminder] Online ".$key->online_mode." Consultant";
					$message2 = "Your online consult start in ".date('d M Y',strtotime($key->booking_date)).' '.$key->booking_time.' with '.$key->expert_name;
					$selected_android_user2 = array();
					if($key->user_device_type == 'android')
			        {   
			        	if($key->user_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->user_token);
			            }
			            
			        }
					elseif ($key->user_device_type == 'ios') 
	                {
						//$this->send_ios_notification($key->user_token,$message2,$key->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    'title' => $title2,
			                    'sound' => 'default'
			                );
						$a = $this->sendMessageThroughFCM($selected_android_user2,$message3);
			        }	

		        	$this->db->query("UPDATE `booking` SET `fifteen_minutes_notification` = '1' WHERE `id`=$key->id ");
				}
			}		
		}
	}

	function get_settings(){
		$query = $this->db->get_where('settings',array('id'=>'1'));
		return $result = $query->row();
	}

	public function sendMessageThroughFCM($registatoin_ids, $message) 
	{
		$settings = $this->get_settings();
    	if ($settings->firebase_key) 
    	{
    		$k = $settings->firebase_key;
    	}
    	else
    	{
    		$k = 'AAAAde4zwbU:APA91bF2eh_-9PawWtsP8Krt5bx6fOqICeq8D_G6TPmDGmSqhH6RGCexdf6ZANf9ATlNQuznDFjToucUg42OoBvwB-rF9SZj-usmHobxM7oekCjX1vQLqHOibjTVOe9jkKPAQQs_LzsH';
    	}
    	$url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message
        );
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='.$k;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);   
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //Setup curl, add headers and post parameters.
        
        $result = curl_exec($ch);  
        // print_r($result);             
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

    /*public function send_ios_notification($device_token,$message_text,$type)
    {
		$payload='{"aps":{"alert":"'.$message_text.'","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"'.$type.'"}';
        //include_once("Cow.pem");
        $ctx=stream_context_create();
        stream_context_set_option($ctx,'ssl','local_cert','/var/www/html/anytimedoc/notification_key/api.pem');
        // $fp=stream_socket_client('ssl://gateway.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        $fp=stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        if($fp)
        {
        // echo "Connected".$err;
        }
        $msg=chr(0).pack("n",32).pack("H*",str_replace(' ','',$device_token)).pack("n",strlen($payload)).$payload;
        $res=fwrite($fp,$msg);
        if($res)
        {
         //print_r($res);   
        }
        fclose($fp);
        return true;
    }*/

}