<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offline_consultation extends CI_Controller{

	function __construct () {
		parent::__construct();
		$this->load->model("Doctor_doorstep_model","d_m");
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
        $config["base_url"] = base_url() . "offline_consultation/all_booking";
        $config["total_rows"] = $this->d_m->get_count_offline_all_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_offline_all_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
      // print_r($template['list']);die;
        $template['page'] = "offline_consultation/all_booking";
        $template['page_title'] = "plan_all_booking";
        $this->load->view('template',$template);
	}

//plan_complete_booking

	public function complete_booking()
	{
        $config = array();
        $config["base_url"] = base_url() . "offline_consultation/complete_booking";
        $config["total_rows"] = $this->d_m->get_count_offline_complete_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_offline_complete_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
      //  print_r($template['list']);die;
        $template['page'] = "offline_consultation/complete_booking";
        $template['page_title'] = "plan_complete_booking";
        $this->load->view('template',$template);
	}



	//plan_cancel_booking

	public function cancel_booking()
	{
		
        $config = array();
        $config["base_url"] = base_url() . "offline_consultation/cancel_booking";
        $config["total_rows"] = $this->d_m->get_count_offline_cancel_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_offline_cancel_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
     // echo $this->db->last_query();die;
        $template['page'] = "offline_consultation/cancel_booking";
        $template['page_title'] = "cancel_booking";
        $this->load->view('template',$template);
	}

	//plan_new_booking

	public function new_booking()
	{
		
        $config = array();
        $config["base_url"] = base_url() . "offline_consultation/new_booking";
        $config["total_rows"] = $this->d_m->get_count_offline_new_booking('booking');
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
        $template['list'] = $this->d_m->get_pagination_offline_new_booking($config["per_page"],$template['page'],'booking');
        $template["links"] = $this->pagination->create_links();
      //  print_r($template['list']);die;
        $template['page'] = "offline_consultation/new_booking";
        $template['page_title'] = "new_booking";
        $this->load->view('template',$template);
	}




    //Explode All Panned Doctor

     public function export_offline_doctor()
    {
       $uri = $this->uri->segment(3);
      // print_r($uri);die;
       if($uri == 'new_booking')
       {
          //  $status = 0;
            $query = 'SELECT * FROM `booking` where status = 0  AND `booking_type` = 5 ORDER BY `added_on` DESC';
       }
       elseif($uri == 'all_booking')
       {
            $query = 'SELECT * FROM `booking`  WHERE `booking_type` = 5 ORDER BY `added_on` DESC';
       }
       elseif($uri == 'cancel_booking')
       {
            $query = 'SELECT * FROM `booking` WHERE `status` IN(2, 3) AND `booking_type` = 5 ORDER BY `added_on` DESC';
       }
       elseif($uri == 'complete_booking')
       {
            $query = 'SELECT * FROM `booking` where status = 1 AND `booking_type` = 5 ORDER BY `added_on` DESC';
       }

        
        $details=  $this->d_m->get_all_result_array($query,'select','','');
       // echo $this->db->last_query(); die;
        //print_r($details);die;


     $data[] = array("#","Patient Name","Patient Mobile","Patient Email","Problem","Online Mode","Name","Gender","Dob","Address","Area","Pincode","City State","Booking Date","Booking Time","Assign By","Assign Doctor","Cancel By","Assign Time","Cancel Time","Complete On","Coupan Code","Total Amount","Discount Amount/Percentage","Discount Amount","Tax Amount","Base Amount","Trxn Status","Trxn Mode","Trxn Id","Refund Amount","Refund Trxn Id","Refund Date","Refund By");
        
    $i=1;
    foreach($details as $user)
    {

          $query = 'SELECT * FROM `admin` WHERE `id`="'.$user['refund_by'].'"';
        $refund_by = $this->d_m->get_all_result_array($query,'single_row','','');


        $query3 = 'SELECT * FROM `patient` WHERE `id`="'.$user['patient_id'].'"';
        $patient = $this->d_m->get_all_result_array($query3,'single_row','','');

        $query4 = 'SELECT * FROM `doctor` WHERE `id`="'.$user['assign_id'].'"';
        $doctor = $this->d_m->get_all_result_array($query4,'single_row','','');

        $query7 = 'SELECT * FROM `admin` WHERE `id`="'.$user['assign_by'].'"';
        $assign_by = $this->d_m->get_all_result_array($query7,'single_row','','');

        $query8 = 'SELECT * FROM `coupan` WHERE `id`="'.$user['coupan_code_id'].'"';
        $coupan = $this->d_m->get_all_result_array($query8,'single_row','','');
        
        $value ="";
        if ($coupan['discount_type'] == "percentage") {
          $value = "%";
        }else{
          $value = "₹";
        }
        if ($user['refund_status'] == 1) 
        {
   
      $data[] = array(
        "#" =>$i,
        "patient"=>$patient['name'],
        "patient_phone"=>$patient['phone'],
        "patient_email"=>$patient['email'],
        "problem"=>$user['problem'],
        "online_mode"=>$user['online_mode'],
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
        "doctor_name"=>$doctor['doctor_firstname'],
        "cancel_by"=>$assign_by['username'],
        "assign_time"=>$user['assign_time'],
        "cancel_time"=>$user['cancel_time'],
        "complete_on"=>$user['complete_on'],
        "coupan_code"=>$user['coupan_code'],
        "total_amount"=>$user['total_amount'],
        "amount_percentage"=>$coupan['amount'].$value,
        "discount_amount"=>$user['discount_amount'],
        "tax_amount"=>$user['tax_amount'],
        "base_amount"=>$user['base_amount'],
        "trxn_status"=>$user['trxn_status'],
        "trxn_mode"=>$user['trxn_mode'],
        "trxn_id"=>$user['trxn_id'],
        "refund_amount"=>$user['refund_amount'],
        "refund_trxn_id"=>$user['refund_trxn_id'],
        "refund_date"=>$user['refund_date'],
        "refund_by"=>$refund_by['username'],
  
      );
  }
  else
   {  $data[] = array(
        "#" =>$i,
        "patient"=>$patient['name'],
        "patient_phone"=>$patient['phone'],
        "patient_email"=>$patient['email'],
        "problem"=>$user['problem'],
        "online_mode"=>$user['online_mode'],
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
        "doctor_name"=>$doctor['doctor_firstname'],
        "cancel_by"=>$assign_by['username'],
        "assign_time"=>$user['assign_time'],
        "cancel_time"=>$user['cancel_time'],
        "complete_on"=>$user['complete_on'],
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

  }
       $i++;
  }
    

      header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_offline".$uri.".csv\"");
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
        "cancel_time"=>date('Y-m-d H:i:s'),
        "cancel_by_id"=>$_SESSION['id']
        );
        //echo $data;die;
        $create = $this->d_m->get_all_result($data,'update','booking',array('id'=>$cancel_id));
        echo $this->db->last_query();       
      }
    
    }


     public function image_details()
    {
        $booking_id = trim($this->input->post('booking_id'));

        // $booking_data = $this->db->where('id',$booking_id)->get('booking')->result_array();
        $booking_data = $this->db->where('id',$booking_id)->get('booking')->row();
        $image = explode(',', $booking_data->images);
        // print_r($image);

        foreach ($image as $key) {
            echo "<img src='".base_url('uploads/video_attachment_by_patient')."/".$key."' height='200px' width='200px'>&nbsp;&nbsp;";
        }
  
    }



}