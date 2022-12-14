<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// /* New aliases. */
// use PHPMailer\PHPMailer\OAuth;
// use League\OAuth2\Client\Provider\Google;

class Consultation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->library('pagination');
        $this->load->library('csvimport');
        $this->load->library('encryption');
        $this->load->helper('url');

        $this->load->library('form_validation');
        if(!$this->session->userdata('logged_in')) {
        	redirect(base_url());
        }
    }

    public function countBookings()
    {
        if(isset($_GET['orderId']) && !empty($_GET['orderId'])){
            $this->db->where('id',intval($_GET['orderId']));
        }else{
            $type=isset($_GET['type'])?$_GET['type']:'1,2,3,4,5';
            $type_arr = explode(',',$type);
            if(!empty($type_arr)){
                $this->db->where_in('type',$type_arr);
            }
            if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['mobile'])) {
                if(isset($_GET['mobile']) && $_GET['mobile'] != '')
                {
                  $this->db->or_like('user_phone', $_GET['mobile']);
                }
                if(isset($_GET['name']) && $_GET['name'] != '')
                {
                  $this->db->or_like('user_name', $_GET['name']);
                }
                if(isset($_GET['email']) && $_GET['email'] != '')
                {
                  $this->db->or_like('user_email', $_GET['email']);
                }
                if(isset($_GET['start_date']) && $_GET['start_date'] != '')
                {
                   $this->db->where('DATE(created_at) >=', $_GET['start_date']);
                }
                if(isset($_GET['end_date']) && $_GET['end_date'] != '')
                {
                 $this->db->where('DATE(created_at) <=', $_GET['end_date']);
                }
            }
           
            if(isset($_GET['astrologer_id']) && !empty($_GET['astrologer_id'])){
                $this->db->where('assign_id',intval($_GET['astrologer_id']));
            }
            if(isset($_GET['booking_status']) && !empty($_GET['booking_status'])){
                $booking_status = $_GET['booking_status'];
                if($booking_status=='ongoing'){
                    $this->db->where('status',6);
                }elseif($booking_status=='new'){
                    $this->db->where('status',0);
                }
                elseif($booking_status=='completed'){
                    $this->db->where('status',2);
    
                }elseif($booking_status=='cancelled'){
                    $this->db->where('status',3);
    
                }
            }
        }
        if(isset($_GET['refund_bookings']) && $_GET['refund_bookings']){
            $this->db->where_in('refund_request_raised',[1,2]);
        }
        $this->db->where('booking_type',2);
        $query = $this->db->count_all('bookings');
		return $query;
    }

    public function fetchBookings($limit, $start)
    {
        if(isset($_GET['orderId']) && !empty($_GET['orderId'])){
            $this->db->where('id',intval($_GET['orderId']));
        }else{
            $type=isset($_GET['type'])?$_GET['type']:'1,2,3,4,5';
            $type_arr = explode(',',$type);
            if(!empty($type_arr)){
                $this->db->where_in('type',$type_arr);
            }
            if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['mobile'])) {
                if(isset($_GET['mobile']) && $_GET['mobile'] != '')
                {
                  $this->db->or_like('user_phone', $_GET['mobile']);
                }
                if(isset($_GET['name']) && $_GET['name'] != '')
                {
                  $this->db->or_like('user_name', $_GET['name']);
                }
                if(isset($_GET['email']) && $_GET['email'] != '')
                {
                  $this->db->or_like('user_email', $_GET['email']);
                }
                if(isset($_GET['start_date']) && $_GET['start_date'] != '')
                {
                   $this->db->where('DATE(created_at) >=', $_GET['start_date']);
                }
                if(isset($_GET['end_date']) && $_GET['end_date'] != '')
                {
                 $this->db->where('DATE(created_at) <=', $_GET['end_date']);
                }
            }
           
            if(isset($_GET['astrologer_id']) && !empty($_GET['astrologer_id'])){
                $this->db->where('assign_id',intval($_GET['astrologer_id']));
            }
            if(isset($_GET['booking_status']) && !empty($_GET['booking_status'])){
                $booking_status = $_GET['booking_status'];
                if($booking_status=='ongoing'){
                    $this->db->where('status',6);
                }elseif($booking_status=='new'){
                    $this->db->where('status',0);
                }
                elseif($booking_status=='completed'){
                    $this->db->where('status',2);
    
                }elseif($booking_status=='cancelled'){
                    $this->db->where('status',3);
    
                }
            }
        }
        if(isset($_GET['refund_bookings']) && $_GET['refund_bookings']){
            $this->db->where_in('refund_request_raised',[1,2]);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$start);
        $this->db->where('booking_type',2);
        $query = $this->db->get('bookings');
		return $query->result();
    }
    
    public function consultations_assets()
    {
        if(isset($_GET['orderId']) && !empty($_GET['orderId'])){
            $this->db->where('id',intval($_GET['orderId']));
        }else{
            $type=isset($_GET['type'])?$_GET['type']:'1,2,3,4,5';
            $type_arr = explode(',',$type);
            if(!empty($type_arr)){
                $this->db->where_in('type',$type_arr);
            }
            if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['mobile'])) {
                if(isset($_GET['mobile']) && $_GET['mobile'] != '')
                {
                  $this->db->or_like('user_phone', $_GET['mobile']);
                }
                if(isset($_GET['name']) && $_GET['name'] != '')
                {
                  $this->db->or_like('user_name', $_GET['name']);
                }
                if(isset($_GET['email']) && $_GET['email'] != '')
                {
                  $this->db->or_like('user_email', $_GET['email']);
                }
                if(isset($_GET['start_date']) && $_GET['start_date'] != '')
                {
                   $this->db->where('DATE(created_at) >=', $_GET['start_date']);
                }
                if(isset($_GET['end_date']) && $_GET['end_date'] != '')
                {
                 $this->db->where('DATE(created_at) <=', $_GET['end_date']);
                }
            }
           
            if(isset($_GET['astrologer_id']) && !empty($_GET['astrologer_id'])){
                $this->db->where('assign_id',intval($_GET['astrologer_id']));
            }
            if(isset($_GET['booking_status']) && !empty($_GET['booking_status'])){
                // $booking_status = $_GET['booking_status'];
                // if($booking_status=='ongoing'){
                //     $this->db->where('status',6);
                // }elseif($booking_status=='new'){
                //     $this->db->where('status',0);
                // }
                // elseif($booking_status=='completed'){
                //     $this->db->where('status',2);
    
                // }elseif($booking_status=='cancelled'){
                //     $this->db->where('status',3);
    
                // }
                $this->db->where('status',2);
            }else{
                $this->db->where('status',2);
            }
        }
        $this->db->select("COUNT(id) as total_records,SUM(payable_amount) as total_amount_bookings,SUM(astrologer_comission_amount) as total_comission_amount");
        $this->db->where('booking_type',2);
        $query = $this->db->get('bookings');
		return $query->row();
    }

    public function refund_request_solved($order_id)
    {
        $this->db->where('id',$order_id);
        $this->db->update('bookings',['refund_request_raised'=>2]);
        redirect($this->agent->referrer());
    }

    public function booking_complete($order_id)
    {
        $this->db->where('id',$order_id);
        $this->db->update('bookings',['status'=>2]);
        redirect($this->agent->referrer());
    }


    public function booking_cancel($order_id)
    {
        $this->db->where('id',$order_id);
        $this->db->update('bookings',['status'=>3]);
        redirect($this->agent->referrer());
    }


    public function fetchConsultations($rowno=0) {


 if (isset($_GET['get_export_data'])) {
             $data[] = array("#"," OrderId","Booking Type","Booking Status","Astrologer","UserName","Email","Mobile","Gender","Dob","Time of birth","Place of birth","Message","Amount","Start Time","End Time ","Total Minutes","Total Seconds","Refund Request","Refund Reason","Recording","Added on");
                $acounts = $this->fetchBookings(0, '');

                // print_r($acounts); die;
                $i = 1;
                foreach ($acounts as $user) {
                    $created_at = date("d-m-Y", strtotime($user->created_at));
                    $dob = date("d/m/Y", strtotime($user->user_dob));
                     $tob =  date('h:ia', strtotime($user->user_tob));
                    // $created_at  = date("d-m-Y H:i:s", $user->created_at);
                    // $added_on   = date("d-m-Y h:i:s A", strtotime($user->added_on ));
                    $schedule_date_time   = date("d-m-Y h:i:s A", strtotime($user->schedule_date_time ));
                    $end_time   = date("d-m-Y h:i:s A", strtotime($user->end_time ));
                 // $added = date('d-M-Y g:i A', strtotime($d->created_at));

                     $start = strtotime($user->schedule_date_time);
                      $end = strtotime($user->end_time);
                      $diff = abs((($d=$end-$start) <0 ? 0 : $d )/60);
                      $mail_deff =  round($diff);

                     $sss =  ($d=$end-$start) <0 ? 0 : $d;

                switch ($user->status) {
                    case '1':
                        $st = "Confirmed";
                       
                        break;
                    case '2':
                        $st = "Completed";
                           

                        break;
                    case '3':
                        $st = "Canceled";
                           
                        break;
                    case '4':
                        $st = "refunded";
                           
                        break;
                           case '6':
                        $st = "Ongoing";
                           
                        break;

                    default:
                        $st = "PENDING";
                           

                        break;
                }

                 switch ($user->type) {
                    case '1':
                        $bt = "Video";
                        break;
                    case '2':
                        $bt = "Audio";
                        break;
                    case '3':
                        $bt = "Report";
                        break;
                   
                    default:
                        $bt = "Live";

                        break;
                }

            
        
                 $ci =& get_instance();
                 $assign_id = $ci->db->get_where('astrologers',['id'=>$user->assign_id])->row();
                

                    $data[] = array(
                    "#" => $i,
                    "order_id"=>$user->id,
                    "type" => $bt,
                    "status"=>$st,
                    "assign_id"=>$assign_id->name,
                    "user_name"=>$user->user_name,
                    "user_email"=>$user->user_email,
                    "user_phone"=>$user->user_phone,
                    "user_gender"=>$user->user_gender,
                    "dob"=>$dob,
                    "tob"=>$tob,
                    "problem"=>$user->user_pob,
                    "message"=>$user->message,
                    "payable_amount"=>$user->payable_amount,
                    "schedule_date_time"=>$schedule_date_time,
                    "end_time"=>$end_time,
                    "mail_deff"=>$mail_deff,
                    "sss"=>$sss,
                    "created_at"=>$created_at,



                    );
                    $i++;
                }
            
                    $string_file = date("d-m-Y h:i:s A");
               
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=\"Booking" . $string_file . ".csv");
                header("Pragma: no-cache");
                header("Expires: 0");

                $handle = fopen('php://output', 'w');

                foreach ($data as $data) {
                    fputcsv($handle, $data);
                }
                fclose($handle);
                exit;
    }
       



        $config = array();
        $config["base_url"] = base_url() . "consultation";
        $config["total_rows"] =$allcount= $this->countBookings();
        // print_r($allcount);die;
        $config["per_page"] =$rowperpage= 10;
        $config['base_url'] = base_url() . "consultation/fetchConsultations/";
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $template['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = TRUE;
        // $config['page_query_string'] = TRUE;
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
        $this->pagination->initialize($config);

		$template["links"] = $this->pagination->create_links();

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
		$template['list'] = $this->fetchBookings($rowperpage, $rowno);
		$template['astrologer_assets'] = $consultations_assets = $this->consultations_assets();
        $template['page'] = "booking/astrologer_booking_new";
        $template['page_title'] = "View Consultations";
        $this->load->view('template',$template);
    }



    public function booking_details()
    {
      $id = trim($this->input->post('id'));
      // $patient_data = $this->db->where('id',$id)->get('patient')->row();
      $data = "SELECT * FROM `bookings` WHERE `id` = '$id'";
      $d= $this->db->query($data);
      $row = $d->result_array();
      echo json_encode($row);
    }



    public function update_astrologer_amount_null()
    {
      if ($_POST) {   
        $uri = $this->uri->segment(3);
        $user_id =  $this->input->post("user_id");
        $amount =  floatval($this->input->post("amount"));

        
        $user_data = $this->db->where('id',$user_id)->get('bookings')->row();
        $wallet_amount =   $user_data->astrologer_comission_amount;
        $update_amount =  $user_data->astrologer_comission_amount-$amount;
       
        $this->db->where('id',$user_id);
        $this->db->update('bookings',['astrologer_comission_amount'=>$update_amount]);

        // echo $this->db->last_query(); die;
      }
    }

  

 


    public function astrologer_payout()
    {
        $template['astrologer_assets'] = $consultations_assets = $this->consultations_assets();

        
        $type=isset($_GET['type'])?$_GET['type']:'1,2,3,4,5';
        $type_arr = explode(',',$type);
        if(!empty($type_arr)){
            $this->db->where_in('type',$type_arr);
        }
        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['mobile'])) {
            if(isset($_GET['mobile']) && $_GET['mobile'] != '')
            {
              $this->db->or_like('user_phone', $_GET['mobile']);
            }
            if(isset($_GET['name']) && $_GET['name'] != '')
            {
              $this->db->or_like('user_name', $_GET['name']);
            }
            if(isset($_GET['email']) && $_GET['email'] != '')
            {
              $this->db->or_like('user_email', $_GET['email']);
            }
            if(isset($_GET['start_date']) && $_GET['start_date'] != '')
            {
               $this->db->where('DATE(created_at) >=', $_GET['start_date']);
            }
            if(isset($_GET['end_date']) && $_GET['end_date'] != '')
            {
             $this->db->where('DATE(created_at) <=', $_GET['end_date']);
            }
        }
       
        if(isset($_GET['astrologer_id']) && !empty($_GET['astrologer_id'])){
            $this->db->where('assign_id',intval($_GET['astrologer_id']));
        }
        if(isset($_GET['booking_status']) && !empty($_GET['booking_status'])){
            $booking_status = $_GET['booking_status'];
            if($booking_status=='ongoing'){
                $this->db->where('status',6);
            }elseif($booking_status=='new'){
                $this->db->where('status',0);
            }
            elseif($booking_status=='completed'){
                $this->db->where('status',2);

            }elseif($booking_status=='cancelled'){
                $this->db->where('status',3);

            }
        }
        $this->db->select("COUNT(id) as total_pending_records,SUM(astrologer_comission_amount) as total_pending_payouts");
        $this->db->where('booking_type',2);
        $this->db->where('is_comission_paid',0);
        $query = $this->db->get('bookings')->row();
        $template['payouts'] = $query;
        if(isset($_POST['clear_payout'])){
            $pending_payout = floatval($query->total_pending_payouts);
            if($pending_payout){
                $this->db->where('is_comission_paid',0);
                $this->db->where('assign_id',$_GET['astrologer_id']);
                $this->db->update('bookings',['is_comission_paid'=>1]);

                $this->db->insert('astrologer_payouts',[
                    'astrologer_id'=>$_GET['astrologer_id'],
                    'amount'=>$pending_payout,
                    'created_at'=>date('Y-m-d H:i:s')
                ]);

                $this->session->set_flashdata('message',array('message' => 'Astrologer payout cleared successfully.','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message',array('message' => 'No Pending Payouts.','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        // else{
        //     $this->session->set_flashdata('message',array('message' => 'No Pending Payouts.','class' => 'warning'));
        //     redirect($this->agent->referrer());
        // }

        $template['page'] = "booking/astrologer_payout";
        $template['page_title'] = "View Astrologer Payout";
        $this->load->view('template',$template);

    }

}
