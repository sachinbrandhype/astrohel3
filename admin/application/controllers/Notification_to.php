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
class Notification_to extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Api_Model','w_m');
		$this->load->library('form_validation');
		
			
	}

	// one hour before reminder notification
	public function send_video_notificationonehour_astro_consult()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		$list_bookings = $this->db->query("SELECT * FROM bookings WHERE `schedule_date` = '$date1' AND `status` = 0 AND `type` IN ('1','2','3') AND `booking_type`='2' AND `is_premium`='1' AND `one_hour_notification` = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
				// Send to doctor Notification
				$btime = strtotime($key->schedule_date_time);
				$b60_befor = strtotime("-61 minutes", $btime);
				if ($date >= $b60_befor) 
				{
					$a = $key;
					$user = $this->db->get_where("user",array("id"=>$a->user_id))->row();
					$astrologers = $this->db->get_where("astrologers",array("id"=>$a->assign_id))->row();
					$mode = '';
					if ($a->type == 1) 
					{
						$mode = 'Video';
					}
					elseif ($a->type == 2) 
					{
						$mode = 'Audio';
					}
					elseif ($a->type == 3) 
					{
						$mode = 'Chat';
					}
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					
					$title2 ="Shaktipeeth Digital Online Consultation";
					$message2 = "Your ".$mode." consultation with ".$user->name." is booked for ".date('d M, Y',strtotime($key->schedule_date))." at ".date('h:ia',strtotime($key->schedule_time))." Time for ".$key->total_minutes." minutes. Remain only one hour to start.";
					
					$selected_android_user2 = array();
					if($astrologers->device_type == 'android')
			        {   
			        	if($astrologers->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $astrologers->device_token);
			            }
			            
			        }
					elseif ($astrologers->device_type == 'ios') 
			        {
						// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
			        }
			        if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

			                );
						$a = $this->sendMessageThroughFCM($selected_android_user2,$message2,$settings->astrologer_firebase);
			        }
			        $noti_array = array("type"=>$mode,"for_"=>"astrologer","user_id"=>$astrologers->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
					$this->db->insert('astrologer_notification',$noti_array);
				
					//to user notification
					$title_user = "Shaktipeeth Digital Online Consultation";
					$message_user = "Your ".$mode." consultation with ".$astrologers->name." is booked for ".date('d M, Y',strtotime($key->schedule_date))." at ".date('h:ia',strtotime($key->schedule_time))." Time for ".$key->total_minutes." minutes. Remain only one hour to start.";
					$selected_android_user1 = array();
					if($user->device_type == 'android')
			        {   
			            if($user->device_token!='abc')
			            {
			            	array_push($selected_android_user1, $user->device_token);
			            }
			            
			        }
					elseif ($user->device_type == 'ios') 
			        {
						// $this->w_m->send_ios_notification($user->device_token,$message1,$mode);
			        }
			        if(count($selected_android_user1))
			        {
			        	$notification_type1 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title_user.'","msg":"'.$message_user.'","type":"no"}';
			            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
			            $message_user_ = array(
			                    'body' => $message_user,
			                    'title' => $title_user,
			                    'sound' => 'default'
			                );
						$a = $this->w_m->sendMessageThroughFCM($selected_android_user1,$message_user_,$settings->firebase_key);
			    	}
			    	$noti_array_user = array("type"=>$mode,"for_"=>"user","user_id"=>$user->id,"title"=>$title_user,"notification"=>$message_user,"booking_id"=>$key->id,"added_on"=>date('Y-m-d H:i:s'));
					$this->db->insert('user_notification',$noti_array_user);

			        $this->db->query("UPDATE `bookings` SET `one_hour_notification` = '1' WHERE `id`=$key->id ");
				}
			}		
		}
	}

	public function send_video_notificationonefifteen_minutes_astro_consult()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		$list_bookings = $this->db->query("SELECT * FROM bookings WHERE `schedule_date` = '$date1' AND `status` = 0 AND `type` IN ('1','2','3') AND `booking_type`='2' AND `is_premium`='1' AND `fifteen_minutes_notification` = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
				// Send to doctor Notification
				$btime = strtotime($key->schedule_date_time);
				$b60_befor = strtotime("-16 minutes", $btime);
				if ($date >= $b60_befor) 
				{
					$a = $key;
					$user = $this->db->get_where("user",array("id"=>$a->user_id))->row();
					$astrologers = $this->db->get_where("astrologers",array("id"=>$a->assign_id))->row();
					$mode = '';
					if ($a->type == 1) 
					{
						$mode = 'Video';
					}
					elseif ($a->type == 2) 
					{
						$mode = 'Audio';
					}
					elseif ($a->type == 3) 
					{
						$mode = 'Chat';
					}
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					
					$title2 ="Shaktipeeth Digital Online Consultation";
					$message2 = "Your ".$mode." consultation with ".$user->name." is booked for ".date('d M, Y',strtotime($key->schedule_date))." at ".date('h:ia',strtotime($key->schedule_time))." Time for ".$key->total_minutes." minutes. Remain only one 15 minutes to start.";
					
					$selected_android_user2 = array();
					if($astrologers->device_type == 'android')
			        {   
			        	if($astrologers->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $astrologers->device_token);
			            }
			            
			        }
					elseif ($astrologers->device_type == 'ios') 
			        {
						// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
			        }
			        if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

			                );
						$a = $this->sendMessageThroughFCM($selected_android_user2,$message2,$settings->astrologer_firebase);
			        }
			        $noti_array = array("type"=>$mode,"for_"=>"astrologer","user_id"=>$astrologers->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
					$this->db->insert('astrologer_notification',$noti_array);
				
					//to user notification
					$title_user = "Shaktipeeth Digital Online Consultation";
					$message_user = "Your ".$mode." consultation with ".$astrologers->name." is booked for ".date('d M, Y',strtotime($key->schedule_date))." at ".date('h:ia',strtotime($key->schedule_time))." Time for ".$key->total_minutes." minutes. Remain only 15 minutes to start.";
					$selected_android_user1 = array();
					if($user->device_type == 'android')
			        {   
			            if($user->device_token!='abc')
			            {
			            	array_push($selected_android_user1, $user->device_token);
			            }
			            
			        }
					elseif ($user->device_type == 'ios') 
			        {
						// $this->w_m->send_ios_notification($user->device_token,$message1,$mode);
			        }
			        if(count($selected_android_user1))
			        {
			        	$notification_type1 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title_user.'","msg":"'.$message_user.'","type":"no"}';
			            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
			            $message_user_ = array(
			                    'body' => $message_user,
			                    'title' => $title_user,
			                    'sound' => 'default'
			                );
						$a = $this->w_m->sendMessageThroughFCM($selected_android_user1,$message_user_,$settings->firebase_key);
			    	}
			    	$noti_array_user = array("type"=>$mode,"for_"=>"user","user_id"=>$user->id,"title"=>$title_user,"notification"=>$message_user,"booking_id"=>$key->id,"added_on"=>date('Y-m-d H:i:s'));
					$this->db->insert('user_notification',$noti_array_user);

			        $this->db->query("UPDATE `bookings` SET `fifteen_minutes_notification` = '1' WHERE `id`=$key->id ");
				}
			}		
		}
	}

	public function send_video_notificationonefive_minutes_astro_consult()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		$list_bookings = $this->db->query("SELECT * FROM bookings WHERE `schedule_date` = '$date1' AND `status` = 0 AND `type` IN ('1','2','3') AND `booking_type`='2' AND `is_premium`='1' AND `five_minutes_notification` = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
				// Send to doctor Notification
				$btime = strtotime($key->schedule_date_time);
				$b60_befor = strtotime("-6 minutes", $btime);
				if ($date >= $b60_befor) 
				{
					$a = $key;
					$user = $this->db->get_where("user",array("id"=>$a->user_id))->row();
					$astrologers = $this->db->get_where("astrologers",array("id"=>$a->assign_id))->row();
					$mode = '';
					if ($a->type == 1) 
					{
						$mode = 'Video';
					}
					elseif ($a->type == 2) 
					{
						$mode = 'Audio';
					}
					elseif ($a->type == 3) 
					{
						$mode = 'Chat';
					}
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					
					$title2 ="Shaktipeeth Digital Online Consultation";
					$message2 = "Your ".$mode." consultation with ".$user->name." is booked for ".date('d M, Y',strtotime($key->schedule_date))." at ".date('h:ia',strtotime($key->schedule_time))." Time for ".$key->total_minutes." minutes. Remain only one 5 minutes to start.";
					
					$selected_android_user2 = array();
					if($astrologers->device_type == 'android')
			        {   
			        	if($astrologers->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $astrologers->device_token);
			            }
			            
			        }
					elseif ($astrologers->device_type == 'ios') 
			        {
						// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
			        }
			        if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

			                );
						$a = $this->sendMessageThroughFCM($selected_android_user2,$message2,$settings->astrologer_firebase);
			        }
			        $noti_array = array("type"=>$mode,"for_"=>"astrologer","user_id"=>$astrologers->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
					$this->db->insert('astrologer_notification',$noti_array);
				
					//to user notification
					$title_user = "Shaktipeeth Digital Online Consultation";
					$message_user = "Your ".$mode." consultation with ".$astrologers->name." is booked for ".date('d M, Y',strtotime($key->schedule_date))." at ".date('h:ia',strtotime($key->schedule_time))." Time for ".$key->total_minutes." minutes. Remain only 5 minutes to start.";
					$selected_android_user1 = array();
					if($user->device_type == 'android')
			        {   
			            if($user->device_token!='abc')
			            {
			            	array_push($selected_android_user1, $user->device_token);
			            }
			            
			        }
					elseif ($user->device_type == 'ios') 
			        {
						// $this->w_m->send_ios_notification($user->device_token,$message1,$mode);
			        }
			        if(count($selected_android_user1))
			        {
			        	$notification_type1 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title_user.'","msg":"'.$message_user.'","type":"no"}';
			            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
			            $message_user_ = array(
			                    'body' => $message_user,
			                    'title' => $title_user,
			                    'sound' => 'default'
			                );
						$a = $this->w_m->sendMessageThroughFCM($selected_android_user1,$message_user_,$settings->firebase_key);
			    	}
			    	$noti_array_user = array("type"=>$mode,"for_"=>"user","user_id"=>$user->id,"title"=>$title_user,"notification"=>$message_user,"booking_id"=>$key->id,"added_on"=>date('Y-m-d H:i:s'));
					$this->db->insert('user_notification',$noti_array_user);

			        $this->db->query("UPDATE `bookings` SET `five_minutes_notification` = '1' WHERE `id`=$key->id ");
				}
			}		
		}
	}



	// one hour before reminder notification
	public function send_video_notificationonehour()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		$list_bookings = $this->db->query("SELECT * FROM booking_history WHERE `schedule_date` = '$date1' AND `schedule_time` <> 'ANY TIME' AND `status` = '0' AND `one_hour_notification` = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
				// Send to doctor Notification
				$btime = strtotime($key->booking_date_time);
				$b60_befor = strtotime("-61 minutes", $btime);
				if ($date >= $b60_befor) 
				{
					$puja = $this->db->get_where("puja",array("id"=>$key->puja_id))->row();
					$title = 'Reminder for puja booking!';
					$for_user = "Puja ".$puja->name." booking started at ".date('h:ia',strtotime($key->schedule_time))." on ".date('d M, Y',strtotime($key->schedule_date))." so please be ready to receive and accept the connection";
					$for_supervider = "Puja ".$puja->name." booking started at ".date('h:ia',strtotime($key->schedule_time))." on ".date('d M, Y',strtotime($key->schedule_date))." so please be ready to receive and accept the connection";
					$for_priest = "Puja ".$puja->name." booking started at ".date('h:ia',strtotime($key->schedule_time))." on ".date('d M, Y',strtotime($key->schedule_date))." so please be ready to receive and accept the connection";
					$for_admin = "Puja ".$puja->name." booking started at ".date('h:ia',strtotime($key->schedule_time))." on ".date('d M, Y',strtotime($key->schedule_date))." so please be ready to receive and accept the connection";

					if ($key->supervisor_id > 0 && $key->priest_id > 0) 
					{
						$user = $this->db->get_where("user",array("id"=>$key->user_id))->row();
						$supervisor = $this->db->get_where("supervisor",array("id"=>$key->supervisor_id))->row();
						$priest = $this->db->get_where("priest",array("id"=>$key->priest_id))->row();
						$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
						$notificationtype = "text";
				        $user_array = array();
						if($user->device_type == 'android')
				        {   
				        	if($user->device_token!='abc')
				            {
				            	array_push($user_array, $user->device_token);
				            }
				            
				        }
						elseif ($user->device_type == 'ios') 
				        {
							// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
				        }
				        if(count($user_array) > 0)
				        {
				        	$respJson1 = '{"notification_type":"'.$notificationtype.'","title":"'.$title.'","msg":"'.$for_user.'","type":"no"}';
				            $user_packet = array(
				                    'body' => $for_user,
				                    'title' => $title,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

				                );
							$this->sendMessageThroughFCM($user_array,$user_packet,$settings->firebase_key);
				        }
				        $noti_array = array("type"=>'puja_booking',"for_"=>"user","user_id"=>$user->id,"title"=>$title,"notification"=>$for_user,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
						$this->db->insert('user_notification',$noti_array);

						//
						$supervisor_array = array();
						if($supervisor->device_type == 'android')
				        {   
				        	if($supervisor->device_token!='abc')
				            {
				            	array_push($supervisor_array, $supervisor->device_token);
				            }
				            
				        }
						elseif ($supervisor->device_type == 'ios') 
				        {
							// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
				        }
				        if(count($supervisor_array) > 0)
				        {
				        	$respJson1 = '{"notification_type":"'.$notificationtype.'","title":"'.$title.'","msg":"'.$for_user.'","type":"no"}';
				            $supervisor_packet = array(
				                    'body' => $supervisor_array,
				                    'title' => $title,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

				                );
							$this->sendMessageThroughFCM($supervisor_array,$supervisor_packet,$settings->supervisor_firebase_key);
				        }
				        $noti_array = array("type"=>'puja_booking',"for_"=>"supervisor","user_id"=>$supervisor->id,"title"=>$title,"notification"=>$supervisor_array,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
						$this->db->insert('supervisor_notification',$noti_array);

						//
						$priest_array = array();
						if($priest->device_type == 'android')
				        {   
				        	if($priest->device_token!='abc')
				            {
				            	array_push($priest_array, $priest->device_token);
				            }
				            
				        }
						elseif ($priest->device_type == 'ios') 
				        {
							// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
				        }
				        if(count($priest_array) > 0)
				        {
				        	$respJson1 = '{"notification_type":"'.$notificationtype.'","title":"'.$title.'","msg":"'.$for_priest.'","type":"no"}';
				            $priest_packet = array(
				                    'body' => $priest_array,
				                    'title' => $title,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

				                );
							$this->sendMessageThroughFCM($priest_array,$priest_packet,$settings->priest_firebase_key);
				        }
				        $noti_array = array("type"=>'puja_booking',"for_"=>"priest","user_id"=>$priest->id,"title"=>$title,"notification"=>$for_priest,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
						$this->db->insert('priest_notification',$noti_array);
					}
					elseif ($key->supervisor_id > 0) 
					{
						$user = $this->db->get_where("user",array("id"=>$key->user_id))->row();
						$supervisor = $this->db->get_where("supervisor",array("id"=>$key->supervisor_id))->row();
						$priest = $this->db->get_where("priest",array("id"=>$key->priest_id))->row();
						$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
						$notificationtype = "text";
				        $user_array = array();
						if($user->device_type == 'android')
				        {   
				        	if($user->device_token!='abc')
				            {
				            	array_push($user_array, $user->device_token);
				            }
				            
				        }
						elseif ($user->device_type == 'ios') 
				        {
							// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
				        }
				        if(count($user_array) > 0)
				        {
				        	$respJson1 = '{"notification_type":"'.$notificationtype.'","title":"'.$title.'","msg":"'.$for_user.'","type":"no"}';
				            $user_packet = array(
				                    'body' => $for_user,
				                    'title' => $title,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

				                );
							$this->sendMessageThroughFCM($user_array,$user_packet,$settings->firebase_key);
				        }
				        $noti_array = array("type"=>'puja_booking',"for_"=>"user","user_id"=>$user->id,"title"=>$title,"notification"=>$for_user,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
						$this->db->insert('user_notification',$noti_array);

						//
						$supervisor_array = array();
						if($supervisor->device_type == 'android')
				        {   
				        	if($supervisor->device_token!='abc')
				            {
				            	array_push($supervisor_array, $supervisor->device_token);
				            }
				            
				        }
						elseif ($supervisor->device_type == 'ios') 
				        {
							// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
				        }
				        if(count($supervisor_array) > 0)
				        {
				        	$respJson1 = '{"notification_type":"'.$notificationtype.'","title":"'.$title.'","msg":"'.$for_user.'","type":"no"}';
				            $supervisor_packet = array(
				                    'body' => $supervisor_array,
				                    'title' => $title,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

				                );
							$this->sendMessageThroughFCM($supervisor_array,$supervisor_packet,$settings->supervisor_firebase_key);
				        }
				        $noti_array = array("type"=>'puja_booking',"for_"=>"supervisor","user_id"=>$supervisor->id,"title"=>$title,"notification"=>$supervisor_array,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
						$this->db->insert('supervisor_notification',$noti_array);
					}
					$this->db->query("UPDATE `booking_history` SET `one_hour_notification` = '1' WHERE `id`=$key->id ");
				}
			}		
		}
	}

	public function send_video_notificationfifteenminutes()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		// $endTime = date('Y-m-d H:i:s',strtotime("+60 minutes", $date));
		// $endTime
		$list_bookings = $this->db->query("SELECT * FROM booking WHERE `booking_date` = '$date1' AND `priest_id` <> '0' AND `booking_time` <> 'ANY TIME' AND `status` = '0' AND `one_hour_notification` = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
				// Send to doctor Notification
				$btime = strtotime($key->booking_date_time);
				$b60_befor = strtotime("-16 minutes", $btime);
				if ($date >= $b60_befor) 
				{
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					$priest_d = $this->db->get_where("priest",array("id"=>$key->priest_id))->row();
					$title1 = "SHAKTIPEETH";
					$message1 = "Your Online Puja with ".$key->name." is booked for ".date('d M, Y',strtotime($key->booking_date))." at ".$key->booking_time." Time for ".$key->booking_time." minutes. Remain only 15 minutes to start.";
					$selected_android_user1 = array();
					if($priest_d->device_type == 'android')
			        {   
			            if($priest_d->device_token!='abc')
			            {
			            	array_push($selected_android_user1, $priest_d->device_token);
			            }
			            
			        }
					elseif ($priest_d->device_type == 'ios') 
	                {
						//$this->send_ios_notification($priest_d->device_token,$message1,$priest_d->booking_mode);
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

			            $a = $this->sendMessageThroughFCM($selected_android_user1,$message2,$settings->priest_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$priest_d->id,"title"=>$title1,"notification"=>$message1,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
						$this->db->insert('priest_notification',$noti_array);
			     	}
					

					// send to user notification
					$title2 = "SHAKTIPEETH PUJA BOOKING!";
					$message2 = $priest_d->name." is going to connect with you at ".$key->booking_time." on ".date('d M, Y',strtotime($key->booking_date))." so please be ready to receive and accept the connection from ".$key->name;
					$get_user = $this->w_m->get_user($key->user_id);
					$selected_android_user2 = array();
					if($get_user->device_type == 'android')
			        {   
			        	if($get_user->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $get_user->device_token);
			            }
			            
			        }
					elseif ($get_user->device_type == 'ios') 
	                {
						//$this->send_ios_notification($key->patient_token,$message2,$key->booking_mode);
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

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->firebase_key);
			            $noti_array = array("type"=>"online","user_id"=>$get_user->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$key->id);
						$this->db->insert('user_notification',$noti_array);
			        }

			        $this->db->query("UPDATE `booking` SET `fifteen_minutes_notification` = '1' WHERE `id`=$key->id ");
				}
			}		
		}
	}

	
	public function send_video_chat_notification5minutes()
	{
		$date = time();
		$date1 = date('Y-m-d'); 
		$list_bookings = $this->db->query("SELECT a.id,a.booking_date_time,b.name AS name,a.online_mode,a.id,a.booking_date,a.booking_time,c.doctor_firstname,c.deviceToken as doctor_device_token ,c.deviceType  as doctor_device_type,b.device_token as patient_token,b.device_type  FROM booking a JOIN patient b ON b.id=a.patient_id JOIN doctor c ON c.id = a.doctor_id WHERE `booking_date` = '$date1' AND a.status = '0' AND a.five_minutes_notification = '0'")->result();
		if (count($list_bookings) > 0) 
		{
			foreach ($list_bookings as $key) 
			{
					// Send to doctor Notification
					$btime = strtotime($key->booking_date_time);
					$b15_befor = strtotime("-6 minutes", $btime);
					if ($date >= $b15_befor) 
					{
						$title1 = "DISKUSS";//"[Reminder] Online Consultant ".$key->online_mode;
						$message1 = "Your Online Appointment with ".$key->name." is booked for ".date('d M, Y',strtotime($key->booking_date))." at ".$key->booking_time." Time for 15 Minutes";
						$selected_android_user1 = array();
						if($key->doctor_device_type == 'android')
				        {   
				            if($key->doctor_device_token!='abc')
				            {
				            	array_push($selected_android_user1, $key->doctor_device_token);
				            }
				            
				        }
						elseif ($key->doctor_device_type == 'ios') 
		                {
							$this->send_ios_notification($key->doctor_device_token,$message1,$key->booking_mode);
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

				            $a = $this->sendMessageThroughFCMdoctor($selected_android_user1,$message2);
				   		 }
					

						// send to patient notification
						$title2 = "DISKUSS CONSULTATION";//"[Reminder] Online Consultant ".$key->online_mode;
						if ($key->online_mode == 'chat') 
						{
							$message2 = $key->doctor_firstname." is going to connect with you at ".$key->booking_time." on ".date('d M, Y',strtotime($key->booking_date))." so please be ready to receive and accept the chat connection from ".$key->doctor_firstname;
						}
						else
						{
							$message2 = $key->doctor_firstname." is going to call you at ".$key->booking_time.' on '.date('d M, Y',strtotime($key->booking_date)).". Please be ready to receive and accept the ".$key->online_mode." call.";
						}

						
						$selected_android_user2 = array();
						if($key->device_type == 'android')
				        {   
				        	if($key->patient_token!='abc')
				            {
				            	array_push($selected_android_user2, $key->patient_token);
				            }
				            
				        }
						elseif ($key->device_type == 'ios') 
		                {
							$this->send_ios_notification($key->patient_token,$message2,$key->booking_mode);
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

				        $this->db->query("UPDATE `booking` SET `five_minutes_notification` = '1' WHERE `id`=$key->id ");
					}
			}		
		}
	}

	public function common_notification()
	{
		$id = $this->input->post("id");
		$method = $this->input->post("method");
		$completed_on = $this->input->post("completed_on");
		$this->$method($id,$completed_on);
		
	}

	public function send_start_consult_notification_alert($id='')
	{
		// $id = $this->input->post("id");
		$get_booking_details = $this->db->get_where('bookings',array("id"=>$id));
		if ($get_booking_details->num_rows() > 0) 
		{
			$a = $get_booking_details->row();
			$user = $this->db->get_where("user",array("id"=>$a->user_id))->row();
			$astrologers = $this->db->get_where("astrologers",array("id"=>$a->assign_id))->row();
			$mode = '';
			if ($a->type == 1) 
			{
				$mode = 'Video';
			}
			elseif ($a->type == 2) 
			{
				$mode = 'Audio';
			}
			elseif ($a->type == 3) 
			{
				$mode = 'Chat';
			}
			$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
			
			$title2 ="Shaktipeeth Digital Online Consultation";
			$message2 = "Your Online ".ucfirst($mode)." Consulting Session with ".$user->name." is started";
			
			$selected_android_user2 = array();
			if($astrologers->device_type == 'android')
	        {   
	        	if($astrologers->device_token!='abc')
	            {
	            	array_push($selected_android_user2, $astrologers->device_token);
	            }
	            
	        }
			elseif ($astrologers->device_type == 'ios') 
	        {
				// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
	        }
	        if(count($selected_android_user2))
	        {
	        	$notification_type2 = "text";
	            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
	            $message3 = array(
	                    'body' => $message2,
	                    'title' => $title2,
	                    'sound' => 'default',
	                    'type' => 'live',
	                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

	                );
				$a = $this->sendMessageThroughFCM($selected_android_user2,$message2,$settings->astrologer_firebase);
	        }
	        $noti_array = array("type"=>$mode,"for_"=>"astrologer","user_id"=>$astrologers->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'));
			$this->db->insert('astrologer_notification',$noti_array);
		
			//to user notification
			$title_user = "Shaktipeeth Digital Online Consultation";
			$message_user = "Your Online ".ucfirst($mode)." Consulting Session with ".$astrologers->name." is starting now.";
			$selected_android_user1 = array();
			if($user->device_type == 'android')
	        {   
	            if($user->device_token!='abc')
	            {
	            	array_push($selected_android_user1, $user->device_token);
	            }
	            
	        }
			elseif ($user->device_type == 'ios') 
	        {
				// $this->w_m->send_ios_notification($user->device_token,$message1,$mode);
	        }
	        if(count($selected_android_user1))
	        {
	        	$notification_type1 = "text";
	            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title_user.'","msg":"'.$message_user.'","type":"no"}';
	            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
	            $message_user_ = array(
	                    'body' => $message_user,
	                    'title' => $title_user,
	                    'sound' => 'default'
	                );
				$a = $this->w_m->sendMessageThroughFCM($selected_android_user1,$message_user_,$settings->firebase_key);
	    	}
	    	$noti_array_user = array("type"=>$mode,"for_"=>"user","user_id"=>$user->id,"title"=>$title_user,"notification"=>$message_user,"added_on"=>date('Y-m-d H:i:s'));
			$this->db->insert('user_notification',$noti_array_user);

		}
	}

	public function complete_astrologer_bookings($id='')
	{
		// $id = $this->input->post("id");
		$get_booking_details = $this->db->get_where('bookings',array("id"=>$id));
		if ($get_booking_details->num_rows() > 0) 
		{
			$a = $get_booking_details->row();
			$user = $this->db->get_where("user",array("id"=>$a->user_id))->row();
			$astrologers = $this->db->get_where("astrologers",array("id"=>$a->assign_id))->row();
			$mode = '';
			if ($a->type == 1) 
			{
				$mode = 'Video';
			}
			elseif ($a->type == 2) 
			{
				$mode = 'Audio';
			}
			elseif ($a->type == 3) 
			{
				$mode = 'Chat';
			}
			$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
			
			$title2 ="Shaktipeeth Digital Online Consultation Completed!";
			$message2 = "Your Online ".ucfirst($mode)." Consulting Session with ".$user->name." is completed";
			
			$selected_android_user2 = array();
			if($astrologers->device_type == 'android')
	        {   
	        	if($astrologers->device_token!='abc')
	            {
	            	array_push($selected_android_user2, $astrologers->device_token);
	            }
	            
	        }
			elseif ($astrologers->device_type == 'ios') 
	        {
				// $this->send_ios_notification($astrologers->device_token,$message2,$mode);
	        }
	        if(count($selected_android_user2))
	        {
	        	$notification_type2 = "text";
	            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
	            $message3 = array(
	                    'body' => $message2,
	                    'title' => $title2,
	                    'sound' => 'default',
	                    'type' => 'live',
	                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

	                );
				$a = $this->sendMessageThroughFCM($selected_android_user2,$message2,$settings->astrologer_firebase);
	        }
	        $noti_array = array("type"=>$mode,"for_"=>"astrologer","user_id"=>$astrologers->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'));
			$this->db->insert('astrologer_notification',$noti_array);
		
			//to user notification
			$title_user = "Shaktipeeth Digital Online Consultation!";
			$message_user = "Your Online ".ucfirst($mode)." Consulting Session with ".$astrologers->name." is completed.";
			$selected_android_user1 = array();
			if($user->device_type == 'android')
	        {   
	            if($user->device_token!='abc')
	            {
	            	array_push($selected_android_user1, $user->device_token);
	            }
	            
	        }
			elseif ($user->device_type == 'ios') 
	        {
				// $this->w_m->send_ios_notification($user->device_token,$message1,$mode);
	        }
	        if(count($selected_android_user1))
	        {
	        	$notification_type1 = "text";
	            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title_user.'","msg":"'.$message_user.'","type":"no"}';
	            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
	            $message_user_ = array(
	                    'body' => $message_user,
	                    'title' => $title_user,
	                    'sound' => 'default'
	                );
				$a = $this->w_m->sendMessageThroughFCM($selected_android_user1,$message_user_,$settings->firebase_key);
	    	}
	    	$noti_array_user = array("type"=>$mode,"for_"=>"user","user_id"=>$user->id,"title"=>$title_user,"notification"=>$message_user,"added_on"=>date('Y-m-d H:i:s'));
			$this->db->insert('user_notification',$noti_array_user);

		}
	}

	public function new_booking_to_all_supervisor($id)
	{
		$get_booking_detail = $this->db->get_where("booking",array("status"=>0,"id"=>$id))->row();
		if (count($get_booking_detail) > 0) 
		{
			$get_user = $this->w_m->get_user($get_booking_detail->user_id);
			$get_list_supervisor = $this->db->get_where("supervisor",array("status"=>1,"location"=>$get_booking_detail->booking_location))->result();
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->puja_id'")->row();//get_where("pooja",array("id"=>$get_booking_detail->puja_id))->row();
			$booking_other_details = $this->db->get_where("booking_other_details",array("booking_id"=>$id))->row();
			$venue_details = '';
			if (count($booking_other_details) > 0) 
			{
				$get_venue = $this->db->get_where("puja_venue_table",array("id"=>$booking_other_details->venue_id))->row();
				if (count($get_venue) > 0) 
				{
					$venue_details = $get_venue->venue_name;
				}
			}
			if (count($get_list_supervisor) > 0) 
			{
				$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
				$title2 ="New Pooja Booking!";
				foreach ($get_list_supervisor as $key) 
				{	
					$message2 = "Dear ".$key->name." new  order id-".$id." worth Rs. ".$get_booking_detail->total_amount.".  Booked Pujas : ".$get_puja_detail->name." (online)  ".$venue_details." ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time.".";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
			}

			//to admin
			$title_admin ="New Pooja Booking!";
			$message_admin = "Dear Admin new order booked by ".$get_booking_detail->name.'/'.$get_user->phone."  order id-".$id." worth Rs. ".$get_booking_detail->total_amount.".  Booked Pujas : ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." ".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->booking_date)).".";
			$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
			$this->db->insert('admin_notification',$noti_array);	

			

		}
	}

	public function to_all_supervisor_cancel_content($id)
	{
		$get_booking_detail = $this->db->get_where("booking",array("id"=>$id))->row();
		if (count($get_booking_detail) > 0) 
		{
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->puja_id'")->row();//$this->db->get_where("pooja",array("id"=>$get_booking_detail->puja_id))->row();
			$booking_other_details = $this->db->get_where("booking_other_details",array("booking_id"=>$id))->row();
			$venue_details = '';
			if (count($booking_other_details) > 0) 
			{
				$get_venue = $this->db->get_where("puja_venue_table",array("id"=>$booking_other_details->venue_id))->row();
				if (count($get_venue) > 0) 
				{
					$venue_details = $get_venue->venue_name;
				}
			}
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1))->row();
				if (count($key) > 0) 
				{
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					$title2 ="Pooja Booking Cancel!";
					$message2 = "Booking Cancel: Dear ".$key->name.", Booking of ".$id." $get_booking_detail->name is  cancelled by the cutomer $get_booking_detail->name on ".date('d/m/Y').".";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
				if ($get_booking_detail->priest_id != 0) 
				{
					$key2 = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1))->row();
					if (count($key2) > 0) 
					{
						$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
						$title2 ="Pooja Booking Cancel!";
						$message2 = "Booking Cancel: Dear ".$key2->name.", Booking of ".$id." $get_booking_detail->name is cancelled by the cutomer on ".date('d/m/Y')." and order id-".$id.".";
						$selected_android_user2 = array();
						if($key2->device_type == 'android')
				        {   
				        	if($key2->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key2->device_token);
				            }
				            
				        }
						elseif ($key2->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('priest_notification',$noti_array);		
				        }
					}
				}
			}
			else
			{
				$get_list_supervisor = $this->db->get_where("supervisor",array("status"=>1,"location"=>$get_booking_detail->booking_location))->result();
				if (count($get_list_supervisor) > 0) 
				{
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					$title2 ="New Pooja Booking!";
					foreach ($get_list_supervisor as $key) 
					{	
						$message2 = "Booking Cancel: Dear ".$key->name.", Booking of ".$id." $get_booking_detail->name is  cancelled by the cutomer $get_booking_detail->name on ".date('d/m/Y').".";
						$selected_android_user2 = array();
						if($key->device_type == 'android')
				        {   
				        	if($key->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key->device_token);
				            }
				            
				        }
						elseif ($key->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('supervisor_notification',$noti_array);		
				        }
					}
				}
			}

			$get_user = $this->w_m->get_user($get_booking_detail->user_id);
			//to admin
			$title_admin ="Pooja Booking Cancel!";
			$message_admin = "Booking Cancel: Dear Admin, Booking of ".$get_booking_detail->name.'/'.$get_user->phone." is  cancelled by the cutomer on ".date('d M, Y',strtotime($get_booking_detail->booking_date))." and order id-".$id.".";
			$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
			$this->db->insert('admin_notification',$noti_array);
		}
	}

	public function puja_start($id)
	{
		$get_booking_detail_ = $this->db->get_where("booking_history",array("id"=>$id));
		if ($get_booking_detail_->num_rows() > 0) 
		{
			$get_booking_detail = $get_booking_detail_->row();
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->main_location_id'")->row();//$this->db->get_where("pooja",array("id"=>$get_booking_detail->puja_id))->row();
			$booking_other_details = $this->db->get_where("booking_other_details",array("booking_id"=>$id))->row();
			$venue_details = '';
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key_ = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1));
				if ($key_->num_rows() > 0) 
				{
					$key = $key_->row();
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					$title2 ="Pooja Booking Started!";
					$message2 = "Puja Start: Dear ".$key->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." is started";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
				if ($get_booking_detail->priest_id != 0) 
				{
					$key2_ = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1));
					if ($key2_->num_rows() > 0) 
					{
						$key2 = $key2_->row();
						$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
						$title2 ="Pooja Booking Started!";
						$message2 = "Puja Start: Dear ".$key2->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." is started";
						$selected_android_user2 = array();
						if($key2->device_type == 'android')
				        {   
				        	if($key2->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key2->device_token);
				            }
				            
				        }
						elseif ($key2->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('priest_notification',$noti_array);		
				        }
					}
				}
			}
			
			$get_user = $this->w_m->get_user($get_booking_detail->user_id);
			//to admin
			$title_admin ="Pooja Booking Started!";
			$message_admin = "Puja Start: Dear Admin Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." against Order-".$id." for Customer ".$get_booking_detail->host_name." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." is started";
			$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
			$this->db->insert('admin_notification',$noti_array);
		}
	}

	public function puja_start_supervisor($id)
	{
		$get_booking_detail_ = $this->db->get_where("booking_history",array("id"=>$id));
		if ($get_booking_detail_->num_rows() > 0) 
		{
			$get_booking_detail = $get_booking_detail_->row();
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->main_location_id'")->row();
			$venue_details = $get_booking_detail->venue;
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key_ = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1));
				if ($key_->num_rows() > 0) 
				{
					$key = $key_->row();
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					$title2 ="Pooja Booking Started!";
					$message2 = "Puja Start: Dear ".$key->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." is started";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
				if ($get_booking_detail->priest_id != 0) 
				{
					$key2_ = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1));
					if ($key2_->num_rows() > 0) 
					{
						$key2 = $key2_->row();
						$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
						$title2 ="Pooja Booking Started!";
						$message2 = "Puja Start: Dear ".$key2->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." is started";
						$selected_android_user2 = array();
						if($key2->device_type == 'android')
				        {   
				        	if($key2->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key2->device_token);
				            }
				            
				        }
						elseif ($key2->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('priest_notification',$noti_array);		
				        }
					}
				}
			}
			
			$get_user = $this->w_m->get_user($get_booking_detail->user_id);
			//to admin
			$title_admin ="Pooja Booking Started!";
			$message_admin = "Puja Start: Dear Admin Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." against Order-".$id." for Customer ".$get_booking_detail->host_name." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." is started";
			$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
			$this->db->insert('admin_notification',$noti_array);
		}
	}


	public function completed_booking($id,$booking_complete='')
	{
		
		$get_booking_detail = $this->db->get_where("booking",array("id"=>$id))->row();
		if (count($get_booking_detail) > 0) 
		{
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->main_location_id'")->row();;//$this->db->get_where("pooja",array("id"=>$get_booking_detail->puja_id))->row();
			$booking_other_details = $this->db->get_where("booking_other_details",array("booking_id"=>$id))->row();
			$venue_details = '';
			if (count($booking_other_details) > 0) 
			{
				$get_venue = $this->db->get_where("puja_venue_table",array("id"=>$booking_other_details->venue_id))->row();
				if (count($get_venue) > 0) 
				{
					$venue_details = $get_venue->venue_name;
				}
			}
			$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1))->row();
				if (count($key) > 0) 
				{
					$title2 ="Pooja Booking Completed!";
					$message2 = "Puja Start: Dear ".$key->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is completed.";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
				if ($get_booking_detail->priest_id != 0) 
				{
					$key2 = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1))->row();
					if (count($key2) > 0) 
					{
						$title2 ="Pooja Booking Completed!";
						$message2 = "Puja Start: Dear ".$key2->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is completed.";
						$selected_android_user2 = array();
						if($key2->device_type == 'android')
				        {   
				        	if($key2->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key2->device_token);
				            }
				            
				        }
						elseif ($key2->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('priest_notification',$noti_array);		
				        }
					}
				}
			}
			
			$get_user = $this->w_m->get_user($get_booking_detail->user_id);
			if (count($get_user) > 0) 
			{
				$title2 ="Pooja Booking Completed!";
				$message2 = "Puja Start: Dear ".$get_user->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is completed.";
				$selected_android_user2 = array();
				if($get_user->device_type == 'android')
		        {   
		        	if($get_user->device_token!='abc')
		            {
		            	array_push($selected_android_user2, $get_user->device_token);
		            }
		            
		        }
				elseif ($get_user->device_type == 'ios') 
                {
					//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
                }
                if(count($selected_android_user2))
		        {
		        	$notification_type2 = "text";
		            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
		            $message3 = array(
		                    'body' => $message2,
		                    //'title' => $title2,
		                    'sound' => 'default',
		                    'type' => 'live',
		                    'booking_id' => $id,
		                );

		            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->firebase_key);
		            $noti_array = array("type"=>"online","user_id"=>$get_user->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
					$this->db->insert('user_notification',$noti_array);		
		        }
			}
			//to admin
			$title_admin ="Pooja Booking Completed!";
			$message_admin = "Puja Complete: Dear Admin Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." against Order-".$id." for Customer ".$get_booking_detail->name." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is completed.";
			$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
			$this->db->insert('admin_notification',$noti_array);
		}
	}

	public function missed_booking($id,$booking_complete='')
	{
		
		$get_booking_detail = $this->db->get_where("booking",array("id"=>$id))->row();
		if (count($get_booking_detail) > 0) 
		{
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->puja_id'")->row();;//$this->db->get_where("pooja",array("id"=>$get_booking_detail->puja_id))->row();
			$booking_other_details = $this->db->get_where("booking_other_details",array("booking_id"=>$id))->row();
			$venue_details = '';
			if (count($booking_other_details) > 0) 
			{
				$get_venue = $this->db->get_where("puja_venue_table",array("id"=>$booking_other_details->venue_id))->row();
				if (count($get_venue) > 0) 
				{
					$venue_details = $get_venue->venue_name;
				}
			}
			$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1))->row();
				if (count($key) > 0) 
				{
					$title2 ="Pooja Booking Missed!";
					$message2 = "Puja Start: Dear ".$key->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is missed.";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
				if ($get_booking_detail->priest_id != 0) 
				{
					$key2 = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1))->row();
					if (count($key2) > 0) 
					{
						$title2 ="Pooja Booking Missed!";
						$message2 = "Puja Start: Dear ".$key2->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is missed.";
						$selected_android_user2 = array();
						if($key2->device_type == 'android')
				        {   
				        	if($key2->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key2->device_token);
				            }
				            
				        }
						elseif ($key2->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('priest_notification',$noti_array);		
				        }
					}
				}
			}
			
			$get_user = $this->w_m->get_user($get_booking_detail->user_id);
			if (count($get_user) > 0) 
			{
				$title2 ="Pooja Booking Missed!";
				$message2 = "Puja Start: Dear ".$get_user->name." Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is missed.";
				$selected_android_user2 = array();
				if($get_user->device_type == 'android')
		        {   
		        	if($get_user->device_token!='abc')
		            {
		            	array_push($selected_android_user2, $get_user->device_token);
		            }
		            
		        }
				elseif ($get_user->device_type == 'ios') 
                {
					//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
                }
                if(count($selected_android_user2))
		        {
		        	$notification_type2 = "text";
		            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
		            $message3 = array(
		                    'body' => $message2,
		                    //'title' => $title2,
		                    'sound' => 'default',
		                    'type' => 'live',
		                    'booking_id' => $id,
		                );

		            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->firebase_key);
		            $noti_array = array("type"=>"online","user_id"=>$get_user->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
					$this->db->insert('user_notification',$noti_array);		
		        }
			}
			//to admin
			$title_admin ="Pooja Booking Missed!";
			$message_admin = "Puja Complete: Dear Admin Puja details ".$get_puja_detail->name." (online) - ".$get_booking_detail->booking_location." -".$venue_details." against Order-".$id." for Customer ".$get_booking_detail->name." - ".date('d M, Y',strtotime($get_booking_detail->booking_date))." at ".$get_booking_detail->booking_time." is missed.";
			$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
			$this->db->insert('admin_notification',$noti_array);
		}
	}


	public function accepted_by_supervisor($id)
	{
		$get_booking_detail_ = $this->db->get_where("booking_history",array("id"=>$id));
		if ($get_booking_detail_->num_rows() > 0) 
		{
			$get_booking_detail = $get_booking_detail_->row();
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->main_location_id'")->row();
			$booking_other_details = $this->db->get_where("booking_other_details",array("booking_id"=>$id))->row();
			$venue_details = '('.$get_booking_detail->venue.') ';
			
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key_ = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1));
				if ($key_->num_rows() > 0) 
				{
					$key = $key_->row();
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					
					$user = $this->db->get_where("user",array("id"=>$get_booking_detail->user_id))->row();
					//to user notification
					$title_user = "Pooja Booking Accepted!";
					$message_user = "Supervisor ".$key->name." accepted the puja - ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location.$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and orderid ".$get_booking_detail->booking_id.".";
					$selected_android_user1 = array();
					if($user->device_type == 'android')
			        {   
			            if($user->device_token!='abc')
			            {
			            	array_push($selected_android_user1, $user->device_token);
			            }
			            
			        }
					elseif ($user->device_type == 'ios') 
			        {
						// $this->w_m->send_ios_notification($user->device_token,$message1,$mode);
			        }
			        if(count($selected_android_user1))
			        {
			        	$notification_type1 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title_user.'","msg":"'.$message_user.'","type":"no"}';
			            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
			            $message_user_ = array(
			                    'body' => $message_user,
			                    'title' => $title_user,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );
						$a = $this->w_m->sendMessageThroughFCM($selected_android_user1,$message_user_,$settings->firebase_key);
			    	}
			    	$noti_array_user = array("type"=>$get_booking_detail->mode,"for_"=>"user","user_id"=>$user->id,"title"=>$title_user,"notification"=>$message_user,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
					$this->db->insert('user_notification',$noti_array_user);

					$title2 ="Pooja Booking Accepted!";
					$message2 = "You have accepted the puja - ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location.$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and orderid ".$id.".";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			        }
			        $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
					$this->db->insert('supervisor_notification',$noti_array);		

			        $title_admin ="Pooja Booking Accepted!";
					$message_admin = "Dear Admin,supervisor ".$key->name." has accepted the puja - ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->end_time." and orderid ".$id.".";
					$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
					$this->db->insert('admin_notification',$noti_array);
				}
			}
			
			
		}
	}

	public function assigned_notification($id)
	{
		$get_booking_detail_ = $this->db->get_where("booking_history",array("id"=>$id));
		if ($get_booking_detail_->num_rows() > 0) 
		{
			$get_booking_detail = $get_booking_detail_->row();
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->main_location_id'")->row();//$this->db->get_where("pooja",array("id"=>$get_booking_detail->puja_id))->row();
			$venue_details = $get_booking_detail->venue;
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key_ = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1));
				if ($key_->num_rows() > 0) 
				{
					$key = $key_->row();
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					$priest_d = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1))->row();
					$title2 ="Pooja Booking Assign!";
					$message2 = "You have assigned Priest ".$priest_d->name." for ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and orderid ".$id.".";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
				if ($get_booking_detail->priest_id != 0) 
				{
					$key2_ = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1));
					if ($key2_->num_rows() > 0) 
					{
						$key2 = $key2_->row();
						$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
						$title2 ="Pooja Booking Assign!";
						$message2 = "Dear ".$key2->name." you have been assigned for ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and orderid ".$id.".";
						$selected_android_user2 = array();
						if($key2->device_type == 'android')
				        {   
				        	if($key2->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key2->device_token);
				            }
				            
				        }
						elseif ($key2->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('priest_notification',$noti_array);		
				        }

				        //to admin
						$title_admin ="Pooja Booking Assign!";
						$message_admin = "Dear Admin,Priest ".$key2->name." is assigned for ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and orderid ".$id.".";
						$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('admin_notification',$noti_array);
					}
				}
			}
			
			
		}
	}

	public function reassign_notification($id,$old_priest)
	{
		$get_booking_detail_ = $this->db->get_where("booking_history",array("id"=>$id));
		if ($get_booking_detail_->num_rows() > 0) 
		{
			$get_booking_detail = $get_booking_detail_->row();
			$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get_booking_detail->main_location_id'")->row();
			$venue_details = $get_booking_detail->venue;
			
			if ($get_booking_detail->supervisor_id != 0) 
			{
				$key_ = $this->db->get_where("supervisor",array("id"=>$get_booking_detail->supervisor_id,"status"=>1));
				if ($key_->num_rows() > 0) 
				{
					$key = $key_->row();
					$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
					$priest_d = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1))->row();
					$title2 ="Pooja Booking Assign!";
					$message2 = "You have assigned Priest ".$priest_d->name." for ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and orderid -".$id.".";
					$selected_android_user2 = array();
					if($key->device_type == 'android')
			        {   
			        	if($key->device_token!='abc')
			            {
			            	array_push($selected_android_user2, $key->device_token);
			            }
			            
			        }
					elseif ($key->device_type == 'ios') 
	                {
						//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
	                }
	                if(count($selected_android_user2))
			        {
			        	$notification_type2 = "text";
			            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
			            $message3 = array(
			                    'body' => $message2,
			                    //'title' => $title2,
			                    'sound' => 'default',
			                    'type' => 'live',
			                    'booking_id' => $id,
			                );

			            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->supervisor_firebase_key);
			            $noti_array = array("type"=>"puja_booking","user_id"=>$key->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
						$this->db->insert('supervisor_notification',$noti_array);		
			        }
				}
				if ($get_booking_detail->priest_id != 0) 
				{
					$key2_ = $this->db->get_where("priest",array("id"=>$get_booking_detail->priest_id,"status"=>1));
					if ($key2_->num_rows() > 0) 
					{
						$key2 = $key2_->row();
						$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
						$title2 ="Pooja Booking Assign!";
						$message2 = "Dear ".$key2->name." you have been assigned for ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and order id -".$id.".";
						$selected_android_user2 = array();
						if($key2->device_type == 'android')
				        {   
				        	if($key2->device_token!='abc')
				            {
				            	array_push($selected_android_user2, $key2->device_token);
				            }
				            
				        }
						elseif ($key2->device_type == 'ios') 
		                {
							//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
		                }
		                if(count($selected_android_user2))
				        {
				        	$notification_type2 = "text";
				            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
				            $message3 = array(
				                    'body' => $message2,
				                    //'title' => $title2,
				                    'sound' => 'default',
				                    'type' => 'live',
				                    'booking_id' => $id,
				                );

				            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
				            $noti_array = array("type"=>"puja_booking","user_id"=>$key2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('priest_notification',$noti_array);		
				        }

				        $oldkey2_ = $this->db->get_where("priest",array("id"=>$old_priest,"status"=>1));
						if ($oldkey2_->num_rows() > 0) 
						{	
							$oldkey2 = $oldkey2_->row();
							$settings = $this->w_m->global_multiple_query('settings',array('id'=>1),'row()');
							$title2 ="Pooja Booking Reassign!";
							$message2 = "Dear ".$oldkey2->name." your puja ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and orderid -".$id." has been reassigned to another Priest.";
							$selected_android_user2 = array();
							if($oldkey2->device_type == 'android')
					        {   
					        	if($oldkey2->device_token!='abc')
					            {
					            	array_push($selected_android_user2, $oldkey2->device_token);
					            }
					            
					        }
							elseif ($oldkey2->device_type == 'ios') 
			                {
								//$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
			                }
			                if(count($selected_android_user2))
					        {
					        	$notification_type2 = "text";
					            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
					            $message3 = array(
					                    'body' => $message2,
					                    //'title' => $title2,
					                    'sound' => 'default',
					                    'type' => 'live',
					                    'booking_id' => $id,
					                );

					            $a = $this->sendMessageThroughFCM($selected_android_user2,$message3,$settings->priest_firebase_key);
					            $noti_array = array("type"=>"puja_booking","user_id"=>$oldkey2->id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
								$this->db->insert('priest_notification',$noti_array);		
					        }

					        //to admin
							$title_admin ="Pooja Booking Reassign!";
							$message_admin = "Dear Admin,Priest ".$key2->name." is reassigned instead of ".$oldkey2->name." for ".$get_puja_detail->name." (".ucfirst($get_booking_detail->mode).") - ".$get_booking_detail->booking_location." -".$venue_details." - ".date('d M, Y',strtotime($get_booking_detail->schedule_date))." at ".$get_booking_detail->schedule_time." and order id -".$id.".";
							$noti_array = array("type"=>"puja_booking","user_id"=>1,"title"=>$title_admin,"notification"=>$message_admin,"added_on"=>date('Y-m-d H:i:s'),"booking_id"=>$id);
							$this->db->insert('admin_notification',$noti_array);
						}
					}


				}
			}
			
			
		}
	}

	public function to_bookmarked_users()
	{
		$id = $this->input->post("doc_id");
		$get_list = $this->db->get_where("patient_bookmark",array("doctor_id"=>$id))->result();
		if (count($get_list) > 0) 
		{
			//for doctor
			$doctor = $this->db->get_where("doctor",array("id"=>$id))->row();
			// send to patient notification
			$title2 ="";//"Live broadcast";
			$message2 = $doctor->doctor_firstname." is now online. You can consult him.";
			foreach ($get_list as $key) 
			{
				$user = $this->db->get_where("patient",array("id"=>$key->patient_id))->row();
				$selected_android_user2 = array();
				if($user->device_type == 'android')
		        {   
		        	if($user->device_token!='abc')
		            {
		            	array_push($selected_android_user2, $user->device_token);
		            }
		            
		        }
				elseif ($user->device_type == 'ios') 
                {
					$this->send_ios_notification($user->device_token,$message2,$user->booking_mode);
                }
                if(count($selected_android_user2))
		        {
		        	$notification_type2 = "text";
		            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
		            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
		            $message3 = array(
		                    'body' => $message2,
		                    //'title' => $title2,
		                    'sound' => 'default',
		                    'type' => 'live',
		                    'doctor_id' => $id,
		                    'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

		                );

		            // $regIdChunk2=array_chunk($selected_android_user2,1000);
		            // foreach($regIdChunk2 as $RegId2){
						$a = $this->sendMessageThroughFCM($selected_android_user2,$message3);
		            // }
		            
		          
		        }
			}
			
		}
	}

	public function to_doctor_start_consultation()
	{
		$id = $this->input->post("doc_id");
		$mode = $this->input->post("mode");
		$user_id = $this->input->post("user_id");
		$doctor = $this->db->get_where("doctor",array("id"=>$id))->row();
		$user = $this->db->get_where("patient",array("id"=>$user_id))->row();
		
		/*
		$title2 ="DISKUSS ONLINE CONSULTATION";
		$message2 = "Your Online ".ucfirst($mode)." Consulting Session with ".$doctor->doctor_firstname." is starting now";
		
		$selected_android_user2 = array();
		if($doctor->deviceType == 'android')
        {   
        	if($doctor->deviceToken!='abc')
            {
            	array_push($selected_android_user2, $doctor->deviceToken);
            }
            
        }
		elseif ($doctor->deviceType == 'ios') 
        {
			$this->send_ios_notification($doctor->deviceToken,$message2,$doctor->booking_mode);
        }
        if(count($selected_android_user2))
        {
        	$notification_type2 = "text";
            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
            $message3 = array(
                    'body' => $message2,
                    //'title' => $title2,
                    'sound' => 'default',
                    'type' => 'live',
                    'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

                );
			$a = $this->sendMessageThroughFCM($selected_android_user2,$message3);
        }
        $noti_array = array("type"=>"online","user_id"=>$user_id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'));
		$this->db->insert('user_notification',$noti_array);user ko*/

		$title2 ="DISKUSS ONLINE CONSULTATION";
		$message2 = "Your Online ".ucfirst($mode)." Consulting Session with ".$user->name." is started";
		
		$selected_android_user2 = array();
		if($doctor->deviceType == 'android')
        {   
        	if($doctor->deviceToken!='abc')
            {
            	array_push($selected_android_user2, $doctor->deviceToken);
            }
            
        }
		elseif ($doctor->deviceType == 'ios') 
        {
			$this->send_ios_notification($doctor->deviceToken,$message2,$doctor->booking_mode);
        }
        if(count($selected_android_user2))
        {
        	$notification_type2 = "text";
            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
            $message3 = array(
                    'body' => $message2,
                    'title' => $title2,
                    'sound' => 'default',
                    'type' => 'live',
                    // 'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

                );
			$a = $this->sendMessageThroughFCMdoctor($selected_android_user2,$message3);
        }
        $noti_array = array("type"=>"online","user_type"=>"doctor","user_id"=>$id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'));
		$this->db->insert('user_notification',$noti_array);



		//to user notification
		$title_2 = "DISKUSS ONLINE CONSULTATION";
		$message2 = "Your Online ".ucfirst($mode)." Consulting Session with ".$doctor->doctor_firstname." is starting now at ".date('h:ia');
		$selected_android_user1 = array();
		if($user->device_type == 'android')
        {   
            if($user->device_token!='abc')
            {
            	array_push($selected_android_user1, $user->device_token);
            }
            
        }
		elseif ($user->device_type == 'ios') 
        {
			$this->w_m->send_ios_notification($user->device_token,$message1,$mode);
        }
        if(count($selected_android_user1))
        {
        	$notification_type1 = "text";
            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title_2.'","msg":"'.$message2.'","type":"no"}';
            //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
            $message2 = array(
                    'body' => $message2,
                    'title' => $title_2,
                    'sound' => 'default'
                );

            

			$a = $this->w_m->sendMessageThroughFCM($selected_android_user1,$message2);
    	}
	}

	public function sendMessageThroughFCMdoctor($registatoin_ids, $message,$notificationkey) 
	{
    	$k = $notificationkey;
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
        //print_r($result);             
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

    public function sendMessageThroughFCM($registatoin_ids, $message,$firebase_key) 
	{
    	$k = $firebase_key;
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
        //print_r($result);             
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

	// public function sendMessageThroughFCM($registatoin_ids, $message) 
	// {
 //    	$k = 'AAAAlzqnLIw:APA91bGHHrKabusAQDnlaXoTT095ynYXsQQ8uPhcO91mYHR-sDHHeUHqVxJWpJ4F4KJTXGC-27VHt2aE3kUiS3od8V87me7lkNf7PDhYqNdQMUesS0naYNsODH8kMySG7uk8f3p3C_k9';
 //        $url = 'https://fcm.googleapis.com/fcm/send';
 //        $fields = array(
 //            'registration_ids' => $registatoin_ids,
 //            'data' => $message,
 //            'notification' => $message
 //        );
 //        //Setup headers:
 //        $headers = array();
 //        $headers[] = 'Content-Type: application/json';
 //        $headers[] = 'Authorization: key='.$k;

 //        $ch = curl_init();
 //        curl_setopt($ch, CURLOPT_URL, $url);
 //        curl_setopt($ch, CURLOPT_POST, true);
 //        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);   
 //        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 //        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 //        //Setup curl, add headers and post parameters.
        
 //        $result = curl_exec($ch);  
 //        // print_r($result);             
 //        if ($result === FALSE) {
 //            die('Curl failed: ' . curl_error($ch));
 //        }
 //        curl_close($ch);
 //    }

    public function send_ios_notification($device_token,$message_text,$type)
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
    }


    public function testing_notification()
    {
    	// $id = $this->input->post("doc_id");
		$mode = 'video';//$this->input->post("mode");
		// $user_id = $this->input->post("user_id");
		$doctor = $this->db->get_where("doctor",array("id"=>41))->row();
		$user = $this->db->get_where("patient",array("id"=>70))->row();
		$title2 ="DISKUSS ONLINE CONSULTATION";
		$message2 = "Your Online ".ucfirst($mode)." Consulting Session with ".$user->name." is started";
		
		$selected_android_user2 = array();
		if($doctor->deviceType == 'android')
        {   
        	if($doctor->deviceToken!='abc')
            {
            	array_push($selected_android_user2, $doctor->deviceToken);
            }
            
        }
		elseif ($doctor->deviceType == 'ios') 
        {
			$this->send_ios_notification($doctor->deviceToken,$message2,$doctor->booking_mode);
        }
        if(count($selected_android_user2))
        {
        	$notification_type2 = "text";
            $respJson1 = '{"notification_type":"'.$notification_type2.'","title":"'.$title2.'","msg":"'.$message2.'","type":"no"}';
            $message3 = array(
                    'body' => $message2,
                    'title' => $title2,
                    'sound' => 'default',
                    'type' => 'live',
                    //'image'=>base_url('uploads/doctor').'/'.$doctor->display_image

                );
			$a = $this->sendMessageThroughFCMdoctor($selected_android_user2,$message3);
        }
        $noti_array = array("type"=>"online","user_type"=>"doctor","user_id"=>$id,"title"=>$title2,"notification"=>$message2,"added_on"=>date('Y-m-d H:i:s'));
		$this->db->insert('user_notification',$noti_array);
    }

}