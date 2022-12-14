<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google; 

use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;

class ApiCommonNotify extends CI_Model {	
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

	public function send_sms($mobile,$sms_message,$country_code)
	{
		$settings = $this->global_multiple_query('settings',array('id'=>1),'row()');
		$key = $settings->aws_key;//'AKIAWKL6GWKSULRK3RVW';
		$secret = $settings->aws_secret;//'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';
		$SnSclient = new SnsClient([
		    'region' => 'ap-south-1',
		    'version' => '2010-03-31',
		    'credentials' => [
				            'key' => $key,
				            'secret' => $secret,
				        ]
		]);

		$message = $sms_message;
		$phone = $country_code.$mobile;

		try {
		    $result = $SnSclient->publish([
		        'Message' => $message,
		        'PhoneNumber' => $phone,
		    ]);
		   
		} catch (AwsException $e) {
		    // output error message if fails
		    
		} 
		return true;
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
        // print_r($reult);             
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }


    public function send_invoice_temp($booking_id = '',$sub,$condition)
	{
		$get_ = $this->db->get_where("booking_history", array("id" => $booking_id));
		if ($get_->num_rows() > 0) {
			$get = $get_->row();
			$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get->main_location_id'")->row();
			$venue_details = $get->venue;
			$pdf_data = array();
			$pdf_data['puja_name'] = $get_pooja_detail->name;
			$pdf_data['location_name'] = $get->booking_location;
			$pdf_data['status'] = $get->status;
			$pdf_data['puja_mode'] = ucfirst($get->mode);

			$pdf_data['booking_date'] = date('d/m/Y', strtotime($get->schedule_date));
			$pdf_data['booking_time'] = $get->schedule_time;
			$pdf_data['end_time'] = $get->end_time;
			$pdf_data['total_amount'] = $get->amount;
			$pdf_data['total_amount'] = number_format((float)$pdf_data['total_amount'], 2, '.', '');
			$pdf_data['venue_details'] = $venue_details;
			$tax_amount = $get->tax_amount;
			$pdf_data['unit_Price'] = $get->amount - $tax_amount;
			$pdf_data['qty'] = 1;
			$pdf_data['tax_amount'] = $tax_amount;
			$pdf_data['tax_type_string'] = $get->tax_name;
			$pdf_data['tax_value_string'] = $get->tax_name;
			$pdf_data['order_number'] = 'KOL-'.$get->booking_id;
			$pdf_data['suborder_number'] = $get->id;
			$pdf_data['order_date'] = date('d/m/Y', strtotime($get->created_at));
			$pdf_data['time'] = date('h:i:s', strtotime($get->created_at));
			$pdf_data['invoice_order_date'] = date('d/m/Y');
			$pdf_data['invoice_time'] = date('h:i:s');
			$pdf_data['name'] = $get->host_name;
			// $f = explode(',', $get->pob_lat_long_address);
			$pdf_data['word_rs'] = $this->intowords($pdf_data['total_amount']);
			$user_detail = $this->db->get_where("user", array("id" => $get->user_id))->row();
			//customer address
			$pdf_data['Name'] = $user_detail->name;
			$pdf_data['City'] = $user_detail->city;
			$pdf_data['Pincode'] = $user_detail->zip;
			$pdf_data['State'] = $user_detail->state;
			$pdf_data['Country'] = $user_detail->country;
			//billing address
			$get_booking_ = $this->db->get_where('bookings',array('id'=>$get->booking_id))->row();
			$pdf_data['b_Name'] = $get_booking_->billing_name;
			$pdf_data['b_City'] = $get_booking_->billing_city;
			$pdf_data['b_Pincode'] = $get_booking_->billing_pincode;
			$pdf_data['b_State'] = $get_booking_->billing_state;
			$pdf_data['b_Country'] = $get_booking_->billing_country;
			
			

			$this->load->library('Pdf');
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('SHAKTIPEETH');
			$pdf->SetTitle('Invoice');
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->SetFont('dejavusans', '', 10);
			$pdf->AddPage();
			$htmlcode = $this->load->view('invoice/final-invoice', $pdf_data, TRUE);
			$pdf->writeHTML($htmlcode, true, false, true, false, '');
			$pdffname = $pdf_data['order_number'] .date('d-m-y-h-i-s').'-invoice.pdf';
			$newFile  = FCPATH . "/uploads/invoices/" . $pdffname;
			//ob_clean();
			$pdf->Output($newFile, 'F');
			
			$email = $user_detail->email;
			$mobile = $user_detail->phone;
			$settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
			$subject = $sub;
			//$sum_total = 1000; //$detail_s->total_amount + $detail_s->wallet_amount + $detail_s->referral_amount + $detail_s->discount_amount;

			//$sms_message = "Prescription uploaded send to your registered email.[Online Counsult] Appointment ID:EASEMYMED-".$detail_s->id." for ".$booking_date.','.$booking_time." with ".$get_doc_detail->doctor_firstname;
			if ($condition == 'cancel') 
			{
				$array_ = array("cancel_invoice"=>$pdffname,"cancel_date"=>date('Y-m-d H:i:s'));
				$this->db->where("id",$booking_id);
				$this->db->update("booking_history",$array_);	
			}
			else
			{
				$array_ = array("complete_booking_invoice"=>$pdffname,"complete_booking_date"=>date('Y-m-d H:i:s'));
				$this->db->where("id",$booking_id);
				$this->db->update("booking_history",$array_);	
			}
			
			$fil_package_deatils = "/uploads/invoices/" . $pdffname;
			if (isset($email)) {
				$htmlcode = '<div id=":1iu" class="ii gt"><div id=":1it" class="a3s aiL msg8519675303135148619"> <u></u><div style="margin:0;font-family:\'Quicksand\',sans-serif"><div style="border:2px solid #f3914a;margin:10px;border-radius:10px"><div style="padding:20px"> <img src="'.base_url("uploads/email_temp/shakti.png").'" alt="certificate logo" style="width:150px;display:block;margin:0 auto;margin-top:15px" data-image-whitelisted="" class="CToWUd"><div style="padding:0 10px"><p style="color:#171717;font-size:14px;margin:3px 0;font-weight:400"><span> Hi '.$get->host_name.',<br>Your Booked Puja '.$pdf_data['puja_name'].' ('.$pdf_data['location_name'].'), vide Order Id KOL-'.$get->booking_id.' Sub Order Id '.$get->id.' has been conducted successfully by our affiliated priest on '.date('d/m/Y').'.<br> You will receive video clips shortly and also the Puja Certificate and invoice would be uploaded in your account. We look forward to serving you again.<br><br>Regards,<br>Shaktipeeth Digital<br>(This is a system generated email. Please do not reply) </span></p></div></div></div> <br></div><div class="yj6qo"></div><div class="adL"></div></div></div>';
				$this->check_curl($email, $subject, $htmlcode , $pdf_data['name'], '', '', $fil_package_deatils);
			}
			if (isset($mobile)) 
			{
				$sms_message = 'Dear '.$get->host_name.', Your Booked Puja '.$pdf_data['puja_name'].' ('.$pdf_data['location_name'].'), vide Order Id KOL-'.$get->booking_id.' Sub Order Id '.$get->id.' has been conducted successfully by our affiliated priest on '.date('d/m/Y').'. You will receive video clips shortly and also the Puja Certificate and invoice would be uploaded in your account. We look forward to serving you again.';
				$this->send_sms($mobile,$sms_message,'+91');
			}
		}
	}

	public function intowords($number)
	{
		$no = floor($number);
	    $point = round($number - $no, 2) * 100;
	    $point = number_format((float)$point, 2, '.', '');
	    $hundred = null;
	    $digits_1 = strlen($no);
	    $i = 0;
	    $str = array();
	    $words = array('0' => '', '1' => 'one', '2' => 'two',
	    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
	    '7' => 'seven', '8' => 'eight', '9' => 'nine',
	    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
	    '13' => 'thirteen', '14' => 'fourteen',
	    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
	    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
	    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
	    '60' => 'sixty', '70' => 'seventy',
	    '80' => 'eighty', '90' => 'ninety');
	    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
	    while ($i < $digits_1) {
	     $divider = ($i == 2) ? 10 : 100;
	     $number = floor($no % $divider);
	     $no = floor($no / $divider);
	     $i += ($divider == 10) ? 1 : 2;
	     if ($number) {
	        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
	        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
	        $str [] = ($number < 21) ? $words[$number] .
	            " " . $digits[$counter] . $plural . " " . $hundred
	            :
	            $words[floor($number / 10) * 10]
	            . " " . $words[$number % 10] . " "
	            . $digits[$counter] . $plural . " " . $hundred;
	     } else $str[] = null;
	    }
	    $str = array_reverse($str);
	    $result = implode('', $str);
	    $second_str = '';
	    if ($point > 0) 
	    {
	    	$points = ($point) ? "and " . $words[$point / 100] . " " . $words[$point = $point % 100] : '';
		    $second_str = $points . " paise";
	    }
	    
	    return ucfirst($result) . "rupees  " . $second_str;
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
	
}