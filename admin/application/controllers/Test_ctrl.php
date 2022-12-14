<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Test_ctrl extends CI_Controller {
  public function __construct() {
  parent::__construct();  
    date_default_timezone_set("Asia/Kolkata");
    //$this->load->model('Img_model');  
  
    }




public function insert_record_server()
  {      
     // print_r("ss"); die;
        $date_now = time();
        $date_time = date('Y-m-d H:i:s'); 
        $duration_in_minutes = 3;
        $btime = strtotime($date_time);
        $b_befor =  strtotime(date('Y-m-d H:i:s', strtotime('+'.$duration_in_minutes.' minutes', strtotime($date_time))));

        if ($date_now <= $b_befor  ) 
        {
        
          echo "yes"; die;
        }
        else{
           echo "No"; die;
        }

     
    }





    
    public function send_push_notification()
    {
			  $data =json_decode(file_get_contents('php://input'), true);
        if(empty($data)){
          $data = $_POST;
        }

        $title = $data['title'];
        $body = $data['body'];
        $details = $data['details'];
        $user_id=$data['user_id'];
        $registatoin_ids='';
        if(!empty($user_id)){
          $user = $this->db->get_where('user',['id'=>$user_id])->row();
          $registatoin_ids = [$user->device_token];

        }else{
            $this->check_curl($body,$title,'');
            return true; 
          // redirect(base_url('User_details/send_to_all'));
        }

        $message =  array(
            'body' => $body,
            'data' => $details,
            'title' => $title,
            'sound' => 'default',
            "icon" => "ic_launcher"
        );
        



        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
        // $API_SERVER_KEY = "AAAAb0zS7Yo:APA91bHpdehHo2KvTHjjwr4WryWMSwSJH0TRw-rhZymhP6xv0BvdXqRtxwe6AUT2glPRRVzvNQIk8W7yBhGF0m1WodmC_YsrT1tRDfyjLCWOfj7EkayN8fhJddDYUTI4MkJvXaVC2pgY";
        $API_SERVER_KEY = 'AAAAA-Vq-4w:APA91bHMazogQxvqHJqR8N9Uz0gC6UeVaH4SRC4YFILWUqsytLcxNrkhm750cdczKBvwsctBTZRVWSlRJNACPpRedPbiVbXYnyy0Y_AihAPpPZFUfZauiJM3r2XlZkDXeEldAE-EnKjt';
    
        if (!is_array($registatoin_ids)) {
            $device_tokens = [$registatoin_ids];
        } else {
            $device_tokens = $registatoin_ids;
        }
        $fields = array(
            'registration_ids' => $device_tokens,
            'data' => $message,
            'notification' => $message
            // 'sound'=>'default'
        );
        $headers = array(
            'Authorization:key=' . $API_SERVER_KEY,
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
        // print_r($result);
        echo $result;
        // print_r($result);
    }

  public function send()
    {
      // print_r("expression");die;
      if (!empty($_FILES['image'])) {
        $config['upload_path'] = 'uploads/notification/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['encrypt_name'] = TRUE;
       $this->load->library('upload');
       $this->upload->initialize($config);
         $imageUpload = '';
        if (!$this->upload->do_upload('image')) {
          $error = array(
            'error' => $this->upload->display_errors()
          );
          $display_image = 'default.png';
        }
        else {
          $imageUpload = $this->upload->data();
          $display_image = $imageUpload['file_name'];
        }
      }
      $image =      base_url("uploads/notification")."/".$display_image;
     $message = $this->input->post('message');
     $title = $this->input->post('title');        
     
     $this->check_curl($message,$title,$image);
            // return true; 
          redirect(base_url('Notification_send/send_to_all_astrologer'));
    }

    public function check_curl($message,$title,$image)
    {
      $url = base_url('test_ctrl/curl_main_resource');
      $curl = curl_init();                
      $post['message'] = $message; // our data todo in received
      $post['title'] = $title; // our data todo in received
      $post['image'] = $image; // our data todo in received
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt ($curl, CURLOPT_POST, TRUE);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, $post); 
      curl_setopt($curl, CURLOPT_USERAGENT, 'api');
      curl_setopt($curl, CURLOPT_TIMEOUT, 1); 
      curl_setopt($curl, CURLOPT_HEADER, 0);
      curl_setopt($curl,  CURLOPT_RETURNTRANSFER, false);
      curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
      curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10); 
      curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
      $re = curl_exec($curl);   
      //print_r($re);
      curl_close($curl);  
        return true;
      
    }

  public function curl_main_resource()
  { 
      $title = $this->input->post("title");
      $message = $this->input->post("message");
      $image = $this->input->post("image");
          $selected_android_user1 = array();
          $selected_ios_user1 = array();
         //$device_token = $this->db->query("SELECT * FROM `user` WHERE status = 1 AND notification_config = 1")->result();
           $device_token = $this->db->query("SELECT * FROM `astrologers` WHERE status = 1")->result();
           // $device_token = $this->db->query("SELECT * FROM `patient` WHERE id = 6180")->result();
           // print_r($device_token ); die;
          $userID = '';
          foreach($device_token as $u)
          {
              $mobile = $u->phone;    
              $userID.=$u->id.",";
             
              $insert_array = array('user_id' => $u->id,
                                'title' => $title,
                                'notification' => $message,
                                'image' => $image,
                                'type' => 'admin_all',
                                'added_on' => date('Y-m-d H:i:s')
                                );
              $insert = $this->db->insert('user_notification',$insert_array);
              
          }
          $user_array = rtrim($userID,",");
          if (count($device_token) > 0)
            {
              foreach($device_token as $u)
              {
                if($u->device_type == 'android')
                {
                  array_push($selected_android_user1, $u->device_token);
                }

                if($u->device_type == 'ios')
                {
                    array_push($selected_ios_user1, $u->device_token);
                }


                
                
                @$alluserID.=$u->id.',';
              }
                $getuserID = rtrim($alluserID,',');
               if(count($selected_android_user1))
                {
                    $notification_type1 = "text";
                       $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title.'","msg":"'.$message.'","image":"'.$image.'","type":"no"}';
                       $message2 = array(
                               'body' => $message,
                               'title' => $title,
                               'image' => $image,
                               'sound' => 'Default'
                           );

                       $regIdChunk1=array_chunk($selected_android_user1,1000);
                       foreach($regIdChunk1 as $RegId1){
                        $a = $this->sendMessageThroughFCM($RegId1,$message2);
                       }
                }

                 if(count($selected_ios_user1))
                  {
                      $notification_type1 = "text";
                         $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title.'","msg":"'.$message.'","image":"'.$image.'","type":"no"}';
                         //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
                         $message2 = array(
                                 'body' => $message,
                                 'title' => $title,
                                 'image' => $image,
                                 'sound' => 'Default'
                             );

                         $regIdChunk1=array_chunk($selected_ios_user1,1000);
                         foreach($regIdChunk1 as $RegId1){
                          $a = $this->send_ios_notification($RegId1,$message2,"ios");
                         }
                  }

            
            }
    }


     private function send_ios_notification($device_token,$message_text,$type)
    {
      // print_r($message_text);


    @$payload='{"aps":{"alert":"'.$message_text['body'].'","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"genral"}';
    // print_r( $payload); die;
        //include_once("Cow.pem");
        $ctx=stream_context_create();
        
        /*for development*/
          stream_context_set_option($ctx,'ssl','local_cert','/var/www/html/kundali_expert/notification_key/kundali.pem');
          $fp=stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        /*end for development*/
        /*for production*/
          // stream_context_set_option($ctx,'ssl','local_cert','/var/www/html/kundali_expert/notification_key/kundali.pem');
          // $fp=stream_socket_client('ssl://gateway.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        /*end for production*/
        if($fp)
        {
          echo "Connected".$err;
        }
         foreach ($device_token as $key)
         {
          // print_r($key); die;

        $msg=chr(0).pack("n",32).pack("H*",str_replace(' ','',$key)).pack("n",strlen($payload)).$payload;
         }
        // print_r($msg); die;
        $res=fwrite($fp,$msg);
        // print_r($res); die;
        if($res)
        {
         print_r($res);   
        }
        fclose($fp);
        return true;
    }




   public function sendMessageThroughFCM($registatoin_ids, $message)
    {
   
        $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $android_firbase = $settings->firebase_key;  
        $k = "AAAAA-Vq-4w:APA91bHMazogQxvqHJqR8N9Uz0gC6UeVaH4SRC4YFILWUqsytLcxNrkhm750cdczKBvwsctBTZRVWSlRJNACPpRedPbiVbXYnyy0Y_AihAPpPZFUfZauiJM3r2XlZkDXeEldAE-EnKjt";
        // print_r( $k);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message
        );
// print_r($fields); die;
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
        // print_r($result);     die;         
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
//print_r($registatoin_ids);
    }



}