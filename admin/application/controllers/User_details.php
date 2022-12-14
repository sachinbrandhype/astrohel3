<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_details extends CI_Controller {
    public function __construct() {
    parent::__construct();      
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Patient_model');    
        $this->load->library('pagination');    
        if(!$this->session->userdata('logged_in')) { 
            redirect(base_url());
        }
    }


      public function userList(){

    if(!empty($_POST["keyword"])) {
    $query ="SELECT * FROM user WHERE name like '" . $_POST["keyword"] . "%' ORDER BY name LIMIT 0,25";
    $result = $this->db->query($query)->result_array();
  // print_r($result);
    if(!empty($result)) {
    ?>
    <ul id="country-list">
    <?php
    foreach($result as $user_d) {

    ?>
    <li onClick="selectCountry('<?php echo $user_d["name"]."(".$user_d["phone"].")"; ?>');"><?php echo $user_d["name"]."(".$user_d["phone"].")"; ?></li>
    <?php } ?>
    </ul>
    <?php } }

     }
  



  public function delete_Patient()

  {
    $data1 = array(
      "status" => '2'
    );
    $id = $this->uri->segment(3);
    $s = $this->Patient_model->update_patient_status($id, $data1);
    $this->session->set_flashdata('message', array(
      'message' => 'Requested User Deleted Successfully',
      'class' => 'warning'
    ));
    redirect($_SERVER['HTTP_REFERER']);
    //redirect(base_url('patientdetail_ctrl/view_patientdetails'));
  }


  public function patient_status($id)

  {
    $data1 = array(
      "status" => 0
    );
    // $id = $this->uri->segment(3);
    // $s = $this->Patient_model->update_patient_status($id, $data1);
    $this->db->where('id',$id);
    $this->db->update('user',['status'=>0]);
    $this->session->set_flashdata('message', array(
      'message' => 'User Successfully Disabled',
      'class' => 'warning'
    ));
    redirect($_SERVER['HTTP_REFERER']);
    //redirect(base_url('patientdetail_ctrl/view_patientdetails'));
  }
  public function patient_active($id)
  {
    $data1 = array(
      "status" => 1
    );
    // $id = $this->uri->segment(3);
    // $s = $this->Patient_model->update_patient_status($id, $data1);
    $this->db->where('id',$id);
    $this->db->update('user',['status'=>1]);
    $this->session->set_flashdata('message', array(
      'message' => 'User Successfully Enabled',
      'class' => 'success'
    ));
    redirect($_SERVER['HTTP_REFERER']);
    //redirect(base_url('Doctordetail_ctrl/view_doctordetails'));
  }



  
 public function view_userdetails($rowno = 1)
    {
        // print_r($rowno); die;
          ini_set('memory_limit', -1);
         if (isset($_GET['get_export_data'])) {
            $data[] = array("UserID","Name","Gender","DOB","Email","Mobile","Wallet","image","birth_time",
                "place_of_birth","marital_status","address","city","zip","auth",
                "device_type","loginTime","model_name","Added_On");
                $acounts = $this->get_total_enquiries_paginate(0, '',1);
                $i = 1;
                foreach ($acounts as $user) {
                  


                    $data[] = array(
                        // "#" => $i,
                "UserID" =>$user->id,
                "Name" => $user->name,
                "Gender" => $user->gender,
                "DOB" =>$user->dob,
                "Email"=> $user->email,
                "Mobile"=>$user->phone,
                "wallet"=>$user->wallet,
                "image"=>base_url()."uploads/patient/".$user->image,
                "birth_time "=>$user->birth_time ,
                "place_of_birth"=>$user->place_of_birth,
                "marital_status"=>$user->marital_status,
                "address"=>$user->address,
                "city"=>$user->city,
                "zip"=>$user->zip,
                "auth"=>$user->auth,
                "device_type"=>$user->device_type,
                "loginTime"=>$user->loginTime,
                "model_name"=>$user->model_name,
      
                "Added_On" => date('d M Y H:i A')

                    );
                    $i++;
                }
            
                    $string_file = date("d-m-Y h:i:s A");
               
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=\"export_user" . $string_file . ".csv");
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
        $s = $this->get_total_enquiries_paginate($rowno, $rowperpage,1);
// echo $this->db->last_query(); die;
        // Pagination Configuration
         $uri = $this->uri->segment(3);
     $config['base_url'] = base_url() . '/User_details/view_userdetails';
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
        $template['page'] = "Patientdetails/view-patient-details";
        $template['page_title'] = "Life_prediction";
        $template['links'] = $this->pagination->create_links();
    
        $template['data'] = $s;
         $template['counter_for_index'] = $rowno;
        $template['row'] = $rowno;
        $this->load->view('template', $template);
    }




  public function update_user_amount()
    {
      if ($_POST) {   
        $uri = $this->uri->segment(3);
        $user_id =  $this->input->post("user_id");
        $amount =  floatval($this->input->post("amount"));
         $message =  $this->input->post("message");
        $assign_by =  $_SESSION['id'];
        $user_data = $this->db->where('id',$user_id)->get('user')->row();
        // print_r($user_data->wallet);die; 
        $wallet_amount =  floatval($user_data->wallet);
        // $data = array
        // (
        //     "patient_id"=>$user_id,
        //     "payment_type"=>"add_wallet",
        //     "BANKNAME"=>"admin",
        //     "BANKTXNID"=>time(),
        //     "STATUS"=>"1",
        //     "TXNAMOUNT"=>$amount,
        //     "TXNDATE"=>time(),
        //     "TXNID"=>time(),
        //     "amount_before_trxn"=>$wallet_amount,
        //     "amount_after_trxn"=>$wallet_amount+$amount,
        //     "added_on"=>date('Y-m-d H:i:s'),
        //     "admin_id"=>$_SESSION['id'],
        //     "by_"=>"admin",
        //     "do_sum_minus"=>"add",
        
        // );
        //   $insert = $this->db->insert('user_wallet_history',$data);
        
        $data2 = array
        (
            "wallet "=>$new_wallet = $wallet_amount+$amount,
        );

        $txn_ = [
          'user_id'=>$user_id,
          'txn_name'=>'Credits Added by admin',
          'booking_txn_id'=>'Ad'.time(),
          'payment_mode'=>'wallet',
          'txn_for'=>'wallet',
          'type'=>'credit',
          'old_wallet'=>$wallet_amount,
          'txn_amount'=>$amount,
          'message'=>$message,
          'update_wallet'=>$new_wallet,
          'status'=>1,
          'created_at'=>$date=date('Y-m-d H:i:s'),
          'updated_at'=>$date
        ];
        $this->db->insert('transactions',$txn_);
        $this->db->where('id',$user_id);
        $this->db->update('user',$data2);
        // $update = $this->Patient_model->get_all_result($data2,'update','user',array('id'=>$user_id));
      
      }
    }

    public function update_user_amount_null()
    {
      if ($_POST) {   
        $uri = $this->uri->segment(3);
        $user_id =  $this->input->post("user_id");
        $message =  $this->input->post("message");
        $amount =  floatval($this->input->post("amount"));

        
        $assign_by =  $_SESSION['id'];
        $user_data = $this->db->where('id',$user_id)->get('user')->row();
        $wallet_amount =   $user_data->wallet;
        $update_amount =  $user_data->wallet-$amount;
        $data = array
        (
           


            'user_id'=>$user_id,
            'txn_name'=>'admin deduct amount from user wallet',
            'booking_txn_id'=>'de'.time(),
            'payment_mode'=>'wallet',
            'txn_for'=>'wallet',
            'type'=>'debit',
            'old_wallet'=>$wallet_amount,
            'txn_amount'=>$amount,
            'update_wallet'=>$update_amount,
            'message'=>$message,
            'status'=>1,
            'created_at'=>$date=date('Y-m-d H:i:s'),
            'updated_at'=>$date


        
        );
          $insert = $this->db->insert('transactions',$data);
        $data2 = array
        (
            "wallet "=>$update_amount,
        );
        $update = $this->Patient_model->get_all_result($data2,'update','user',array('id'=>$user_id));
        // echo $this->db->last_query(); die;
      }
    }

  



    public function user_details()
    {
      $id = trim($this->input->post('id'));
      // $patient_data = $this->db->where('id',$id)->get('patient')->row();
      $data = "SELECT * FROM `user` WHERE `id` = '$id'";
      $d= $this->db->query($data);
      $row = $d->result_array();
      echo json_encode($row);
    }

 
 public function view_userdelete_details($rowno = 1)
    {
        
            $data[] = array("UserID","Name","Gender","DOB","Email","Mobile","terms","image","birth_time","place_of_birth","languages","marital_status","address","area","city","zip","username","auth","device_type","loginTime","model_name","carrier_name","device_country","device_memory","have_notch","manufacture","wallet","refferal_wallet","Referral Code","Added_On");
                $acounts = $this->get_total_enquiries_paginate(0, '',2);
                $i = 1;
                foreach ($acounts as $user) {
                  


                    $data[] = array(
                        // "#" => $i,
                "UserID" =>$user->id,
                "Name" => $user->name,
                "Gender" => $user->gender,
                "DOB" =>$user->dob,
                "Email"=> $user->email,
                "Mobile"=>$user->phone,
                "terms"=>$user->terms,
                "image"=>base_url()."uploads/patient/".$user->image,
                "birth_time "=>$user->birth_time ,
                "place_of_birth"=>$user->place_of_birth,
              
                "languages"=>$user->languages,
                "marital_status"=>$user->marital_status,
                "address"=>$user->address,
                "area"=>$user->area,
                "city"=>$user->city,
                "zip"=>$user->zip,
                "username"=>$user->username,
                "auth"=>$user->auth,
                "device_type"=>$user->device_type,
                "loginTime"=>$user->loginTime,
                "model_name"=>$user->model_name,
                "carrier_name"=>$user->carrier_name,
                "device_country"=>$user->device_country,
                "device_memory"=>$user->device_memory,
                "have_notch"=>$user->have_notch,
                "manufacture"=>$user->manufacture,
                "wallet"=>$user->wallet,
                "refferal_wallet"=>$user->refferal_wallet,
                "referral_code"=>$user->referral_code,
                "Added_On" => date('d M Y H:i A')

                    );
                    $i++;
                }
            
                    $string_file = date("d-m-Y h:i:s A");
               
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=\"export_delete_user" . $string_file . ".csv");
                header("Pragma: no-cache");
                header("Expires: 0");

                $handle = fopen('php://output', 'w');

                foreach ($data as $data) {
                    fputcsv($handle, $data);
                }
                fclose($handle);
                exit;
 
    }

 
 public function view_disabled_userdetails($rowno = 1)
    {
        // print_r($rowno); die;

        ini_set('memory_limit', -1);
         if (isset($_GET['get_export_data'])) {
            $data[] = array("UserID","Name","Gender","DOB","Email","Mobile","terms","image","birth_time","place_of_birth","languages","marital_status","address","area","city","zip","username","auth","device_type","loginTime","model_name","carrier_name","device_country","device_memory","have_notch","manufacture","wallet","refferal_wallet","Referral Code","Added_On");
                $acounts = $this->get_total_enquiries_paginate(0, '',0);
                $i = 1;
                foreach ($acounts as $user) {
                  


                    $data[] = array(
                        // "#" => $i,
                "UserID" =>$user->id,
                "Name" => $user->name,
                "Gender" => $user->gender,
                "DOB" =>$user->dob,
                "Email"=> $user->email,
                "Mobile"=>$user->phone,
                "terms"=>$user->terms,
                "image"=>base_url()."uploads/patient/".$user->image,
                "birth_time "=>$user->birth_time ,
                "place_of_birth"=>$user->place_of_birth,
              
                "languages"=>$user->languages,
                "marital_status"=>$user->marital_status,
                "address"=>$user->address,
                "area"=>$user->area,
                "city"=>$user->city,
                "zip"=>$user->zip,
                "username"=>$user->username,
                "auth"=>$user->auth,
                "device_type"=>$user->device_type,
                "loginTime"=>$user->loginTime,
                "model_name"=>$user->model_name,
                "carrier_name"=>$user->carrier_name,
                "device_country"=>$user->device_country,
                "device_memory"=>$user->device_memory,
                "have_notch"=>$user->have_notch,
                "manufacture"=>$user->manufacture,
                "wallet"=>$user->wallet,
                "refferal_wallet"=>$user->refferal_wallet,
                "referral_code"=>$user->referral_code,
                "Added_On" => date('d M Y H:i A')

                    );
                    $i++;
                }
            
                    $string_file = date("d-m-Y h:i:s A");
               
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=\"export_disabled_user" . $string_file . ".csv");
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
        $s = $this->get_total_enquiries_paginate($rowno, $rowperpage,0);
// echo $this->db->last_query(); die;
        // Pagination Configuration
         $uri = $this->uri->segment(3);
     $config['base_url'] = base_url() . '/User_details/view_disabled_userdetails';
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
        $template['page'] = "Patientdetails/view-patient-details";
        $template['page_title'] = "Life_prediction";
        $template['links'] = $this->pagination->create_links();
    
        $template['data'] = $s;
         $template['counter_for_index'] = $rowno;
        $template['row'] = $rowno;
        $this->load->view('template', $template);
    }


    private function count_total_enquiries()
    {
   
      
        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['mobile'])) {


          if($_GET['mobile'] != '')
            {
              $this->db->or_like('phone', $_GET['mobile']);
            }
            if($_GET['name'] != '')
            {
              $this->db->or_like('name', $_GET['name']);
            }
            if($_GET['email'] != '')
            {
              $this->db->or_like('email', $_GET['email']);
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
        $this->db->from('user');
        $this->db->where_in('status',array(0,1));
        $this->db->order_by('id', 'DESC');
        $this->db->group_by('id');
        $query = $this->db->get();
        return count($query->result());

    }


     private function get_total_enquiries_paginate($start = 0, $limit,$status)
    {
      // print_r($start); die;

      
      
           if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['mobile'])) {
            // $first_date = date('Y-m-d', strtotime($_GET['start_date']));
            // $second_date = date('Y-m-d', strtotime($_GET['end_date']));;
            if($_GET['mobile'] != '')
            {
              $this->db->or_like('phone', $_GET['mobile']);
            }
            if($_GET['name'] != '')
            {
              $this->db->or_like('name', $_GET['name']);
            }
            if($_GET['email'] != '')
            {
              $this->db->or_like('email', $_GET['email']);
            }
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
        $this->db->from('user');
        $this->db->where_in('status',array($status));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }







     public function view_userdetails_old($rowno=0)
     {


     $data = array();
         $user_id = "";
         $number = "";
          $start_date = "";
         $end_date = "";
        if($this->input->post('submit') != NULL ){
            $user_id = $this->input->post('user_id');
            $number = $this->input->post('number');
               $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');

            $sess = $this->session->set_userdata(array("user_id"=>$user_id,"number" => $number,"start_date"=>$start_date,"end_date" => $end_date));
        }if($this->input->post('reset') != NULL)
        {
            unset(
                    $_SESSION['user_id'],
                    $_SESSION['number'],
                     $_SESSION['start_date'],
                    $_SESSION['end_date']
                  
                );
        }else{
            if($this->session->userdata('user_id') != NULL){
                $user_id = $this->session->userdata('user_id');
            }
            if($this->session->userdata('number') != NULL){
                $number = $this->session->userdata('number');
            }
               if($this->session->userdata('start_date') != NULL){
                $start_date = $this->session->userdata('start_date');
            }
            if($this->session->userdata('end_date') != NULL){
                $end_date = $this->session->userdata('end_date');
            }
        }
        $rowperpage = 20;
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        $total_records = $this->Patient_model->get_total_patientdetails($user_id,$number,$start_date,$end_date);
        // echo $this->db->last_query();die;
        $template['data'] = $this->Patient_model->get_patientdetails_pagination($rowno,$rowperpage,$user_id,$number,$start_date,$end_date);
        $config['base_url'] = base_url() . '/User_details/view_userdetails';
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
        $template['user_id'] = $user_id;
        $template['number'] = $number;
          $template['start_date'] = $start_date;
        $template['end_date'] = $end_date;
        $template['user_details'] = $this->Patient_model->user_details();

         $template['counter_for_index'] = $rowno;
         // $template['counter_for_index'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
// print_r($template['counter_for_index']);die;

          $template['page'] = "Patientdetails/view-patient-details";
          $template['page_title'] = "User Details";
          $this->load->view('template',$template);
     }  

     
     public function view_userdetails_2()
     {
        $config = array();
        $config["base_url"] = base_url() . "User_details/view_userdetails";
        $config["total_rows"] = $this->Patient_model->get_count_patientdetails('user');
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
          $template['data'] = $this->Patient_model->get_pagination_data_patientdetails($config["per_page"],$template['page'],'user');
          // echo $this->db->last_query();die;
          // print_r($template['lab_package']);die;
          $template["links"] = $this->pagination->create_links();
          $template['counter_for_index'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
          $template['page'] = "Patientdetails/view-patient-details";
          $template['page_title'] = "User Details";
          $this->load->view('template',$template);
     }  


     public function user_export()
    {
      // print_r("expression");die;
        $id = htmlentities(trim($this->uri->segment(3)));
        $query2 = "SELECT * FROM `user`";
        $template['post'] = $this->Patient_model->get_all_result($query2,'select','','');

        $data[] = array("UserID","Name","Gender","DOB","Email","Mobile","terms","image","birth_time","place_of_birth","allergies","languages","marital_status","address","area","city","zip","username","auth","device_type","loginTime","model_name","carrier_name","device_country","device_memory","have_notch","manufacture","wallet","refferal_wallet","Referral Code","Added_On");
                
            
        foreach($template['post'] as $user)
        {
            $data[] = array(
                "UserID" =>$user->id,
                "Name" => $user->name,
                "Gender" => $user->gender,
                "DOB" =>$user->dob,
                "Email"=> $user->email,
                "Mobile"=>$user->phone,
                "terms"=>$user->terms,
                "image"=>base_url()."uploads/patient/".$user->image,
                "birth_time "=>$user->birth_time ,
                "place_of_birth"=>$user->place_of_birth,
              
                "languages"=>$user->languages,
                "marital_status"=>$user->marital_status,
                "address"=>$user->address,
                "area"=>$user->area,
                "city"=>$user->city,
                "zip"=>$user->zip,
                "username"=>$user->username,
                "auth"=>$user->auth,
                "device_type"=>$user->device_type,
                "loginTime"=>$user->loginTime,
                "model_name"=>$user->model_name,
                "carrier_name"=>$user->carrier_name,
                "device_country"=>$user->device_country,
                "device_memory"=>$user->device_memory,
                "have_notch"=>$user->have_notch,
                "manufacture"=>$user->manufacture,
                "wallet"=>$user->wallet,
                "refferal_wallet"=>$user->refferal_wallet,
                "referral_code"=>$user->referral_code,
                "Added_On" => date('d M Y H:i A')
            );
        }
        

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"export_user_list".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');

        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
                    
        fclose($handle);
        exit;
    
    }

      public function notification()
    {

     // print_r("shubha");die;

      $config = array();
        $config["base_url"] = base_url() . "User_details/notification";
        $config["total_rows"] = $this->Patient_model->get_count_notification('user_notification');
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
        $template['lab_package'] = $this->Patient_model->get_pagination_data_notification($config["per_page"],$template['page'],'user_notification');
        // print_r($template['lab_package']);die;
        $template["links"] = $this->pagination->create_links();

      $template['page'] = "Patientdetails/notification";
    $template['page_title'] = "Notification";
    //$template['lab_package'] = $this->Lab_model->get_lab_package();
    //echo $this->db->last_query();die;
    $this->load->view('template',$template);
    }



  
      public function referral_view(){

        $userid = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $userid;
        $config = array();
        $config["base_url"] = base_url() . "User_details/referral_view/".$userid;
        $config["total_rows"] = $this->Patient_model->get_count('referral_code_history',$userid);
        $config['per_page'] = 50;
        $config["uri_segment"] = 4;
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
        $template['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $template['data'] = $this->Patient_model->get_order_data($config["per_page"],$template['page'],'referral_code_history',$userid);
        // print_r($template['data']);die;
        $template["links"] = $this->pagination->create_links();



      //   $query = "SELECT * FROM `departments` WHERE `id` = '$id'";
      // $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');



        $template['page'] = "Patientdetails/referral_view";
        $template['page_title'] = "User referral_view";
        $this->load->view('template', $template);
             
     } 

      public function export_referral()
    {

        $user_id = $this->uri->segment(3);
        // print_r($user_id);die;
        $query = 'SELECT * FROM referral_code_history WHERE `appy_by` = "'.$user_id.'" ORDER BY `added_on` DESC';
        $details=  $this->Patient_model->get_all_result_array($query,'select','','');
        // print_r($details);die;
            $data[] = array("#","User Name","Referral User Name","Email","Weight","Used","Added On","Code");
                
            $i=1;
            foreach($details as $user)
            {
              $user_id = $user['appy_by'];
              $user_data = $this->db->where('id',$user_id)->get('user')->row();
              if ($user_data) 
              {
                  $user_name = $user_data->name;
              }

              $referral_id = $user['apply_to'];
              $referral = $this->db->where('id',$referral_id)->get('user')->row();

             // print_r($referral);die;
              if ($referral) 
              {
                  $referral_name = $referral->name;
                  $referral_email = $referral->email;
                
                  $referral_gender = $referral->gender;

                  if ($user['is_used'] == 1) 
                  {
                    $referral_used = "Used";
                  }
                  else 
                  {
                     $referral_used = "Pending";
                  }
                  $referral_added_on = $user['added_on'];
                  $referral_code = $user['code'];
                 
              }
              else
              {
                 $referral_name = "";
                   $referral_email = "";
                    $referral_gender ="";
                    $referral_used ="";
                    $referral_code ="";
                    $referral_added_on ="";
              }
              

              $data[] = array(
                "#" =>$i,
                "user_name"=>$user_name,
                "referral_name"=>$referral_name,
                "referral_email"=>$referral_email,
              
                "referral_gender"=>$referral_gender,
                "referral_used"=>$referral_used,
                "referral_added_on"=>$referral_added_on,
                "referral_code"=>$referral_code,
                
              
              );
               $i++;
            }

            header("Content-type: application/csv");
              header("Content-Disposition: attachment; filename=\"export_referral".".csv\"");
              header("Pragma: no-cache");
              header("Expires: 0");

              $handle = fopen('php://output', 'w');

              foreach ($data as $data) {
                  fputcsv($handle, $data);
              }
                          
              fclose($handle);
              exit;
    }


 public function wallet_view(){


         $userid = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $userid;
        $config = array();
        $config["base_url"] = base_url() . "User_details/wallet_view/".$userid;
        $config["total_rows"] = $this->Patient_model->get_count_wallet('transactions',$userid);
         // echo $this->db->last_query();die;
        $config['per_page'] = 10;
        $config["uri_segment"] = 4;
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
        $template['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $template['data'] = $this->Patient_model->get_order_data_wallet($config["per_page"],$template['page'],'transactions',$userid);
        $template["links"] = $this->pagination->create_links();
        $template['page'] = "Patientdetails/wallet_view";
        $template['page_title'] = "User wallet_view";
        $this->load->view('template', $template);


     } 

     public function export_wallet()
    {

        $user_id = $this->uri->segment(3);
       // print_r($user_id);die;
        
        $query = 'SELECT * FROM transactions WHERE `user_id` = "'.$user_id.'" ORDER BY `created_at` DESC';
            
       
        $details=  $this->Patient_model->get_all_result_array($query,'select','','');
       // print_r($details);die;
            $data[] = array("#","User Name","Transactions Name","Booking Id","Payment Mode","Transactions For","Type","Old Wallet","Transaction Amount","Update Wallet","Gst Perct","Gst Amount","Added On");
            $i=1;
            foreach($details as $user)
            {
              $user_id = $user['user_id'];
              $user_data = $this->db->where('id',$user_id)->get('user')->row();
              if ($user_data) 
              {
                  $user_name = $user_data->name;
              }
              $data[] = array(
                "#" =>$i,
                "user_name"=>$user_name,
                "payment_for"=>$user['txn_name'],
                "booking_id"=>$user['booking_txn_id'],
                "update_wallet"=>$user['payment_mode'],
                "trxn_status"=>$user['txn_for'],
                "trxn_id"=>$user['type'],
                "currency"=>$user['old_wallet'],
                "payment_status"=>$user['txn_amount'],
                "description"=>$user['update_wallet'],
                "created_at"=>$user['gst_perct'],
                "method"=>$user['gst_amount'],
               
                "added_on"=>date("d M y g:ia",  strtotime($user['created_at'])),
                
              );
               $i++;
            }

            header("Content-type: application/csv");
              header("Content-Disposition: attachment; filename=\"export_wallet".".csv\"");
              header("Pragma: no-cache");
              header("Expires: 0");

              $handle = fopen('php://output', 'w');

              foreach ($data as $data) {
                  fputcsv($handle, $data);
              }
                          
              fclose($handle);
              exit;
    }

     // public function delete_Patient(){            
     //      $id = $this->uri->segment(3);
     //      $result= $this->Patient_model->patient_delete($id);
     //      $this->session->set_flashdata('message', array('message' => 'Requested User Deleted Successfully','class' => 'success'));
     //      redirect(base_url().'User_details/view_userdetails');
     // }                   
    public function patient_viewpopup() {  
        $id=$_POST['patientdetailsval'];
        $template['data'] = $this->Patient_model->view_popup_patient($id);
        $this->load->view('Patientdetails/patient-view-popup',$template);   
    }
    public function get_patientdetails(){
        $template['data'] = $this->Patient_model->get_patientval(); 
    }
    public function get_patientstates(){         
        $template['data'] = $this->Patient_model->get_patientstateval();     
    }
    public function get_patientcountry(){   
        $template['data'] = $this->Patient_model->get_patientcountryval();  
    }
    public function patient_view()

    {
        $template['page'] = "Patientdetails/patient_view";
        $template['page_title'] = "View User Details";
        $id = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $id;
        $template['data'] = $this->Patient_model->get_single_patient($id);
        $this->load->view('template', $template);
    }
    public function member_view()
    {
        $template['page'] = "Patientdetails/member_view";
        $template['page_title'] = "View Member Details";
        $id = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $id;
        $template['data'] = $this->Patient_model->get_memberdetails($id);
        $this->load->view('template', $template);
    }
     public function exportCSV_member(){ 

        $p_id = $this->uri->segment(3);
        $p_name = $this->db->where(array('id'=>$p_id))->get('user')->row();
         if($p_name)
         {
            $patient_name = $p_name->name;
         }
     
        
        $data[] = array('S.No.', 'Member ID', 'User Name', 'Member Name', 'DOB','gender','Place Of birth','Relation');

        $pp = $this->Patient_model->get_tbl_data(array('user_id' => $p_id ));
        //echo $this->db->last_query();die;

        if(count($pp) > 0 && !empty($pp)){
        //print_r($pp);
          $i=1;
        foreach($pp as $nu)
        {
            $data[] = array(
                "s.no"                => $i,
                "Member ID"           => $nu->id,
                "User Name"        => $patient_name,
                "Member Name"         => $nu->member_name,
                "Date Of Birth"       => $nu->member_dob,
                "member_gender"       => $nu->member_gender,
                "place_of_birth"       => $nu->place_of_birth,
                "Relation"       => $nu->relation,
            );
           $i++;
      }
  
    }
    //header("Content-Description: File Transfer"); 
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"export_member".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');

        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
        fclose($handle);
        exit;
}

    public function transaction_view()
    {
        $template['page'] = "Patientdetails/transaction_view";
        $template['page_title'] = "View Transaction History";
        $id = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $id;
        $template['data'] = $this->Patient_model->get_transactiondetails($id);
        $this->load->view('template', $template);
    }

    public function send_single()
    {
        // $config = array();
        // $config["base_url"] = base_url() . "User_details/send_single";
        // $config["total_rows"] = $this->db->get_where('user_notification',array('type'=>'admin'))->num_rows();
        // $config['per_page'] = 10;
        // $config["uri_segment"] = 3;
        // $choice = $config["total_rows"]/$config["per_page"];
        // $config["num_links"] = floor($choice);
        // $config['full_tag_open'] = '<ul class="pagination">';
        // $config['full_tag_close'] = '</ul>';
        // $config['first_link'] = false;
        // $config['last_link'] = false;
        // $config['first_tag_open'] = '<li>';
        // $config['first_tag_close'] = '</li>';
        // $config['prev_link'] = 'Prev';
        // $config['prev_tag_open'] = '<li class="prev">';
        // $config['prev_tag_close'] = '</li>';
        // $config['next_link'] = 'Next';
        // $config['next_tag_open'] = '<li>';
        // $config['next_tag_close'] = '</li>';
        // $config['last_tag_open'] = '<li>';
        // $config['last_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li class="active"><a href="#">';
        // $config['cur_tag_close'] = '</a></li>';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';

        // $this->pagination->initialize($config);
        // $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // $template['notification'] = $this->Patient_model->get_pagination_data_notify($config["per_page"],$template['page'],'user_notification','admin');
        // $template["links"] = $this->pagination->create_links();


        $template['page'] = "Patientdetails/send_single_notification";
        $template['page_title'] = "Send Single Notification";
        $id = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $id;
          // $template['data'] = $this->db->get('user')->where('status', '1')->result();
          $template['users'] = $this->db->get_where('user', array('status' => 1))->result();
          // echo $this->db->last_query();  die;
        $this->load->view('template', $template);
    }

    public function send_to_all()
    {
        $config = array();
        $config["base_url"] = base_url() . "User_details/send_to_all";
        $config["total_rows"] = $this->db->get_where('user_notification',array('type'=>'admin_all'))->num_rows();
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 10;
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
        $template['notification'] = $this->Patient_model->get_pagination_data_notify($config["per_page"],$template['page'],'user_notification','admin_all');
        $template["links"] = $this->pagination->create_links();
        $template['page'] = "Patientdetails/send_all_notification";
        $template['page_title'] = "Send Notification to All";
        $id = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $id;
        $template['data'] = $this->db->get_where('user', array('status' => 1))->result();
        $this->load->view('template', $template);
    }
    public function send_single_notification()
    {
        if(!empty($_POST))
        {
      // print_r($_POST); die;

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
          $selected_android_user1 = array();
          $selected_ios_user1 = array();
          $user_array =     explode('(', $this->input->post('name'));
          $phone_number = rtrim($user_array[1], ") ");

          $user_id = $_POST['user_id'];
          // $device_token = $this->db->query("SELECT * FROM `user` WHERE status = 1 AND  device_token !='' AND phone = $phone_number")->result();

          $device_token = $this->db->query("SELECT * FROM `user` WHERE status = 1 AND  device_token !='' AND id = $user_id")->result();

          if($device_token->device_type == 'android'){
            $notification_type1 = "text";
            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title.'","msg":"'.$message.'","image":"'.$image.'","type":"no"}';
            $message2 = array(
                         'body' => $message,
                         'title' => $title,
                         'image' => $image,
                         'sound' => 'Default'
                     );
                     $a = $this->sendMessageThroughFCM([$device_token->device_token],$message2);
          }else{
            $notification_type1 = "text";
            $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title.'","msg":"'.$message.'","type":"no"}';
            $message2 = array(
                    'body' => $message,
                    'title' => $title,
                    'sound' => 'Default'
                );
                $a = $this->send_ios_notification([$device_token->device_token],$message2,"ios");
          }
          $insert_array = array('user_id' => $user_id,
          'title' => $title,
           'image' => $image,
          'notification' => $message,
          'type' => 'admin',
          'added_on' => date('Y-m-d H:i:s')
          );
          // print_r($insert_array);die;

          $insert = $this->db->insert('user_notification',$insert_array);
  
          $this->session->set_flashdata('message', array('message' => 'Notification sent successfully.','class' => 'success'));
          redirect($this->agent->referrer());

        }
    }

    public function send_to_all_notification()
    {
      
        if(!empty($_POST))
        {
          $message = $this->input->post('message');
          $title = $this->input->post('title');        
          $selected_android_user1 = array();
          $selected_ios_user1 = array();
          $device_token = $this->db->query("SELECT * FROM `user` WHERE status = 1 AND notification_config = 1")->result();
          // $device_token = $this->db->query("SELECT * FROM `user` WHERE id = 10")->result();
          $userID = '';
          foreach($device_token as $u)
          {
              $mobile = $u->phone;    
              $userID.=$u->id.",";
                  // $this->sendsms($mobile,$message);
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
                        $a = $this->send_ios_notification($RegId1,$message2,"ios");
                       }
                }

                $insert_array = array('user_id' => $getuserID,
                                    'title' => $title,
                                    'notification' => $message,
                                    'type' => 'admin_all',
                                    'added_on' => date('Y-m-d H:i:s')
                                    );
              $insert = $this->db->insert('user_notification',$insert_array);
              if($insert)
              {
                redirect(base_url('User_details/send_to_all'));
              }
            }
        }
        
        
    }
    public function sendMessageThroughFCM($registatoin_ids, $message)
    {
   
         // $k = 'AAAAde4zwbU:APA91bF2eh_-9PawWtsP8Krt5bx6fOqICeq8D_G6TPmDGmSqhH6RGCexdf6ZANf9ATlNQuznDFjToucUg42OoBvwB-rF9SZj-usmHobxM7oekCjX1vQLqHOibjTVOe9jkKPAQQs_LzsH';
// AAAAde4zwbU:APA91bF2eh_-9PawWtsP8Krt5bx6fOqICeq8D_G6TPmDGmSqhH6RGCexdf6ZANf9ATlNQuznDFjToucUg42OoBvwB-rF9SZj-usmHobxM7oekCjX1vQLqHOibjTVOe9jkKPAQQs_LzsH

        // }

        $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $android_firbase = $settings->firebase_key;  
        $k = $android_firbase;
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

    public function send_ios_notification($device_token,$message_text,$type)
    {
      // print_r($message_text['body']); die;
      // $message_text ="hello";
      @$payload='{"aps":{"alert":"'.$message_text['body'].'","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"genral"}';

        // @$payload='{"aps":{"alert":"'.$message_text.'","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"genral"}';
        //include_once("Cow.pem");
        $ctx=stream_context_create();
        stream_context_set_option($ctx,'ssl','local_cert','/var/www/html/kundali_expert/notification_key/kundali.pem');
        // $fp=stream_socket_client('ssl://gateway.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        @$fp=stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        if($fp)
        {
        // echo "Connected".$err;
        }
        foreach ($device_token as $key)
         {
          // print_r($key); die;

        $msg=chr(0).pack("n",32).pack("H*",str_replace(' ','',$key)).pack("n",strlen($payload)).$payload;
        // @$msg=chr(0).pack("n",32).pack("H*",str_replace(' ','',$device_token)).pack("n",strlen($payload)).$payload;
        // print_r($msg); die;
         }

        @$res=fwrite($fp,$msg);
        if($res)
        {
         //print_r($res);  
        }
        fclose($fp);
        return true;
    }


    public function export_notification()
    { 
        $uri = $this->uri->segment(3);
        $data[] = array('S.No.', 'UserID', 'Title', 'Message', 'DateTime');
        if($uri == 'specific')
        {
          $pp = $this->db->where(array('type'=> 'admin'))->get('user_notification')->result();
        }
        elseif($uri == 'send_all')
        {
          $pp = $this->db->where(array('type'=> 'admin_all'))->get('user_notification')->result();
        }
        
        if(count($pp) > 0 && !empty($pp)){
          $i=1;
        foreach($pp as $nu)
        {
            $data[] = array(
                "s.no"             => $i,
                "UserID"           => $nu->user_id,
                "Title"            => $nu->title,
                "Message"          => $nu->notification,
                "DateTime"         => $nu->added_on,
            );
           $i++;
        }
  
        }
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"export_specific_notification".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');

        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
        fclose($handle);
        exit;
    }




    public function history()
    {
        $template['page'] = "Patientdetails/history";
        $template['page_title'] = "View Member history Details";
        $id = htmlentities(trim($this->uri->segment(3)));
        $template["patientID"] = $id;
        $template['online_data'] = $this->Patient_model->get_doc_history_details($id);
        $template['lab_data'] = $this->Patient_model->get_lab_history_details($id);
        $template['pharmacy_data'] = $this->Patient_model->get_pharmacy_history_details($id);
        $template['quotation_data'] = $this->Patient_model->get_quotation_history_details($id);
        // print_r($template['lab_data']);die;
        $this->load->view('template', $template);
    }


     public function history_details()
    {
          $user_id = trim($this->input->post('user_id'));
          $query ='SELECT *  FROM booking WHERE status = 1 AND patient_id = "'.$user_id.'"  ';
          $complete_booking = $this->db->query($query)->num_rows();

          $query2 ='SELECT *  FROM booking WHERE status = 0 AND patient_id = "'.$user_id.'"  ';
          $new_booking = $this->db->query($query2)->num_rows();
        //  print_r($new_booking); die;
          $query3 ='SELECT * FROM booking WHERE `status` IN(2, 3) AND patient_id = "'.$user_id.'"  ';
          $cancel_booking = $this->db->query($query3)->num_rows();

          $query4 ='SELECT * FROM booking WHERE  patient_id = "'.$user_id.'"  ';
          $total_booking = $this->db->query($query4)->num_rows();

          $query5 ='SELECT * FROM `booking_medical_cart` WHERE `equipment_type` = "Rental" AND  order_id = "'.$user_id.'"  ';
          $total_rentals = $this->db->query($query5)->num_rows();

          $query6 ='SELECT * FROM `booking_medical_cart` WHERE `equipment_type` = "Purchase" AND  order_id = "'.$user_id.'"  ';
          $total_purchase = $this->db->query($query6)->num_rows();

          $query7 ='SELECT * FROM `booking_medical_cart` WHERE  order_id = "'.$user_id.'"  ';
          $total_equipment = $this->db->query($query7)->num_rows();

          $query8 ='SELECT * FROM `booking_medical_cart` WHERE status = 1 AND  order_id = "'.$user_id.'"  ';
          $complete_equipment = $this->db->query($query8)->num_rows();

          $query9 ='SELECT * FROM `booking_medical_cart` WHERE status = 0 AND  order_id = "'.$user_id.'"  ';
          $new_equipment = $this->db->query($query9)->num_rows();

          $query10 ='SELECT * FROM `booking_medical_cart` WHERE `status` IN(2, 3) AND  order_id = "'.$user_id.'"  ';
          $cancel_equipment = $this->db->query($query10)->num_rows();

         $query11 ='SELECT * FROM `booking_medical_cart` WHERE `refund_status` = 1 AND  order_id = "'.$user_id.'"  ';
          $refund_equipment = $this->db->query($query11)->num_rows();

           $query12 ='SELECT * FROM `ambulence_booking` WHERE  user_id = "'.$user_id.'"  ';
          $total_ambulence_booking = $this->db->query($query12)->num_rows();

          $query13 ='SELECT * FROM `surgery_enquiry_quotation` WHERE  user_id = "'.$user_id.'"  ';
          $total_surgery_enquiry = $this->db->query($query13)->num_rows();



          $query14 ='SELECT * FROM `booking_test` WHERE  status = 1 AND  patient_id  = "'.$user_id.'"  ';
          $lab_complete_test = $this->db->query($query14)->num_rows();

          $query15 ='SELECT * FROM `booking_test` WHERE status = 0 AND patient_id  = "'.$user_id.'"  ';
          $lab_new_test = $this->db->query($query15)->num_rows();

          $query16 ='SELECT * FROM `booking_test` WHERE `status` IN(2, 3) AND  patient_id  = "'.$user_id.'"  ';
          $lab_cancel_test = $this->db->query($query16)->num_rows();

          $query17 ='SELECT * FROM `booking_test` WHERE  patient_id  = "'.$user_id.'"  ';
          $lab_total_test = $this->db->query($query17)->num_rows();

          $query18 ='SELECT * FROM `booking_test` WHERE `refund_status` = 1 AND patient_id  = "'.$user_id.'"  ';
          $lab_refund_test = $this->db->query($query18)->num_rows();
          // echo $this->db->last_query();die;

          if (count($new_booking) > 0) 
          {
            $arra = array("status"=>true,"new_booking"=>$new_booking,"complete_booking"=>$complete_booking,"cancel_booking"=>$cancel_booking,"total_booking"=>$total_booking,"total_rentals"=>$total_rentals,"total_purchase"=>$total_purchase,"total_equipment"=>$total_equipment,"complete_equipment"=>$complete_equipment,"cancel_equipment"=>$cancel_equipment,"refund_equipment"=>$refund_equipment,"total_ambulence_booking"=>$total_ambulence_booking,"total_surgery_enquiry"=>$total_surgery_enquiry,"lab_complete_test"=>$lab_complete_test,"lab_new_test"=>$lab_new_test,"lab_cancel_test"=>$lab_cancel_test,"lab_total_test"=>$lab_total_test,"lab_refund_test"=>$lab_refund_test,"new_equipment"=>$new_equipment);
          }
          else
          {
            $arra = array("status"=>false);
          }
          echo  json_encode($arra);   
        
 
    }

    public function timeline()
    {
        $template['page'] = "userdetails/timeline";
        $template['page_title'] = "View Timeline";
        $id = htmlentities(trim($this->uri->segment(3)));
        $template["user_id"] = $id;
        $template['u_data'] = $this->Patient_model->get_single_patient($id);
        $this->load->view('template', $template);
    }




}