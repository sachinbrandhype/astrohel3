<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

class Speedhuntson extends CI_Controller{

	function __construct () {
		parent::__construct();
		$this->load->model("Speedhuntson_m","c_m");
		$this->load->library('encryption');
        $this->load->model('Api_Model','w_m');

		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->library('user_agent');
		$this->load->library('session');
        if(!$this->session->userdata('logged_in')) { 
            redirect(base_url());
        }
	}



  public function solve_message_data()
    {
       if ($_POST) 
      {
        // print_r($_POST); die;
        $ide =  $this->input->post("cancel_id");   
        $message =  $this->input->post("message");
        $key = $this->db->get_where("user_support",array("id"=>$ide))->row();
        // print_r($key->email); die;
          $data = array
          (
          "status"=>1,
          "resolved_message"=>$message
          );
          $create = $this->c_m->get_all_result($data,'update','user_support',array('id'=>$ide));
          if ($create) 
          {

           $subject = "Kundal Solve Message";
          $mail_message= "Hello,<br><br> ".$message."<br><br>Regards<br>Kundal SUPPORT";
          $this->check_curl($key->email,$subject,$mail_message,$key->name); 



        $title1 = "Your Solve Message";
         $patient_detail = $this->db->get_where("user",array("id"=>$key->user_id))->row();
         // print_r($patient_detail); die;
        $selected_android_user1 = array();
        if($patient_detail->device_type == 'android')
            {   
                if($patient_detail->device_token!='abc')
                {
                  array_push($selected_android_user1, $patient_detail->device_token);
                }
                
            }
        elseif ($key->device_type == 'ios') 
                {
          $this->w_m->send_ios_notification($patient_detail->device_token,$message,$key->booking_mode);
                }
                if(count($selected_android_user1))
            {
              $notification_type1 = "text";
                $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title1.'","msg":"'.$message.'","type":"no"}';
                //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
                $message2 = array(
                        'body' => $message,
                        'title' => $title1,
                        'sound' => 'default'
                    );
                // print_r($message2); die;
          $a = $this->sendMessageThroughFCM_1($selected_android_user1,$message2);
          }
            $this->session->set_flashdata('message', array('message' => 'Update Successfully','class' => 'success')); 
            redirect("speedhuntson/sold_enquiry/sold");  
            
        } 

      }
    }



    public function sendMessageThroughFCM_1($registatoin_ids, $message) 
  {
      $settings = $this->w_m->get_settings();
    if ($settings->firebase_key_for_user) 
    {
      $k = $settings->firebase_key_for_user;
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
        // print_r($result);  die           
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }




    public function check_curl($email = '',$subject = '',$message = '', $name = '',$bcc_email = '' ,$bcc_line = '',$fil_package_deatils = '')
  {

    $url = base_url('api/curl_mail_fun');
      $curl = curl_init();                
      $post['email'] = $email; // our data todo in received
      $post['subject'] = $subject; // our data todo in received
      $post['message'] = $message; // our data todo in received
      $post['name'] = $name; // our data todo in received
      $post['bcc_email'] = $bcc_email;
      $post['bcc_line'] = $bcc_line;
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
      curl_close($curl);  
      return $fil_package_deatils;
  }












public function sold_enquiry($uri="",$rowno=0)
  {

    $uri = $this->uri->segment(3);
    // print_r($uri);die;
     $data = array();
         $sup_name = "";
         $sup_email = "";
        if($this->input->post('submit') != NULL ){
            $sup_name = $this->input->post('sup_name');
            $sup_email = $this->input->post('sup_email');
            $sess = $this->session->set_userdata(array("sup_name"=>$sup_name,"sup_email" => $sup_email));
        }if($this->input->post('reset') != NULL)
        {
            unset(
                    $_SESSION['sup_name'],
                    $_SESSION['sup_email']
                  
                );
        }else{
            if($this->session->userdata('sup_name') != NULL){
                $sup_name = $this->session->userdata('sup_name');
            }
            if($this->session->userdata('sup_email') != NULL){
                $sup_email = $this->session->userdata('sup_email');
            }
        }
        $rowperpage = 50;
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }

           if($uri == 'sold')
       {
        // print_r("expression");die;
         $total_records = $this->c_m->get_total_enquiry($sup_name,$sup_email,1);
        $template['list'] = $this->c_m->get_enquiry_for_pagination($rowno,$rowperpage,$sup_name,$sup_email,1)
        ;

        $config['base_url'] = base_url() . 'speedhuntson/sold_enquiry/sold';
          $template['page_title'] = "solve";
            $template['page_title_uri'] = "sold";
       }
       elseif ($uri == 'unsold') 
       {

         $total_records = $this->c_m->get_total_enquiry($sup_name,$sup_email,0);
        $template['list'] = $this->c_m->get_enquiry_for_pagination($rowno,$rowperpage,$sup_name,$sup_email,0)
        ;
                // echo  $this->db->last_query();die;
        $config['base_url'] = base_url() . 'speedhuntson/sold_enquiry/unsold';
          $template['page_title'] = "unsolve";
        $template['page_title_uri'] = "unsold";
       }


        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $rowperpage;
        $config['cur_tag_open'] = '<a class="current">';  
        $choice = $config["total_rows"]/$config["per_page"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $template["links"] = $this->pagination->create_links();
        $template['row'] = $rowno;
        $template['sup_name'] = $sup_name;
        $template['sup_email'] = $sup_email;

    $template['page'] = "ambulance/sold";
    $this->load->view('template', $template);
  }





   public function export_pharmacy_details()
    {
       $uri = $this->uri->segment(3);

       //print_r($uri);die;
        if($uri == 'new_pharmacy')
       {
       // print_r("shubham");die;
            $query = 'SELECT * FROM `pharmacy_enquiry` where status = 0  ORDER BY `added_on` DESC';
       }
       elseif($uri == 'all_pharmacy')
       {
            $query = 'SELECT * FROM `pharmacy_enquiry`  ORDER BY `added_on` DESC';
       }
       elseif($uri == 'cancel_pharmacy')
       {
            $query = 'SELECT * FROM `pharmacy_enquiry` where status IN (2,3)  ORDER BY `added_on` DESC';
       }
       elseif($uri == 'complete_pharmacy')
       {
            $query = 'SELECT * FROM `pharmacy_enquiry` where status = 1   ORDER BY `added_on` DESC';
       }

        
        $details=  $this->c_m->get_all_result_array($query,'select','','');
      // print_r($details);die;


     $data[] = array("#","Patient Name","Patient Email","Patient Mobile","Patient Dob","Pharmacy Name","Amount","Email","Mobile","Address","Area","Pincode","City State","Status","Complete Pharmacy","Added On");
        
    $i=1;
    foreach($details as $user)
    {
        $query3 = 'SELECT * FROM `patient` WHERE `id`="'.$user['patient_id'].'"';
        $patient = $this->c_m->get_all_result_array($query3,'single_row','','');
        if($user['status'] == 0)
         {
          $status_book = "New";
         }
         elseif($user['status'] == 1)
         {
          $status_book = "Complete";

        
         }
         elseif($user['status'] == 2 || $user['status'] == 3)
         {
          $status_book = "Canceled";
            
         }

         elseif($user['status'] == 4)
         {
          $status_book = "On Going";
         }
    $data[] = array(
        "#" =>$i,
        
        "patient"=>$patient['name'],
        "patient_email"=>$patient['email'],
        "patient_phone"=>$patient['phone'],
        "patient_dob"=>$patient['dob'],
        "name"=>$user['name'], 
        "amount"=>$user['amount'], 
        "email"=>$user['email'], 
        "mobile"=>$user['mobile'], 
        "address"=>$user['address'], 
        "area"=>$user['area'], 
        "pincode"=>$user['pincode'], 
        "city_state"=>$user['city_state'], 
        "status_book"=>$status_book, 
        "date"=>$user['date'], 
        "added_on"=>$user['added_on'], 
  
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_pharmacy_booking".$uri.".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }




       public function all_pharmacy()
    {
        $uri = $this->uri->segment(3);
        // print_r($uri);die;  
        $config = array();
        
        if($uri == 'all_pharmacy')
       {
            $config["base_url"] = base_url() . "speedhuntson/all_pharmacy/all_pharmacy";
            $config["total_rows"] = $this->c_m->get_count_all_pharmacy('pharmacy_enquiry');
       }
       elseif ($uri == 'new_pharmacy') 
       {
            $config["base_url"] = base_url() . "speedhuntson/all_pharmacy/new_pharmacy";
            $config["total_rows"] = $this->c_m->get_count_new_pharmacy('pharmacy_enquiry');   
       }

       elseif ($uri == 'cancel_pharmacy') 
       {
            $config["base_url"] = base_url() . "speedhuntson/all_pharmacy/cancel_pharmacy";
            $config["total_rows"] = $this->c_m->get_count_cancel_pharmacy('pharmacy_enquiry');   
       }

       elseif ($uri == 'complete_pharmacy') 
       {
            $config["base_url"] = base_url() . "speedhuntson/all_pharmacy/complete_pharmacy";
            $config["total_rows"] = $this->c_m->get_count_complete_pharmacy('pharmacy_enquiry');   
       }

        //print_r($config["total_rows"]);die;
        $config['per_page'] = 30;
        $config["uri_segment"] = 4;
        $choice = $config["total_rows"]/$config["per_page"];
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = '&laquo; First';
      $config['first_tag_open'] = '<li class="prev page">';
      $config['first_tag_close'] = '</li>';

      $config['last_link'] = 'Last &raquo;';
      $config['last_tag_open'] = '<li class="next page">';
      $config['last_tag_close'] = '</li>';

      $config['next_link'] = 'Next &rarr;';
      $config['next_tag_open'] = '<li class="next page">';
      $config['next_tag_close'] = '</li>';

      $config['prev_link'] = '&larr; Previous';
      $config['prev_tag_open'] = '<li class="prev page">';
      $config['prev_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="">';
      $config['cur_tag_close'] = '</a></li>';

      $config['num_tag_open'] = '<li class="page">';
      $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

         if($uri == 'all_pharmacy')
       {
        $template['list'] = $this->c_m->get_pagination_all_pharmacy($config["per_page"],$template['page'],'pharmacy_enquiry');
        $template['page_title'] = "All Pharmacy Details";
        $template['page_title_uri'] = "all_pharmacy";

       }
         if($uri == 'new_pharmacy')
       {
        $template['list'] = $this->c_m->get_pagination_new_pharmacy($config["per_page"],$template['page'],'pharmacy_enquiry');
        $template['page_title'] = "New Pharmacy Details";
        $template['page_title_uri'] = "new_pharmacy";

       }

      if($uri == 'cancel_pharmacy')
           {
            $template['list'] = $this->c_m->get_pagination_cancel_pharmacy($config["per_page"],$template['page'],'pharmacy_enquiry');
            $template['page_title'] = "Cancel Pharmacy Details";
            $template['page_title_uri'] = "cancel_pharmacy";

           }
      if($uri == 'complete_pharmacy')
           {
            $template['list'] = $this->c_m->get_pagination_complete_pharmacy($config["per_page"],$template['page'],'pharmacy_enquiry');
            $template['page_title'] = "Complete Pharmacy Details";
            $template['page_title_uri'] = "complete_pharmacy";
           }

        $template["links"] = $this->pagination->create_links();
      //  print_r( $template["links"]);die;
        $template['page'] = "pharmacy/all_pharmacy";
        
        $this->load->view('template',$template);
    }


     public function image_pharmacy_details()
    {
        $booking_id = trim($this->input->post('booking_id'));
        $booking_data = $this->db->where('id',$booking_id)->get('pharmacy_enquiry')->row();
        $image = explode('|', $booking_data->images);
        foreach ($image as $key) {
           echo "<a href='".base_url('uploads/pharmacy_attachment_by_patient')."/".$key."' download><img src='".base_url('uploads/pharmacy_attachment_by_patient')."/".$key."' height='200px' width='200px'></a>&nbsp;&nbsp;";
         
        }
    }


      public function pharmacy_data()
    {
   //print_r($_POST);die; 
      if ($_POST) {
        $booking_id =  $this->input->post("booking_id");   
        $name =  $this->input->post("name");
        $amount =  $this->input->post("amount");
        $p_date =  $this->input->post("date");
        $array = array
        (
        "name"=>$name,
        "amount"=>$amount,
        "date"=>$p_date,
        "status"=>1,
        );

          $create = $this->c_m->get_all_result($array,'update','pharmacy_enquiry',array('id'=>$booking_id));
        //$create = $this->Lab_model->get_all_result($data,'update','booking_test',array('id'=>$booking_id));
       if ($create) {

        $this->send_sms_pharmacy($booking_id);
        $this->send_mail_pharmacy($booking_id);
       $this->send_notification_pharmacy($booking_id);

            $this->session->set_flashdata('message', array('message' => 'Update Successfully','class' => 'success')); 
            redirect("speedhuntson/all_pharmacy/all_pharmacy");  
        }
      }
    }


    public function send_notification_pharmacy($booking_id)
    {
        

          $pharmacy = $this->db->get_where('pharmacy_enquiry',array('id' => $booking_id ))->row(); 
   // print_r($pharmacy);die;
          $pharmacy_name = $pharmacy->name;
          $pharmacy_email = $pharmacy->email;
          $pharmacy_phone = $pharmacy->mobile;   
          $pharmacy_date = $pharmacy->date;   
          $booking_date = date("jS F Y", strtotime($pharmacy_date));
          $patient_id = $pharmacy->patient_id;   
          $patient = $this->db->get_where('patient',array('id' => $patient_id ))->row(); 

          $patient_name = $patient->name;
          $patient_email = $patient->email;
          $patient_phone = $patient->phone; 
          //print_r($patient);die;  

        $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $doctor_mobile = $settings->helpline_number;
        
       

            $message= "Hi ". $patient_name .", your pharmacy products is delivered by ". $booking_date ;
      
      
        $title = "ANYTIMEDOC BOOKING";
       // $message = $type;
        
        $selected_android_user1 = array();
        $selected_ios_user1 = array();
        $patient_token = $this->db->query("SELECT * FROM `patient` WHERE device_token !='' AND id = $patient->id ")->row();
        if (count($patient_token) > 0)
        {
            if($patient_token->device_type == 'android')
            {
                array_push($selected_android_user1, $patient_token->device_token);
            }
           
            if(count($selected_android_user1))
            {
                $notification_type1 = "text";
                   $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title.'","msg":"'.$message.'","type":"no"}';
                   //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
                   $message2 = array(
                           'body' => $message,
                           'title' => $title,
                           'sound' => 'Default'
                       );

                   $regIdChunk1=array_chunk($selected_android_user1,1000);
                   foreach($regIdChunk1 as $RegId1){
                    $a = $this->sendMessageThroughFCM($RegId1,$message2);
                   }
            }
        }
       
    }    


    public function fcmNotification($device_id="dOk1-W7v4Uw:APA91bHaw_6oyLN3Zxfh_6uO8wxRldslP7L8nX3gqStDWymVh2r4owHCkIon7sp7VeV04vcGKk6H9CRmkOBQNFVoGQYVLk2Gq5xvQwbg7fah4bL_gq4yCwLfB-85-Gjw3u4yDrXihfo5", $sendData="mesdsdfds")
    {
        #API access key from Google API's Console
        if (!defined('API_ACCESS_KEY')){
            define('API_ACCESS_KEY', 'AAAAXHb-Bzs:APA91bFwfXFtSOC0ASXjs6CzoCPx2KeO425JWmI3_FoFhNELITsfCd0OYAKD5lgvG8yqgEXKy87Jku16yOdj-BjJbHzLdpjIDnOs0PQvTwNRvqK5jwJ55yg1RgtJnee2f0V6qqkOw2Hm');
        }
                
        $fields = array
                (
                    'to'    => $device_id,
                    'data'  => $sendData,
                    'notification'  => $sendData
                );


        $headers = array
                (
                    'Authorization: key=' . API_ACCESS_KEY,
                    'Content-Type: application/json'
                );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        //$data = json_decode($result);
        if($result === false)
        {
            echo 'Curl failed ' . curl_error();
        }
        // else
        // {
        //   //  print_r($result);
        //    // echo "Sdfsdf";
        // }
        

        curl_close($ch);
        return $result;
    }

    public function sendMessageThroughFCM($registatoin_ids, $message)
    {
    //FCM ENDPONT Url
        // $setting = $this->db->query("SELECT `firebase_api_key` FROM `setting` WHERE `settingID`='1'")->row();
        // if (count($setting) > 0)
        // {
        // $k = $setting->firebase_api_key;
        // }
        // else
        // {


        // $k = 'AAAAXHb-Bzs:APA91bFwfXFtSOC0ASXjs6CzoCPx2KeO425JWmI3_FoFhNELITsfCd0OYAKD5lgvG8yqgEXKy87Jku16yOdj-BjJbHzLdpjIDnOs0PQvTwNRvqK5jwJ55yg1RgtJnee2f0V6qqkOw2Hm';
        $k = 'AAAAb0zS7Yo:APA91bHpdehHo2KvTHjjwr4WryWMSwSJH0TRw-rhZymhP6xv0BvdXqRtxwe6AUT2glPRRVzvNQIk8W7yBhGF0m1WodmC_YsrT1tRDfyjLCWOfj7EkayN8fhJddDYUTI4MkJvXaVC2pgY';
        // }
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
        if ($result === FALSE) 
        {
            echo 'Curl failed ' . curl_error();die;
        }
        // else
        // {
        //     print_r($result);
        //     //echo "Sdfsdf";die;
        // }
        curl_close($ch);
//print_r($registatoin_ids);
    }

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
    

     public function send_sms_pharmacy($booking_id)
      {

          $settings = $this->db->get_where('settings',array('id'=>1))->row();
          $doctor_mobile = $settings->helpline_number;   
        
          $pharmacy = $this->db->get_where('pharmacy_enquiry',array('id' => $booking_id ))->row(); 
   // print_r($pharmacy);die;
          $pharmacy_name = $pharmacy->name;
          $pharmacy_email = $pharmacy->email;
          $pharmacy_phone = $pharmacy->mobile;   
          $patient_id = $pharmacy->patient_id;   
          $pharmacy_date = $pharmacy->date;   
          $booking_date = date("jS F Y", strtotime($pharmacy_date));
          $patient = $this->db->get_where('patient',array('id' => $patient_id ))->row(); 
          $patient_name = $patient->name;
          $patient_email = $patient->email;
          $patient_phone = $patient->phone; 

          if(!empty($patient_phone))
          {
              $msgtopatient= '';
              $msgtopatient.= "Hi ". $patient_name .", your pharmacy products is delivered by ". $booking_date ;
              $msg1 = urlencode($msgtopatient);
              $this->send_to_pharmacy_mag($patient_phone,$msg1);
          }


      }

        public function send_mail_pharmacy($booking_id)
    {
         $settings = $this->db->get_where('settings',array('id'=>1))->row();
          $doctor_mobile = $settings->helpline_number;   
        
          $pharmacy = $this->db->get_where('pharmacy_enquiry',array('id' => $booking_id ))->row(); 
          $pharmacy_name = $pharmacy->name;
          $pharmacy_email = $pharmacy->email;
          $pharmacy_phone = $pharmacy->mobile;   
          $pharmacy_address  = $pharmacy->address;   
          $pharmacy_area = $pharmacy->area;   
          $pharmacy_pincode = $pharmacy->pincode;   
          $pharmacy_city_state = $pharmacy->city_state;   
          $pharmacy_detail = $pharmacy->pharmacy_detail;   
          $pharmacy_amount   = $pharmacy->amount;   
          $pharmacy_date   = $pharmacy->date;   
          $pharmacy_added_on = $pharmacy->added_on;   
          $patient_id = $pharmacy->patient_id;   

           if (!empty($pharmacy->images)) 
        { 
            $pharmacy_images="";
           $image = explode('|', $pharmacy->images);
            foreach ($image as $key) {
                $pharmacy_images.= "<a href='".base_url('uploads/pharmacy_attachment_by_patient')."/".$key."' download><img src='".base_url('uploads/pharmacy_attachment_by_patient')."/".$key."' height='200px' width='200px'>&nbsp;&nbsp;";
            }
        }


          $patient = $this->db->get_where('patient',array('id' => $patient_id ))->row(); 
          $patient_name = $patient->name;
          $patient_email = $patient->email;
          $patient_phone = $patient->phone; 


        $this->load->library('My_PHPMailer');
        $this->load->helper('string');
        $subject = "ANYTIMEDOC: Pharmacy Report.";
        $body= '<table cellpadding="5" style="width:100%; border-collapse: collapse;">
                       <tr>
                          <td><img src="http://anytimedoc.in/images/logo-1.png"></td>
                          <td style="text-align: right;">anytimedoc.in</td>
                       </tr>
                    </table>

                    <table>
                       <tr height="10"></tr>
                    </table>

                   
                    <table>
                       <tr height="10"></tr>
                    </table>


                    <table  cellpadding="10" cellspacing="10" style="width:100%; text-align: left; border-collapse: collapse;" border="1">
                     <tr>
                          <th>Name</th>
                          <td>'.$pharmacy_name.'</td>
                       </tr>
                         <tr>
                          <th>Amount</th>
                          <td>'.$pharmacy_amount.'</td>
                       </tr>
                           <tr>
                          <th>Date</th>
                           <td>'.$pharmacy_date.'</td>
                        </tr>
                            <tr>
                          <th>Phone</th>
                           <td>'.$pharmacy_phone.'</td>
                        </tr>
                            <tr>

                          <th> Detail</th>
                           <td>'.$pharmacy_detail.'</td>
                        </tr>
                        <tr>
                          <th> Email</th>
                          <td>'.$pharmacy_email.'</td>
                       </tr>
                         
                    </table>
                     <table cellpadding="0" cellspacing="0" style="width:100%;margin-top:50px">
            <tbody>
                <tr>
                    <th style="color:#575758;background-color:#cbd5e6;width:100%;padding:9px;text-align:left;font-size:12px;font-weight:normal;font-family:verdana">Pharmacy Images</th>
          
                </tr>
            </tbody>
        </table>
        <table width="100%" cellpadding="10" cellspacing="0" border="0">
            <tbody>
                <tr>
                    '.$pharmacy_images.'
                  
                </tr>

               
               
            </tbody>
        </table>

                    <table>
                       <tr height="10"></tr>
                    </table>
                   
                    <table>
                       <tr height="10"></tr>
                    </table>
                    <table cellpadding="10" cellspacing="10" bgcolor="#35a4ff" style="width:100%; color: #fff; text-align: center; border-collapse: collapse;">
                       <tr>
                          <td style="line-height: 1.5;">
                             support@anytimedoc.in<br>
                             24 x 7 helpline - 7724000070<br>
                             © 2019 Anytimedoc. All Rights Reserved.
                          </td>
                    </table>';
        $mail = new PHPMailer;
        $mail->isSMTP();  
        $mail->Host = 'smtp.gmail.com'; //'md-70.webhostbox.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'emailsendtestappslure@gmail.com';//'form41app@gmail.com'; //'mail@appsgenic.com';
                $mail->Password = 'appslure@321';//'appslure123'; // '@appsgenic123@';
        $mail->SMTPSecure = 'tls';
        $mail->Port =587;
        $mail->From = 'emailsendtestappslure@gmail.com';
        $mail->FromName = 'ANYTIMEDOC Pharmacy ';
        $mail->addAddress($patient_email, 'ANYTIMEDOC');
                $mail->WordWrap = 500;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        if(!$mail->send())
        {
            return false;
        }
        else
        {
            return true;
        }    
    }

   


       public function send_to_pharmacy_mag($mobile,$message_patient)
    {
        $authKey = "290852AOOLo80J5d5fabd8";
        $senderId = "ANYTIM";
        $message = $message_patient;
        $route = "default";
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobile,
            'message' => $message_patient,
            'sender' => $senderId,
            'route' => $route
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?mobiles=$mobile&authkey=$authKey&route=4&sender=ANYTIM&message=$message_patient&country=91",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
    }






	public function ambulance()
    {



        $config = array();
        $config["base_url"] = base_url() . "speedhuntson/ambulance";
        $config["total_rows"] = $this->c_m->get_count_ambulance('ambulance');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 30;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_data_ambulance($config["per_page"],$template['page'],'ambulance');
        $template["links"] = $this->pagination->create_links();


        // $query = 'SELECT * FROM `ambulance` WHERE `status` <> "2" ORDER BY `name` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/ambulance";
        $template['page_title'] = "Ambulance Details";
        $this->load->view('template',$template);
    } 

      public function export_ambulance()
    {
        $query = 'SELECT * FROM `ambulance` WHERE status = 1 ORDER BY `name` ASC';
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name","Owner Name","Mobile","Driver & Mobile","Model & Category","Vehicle Number","Owner Email","Hospital Name","Address","Price","Residence Address","Aadhar Number","Pan Number","Bank Name","Bank Account No","Ifsc Code","Remarks");
        
    $i=1;
    foreach($details as $user)
    {
      // $query = 'SELECT * FROM `customerdetails` WHERE `fkcustomer_id`="'.$user['id'].'"';
      // $contact_person = $this->web_m->get_all_result_arrays($query,'single_row','','');
        $query1 = 'SELECT * FROM `hospital` WHERE `id`="'.$user['hospital_id'].'"';
        $hospital = $this->c_m->get_all_result_array($query1,'single_row','','');

      $query2 = 'SELECT * FROM `ambulance_category` WHERE `id`="'.$user['category'].'"';
      $ambulance_category = $this->c_m->get_all_result_array($query2,'single_row','','');

      $data[] = array(
        "#" =>$i,
        "name"=>$user['name'],
        "owner_name"=>$user['owner_name'],
        "owner_number"=>$user['owner_number'],
        //"owner_number"=>$user['owner_number'],
        "driver_name"=>$user['driver_name'].' & '.$user['driver_number'],
        "model_type"=>$user['model_type'].' & '.$ambulance_category['name'],
        "v_number"=>$user['v_number'],
        "owner_email"=>$user['owner_email'],
        "hospital_name"=>$hospital['hospital_name'],
        "address"=>$user['address'],
        "price"=>$user['price'],
        "residence_address"=>$user['residence_address'],
        "aadhar_number"=>$user['aadhar_number'],
        "pan_number"=>$user['pan_number'],
        "bank_name"=>$user['bank_name'],
        "bank_account_no"=>$user['bank_account_no'],
        "ifsc_code"=>$user['ifsc_code'],
        "remarks"=>$user['remarks'],
        

      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_ambulance".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }


    public function add_ambulance()
    {
        if ($_POST) 
        {  
           // print_r($_POST);die;
            // if ($_FILES['icon']['name'])
            // {
            //     if ($_FILES['icon']['type'] == 'image/jpeg' || $_FILES['icon']['type'] == 'image/png') 
            //     {
            //         $target_path = "uploads/ambulance/";
            //         $target_dir = "uploads/ambulance/";
            //         $target_file_logo = $target_dir . basename($_FILES["icon"]["name"]);
            //         $title_image = basename($_FILES["icon"]["name"]);
            //         $title_extension = substr(strrchr($_FILES['icon']['name'], '.'), 1);
            //         $title_image_name = time().".".$title_extension;
            //         move_uploaded_file($_FILES["icon"]["tmp_name"],$target_path.$title_image_name);
            //         if(!empty($title_extension))
            //         {
            //             $icon = $title_image_name;
                        // driver_image
            if (!empty($_FILES['driver_image'])) {
                $config['upload_path'] = 'uploads/ambulance/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $imageUpload = '';
                if (!$this->upload->do_upload('driver_image')) {
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                }
                else {
                    $imageUpload = $this->upload->data();
                }
                $driver_image = $imageUpload['file_name'];
            }
            else {
                $driver_image = '';
            }

             if (!empty($_FILES['v_image'])) {
                $config['upload_path'] = 'uploads/ambulance/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $imageUpload = '';
                if (!$this->upload->do_upload('v_image')) {
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                }
                else {
                    $imageUpload = $this->upload->data();
                }
                $v_image = $imageUpload['file_name'];
            }
            else {
                $v_image = '';
            }

                       


                        // v_image
                       

                         // owner_image
                        if ($_FILES['owner_image']['type'] == 'image/jpeg' || $_FILES['owner_image']['type'] == 'image/png') 
                        {
                            $target_path = "uploads/ambulance/";
                             $target_dir = "uploads/ambulance/";
                            $target_file_logo_owner_image = $target_dir . basename($_FILES["owner_image"]["name"]);
                            $title_image_owner_image = basename($_FILES["owner_image"]["name"]);
                            $title_extension_owner_image = substr(strrchr($_FILES['owner_image']['name'], '.'), 1);
                            $title_image_name_owner_image = time().".".$title_extension_owner_image;
                            move_uploaded_file($_FILES["owner_image"]["tmp_name"],$target_path.$title_image_name_owner_image);
                            if(!empty($title_extension_owner_image))
                            {
                                $owner_image = $title_image_name_owner_image;
                            }
                            else
                            {
                                $owner_image = 'default.png';
                            }
                        }
                        else
                        {
                            $owner_image = 'default.png';
                        }

                        $array = array(
                            "model_type"=>$this->input->post("model_type"),
                            "category"=>$this->input->post("category"),
                            "hospital_id"=>$this->input->post("hospital_id"),
                            "name"=>$this->input->post("name"),
                            "owner_name"=>$this->input->post("owner_name"),
                            "owner_number"=>$this->input->post("owner_number"),
                            "owner_email"=>$this->input->post("owner_email"),
                            "driver_name"=>$this->input->post("driver_name"),
                            "driver_number"=>$this->input->post("driver_number"),
                            "driver_email"=>$this->input->post("driver_email"),
                            "v_number"=>$this->input->post("v_number"),
                            "latitude"=>$this->input->post("latitude"),
                            "longitude"=>$this->input->post("longitude"),
                            "address"=>$this->input->post("address"),
                            "price"=>$this->input->post("price"),
                            "username"=>$this->input->post("username"),
                            "password"=>$this->input->post("password"),
                            "residence_address"=>$this->input->post("residence_address"),
                            "aadhar_number"=>$this->input->post("aadhar_number"),
                            "pan_number"=>$this->input->post("pan_number"),
                            "bank_name"=>$this->input->post("bank_name"),
                            "bank_account_no"=>$this->input->post("bank_account_no"),
                            "ifsc_code"=>$this->input->post("ifsc_code"),
                            "remarks"=>$this->input->post("remarks"),
                           // "icon"=>$icon,
                            "driver_image"=>$driver_image,
                            "v_image"=>$v_image,
                            "owner_image"=>$owner_image,
                            "added_on"=>date('Y-m-d H:i:s'),
                            "status"=>1,
                            );
                        $this->db->insert('ambulance',$array);
                        //echo $this->db->last_query(); die;
                        $news_id = $this->db->insert_id();
                        $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("speedhuntson/ambulance");
                    }
               //     else
        //             {
        //                 $this->session->set_flashdata('message', array('message' => 'Icon is not uploaded please try again later','class' => 'danger'));
        //                 redirect("speedhuntson/add_ambulance");
        //             }
        //         }
        //         else
        //         {
        //             $this->session->set_flashdata('message', array('message' => 'Icon is not uploaded please try again later','class' => 'danger'));
        //             redirect("speedhuntson/add_ambulance");    
        //         }


        //     }
        //     else
        //     {
        //        $this->session->set_flashdata('message', array('message' => 'Icon is not uploaded please try again later','class' => 'danger'));
        //         redirect("speedhuntson/add_ambulance"); 
        //     }
            
           
        // }
        else
        {
            $query1 = 'SELECT * FROM `hospital` WHERE `status`="1" ORDER BY `id` DESC';
            $template['hospital'] = $this->c_m->get_all_result($query1,'select','','');

             $query2 = 'SELECT * FROM `ambulance_category` WHERE `status`="1" ORDER BY `id` DESC';
            $template['ambulance_category'] = $this->c_m->get_all_result($query2,'select','','');
            $template['page'] = "ambulance/add_ambulance";
            $template['page_title'] = "Add Ambulance";
            $this->load->view('template',$template);
        }
    }

  public function edit_ambulance()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {

            $old_img = $this->input->post('image11');
            $old_img1 = $this->input->post('image12');
            $old_img2 = $this->input->post('image13');
            
            $id = $this->uri->segment(3);
            if (!empty($_FILES['owner_image']) && !empty(trim($_FILES['owner_image']['name']))) {
                $config['upload_path'] = 'uploads/ambulance/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $imageUpload = '';
                if (!$this->upload->do_upload('owner_image')) {
                    $display_image = $old_img;
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                }
                else {
                    $imageUpload = $this->upload->data();
                    $display_image = $imageUpload['file_name'];
                    
                    unlink($old_img);
                    

                }
            }
            else {
                $display_image = $old_img;
            }

            if (!empty($_FILES['driver_image']) && !empty(trim($_FILES['driver_image']['name']))) {
                $config['upload_path'] = 'uploads/ambulance/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $imageUpload = '';
                if (!$this->upload->do_upload('driver_image')) {
                    $driver_image = $old_img1;
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                }
                else {
                    $imageUpload = $this->upload->data();
                    $driver_image = $imageUpload['file_name'];
                    
                    unlink($old_img1);
                    

                }
            }
            else {
                $driver_image = $old_img1;
            }

            if (!empty($_FILES['v_image']) && !empty(trim($_FILES['v_image']['name']))) {
                $config['upload_path'] = 'uploads/ambulance/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $imageUpload = '';
                if (!$this->upload->do_upload('v_image')) {
                    $v_image = $old_img2;
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                }
                else {
                    $imageUpload = $this->upload->data();
                    $v_image = $imageUpload['file_name'];
                    
                    unlink($old_img2);
                    

                }
            }
            else {
                $v_image = $old_img2;
            }


            $array = array(
                            "model_type"=>$this->input->post("model_type"),
                            "category"=>$this->input->post("category"),
                            "hospital_id"=>$this->input->post("hospital_id"),
                            "name"=>$this->input->post("name"),
                            "owner_name"=>$this->input->post("owner_name"),
                            "owner_number"=>$this->input->post("owner_number"),
                            "owner_email"=>$this->input->post("owner_email"),
                            "driver_name"=>$this->input->post("driver_name"),
                            "driver_number"=>$this->input->post("driver_number"),
                            "driver_email"=>$this->input->post("driver_email"),
                            "v_number"=>$this->input->post("v_number"),
                            "latitude"=>$this->input->post("latitude"),
                            "longitude"=>$this->input->post("longitude"),
                            "address"=>$this->input->post("address"),
                            "price"=>$this->input->post("price"),
                            "username"=>$this->input->post("username"),
                            "password"=>$this->input->post("password"),
                            "residence_address"=>$this->input->post("residence_address"),
                            "aadhar_number"=>$this->input->post("aadhar_number"),
                            "pan_number"=>$this->input->post("pan_number"),
                            "bank_name"=>$this->input->post("bank_name"),
                            "bank_account_no"=>$this->input->post("bank_account_no"),
                            "ifsc_code"=>$this->input->post("ifsc_code"),
                            "remarks"=>$this->input->post("remarks"),
                           // "icon"=>$icon,
                            "driver_image"=>$driver_image,
                            "v_image"=>$v_image,
                            "owner_image"=>$display_image,
                            "added_on"=>date('Y-m-d H:i:s'),
                            "status"=>1,
                            );
             $create = $this->c_m->get_all_result($array,'update','ambulance',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
                redirect("speedhuntson/edit_ambulance/".$id);
            }
            else
            {
                $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
                redirect("speedhuntson/edit_ambulance/".$id);  
            }
        }
        else
        {
          $query = "SELECT * FROM `ambulance` WHERE `id` = '$id'";
          $template['list'] = $this->c_m->get_all_result($query,'single_row','','');
        $query1 = 'SELECT * FROM `hospital` WHERE `status`="1" ORDER BY `id` DESC';
        $template['hospital'] = $this->c_m->get_all_result($query1,'select','','');
         $query2 = 'SELECT * FROM `ambulance_category` WHERE `status`="1" ORDER BY `id` DESC';
            $template['ambulance_category'] = $this->c_m->get_all_result($query2,'select','','');
         // print_r($template['list']);die;
           $template['page'] = "ambulance/edit_ambulance";
          $template['page_title'] = "Edit Ambulance";
          $this->load->view('template',$template);
        }
    }

    public function delete_ambulance()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','ambulance',array('id'=>$id));
        if ($create) {
           // $this->session->set_flashdata('delete','Delete Successfully...');
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully','class' => 'success')); 
            redirect("speedhuntson/ambulance");  
        }
        else
        {
           // $this->session->set_flashdata('err','Something went wrong please try again...');
             $this->session->set_flashdata('message', array('message' => 'Something went wrong please try again...','class' => 'danger')); 
            redirect("speedhuntson/ambulance");
        }
    }

    public function website_alert()
    {
        $query = 'SELECT * FROM `sd_news_alert` ORDER BY `position` ASC';
        $this->data['list'] = $this->c_m->get_all_result($query,'select','','');
        $this->data["subview"] = "edit/website_alert";
        $this->load->view('_layout_main', $this->data);
    } 

    public function add_website_alert()
    {
        if ($_POST) 
        {
            $array = array("news_id"=>$this->input->post("news_id"),
                           "added_on"=>$this->input->post("added_on"),
                           "title"=>$this->input->post("title"),
                           "position"=>$this->input->post("position"),
                           "status"=>1,
                          );
            $this->db->insert('sd_news_alert',$array);
            $this->session->set_flashdata('delete','Add Successfully!!!!!!');
            redirect("edit/website_alert");
            
        }
        else
        {
            $query = 'SELECT * FROM `sd_news` WHERE `status` <> "2"  ORDER BY `id` DESC';
            $this->data['news_list'] = $this->c_m->get_all_result($query,'select','','');
            $this->data["subview"] = "edit/add_website_alert";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit_website_alert()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {
            $id = $this->input->post("id");
            $query = "SELECT * FROM `sd_news_alert` WHERE `id` = '$id'";
            $this->data['list'] = $this->c_m->get_all_result($query,'single_row','','');
            $array = array("news_id"=>$this->input->post("news_id"),
                           "added_on"=>$this->input->post("added_on"),
                           "title"=>$this->input->post("title"),
                           "position"=>$this->input->post("position"),
                           "status"=>1,);
            $create = $this->c_m->get_all_result($array,'update','sd_news_alert',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('delete','Update Successfully...');
                redirect("edit/edit_website_alert".'/'.$id);
            }
            else
            {
                $this->session->set_flashdata('err','Something went wrong please try again...');
                redirect("edit/edit_website_alert".'/'.$id);  
            }
        }
        else
        {
          $query1 = 'SELECT * FROM `sd_news` WHERE `status` <> "2"  ORDER BY `id` DESC';
          $this->data['news_list'] = $this->c_m->get_all_result($query1,'select','','');
          $query = "SELECT * FROM `sd_news_alert` WHERE `id` = '$id'";
          $this->data['list'] = $this->c_m->get_all_result($query,'single_row','','');
          $this->data["subview"] = "edit/edit_website_alert";
          $this->load->view('_layout_main', $this->data);
        }
    }

    public function delete_website_alert()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $query = "DELETE FROM `sd_news_alert` WHERE `id` = '$id'";
        $r = $this->c_m->get_all_result($query,'delete','','');
        if ($r) {
            $this->session->set_flashdata('delete','Delete Successfully...');
            redirect("edit/website_alert");   
        }
        else
        {
            $this->session->set_flashdata('err','Something went wrong please try again...');
            redirect("edit/website_alert");
        }
    }

    public function news()
    {
        $query = 'SELECT * FROM `sd_news` WHERE `status` <> "2" ORDER BY `id` DESC';
        $this->data['list'] = $this->c_m->get_all_result($query,'select','','');
        $this->data["subview"] = "edit/news";
        $this->load->view('_layout_main', $this->data);
    }

    public function add_news()
    {
        if ($_POST) 
        {   
            if ($_FILES['author']['name'])
            {
                if ($_FILES['author']['type'] == 'video/mp4' || $_FILES['author']['type'] == 'video/mpeg') 
                {
                    $file_type = 'video';
                    $target_path = "uploads/news/video/";
                    $target_dir = "uploads/news/video/";
                    $target_file_logo = $target_dir . basename($_FILES["author"]["name"]);
                    if(is_array($_FILES)) 
                    {
                        foreach($_FILES as $fileKey => $fileVal)
                           {
                               $author = basename($_FILES["author"]["name"]);
                               $title_extension = substr(strrchr($_FILES['author']['name'], '.'), 1);
                                       $author_name = time().".".$title_extension;
                               move_uploaded_file($_FILES["author"]["tmp_name"],$target_path.$author_name);
                                              
                             if(!empty($title_extension))
                             {
                                 $title = $author_name;
                             }
                           }
                    }
                    $array = array(
                        "news_title"=>$this->input->post("news_title"),
                        "cat_id"=>$this->input->post("cat_id"),
                        "author_id"=>$this->input->post("author_id"),
                        "published_date"=>$this->input->post("published_date"),
                        "news_subheading"=>$this->input->post("news_subheading"),
                        "news_desc"=>$this->input->post("news_desc"),
                        "news_is_published"=>$this->input->post("news_is_published"),
                        "news_search_tags"=>$this->input->post("news_search_tags"),
                        "file_type"=>$file_type,
                        "image"=>$title,
                        "status"=>1,
                        "in_banner"=>$this->input->post("in_banner")
                    );
                    $this->db->insert('sd_news',$array);
                    $news_id = $this->db->insert_id();
                    if (!empty($this->input->post("related_news"))) 
                    {
                        foreach ($this->input->post("related_news") as $keys) 
                        {
                           $r_array = array("news_id"=>$news_id,
                                            "related_news_id"=>$keys);
                           $this->db->insert('sd_related_news',$r_array);
                        }
                    }
                    $this->session->set_flashdata('delete','Add Successfully!!!!!!');
                    redirect("edit/news");
                }
                elseif ($_FILES['author']['type'] == 'image/jpeg' || $_FILES['author']['type'] == 'image/png') 
                {
                    $file_type = 'image';
                    $image_name = $this->news_image_thumbnail($_FILES);
                    $array = array(
                        "news_title"=>$this->input->post("news_title"),
                        "cat_id"=>$this->input->post("cat_id"),
                        "author_id"=>$this->input->post("author_id"),
                        "published_date"=>$this->input->post("published_date"),
                        "news_subheading"=>$this->input->post("news_subheading"),
                        "news_desc"=>$this->input->post("news_desc"),
                        "news_is_published"=>$this->input->post("news_is_published"),
                        "news_search_tags"=>$this->input->post("news_search_tags"),
                        "file_type"=>$file_type,
                        "image"=>$image_name,
                        "status"=>1,
                        "in_banner"=>$this->input->post("in_banner")
                        );
                    $this->db->insert('sd_news',$array);
                    $news_id = $this->db->insert_id();
                    if (!empty($this->input->post("related_news"))) 
                    {
                        foreach ($this->input->post("related_news") as $keys) 
                        {
                           $r_array = array("news_id"=>$news_id,
                                            "related_news_id"=>$keys);
                           $this->db->insert('sd_related_news',$r_array);
                        }
                    }
                    $this->session->set_flashdata('delete','Add Successfully!!!!!!');
                    redirect("edit/news");

                }
                else
                {
                    $this->session->set_flashdata('err','File Format Npot support');
                    redirect("edit/add_news");
                }


            }
            
           
        }
        else
        {
            $query1 = 'SELECT * FROM `sd_category` WHERE `status`="1" ORDER BY `id` DESC';
            $this->data['cate'] = $this->c_m->get_all_result($query1,'select','','');
            $query = 'SELECT * FROM `sd_author` WHERE `status`="1" ORDER BY `id` DESC';
            $this->data['author'] = $this->c_m->get_all_result($query,'select','','');
            $query3 = 'SELECT * FROM `sd_news` WHERE `status`="1" ORDER BY `id` DESC';
            $this->data['news'] = $this->c_m->get_all_result($query3,'select','','');
            $this->data["subview"] = "edit/add_news";
            $this->load->view('_layout_main', $this->data);
        }
    }


    public function news_image_thumbnail()
    {
        $file_type = 'image';
        $config['upload_path']          = 'uploads/news/news_original_image';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['encrypt_name']        = TRUE;
        $config['max_size']             = '';
        $config['max_width']            = '';
        $config['max_height']           = '';
        $upload_dir_thumbs = 'uploads/news/';
        $thumb_width = '650';
        $thumb_height = '450';   
        $this->load->library('upload', $config);
        $imageUpload = [];
        $_FILES['file']['name']     = $_FILES['author']['name'];
        $_FILES['file']['type']     = $_FILES['author']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['author']['tmp_name'];
        $_FILES['file']['error']     = $_FILES['author']['error'];
        $_FILES['file']['size']     = $_FILES['author']['size'];
        if ( ! $this->upload->do_upload('file'))
        {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('err', 'File Format Npot support');
          redirect("edit/add_news");
        }
        else
        {
            $fileName = base_url('uploads/news/news_original_image/').$this->upload->data('file_name');
            $sourceProperties = getimagesize($fileName);
            $resizeFileName = $this->upload->data('file_name');
            $uploadPath = "./../uploads/products/gallery/";
            $fileExt = pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION);
            $uploadImageType = $sourceProperties[2];
            $sourceImageWidth = $sourceProperties[0];
            $sourceImageHeight = $sourceProperties[1];
            switch ($uploadImageType) 
            {
                case IMAGETYPE_JPEG:
                    $resourceType = imagecreatefromjpeg($fileName); 
                    $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                    imagejpeg($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                    break;
     
                case IMAGETYPE_GIF:
                    $resourceType = imagecreatefromgif($fileName); 
                    $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                    imagegif($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                    break;
     
                case IMAGETYPE_PNG:
                    $resourceType = imagecreatefrompng($fileName); 
                    $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                    imagepng($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                    break;
     
                default:
                    $imageProcess = 0;
                    break;
            }

            return $resizeFileName;
        }
    }

    public function author_image_thumbnail()
    {
        $file_type = 'image';
        $config['upload_path']          = 'uploads/author/author_orginal';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['encrypt_name']        = TRUE;
        $config['max_size']             = '';
        $config['max_width']            = '';
        $config['max_height']           = '';
        $upload_dir_thumbs = 'uploads/author/';
        $thumb_width = '650';
        $thumb_height = '450';   
        $this->load->library('upload', $config);
        $imageUpload = [];
        $_FILES['file']['name']     = $_FILES['author']['name'];
        $_FILES['file']['type']     = $_FILES['author']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['author']['tmp_name'];
        $_FILES['file']['error']     = $_FILES['author']['error'];
        $_FILES['file']['size']     = $_FILES['author']['size'];
        if ( ! $this->upload->do_upload('file'))
        {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('err', 'File Format Npot support');
          redirect("edit/add_news");
        }
        else
        {
            $fileName = base_url('uploads/author/author_orginal/').$this->upload->data('file_name');
            $sourceProperties = getimagesize($fileName);
            $resizeFileName = $this->upload->data('file_name');
            $fileExt = pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION);
            $uploadImageType = $sourceProperties[2];
            $sourceImageWidth = $sourceProperties[0];
            $sourceImageHeight = $sourceProperties[1];
            switch ($uploadImageType) 
            {
                case IMAGETYPE_JPEG:
                    $resourceType = imagecreatefromjpeg($fileName); 
                    $imageLayer = $this->resizeImage_author($resourceType,$sourceImageWidth,$sourceImageHeight);
                    imagejpeg($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                    break;
     
                case IMAGETYPE_GIF:
                    $resourceType = imagecreatefromgif($fileName); 
                    $imageLayer = $this->resizeImage_author($resourceType,$sourceImageWidth,$sourceImageHeight);
                    imagegif($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                    break;
     
                case IMAGETYPE_PNG:
                    $resourceType = imagecreatefrompng($fileName); 
                    $imageLayer = $this->resizeImage_author($resourceType,$sourceImageWidth,$sourceImageHeight);
                    imagepng($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                    break;
     
                default:
                    $imageProcess = 0;
                    break;
            }

            return $resizeFileName;
        }
    }

    public function edit_news()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) 
        {
           $id = $this->input->post("id");
           if (!empty($_FILES['author']['name'])) 
           {
                if ($_FILES['author']['type'] == 'video/mp4' || $_FILES['author']['type'] == 'video/mpeg') 
                {
                    $file_type = 'video';
                    $target_path = "uploads/news/video/";
                    $target_dir = "uploads/news/video/";
                    $target_file_logo = $target_dir . basename($_FILES["author"]["name"]);
                    if(is_array($_FILES)) 
                    {
                        foreach($_FILES as $fileKey => $fileVal)
                           {
                               $author = basename($_FILES["author"]["name"]);
                               $title_extension = substr(strrchr($_FILES['author']['name'], '.'), 1);
                                       $author_name = time().".".$title_extension;
                               move_uploaded_file($_FILES["author"]["tmp_name"],$target_path.$author_name);
                                              
                             if(!empty($title_extension))
                             {
                                 $title = $author_name;
                             }
                           }
                    }
                    $array = array(
                        "news_title"=>$this->input->post("news_title"),
                        "cat_id"=>$this->input->post("cat_id"),
                        "author_id"=>$this->input->post("author_id"),
                        "published_date"=>$this->input->post("published_date"),
                        "news_subheading"=>$this->input->post("news_subheading"),
                        "news_desc"=>$this->input->post("news_desc"),
                        "news_is_published"=>$this->input->post("news_is_published"),
                        "news_search_tags"=>$this->input->post("news_search_tags"),
                        "file_type"=>$file_type,
                        "image"=>$title,
                        "status"=>1,
                        "in_banner"=>$this->input->post("in_banner")
                    );
                    $create = $this->c_m->get_all_result($array,'update','sd_news',array('id'=>$id));
                    if (!empty($this->input->post("related_news"))) 
                    {
                        $this->db->query("DELETE FROM `sd_related_news` WHERE `news_id`='$id'");
                        foreach ($this->input->post("related_news") as $keys) 
                        {
                           $r_array = array("news_id"=>$id,
                                            "related_news_id"=>$keys);
                           $this->db->insert('sd_related_news',$r_array);
                        }
                    }
                    else
                    {
                        $this->db->query("DELETE FROM `sd_related_news` WHERE `news_id`='$id'");
                    }
                    if ($create) {
                        $this->session->set_flashdata('delete','Update Successfully...');
                        redirect("edit/edit_news".'/'.$id);
                    }
                    else
                    {
                        $this->session->set_flashdata('err','Something went wrong please try again...');
                        redirect("edit/edit_news".'/'.$id);  
                    }
                }
                elseif ($_FILES['author']['type'] == 'image/jpeg' || $_FILES['author']['type'] == 'image/png') 
                {
                    $file_type = 'image';
                    $image_name = $this->news_image_thumbnail($_FILES);
                    $array = array(
                        "news_title"=>$this->input->post("news_title"),
                        "cat_id"=>$this->input->post("cat_id"),
                        "author_id"=>$this->input->post("author_id"),
                        "published_date"=>$this->input->post("published_date"),
                        "news_subheading"=>$this->input->post("news_subheading"),
                        "news_desc"=>$this->input->post("news_desc"),
                        "news_is_published"=>$this->input->post("news_is_published"),
                        "news_search_tags"=>$this->input->post("news_search_tags"),
                        "file_type"=>$file_type,
                        "image"=>$image_name,
                        "status"=>1,
                        "in_banner"=>$this->input->post("in_banner")
                        );
                    $create = $this->c_m->get_all_result($array,'update','sd_news',array('id'=>$id));
                    if (!empty($this->input->post("related_news"))) 
                    {
                        $this->db->query("DELETE FROM `sd_related_news` WHERE `news_id`='$id'");
                        foreach ($this->input->post("related_news") as $keys) 
                        {
                           $r_array = array("news_id"=>$id,
                                            "related_news_id"=>$keys);
                           $this->db->insert('sd_related_news',$r_array);
                        }
                    }
                    else
                    {
                        $this->db->query("DELETE FROM `sd_related_news` WHERE `news_id`='$id'");
                    }
                    if ($create) {
                        $this->session->set_flashdata('delete','Update Successfully...');
                        redirect("edit/edit_news".'/'.$id);
                    }
                    else
                    {
                        $this->session->set_flashdata('err','Something went wrong please try again...');
                        redirect("edit/edit_news".'/'.$id);  
                    }

                }
                else
                {
                    $this->session->set_flashdata('err','File Format Npot support');
                    redirect("edit/add_news");
                }
           }
           else
           {
             $array = array(
                        "news_title"=>$this->input->post("news_title"),
                        "cat_id"=>$this->input->post("cat_id"),
                        "author_id"=>$this->input->post("author_id"),
                        "published_date"=>$this->input->post("published_date"),
                        "news_subheading"=>$this->input->post("news_subheading"),
                        "news_desc"=>$this->input->post("news_desc"),
                        "news_is_published"=>$this->input->post("news_is_published"),
                        "news_search_tags"=>$this->input->post("news_search_tags"),
                        "status"=>$this->input->post("status"),
                         "in_banner"=>$this->input->post("in_banner"));
            $create = $this->c_m->get_all_result($array,'update','sd_news',array('id'=>$id));
            if (!empty($this->input->post("related_news"))) 
            {
                $this->db->query("DELETE FROM `sd_related_news` WHERE `news_id`='$id'");
                foreach ($this->input->post("related_news") as $keys) 
                {
                   $r_array = array("news_id"=>$id,
                                    "related_news_id"=>$keys);
                   $this->db->insert('sd_related_news',$r_array);
                }
            }
            else
            {
                $this->db->query("DELETE FROM `sd_related_news` WHERE `news_id`='$id'");
            }
            if ($create) {
                $this->session->set_flashdata('delete','Update Successfully...');
                redirect("edit/edit_news".'/'.$id);
            }
            else
            {
                $this->session->set_flashdata('err','Something went wrong please try again...');
                redirect("edit/edit_news".'/'.$id);  
            }
           }
        }
        else
        {
            $query1 = 'SELECT * FROM `sd_category` WHERE `status`="1" ORDER BY `id` DESC';
            $this->data['cate'] = $this->c_m->get_all_result($query1,'select','','');
            $query = 'SELECT * FROM `sd_author` WHERE `status`="1" ORDER BY `id` DESC';
            $this->data['author'] = $this->c_m->get_all_result($query,'select','','');
            $query2 = 'SELECT * FROM `sd_news` WHERE id="'.$id.'" ORDER BY `id` DESC';
            $this->data['list'] = $this->c_m->get_all_result($query2,'single_row','','');
            $query3 = 'SELECT * FROM `sd_news` WHERE `status`="1" ORDER BY `id` DESC';
            $this->data['news'] = $this->c_m->get_all_result($query3,'select','','');
            $this->data["subview"] = "edit/edit_news";
            $this->load->view('_layout_main', $this->data);
        }
        
    }

    public function delete_news()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','sd_news',array('id'=>$id));
        if ($create) {
            $this->session->set_flashdata('delete','Delete Successfully...');
            redirect("edit/news");   
        }
        else
        {
            $this->session->set_flashdata('err','Something went wrong please try again...');
            redirect("edit/news");
        }
    }


    public function resizeImage($resourceType,$image_width,$image_height) 
    {
      $resizeWidth = 650;
      $resizeHeight = 450;
      $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
    $white = imagecolorallocatealpha($imageLayer, 255, 255, 255, 70);
   imagefill($imageLayer, 0, 0, $white);
      imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
      return $imageLayer;
   }

   public function resizeImage_author($resourceType,$image_width,$image_height) 
    {
      $resizeWidth = 80;
      $resizeHeight = 80;
      $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
    $white = imagecolorallocatealpha($imageLayer, 255, 255, 255, 70);
   imagefill($imageLayer, 0, 0, $white);
      imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
      return $imageLayer;
   }


   public function author()
   {
        $query = 'SELECT * FROM `sd_author` WHERE `status` <> "2" ORDER BY `name` ASC';
        $this->data['list'] = $this->c_m->get_all_result($query,'select','','');
        $this->data["subview"] = "edit/author";
        $this->load->view('_layout_main', $this->data);
    } 

    public function add_author()
    {
        if ($_POST) 
        {
            if($_FILES['author']['type'] == 'image/jpeg' || $_FILES['author']['type'] == 'image/png') 
            {
                $image_name = $this->author_image_thumbnail($_FILES);
            }
            else
            {
                $image_name = 'default.png';     
            }
            $array = array("name"=>$this->input->post("name"),
                           "post"=>$this->input->post("post"),
                           "image"=>$image_name,
                           "status"=>1,
                           "is_top"=>$this->input->post("is_top")
                          );
            $this->db->insert('sd_author',$array);
            $this->session->set_flashdata('delete','Add Successfully!!!!!!');
            redirect("edit/author");
            
        }
        else
        {
            $this->data["subview"] = "edit/add_author";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit_author()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) 
        {
           $id = $this->input->post("id");
           if (!empty($_FILES['author']['name'])) 
           {
                if ($_FILES['author']['type'] == 'image/jpeg' || $_FILES['author']['type'] == 'image/png') 
                {
                    $image_name = $this->author_image_thumbnail($_FILES);
                }
                else
                {
                     $image_name = 'default.png'; 
                }
                $array = array(
                        "name"=>$this->input->post("name"),
                        "post"=>$this->input->post("post"),
                        "image"=>$image_name,
                        "status"=>$this->input->post("status"),
                        "is_top"=>$this->input->post("is_top")
                        );
                $create = $this->c_m->get_all_result($array,'update','sd_author',array('id'=>$id));
                if ($create) 
                {
                    $this->session->set_flashdata('delete','Update Successfully...');
                    redirect("edit/edit_author".'/'.$id);
                }
                else
                {
                    $this->session->set_flashdata('err','Something went wrong please try again...');
                    redirect("edit/edit_auhtor".'/'.$id);  
                }
           }
           else
           {
             $array = array(
                        "name"=>$this->input->post("name"),
                        "post"=>$this->input->post("post"),
                        "status"=>$this->input->post("status"),
                        "is_top"=>$this->input->post("is_top"));
             $create = $this->c_m->get_all_result($array,'update','sd_author',array('id'=>$id));
             if ($create) 
             {
                    $this->session->set_flashdata('delete','Update Successfully...');
                    redirect("edit/edit_author".'/'.$id);
             }
             else
             {
                    $this->session->set_flashdata('err','Something went wrong please try again...');
                    redirect("edit/edit_auhtor".'/'.$id);  
             }
           }
        }
        else
        {
          $query = "SELECT * FROM `sd_author` WHERE `id` = '$id'";
          $this->data['list'] = $this->c_m->get_all_result($query,'single_row','','');
          $this->data["subview"] = "edit/edit_author";
          $this->load->view('_layout_main', $this->data);
        }
    }

    public function delete_author()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','sd_author',array('id'=>$id));
        if ($create) {
            $this->session->set_flashdata('delete','Delete Successfully...');
            redirect("edit/author");   
        }
        else
        {
            $this->session->set_flashdata('err','Something went wrong please try again...');
            redirect("edit/author");
        }
    }

    public function polls()
    {
        $query = "SELECT * FROM `sd_poll` ORDER BY `id` DESC";
        $this->data['list'] = $this->c_m->get_all_result($query,'select','','');
        $this->data["subview"] = "poll/list_poll";
        $this->load->view('_layout_main.php', $this->data);
    }

    public function create_poll()
    {
        $date = date('Y-m-d');
        if ($_POST) 
        {
            $array = array("question"=>$this->input->post("question"),
                               "option1"=>$this->input->post("option1"),
                               "option2"=>$this->input->post("option2"),
                               "option3"=>$this->input->post("option3"),
                               "option4"=>$this->input->post("option4"),
                               "in_home"=>$this->input->post('in_home'),
                               "added_on"=>time(),
                               "status"=>1);
            $this->db->insert('sd_poll',$array);
            $this->session->set_flashdata('delete','Add Successfully!!!!!!');
            redirect("edit/polls");
        }
        else
        {
            $this->data["subview"] = "poll/create_poll";
            $this->load->view('_layout_main.php', $this->data);
        }
        
        
    }
    

    public function edit_poll()
    {
        $date = date('Y-m-d');
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {
            $id = $this->input->post("id");
            $query = "SELECT * FROM `sd_poll` a WHERE a.`id` = '$id'";
            $this->data['list'] = $this->c_m->get_all_result($query,'single_row','','');
            $array = array(    "question"=>$this->input->post("question"),
                               "option1"=>$this->input->post("option1"),
                               "option2"=>$this->input->post("option2"),
                               "option3"=>$this->input->post("option3"),
                               "option4"=>$this->input->post("option4"),
                               "status" =>  $this->input->post('status'),
                               "in_home"=>$this->input->post('in_home'));
            $create = $this->c_m->get_all_result($array,'update','sd_poll',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('delete','Update Successfully...');
                redirect("edit/edit_poll".'/'.$id);
            }
            else
            {
                $this->session->set_flashdata('err','Something went wrong please try again...');
                redirect("edit/edit_poll".'/'.$id); 
            }
        }
        else
        {

          $query2 = "SELECT a.`id`, `question`,`in_home`, `option1`, `option2`, `option3`, `option4`, `answer`, `status` FROM `sd_poll` a WHERE a.`id` = '$id'";
          $this->data['list2'] = $this->c_m->get_all_result($query2,'single_row','','');
          $this->data["subview"] = "poll/edit_poll";
          $this->load->view('_layout_main', $this->data);
        }
    }



    public function ambulance_category()
    {

        $config = array();
        $config["base_url"] = base_url() . "speedhuntson/ambulance_category";
        $config["total_rows"] = $this->c_m->get_count_ambulance('ambulance_category');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 30;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_data_ambulance($config["per_page"],$template['page'],'ambulance_category');
        $template["links"] = $this->pagination->create_links();


        // $query = 'SELECT * FROM `ambulance_category` WHERE `status` <> "2" ORDER BY `name` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/ambulance_category";
        $template['page_title'] = "Ambulance Category Details";
        $this->load->view('template',$template);
    } 


    public function add_ambulance_category()
    {
      //  print_r($_SESSION['id']);die;
        if ($_POST) 
        {  
           
                        if ($_FILES['icon']['type'] == 'image/jpeg' || $_FILES['icon']['type'] == 'image/png') 
                        {
                            $target_path = "uploads/ambulance/category/";
                             $target_dir = "uploads/ambulance/category/";
                            $target_file_logo_driver = $target_dir . basename($_FILES["icon"]["name"]);
                            $title_image_driver = basename($_FILES["icon"]["name"]);
                            $title_extension_driver = substr(strrchr($_FILES['icon']['name'], '.'), 1);
                            $title_image_name_driver = time().".".$title_extension_driver;
                            move_uploaded_file($_FILES["icon"]["tmp_name"],$target_path.$title_image_name_driver);
                            if(!empty($title_extension_driver))
                            {
                                $icon = $title_image_name_driver;
                            }
                            else
                            {
                                $icon = 'default.png';
                            }
                        }
                        else
                        {
                            $icon = 'default.png';
                        }


                       

                        $array = array(
                            "name"=>$this->input->post("name"),
                            "price"=>$this->input->post("price"),
                            "is_call"=>$this->input->post("is_call"),
                            "position"=>$this->input->post("position"),
                            "icon"=>$icon,
                            "status"=>1,
                            "added_by"=>$_SESSION['id'],
                            "added_on"=>date('Y-m-d H:i:s'),
                        
                            );
                        $this->db->insert('ambulance_category',$array);
                        //echo $this->db->last_query(); die;
                        $news_id = $this->db->insert_id();
                        $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("speedhuntson/ambulance_category");
                    }
              
        else
        {
            $query1 = 'SELECT * FROM `hospital` WHERE `status`="1" ORDER BY `id` DESC';
            $template['hospital'] = $this->c_m->get_all_result($query1,'select','','');
            $template['page'] = "ambulance/add_ambulance_category";
            $template['page_title'] = "Add Ambulance";
            $this->load->view('template',$template);
        }
    }

     public function edit_ambulance_category()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {

            $old_img = $this->input->post('image11');
            
           // $id = $this->uri->segment(3);
            if (!empty($_FILES['icon']) && !empty(trim($_FILES['icon']['name']))) {
                $config['upload_path'] = 'uploads/ambulance/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $imageUpload = '';
                if (!$this->upload->do_upload('icon')) {
                    $display_image = $old_img;
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                }
                else {
                    $imageUpload = $this->upload->data();
                    $display_image = $imageUpload['file_name'];
                    
                    unlink($old_img);
                    

                }
            }
            else {
                $display_image = $old_img;
            }

          

            $array = array(
                           "name"=>$this->input->post("name"),
                            "price"=>$this->input->post("price"),
                            "is_call"=>$this->input->post("is_call"),
                            "position"=>$this->input->post("position"),
                            "icon"=>$display_image,
                            "status"=>1,
                            "added_by"=>$_SESSION['id'],
                            "added_on"=>date('Y-m-d H:i:s'),
                            );
             $create = $this->c_m->get_all_result($array,'update','ambulance_category',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
                redirect("speedhuntson/edit_ambulance_category/".$id);
            }
            else
            {
                $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
                redirect("speedhuntson/edit_ambulance_category/".$id);  
            }
        }
        else
        {
          $query = "SELECT * FROM `ambulance_category` WHERE `id` = '$id'";
          $template['list'] = $this->c_m->get_all_result($query,'single_row','','');
         // print_r($template['list']);die;
           $template['page'] = "ambulance/edit_ambulance_category";
          $template['page_title'] = "Edit Ambulance category";
          $this->load->view('template',$template);
        }
    }

 public function delete_ambulance_category()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','ambulance_category',array('id'=>$id));
        if ($create) {
           // $this->session->set_flashdata('delete','Delete Successfully...');
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully','class' => 'success')); 
            redirect("speedhuntson/ambulance_category");  
        }
        else
        {
           // $this->session->set_flashdata('err','Something went wrong please try again...');
             $this->session->set_flashdata('message', array('message' => 'Something went wrong please try again...','class' => 'danger')); 
            redirect("speedhuntson/ambulance_category");
        }
    }


    public function medical_equipment_gallery()
    {


        $madiid = $this->uri->segment(3);
        $template['madiid'] =  $madiid;
       // print_r($madiid);die;
        $template['list'] = $this->c_m->medical_equipment_gallery($madiid);

        $template["links"] = $this->pagination->create_links();
        $query = 'SELECT * FROM `medical_equipment` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['medical_equipment_name'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/medical_equipment_gallery";
        $template['page_title'] = "Medical Equipment Details";
        $this->load->view('template',$template);
    } 


      public function add_medical_equipment_gallery()
    {
       if ($_FILES) 
        { 
         $ids=  $this->input->post("madi_id");

            $files = $_FILES;
            $count = count($_FILES['medical_equipment_image']['name']);
            for ($i = 0; $i < $count; $i++) {
                $_FILES['medical_equipment_image']['name'] = time() . $files['medical_equipment_image']['name'][$i];
                $_FILES['medical_equipment_image']['type'] = $files['medical_equipment_image']['type'][$i];
                $_FILES['medical_equipment_image']['tmp_name'] = $files['medical_equipment_image']['tmp_name'][$i];
                $_FILES['medical_equipment_image']['error'] = $files['medical_equipment_image']['error'][$i];
                $_FILES['medical_equipment_image']['size'] = $files['medical_equipment_image']['size'][$i];
                $config['upload_path'] = 'uploads/medical_equipment/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $config['max_width'] = '';
                $config['max_height'] = '';
                $this->load->library('upload', $config);
                //$this->upload->initialize($config);
                // $this->upload->do_upload('medical_equipment_image');
                if (!$this->upload->do_upload('medical_equipment_image')) {
                    // echo $this->upload->display_errors();
                    $data = $this->upload->display_errors();
                    $this->session->set_flashdata('message',array('message' => $data,'class' => 'danger'));
                    redirect(base_url('speedhuntson/medical_equipment_gallery/')."/".$ids);
                }
                $fileName = $this->upload->data('file_name');
                $medical_equipment_images[] = $fileName;
            }
          

           foreach($medical_equipment_images as $img_equ) {
                    $data = array(

                        'medical_equipment_id' => $this->input->post("madi_id"),
                        'image' => $img_equ,
                    );

                    $this->db->insert('medical_equipment_gallery',$data);

                  //  $medical_equipment_img = $this->Doctordetail_model->insert_data('medical_equipment_gallery', $data);
                }

            
            $this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
            redirect(base_url('speedhuntson/medical_equipment_gallery/')."/".$ids);
           // redirect("speedhuntson/medical_equipment_gallery");
        }
    }

     public function delete_medical_equipment_gallery() {
        
         $med = $this->uri->segment(3);
         $id = $this->uri->segment(4);
         $query = "DELETE FROM `medical_equipment_gallery` WHERE `id` = '$id'";
         $r = $this->c_m->get_all_result($query,'delete','','');

        $this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
       
       // redirect(base_url('speedhuntson/medical_equipment_gallery/')."/".$id);
       redirect(base_url().'speedhuntson/medical_equipment_gallery/'.$med);
     }

     public function medical_equipment_rental()
    {


         $config = array();
        $config["base_url"] = base_url() . "speedhuntson/medical_equipment_rental";
        $config["total_rows"] = $this->c_m->get_count_rental('medical_equipment');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 30;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_data_rental($config["per_page"],$template['page'],'medical_equipment');
        // echo $this->db->last_query(); die;
        $template["links"] = $this->pagination->create_links();


        // $query = 'SELECT * FROM `medical_equipment` WHERE `status` <> "2" ORDER BY `name` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/medical_equipment_rental";
        $template['page_title'] = "Medical Equipment rental Details";
        $this->load->view('template',$template);
    } 

     public function export_medical_equipment_rental()
    {
        $query = 'SELECT * FROM `medical_equipment` WHERE status = 1 AND `for` = "Rental" ORDER BY `name` ASC';
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name","For","Price","Discount","Description","image");
        
    $i=1;
    foreach($details as $user)
    {
        $price = "" ;
        if ($user['for'] == "Rental" ) 
        {
          $price = $user['rent_price'];
        }
        else
        {
          $price = $user['purchase_price'];
        }
        $discount = "";
         if ($user['for'] == "Purchase" ) 
        {
          $discount = $user['purchase_discount'];
        }
        else
        {
          $discount = $user['rent_discount'];
        }

      $data[] = array(
        "#" =>$i,
        "name"=>$user['name'],
        "for"=>$user['for'],
        "price"=>$price,
        "discount"=>$discount,
       
        "description"=>$user['description'],
        "image"=>base_url('/')."uploads/medical_equipment/".$user['image'],
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_medical_equipment_rental".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }


    public function medical_equipment_sell()
    {


         $config = array();
        $config["base_url"] = base_url() . "speedhuntson/medical_equipment_sell";
        $config["total_rows"] = $this->c_m->get_count_sell('medical_equipment');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 50;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_data_sell($config["per_page"],$template['page'],'medical_equipment');
        $template["links"] = $this->pagination->create_links();


        // $query = 'SELECT * FROM `medical_equipment` WHERE `status` <> "2" ORDER BY `name` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/medical_equipment_sell";
        $template['page_title'] = "Medical Equipment sell Details";
        $this->load->view('template',$template);
    } 

     public function export_medical_equipment_sell()
    {
        $query = 'SELECT * FROM `medical_equipment` WHERE status = 1 AND `for` = "Purchase" ORDER BY `name` ASC';
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name","For","Price","Discount","Description","image");
        
    $i=1;
    foreach($details as $user)
    {
        $price = "" ;
        if ($user['for'] == "Rental" ) 
        {
          $price = $user['rent_price'];
        }
        else
        {
          $price = $user['purchase_price'];
        }
        $discount = "";
         if ($user['for'] == "Purchase" ) 
        {
          $discount = $user['purchase_discount'];
        }
        else
        {
          $discount = $user['rent_discount'];
        }

      $data[] = array(
        "#" =>$i,
        "name"=>$user['name'],
        "for"=>$user['for'],
        "price"=>$price,
        "discount"=>$discount,
       
        "description"=>$user['description'],
        "image"=>base_url('/')."uploads/medical_equipment/".$user['image'],
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_medical_equipment_sell".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }



     

   public function medical_equipment($rowno=0)
    {
      $data = array();
      $equipment_name = "";
        if($this->input->post('submit') != NULL )
        {
            $equipment_name = $this->input->post('equipment_name');
          
            $sess = $this->session->set_userdata(array("equipment_name"=>$equipment_name));
        }
        if($this->input->post('reset') != NULL)
        {
            unset(
                    $_SESSION['equipment_name']
                );
        }else
        {
            if($this->session->userdata('equipment_name') != NULL)
            {
                $equipment_name = $this->session->userdata('equipment_name');
            }
        }
        $rowperpage = 30;
        if($rowno != 0)
        {
            $rowno = ($rowno-1) * $rowperpage;
        }

        $total_records = $this->c_m->get_count_medical_equipment_filter($equipment_name);
        $template['list'] = $this->c_m->get_pagination_data_medical_equipment_filter($rowno,$rowperpage,$equipment_name);
        $config['base_url'] = base_url() . '/speedhuntson/medical_equipment';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $rowperpage;
        $config['cur_tag_open'] = '<a class="current">';  
        $choice = $config["total_rows"]/$config["per_page"];
       $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        
        $template["links"] = $this->pagination->create_links();
        $template['row'] = $rowno;
        $template['equipment_name'] = $equipment_name;
      
        $template['page'] = "ambulance/medical_equipment";
        $template['page_title'] = "Medical Equipment Details";
        $this->load->view('template',$template);
    } 

     public function export_medical_equipment()
    {
        $query = 'SELECT * FROM `medical_equipment` WHERE status = 1 ORDER BY `name` ASC';
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name","For","Price","Discount","Description","image");
        
    $i=1;
    foreach($details as $user)
    {
        $price = "" ;
        if ($user['for'] == "Rental" ) 
        {
          $price = $user['rent_price'];
        }
        else
        {
          $price = $user['purchase_price'];
        }
        $discount = "";
         if ($user['for'] == "Purchase" ) 
        {
          $discount = $user['purchase_discount'];
        }
        else
        {
          $discount = $user['rent_discount'];
        }

      $data[] = array(
        "#" =>$i,
        "name"=>$user['name'],
        "for"=>$user['for'],
        "price"=>$price,
        "discount"=>$discount,
       
        "description"=>$user['description'],
        "image"=>base_url('/')."uploads/medical_equipment/".$user['image'],
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_ambulance".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }



     public function add_medical_equipment()
    {
        $uri = $this->uri->segment(3);
        //if($uri == 'new_booking')
        //print_r($uri);die;
        if ($_POST) 
        {  
            // print_r($_POST);die;
            if(!empty($_FILES['image'])){
                        $config['upload_path']          = 'uploads/medical_equipment';
                        $config['allowed_types']        = 'jpg|png|jpeg';
                        $config['max_size']             = '';
                        $config['max_width']            = '';
                        $config['max_height']           = '';
                        $config['encrypt_name']         = TRUE;
                        $this->load->library('upload', $config);
                        $imageUpload = '';

                        if ( ! $this->upload->do_upload('image'))
                        {
                           // $error = array('error' => $this->upload->display_errors());
                              $data = $this->upload->display_errors();
                             $this->session->set_flashdata('message',array('message' => $data,'class' => 'danger'));
                            redirect("speedhuntson/medical_equipment");
                        }
                        else
                        {
                            $imageUpload =  $this->upload->data();
                            
                            
                        }
                       
                            $display_image = $imageUpload['file_name'];
                    }else{
                        $display_image= '';
                    }
                    if (empty($this->input->post("for_month_week"))) 
                    {
                        $for_month_week = "0";
                    }
                    else
                    {
                        $for_month_week = $this->input->post("for_month_week");
                    }

           
                        $array = array(
                            "name"=>$this->input->post("name"),
                            "description"=>$this->input->post("description"),
                            "for"=>$this->input->post("for"),
                            "rent_price"=>$this->input->post("rent_price"),
                            "rent_discount"=>$this->input->post("rent_discount"),
                            "rent_month_price"=>$this->input->post("rent_month_price"),
                            "rent_month_discount_price"=>$this->input->post("rent_month_discount_price"),
                            "purchase_price"=>$this->input->post("purchase_price"),
                            "purchase_discount"=>$this->input->post("purchase_discount"),
                            "for_month_week"=>$for_month_week,
                            "image"=>$display_image,
                            "status"=>1,
                            "added_by"=>$_SESSION['id'],
                            "added_on"=>date('Y-m-d H:i:s'),
                        
                            );
                        $this->db->insert('medical_equipment',$array);
                        //echo $this->db->last_query(); die;
                        if($uri == 'rental')
                        {
                        $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("speedhuntson/medical_equipment_rental");
                        }
                        elseif ($uri == 'sell') {
                           $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        //redirect("speedhuntson/medical_equipment");
                        redirect("speedhuntson/medical_equipment_sell");
                        }
                        else
                        {
                             $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                            redirect("speedhuntson/medical_equipment"); 
                        }
                    }
              
        else
        {
          
            $template['page'] = "ambulance/add_medical_equipment";
            $template['page_title'] = "Add Ambulance";
            $this->load->view('template',$template);
        }
    }


    public function edit_medical_equipment()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {

            $old_img = $this->input->post('image11');
            
            $id = $this->uri->segment(3);
            if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
                $config['upload_path'] = 'uploads/medical_equipment';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $imageUpload = '';
                if (!$this->upload->do_upload('image')) {
                    $display_image = $old_img;
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                }
                else {
                    $imageUpload = $this->upload->data();
                    $display_image = $imageUpload['file_name'];
                    
                    unlink($old_img);
                    

                }
            }
            else {
                $display_image = $old_img;
            }

            if (empty($this->input->post("for_month_week"))) 
                    {
                        $for_month_week = "0";
                    }
                    else
                    {
                        $for_month_week = $this->input->post("for_month_week");
                    }

            $array = array(
                           "name"=>$this->input->post("name"),
                            "description"=>$this->input->post("description"),
                            "for"=>$this->input->post("for"),
                            "rent_price"=>$this->input->post("rent_price"),
                            "rent_discount"=>$this->input->post("rent_discount"),
                             "rent_month_price"=>$this->input->post("rent_month_price"),
                            "rent_month_discount_price"=>$this->input->post("rent_month_discount_price"),
                            "purchase_price"=>$this->input->post("purchase_price"),
                            "purchase_discount"=>$this->input->post("purchase_discount"),
                             "for_month_week"=>$for_month_week,
                            'image' => $display_image,
                            "added_by"=>$_SESSION['id'],
                            "added_on"=>date('Y-m-d H:i:s'),
                            );
             $create = $this->c_m->get_all_result($array,'update','medical_equipment',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
               // redirect("speedhuntson/medical_equipment"); 
                redirect($_SERVER['HTTP_REFERER']);
                //redirect("speedhuntson/edit_medical_equipment/".$id);
            }
            else
            {
                $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
             //   redirect("speedhuntson/medical_equipment"); 
                redirect($_SERVER['HTTP_REFERER']);
                // redirect("speedhuntson/edit_medical_equipment/".$id);  
            }
        }
        else
        {
          $query = "SELECT * FROM `medical_equipment` WHERE `id` = '$id'";
          $template['lists'] = $this->c_m->get_all_result($query,'single_row','','');
           $template['page'] = "ambulance/edit_medical_equipment";
          $template['page_title'] = "Edit Medical Equipment";
          $this->load->view('template',$template);
        }
    }

     public function delete_medical_equipment()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','medical_equipment',array('id'=>$id));
        if ($create) {
           // $this->session->set_flashdata('delete','Delete Successfully...');
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully','class' => 'success')); 
            redirect("speedhuntson/medical_equipment");  
        }
        else
        {
           // $this->session->set_flashdata('err','Something went wrong please try again...');
             $this->session->set_flashdata('message', array('message' => 'Something went wrong please try again...','class' => 'danger')); 
            redirect("speedhuntson/medical_equipment");
        }
    }


    public function all_booking()
    {
       // print_r($_SESSION);die;
        $config = array();
        $config["base_url"] = base_url() . "speedhuntson/all_booking";
        $config["total_rows"] = $this->c_m->get_count_all_booking('booking');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 50;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_all_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();



       // print_r($template['ambulance']);die;
        // $query = 'SELECT * FROM `booking` WHERE status = 0  ORDER BY `added_on` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/all_booking";
        $template['page_title'] = "all_booking Details";
        $this->load->view('template',$template);
    }

     public function export_booking()
    {
       $uri = $this->uri->segment(3);
        if($uri == 'new_booking')
       {
            $status = 0;
            $query = 'SELECT * FROM `booking` where status = 0 AND `booking_type` = 6 ORDER BY `added_on` DESC';
       }
       elseif($uri == 'all_booking')
       {
            $query = 'SELECT * FROM `booking` WHERE  `booking_type` = 6 ORDER BY `added_on` DESC';
       }
       elseif($uri == 'cancel_booking')
       {
            $query = 'SELECT * FROM `booking` where status IN (2,3) AND `booking_type` = 6 ORDER BY `added_on` DESC';
       }
       elseif($uri == 'complete_booking')
       {
            $query = 'SELECT * FROM `booking` where status = 1 AND `booking_type` = 6  ORDER BY `added_on` DESC';
       }

        
        $details=  $this->c_m->get_all_result_array($query,'select','','');
       // print_r($details);die;


     $data[] = array("#","Booking Type","Ambulance Name","Ambulance Oner Name","Ambulance Driver Number","Ambulance Catgeory","Ambulance Price","Patient Name","Patient Email","Patient Mobile","Service Name","Doctor Name","Booking For","Name","Gender","Dob","Address","Area","Pincode","City State","Booking Date","Booking Time","Assign By","Coupan Code","Total Amount","Discount Amount/Percentage","Discount Amount","Tax Amount","Base Amount","Trxn Status","Trxn Mode","Trxn Id");
        
    $i=1;
    foreach($details as $user)
    {

        $booking_type = $user['booking_type'];
            if ($booking_type == 1) {
                $booking_type = "Doctor Doorstep";
             }
             elseif ($booking_type == 2) {
                $booking_type = "Nurse Booking";
              }
              elseif ($booking_type == 3) {
                $booking_type = "Medical Services Doorstep";
              }
              elseif ($booking_type == 4) {
               $booking_type = "Online Consult";
              }
              elseif ($booking_type == 5) {
                $booking_type = "Doctor Appointment Clicnic";
              }
              else{
                $booking_type = "Ambulance";
              }

        $query = 'SELECT * FROM `ambulance` WHERE `id`="'.$user['ambulance_assign_id'].'"';
        $ambulance_data = $this->c_m->get_all_result_array($query,'single_row','','');

        $query2 = 'SELECT * FROM `ambulance_category` WHERE `id`="'.$user['ambulance_cat_id'].'"';
        $ambulance_category = $this->c_m->get_all_result_array($query2,'single_row','','');

        $query3 = 'SELECT * FROM `patient` WHERE `id`="'.$user['patient_id'].'"';
        $patient = $this->c_m->get_all_result_array($query3,'single_row','','');

        $query4 = 'SELECT * FROM `doctor` WHERE `id`="'.$user['doctor_id'].'"';
        $doctor = $this->c_m->get_all_result_array($query4,'single_row','','');

        $query5 = 'SELECT * FROM `doctor_services` WHERE `id`="'.$user['service_id'].'"';
        $doctor_services = $this->c_m->get_all_result_array($query5,'single_row','','');

         $query6 = 'SELECT * FROM `nurse` WHERE `id`="'.$user['nurse_assign_id'].'"';
        $nurse = $this->c_m->get_all_result_array($query6,'single_row','','');

         $query7 = 'SELECT * FROM `admin` WHERE `id`="'.$user['assign_by'].'"';
        $assign_by = $this->c_m->get_all_result_array($query7,'single_row','','');

        $query8 = 'SELECT * FROM `coupan` WHERE `id`="'.$user['coupan_code_id'].'"';
        $coupan = $this->c_m->get_all_result_array($query8,'single_row','','');
        
        $value ="";
        if ($coupan['discount_type'] == "percentage") {
          $value = "%";
        }else{
          $value = "₹";
        }
   
      $data[] = array(
        "#" =>$i,
        "booking_type"=>$booking_type,
        "ambulancename"=>$ambulance_data['name'],
        "ambulancename_owner_name"=>$ambulance_data['owner_name'],
        "ambulance_driver_number"=>$ambulance_data['driver_number'],
        "ambulance_category"=>$ambulance_category['name'],
        "ambulance_price"=>$ambulance_category['price'],
        "patient"=>$patient['patient_firstname'],
        "patient_email"=>$patient['email'],
        "patient_phone"=>$patient['phone'],
        "doctor_services"=>$doctor_services['service_name'],
        "doctor_name"=>$doctor['doctor_firstname'],
        "booking_for"=>$user['booking_for'],
        "name"=>$user['name'],
        "gender"=>$user['gender'],
        "dob"=>$user['dob'],
        "address"=>$user['address'],
        "area"=>$user['area'],
        "pincode"=>$user['pincode'],
        "city_state"=>$user['city_state'],
        "booking_date"=>$user['booking_date'],
        "booking_time"=>$user['booking_time'],
        "assign_by"=>$assign_by['username'],
        "coupan_code"=>$user['coupan_code'],
        "total_amount"=>$user['total_amount'],
        "amount_percentage"=>$coupan['amount'].$value,
        "discount_amount"=>$user['discount_amount'],
        "tax_amount"=>$user['tax_amount'],
        "base_amount"=>$user['base_amount'],
        "trxn_status"=>$user['trxn_status'],
        "trxn_mode"=>$user['trxn_mode'],
        "trxn_id"=>$user['trxn_id'],
  
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_booking_".$uri.".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }

    



    public function new_booking()
    {
        $config = array();
        $config["base_url"] = base_url() . "speedhuntson/new_booking";
        $config["total_rows"] = $this->c_m->get_count_new_booking('booking');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 50;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_new_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();


       // print_r($template['ambulance']);die;
        // $query = 'SELECT * FROM `booking` WHERE status = 0  ORDER BY `added_on` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/new_booking";
        $template['page_title'] = "new booking Details";
        $this->load->view('template',$template);
    }


    public function cancel_booking()
    {
        $config = array();
        $config["base_url"] = base_url() . "speedhuntson/cancel_booking";
        $config["total_rows"] = $this->c_m->get_count_cancel_booking('booking');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 50;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_cancel_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();

       
        // $query = 'SELECT * FROM `booking` WHERE status = 4  ORDER BY `added_on` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/cancel_booking";
        $template['page_title'] = "Cancel booking Details";
        $this->load->view('template',$template);
    }

    public function complete_booking()
    {

         $config = array();
        $config["base_url"] = base_url() . "speedhuntson/complete_booking";
        $config["total_rows"] = $this->c_m->get_count_complete_booking('booking');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 50;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_complete_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
       
        // $query = 'SELECT * FROM `booking` WHERE status IN (2,3)  ORDER BY `added_on` ASC';
        // $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "ambulance/complete_booking";
        $template['page_title'] = "complete booking Details";
        $this->load->view('template',$template);
    }

    public function add_ambulance_booking()
    {
      //print_r($_POST);die; 
      if ($_POST) {   
        $booking_id =  $this->input->post("booking_id");
        $ambulance_id =  $this->input->post("ambulance_id");
        $ambulance = $this->db->where('id',$ambulance_id)->get('ambulance')->row();
        $assign_by =  $_SESSION['id'];
        $data = array
        (
        "assign_by"=>$assign_by,
        "ambulance_assign_id"=>$ambulance_id,
        "ambulance_cat_id"=>$ambulance->category
        );
        $create = $this->c_m->get_all_result($data,'update','booking',array('id'=>$booking_id));
        echo $this->db->last_query();       
      }
    }


     public function cancel_booking_id()
    {
        
        if ($_POST) {   
        $cancel_id =  $this->input->post("cancel_id");
        $assign_by = 
        $data = array
        (
        "status"=>3,
        "cancel_by_id"=>$_SESSION['id']
        );
        $create = $this->c_m->get_all_result($data,'update','booking',array('id'=>$cancel_id));
        echo $this->db->last_query();       
      }
    
    }


     public function cancel_ambulance_booking_id()
    {
        
        if ($_POST) {   
        $cancel_id =  $this->input->post("cancel_id");
        $assign_by = 
        $data = array
        (
        "status"=>3,
        "cancel_by_id"=>$_SESSION['id'],
        "updated_on"=>date('Y-m-d H:i:s')
        );
        $create = $this->c_m->get_all_result($data,'update','ambulence_booking',array('id'=>$cancel_id));
        echo $this->db->last_query();       
      }
    
    }


     public function complete_ambulance_booking_id()
    {
        
        if ($_POST) {   
        $cancel_id =  $this->input->post("cancel_id");
        $assign_by = 
        $data = array
        (
        "status"=>1,
        "cancel_by_id"=>$_SESSION['id'],
        "updated_on"=>date('Y-m-d H:i:s')
        );
        $create = $this->c_m->get_all_result($data,'update','ambulence_booking',array('id'=>$cancel_id));
        if ($create) 
        {
          $this->send_emailAMB($cancel_id);
          $this->send_smsAMB($cancel_id);
          $this->send_single_notification($cancel_id);
        }
        echo $this->db->last_query();       
      }
    
    }






    public function send_emailAMB($cancel_id)
    {
      $getbooking_test = $this->db->get_where('ambulence_booking',array('id' => $cancel_id))->row();
     //print_r($getbooking_test);die;
           $patient = $this->db->get_where('patient',array('id' => $getbooking_test->user_id))->row();
            $booking_patient_name = $patient->name;
            $booking_patient_email = $patient->email;
            $booking_patient_phone = $patient->phone;
            $resolve_pdf = $getbooking_test->resolve_pdf ;

           $settings = $this->db->get_where('settings',array('id'=>1))->row();

       
        $this->load->library('My_PHPMailer');
        $this->load->helper('string');
        $subject = "Ambulence booking complete successfully";
        $body= '<table width="100%">
   <tr style="background:#e1e9ef;">
      <td style="padding: 20px;"> <img src="http://anytimedoc.in/images/logo-1.png" tabindex="0"> </td>
   </tr>
   <tr>
      <td height="10"> </td>
   </tr>
   <tr>
      <td style="padding:0 24px">
         <h1 style="color:#212121;font-size:24px;margin:0">Ambulance booking!</h1>
      </td>
   </tr>
   <tr>
      <td style="padding:0 24px">
         <p style="color:#757575;font-size:16px;margin:16px 0 0">Hi, '.$booking_patient_name.' You ambulence booking is done.</p>
      </td>
   </tr>
  <table cellpadding="0" cellspacing="0" width="100%" style="margin-top:20px">
            <tbody>
               <tr>
                  <th style="color:#575758;background-color:#cbd5e6;width:60%;padding:9px;text-align:left;font-weight:normal;font-size:12px;font-family:verdana">Ambulance booking summary</th>
                  
               </tr>
               <tr>
                  <td colspan="2">
                     <table cellpadding="10" cellspacing="0" border="0" width="100%">
                        <tbody>
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;width:40%;font-family:verdana">From</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$getbooking_test->from_.'</td>
                           </tr>
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">To</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$getbooking_test->to_.'</td>
                           </tr>
                          
                           
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
     <table>
               <tr height="10"></tr>
            </table>
            <table cellpadding="10" cellspacing="10" bgcolor="#35a4ff" style="width:100%; color: #fff; text-align: center; border-collapse: collapse;">
               <tr>
                  <td style="line-height: 1.5;">
                     support@anytimedoc.in<br>
                     24 x 7 helpline - 7724000070<br>
                     © 2019 Anytimedoc. All Rights Reserved.
                  </td>
            </table>
</table>';
       $mail = new PHPMailer;
        $mail->isSMTP();  
       $mail->Host = $settings->smtp_host;
        $mail->SMTPAuth = true;
          $mail->Password = 'appslure@321';//'appslure123'; // '@appsgenic123@';
            $mail->Username = $settings->smtp_username;//'form41app@gmail.com'; //'mail@appsgenic.com';
      $mail->Password = $settings->smtp_password;//
        $mail->SMTPSecure = 'tls';
        $mail->Port =587;
        $mail->From = 'admin@anytimedoc.com';
        $mail->FromName = 'ANYTIMEDOC ambulence booking complete successfully';
        $mail->addAddress($booking_patient_email, 'ANYTIMEDOC');
       // $mail->addAttachment($labs_images);
        $mail->AddAttachment($pdf);
                 // Add attachments

        $mail->WordWrap = 500;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        if(!$mail->send())
        {
            return false;
        }
        else
        {
            return true;
        }    
    }

    public function send_single_notification($cancel_id)
    {
        if($cancel_id)
        {
          $message = "Ambulence booking is complete successfully" ;
          $title = "Ambulence Booking";        
          $selected_android_user1 = array();
          $selected_ios_user1 = array();
          $getbooking_test = $this->db->get_where('ambulence_booking',array('id' => $cancel_id))->row();
     //print_r($getbooking_test);die;
           $patient_token = $this->db->get_where('patient',array('id' => $getbooking_test->user_id))->row();
          // $patient_token = $this->db->query("SELECT * FROM `patient` WHERE device_token !='' AND id IN ($b_id)")->result();
          if (count($patient_token) > 0)
          {
           
              if($patient_token->device_type == 'android')
              {
                array_push($selected_android_user1, $patient_token->device_token);
              }
              
              
              if($patient_token->device_type == 'ios')
              {
                  array_push($selected_ios_user1, $patient_token->device_token);
              }
              $alluserID.=$patient_token->id.',';
              
          
           $getuserID = rtrim($alluserID,',');

            if(count($selected_android_user1))
            {
                $notification_type1 = "text";
                $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title.'","msg":"'.$message.'","type":"no"}';
                     //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
                $message2 = array(
                             'body' => $message,
                             'title' => $title,
                             'sound' => 'Default'
                         );

                $regIdChunk1=array_chunk($selected_android_user1,1000);
                foreach($regIdChunk1 as $RegId1){
                  $a = $this->sendMessageThroughFCMAMB($RegId1,$message2);
                }
              }

              if(count($selected_ios_user1))
              {
                  $notification_type1 = "text";
                     $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title.'","msg":"'.$message.'","type":"no"}';
                     //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
                     $message2 = array(
                             'body' => $message,
                             'title' => $title,
                             'sound' => 'Default'
                         );

                     $regIdChunk1=array_chunk($selected_ios_user1,1000);
                     foreach($regIdChunk1 as $RegId1){
                      $a = $this->send_ios_notificationAMB($RegId1,$message2,"ios");
                     }
              }

              $insert_array = array('user_id' => $getuserID,
                                    'title' => $title,
                                    'notification' => $message,
                                    'type' => 'ambulance',
                                    'added_on' => date('Y-m-d H:i:s')
                                    );

              $insert = $this->db->insert('user_notification',$insert_array);
              // if($insert)
              // {
              //   redirect(base_url('Patient_details/send_single'));
              // }
          }
        }
        
    }

     public function sendMessageThroughFCMAMB($registatoin_ids, $message)
    {
    //FCM ENDPONT Url
        // $setting = $this->db->query("SELECT `firebase_api_key` FROM `setting` WHERE `settingID`='1'")->row();
        // if (count($setting) > 0)
        // {
        // $k = $setting->firebase_api_key;
        // }
        // else
        // {


        // $k = 'AAAAXHb-Bzs:APA91bFwfXFtSOC0ASXjs6CzoCPx2KeO425JWmI3_FoFhNELITsfCd0OYAKD5lgvG8yqgEXKy87Jku16yOdj-BjJbHzLdpjIDnOs0PQvTwNRvqK5jwJ55yg1RgtJnee2f0V6qqkOw2Hm';
        $k = 'AAAAb0zS7Yo:APA91bHpdehHo2KvTHjjwr4WryWMSwSJH0TRw-rhZymhP6xv0BvdXqRtxwe6AUT2glPRRVzvNQIk8W7yBhGF0m1WodmC_YsrT1tRDfyjLCWOfj7EkayN8fhJddDYUTI4MkJvXaVC2pgY';
        // }
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
        if ($result === FALSE) 
        {
            echo 'Curl failed ' . curl_error();die;
        }
        
        curl_close($ch);
//print_r($registatoin_ids);
    }

    public function send_ios_notificationAMB($device_token,$message_text,$type)
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



     public function send_smsAMB($cancel_id)
    {


      $getbooking_test = $this->db->get_where('ambulence_booking',array('id' => $cancel_id))->row();
     //print_r($getbooking_test);die;
      
        if($getbooking_test)
        {
         
            $patient = $this->db->get_where('patient',array('id' => $getbooking_test->user_id))->row();
            $patient_id = $patient->id;
            $patient_name = $patient->name;
            $patient_email = $patient->email;
            $patient_phone = $patient->phone;
        }
        $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $doctor_mobile = $settings->helpline_number;     

        if(!empty($patient_phone))
        {
            $msgtopatient= '';
            $msgtopatient.= "Hii ".$patient_name." your ambulence booking is complete successfully." ;
            $msg1 = urlencode($msgtopatient);
            $this->send_to_patient_msg($patient_phone,$msg1);
        }

       

    }







    public function transaction_details()
    {
    $transaction_id = trim($this->input->post('transaction_id'));

    $transaction_data = $this->db->where('id',$transaction_id)->get('booking')->row();
   // echo $transaction_data->coupan_code_id;die;
    if (!empty($transaction_data->coupan_code_id)) {
       
    $data="SELECT * FROM `booking` b INNER JOIN coupan c ON b.coupan_code_id = c.id WHERE b.coupan_code_id='$transaction_data->coupan_code_id'";
    }else{
      //  $data =  $this->db->where('id',$transaction_id)->get('booking')->row();
        $data = "SELECT * FROM `booking` WHERE `id` = '$transaction_id'";
    }
  //  echo $this->this->last_query();die;
   $d= $this->db->query($data);
   $row = $d->result_array();
    echo json_encode($row);
    }



      public function view_details()
    {
        
        $id = htmlentities(trim($this->uri->segment(3)));
       
         $query = "SELECT * FROM `booking` WHERE `id` = '$id'";
        $template['list'] = $this->c_m->get_all_result($query,'single_row','','');
       // print_r($template['list']);die;
        $template['page'] = "ambulance/view_details";
        $template['page_title'] = "Cancel booking Details";
        $this->load->view('template',$template);
    }


    // Coupan Module
    public function coupan_list()
    {
        $data = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->c_m->get_total_list_coupan();
        if ($total_records > 0) 
        {
            $template['total_data'] = $total_records;
            // get current page records
            $template['list'] = $this->c_m->get__list_coupan($limit_per_page, $start_index);
            $config['base_url'] = base_url() . 'speedhuntson/coupan_list/';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = $this->uri->total_segments();
            

            $config['full_tag_open'] = '<ul class="pagination pagination-separate pagination-outline-warning" style="float: right;">';
            $config['full_tag_close'] = ' </ul>';
             
            $config['first_link'] = '<li class="page-item"><span class="page-link"><i aria-hidden="true" class="fa fa-mail-reply"></i>';
            $config['first_tag_open'] = '';
            $config['first_tag_close'] = '</span></li>';
             
            $config['last_link'] = '<li class="page-item"><span class="page-link"><i aria-hidden="true" class="fa fa-mail-forward"></i>';
            $config['last_tag_open'] = '';
            $config['last_tag_close'] = '</span></li>';
             
            $config['next_link'] = '<li class="page-item"><span class="page-link">Next';
            $config['next_tag_open'] = '';
            $config['next_tag_close'] = '</span></li>';
 
            $config['prev_link'] = '<li class="page-item"><span class="page-link">Previous';
            $config['prev_tag_open'] = '';
            $config['prev_tag_close'] = '</span></li>';
 
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void();">';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close'] = '</span></li>';

            $this->pagination->initialize($config);
             
            // build paging links
            $template['links'] = $this->pagination->create_links();
        }
        else
        {
           $template['links'] = ''; 
           $template['list'] = '';
        }

        $template['page'] = "coupan/coupan_list";
        $template['page_title'] = "Coupan list";
        $this->load->view('template',$template);
       
    }

    public function filter_coupan_list()
    {
        
        if ($_POST) 
        {
            echo 1;
        }
        // $data = array();
        // $limit_per_page = 50;
        // $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // $total_records = $this->c_m->get_total_list_coupan();
        // if ($total_records > 0) 
        // {
        //     $template['total_data'] = $total_records;
        //     // get current page records
        //     $template['list'] = $this->c_m->get__list_coupan($limit_per_page, $start_index);
        //     $config['base_url'] = base_url() . 'speedhuntson/coupan_list/';
        //     $config['total_rows'] = $total_records;
        //     $config['per_page'] = $limit_per_page;
        //     $config["uri_segment"] = $this->uri->total_segments();
            

        //     $config['full_tag_open'] = '<ul class="pagination pagination-separate pagination-outline-warning" style="float: right;">';
        //     $config['full_tag_close'] = ' </ul>';
             
        //     $config['first_link'] = '<li class="page-item"><span class="page-link"><i aria-hidden="true" class="fa fa-mail-reply"></i>';
        //     $config['first_tag_open'] = '';
        //     $config['first_tag_close'] = '</span></li>';
             
        //     $config['last_link'] = '<li class="page-item"><span class="page-link"><i aria-hidden="true" class="fa fa-mail-forward"></i>';
        //     $config['last_tag_open'] = '';
        //     $config['last_tag_close'] = '</span></li>';
             
        //     $config['next_link'] = '<li class="page-item"><span class="page-link">Next';
        //     $config['next_tag_open'] = '';
        //     $config['next_tag_close'] = '</span></li>';
 
        //     $config['prev_link'] = '<li class="page-item"><span class="page-link">Previous';
        //     $config['prev_tag_open'] = '';
        //     $config['prev_tag_close'] = '</span></li>';
 
        //     $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void();">';
        //     $config['cur_tag_close'] = '</a></li>';
 
        //     $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        //     $config['num_tag_close'] = '</span></li>';

        //     $this->pagination->initialize($config);
             
        //     // build paging links
        //     $template['links'] = $this->pagination->create_links();
        // }
        // else
        // {
        //    $template['links'] = ''; 
        //    $template['list'] = '';
        // }

        // $template['page'] = "coupan/coupan_list";
        // $template['page_title'] = "Coupan list";
        // $this->load->view('template',$template);
       
    }

    public function add_coupan()
    {
        if ($_POST) 
        {
          // print_r("expression");die;
            $array = array("heading"=>$this->input->post("heading"),
                           "description"=>"1",
                           "code"=>$this->input->post("code"),
                           "is_public"=>$this->input->post("is_public"),
                           "uses_limit"=>$this->input->post("uses_limit"),
                           "discount_type"=>$this->input->post("discount_type"),
                           "amount"=>$this->input->post("amount"),
                           "discount_on"=>$this->input->post("discount_on"),
                           "expiry_date"=>$this->input->post("expiry_date"),
                           "start_date"=>$this->input->post("start_date"),
                           "status"=>$this->input->post("status"),
                           "added_on"=>date('Y-m-d H:i:s'),
                           "added_by"=>$_SESSION['id'],
                          );
            // print_r($array); die;
            $this->db->insert('coupan',$array);
            // echo $this->db->last_query(); die;
            $this->session->set_flashdata('delete','Add Successfully!!!!!!');
            redirect("speedhuntson/coupan_list");
            
        }
        else
        {
            $template['page'] = "coupan/add_coupan";
            $template['page_title'] = "Coupan";
            $this->load->view('template',$template);
        }
    }

    public function edit_coupan()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) 
        {
            $id = $this->input->post("id");
            $array = array("heading"=>$this->input->post("heading"),
                           "description"=>$this->input->post("description"),
                            "is_public"=>$this->input->post("is_public"),
                           "code"=>$this->input->post("code"),
                           "uses_limit"=>$this->input->post("uses_limit"),
                           "discount_type"=>$this->input->post("discount_type"),
                           "amount"=>$this->input->post("amount"),
                           "discount_on"=>$this->input->post("discount_on"),
                           "expiry_date"=>$this->input->post("expiry_date"),
                           "start_date"=>$this->input->post("start_date"),
                           "status"=>$this->input->post("status"),
                           );
            $create = $this->c_m->get_all_result($array,'update','coupan',array('id'=>$id));
            if ($create) 
            {
                $this->session->set_flashdata('message', array('message' => 'Update Successfully','class' => 'success'));
                redirect("speedhuntson/edit_coupan".'/'.$id);
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong please try again...','class' => 'danger'));
                redirect("speedhuntson/edit_coupan".'/'.$id);  
            }
        }
        else
        {
          $query = "SELECT * FROM `coupan` WHERE `id` = '$id'";
          $template['list'] = $this->c_m->get_all_result($query,'single_row','','');
          $template['page'] = "coupan/edit_coupan";
          $template['page_title'] = "Coupan";
          $this->load->view('template',$template);
        }
    }

    public function delete_coupan()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','coupan',array('id'=>$id));
        if ($create) {
            $this->session->set_flashdata('delete','Delete Successfully...');
            redirect("speedhuntson/coupan_list");   
        }
        else
        {
            $this->session->set_flashdata('err','Something went wrong please try again...');
            redirect("speedhuntson/coupan_list");
        }
    }


     public function all_booking_ambulance()
    {
        $uri = $this->uri->segment(3);
        $config = array();
        
        if($uri == 'all_booking')
       {
            $config["base_url"] = base_url() . "speedhuntson/all_booking_ambulance/all_booking";
            $config["total_rows"] = $this->c_m->get_count_all_booking_ambulance('ambulence_booking');
            // echo $this->db->last_query();die;
       }
       elseif ($uri == 'new_booking') 
       {
            $config["base_url"] = base_url() . "speedhuntson/all_booking_ambulance/new_booking";
            $config["total_rows"] = $this->c_m->get_count_new_booking_ambulance('ambulence_booking');   
       }

       elseif ($uri == 'cancel_booking') 
       {
            $config["base_url"] = base_url() . "speedhuntson/all_booking_ambulance/cancel_booking";
            $config["total_rows"] = $this->c_m->get_count_cancel_booking_ambulance('ambulence_booking');   
       }

       elseif ($uri == 'complete_booking') 
       {
            $config["base_url"] = base_url() . "speedhuntson/all_booking_ambulance/complete_booking";
            $config["total_rows"] = $this->c_m->get_count_complete_booking_ambulance('ambulence_booking');   
       }

        //print_r($config["total_rows"]);die;
        $config['per_page'] = 30;
        $config["uri_segment"] = 4;
        $choice = $config["total_rows"]/$config["per_page"];
       $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $template['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

         if($uri == 'all_booking')
       {
        $template['list'] = $this->c_m->get_pagination_all_booking_ambulance($config["per_page"],$template['page'],'ambulence_booking');
        $template['page_title'] = "All Ambulance Booking Details";
       }
         if($uri == 'new_booking')
       {
        $template['list'] = $this->c_m->get_pagination_new_booking_ambulance($config["per_page"],$template['page'],'ambulence_booking');
        $template['page_title'] = "New Ambulance Booking Details";
       }

      if($uri == 'cancel_booking')
           {
            $template['list'] = $this->c_m->get_pagination_cancel_booking_ambulance($config["per_page"],$template['page'],'ambulence_booking');
            $template['page_title'] = "Cancel Ambulance Booking Details";
           }
      if($uri == 'complete_booking')
           {
            $template['list'] = $this->c_m->get_pagination_complete_booking_ambulance($config["per_page"],$template['page'],'ambulence_booking');
            $template['page_title'] = "Complete Ambulance Booking Details";
           }

        $template["links"] = $this->pagination->create_links();
      //  print_r( $template["links"]);die;
        $template['page'] = "ambulance/all_booking_ambulance";
        
        $this->load->view('template',$template);
    }




    public function export_ambulance_booking()
    {
       $uri = $this->uri->segment(3);

      // print_r($uri);die;
        if($uri == 'New%20Ambulance%20Booking%20Details')
       {
       // print_r("shubham");die;
            $query = 'SELECT * FROM `ambulence_booking` where status = 0  ORDER BY `added_on` DESC';
       }
       elseif($uri == 'All%20Ambulance%20Booking%20Details')
       {
            $query = 'SELECT * FROM `ambulence_booking`  ORDER BY `added_on` DESC';
       }
       elseif($uri == 'Cancel%20Ambulance%20Booking%20Details')
       {
            $query = 'SELECT * FROM `ambulence_booking` where status IN (2,3)  ORDER BY `added_on` DESC';
       }
       elseif($uri == 'Complete%20Ambulance%20Booking%20Details')
       {
            $query = 'SELECT * FROM `ambulence_booking` where status = 1   ORDER BY `added_on` DESC';
       }

        
        $details=  $this->c_m->get_all_result_array($query,'select','','');
      // print_r($details);die;


     $data[] = array("#","Patient Name","Patient Email","Patient Mobile","From","To","Added On");
        
    $i=1;
    foreach($details as $user)
    {
        $query3 = 'SELECT * FROM `patient` WHERE `id`="'.$user['user_id'].'"';
        $patient = $this->c_m->get_all_result_array($query3,'single_row','','');

      $data[] = array(
        "#" =>$i,
        
        "patient"=>$patient['name'],
        "patient_email"=>$patient['email'],
        "patient_phone"=>$patient['phone'],
        "from_"=>$user['from_'], 
        "to_"=>$user['to_'], 
        "to_"=>$user['to_'], 
        "added_on"=>$user['added_on'], 
  
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_ambulance_booking".$uri.".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }



  //orders_for_rentals


        public function orders_for_equipment()
        {
             $uri = $this->uri->segment(3);
                $config = array();  
                if($uri == 'orders_for_rentals')
               {
                    $config["base_url"] = base_url() . "speedhuntson/orders_for_equipment/orders_for_rentals";
                    $config["total_rows"] = $this->c_m->get_count_orders_for_rentals('booking_medical_cart');
               }
               elseif ($uri == 'orders_for_purchase') 
               {
                    $config["base_url"] = base_url() . "speedhuntson/orders_for_equipment/orders_for_purchase";
                    $config["total_rows"] = $this->c_m->get_count_orders_for_purchase('booking_medical_cart');   
               // echo $this->db->last_query();die;
               }

               elseif ($uri == 'orders_for_complete') 
               {
                    $config["base_url"] = base_url() . "speedhuntson/orders_for_equipment/orders_for_complete";
                    $config["total_rows"] = $this->c_m->get_count_orders_for_complete('booking_medical_cart');   
               }

               elseif ($uri == 'orders_for_cancel') 
               {
                    $config["base_url"] = base_url() . "speedhuntson/orders_for_equipment/orders_for_cancel";
                    $config["total_rows"] = $this->c_m->get_count_orders_for_cancel('booking_medical_cart');   
               }
                $config['per_page'] = 30;
                $config["uri_segment"] = 4;
                $choice = $config["total_rows"]/$config["per_page"];
                $config["num_links"] = floor($choice);
             $config['full_tag_open'] = '<ul class="pagination">';
          $config['full_tag_close'] = '</ul>';
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          $config['cur_tag_open'] = '<li class="active"><a href="">';
          $config['cur_tag_close'] = '</a></li>';

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';
                $this->pagination->initialize($config);
                $template['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                  if($uri == 'orders_for_rentals')
                   {
                    $template['list'] = $this->c_m->get_pagination_orders_for_rentals($config["per_page"],$template['page'],'booking_medical_cart');
                    $template['page_title'] = "Orders For Rentals";
                   }
                     if($uri == 'orders_for_purchase')
                   {
                    $template['list'] = $this->c_m->get_pagination_orders_for_purchase($config["per_page"],$template['page'],'booking_medical_cart');
                    $template['page_title'] = "Orders For Purchase";
                   }

                  if($uri == 'orders_for_complete')
                       {
                        $template['list'] = $this->c_m->get_pagination_orders_for_complete($config["per_page"],$template['page'],'booking_medical_cart');
                        $template['page_title'] = "Orders For Complete";
                       }
                    if($uri == 'orders_for_cancel')
                       {
                        $template['list'] = $this->c_m->get_pagination_orders_for_cancel($config["per_page"],$template['page'],'booking_medical_cart');
                        $template['page_title'] = "Orders For Cancel";
                       }

                    $template["links"] = $this->pagination->create_links();
                    $template['page'] = "ambulance/orders_for_purchase";
                    $this->load->view('template',$template);
        } 




        public function cancel_orders_booking_id()
            {
                
                if ($_POST) {   
                $cancel_id =  $this->input->post("cancel_id");
               
                $data = array
                (
                "status"=>4,
                );
                $create = $this->c_m->get_all_result($data,'update','booking_medical_cart',array('id'=>$cancel_id));
                 
                $this->send_cancel_sms($cancel_id);
                $this->send_cancel_email($cancel_id);
               // }
                echo $this->db->last_query();       
              }
            
            }


             public function send_cancel_email($cancel_id)
    {
         $getbooking_test = $this->db->get_where('booking_medical_cart',array('id' => $cancel_id))->row();
          $order_id              = $getbooking_test->order_id;
          $order_price           = $getbooking_test->order_price;
          $quantity              = $getbooking_test->quantity;
        if($getbooking_test)
        {
            $booking_medical = $this->db->get_where('booking_medical',array('id' => $getbooking_test->order_id))->row();
            $name = $booking_medical->name;
            $email = $booking_medical->email;
            $mobile = $booking_medical->mobile;
            $address = $booking_medical->address;
            $area = $booking_medical->area;
            $pincode = $booking_medical->pincode;
            $city_state = $booking_medical->city_state;
            $trxn_status = $booking_medical->trxn_status;
            $trxn_id = $booking_medical->trxn_id;
            $booking_type = $booking_medical->booking_type;
            $product = $this->db->get_where('medical_equipment',array('id' => $getbooking_test->product_id))->row();
            $product_image = base_url('/')."uploads/medical_equipment/".$product->image ;
            $product_name = $product->name ;

            $patient = $this->db->get_where('patient',array('id' => $booking_medical->patient_id ))->row();
            $booking_patient_name = $patient->name;
            $booking_patient_email = $patient->email;
            $booking_patient_phone = $patient->phone;
        }

        $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $doctor_mobile = $settings->helpline_number; 

        $this->load->library('My_PHPMailer');
        $this->load->helper('string');
        $subject = "ANYTIMEDOC: Booking Medical Equipment Cancel.";
        $body= '<table width="100%">
   <tr style="background:#e1e9ef;">
      <td style="padding: 20px;"> <img src="http://anytimedoc.in/images/logo-1.png" tabindex="0"> </td>
   </tr>

   Hi '.$booking_patient_name.',
   <tr>
      <td height="10"> </td>
   </tr>
    
    <th><br>


   
   
   <tr>
      <td bgcolor="#fafafa" width="600px" height="112px">
         <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
               <tr>
                  <td style="padding-left:24px" width="64px"> <a style="text-decoration:none" rel="noreferrer">




                  <img src="'.$product_image.'" style="border-radius:114.3px;height:64px;width:64px" class="CToWUd"></a> </td>
                  <td style="padding-left:24px">
                     <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                           <tr>
                              <td> <span style="font-size:16px;font-weight:bold;height:24px;width:111px"> '.$product_name.'</span> </td>
                           </tr>
                           <tr>
                              <td style="font-size:14px"> </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                 
               </tr>
            </tbody>
         </table>
      </td>
   </tr>
   <tr>
      <td style="text-align:center;font-weight:normal;font-size:13px;color:#514f4f;border-bottom:1px solid #dee0e6;padding:10px 0 10px;font-family:verdana">Your Booking Medical Equipment  '.$product_name.' has been Cancelled.
.</td>
   </tr>
   <tr>
      <td>
         <table cellpadding="0" cellspacing="0" width="100%" style="margin-top:20px">
            <tbody>
               <tr>
                  <th style="color:#575758;background-color:#cbd5e6;width:60%;padding:9px;text-align:left;font-weight:normal;font-size:12px;font-family:verdana">Booking Summary</th>
                  <th style="color:#ffffff;background-color:#6f839f;width:40%;font-size:12px;font-family:verdana">Order ID: '.$order_id.'</th>
               </tr>
               <tr>
                  <td colspan="2">
                     <table cellpadding="10" cellspacing="0" border="0" width="100%">
                        <tbody>
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;width:40%;font-family:verdana">Transaction No.</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$trxn_id.'</td>
                           </tr>


                            <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Order Price</td>
                             <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Rs. '.$order_price.'</td>
                           </tr>
                            <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Quantity</td>
                             <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Rs. '.$quantity.'</td>
                           </tr>

                            <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Name</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana"><a href="mailto:'.$booking_patient_name.'" rel="noreferrer" target="_blank">sachinappslure@gmail.com</a> </td>
                           </tr>
                          
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Email ID</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana"><a href="mailto:'.$booking_patient_email.'" rel="noreferrer" target="_blank">sachinappslure@gmail.com</a> </td>
                           </tr>

                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Mobile</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$booking_patient_phone.'</td>
                           </tr>

                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Address</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$address.','.$area.','.$city_state.','.$pincode.'</td>
                           </tr>

                            
                           

                            
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
        
        

         
      </td>
   </tr>
   <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:50px">
      <tbody>
         <tr>
            <td style="background:#e1e9ef">
               <table cellpadding="0" border="0" align="center" style="margin-top:30px">
                  <tbody>
                     <tr>
                        <td>
                           <p style="text-align:right;font-size:10px;margin-top:8px;font-family:verdana">To keep a track of your health : Install Our App</p>
                        </td>
                        <td> <a href=""> <img src="https://ci4.googleusercontent.com/proxy/oUqTaSwNdxs9uzG0cuNfDDHlQdO2oFRashK2UVHuDG-cWqznC4Ipvv1BcalPa_tkthqUihoUcmsbv4fus6hZuQ=s0-d-e1-ft#https://www.healthians.com/img/googleplay.png" style="width:110px;border-radius:4px"> </a> </td>
                        <td> <a href=""> <img src="https://ci6.googleusercontent.com/proxy/3FahAwt_vJaHSw2cWnjLIM8RBcvYOBKMWRN6i8UhmscqPn3YAfwg9aCzdiiFicNWnGbPG7KZWT3FqsiTU2vK6g=s0-d-e1-ft#https://www.healthians.com/img/applestore.png" style="width:110px;border-radius:4px"> </a> </td>
                     </tr>
                     <tr>
                        <td colspan="3" style="text-align:center;font-size:10px;padding-top:10px;font-family:verdana">Any questions? <span style="color:#009aa5;font-family:verdana"> Get in touch with our customer care team at: 7724000070</span> </td>
                     </tr>
                  </tbody>
               </table>
               <table cellpadding="0" cellspacing="0" border="0" style="margin:20px auto">
                  <tbody>
                     <tr>
                        <td style="text-align:center;font-size:10px;color:#000000;border-right:1px solid #333;font-family:verdana;padding:0 10px">Mail us at: <a style="text-decoration:underline;color:#000" href="mailto:support@anytimedoc.in" rel="noreferrer" target="_blank">support@anytimedoc.in</a> </td>
                        <td style="text-align:center;font-size:10px;color:#000000;font-family:verdana;padding:0 10px">Visit us on: <a style="text-decoration:underline;color:#000;font-family:verdana" href="http://anytimedoc.in/">anytimedoc.in</a> </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="padding-top:10px">
                           <table cellpadding="0" cellspacing="10" align="center">
                              <tbody>
                                 <tr>
                                    <td style="text-align:center;font-size:10px;color:#000000;font-family:verdana">Follow us on:</td>
                                    <td> <a href=""> <img src="https://ci5.googleusercontent.com/proxy/uloeVEectKuCtdlUKDfYm5pzn_zAb6Dd_lUJ5rtzOvAzCeyq_Xrxn_w_YaI_3JAh1McKqkasxUZ9kmDd2OA=s0-d-e1-ft#https://www.healthians.com/img/facebook.png" width="20"> </a> </td>
                                    <td> <a href=""> <img src="https://ci5.googleusercontent.com/proxy/kRBOqoYyQi4TBHmteOLNgMhpkIgd2oJ12d50MqX_CdV4Q47SqaWQUJ9d5BRbEvgv736Puypc62B4IcJBzg=s0-d-e1-ft#https://www.healthians.com/img/twitter.png" width="20"> </a> </td>
                                    <td> <a href=""> <img src="https://ci5.googleusercontent.com/proxy/QZImL8EIfcKH9FZGyADaxVeQkM7F9rtEvjNyJk7qwhSmtVGGMMF28PsH_j2mlgnsYzg-_VTWuU6TFcT84Q=s0-d-e1-ft#https://www.healthians.com/img/youtube.png" width="20"> </a> </td>
                                    <td> <a href="" target="_blank"> <img src="https://ci5.googleusercontent.com/proxy/2sSKroXlxycZM5CEK33Z2aWgwX6GuvaoogHq58SD4Z09tEKnEh-6Tnbj_uBg0RSGhLuYWRxyguuokTp8ThwG=s0-d-e1-ft#https://www.healthians.com/img/instagram.png" width="20"> </a> </td>
                                    <td> <a href="" target="_blank"> <img src="https://ci5.googleusercontent.com/proxy/KtS9k6YF8sSjsbEVubeX8y7csBhp9nq3hjsDqTTGSVyd3aB-eYsd24gV0w5DqoGVlhu069CkWjCmN3H_Ygo=s0-d-e1-ft#https://www.healthians.com/img/linkedin.png" width="20"> </a> </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
      </tbody>
   </table>
</table>';
        $mail = new PHPMailer;
        $mail->isSMTP();  
        $mail->Host = 'smtp.gmail.com'; //'md-70.webhostbox.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'emailsendtestappslure@gmail.com';//'form41app@gmail.com'; //'mail@appsgenic.com';
                $mail->Password = 'appslure@321';//'appslure123'; // '@appsgenic123@';
        $mail->SMTPSecure = 'tls';
        $mail->Port =587;
        $mail->From = 'emailsendtestappslure@gmail.com';
        $mail->FromName = 'ANYTIMEDOC Booking Medical Equipment Cancel';
        $mail->addAddress($email, 'ANYTIMEDOC');
                $mail->WordWrap = 500;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        if(!$mail->send())
        {
            return false;
        }
        else
        {
            return true;
        }    
    }

public function send_cancel_sms($cancel_id)
    {

      $getbooking_test = $this->db->get_where('booking_medical_cart',array('id' => $cancel_id))->row();
         $delivery_time = $getbooking_test->delivery_time;
         $delivery_date = $getbooking_test->delivery_date;
      
        if($getbooking_test)
        {
            
            $booking_medical = $this->db->get_where('booking_medical',array('id' => $getbooking_test->order_id))->row();
          //  print_r($booking_medical);die;
            $name = $booking_medical->name;
            $email = $booking_medical->email;
            $mobile = $booking_medical->mobile;
            $booking_type = $booking_medical->booking_type;

            $patient = $this->db->get_where('patient',array('id' => $booking_medical->patient_id ))->row();
            $booking_patient_name = $patient->name;
            $booking_patient_email = $patient->email;
            $booking_patient_phone = $patient->phone;
        }
        $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $doctor_mobile = $settings->helpline_number;       
        // $booking_date = date("jS F Y", strtotime($book_date));
        if(!empty($booking_patient_phone))
        {
            $msgtopatient= '';
            $msgtopatient.="ANYTIMEDOC-# msg send cancel";
            $msg1 = urlencode($msgtopatient);
            $this->send_to_patient_msg($booking_patient_phone,$msg1);
        }

        

    }





             public function transaction_details_orders()
            {
                $id = trim($this->input->post('id'));
                $transaction_data = $this->db->where('id',$id)->get('booking_medical')->result_array();
                echo json_encode($transaction_data);
            }


        public function notification_sound()
        {
          $user_notification_count1= "Select count(*) as `tot` from `user_notification` Where `type` NOT IN('admin','admin_all') and `read` != 1";
          $notification_data_count1 = $this->db->query($user_notification_count1)->row();
            $n_count = $notification_data_count1->tot;

          // print_r($count);
           // $array = array(
           //          "count"=>$count,
           //        );
         // $this->db->insert('notification_count',$array);
           $query =  "select * from notification_count";
           $query_count = $this->db->query($query)->row();
           // print_r($query_count->count);die;
           if ($query_count->count == $n_count ) 
              {
               ?>
               <audio controls autoplay hidden='true'>
               <source src='http://www.w3schools.com/html/horse.ogg' type='audio/ogg'>
              </audio>
               <?php
              }

               elseif ($query_count->count > $n_count ) 
              {
               ?>
               <audio controls autoplay hidden='true'>
               <source src='http://www.w3schools.com/html/horse.ogg' type='audio/ogg'>
              </audio>
               <?php
              }

               elseif ($query_count->count < $n_count ) 
              {
               
               $update = "UPDATE notification_count SET count = '".$n_count."'" ;
            
              }
        }


         public function notification_sound_play()
        {
          echo base_url('uploads/eventually.ogg');
            // echo "<audio controls autoplay hidden='true'>
            //   <source src='http://www.w3schools.com/html/horse.ogg' type='audio/ogg'>
            // </audio>";
          
        }



    public function notifiction_details()
    {
        $user_notification= "SELECT *  FROM admin_notification ORDER BY id DESC limit 250";
        $notification_data = $this->db->query($user_notification)->result();
   
        // $this->notification_sound();
     
// `status` IN(2, 3) AND `booking_type` = 1
        $user_notification_count= "Select count(*) as `tot` from `admin_notification` Where `type` NOT IN('admin','admin_all') and `read` != 1";
        // print_r($user_notification_count);die;
        $notification_data_count = $this->db->query($user_notification_count)->row();
        $count = $notification_data_count->tot;


        // Logic start
        $query_for_audio =  "select * from notification_count where id='1'";
        $query_countfor_audio = $this->db->query($query_for_audio)->row();
        if ($query_countfor_audio->count < $count) 
        {
            echo "<audio controls autoplay hidden='true'>
              <source src='".base_url('uploads/eventually.ogg')."' type='audio/ogg'>
            </audio>";
          $this->db->query("UPDATE `notification_count` SET `count`='$count'");
        }
        // End Logic




        echo "<input type='hidden' value='".$count."' id='notifycount'>";
        
        foreach($notification_data as $n)
        {
          $collor = "";
          if ($n->read == 1) 
          {
            $collor = "background-color: green ";
            $bolds = "color: black";
          }
          else 
          {
            $collor = "background-color: #red ";
            $bolds = "color:#888888";
          }
           $doctor_id = $n->user_id;
             // $doctor = $this->db->where('id',$doctor_id)->get('doctor')->row();

           $book_date = $n->added_on;
            $booking_t = $n->added_on;
            $booking_date = date("jS F Y", strtotime($book_date));
            $booking_time = date("H:i:s A", strtotime($booking_t));

          switch($n->type)
          {

            case 'puja_booking':
            $data12 = base_url('online_consultation/online_booking/all_booking');
            echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Online Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;
            case 'varshfal_booking':
            $data12 = base_url('pdf_booking/all_booking');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Varshafhal Pdf booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

             case 'life_prediction':
            $data12 = base_url('life_prediction/prediction/all_booking');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Life Prediction Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

            case 'package':
            $data12 = base_url('class_package/purchase_history');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Class Package Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

            case 'horoscope_matching':
            $data12 = base_url('Horoscope_matching/matching/all_booking');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Match Making Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

            case 'in_person':
            $data12 = base_url('inperson_ctrl/inperson/all_booking');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>In Person Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

            case 'gems':
            $data12 = base_url('Gems_booking_ctrl/booking/all_booking');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Gems Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

            case 'medical_booking':
            $data12 = base_url('medical_module/medical/all_booking');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Medical Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

             case 'financial_booking':
            $data12 = base_url('financial_module/financial/all_booking');
             echo "<li ><a href='".$data12."' onclick='return update_notifiction_id(".$n->id.")'><div class='pull-left noti' style = '".$collor."'>Financial Booking</div><h4> ".$n->title." <small><i class=''></i> <b> ".$booking_date." ".$booking_time." </b></small></h4><p style = '".$bolds."'>".$n->notification."</p></a></li>";
            break;

           
            

          default:
              // echo "<li><a href='".base_url('Patient_details/notification')."'>Show all Notification</a></li>";
              break;
         
          }
        }

        echo "<li><a href='".base_url('User_details/notification')."'><b>Show all Notification</b></a></li>";
  
    }



    public function lab_notifiction_details()
    {
       
        $user_lab_count= "Select count(*) as `tot` from `booking_test` Where  `notification_to_admin` = 1";
        // print_r($user_notification_count);die;
        $lab_data_count = $this->db->query($user_lab_count)->row();
        $count = $lab_data_count->tot;

        echo "<input type='hidden' value='".$count."' id='labs_count'>";
        
        echo "<li><a href='".base_url('Patient_details/notification')."'><b>Show all Notification</b></a></li>";
  
    }



    public function update_notifiction_details()
    {
      // print_r($_POST);die; 
      if ($_POST) {   
        $id =  $this->input->post("id");
        $data = array
        (
          "read"=>1,
        );
        $update = $this->c_m->get_all_result($data,'update','admin_notification',array('id'=>$id));
        $query_for_audio =  "select * from notification_count where id='1'";
        $query_countfor_audio = $this->db->query($query_for_audio)->row();
         $read_count = $query_countfor_audio->count;
         $c = $read_count - 1;

         $this->db->query("UPDATE `notification_count` SET `count`='$c'");

      }
    }






        public function refund_data()
        {
              if ($_POST) {
                $booking_id =  $this->input->post("booking_id");   
                $refund_trxn_id =  $this->input->post("refund_trxn_id");
                $refund_date =  $this->input->post("refund_date");
                $refund_amount =  $this->input->post("refund_amount");
                $refund_by =  $_SESSION['id'];
                $data = array
                (
                "refund_trxn_id"=>$refund_trxn_id,
                "refund_date"=>$refund_date,
                "refund_amount"=>$refund_amount,
                "refund_by"=>$refund_by,
                "refund_status"=>1,
                );
                $create = $this->c_m->get_all_result($data,'update','booking_medical_cart',array('id'=>$booking_id));
               if ($create) {
                    $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success')); 
                    //redirect("speedhuntson/orders_for_equipment");  
                     redirect($this->agent->referrer());
                }
              }
        }


          public function delivery_date_time()
        {
          if ($_POST) {
            $booking_id =  $this->input->post("booking_id");   
            $delivery_date =  $this->input->post("delivery_date");
            $delivery_time =  $this->input->post("delivery_time");
            
            $data = array
            (
            "delivery_time"=>$delivery_time,
            "delivery_date"=>$delivery_date,
             "status"=>1,
            );
            $create = $this->c_m->get_all_result($data,'update','booking_medical_cart',array('id'=>$booking_id));
           if ($create) {

                $this->send_sms($booking_id);
                $this->send_email($booking_id);
                $this->session->set_flashdata('message', array('message' => 'Update Successfully','class' => 'success')); 
                //redirect("speedhuntson/orders_for_equipment");  
                redirect($this->agent->referrer());
            }
          }
        }

        public function expire_date_time()
        {
          if ($_POST) {
            $booking_id =  $this->input->post("book_id");   
            $delivery_date =  $this->input->post("delivery_date");
            $delivery_time =  $this->input->post("delivery_time");
            
            $data = array
            (
            "delivery_time"=>$delivery_time,
            "delivery_date"=>$delivery_date,
             "status"=>6,
            );
            $create = $this->c_m->get_all_result($data,'update','booking_medical_cart',array('id'=>$booking_id));
           if ($create) {

                $this->send_sms($booking_id);
                $this->send_email($booking_id);
                $this->session->set_flashdata('message', array('message' => 'Update Successfully','class' => 'success')); 
                //redirect("speedhuntson/orders_for_equipment");  
                redirect($this->agent->referrer());
            }
          }
        }



         public function send_email($booking_id)
    {
        $getbooking_test = $this->db->get_where('booking_medical_cart',array('id' => $booking_id))->row();
       // print_r($getbooking_test);die;
         $order_id              = $getbooking_test->order_id;
         $delivery_time         = $getbooking_test->delivery_time;
         $delivery_date         = $getbooking_test->delivery_date;
         $quantity         = $getbooking_test->quantity;

          $delivery_dates = date("jS F Y", strtotime($delivery_date));


         $start_date            = $getbooking_test->start_date;
           $start_dates = date("jS F Y", strtotime($start_date));
         $end_date              = $getbooking_test->end_date;
           $end_dates = date("jS F Y", strtotime($end_date));

         $order_price           = $getbooking_test->order_price;
         $for_month_week        = $getbooking_test->for_month_week;
         $booking_ids           = $getbooking_test->id;


         $equipment_type        = $getbooking_test->equipment_type;
         if ($equipment_type == "Rental") 
         {
             $table = '<tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Start Date</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$start_dates.'</td>
                           </tr>
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">End Date</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$end_dates.'</td>
                           </tr>
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Equipment Type</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$equipment_type.'</td>
                           </tr>
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Rent For </td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$for_month_week.'</td>
                           </tr>
                          ';
         }
         elseif($equipment_type == "Purchase")
         {
              $table = '
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Equipment Type</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$equipment_type.'</td>
                           </tr>
                           ';
         }

         



        if($getbooking_test)
        {
            
            $booking_medical = $this->db->get_where('booking_medical',array('id' => $getbooking_test->order_id))->row();
            $name = $booking_medical->name;
            $email = $booking_medical->email;
            $mobile = $booking_medical->mobile;
            $address = $booking_medical->address;
            $area = $booking_medical->area;
            $pincode = $booking_medical->pincode;
            $city_state = $booking_medical->city_state;
            $trxn_status = $booking_medical->trxn_status;
            $trxn_id = $booking_medical->trxn_id;
            $booking_type = $booking_medical->booking_type;

            $product = $this->db->get_where('medical_equipment',array('id' => $getbooking_test->product_id))->row();
            $product_image = base_url('/')."uploads/medical_equipment/".$product->image ;
            $product_name = $product->name ;

            $patient = $this->db->get_where('patient',array('id' => $booking_medical->patient_id ))->row();
            $booking_patient_name = $patient->name;
            $booking_patient_email = $patient->email;
            $booking_patient_phone = $patient->phone;


          //print_r($email);die;
        }

        $this->load->library('My_PHPMailer');
        $this->load->helper('string');
        $subject = "ANYTIMEDOC: Booking Medical Equipment.";
    $body= '<table width="100%">
   <tr style="background:#e1e9ef;">
      <td style="padding: 20px;"> <img src="http://anytimedoc.in/images/logo-1.png" tabindex="0"> </td>
   </tr>
     Hi '.$booking_patient_name.',
   <tr>
      <td height="10"> </td>
   </tr>
   
   
   <tr>
      <td bgcolor="#fafafa" width="600px" height="112px">
         <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
               <tr>
                  <td style="padding-left:24px" width="64px"> <a style="text-decoration:none" rel="noreferrer">




                  <img src="'.$product_image.'" style="border-radius:114.3px;height:64px;width:64px" class="CToWUd"></a> </td>
                  <td style="padding-left:24px">
                     <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                           <tr>
                              <td> <span style="font-size:16px;font-weight:bold;height:24px;width:111px"> '.$product_name.'</span> </td>
                           </tr>
                           <tr>
                              <td style="font-size:14px"> </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
                 
               </tr>
            </tbody>
         </table>
      </td>
   </tr>
   <tr>
      <td style="text-align:center;font-weight:normal;font-size:13px;color:#514f4f;border-bottom:1px solid #dee0e6;padding:10px 0 10px;font-family:verdana">Here is a summary of your booking medical equipment.</td>
   </tr>
   <tr>
      <td>
         <table cellpadding="0" cellspacing="0" width="100%" style="margin-top:20px">
            <tbody>
               <tr>
                  <th style="color:#575758;background-color:#cbd5e6;width:60%;padding:9px;text-align:left;font-weight:normal;font-size:12px;font-family:verdana">Booking Summary</th>
                  <th style="color:#ffffff;background-color:#6f839f;width:40%;font-size:12px;font-family:verdana">Order ID: '.$order_id.'</th>
               </tr>
               <tr>
                  <td colspan="2">
                     <table cellpadding="10" cellspacing="0" border="0" width="100%">
                        <tbody>
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;width:40%;font-family:verdana">Transaction No.</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$trxn_id.'</td>
                           </tr>
                            <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Name</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana"><a href="mailto:'.$booking_patient_name.'" rel="noreferrer" target="_blank">sachinappslure@gmail.com</a> </td>
                           </tr>

                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Order Price</td>
                             <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Rs. '.$order_price.'</td>
                           </tr>

                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Quantity</td>
                             <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Rs. '.$quantity.'</td>
                           </tr>



                          
                           '.$table.'
                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Email ID</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana"><a href="mailto:'.$booking_patient_email.'" rel="noreferrer" target="_blank">sachinappslure@gmail.com</a> </td>
                           </tr>

                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Mobile</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$booking_patient_phone.'</td>
                           </tr>

                           <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Address</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$address.','.$area.','.$city_state.','.$pincode.'</td>
                           </tr>

                            <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Delivery Date</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$delivery_dates.'</td>
                           </tr>

                            <tr>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">Delivery Time</td>
                              <td style="border-bottom:1px solid #dee0e6;font-size:12px;font-family:verdana">'.$delivery_time.'</td>
                           </tr>

                           

                            
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
        
        

         
      </td>
   </tr>
   <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:50px">
      <tbody>
         <tr>
            <td style="background:#e1e9ef">
               <table cellpadding="0" border="0" align="center" style="margin-top:30px">
                  <tbody>
                     <tr>
                        <td>
                           <p style="text-align:right;font-size:10px;margin-top:8px;font-family:verdana">To keep a track of your health : Install Our App</p>
                        </td>
                        <td> <a href=""> <img src="https://ci4.googleusercontent.com/proxy/oUqTaSwNdxs9uzG0cuNfDDHlQdO2oFRashK2UVHuDG-cWqznC4Ipvv1BcalPa_tkthqUihoUcmsbv4fus6hZuQ=s0-d-e1-ft#https://www.healthians.com/img/googleplay.png" style="width:110px;border-radius:4px"> </a> </td>
                        <td> <a href=""> <img src="https://ci6.googleusercontent.com/proxy/3FahAwt_vJaHSw2cWnjLIM8RBcvYOBKMWRN6i8UhmscqPn3YAfwg9aCzdiiFicNWnGbPG7KZWT3FqsiTU2vK6g=s0-d-e1-ft#https://www.healthians.com/img/applestore.png" style="width:110px;border-radius:4px"> </a> </td>
                     </tr>
                     <tr>
                        <td colspan="3" style="text-align:center;font-size:10px;padding-top:10px;font-family:verdana">Any questions? <span style="color:#009aa5;font-family:verdana"> Get in touch with our customer care team at: 7724000070</span> </td>
                     </tr>
                  </tbody>
               </table>
               <table cellpadding="0" cellspacing="0" border="0" style="margin:20px auto">
                  <tbody>
                     <tr>
                        <td style="text-align:center;font-size:10px;color:#000000;border-right:1px solid #333;font-family:verdana;padding:0 10px">Mail us at: <a style="text-decoration:underline;color:#000" href="mailto:support@anytimedoc.in" rel="noreferrer" target="_blank">support@anytimedoc.in</a> </td>
                        <td style="text-align:center;font-size:10px;color:#000000;font-family:verdana;padding:0 10px">Visit us on: <a style="text-decoration:underline;color:#000;font-family:verdana" href="http://anytimedoc.in/">anytimedoc.in</a> </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="padding-top:10px">
                           <table cellpadding="0" cellspacing="10" align="center">
                              <tbody>
                                 <tr>
                                    <td style="text-align:center;font-size:10px;color:#000000;font-family:verdana">Follow us on:</td>
                                    <td> <a href=""> <img src="https://ci5.googleusercontent.com/proxy/uloeVEectKuCtdlUKDfYm5pzn_zAb6Dd_lUJ5rtzOvAzCeyq_Xrxn_w_YaI_3JAh1McKqkasxUZ9kmDd2OA=s0-d-e1-ft#https://www.healthians.com/img/facebook.png" width="20"> </a> </td>
                                    <td> <a href=""> <img src="https://ci5.googleusercontent.com/proxy/kRBOqoYyQi4TBHmteOLNgMhpkIgd2oJ12d50MqX_CdV4Q47SqaWQUJ9d5BRbEvgv736Puypc62B4IcJBzg=s0-d-e1-ft#https://www.healthians.com/img/twitter.png" width="20"> </a> </td>
                                    <td> <a href=""> <img src="https://ci5.googleusercontent.com/proxy/QZImL8EIfcKH9FZGyADaxVeQkM7F9rtEvjNyJk7qwhSmtVGGMMF28PsH_j2mlgnsYzg-_VTWuU6TFcT84Q=s0-d-e1-ft#https://www.healthians.com/img/youtube.png" width="20"> </a> </td>
                                    <td> <a href="" target="_blank"> <img src="https://ci5.googleusercontent.com/proxy/2sSKroXlxycZM5CEK33Z2aWgwX6GuvaoogHq58SD4Z09tEKnEh-6Tnbj_uBg0RSGhLuYWRxyguuokTp8ThwG=s0-d-e1-ft#https://www.healthians.com/img/instagram.png" width="20"> </a> </td>
                                    <td> <a href="" target="_blank"> <img src="https://ci5.googleusercontent.com/proxy/KtS9k6YF8sSjsbEVubeX8y7csBhp9nq3hjsDqTTGSVyd3aB-eYsd24gV0w5DqoGVlhu069CkWjCmN3H_Ygo=s0-d-e1-ft#https://www.healthians.com/img/linkedin.png" width="20"> </a> </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
      </tbody>
   </table>
</table>';
        $mail = new PHPMailer;
        $mail->isSMTP();  
        $mail->Host = 'smtp.gmail.com'; //'md-70.webhostbox.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'emailsendtestappslure@gmail.com';//'form41app@gmail.com'; //'mail@appsgenic.com';
                $mail->Password = 'appslure@321';//'appslure123'; // '@appsgenic123@';
        $mail->SMTPSecure = 'tls';
        $mail->Port =587;
        $mail->From = 'emailsendtestappslure@gmail.com';
        $mail->FromName = 'ANYTIMEDOC Booking Medical Report';
        $mail->addAddress($booking_patient_email, 'ANYTIMEDOC');
                $mail->WordWrap = 500;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        if(!$mail->send())
        {
            return false;
        }
        else
        {
            return true;
        }    
    }



        public function send_sms($booking_id)
    {


      $getbooking_test = $this->db->get_where('booking_medical_cart',array('id' => $booking_id))->row();
       // print_r($getbooking_test);die;
         $delivery_time = $getbooking_test->delivery_time;
         $delivery_date = $getbooking_test->delivery_date;
        // $book_date = $getbooking_test->booking_date;
        // $booking_time = $getbooking_test->booking_time;
        // $booking_date = date("jS F Y", strtotime($book_date));
        if($getbooking_test)
        {
            
            $booking_medical = $this->db->get_where('booking_medical',array('id' => $getbooking_test->order_id))->row();
          //  print_r($booking_medical);die;
            $name = $booking_medical->name;
            $email = $booking_medical->email;
            $mobile = $booking_medical->mobile;
            $booking_type = $booking_medical->booking_type;

            $patient = $this->db->get_where('patient',array('id' => $booking_medical->patient_id ))->row();
            $booking_patient_name = $patient->name;
            $booking_patient_email = $patient->email;
            $booking_patient_phone = $patient->phone;
        }
        $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $doctor_mobile = $settings->helpline_number;       
        // $booking_date = date("jS F Y", strtotime($book_date));
        if(!empty($booking_patient_phone))
        {
           // print_r($mobile);die;
           // $num ="827941703";
            $msgtopatient= '';
            $msgtopatient.="ANYTIMEDOC-# msg send";
            $msg1 = urlencode($msgtopatient);
            $this->send_to_patient_msg($booking_patient_phone,$msg1);
        }

        

    }





public function medical_equipment_status()

    {
        $data1 = array(
            "status" => '0'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_medical_equipment_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Medical Equipment Successfully Disabled',
            'class' => 'warning'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('Doctordetail_ctrl/view_doctordetails'));
    }
    public function medical_equipment_active()

    {
        $data1 = array(
            "status" => '1'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_medical_equipment_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Medical Equipment Successfully Enabled',
            'class' => 'success'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('Doctordetail_ctrl/view_doctordetails'));
    }


     public function send_to_patient_msg($mobile,$message_patient)
    {
        $authKey = "290852AOOLo80J5d5fabd8";
        $senderId = "ANYTIM";
        $message = $message_patient;
        $route = "default";
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobile,
            'message' => $message_patient,
            'sender' => $senderId,
            'route' => $route
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?mobiles=$mobile&authkey=$authKey&route=4&sender=ANYTIM&message=$message_patient&country=91",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
    }



    public function ambulance_status()

    {
        $data1 = array(
            "status" => '0'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_ambulance_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Ambulance Successfully Disabled',
            'class' => 'warning'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('ambulancedetail_ctrl/view_ambulancedetails'));
    }
    public function ambulance_active()

    {
        $data1 = array(
            "status" => '1'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_ambulance_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Ambulance Successfully Enabled',
            'class' => 'success'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('Doctordetail_ctrl/view_doctordetails'));
    }


     public function ambulance_category_status()

    {
        $data1 = array(
            "status" => '0'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_ambulance_category_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Ambulance Successfully Disabled',
            'class' => 'warning'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('ambulancedetail_ctrl/view_ambulancedetails'));
    }
    public function ambulance_category_active()

    {
        $data1 = array(
            "status" => '1'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_ambulance_category_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Ambulance Successfully Enabled',
            'class' => 'success'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('Doctordetail_ctrl/view_doctordetails'));
    }


    
    public function common_service_status()

    {
        $data1 = array(
            "status" => '0'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_common_service_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Common Service Successfully Disabled',
            'class' => 'warning'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('Common Servicedetail_ctrl/view_Common Servicedetails'));
    }
    public function common_service_active()

    {
        $data1 = array(
            "status" => '1'
        );
        $id = $this->uri->segment(3);
        $s = $this->c_m->update_common_service_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Common Service Successfully Enabled',
            'class' => 'success'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('Doctordetail_ctrl/view_doctordetails'));
    }

    public function wallet_conf_list($location_id=0)
    {
        if($_POST){
            if(isset($_POST['save_category'])){
                $d['type']=trim($_POST['type']);
                $d['min_range']=trim($_POST['min_range']);
                $d['max_range']=trim($_POST['max_range']);
                $d['value']=trim($_POST['value']);
                $d['added_by'] = $this->session->userdata('id');
                $d['status'] = $_POST['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                if ($d['status'] == 1) 
                {
                    $this->db->query("UPDATE `wallet_configuration` SET `status` = 0 WHERE `status`<>2");
                }
                $this->db->insert('wallet_configuration',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($_POST['update_category'])) {
                $id = $_POST['id'];
                $d['type']=trim($_POST['type']);
                $d['min_range']=trim($_POST['min_range']);
                $d['max_range']=trim($_POST['max_range']);
                $d['value']=trim($_POST['value']);
                $d['status'] = $_POST['status'];
                if ($d['status'] == 1) 
                {
                    $this->db->query("UPDATE `wallet_configuration` SET `status` = 0 WHERE `status`<>2");
                }
                $this->db->where('id',$id);
                $this->db->update('wallet_configuration',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['results'] = $this->db->get_where("wallet_configuration",array("status<>"=>2))->result();
        $template['page_title'] = 'Wallet Configuration';
        $template['page'] = "sd/edit_master/wallet_conf_list";
        $this->load->view('template',$template);
    }
    public function delete_wallet_conf($location_id)
    {
        if(empty($location_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$location_id);
        $this->db->update('wallet_configuration',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }



    




}