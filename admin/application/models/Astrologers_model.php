<?php 
class Astrologers_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}



 	public function login($username,$password) 
{
  $this->db->select('*');
  $this->db->from('astrologers');

  $this->db->where('email',$username);
  // $this->db->where("(username = '$username' OR email = '$username')");
  $this->db->where('password',$password);
  $query = $this->db->get();
  //echo $this->db->last_query(); die;
  if ($query->num_rows() == 1) {
          $row  = $query->row();
          if($row->status!='1'){
           return '2';//Deactive User
          }
          else{
          $data = array(
                    'astrologer_id'       =>  $row->id, 
                    'username'        =>  $row->name, 
                    'password'        =>  $row->password,
                    'status'          =>  $row->status,
          ); 
          
          $this->session->set_userdata($data);
          return '1';//True Creditional
        }
      }
      else{
          return '3';//Invalid Creditional
       }
 }


   public function message($message, $status) {
    if ($status == 'warning') {
        return $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-no-border alert-close alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'. $message .'</div>');
    }
    if ($status == 'success') {

       return $this->session->set_flashdata('msg', '<div class="alert bounce alert-animate alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <b>Success! </b>'. $message .'</div>');
    }
    if ($status == 'error') { 
            
        return $this->session->set_flashdata('msg', '<div class="alert bounce alert-animate alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <b>Error! </b>'. $message .'</div>');
    }
  }


    function get_single_astrologer($id){
        $this->db->select('*');
        $this->db->from('astrologers');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    


    public function updatepassword($email, $code)
    {
      $data['password'] = $code;
      $this->db->where("email", $email);
      $this->db->update("lab", $data);
      return $this->db->affected_rows();
    }





 function update_astrologers_passwords($data, $id) {
                $this->db->select("count(*) as count");
                $this->db->where("password",md5($data['password']));
                $this->db->where("id",$id);
                $this->db->from("astrologers");
                $count = $this->db->get()->row();
                    //var_dump($count);
                if($count->count == 0) {
                    return "notexist";
                }
                else {                  
                    $update_data['password'] = md5($data['n_password']);
                    $this->db->where('id', $id);
                    $result = $this->db->update('astrologers', $update_data); 
               
                    if($result) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
 	




 
	 public function get_row($tbl,$where)
    {
        $row = $this->db->get_where($tbl,$where);
        if(count($row->result()>0))
        {
            return $row->row();
        }
        return false;

    } 

    public function table_data_delete($table , $where){ 
		 $this->db->where($where);
		 $result = $this->db->delete($table);
		 if($result){
			return True; 
		 }
		 else {
			 return False;
		 }
	 }

	  public function get_all_result_array($query,$query_type,$table,$condition)
    {

    if ($query_type == 'select') {
    return $this->db->query($query)->result_array();  
    }
    elseif ($query_type == 'delete') {
    $this->db->query($query);
    return true;
    }
    elseif ($query_type == 'insert') {
    $query = $this->db->insert($table,$query);
    return $this->db->insert_id();
    }
    elseif ($query_type == 'single_row') {
    return $this->db->query($query)->row_array();
    }
    elseif ($query_type == 'update') {
    $query2 = $this->db->where($condition);
    $this->db->update($table,$query);
    return TRUE;
    }
    else
    {
    return false;
    }

    }

    public function get_all_result($query,$query_type,$table,$condition)
	{
		
		if ($query_type == 'select') {
			return $this->db->query($query)->result();	
		}
		elseif ($query_type == 'delete') {
			$this->db->query($query);
			return true;
		}
		elseif ($query_type == 'insert') {
			$query = $this->db->insert($table,$query);
			return $this->db->insert_id();
		}
		elseif ($query_type == 'single_row') {
			return $this->db->query($query)->row();
		}
		elseif ($query_type == 'update') {
			$query2 = $this->db->where($condition);
			$this->db->update($table,$query);
			return true;
		}
		else
		{
			return false;
		}
		
	}



    public function send_sms($mobile,$sms_message)
{
// $curl = curl_init();
// $R = "http://sms.ssdindia.com/api/sendhttp.php?authkey=10191AqzE6VoU6ag564ffab1&mobiles=91".$mobile."&message=".$sms_message."&sender=PICASO&route=4&country=0";
// curl_setopt_array($curl, array(
//   CURLOPT_URL => $R
//   ,
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_POSTFIELDS => "",
//   CURLOPT_SSL_VERIFYHOST => 0,
//   CURLOPT_SSL_VERIFYPEER => 0,
// ));
// $response = curl_exec($curl);
// $err = curl_error($curl);
// curl_close($curl);
// return true;

//Your authentication key
$authKey = "10191AqzE6VoU6ag564ffab1";

//Multiple mobiles numbers separated by comma
$mobileNumber = '91'.$mobile;

//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "PICASO";

//Your message to send, Add URL encoding here.
$message = urlencode($sms_message);

//Define route
$route = "default";
//Prepare you post parameters
$postData = array(
   'authkey' => $authKey,
   'mobiles' => $mobileNumber,
   'message' => $message,
   'sender' => $senderId,
   'route' => $route
);

//API URL
$url="http://sms.ssdindia.com/api/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
   CURLOPT_URL => $url,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_POST => true,
   CURLOPT_POSTFIELDS => $postData
   //,CURLOPT_FOLLOWLOCATION => true
));


//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

//Print error if any
// if(curl_errno($ch))
// {
//     echo 'error:' . curl_error($ch);
// }

// curl_close($ch);

// echo $output;
return true;
}


public function send_ios_notification($device_token,$message_text,$type)
    {
$payload='{"aps":{"alert":"'.$message_text.'","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"'.$type.'"}';
        //include_once("Cow.pem");
        $ctx=stream_context_create();
        stream_context_set_option($ctx,'ssl','local_cert','/var/www/html/picasoid/notification_key/api.pem');
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

    public function sendMessageThroughFCM($registatoin_ids, $message)
{
    $k = 'AAAAlzqnLIw:APA91bGHHrKabusAQDnlaXoTT095ynYXsQQ8uPhcO91mYHR-sDHHeUHqVxJWpJ4F4KJTXGC-27VHt2aE3kUiS3od8V87me7lkNf7PDhYqNdQMUesS0naYNsODH8kMySG7uk8f3p3C_k9';
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






}