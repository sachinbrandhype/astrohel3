<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google; 
class Api_Model extends CI_Model {	
	public function _consruct(){
		parent::_construct();
 	}

 	public function global_multiple_query($table,$condition,$what)
 	{
 		if ($what == 'row()') 
 		{
 			return $this->db->get_where($table,$condition)->row();
 		}
 		else
 		{
 			return $this->db->get_where($table,$condition)->result();
 		}
 		
 	}


 	public function Signin_astrologer($data)
	{
		$password = $data['password'];
		// $password1 = $data['password'];
		if (strpos($data['phone'], '@') !== false) 
		{
			$query_ = $this->db->query("SELECT * FROM `astrologers` WHERE `email`='".$data['phone']."' AND `status`='1' AND approved = 1");
		}
		else
		{
			$query_ = $this->db->query("SELECT * FROM `astrologers` WHERE `phone`='".$data['phone']."' AND `status`='1' AND approved = 1");
		}
		if ($query_->num_rows() > 0) 
		{
			$query = $query_->row();
			if ($query->random_password==$password) 
			{
				if (!empty($query->image)) 
				{
					$img = base_url('/uploads/astrologers').'/'.$query->image;
				}
				else
				{
					$img = base_url('/uploads/astrologers/').'/'.'default.png';
				}

				$device_id = $data['device_id'];
				$device_token = $data['device_token'];
				$device_type = $data['device_type'];
				
				$this->db->query("UPDATE `astrologers` SET `device_id`='$device_id',`device_token`='$device_token',`device_type`='$device_type' WHERE `id` = '$query->id'");
				
				$user_details = array( "status"=>$query->status,
										"user_id"=>$query->id,
										"email"=>$query->email,
										"name"=>$query->name,
										"mobile"=>$query->phone,
										"image"=>$img,
										);
				$response = array("status" => true,'signal'=>1, "user_detail"=>$user_details);
			}
			else
			{
				$response = array("status"=>false,'signal'=>2,"msg"=>"Password is Incorrect");
			}
			
		}
		else
		{
			$response = array("status"=>false,'signal'=>3,"msg"=>"username and password incorrect");
		}
			return $response;
	}

	function signup_astrologer($data,$password,$password2){
		$info = array( 'name'=>$data['name'],
					    'email'=>$data['email'],
					   'password'=>$password,
					   'phone'=>$data['mobile'],
					   'status'=>1,
					   'image'=>'default.png',
					   'added_on'=>date('Y-m-d H:i:sa'),
					   'device_id' => $data['device_id'],
					   'device_token' => $data['device_token'],
					   'device_type' => $data['device_type'],
					   'random_password'=>$password2,
					   'gender'=>$data['gender'],
					   'dob'=>$data['dob'],
					   'address'=>$data['address'],
					   'state'=>$data['state'],
					   'city'=>$data['city'],
					   'pincode'=>$data['pincode'],
					   'added_on'=>date('Y-m-d H:i:s'),
					   'bio'=>'',
					   'registartion_from'=>'app'
					   
					);		
		if($this->db->insert('astrologers',$info)){
			$user_id = $this->db->insert_id();
			return $user_id;
		}
		
	}

	public function otp_send_astrologer($data)
	{

		$settings = $this->global_multiple_query('settings',array('id'=>1),'row()');
		// $subject = "SHAKTIPEETH OTP Verification";
		// $mail_message= "Hello,<br><br>Please enter the OTP ".$data['otp']." to verify your account.<br><br>For any Help Assistance and Support you can reach out to us on our helpline number ".$settings->helpline_number."<br>Looking forward to Care for your Mind and Body.<br><br>Regards<br>SHAKTIPEETH SUPPORT";
        // $this->check_curl($data['email'],$subject,$mail_message,'OTP VERIFICATION');
		$response = array("status"=>true,"msg"=>"otp send successfully");
		$this->load->model('ApiCommonNotify');
		$sms_message = 'Your verification code is '.$data['otp'].'.';
		$this->ApiCommonNotify->send_sms($data['mobile'],$sms_message,'+91');
		return $response;
	}

	public function otp_send_astrologer_register($data)
	{
		$response = array("status"=>false,"msg"=>"otp not send!");
		if (strpos($data['email_phone'], '@') !== false) 
		{
			$query_ = $this->db->query("SELECT * FROM `astrologers` WHERE `email`='".$data['email_phone']."' AND `status`='1'");
		}
		else
		{
			$query_ = $this->db->query("SELECT * FROM `astrologers` WHERE `phone`='".$data['email_phone']."' AND `status`='1'");
		}
		if ($query_->num_rows() > 0) 
		{
			$query = $query_->row();
			$settings = $this->global_multiple_query('settings',array('id'=>1),'row()');
			$subject = "SHAKTIPEETH OTP Verification";
			$mail_message= "Hello,<br><br>Please enter the OTP ".$data['otp']." to verify your account.<br><br>For any Help Assistance and Support you can reach out to us on our helpline number ".$settings->helpline_number."<br>Looking forward to Care for your Mind and Body.<br><br>Regards<br>SHAKTIPEETH SUPPORT";
	        $this->check_curl($query->email,$subject,$mail_message,'OTP VERIFICATION');
	        $this->load->model('ApiCommonNotify');
			$sms_message = 'Thank you for registering with Shaktipeeth Digital. Your OTP for verifying your phone no is: '.$data['otp'].' Please do not share this with anyone.';
			$this->ApiCommonNotify->send_sms($query->phone,$sms_message,'+91');
			$response = array("status"=>true,"id"=>$query->id,"msg"=>"otp send successfully");
		
		}
		return $response;
	}

	function isEmailExist_astrologer($email){
		$query1 = $this->db->get_where('astrologers',array('email'=>$email,"status"=>1));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}
	function Isphoneexist_astrologer($mobile,$country_code=''){
		$query1 = $this->db->get_where('astrologers',array('phone'=>$mobile,"status"=>1));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}

	function Isphoneexist_astrologer_country_code($mobile,$country_code){
		$query1 = $this->db->get_where('astrologers',array('phone'=>$mobile,'country_code'=>$country_code,"status<>"=>2));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}

	public function get_profile_astrologers($data)
	{
		$query_  = $this->db->get_where("astrologers",array("id"=>$data['user_id']));
		if ($query_->num_rows() > 0) 
		{
			$query = $query_->row();
			if (!empty($query->image)) 
			{
				$img = base_url('/uploads/astrologers').'/'.$query->image;
			}
			else
			{
				$img = base_url('/uploads/astrologers/').'/'.'default.png';
			}
			if (!is_null($query->gender)) 
			{
				$gender = $query->gender;
			}
			else
			{
				$gender = '';
			}


			if (!is_null($query->dob)) 
			{
				$dob = $query->dob;
			}
			else
			{
				$dob = '';
			}

			
			if (!is_null($query->address)) 
			{
				$address = $query->address;
			}
			else
			{
				$address = '';
			}

			
			if (!is_null($query->state)) 
			{
				$state = $query->state;
			}
			else
			{
				$state = '';
			}

			if (!is_null($query->city)) 
			{
				$city = $query->city;
			}
			else
			{
				$city = '';
			}

			if (!is_null($query->languages)) 
			{
				$language = $query->languages;
			}
			else
			{
				$language = '';
			}

			if (!is_null($query->specialization)) 
			{
				$specialization = $query->specialization;
			}
			else
			{
				$specialization = '';
			}
			if (!is_null($query->service_offered)) 
			{
				$service_offered = $query->service_offered;
			}
			else
			{
				$service_offered = '';
			}

			
			
			$user_details = array( "status"=>$query->status,
									"user_id"=>$query->id,
									"email"=>$query->email,
									"name"=>$query->name,
									"mobile"=>$query->phone,
									"image"=>$img,
									"dob"=>$dob,
									"gender"=>$gender,
									"experience"=>$query->experience,
									"address"=>$address,
									"state"=>$state,
									"city"=>$city,
									"language"=>$language,
									"specialization"=>$query->specialization,
									"service_offered"=>$query->service_offered,
									"approved"=>$query->approved,
									"is_approval"=>$query->is_approval,
									"service_offered"=>$service_offered,
									"specialization"=>$specialization
									);

			$response = array("status"=>true,"user_details"=>$user_details);
		}
		else
		{
			$response = array("status"=>false,"message"=>"No user found of this user_id");
		}
		return $response;
	}

	
 	//fresh for astrologer

 	public function send_mail($email,$subject,$message)
	{
		$this->load->library('My_PHPMailer');
		$settings = $this->get_settings();
		$body= $message;
        $mail = new PHPMailer;
		$mail->isSMTP();				  
		$mail->Host = $settings->smtp_host;//'smtp.gmail.com'; //'md-70.webhostbox.net';
		$mail->SMTPAuth = true;
		$mail->Username = $settings->smtp_username;//'form41app@gmail.com'; //'mail@appsgenic.com';
	    $mail->Password = $settings->smtp_password;//'appslure123'; // '@appsgenic123@';
		$mail->SMTPSecure = 'tls';
		$mail->Port =587;
		$mail->From = $settings->support_email;
		$mail->FromName = $settings->title;
		$mail->addAddress($email, $settings->title);
	    $mail->WordWrap = 500;
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->send();
	}

 	function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SECRET_KEY';
        $secret_iv = 'SECRET_IV';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if($action == 'encrypt')
        {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

 	public function signin($data)
	{
		$password = $this->encrypt_decrypt('encrypt',$data['password']);
		// $password1 = $data['password'];
		if (strpos($data['phone'], '@') !== false) 
		{
			$query = $this->db->query("SELECT * FROM `user` WHERE `email`='".$data['phone']."' AND `password`='$password' AND `status`='1'")->row();
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `user` WHERE `phone`='".$data['phone']."' AND `password`='$password' AND `status`='1'")->row();
		}
		if (count($query) > 0) 
		{
			$ip_address = isset($data['ip_address']) ? $data['ip_address'] : '';
			$deviceID = $data['deviceID'];
			$deviceType = $data['deviceType'];
			$deviceToken = $data['deviceToken'];
			$model_name = isset($data['model_name']) ? $data['model_name'] : '';
			$carrier_name = isset($data['carrier_name']) ? $data['carrier_name'] : '' ;
			$device_country = isset($data['device_country']) ? $data['device_country'] : '';
			$device_memory =  isset($data['device_memory']) ? $data['device_memory'] : '';
			$has_notch = isset($data['has_notch']) ? $data['has_notch'] : '';
			$manufacture = isset($data['manufacture']) ? $data['manufacture'] : '';
			// voip_token for voice notification
			$voip_token = '';//$data['voip_token'];

			$this->db->query("UPDATE `user` SET `voip_token`='$voip_token',`ip_address` = '$ip_address',`device_id`='$deviceID',`model_name`='$model_name',`carrier_name`='$carrier_name',`device_country`='$device_country',`device_memory`='$device_memory',`have_notch`='$has_notch',`manufacture`='$manufacture',`device_token`='$deviceToken',`device_type`='$deviceType' WHERE `id` = '$query->id'");
			if (!empty($query->image)) 
			{
				$img = base_url('/uploads/user').'/'.$query->image;
			}
			else
			{
				$img = base_url('/uploads/user/').'/'.'default.png';
			}
			if (!is_null($query->gender)) 
			{
				$gender = $query->gender;
			}
			else
			{
				$gender = '';
			}


			if (!is_null($query->dob)) 
			{
				$dob = $query->dob;
			}
			else
			{
				$dob = '';
			}

			if (!is_null($query->address)) 
			{
				$address = $query->address;
			}
			else
			{
				$address = '';
			}

			if (!is_null($query->country)) 
			{
				$country = $query->country;
			}
			else
			{
				$country = '';
			}

			if (!is_null($query->state)) 
			{
				$state = $query->state;
			}
			else
			{
				$state = '';
			}

			if (!is_null($query->city)) 
			{
				$city = $query->city;
			}
			else
			{
				$city = '';
			}

			if (!is_null($query->annual_income)) 
			{
				$annual_income = $query->annual_income;
			}
			else
			{
				$annual_income = '';
			}

			if (!is_null($query->occupation)) 
			{
				$occupation = $query->occupation;
			}
			else
			{
				$occupation = '';
			}

			if (!is_null($query->marital_status)) 
			{
				$marital_status = $query->marital_status;
			}
			else
			{
				$marital_status = '';
			}

			$user_details = array( "status"=>$query->status,
									"user_id"=>$query->id,
									"email"=>$query->email,
									"first_name"=>$query->name,
									"last_name"=>$query->last_name,
									"mobile"=>$query->phone,
									"image"=>$img,
									"wallet"=>$query->wallet,
									"dob"=>$dob,
									"gender"=>$gender,
									"address"=>$address,
									"country"=>$country,
									"state"=>$state,
									"city"=>$city,
									"language"=>$query->language,
									"annual_income"=>$annual_income,
									"occupation"=>$occupation,
									"marital_status"=>$marital_status
									);
			$response = array("status" => true, "msg"=>"correct username and password","user_detail"=>$user_details);
		}
		else
		{
			$response = array("status"=>false,"msg"=>"username and password incorrect");
		}
			return $response;
	}

	function isEmailExist($email){
		$query1 = $this->db->get_where('user',array('email'=>$email,"status<>"=>2));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}
	function Isphoneexist($mobile,$country_code){
		$query1 = $this->db->get_where('user',array('country_code'=>$country_code,'phone'=>$mobile,"status<>"=>2));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}

	function Isphoneexist_country_code($mobile,$country_code){
		$query1 = $this->db->get_where('user',array('phone'=>$mobile,'country_code'=>$country_code));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}

	function isEmailExist_doctor($email){
		$query1 = $this->db->get_where('doctor',array('email'=>$email));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}
	function Isphoneexist_doctor($mobile){
		$query1 = $this->db->get_where('doctor',array('phone'=>$mobile));
		$this->db->last_query();
		if($query1->num_rows()==0){
			return true;
		}else{
			return false;
		}
	}

	function signup($data,$password,$password2){
		$referral_code = $this->referral_code();
		$info = array( 'name'=>$data['first_name'],
					   'last_name'=>$data['last_name'],
					   'email'=>$data['email'],
					   'password'=>$password,
					   'phone'=>$data['mobile'],
					   'gender'=>$data['gender'],
					   'latitude'=>$data['latitude'],
					   'longitude'=>$data['longitude'],
					   'address'=>$data['address'],
					   'country'=>$data['country'],
					   'state'=>$data['state'],
					   'city'=>$data['city'],
					   'marital_status'=>$data['marital_status'],
					   'occupation'=>$data['occupation'],
					   'annual_income'=>$data['annual_income'],
					   'status'=>1,
					   'image'=>'default.png',
					   'added_on'=>date('Y-m-d H:i:sa'),
					   'ip_address' => '',//$data['ip_address'],
					   'device_id' => $data['deviceID'],
					   'device_token' => $data['deviceToken'],
					   'device_type' => $data['deviceType'],
					   'loginTime' => date('Y-m-d H:i:sa'),
					   'model_name' => $data['model_name'],
					   'carrier_name' => $data['carrier_name'],
					   'device_country' => $data['device_country'],
					   'device_memory' => $data['device_memory'],
					   'have_notch' => $data['has_notch'],
					   'manufacture' => $data['manufacture'],
					   'password1'=>$password2,
					   'referral_code'=>$this->referral_code(),
					   'country_code'=>$data['country_code'],
						);		
		if($this->db->insert('user',$info)){
			$user_id = $this->db->insert_id();
			$user_detail = $this->get_user($user_id);
			// referral logic
			$settings = $this->get_settings();
			$subject = '['.$settings->title.']Registration Successfully';
			$mail_message = '<h1 style="color: green;">Congratulations !!</h1>Hi @'.$user_detail->name.',<br><br>Welcome to '.$settings->title.'.<br>Your account with '.$settings->title.' has been created.<br><br>You can now login to Shaktipeeth digital for interactive vedic astrology features and reports.<br><br><br>Sincerely,<br>Support Team <br>'.$settings->company_name.'<br> Website: '.$settings->website_link.'<br><br><p style="text-align: center;">We work for your profit</p><p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p>';
			

			$this->check_curl($user_detail->email,$subject,$mail_message);
			if ($data['is_refer_verify'] == 1) 
			{
				// $this->db->query("UPDATE `user` SET `refferal_wallet` = ".$settings->refferal_wallet." WHERE `id`='$user_id'");
				// $get_other_detail = $this->db->get_where("user",array("id"=>$data['apply_to']))->row();
				// $update_wallet_other_user = $get_other_detail->refferal_wallet + $settings->refferal_wallet;
				// $this->db->query("UPDATE `user` SET `refferal_wallet` = '$update_wallet_other_user' WHERE `id`='".$data['apply_to']."'");
				$refer_array = array("appy_by"=>$user_id,"apply_to"=>$data['apply_to'],"is_used"=>1,"added_on"=>date('Y-m-d H:i:s'),"code"=>$data['referral_code_other']);
				$this->db->insert('referral_code_history',$refer_array);
				$subject_user = '['.$settings->title.']Refer code verified successfully';
				$mail_message_user = '<h1 style="color: green;">Congratulations !!</h1>Hi @'.$user_detail->name.',<br><br>Welcome to '.$settings->title.'.<br>Your refer code is verified successfully!.<br><br><br>Sincerely,<br>Support Team <br>'.$settings->company_name.'.<br> Website: '.$settings->website_link.'<br><br><p style="text-align: center;">We work for your profit</p><p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p>';
				$this->check_curl($user_detail->email,$subject_user,$mail_message_user,$user_detail->name);

				$user_detail2 =  $this->get_user($data['apply_to']);
				$subject_refer_user = '['.$settings->title.']Refer code use successfully';
				$mail_message_refer_user = '<h1 style="color: green;">Congratulations !!</h1>Hi @'.$user_detail2->name.',<br><br>Welcome to Kundali Expert.<br>Your refer code is use by '.$user_detail->name.' and verified successfully!.<br><br><br>Sincerely,<br>Support Team <br>'.$settings->company_name.'.<br> Website: '.$settings->website_link.'<br><br><p style="text-align: center;">We work for your profit</p><p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p>';
				$this->check_curl($user_detail2->email,$subject_refer_user,$mail_message_refer_user);
			}
			return $user_id;
		}
		
	}

	public function referral_code()
	{
		$chars = "0123456789DISCUSS";
		$res = "";
		for ($i = 0; $i < 7; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		return $res;
	}

	public function get_profile($data)
	{
		$query  = $this->db->get_where("user",array("id"=>$data['user_id']))->row();
		if (count($query) > 0) 
		{
			if (!empty($query->image)) 
			{
				$img = base_url('/uploads/user').'/'.$query->image;
			}
			else
			{
				$img = base_url('/uploads/user/').'/'.'default.png';
			}
			if (!is_null($query->gender)) 
			{
				$gender = $query->gender;
			}
			else
			{
				$gender = '';
			}


			if (!is_null($query->dob)) 
			{
				$dob = $query->dob;
			}
			else
			{
				$dob = '';
			}

			
			if (!is_null($query->address)) 
			{
				$address = $query->address;
			}
			else
			{
				$address = '';
			}

			if (!is_null($query->country)) 
			{
				$country = $query->country;
			}
			else
			{
				$country = '';
			}

			if (!is_null($query->state)) 
			{
				$state = $query->state;
			}
			else
			{
				$state = '';
			}

			if (!is_null($query->city)) 
			{
				$city = $query->city;
			}
			else
			{
				$city = '';
			}

			if (!is_null($query->annual_income)) 
			{
				$annual_income = $query->annual_income;
			}
			else
			{
				$annual_income = '';
			}

			if (!is_null($query->occupation)) 
			{
				$occupation = $query->occupation;
			}
			else
			{
				$occupation = '';
			}

			if (!is_null($query->marital_status)) 
			{
				$marital_status = $query->marital_status;
			}
			else
			{
				$marital_status = '';
			}


			
			$user_details = array( "status"=>$query->status,
									"user_id"=>$query->id,
									"email"=>$query->email,
									"first_name"=>$query->name,
									"last_name"=>$query->last_name,
									"mobile"=>$query->phone,
									"country_code"=>$query->country_code,
									"image"=>$img,
									"wallet"=>$query->wallet,
									"refferal_wallet"=>$query->refferal_wallet,
									"dob"=>$dob,
									"gender"=>$gender,
									"refferal_code"=>$query->referral_code,
									"address"=>$address,
									"country"=>$country,
									"state"=>$state,
									"city"=>$city,
									"language"=>$query->language,
									"annual_income"=>$annual_income,
									"occupation"=>$occupation,
									"marital_status"=>$marital_status
									);

			$response = array("status"=>true,"user_details"=>$user_details);
		}
		else
		{
			$response = array("status"=>false,"message"=>"No user found of this user_id");
		}
		return $response;
	}

	public function basic_detail_update($data)
	{
		$ar = array("height"=>$data['height'],
					"weight"=>$data['weight'],
					"blood_group"=>$data['blood_group'],
					"allergies"=>$data['allergies'],
					"illnesses"=>$data['illnesses'],
					"surgeries"=>$data['surgeries'],
					);
		$this->db->where('id', $data['user_id']);
        $this->db->update('patient', $ar);
        $user_detail = $this->w_m->global_multiple_query('patient',array('id' => $data['user_id']),'row()');
		if (!empty($user_detail->image)) 
		{
			$img = base_url('/uploads/patient').'/'.$user_detail->image;
		}
		else
		{
			$img = base_url('/uploads/patient/').'/'.'default.png';
		}
		if (!is_null($user_detail->gender)) 
		{
			$gender = $user_detail->gender;
		}
		else
		{
			$gender = '';
		}


		if (!is_null($user_detail->dob)) 
		{
			$dob = $user_detail->dob;
		}
		else
		{
			$dob = '';
		}

		if (!is_null($user_detail->height)) 
		{
			$height = $user_detail->height;
		}
		else
		{
			$height = '';
		}

		if (!is_null($user_detail->weight)) 
		{
			$weight = $user_detail->weight;
		}
		else
		{
			$weight = '';
		}

		if (!is_null($user_detail->blood_group)) 
		{
			$blood_group = $user_detail->blood_group;
		}
		else
		{
			$blood_group = '';
		}

		if (!is_null($user_detail->allergies)) 
		{
			$allergies = $user_detail->allergies;
		}
		else
		{
			$allergies = '';
		}

		if (!is_null($user_detail->illnesses)) 
		{
			$illnesses = $user_detail->illnesses;
		}
		else
		{
			$illnesses = '';
		}


		if (!is_null($user_detail->surgeries)) 
		{
			$surgeries = $user_detail->surgeries;
		}
		else
		{
			$surgeries = '';
		}
		$user_detail1 = array(	"user_id"=> $user_detail->id,
						        "name"=> $user_detail->name,
						        "email"=> $user_detail->email,
						        "mobile"=> $user_detail->phone,
						        "image"=> $img,
						    	"wallet"=>$user_detail->wallet,
						    	"refferal_code"=>$user_detail->referral_code,
						    	"dob"=>$dob,
								"gender"=>$gender,
								"height"=>$height,
								"weight"=>$weight,
								"blood_group"=>$blood_group,
								"allergies"=>$allergies,
								"illnesses"=>$illnesses,
								"surgeries"=>$surgeries,
								);
		$response = array('status'=>true,'msg'=>'Successfully Update','user_detail'=>$user_detail1);
		return $response;
	}
	public function get_user($user_id)
	{
		$user  = $this->db->get_where("user",array("id"=>$user_id))->row();
		return $user;
	}

	public function otp_send($data)
	{
		if (strpos($data['email'], '@') !== false) 
		{
			$settings = $this->global_multiple_query('settings',array('id'=>1),'row()');
			$subject = "SHAKTIPEETH OTP Verification";
			$mail_message= "Hello,<br><br>Please enter the OTP ".$data['otp']." to verify your account.<br><br>For any Help Assistance and Support you can reach out to us on our helpline number ".$settings->helpline_number."<br>Looking forward to Care for your Mind and Body.<br><br>Regards<br>SHAKTIPEETH SUPPORT";
	        $this->check_curl($data['email'],$subject,$mail_message,'OTP VERIFICATION');
			$response = array("status"=>true,"msg"=>"email send successfully");
			
		}
		else
		{
			$response = array("status"=>true,"msg"=>"email send successfully");
			// $query = $this->db->get_where('patient',array('phone'=>$email,"status<>"=>2));
			// $checker = $query->row();
			// if($checker){


			// 	//$password = $this->encrypt_decrypt('decrypt',$checker->password);
			// 	$message = "To log into Diskuss your verification code is ".$otp.". Kindly enter this verification code to confirm your number";
			// 	$authentication_key = '311972AgRlyRODJn5e144d5bP1';
			// 	$curl = curl_init();
			// 	curl_setopt_array($curl, array(
			// 	  CURLOPT_URL => "https://api.msg91.com/api/v2/sendsms",
			// 	  CURLOPT_RETURNTRANSFER => true,
			// 	  CURLOPT_ENCODING => "",
			// 	  CURLOPT_MAXREDIRS => 10,
			// 	  CURLOPT_TIMEOUT => 30,
			// 	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// 	  CURLOPT_CUSTOMREQUEST => "POST",
			// 	  CURLOPT_POSTFIELDS => "{ \"sender\": \"DISKUS\", \"route\": \"4\", \"country\": \"$checker->country_code\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$checker->phone\" ] } ] }",
			// 	  CURLOPT_SSL_VERIFYHOST => 0,
			// 	  CURLOPT_SSL_VERIFYPEER => 0,
			// 	  CURLOPT_HTTPHEADER => array(
			// 	    "authkey: $authentication_key",
			// 	    "content-type: application/json"
			// 	  ),
			// 	));

			// 	$response = curl_exec($curl);
			// 	$err = curl_error($curl);

			// 	curl_close($curl);

				
			// 	$response = array("status"=>true,"msg"=>"email send successfully");
			// }
			// else
			// {
			// 	$response = array("status"=>false,"msg"=>"email not found");
			// }
			
		}
		return $response;
		// return $data1;
	}

	public function otp_send_for_login($data)
	{
		$u = $this->db->get_where("user",array("phone"=>$data['mobile']))->row();
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://control.msg91.com/api/sendotp.php?authkey=315747AeqFpJNgt5e326cbdP1&mobile=".$data['mobile']."&sender=KUNDEX&country=".$data['country_code']."&otp=".$data['otp'],
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$data1 = array("status"=>true,"message"=>"otp send successfully");
		return $data1;
	}


	public function user_detail_after_otp($data)
	{
		$query = $this->db->query("SELECT * FROM `user` WHERE `phone`='".$data['mobile']."' AND `status`='1'")->row();
		if (count($query) > 0) 
		{
			$ip_address = '';//$data['ip_address'];
			$deviceID = $data['deviceID'];
			$deviceType = $data['deviceType'];
			$deviceToken = $data['deviceToken'];
			$model_name = $data['model_name'];
			$carrier_name = $data['carrier_name'];
			$device_country = $data['device_country'];
			$device_memory = $data['device_memory'];
			$has_notch = $data['has_notch'];
			$manufacture = $data['manufacture'];
			$voip_token = '';//$data['voip_token'];

			$this->db->query("UPDATE `user` SET `voip_token`='$voip_token',`ip_address` = '$ip_address',`device_id`='$deviceID',`model_name`='$model_name',`carrier_name`='$carrier_name',`device_country`='$device_country',`device_memory`='$device_memory',`have_notch`='$has_notch',`manufacture`='$manufacture',`device_token`='$deviceToken',`device_type`='$deviceType' WHERE `id` = '$query->id'");
			if (!empty($query->image)) 
			{
				$img = base_url('/uploads/user').'/'.$query->image;
			}
			else
			{
				$img = base_url('/uploads/user/').'/'.'default.png';
			}
			if (!is_null($query->gender)) 
			{
				$gender = $query->gender;
			}
			else
			{
				$gender = '';
			}


			if (!is_null($query->dob)) 
			{
				$dob = $query->dob;
			}
			else
			{
				$dob = '';
			}

			if (!is_null($query->address)) 
			{
				$address = $query->address;
			}
			else
			{
				$address = '';
			}

			if (!is_null($query->birth_time)) 
			{
				$birth_time = $query->birth_time;
			}
			else
			{
				$birth_time = '';
			}

			if (!is_null($query->place_of_birth)) 
			{
				$place_of_birth = $query->place_of_birth;
			}
			else
			{
				$place_of_birth = '';
			}

			
			$user_details = array( "status"=>$query->status,
									"user_id"=>$query->id,
									"email"=>$query->email,
									"name"=>$query->name,
									"mobile"=>$query->phone,
									"image"=>$img,
									"wallet"=>$query->wallet,
									"dob"=>$dob,
									"gender"=>$gender,
									"refferal_code"=>$query->referral_code,
									"address"=>$address,
									"birth_time"=>$birth_time,
									"place_of_birth"=>$place_of_birth,
									);
			$response = array("status" => true, "msg"=>"correct username and password","user_detail"=>$user_details);
		}
		else
		{
			$response = array("status"=>false,"msg"=>"username and password incorrect");
		}
		return $response;
	}

	function forget_password_send_password($email){
		$query = $this->db->get_where('user',array('email'=>$email));
		$checker = $query->row();
		$settings = $this->global_multiple_query('settings',array('id'=>1),'row()');
		if($checker){
			$password = $this->encrypt_decrypt('decrypt',$checker->password);
			$subject = "Your Shaktipeeth accound password";
			$mail_message= $password." is your Shaktipeeth account password.";
            $settings = $this->get_settings();
			$this->check_curl($checker->email,$subject,$mail_message);
			// if(!$mail->send())
			// { 
			// 	$response = array("status"=>false,"msg"=>"something error happen please try again!!"); 
			// }
			// else
			// {    
				$response = array("status"=>true,"msg"=>"email send successfully");
			// }
		}else{
			$response = array("status"=>false,"msg"=>"email not found");
		}
		return $response;
	}

	function forget_password($email,$otp){
		
		if (strpos($email, '@') !== false) 
		{
			$query = $this->db->get_where('user',array('email'=>$email,"status"=>1));
			$checker = $query->row();
			if($checker){
				$settings = $this->global_multiple_query('settings',array('id'=>1),'row()');
				$subject = "SHAKTIPEETH OTP Verification";
				$mail_message= "Hello,<br><br>Please enter the OTP ".$otp." to verify your account.<br><br>For any Help Assistance and Support you can reach out to us on our helpline number ".$settings->helpline_number."<br>Looking forward to Care for your Mind and Body.<br><br>Regards<br>SHAKTIPEETH SUPPORT";
		        $this->check_curl($checker->email,$subject,$mail_message,$checker->name);
				$response = array("status"=>true,"msg"=>"email send successfully");
			}else{
				$response = array("status"=>false,"msg"=>"email not found");
			}
		}
		else
		{
			// $query = $this->db->get_where('patient',array('phone'=>$email,"status<>"=>2));
			// $checker = $query->row();
			// if($checker){


			// 	//$password = $this->encrypt_decrypt('decrypt',$checker->password);
			// 	$message = "To log into Diskuss your verification code is ".$otp.". Kindly enter this verification code to confirm your number";
			// 	$authentication_key = '311972AgRlyRODJn5e144d5bP1';
			// 	$curl = curl_init();
			// 	curl_setopt_array($curl, array(
			// 	  CURLOPT_URL => "https://api.msg91.com/api/v2/sendsms",
			// 	  CURLOPT_RETURNTRANSFER => true,
			// 	  CURLOPT_ENCODING => "",
			// 	  CURLOPT_MAXREDIRS => 10,
			// 	  CURLOPT_TIMEOUT => 30,
			// 	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// 	  CURLOPT_CUSTOMREQUEST => "POST",
			// 	  CURLOPT_POSTFIELDS => "{ \"sender\": \"DISKUS\", \"route\": \"4\", \"country\": \"$checker->country_code\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$checker->phone\" ] } ] }",
			// 	  CURLOPT_SSL_VERIFYHOST => 0,
			// 	  CURLOPT_SSL_VERIFYPEER => 0,
			// 	  CURLOPT_HTTPHEADER => array(
			// 	    "authkey: $authentication_key",
			// 	    "content-type: application/json"
			// 	  ),
			// 	));

			// 	$response = curl_exec($curl);
			// 	$err = curl_error($curl);

			// 	curl_close($curl);

				
			// 	$response = array("status"=>true,"msg"=>"email send successfully");
			// }
			// else
			// {
			// 	$response = array("status"=>false,"msg"=>"email not found");
			// }
			
		}
		
		return $response;
	}

	function forget_password_doctor($email){
		$bg = base_url().'/'."bg.jpg";
		$logo = base_url().'/'.'logo1.png';
		$this->load->library('My_PHPMailer');
		$query = $this->db->get_where('doctor',array('email'=>$email));
		$checker = $query->row();
		$settings = $this->global_multiple_query('settings',array('id'=>1),'row()');
		if($checker){
			$this->load->helper('string');
			$password = $checker->random_password;
			$subject = "Your Anytimedoc accound password";
			$body= $password." is your Anytimedoc account password.";
            $mail = new PHPMailer;
			$mail->isSMTP();				  
			$mail->Host = $settings->smtp_host;//'smtp.gmail.com'; //'md-70.webhostbox.net';
			$mail->SMTPAuth = true;
			$mail->Username = $settings->smtp_username;//'form41app@gmail.com'; //'mail@appsgenic.com';
	        $mail->Password = $settings->smtp_password;//'appslure123'; // '@appsgenic123@';
			$mail->SMTPSecure = 'tls';
			$mail->Port =587;
			$mail->From = 'Anytimedoc@info.com';
			$mail->FromName = 'Anytimedoc';
			$mail->addAddress($email, 'Anytimedoc');
	        $mail->WordWrap = 500;
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $body;
			if(!$mail->send())
			{ 
				$response = array("status"=>false,"msg"=>"something error happen please try again!!"); 
			}
			else
			{    
				$response = array("status"=>true,"msg"=>"email send successfully");
			}
		}else{
			$response = array("status"=>false,"msg"=>"email not found");
		}
		return $response;
	}

	public function photo_gallery($id)
	{
		$gallery = $this->db->query("SELECT `id`, `image` FROM `photo_gallery` WHERE `status` = '1' AND `foreign_id` = '$id'")->result();
		if (count($gallery) > 0) 
		{
			$path = base_url('uploads/photos/gallery');
			foreach ($gallery as $key) 
			{
				$r[] = array("id"=>$key->id,
							  "image"=>$path.'/'.$key->image);
			}
			$response = array("true"=>true,"gallery"=>$r);
		}
		else
		{
			$response = array('status' => false,"msg"=>"Not having any gallery");
		}

		return $response;
	}

	public function verify_referral($data)
	{
		$check = $this->db->query("SELECT * FROM `user` WHERE `referral_code`='".$data['referral_code']."' AND `status`='1'")->row();
		if (count($check) > 0) 
		{
			$apply_to = $check->id;
			$refer_code = $check->referral_code;
			$response = array("status"=>true,"message"=>"Verify","apply_to"=>$apply_to,"referral_code_other"=>$refer_code);

		}
		else
		{
			$response = array("status"=>false,"message"=>"Wrong Refer code","apply_to"=>0,"referral_code_other"=>0);
		}
		return $response;
	}

	public function check_total_member($user_id)
	{
		$q = $this->db->query("SELECT COUNT(*) AS A FROM `user_member` WHERE `user_id`='$user_id' AND `status` <> 2")->row();
		if (count($q) > 0) 
		{
			return $q->A;
		}
		else
		{
			return 0;
		}
	}

	public function check_member_name($email,$mobile,$user_id)
	{
		$get_user_email = $this->db->query("SELECT * FROM `user_member` WHERE `user_id`='$user_id' AND `email`='".$email."' AND `status`='1'")->row();
		$get_user_mobile = $this->db->query("SELECT * FROM `user_member` WHERE`user_id`='$user_id' AND  `mobile`='".$mobile."' AND `status`='1'")->row();
		if (count($get_user_email) > 0) 
		{
			return 1;
		}
		elseif (count($get_user_mobile) > 0) 
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function check_bookmark_of_patient($user_id,$id)
	{
		return $this->db->query("SELECT `id` FROM patient_bookmark WHERE `patient_id`='$user_id' AND `doctor_id`='$id'")->row();
	}

	public function get_ratting_of_doc($id)
	{
		return $this->db->query("SELECT AVG(rating) as avg_rating FROM rating_doctor WHERE `doctor_id` = '$id' GROUP BY `doctor_id`")->row();
	}

	
	

	public function check_bookmark($user_id,$product_id)
  	{
    	return $this->db->query("SELECT `id` FROM `gems_bookmark` WHERE `user_id` = '$user_id' AND `product_id`='$product_id'")->row();
  	}

  	public function delete_it_bookmark($id)
	{
	   $this->db->query("DELETE FROM `gems_bookmark` WHERE `id`='$id'");
	    return false;
	}


  	public function insert_the_booking($insert_data)
  	{
    	$this->db->insert('gems_bookmark',$insert_data);
   	 	return true;
  	}

  	public function list_bookmark_gems($user_id)
  	{
      return $this->db->query("SELECT `id`, `product_id` FROM gems_bookmark WHERE `user_id` = '$user_id'")->result();
  	}

  


	

	

	
	

	

	function get_settings(){
		$query = $this->db->get_where('settings',array('id'=>'1'));
		return $result = $query->row();
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
	    $post['fil_package_deatils'] = $fil_package_deatils;
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
	    return true;
	}

	

	public function curl_mail_fun()
	{
		$email = $this->input->get("email");
		$subject = $this->input->get("subject");
		$message = $this->input->get("message");
		date_default_timezone_set('Etc/UTC');

		/* Information from the XOAUTH2 configuration. */
		$google_email = 'kundliexpert12@gmail.com';
		$oauth2_clientId = '173312080437-dntubar209cf6r6jm2r3kihh1j9pd4jh.apps.googleusercontent.com';
		$oauth2_clientSecret = '-ONN8LIE3o6LwMxEEvNhV-Pz';
		$oauth2_refreshToken = '1//0gx77B2-FpoGqCgYIARAAGBASNgF-L9IrlFe8fY6rOlPpHu6njZDqkuT1WiwcYk4mvf3Ej1BQDzH23FiGymIDrPmWMRqnSxy45g';

		$mail = new PHPMailer(TRUE);

		try {
		   
		   $mail->setFrom($google_email, 'Darth Vader');
		   $mail->addAddress('sachinappslure@gmail.com', 'Emperor');
		   $mail->Subject = 'Force';
		   $mail->Body = 'There is a great disturbance in the Force.';
		   $mail->isSMTP();
		   $mail->Port = 587;
		   $mail->SMTPAuth = TRUE;
		   $mail->SMTPSecure = 'tls';
		   
		   /* Google's SMTP */
		   $mail->Host = 'smtp.gmail.com';
		   
		   /* Set AuthType to XOAUTH2. */
		   $mail->AuthType = 'XOAUTH2';
		   
		   /* Create a new OAuth2 provider instance. */
		   $provider = new Google(
		      [
		         'clientId' => $oauth2_clientId,
		         'clientSecret' => $oauth2_clientSecret,
		      ]
		   );
		   
		   /* Pass the OAuth provider instance to PHPMailer. */
		   $mail->setOAuth(
		      new OAuth(
		         [
		            'provider' => $provider,
		            'clientId' => $oauth2_clientId,
		            'clientSecret' => $oauth2_clientSecret,
		            'refreshToken' => $oauth2_refreshToken,
		            'userName' => $google_email,
		         ]
		      )
		   );
		   
		   /* Finally send the mail. */
		   $mail->send();
		 echo 1;
		}
		catch (Exception $e)
		{
			echo $e->errorMessage();
		}
		catch (\Exception $e)
		{
		   echo $e->getMessage();
		}
		// $this->load->library('My_PHPMailer');
		// $settings = $this->get_settings();
		// $body= $message;
  //       $mail = new PHPMailer;
		// $mail->isSMTP();				  
		// $mail->Host = $settings->smtp_host;//'smtp.gmail.com'; //'md-70.webhostbox.net';
		// $mail->SMTPAuth = true;
		// $mail->Username = $settings->smtp_username;//'form41app@gmail.com'; //'mail@appsgenic.com';
	 //    $mail->Password = $settings->smtp_password;//'appslure123'; // '@appsgenic123@';
		// $mail->SMTPSecure = 'tls';
		// $mail->Port =587;
		// $mail->From = $settings->support_email;
		// $mail->FromName = $settings->title;
		// $mail->addAddress($email, $settings->title);
	 //    $mail->WordWrap = 500;
		// $mail->isHTML(true);
		// $mail->Subject = $subject;
		// $mail->Body    = $body;
		// $mail->send();
	}

	// Signinexpert
	

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
        // print_r($reult);             
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

    public function get_ratting_of_exp($id)
	{
		return $this->db->query("SELECT AVG(rating) as avg_rating FROM rating_expert WHERE `expert_id` = '$id' GROUP BY `expert_id`")->row();
	}

	public function signin_supervisor($data)
	{
		$password  = $data['password'];
		if (strpos($data['phone'], '@') !== false) 
		{
			$query = $this->db->query("SELECT * FROM `supervisor` WHERE `email`='".$data['phone']."' AND `password`='$password' AND `status`='1'")->row();
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `supervisor` WHERE `mobile`='".$data['phone']."' AND `password`='$password' AND `status`='1'")->row();
		}
		if (count($query) > 0) 
		{
			$ip_address = $data['ip_address'];
			$deviceID = $data['deviceID'];
			$deviceType = $data['deviceType'];
			$deviceToken = $data['deviceToken'];
			$model_name = $data['model_name'];
			$carrier_name = $data['carrier_name'];
			$device_country = $data['device_country'];
			$device_memory = $data['device_memory'];
			$has_notch = $data['has_notch'];
			$manufacture = $data['manufacture'];
			// voip_token for voice notification
			$voip_token = '';//$data['voip_token'];

			$this->db->query("UPDATE `supervisor` SET `ip_address` = '$ip_address',`device_id`='$deviceID',`model_name`='$model_name',`carrier_name`='$carrier_name',`device_country`='$device_country',`device_memory`='$device_memory',`have_notch`='$has_notch',`manufacture`='$manufacture',`device_token`='$deviceToken',`device_type`='$deviceType' WHERE `id` = '$query->id'");
			$user_details = array( "status"=>$query->status,
									"user_id"=>$query->id,
									"email"=>$query->email,
									"name"=>$query->name,
									"mobile"=>$query->mobile,
									);
			$response = array("status" => true, "msg"=>"correct username and password","user_detail"=>$user_details);
		}
		else
		{
			$response = array("status"=>false,"msg"=>"username and password incorrect");
		}
			return $response;
	}

	public function signin_priest($data)
	{
		$password  = $data['password'];
		if (strpos($data['phone'], '@') !== false) 
		{
			$query = $this->db->query("SELECT * FROM `priest` WHERE `email`='".$data['phone']."' AND `password`='$password' AND `status`='1'")->row();
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `priest` WHERE `mobile`='".$data['phone']."' AND `password`='$password' AND `status`='1'")->row();
		}
		if (count($query) > 0) 
		{
			$ip_address = $data['ip_address'];
			$deviceID = $data['deviceID'];
			$deviceType = $data['deviceType'];
			$deviceToken = $data['deviceToken'];
			$model_name = $data['model_name'];
			$carrier_name = $data['carrier_name'];
			$device_country = $data['device_country'];
			$device_memory = $data['device_memory'];
			$has_notch = $data['has_notch'];
			$manufacture = $data['manufacture'];
			// voip_token for voice notification
			$voip_token = '';//$data['voip_token'];

			$this->db->query("UPDATE `priest` SET `ip_address` = '$ip_address',`device_id`='$deviceID',`model_name`='$model_name',`carrier_name`='$carrier_name',`device_country`='$device_country',`device_memory`='$device_memory',`have_notch`='$has_notch',`manufacture`='$manufacture',`device_token`='$deviceToken',`device_type`='$deviceType' WHERE `id` = '$query->id'");
			$user_details = array( "status"=>$query->status,
									"user_id"=>$query->id,
									"email"=>$query->email,
									"name"=>$query->name,
									"mobile"=>$query->mobile,
									"location"=>$query->location
									);
			$response = array("status" => true, "msg"=>"correct username and password","user_detail"=>$user_details);
		}
		else
		{
			$response = array("status"=>false,"msg"=>"username and password incorrect");
		}
			return $response;
	}

	public function user_device_update($data)
	{
		$ip_address = isset($data['ip_address']) ? $data['ip_address'] : '';
		$deviceID = $data['deviceID'];
		$deviceType = $data['deviceType'];
		$deviceToken = $data['deviceToken'];
		$model_name = isset($data['model_name']) ? $data['model_name'] : '';
		$carrier_name = isset($data['carrier_name']) ? $data['carrier_name'] : '' ;
		$device_country = isset($data['device_country']) ? $data['device_country'] : '';
		$device_memory =  isset($data['device_memory']) ? $data['device_memory'] : '';
		$has_notch = isset($data['has_notch']) ? $data['has_notch'] : '';
		$manufacture = isset($data['manufacture']) ? $data['manufacture'] : '';
		// voip_token for voice notification
		$voip_token = '';//$data['voip_token'];

		$this->db->query("UPDATE `user` SET `voip_token`='$voip_token',`ip_address` = '$ip_address',`device_id`='$deviceID',`model_name`='$model_name',`carrier_name`='$carrier_name',`device_country`='$device_country',`device_memory`='$device_memory',`have_notch`='$has_notch',`manufacture`='$manufacture',`device_token`='$deviceToken',`device_type`='$deviceType' WHERE `id` = '".$data['user_id']."'");
		return true;
	}


	public function fetch_puja($user_id = '',$gods	= '',$category_id	= '',$temples	= '',$location	= '')
	{
		$where = '';
		// if departments include in filter
		if ($gods) 
		{
			$where .= ' AND CONCAT("|", `gods`, "|") REGEXP "'.$gods.'"';
		}

		if ($temples) 
		{
			$where .= ' AND CONCAT("|", `temples`, "|") REGEXP "'.$temples.'"';
		}
		
		if ($category_id) 
		{
			$where .= ' AND CONCAT(",", `category_id`, ",") REGEXP "'.$category_id.'"';
		}
		$sortby = 'position';
		$order = 'ASC';
		return $this->db->query("SELECT `id`, `name`, `name_in_hindi`, `name_in_gujrati`, `image`, `status`, `position`, `pooja_type`, `added_on`, `category_id`, `gods`, `temples` FROM puja WHERE `status`='1' ".$where." ORDER BY `".$sortby.'` '.$order )->result();
	}

	
}