<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

class Reviews extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Horoscope_model','h_m');
        $this->load->library('pagination');
        $this->load->library('csvimport');
        $this->load->library('encryption');
        $this->load->helper('url');

        $this->load->library('form_validation');
        if(!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }
    }





       public function reviews_list($x='',$rowno = 1)
    {
        // print_r($rowno); die;

         if (isset($_GET['get_export_data'])) {
             $data[] = array("#"," Booking Type","Name","Email","Mobile","Boy Name","Boy Date of birth ","Boy Time of birth ","Boy Place of birth ","Girl Name","Girl Date of birth","Girl Time of birth","Girl Place of birth","Resoliving Files","Mode of payment","Transaction ID","currency","Amount","From wallet amount","From referral amount","Tax amount","Transaction Status","Payment Method","Payment gateway fee","Payment gateway tax","Payment gateway email","Payment gateway mobile","Payment gateway name","Added on system date","Status","Refund Status ","Refund Amount","Refund Transaction ID","Refund Date");
                $acounts = $this->get_total_reviews_paginate(0, '');
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
        $allcount = $this->count_total_reviews();
        // Get records
        $s = $this->get_total_reviews_paginate($rowno, $rowperpage);
// echo $this->db->last_que ry(); die;
        // Pagination Configuration
         $uri = $this->uri->segment(3);
        $config['base_url'] = base_url() . "reviews/reviews_list/".$uri;
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
        $template['page'] = "reviews/reviews_list";
        $template['page_title'] = "reviews";
        $template['links'] = $this->pagination->create_links();
    
        $template['list'] = $s;
        // print_r($template['list']);die;
        $template['row'] = $rowno;
        $this->load->view('template', $template);
    }


    private function count_total_reviews()
    {
      $uri = $this->uri->segment(3);
    
     
      
        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['boy_name']) || isset($_GET['girl_name']) || isset($_GET['mobile'])) {


         
         
            if($_GET['start_date'] != '')
            {
               $this->db->where('DATE(created_at) >=', $_GET['start_date']);
            }
            if($_GET['end_date'] != '')
            {
             $this->db->where('DATE(created_at) <=', $_GET['end_date']);
            }
          
            
        }


        
        $this->db->select('*');
        $this->db->from('reviews');
        // $this->db->where_in('booking_type',array(3));
        // $this->db->where_in('status',$status);
        $this->db->group_by('id');
        $query = $this->db->get();
        return count($query->result());

    }


     private function get_total_reviews_paginate($start = 0, $limit)
    {
      // print_r($start); die;

     
      
           if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['boy_name']) || isset($_GET['girl_name']) || isset($_GET['mobile'])) {
            // $first_date = date('Y-m-d', strtotime($_GET['start_date']));
            // $second_date = date('Y-m-d', strtotime($_GET['end_date']));;
          
         
            if($_GET['start_date'] != '')
            {
               $this->db->where('DATE(created_at) >=', $_GET['start_date']);
            }
            if($_GET['end_date'] != '')
            {
             $this->db->where('DATE(created_at) <=', $_GET['end_date']);
            }
           

            
        }

         if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        
        $this->db->select('*');
        $this->db->from('reviews');
        // $this->db->where_in('booking_type',array(3));
        // $this->db->where_in('status',$status);
        
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }


    public function reviews_status()
    {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        if ($status == 1) 
        {
            $a = 'enabled';
            $class = 'success';
        }
        elseif ($status == 0) 
        {
            $a = 'disabled';
            $class = 'success';
        }
        elseif ($status == 2) 
        {
            $a = 'deleted';
            $class = 'success';
        }
        $s = $this->db->query("UPDATE `reviews` SET `status`='$status' WHERE `id`='$id'");
        $this->session->set_flashdata('message', array(
            'message' => 'Reviews Successfully '.$a,
            'class' => $class
        ));
        redirect($_SERVER['HTTP_REFERER']);
    }


     


}
