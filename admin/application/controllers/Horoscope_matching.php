<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

class Horoscope_matching extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Gems_booking_model');
        $this->load->model('Horoscope_model','h_m');
           $this->load->model("Doctor_doorstep_model","d_m");
        $this->load->library('pagination');
        $this->load->library('csvimport');
        $this->load->library('encryption');
        $this->load->helper('url');

        $this->load->library('form_validation');
        if(!$this->session->userdata('logged_in')) {
        	redirect(base_url());
        }
    }





       public function matching($x='',$rowno = 1)
    {
        // print_r($rowno); die;

         if (isset($_GET['get_export_data'])) {
             $data[] = array("#"," Booking Type","Name","Email","Mobile","Boy Name","Boy Date of birth ","Boy Time of birth ","Boy Place of birth ","Girl Name","Girl Date of birth","Girl Time of birth","Girl Place of birth","Resoliving Files","Mode of payment","Transaction ID","currency","Amount","From wallet amount","From referral amount","Tax amount","Transaction Status","Payment Method","Payment gateway fee","Payment gateway tax","Payment gateway email","Payment gateway mobile","Payment gateway name","Added on system date","Status","Refund Status ","Refund Amount","Refund Transaction ID","Refund Date");
                $acounts = $this->get_total_enquiries_paginate(0, '');
                $i = 1;
                foreach ($acounts as $user) {
                   
                    // $created_at  = date("d-m-Y H:i:s", $user->created_at);
                    $added_on   = date("d-m-Y h:i:s A", strtotime($user->added_on ));
                 // $added = date('d-M-Y g:i A', strtotime($d->created_at));

                    

                switch ($user->status) {
                    case '1':
                        $st = "COMPLETE";
                         $file_arr = explode("||",$user->uploads_doc);
                        $fl = '';    
                            foreach ($file_arr as $a) 
                            {
                                 if (count($a) > 0) 
                                    {
                                       $im = explode(",",$a);
                                         $fl .= "(".base_url().'uploads/horoscope_matching/'.$im[0].")".','; 
                                    }
                            }
                        break;
                    case '2':
                        $st = "CANCEL";
                         $fl = '';    

                        break;
                    case '3':
                        $st = "CANCEL";
                         $fl = '';    
                        break;
                    case '4':
                        $st = "Refunded";
                         $fl = '';    
                        break;

                    default:
                        $st = "PENDING";
                         $fl = '';    

                        break;
                }

                

                  switch ($user->refund_status) {
                    case '1':
                    $refund_status = "Yes";
                    $refund_amount = $user->refund_amount;
                    $refund_trxn_id = $user->refund_trxn_id;
                    $refund_date  = date("d-m-Y h:i:s A", strtotime($user->refund_date));
                        break;
                   
                    default:
                    $refund_status = "No";
                    $refund_amount = "-";
                    $refund_trxn_id ="-";
                    $refund_date  = "-";

                        break;
                }

        

                    $query = 'SELECT * FROM `admin` WHERE `id`="'.$user->refund_by.'"';
                    $refund_by = $this->d_m->get_all_result_array($query,'single_row','','');
                    $query3 = 'SELECT * FROM `user` WHERE `id`="'.$user->user_id.'"';
                    $users = $this->d_m->get_all_result_array($query3,'single_row','','');
                
                    $data[] = array(
                        "#" => $i,

                    "booking_type"=>"Match Making Booking",
                    "name"=>$users['name'],
                    "email"=>$users['email'],
                    "mobile"=>$users['phone'],
                    "boy_name"=>$user->boy_name,
                    "boy_dob"=>date("d/m/Y", strtotime($user->boy_dob)),
                    "boy_tob"=>date('h:ia', strtotime($user->boy_tob)),
                    "boy_pob"=>$user->boy_pob,
                    "girl_name"=>$user->girl_name,
                    "girl_dob"=>date("d/m/Y", strtotime($user->girl_dob)),
                    "girl_tob"=>date('h:ia', strtotime($user->girl_tob)),
                    "girl_pob"=>$user->girl_pob,
                    "fl"=>$fl,
                    "trxn_mode"=>$user->trxn_mode,
                    "trxn_id"=>$user->trxn_id,
                    "currency"=>$user->currency,
                    "total_amount"=>$user->total_amount,
                    "wallet_amount"=>$user->wallet_amount,
                    "referral_amount"=>$user->referral_amount,
                    "tax_amount"=>$user->tax_amount,
                    "trxn_status"=>$user->trxn_status,
                    "method"=>$user->method,
                    "fee"=>$user->fee,
                    "tax"=>$user->tax,
                    "payment_method_email"=>$user->payment_method_email,
                    "payment_method_contact"=>$user->payment_method_contact,
                    "payment_gateway"=>$user->payment_gateway,
                    "payment_gateway"=>$user->payment_gateway,
                    "added_on"=>$added_on,
                    "status"=>$st,
                    "refund_status"=>$refund_status,
                    "refund_amount"=>$refund_amount,
                    "refund_trxn_id"=>$refund_trxn_id,
                    "refund_date"=>$refund_date,

                    );
                    $i++;
                }
            
                    $string_file = date("d-m-Y h:i:s A");
               
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=\"match_making_" . $string_file . ".csv");
                header("Pragma: no-cache");
                header("Expires: 0");

                $handle = fopen('php://output', 'w');

                foreach ($data as $data) {
                    fputcsv($handle, $data);
                }
                fclose($handle);
                exit;
    }
       

        // Row per page
        $rowperpage = 30;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }


        // All records count
        $allcount = $this->count_total_enquiries();
        // Get records
        $s = $this->get_total_enquiries_paginate($rowno, $rowperpage);
// echo $this->db->last_que	ry(); die;
        // Pagination Configuration
         $uri = $this->uri->segment(3);
        $config['base_url'] = base_url() . "Horoscope_matching/matching/".$uri;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $template['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open']     = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']     = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']     = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']     = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']     = '<li class="page-item">';
        $config['next_tagl_close']     = '<span aria-hidden="true">&raquo;</span></li>';
        $config['prev_tag_open']     = '<li class="page-item">';
        $config['prev_tagl_close']     = '</li>';
        $config['first_tag_open']     = '<li class="page-item">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']     = '<li class="page-item">';
        $config['last_tagl_close']     = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        // Initialize
        $this->pagination->initialize($config);
        $template['page'] = "horoscope/all_booking";
        $template['page_title'] = "horoscope";
        $template['links'] = $this->pagination->create_links();
    
        $template['list'] = $s;
        // print_r($template['list']);die;
        $template['row'] = $rowno;
        $this->load->view('template', $template);
    }


    private function count_total_enquiries()
    {
      $uri = $this->uri->segment(3);
    
      if ($uri == "all_booking") 
      {
        $status = array(0,1,2,3,4);
      } 
      elseif ($uri == "new_booking") 
      {
         $status = array(0);
      }
      elseif ($uri == "complete_booking") 
      {
        $status = array(1);
      }
      elseif ($uri == "cancel_booking") 
      {
         $status = array(2, 3,4);
      }
      
        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['boy_name']) || isset($_GET['girl_name']) || isset($_GET['mobile'])) {


         
            if($_GET['boy_name'] != '')
            {
              $this->db->or_like('boy_name', $_GET['boy_name']);
            }
            if($_GET['girl_name'] != '')
            {
              $this->db->or_like('girl_name', $_GET['girl_name']);
            }
            if($_GET['start_date'] != '')
            {
               $this->db->where('DATE(added_on) >=', $_GET['start_date']);
            }
            if($_GET['end_date'] != '')
            {
             $this->db->where('DATE(added_on) <=', $_GET['end_date']);
            }
          
            
        }


        
        $this->db->select('*');
        $this->db->from('horoscope_matching_booking');
        // $this->db->where_in('booking_type',array(3));
        $this->db->where_in('status',$status);
        $this->db->group_by('id');
        $query = $this->db->get();
        return count($query->result());

    }


     private function get_total_enquiries_paginate($start = 0, $limit)
    {
      // print_r($start); die;

       $uri = $this->uri->segment(3);

      if ($uri == "all_booking") 
      {
        $status = array(0,1,2,3,4);
      } 
      elseif ($uri == "new_booking") 
      {
         $status = array(0);
      }
      elseif ($uri == "complete_booking") 
      {
        $status = array(1);
      }
      elseif ($uri == "cancel_booking") 
      {
         $status = array(2, 3,4);
      }
      
           if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['boy_name']) || isset($_GET['girl_name']) || isset($_GET['mobile'])) {
            // $first_date = date('Y-m-d', strtotime($_GET['start_date']));
            // $second_date = date('Y-m-d', strtotime($_GET['end_date']));;
          
            if($_GET['boy_name'] != '')
            {
              $this->db->or_like('boy_name', $_GET['boy_name']);
            }
            if($_GET['girl_name'] != '')
            {
              $this->db->or_like('girl_name', $_GET['girl_name']);
            }
            if($_GET['start_date'] != '')
            {
               $this->db->where('DATE(added_on) >=', $_GET['start_date']);
            }
            if($_GET['end_date'] != '')
            {
             $this->db->where('DATE(added_on) <=', $_GET['end_date']);
            }
           

            
        }

         if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        
        $this->db->select('*');
        $this->db->from('horoscope_matching_booking');
        // $this->db->where_in('booking_type',array(3));
        $this->db->where_in('status',$status);
        
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
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
                "status"=>4,
                );
                $create = $this->d_m->get_all_result($data,'update','horoscope_matching_booking',array('id'=>$booking_id));
               if ($create) {
                    $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success')); 
                    //redirect("speedhuntson/orders_for_equipment");  
                     redirect($this->agent->referrer());
                }
              }
        }


        public function image_pdf_data()
        {
              if ($_POST) {
                $dt = $_POST;
                $images = [];
                    if (isset($dt['confirm'])) {
                        $files = $_FILES;
                        $count = count($_FILES['image']['name']);
                        for ($i = 0; $i < $count; $i++) {
                            $_FILES['image']['name'] = time() . $files['image']['name'][$i];
                            $_FILES['image']['type'] = $files['image']['type'][$i];
                            $_FILES['image']['tmp_name'] = $files['image']['tmp_name'][$i];
                            $_FILES['image']['error'] = $files['image']['error'][$i];
                            $_FILES['image']['size'] = $files['image']['size'][$i];
                            $config['upload_path'] = 'uploads/horoscope_matching/';
                            $config['allowed_types'] = 'pdf|doc|gif|jpg|png|jpeg';
                            $config['max_size'] = '2000000';
                            $config['remove_spaces'] = true;
                            $config['overwrite'] = false;
                            $config['max_width'] = '';
                            $config['max_height'] = '';
                            $n =$_FILES['image']['type'];

                        $dep = explode('/', $n);
                        
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                            echo $this->upload->display_errors();
                        }
                        $fileName = $this->upload->data('file_name');
                          $images[] = $fileName.",".$dep[1];
                        // $images[] = $fileName;
                        }
                        if(!empty($images)){
                            $this->db->where('id',$dt['id']);
                            $this->db->update('horoscope_matching_booking',['uploads_doc'=>implode('||',$images)]);
                            $this->session->set_flashdata('message', array('message' => 'Update successfully', 'class' => 'success'));
                        }else{
                            $this->session->set_flashdata('message', array('message' => 'Something went wrong.You did not select any file.', 'class' => 'danger'));
                        }
                        redirect($this->agent->referrer());
                    }
              }
        }

        public function transaction_details()
        {
            $transaction_id = trim($this->input->post('transaction_id'));

            $transaction_data = $this->db->where('id',$transaction_id)->get('horoscope_matching_booking')->result_array();

            echo json_encode($transaction_data);
        }



    //  public function image_details()
    // {
    //     $booking_id = trim($this->input->post('booking_id'));

    //     // $booking_data = $this->db->where('id',$booking_id)->get('booking')->result_array();
    //     $booking_data = $this->db->where('id',$booking_id)->get('booking')->row();
    //     $image = explode('|', $booking_data->images);
    //     // print_r($image);

    //     foreach ($image as $key) {
    //         echo "<a href='".base_url('uploads/video_attachment_by_patient')."/".$key."' download><img src='".base_url('uploads/video_attachment_by_patient')."/".$key."' height='200px' width='200px'></a>&nbsp;&nbsp;";
    //     }
  
    // }


      public function cancel_booking_id()
    {
        //print_r($_POST);die;
        if ($_POST) {   
        $cancel_id =  $this->input->post("cancel_id");
      
        $data = array
        (
        "status"=>3,
        "cancel_by_id"=>$_SESSION['id']
        );
        //echo $data;die;
        $create = $this->d_m->get_all_result($data,'update','horoscope_matching_booking',array('id'=>$cancel_id));
        echo $this->db->last_query();       
      }
    
    }



    public function confirm_booking($id)
    {
        $this->db->where("id",$id);
        $this->db->update('horoscope_matching_booking',['status'=>1]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Done.', 'class' => 'success'));
          $this->send_mail_order($id);

         redirect($_SERVER['HTTP_REFERER']);
          // redirect($this->agent->referrer());
    }





public function send_mail_order($id ='',$bcc_email = '' ,$bcc_line = '',$fil_package_deatils = '')
    {
        // print_r($id); die;

    $get_booking_detail = $this->db->get_where("horoscope_matching_booking",array("id"=>$id))->row();
    $user_detail = $this->db->get_where("user",array("id"=>$get_booking_detail->user_id))->row();
    $sum_total = $get_booking_detail->total_amount;
    $sms_message = "A match making report will be genrated and send to your registered email id and you can also check your reports in app!";
    // $this->send_sms($user_detail->phone,$sms_message,$user_detail->country_code);
    
        $title11 = "Your making report report is send successfully!";

    $message1 = "A match making report will be genrated and send to your registered email id and you can also check your reports in app";
    $selected_android_user1 = array();
      if ($user_detail->notification_config == 1) 
    {
      // print_r("expression"); die;
      if($user_detail->device_type == 'android')
      {   
          if($user_detail->device_token!='abc')
          {
              array_push($selected_android_user1, $user_detail->device_token);
          }
          
      }
      elseif ($user_detail->device_type == 'ios') 
      {
          //$this->w_m->send_ios_notification($user_detail->device_token,$message1,$key->booking_mode);
      }
      if(count($selected_android_user1))
      {
          $notification_type1 = "text";
          $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title11.'","msg":"'.$message1.'","type":"no"}';
          //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
          $message2 = array(
                  'body' => $message1,
                  'title' => $title11,
                  'sound' => 'Default'
              );
          $this->sendMessageThroughFCM($selected_android_user1,$message2);
      }

       $insert_array = array('user_id' => $user_detail->id,
                              'for_' => "user",
                              'title' => $title11,
                              'notification' => $message1,
                              'type' => 'horoscope_matching',
                              'booking_id' => $id,
                              'added_on' => date('Y-m-d H:i:s')
                              );
        $insert = $this->db->insert('user_notification',$insert_array);

    }


    $settings = $this->Gems_booking_model->get_settings();
    $support_email =  $settings->support_email;
    
    // $file_arr = explode("||",$get_booking_detail->uploads_doc);
    //  if(!empty($get_booking_detail->uploads_doc)){
    //     foreach ($file_arr as $a) {
    //         $im = explode(",",$a);
    //         $fil_package_deatils = 'uploads/varshhal_pdfs/'.$im[0];
    //         // $fil_package_deatils = $im[0];
    //     }
    // }
    // print_r($fil_package_deatils); die;

     // $fil_package_deatils = base_url('/')."uploads/varshhal_pdfs/".$product->image;
    
    $subject = "Making Report booking added successfully!";

if ($settings->facebook_link)
{
$facebook = '<a href="'.$settings->twitter_link.'" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="facebook" src="https://ci4.googleusercontent.com/proxy/OdfuUga4ndDEHFyW6v2aCVjn7QxSHtfjvDowQ6BYpfqnE6xNDVO5PfjPyLZHEQjXBJw7xsIZ5oxLtDdSj19o8BRh7TZbWkULuWVVi9mX1UxkpPHbm-QR5cXDQakMC8vpnXMmCM4LNEPNzfyr-EHKQ_W60gPrmBNEXLNr4g=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Facebook.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
}
else
{
$facebook = '';
}

if ($settings->twitter_link)
{
$twitter = '<a href="'.$settings->twitter_link.'" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="twitter" src="https://ci5.googleusercontent.com/proxy/tezSUjJj4fldIi0UXQ7R1hMi5nCZ_XHUzoRGLksVPkD5rc5UOOtOIFjvM1lsU9OYyz8fqn5lnf0c1X3j69RvccB33B5IZKesVzTr8HIBNr55HrofBYcn5nBp4N4aqQAcrTG7DhRq76P0c6Si8EGwAbWIboQdr-ensOK1=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Twitter.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
}
else
{
$twitter = '';
}


if ($settings->instagram_link)
{
$instagram = '<a href="'.$settings->instagram_link.'" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="instagram" src="https://ci6.googleusercontent.com/proxy/gzxYa0OnFnJh9yh0cTzXyAqCsr5lWZyWX6sbRuUIdIdmTa5gVAP98LmHEt42hW-thQI-cK1u5S7OcRcTDd37iY_exZrcCKMwRHrqqF6LByuN8jUoD7AbBmNV2UApKdwjhPzcwiQ0iUJBstPQCDA6R6ck7N4WAOUtOOpmwMw=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Instagram.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
}
else
{
$instagram = '';
}


if ($settings->youtube_link)
{

$youtube_link = '<a href="'.$settings->youtube_link.'" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="youtube" src="'.base_url('uploads/email_temp/youtube.png').'" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
}
else
{
$youtube_link= '';
}

if ($settings->website_link)
{
$kundali_exp= '<a href="'.$settings->website_link.'" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:0;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="kundaliexpert" src="'.base_url('uploads/email_temp/smalllogo.png').'" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
}
else
{
$kundali_exp= '';
}


$mail_message = '<table style="margin:0;background:#f3f3f3;background-color:#e96125;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;padding:0;padding-left:8px;padding-right:8px;text-align:left;vertical-align:top;width:100%">
   <tbody>
      <tr style="padding:0;text-align:left;vertical-align:top">
         <td align="center" valign="top" style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <center style="min-width:580px;width:100%">
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#e96125;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:36px;margin-top:36px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <center style="min-width:580px;width:100%"><img alt="Kundali Expert Logo" src="https://ci3.googleusercontent.com/proxy/-xQwghvjl49PiaQySEtWx5OXxOEWh2p8l55lkUZO_5mmVyxxl9b2QSAjL445L9v6gYeoLZ5GDV6VCch05jjycrfOLlnR6798nlzPZewyIcMzyA=s0-d-e1-ft#http://139.59.76.223/kundali_expert/uploads/email_temp/logo.png" style="Margin:0 auto;clear:both;display:block;float:none;height:38px;margin:0 auto;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto" class="CToWUd"> </center>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <h6 style="margin:0;margin-bottom:0;color:inherit;font-family:sans-serif;font-size:18px;font-weight:400;line-height:1.3;padding:0;text-align:left;word-wrap:normal">Hi '.$user_detail->name.' </h6>
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:normal;margin-top:12px;padding:0;text-align:left">Thank you for booking with Kundali Expert. Your match making booking details are given below.</p>
                                                   <p style="margin:0;margin-bottom:0;color:#e96125;font-family:sans-serif;font-size:12px;font-weight:400;line-height:normal;margin-top:12px;padding:0;text-align:left"><mark><i> A match making report will be genrated and send to your registered email id and you can also check your reports in app.</i></mark> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;background-color:#fcfcfc;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:20px;padding-left:32px;padding-right:32px;padding-top:20px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:center"><span style="color:#333;font-size:16px;font-weight:500;margin-left:5px;vertical-align:middle">Horoscope Match Making Successfully Added</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Boy Details</span></p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Name</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.$get_booking_detail->boy_name.'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Date of birth</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.date('d m Y', strtotime($get_booking_detail->boy_dob)).'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Time of birth</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.date('H:ia', strtotime($get_booking_detail->boy_tob)).'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Place of birth</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.$get_booking_detail->boy_pob.'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Girl Details</span></p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Name</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.$get_booking_detail->girl_name.'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Date of birth</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.date('d m Y', strtotime($get_booking_detail->girl_dob)).'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Time of birth</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.date('H:ia', strtotime($get_booking_detail->girl_tob)).'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Place of birth</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">'.$get_booking_detail->girl_pob.'</span> </p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <div style="border-top:1px solid #eee;margin-bottom:16px;margin-top:16px"></div>
                                                   <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                      <tbody>
                                                         <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="margin:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.3;padding:0;text-align:left">Total Amount</th>
                                                            <td style="margin:0;border-collapse:collapse!important;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.3;padding:0;text-align:right;vertical-align:top;word-wrap:break-word">???'.$sum_total.' </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                   <div style="border-top:1px dashed #dbdbdb;margin-bottom:16px;margin-top:16px"></div>
                                                   <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                      <tbody>
                                                         <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="margin:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;text-align:left">Online Cash</th>
                                                            <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;padding-bottom:8px;text-align:right;vertical-align:top;word-wrap:break-word">- ???'.$get_booking_detail->from_payment_gateway.' </td>
                                                         </tr>
                                                         <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="margin:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;text-align:left">Wallet Cash</th>
                                                            <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;padding-bottom:8px;text-align:right;vertical-align:top;word-wrap:break-word">- ???'.$get_booking_detail->wallet_amount.' </td>
                                                         </tr>
                                                         <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="margin:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;text-align:left">Referral Cash</th>
                                                            <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;padding-bottom:8px;text-align:right;vertical-align:top;word-wrap:break-word">- ???'.$get_booking_detail->referral_amount.' </td>
                                                         </tr>
                                                         <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="margin:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;text-align:left">Discount Cash</th>
                                                            <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;padding-bottom:0;text-align:right;vertical-align:top;word-wrap:break-word">- ???'.$get_booking_detail->discount_amount.' </td>
                                                         </tr>
                                                         <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="margin:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;text-align:left">Tax</th>
                                                            <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:500;line-height:1.3;padding:0;padding-bottom:0;text-align:right;vertical-align:top;word-wrap:break-word">- ???'.$get_booking_detail->tax_amount.' </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:564px"></th>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"></td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.4;margin-top:5px;padding:0;text-align:left">Have a question?</p>
                                                   <p style="margin:0;margin-bottom:0;color:#535353;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:8px;padding:0;text-align:left">Feel free to shoot an email at <span style="color:#e14a1d"><a href="mailto:'.$settings->support_email.'" rel="noreferrer" target="_blank">'.$settings->support_email.'</a></span> or reach out to us via in-app support for any query or suggestion.</p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;background-color:#fcfcfc;border-bottom-left-radius:6px;border-bottom-right-radius:6px;border-top:1px solid #eee;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:left">Regards,</p>
                                                   <p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:5px;padding:0;text-align:left">Team '.$settings->title.'</p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.4;margin-top:5px;padding:0;text-align:left"></p>
                                                   <p style="margin:0;margin-bottom:0;color:#535353;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:8px;padding:0;text-align:left"> 
                                                   <p style="text-align: center;">We work for your profit</p>
                                                   <p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table align="center" style="margin:0 auto;background:#fefefe;background-color:#e96125;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:48px;margin-top:48px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important">
                  <tbody>
                     <tr style="padding:0;text-align:left;vertical-align:top">
                        <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                           <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tbody>
                                 <tr style="padding:0;text-align:left;vertical-align:top">
                                    <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:564px">
                                       <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                             <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left">
                                                   <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:center">'.$facebook.$twitter.$instagram.$youtube_link.$kundali_exp.'</p>
                                                </th>
                                                <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </th>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </center>
         </td>
      </tr>
   </tbody>
</table>';

// print_r($mail_message); die;

$subject = $subject;
$message = $mail_message;
$name = $user_detail->name;
// $email = $email;
// $name = "shubham";
// $email = "shubham.appslure@gmail.com";
$bcc_email = $bcc_email;
$bcc_line = $bcc_line;
$fil_package_deatils = $fil_package_deatils;
$google_email = 'kmstech88@gmail.com';
$oauth2_clientId = '594945680122-j0n9dut8lg8hatg3damodk0qm7efl0j2.apps.googleusercontent.com';
$oauth2_clientSecret = 'c0kwB7-ozK_x6PGkTrdNRb4r';
$oauth2_refreshToken = '1//0gS0TtUKm3eQnCgYIARAAGBASNwF-L9Ir_2B1Hl2XpV6jy2dr51SbVEQ2IPf1h1LuC6Xd0j0M2RZQWxFIykIws5efVUl7Q5-2iGQ';


$mail = new PHPMailer(TRUE);

try {
 
  $mail->setFrom($google_email, 'Kundali Expert');
  $mail->addAddress($user_detail->email, $name);
  // $mail->addAddress("shubham.appslure@gmail.com", "ddd");
  // if ($bcc_email)
  // {
  // $mail->addBcc($bcc_email, $bcc_line);
  // }
  $mail->WordWrap = 500;
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $message;
  // if ($fil_package_deatils)
  // {

     $file_arr = explode("||",$get_booking_detail->uploads_doc);
     if(!empty($get_booking_detail->uploads_doc)){
        foreach ($file_arr as $a) {
            $im = explode(",",$a);
     // print_r($im ); die;
            $fil_package_deatils1 = 'uploads/horoscope_matching/'.$im[0];
            // $fil_package_deatils = $im[0];
            $path = '/var/www/html/kundali_expert/'.$fil_package_deatils1;
            $mail->addAttachment($path);
        }
    }
  // print_r($fil_package_deatils1); die;
    // echo $fil_package_deatils = '/var/www/html/kundali_expert'.'/uploads/class_package/1587185543.pdf';
  // }
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
  // print_r($mail); die;
 
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
  // if ($send) {
  //   echo"sss"; die;
  // } else {
  //  echo"nnnn"; die;
  // }
  

    }
    catch (Exception $e)
    {
    $e->errorMessage();
    }
    catch (\Exception $e)
    {
     $e->getMessage();
    }

}


public function send_sms($mobile,$sms_message,$country_code)
    {

        // $mobile = 6393953549;
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?mobiles=".$mobile."&authkey=290852AOOLo80J5d5fabd8&route=4&sender=KUNDEX&message=".$sms_message."&country=".$country_code
          ,
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
        return true;
    }


    public function sendMessageThroughFCM($registatoin_ids, $message) 
    {
        // $settings = $this->get_settings();
            $settings = $this->Gems_booking_model->get_settings();

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








}
