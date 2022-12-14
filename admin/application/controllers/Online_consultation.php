<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_consultation extends CI_Controller{

	function __construct () {
		parent::__construct();
		$this->load->model("order_modal","d_m");
		$this->load->library('encryption');
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->library('user_agent');
		$this->load->library('session');
        if(!$this->session->userdata('logged_in')) { 
            redirect(base_url());
        }
	}

  

//plan_all_booking

	public function all_booking()
	{
		
        $config = array();
        $config["base_url"] = base_url() . "Online_consultation/all_booking";
        $config["total_rows"] = $this->d_m->get_count_online_all_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_online_all_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
      // print_r($template['list']);die;
        $template['page'] = "Online_consultation/all_booking";
        $template['page_title'] = "plan_all_booking";
        $this->load->view('template',$template);
	}

//plan_complete_booking

	public function complete_booking()
	{
		
        $config = array();
        $config["base_url"] = base_url() . "Online_consultation/complete_booking";
        $config["total_rows"] = $this->d_m->get_count_online_complete_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_online_complete_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
      //  print_r($template['list']);die;
        $template['page'] = "Online_consultation/complete_booking";
        $template['page_title'] = "plan_complete_booking";
        $this->load->view('template',$template);
	}



	//plan_cancel_booking

	public function cancel_booking()
	{
		
        $config = array();
        $config["base_url"] = base_url() . "Online_consultation/cancel_booking";
        $config["total_rows"] = $this->d_m->get_count_online_cancel_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_online_cancel_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
     // echo $this->db->last_query();die;
        $template['page'] = "Online_consultation/cancel_booking";
        $template['page_title'] = "cancel_booking";
        $this->load->view('template',$template);
	}

	//plan_new_booking

	public function new_booking()
	{
		
        $config = array();
        $config["base_url"] = base_url() . "Online_consultation/new_booking";
        $config["total_rows"] = $this->d_m->get_count_online_new_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_online_new_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
      //  print_r($template['list']);die;
        $template['page'] = "Online_consultation/new_booking";
        $template['page_title'] = "new_booking";
        $this->load->view('template',$template);
	}




    //Explode All Panned Doctor

     public function export_online_doctor()
    {
       $uri = $this->uri->segment(3);
      // print_r($uri);die;
       if($uri == 'new_booking')
       {
          //  $status = 0;
            $query = 'SELECT * FROM `booking` where status = 0  AND `booking_type` IN(1, 2) ORDER BY `added_on` DESC';
       }
       elseif($uri == 'all_booking')
       {
            $query = 'SELECT * FROM `booking`  WHERE `booking_type` IN(1, 2) ORDER BY `added_on` DESC';
       }
       elseif($uri == 'cancel_booking')
       {
            $query = 'SELECT * FROM `booking` WHERE `status` IN(2, 3) AND `booking_type` IN(1, 2) ORDER BY `added_on` DESC';
       }
       elseif($uri == 'complete_booking')
       {
            $query = 'SELECT * FROM `booking` where status = 1 AND `booking_type` IN(1, 2) ORDER BY `added_on` DESC';
       }

        
        $details=  $this->d_m->get_all_result_array($query,'select','','');
       // echo $this->db->last_query(); die;
        //print_r($details);die;


     $data[] = array("#"," Online Mode"," Booking Type"," Booking For","User Name","User Mobile","User Email","Member Name","Member DOB","Name","Gender","Dob","Address","Problem","Booking Date","Booking Time","Total Amount","discount_amount","tax_amount","Trxn Status","Trxn Mode","Trxn Id","Refund Amount","Refund Trxn Id","Refund Date","Refund By","Status");
     
    $i=1;
    foreach($details as $user)
    {

         $query = 'SELECT * FROM `admin` WHERE `id`="'.$user['refund_by'].'"';
        $refund_by = $this->d_m->get_all_result_array($query,'single_row','','');
        $query3 = 'SELECT * FROM `user` WHERE `id`="'.$user['user_id'].'"';
        $users = $this->d_m->get_all_result_array($query3,'single_row','','');
        $query4 = 'SELECT * FROM `user_member` WHERE `id`="'.$user['member_id'].'"';
        $user_member = $this->d_m->get_all_result_array($query4,'single_row','','');

         $status ="";
        if ($user['status'] == 0) {
          $status = "New";
        }
        elseif($user['status'] == 1) 
        {
           $status = "complete";
        }
        elseif($user['status'] == 2) 
        {
            $status = "cancel by user";
        }
        elseif($user['status'] == 3) 
        {
            $status = "cancel by admin";
        }
        elseif($user['status'] == 4) 
        {
            $status = "refunded";
        }

           $data[] = array(
                "#" =>$i,
                "online_mode"=>$user['online_mode'],
                "booking_type"=>$user['booking_type'],
                "booking_for"=>$user['booking_for'],
                "u_name"=>$users['name'],
                "u_phone"=>$users['phone'],
                "u_email"=>$users['email'],
                "member_name"=>$user_member['member_name'],
                "member_gender"=>$user_member['member_gender'],
                "name"=>$user['name'],
                "gender"=>$user['gender'],
                "dob"=>$user['dob'],
                "pob_lat_long_address"=>$user['pob_lat_long_address'],
                "problem"=>$user['problem'],
                "booking_date"=>$user['booking_date'],
                "booking_time"=>$user['booking_time'],
             
                "total_amount"=>$user['total_amount'],
                "discount_amount"=>$user['discount_amount'],
                "tax_amount"=>$user['tax_amount'],
                "trxn_status"=>$user['trxn_status'],
                "trxn_mode"=>$user['trxn_mode'],
                "trxn_id"=>$user['trxn_id'],
                "refund_amount"=>$user['refund_amount'],
                "refund_trxn_id"=>$user['refund_trxn_id'],
                "refund_date"=>$user['refund_date'],
                "refund_by"=>$refund_by['username'],
                "status"=>$status,
          
              );
            $i++;
        }
        
    

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_online".$uri.".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }



	public function assign_docter_booking()
    {
      //print_r($_POST);die; 
      if ($_POST) {   
        $booking_id =  $this->input->post("booking_id");
        $doctor_id =  $this->input->post("doctor_id");
       // $ambulance = $this->db->where('id',$ambulance_id)->get('ambulance')->row();
        $assign_by =  $_SESSION['id'];
        $data = array
        (
        "assign_by"=>$assign_by,
        "assign_id"=>$doctor_id,
        "assign_time"=>date('Y-m-d H:i:s'),
        
        );
        $create = $this->d_m->get_all_result($data,'update','booking',array('id'=>$booking_id));
        echo $this->db->last_query();       
      }
    }

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
        $create = $this->d_m->get_all_result($data,'update','booking',array('id'=>$cancel_id));
        echo $this->db->last_query();       
      }
    
    }
    public function complete_booking_id()
    {
        //print_r($_POST);die;
        if ($_POST) {   
        $booking_ide =  $this->input->post("booking_ide");
      
        $data = array
        (
        "status"=>1,
        );
        //echo $data;die;
        $create = $this->d_m->get_all_result($data,'update','booking',array('id'=>$booking_ide));
        echo $this->db->last_query();       
      }
    
    }


     public function image_details()
    {
        $booking_id = trim($this->input->post('booking_id'));

        // $booking_data = $this->db->where('id',$booking_id)->get('booking')->result_array();
        $booking_data = $this->db->where('id',$booking_id)->get('booking')->row();
        $image = explode('|', $booking_data->images);
        // print_r($image);

        foreach ($image as $key) {
            echo "<a href='".base_url('uploads/video_attachment_by_patient')."/".$key."' download><img src='".base_url('uploads/video_attachment_by_patient')."/".$key."' height='200px' width='200px'></a>&nbsp;&nbsp;";
        }
  
    }


    public function refund_data()
    {
 // print_r($_POST);die; 
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
        $create = $this->d_m->get_all_result($data,'update','booking',array('id'=>$booking_id));
       if ($create) {
            $this->session->set_flashdata('message', array('message' => 'Refund Successfully','class' => 'success')); 
            redirect("Online_consultation/all_booking");  
        }
      }
    }




       public function online_booking($x='',$rowno = 1)
    {
        // print_r($rowno); die;

         if (isset($_GET['get_export_data'])) {
             $data[] = array("#"," Booking Type"," Online Mode"," Booking For"," Booking Time"," Booking Date","Booking Minutes","Name","Gender","Dob","Mode of payment","Transaction ID","currency","Amount","From wallet amount","From referral amount","Tax amount","Transaction Status","Payment Method","Payment gateway fee","Payment gateway tax","Payment gateway email","Payment gateway mobile","Payment gateway name","Added on system date","Status","Refund Status ","Refund Amount","Refund Transaction ID","Refund Date");
                $acounts = $this->get_total_enquiries_paginate(0, '');
                $i = 1;
                foreach ($acounts as $user) {
                    $booking_date = date("d-m-Y", strtotime($user->booking_date));
                    $dob = date("d-m-Y", strtotime($user->dob));
                    $created_at = date("d-m-Y", strtotime($user->created_at));
                    // $created_at  = date("d-m-Y H:i:s", $user->created_at);
                    $added_on   = date("d-m-Y h:i:s A", strtotime($user->added_on ));
                 // $added = date('d-M-Y g:i A', strtotime($d->created_at));
                switch ($user->status) {
                    case '1':
                        $st = "COMPLETE";
                        break;
                    case '2':
                        $st = "CANCEL";
                        break;
                    case '3':
                        $st = "CANCEL";
                        break;
                    case '4':
                        $st = "refunded";
                        break;

                    default:
                        $st = "PENDING";

                        break;
                }

                 switch ($user->booking_type) {
                    case '1':
                        $bt = "Ask for question";
                        break;
                    case '2':
                        $bt = "Online Consultation";
                        break;
                   
                    default:
                        $bt = "New";

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
                    $query4 = 'SELECT * FROM `user_member` WHERE `id`="'.$user->member_id.'"';
                    $user_member = $this->d_m->get_all_result_array($query4,'single_row','','');


                    $data[] = array(
                        "#" => $i,

                    "booking_type"=>$bt,
                    "online_mode"=>$user->online_mode,
                    "booking_for"=>$user->booking_for,
                    "booking_time"=>$user->booking_time,
                    "booking_date"=>$booking_date,
                    "total_minutes"=>$user->total_minutes,
              
                    "name"=>$user->name,
                    "gender"=>$user->gender,
                    "dob"=>$dob,
                    "trxn_mode"=>$user->trxn_mode,
                    "trxn_id"=>$user->trxn_id,
                    "currency"=>$user->currency,
                    "total_amount"=>$user->total_amount,
                    "wallet_amount"=>$user->wallet_amount,
                    "referral_amount"=>$user->referral_amount,
                    "tax_amount"=>$user->tax_amount,
                    "trxn_status"=>$user->trxn_status,
                    // "created_at"=>$created_at,
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
                header("Content-Disposition: attachment; filename=\"online_booking_" . $string_file . ".csv");
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
// echo $this->db->last_query(); die;
        // Pagination Configuration
         $uri = $this->uri->segment(3);
        $config['base_url'] = base_url() . "online_consultation/online_booking/".$uri;
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
        $template['page'] = "Online_consultation/all_booking";
        $template['page_title'] = "booking_test";
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
         $status = array(2, 3);
      }
      
        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['dob']) || isset($_GET['gender'])) {


          if($_GET['gender'] != '')
            {
              $this->db->or_like('gender', $_GET['gender']);
            }
            if($_GET['name'] != '')
            {
              $this->db->or_like('name', $_GET['name']);
            }
            if($_GET['dob'] != '')
            {
              $this->db->or_like('dob', $_GET['dob']);
            }
            if($_GET['start_date'] != '')
            {
               $this->db->where('DATE(booking_date) >=', $_GET['start_date']);
            }
            if($_GET['end_date'] != '')
            {
             $this->db->where('DATE(booking_date) <=', $_GET['end_date']);
            }
          
            
        }


        
        $this->db->select('*');
        $this->db->from('booking');
        $this->db->where_in('booking_type',array(1, 2));
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
         $status = array(2, 3);
      }
      
           if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['dob']) || isset($_GET['gender'])) {
            // $first_date = date('Y-m-d', strtotime($_GET['start_date']));
            // $second_date = date('Y-m-d', strtotime($_GET['end_date']));;
            if($_GET['gender'] != '')
            {
              $this->db->or_like('gender', $_GET['gender']);
            }
            if($_GET['name'] != '')
            {
              $this->db->or_like('name', $_GET['name']);
            }
            if($_GET['dob'] != '')
            {
              $this->db->or_like('dob', $_GET['dob']);
            }
            if($_GET['start_date'] != '')
            {
               $this->db->where('DATE(booking_date) >=', $_GET['start_date']);
            }
            if($_GET['end_date'] != '')
            {
             $this->db->where('DATE(booking_date) <=', $_GET['end_date']);
            }
           

            
        }

         if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        
        $this->db->select('*');
        $this->db->from('booking');
        $this->db->where_in('booking_type',array(1, 2));
        $this->db->where_in('status',$status);
        
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }


    public function get_supervisor()
    {
        if ($_POST) 
        {
           $query2 = "SELECT * FROM `booking` WHERE `id` = '".$_POST['booking_id']."'";
           $list = $this->db->query($query2)->row();
           if ($list) 
           {
               $puja_details = $this->db->query("SELECT b.`name`,b.`id` FROM `puja_location_table` a JOIN `puja_location` b ON b.id = a.location_id WHERE a.id='".$list->puja_id."'")->row();
               if (count($puja_details) > 0) 
               {
                    $query3 = "SELECT * FROM `supervisor` WHERE `status` = '1' AND `location` = '".$puja_details->id."'";
                   $lis2 = $this->db->query($query3)->result();
                   if ($lis2) 
                   {
                       echo json_encode($lis2);
                   }
                   else
                   {
                       echo 0; 
                   }
               }
               else
               {
                    echo 0; 
               }
               
           }
           else
           {
               echo 0; 
           }
        }
        else
        {
            echo 0;
        }
    }

    public function get_priest()
    {
        if ($_POST) 
        {
           $query2 = "SELECT * FROM `booking` WHERE `id` = '".$_POST['booking_id']."'";
           $list = $this->db->query($query2)->row();
           if ($list) 
           {
               $puja_details = $this->db->query("SELECT b.`name`,b.`id` FROM `puja_location_table` a JOIN `puja_location` b ON b.id = a.location_id WHERE a.id='".$list->puja_id."'")->row();
               if (count($puja_details) > 0) 
               {
                    $query3 = "SELECT * FROM `priest` WHERE `status` = '1' AND `location` = '".$puja_details->id."'";
                   $lis2 = $this->db->query($query3)->result();
                   if ($lis2) 
                   {
                       echo json_encode($lis2);
                   }
                   else
                   {
                       echo 0; 
                   }
               }
               else
               {
                    echo 0; 
               }
               
           }
           else
           {
               echo 0; 
           }
        }
        else
        {
            echo 0;
        }
    }

    public function assign_supervisor()
    {
        $check_already = $this->db->get_where("booking",array("id"=>$_POST['booking_id']))->row();

        if (count($check_already) > 0) 
        {
            if ($check_already->supervisor_id == 0) 
            {
                $assign_by_supervisor = json_encode(array("by"=>"admin","date"=>date('Y-m-d H:i:s')));
                $this->db->where("id",$_POST['booking_id']);
                $this->db->update("booking",array("supervisor_id"=>$_POST['supervisor_id'],"accepted_date"=>date('Y-m-d H:i:s'),"assign_by_supervisor"=>$assign_by_supervisor));
                $array = array("booking_id"=>$_POST['booking_id'],
                               "supervisor_id"=>$_POST['supervisor_id'],
                               "added_on"=>date("Y-m-d H:i:s"),
                               "assign_date"=>date("Y-m-d H:i:s"),
                               "type"=>'assign',
                               "assign_reassign_by"=>"admin");
                $this->db->insert("booking_assign_history",$array);
                $this->common_notification($_POST['booking_id'],'accepted_by_supervisor');
                $this->session->set_flashdata('message', array('message' => 'Supervisor Assigned Successfully','class' => 'success'));      
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Supervisor Already assinged','class' => 'danger')); 
            }
              
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Booking not found','class' => 'danger')); 
        }
        redirect($this->agent->referrer());
    }

    public function reassign_supervisor()
    {
        $check_already = $this->db->get_where("booking",array("id"=>$_POST['booking_id']))->row();

        if (count($check_already) > 0) 
        {
            if ($check_already->supervisor_id != 0) 
            {
                $assign_by_supervisor = json_encode(array("by"=>"admin","date"=>date('Y-m-d H:i:s')));
                $from_supervisor_id = $check_already->supervisor_id;
                $this->db->where("id",$_POST['booking_id']);
                $this->db->update("booking",array("supervisor_id"=>$_POST['supervisor_id'],"accepted_date"=>date('Y-m-d H:i:s'),"assign_by_supervisor"=>$assign_by_supervisor));
                $array = array("booking_id"=>$_POST['booking_id'],
                               "supervisor_id"=>$_POST['supervisor_id'],
                               "added_on"=>date("Y-m-d H:i:s"),
                               "assign_date"=>date("Y-m-d H:i:s"),
                               "type"=>'reassign',
                               "assign_reassign_by"=>"admin",
                               "from_supervisor_id"=>$from_supervisor_id);
                $this->db->insert("booking_assign_history",$array);
                $this->common_notification($_POST['booking_id'],'accepted_by_supervisor');
                $this->session->set_flashdata('message', array('message' => 'Supervisor Assigned Successfully','class' => 'success'));      
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Supervisor Already assinged','class' => 'danger')); 
            }
              
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Booking not found','class' => 'danger')); 
        }
        redirect($this->agent->referrer());
    }

    public function assign_priest()
    {
        $check_already = $this->db->get_where("booking",array("id"=>$_POST['booking_id']))->row();

        if (count($check_already) > 0) 
        {
            if ($check_already->priest_id == 0) 
            {
                $assign_by_priest = json_encode(array("by"=>"admin","date"=>date('Y-m-d H:i:s')));
                $this->db->where("id",$_POST['booking_id']);
                $this->db->update("booking",array("priest_id"=>$_POST['priest_id'],"accepted_date"=>date('Y-m-d H:i:s'),"assign_by_priest"=>$assign_by_priest));
                $array = array("booking_id"=>$_POST['booking_id'],
                               "priest_id"=>$_POST['priest_id'],
                               "added_on"=>date("Y-m-d H:i:s"),
                               "assign_date"=>date("Y-m-d H:i:s"),
                               "type"=>'assign',
                               "assign_reassign_by"=>"admin");
                $this->db->insert("booking_assign_history",$array);
                $this->common_notification($_POST['booking_id'],'assigned_notification');
                $this->session->set_flashdata('message', array('message' => 'Priest Assigned Successfully','class' => 'success'));      
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Priest Already assinged','class' => 'danger')); 
            }
              
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Booking not found','class' => 'danger')); 
        }
        redirect($this->agent->referrer());
    }

    public function reassign_priest()
    {
        $check_already = $this->db->get_where("booking",array("id"=>$_POST['booking_id']))->row();

        if (count($check_already) > 0) 
        {
            if ($check_already->priest_id != 0) 
            {
                $from_priest_id = $check_already->priest_id;
                $assign_by_priest = json_encode(array("by"=>"admin","date"=>date('Y-m-d H:i:s')));
                $this->db->where("id",$_POST['booking_id']);
                $this->db->update("booking",array("priest_id"=>$_POST['priest_id'],"accepted_date"=>date('Y-m-d H:i:s'),"assign_by_priest"=>$assign_by_priest));
                $array = array("booking_id"=>$_POST['booking_id'],
                               "priest_id"=>$_POST['priest_id'],
                               "added_on"=>date("Y-m-d H:i:s"),
                               "assign_date"=>date("Y-m-d H:i:s"),
                               "type"=>'reassign',
                               "assign_reassign_by"=>"admin",
                               "from_priest_id"=>$from_priest_id);
                $this->db->insert("booking_assign_history",$array);
                $this->common_notification($_POST['booking_id'],'reassign_notification',$check_already->priest_id);
                $this->session->set_flashdata('message', array('message' => 'Priest Reassigned Successfully','class' => 'success'));      
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Priest Already assinged','class' => 'danger')); 
            }
              
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Booking not found','class' => 'danger')); 
        }
        redirect($this->agent->referrer());
    }

    public function common_notification($id,$method,$completed_on='')
    {
        $url = base_url('notification_to/common_notification');
        $curl = curl_init();                
        $post['id'] = $id; // our data todo in received
        $post['method'] = $method; // our data todo in received
        $post['completed_on'] = $completed_on; // our data todo in received
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