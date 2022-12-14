<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Astrologers_admin extends CI_Controller {
	public function __construct() {
		parent::__construct();		
		date_default_timezone_set("Asia/Kolkata");
        $this->load->helper(array('form'));
		$this->load->model('login_model');
		$this->load->model('Astrologers_model');
	    $this->load->library('pagination');
		$this->load->model('Settings_model');		
		// if($this->session->userdata('logged_in')) { 
		// 	redirect(base_url().'welcome');
		// }		
 	}

 	public function checkLogin(){
    	$id=$this->session->userdata('astrologer_id');
    	//print_r($id);die;
    	if(empty($id)){
    		redirect('login');
    	}
    }


 	public function index()
	{
		$this->login();
	}

	public function login(){
		//print_r("shubha,");die;
		$data['page_title']="Astrologers| Login";
		$dataArray=array();
		if($this->input->post()){
			//print_r($_POST);die;
			$username=$this->input->post('username');
			$password=md5($this->input->post('password'));
			
			$check=$this->Astrologers_model->login($username,$password);
			if($check=='1'){
			$this->Astrologers_model->message('You have Successfully login', 'success', 'success');
            redirect('astrologers_admin/Astrologers_admin/astrologersdashboard');
			}
		else if($check=='2'){//Deactive Account
			 $this->Astrologers_model->message('Your Account has been blocked,Please contact to Admin!', 'error', 'error');
			}
			else{
			$this->Astrologers_model->message('Invalid credential,please enter valid Username and Password!', 'error', 'error');
			}	
				
		}
		
		$this->load->view('Astrologers_admin/astrologers_login');
	}




  public function astrologersdashboard()
  {
    // print_r("shubham");die;
    $this->checkLogin();
    $template['page'] = "Astrologers_admin/astrologer_dashboard";
    $template['page_title'] = "Dashboard";
    $template['data'] = "Dashboard page";
    $this->load->view('templates_astrologers', $template);
    
  }




  public function forgot_password(){
    //print_r("shubha,");die;
    $data['page_title']="Lab| forgot Password";
    $dataArray=array();
    if ($_POST) 
    {
     
    if($this->input->post()){
      $email=$this->input->post('email');
      $check = $this->Astrologers_model->checkUser($email);
      // print_r($check);die;
       if($check){
        $email = $this->input->post('email');
        $code = $this->RandomString(10);
        $update = $this->Astrologers_model->updatepassword($email, $code);

      // echo $this->db->last_query(); die;
        if($update)
        {
          $this->Astrologers_model->message('Mail Send Successfully, Please check your email. ', 'success', 'success');
          $this->forgot_send_email($email,$code);
           redirect('lab-login');
          
        }
         else
         {
      $this->Astrologers_model->message('Something is wrong, Please try again', 'error', 'error');
       redirect('lab-login');
      } 
        } 
  
     
        
    }
    }
    
    $this->load->view('Labdetails/labdashboard/forgot_password');
  }


  public function forgot_send_email($email,$code)
  {
       $this->load->library('My_PHPMailer');
        $this->load->helper('string');
         $settings = $this->db->get_where('settings',array('id'=>1))->row();
        $subject = "Paasword change" ;
        $body= 'Your password is - '.$code.'';
        $mail = new PHPMailer;
        $mail->isSMTP();  
        $mail->Host = $settings->smtp_host;//'smtp.gmail.com'; //'md-70.webhostbox.net';
        $mail->SMTPAuth = true;
        $mail->Username = $settings->smtp_username;//'form41app@gmail.com'; //'mail@appsgenic.com';
        $mail->Password = $settings->smtp_password;//'appslure123'; // '@appsgenic123@';
        $mail->SMTPSecure = 'tls';
        $mail->Port =587;
        $mail->From = 'no-reply@picasoid.com';
        $mail->FromName = 'Picasoid';
         // $mail->AddCC($lab_email, 'ANYTIMEDOC');
        $mail->AddCC($email, 'Picasoid');
        // $mail->addAddress($lab_email, 'ANYTIMEDOC');
        $mail->WordWrap = 500;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        if(!$mail->send())
        {
          // echo "not send"; die;
            return false;
        }
        else
        {
          // echo "Done"; die;
            return true;
        }  
  }

    public function RandomString($len)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $len; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
  }


	

  public function profile_astrologers()
    {
    $this->checkLogin();
    $id = $_SESSION['astrologer_id'];
    if ($_POST) 
    {
       if (!empty($_FILES['image']['name'])) 
          {
              $target_path = "uploads/astrologers/"; 
              $target_dir = "uploads/astrologers/";
              $target_file = $target_dir . basename($_FILES["image"]["name"]);
              $imagename = basename($_FILES["image"]["name"]);
              $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
              $actual_image_name = time().".".$extension;
              move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
          }
          else{
                $actual_image_name = $this->input->post("old_image");
          }

           $array = array(
                          "image"=>$actual_image_name,
                          "name"=>$this->input->post("name"),
                          "gender"=>$this->input->post("gender"),
                          "languages"=>$this->input->post("languages"),
                          "email"=>$this->input->post("email"),
                          "phone"=>$this->input->post("phone"),
                       
                          );
          $create = $this->Astrologers_model->get_all_result($array,'update','astrologers',array('id'=>$id));
    }
    $template['page'] = "Astrologers_admin/profile_astrologers";
    $template['page_title'] = "Edit Test Packages";
    $template['data'] = $this->Astrologers_model->get_single_astrologer($id);
   
    $this->load->view('templates_astrologers',$template);  
  }



   public function change_password(){
    // print_r("expression");die;
      $template['page'] = 'Astrologers_admin/change_password';
      $template['page_title'] = "Change Password";         
      $id = $_SESSION['astrologer_id'];
      if(isset($_POST) and !empty($_POST)) {
        if(isset($_POST['reset_pwd'])) {
        $data = $_POST;
          if($data['n_password'] !== $data['c_password']) {
            $this->session->set_flashdata('message', array('message' => 'Password doesn\'t match', 'title' => 'Error !', 'class' => 'danger'));
            redirect(base_url().'astrologers_admin/Astrologers_admin/change_password');
          }
          else {
            unset($data['c_password']);           
            $result = $this->Astrologers_model->update_astrologers_passwords($data, $id);
            // echo $this->db->last_query(); die;
            if($result) {
              if($result === "notexist") {
                $this->session->set_flashdata('message', array('message' => 'Invalid Password', 'title' => 'Warning !', 'class' => 'warning'));
                 redirect('astrologers_admin/Astrologers_admin/change_password');
                // redirect(base_url().'Lab_admin/change_password');
              }
              else {
                $this->session->set_flashdata('message', array('message' => 'Password updated successfully', 'title' => 'Success !', 'class' => 'success'));
                redirect('astrologers_admin/Astrologers_admin/change_password');
              }
            }
            else {
              $this->session->set_flashdata('message', array('message' => 'Sorry, Error Occurred', 'title' => 'Error !', 'class' => 'danger'));
             redirect('astrologers_admin/Astrologers_admin/change_password');
            }
          }
        }
      }
    $this->load->view('templates_astrologers', $template);
  }



   public function chat_history(){
    // print_r("expression");die;
      $template['page'] = 'Astrologers_admin/chat_history';
      $template['page_title'] = "Chat History";         
      $id = $_SESSION['astrologer_id'];
    
    $this->load->view('templates_astrologers', $template);
  }




	function logged() {
		$this->session->unset_userdata('astrologer_id');
		session_destroy();
    // print_r("expression");die;
    redirect(base_url('astrologers_admin/Astrologers_admin//'));
		// redirect(base_url()/'Lab-admin');
	}


   public function reviews()
    {
        if($_POST){
        }
        $query = 'SELECT * FROM `venues` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->Astrologers_model->get_all_result($query,'select','','');
        $template['page'] = "Astrologers_admin/reviews";
        $template['page_title'] = "Reviews";
        $this->load->view('templates_astrologers',$template);  

    } 


  public function view_bank_details(){
      $this->checkLogin();
      $id = $_SESSION['astrologer_id'];
      $template['page'] = 'Astrologers_admin/view_bank_details';
      $template['page_title'] = "view_bank_details";   

      $query = 'SELECT * FROM `astrologers` WHERE `id` = '.$id.' ORDER BY `name` ASC';
      $template['list'] = $this->db->query('SELECT * FROM `astrologers` WHERE `id` = '.$id.' ORDER BY `name` ASC')->row();   
     // echo $this->db->last_query(); die;
    $this->load->view('templates_astrologers', $template);
  }


  public function bank_details()
    {
    $this->checkLogin();
    $id = $_SESSION['astrologer_id'];
    if ($_POST) 
    { 
         $array = array(
                        
                          "beneficiary_name"=>$this->input->post("beneficiary_name"),
                          "bankName"=>$this->input->post("bankName"),
                          "account_type"=>$this->input->post("account_type"),
                          "bank_account_no"=>$this->input->post("bank_account_no"),
                          "ifsc_code"=>$this->input->post("ifsc_code"),
                          "branch_name"=>$this->input->post("branch_name"),
                          "gst_number"=>$this->input->post("gst_number"),
                          "pan_number"=>$this->input->post("pan_number"),
                          "bank_address"=>$this->input->post("bank_address"),
                          );
          $create = $this->Astrologers_model->get_all_result($array,'update','astrologers',array('id'=>$id));
    }
    $template['page'] = "Astrologers_admin/bank_details";
    $template['page_title'] = "Edit Test Packages";
    $template['data'] = $this->Astrologers_model->get_single_astrologer($id);
   
    $this->load->view('templates_astrologers',$template);  
  }






       public function reviews_list($x='',$rowno = 1)
    {
       $this->checkLogin();
      $id = $_SESSION['astrologer_id'];
        $rowperpage = 30;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = $this->count_total_reviews();
        $s = $this->get_total_reviews_paginate($rowno, $rowperpage);
        // echo $this->db->last_que ry(); die;
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
        $template['page'] = "Astrologers_admin/reviews_list";
        $template['page_title'] = "reviews_list";
        $template['links'] = $this->pagination->create_links();
        $template['list'] = $s;
        $template['row'] = $rowno;
        $this->load->view('templates_astrologers',$template);  
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
        $this->db->group_by('id');
        $query = $this->db->get();
        return count($query->result());

    }


     private function get_total_reviews_paginate($start = 0, $limit)
    {
           if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['boy_name']) || isset($_GET['girl_name']) || isset($_GET['mobile'])) 
           {
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
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }




       public function earnings_list($x='',$rowno = 1)
    {

       $this->checkLogin();
      $id = $_SESSION['astrologer_id'];
        $rowperpage = 30;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = $this->count_total_earnings();
        $s = $this->get_total_earnings_paginate($rowno, $rowperpage);
        // echo $this->db->last_que ry(); die;
        $uri = $this->uri->segment(3);
        $config['base_url'] = base_url() . "Astrologers_admin/astrologers_admin/earnings_list/".$uri;
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
        $template['page'] = "Astrologers_admin/earnings_list";
        $template['page_title'] = "earnings";
        $template['links'] = $this->pagination->create_links();
        $template['list'] = $s;
        $template['row'] = $rowno;
        $this->load->view('templates_astrologers',$template);  
    }


    private function count_total_earnings()
    {
      $uri = $this->uri->segment(3);      
        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['girl_name']) || isset($_GET['mobile'])) {

            if($_GET['name'] != '')
            {
                $this->db->or_like('user_name', $_GET['name']);
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
        
        $this->db->select('*');
        $this->db->from('bookings');
        $this->db->group_by('id');
        $query = $this->db->get();
        return count($query->result());

    }


     private function get_total_earnings_paginate($start = 0, $limit)
    {
           if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['girl_name']) || isset($_GET['mobile'])) 
           {
            if($_GET['name'] != '')
            {
              
                 $this->db->or_like('user_name', $_GET['name']);
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
        $this->db->from('bookings');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }




    public function posts()
    {
         $this->checkLogin();
          $id = $_SESSION['astrologer_id'];
        if($_POST){
            // print_r($_FILES); die;
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/post/"; 
                $target_dir = "uploads/post/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);

                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array(
                      "thumbnail"=>$actual_image_name,
                      // "media"=>$actual_file_name,
                      "astrologer_id"=>$id,           
                      "name"=>$this->input->post("name"),                         
                      "description"=>$this->input->post("description"),                         
                      "status"=>$this->input->post("status"),                         
                      "media_type"=>3,                         
                          );
                    $this->db->insert('posts',$array);
                    // echo $this->db->last_query(); die;
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
                }
                else
                {
                    $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                
            }
            elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];

                  if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/post/"; 
                    $target_path = "uploads/post/"; 
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                }
                else{
                      $actual_image_name = $this->input->post("old_image");
                }
              


                
                    $array = array(  
                    
                       "thumbnail"=>$actual_image_name,
                      // "media"=>$actual_file_name,
                                         
                      "name"=>$this->input->post("name"),                         
                      "description"=>$this->input->post("description"),                         
                      "status"=>$this->input->post("status")                         


                      ,);
                    $create = $this->Astrologers_model->get_all_result($array,'update','posts',array('id'=>$id));
                    // echo $this->db->last_query(); die;
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
               
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }

        $query = 'SELECT * FROM `posts` WHERE `status` <> "2" AND astrologer_id = '.$id.' ORDER BY `id` ASC';
        $template['list'] = $this->Astrologers_model->get_all_result($query,'select','','');
     
        $template['page'] = "Astrologers_admin/posts_list";
        // $template['page'] = "sd/app_management/posts";
        $template['page_title'] = "Post";
        $this->load->view('templates_astrologers',$template);
    }

    public function delete_posts()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->Astrologers_model->get_all_result($array,'update','posts',array('id'=>$id));
        if ($create) 
        {
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully!','class' => 'success'));
            redirect($this->agent->referrer());   
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
            redirect($this->agent->referrer());
        }
    }


    public function support()
    {
         $this->checkLogin();
          $id = $_SESSION['astrologer_id'];
        if($_POST){
            // print_r($_FILES); die;
            $data = $_POST;
            if(isset($data['save_category']))
            {
                    $array = array(                     
                      "astrologer_id"=>$id,           
                      "subject"=>$this->input->post("subject"),                         
                      "message"=>$this->input->post("message"),                         
                                         
                          );
                    $this->db->insert('astrologers_support',$array);
                    // echo $this->db->last_query(); die;
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
               
                
            }
          
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }

        $query = 'SELECT * FROM `astrologers_support` WHERE  astrologer_id = '.$id.' ORDER BY `id` ASC';
        $template['list'] = $this->Astrologers_model->get_all_result($query,'select','','');
     
        $template['page'] = "Astrologers_admin/support";
        // $template['page'] = "sd/app_management/posts";
        $template['page_title'] = "Support ";
        $this->load->view('templates_astrologers',$template);
    }


    public function schedule_vacation()
    {
         $this->checkLogin();
          $id = $_SESSION['astrologer_id'];
        if($_POST){
            // print_r($_FILES); die;
            $data = $_POST;
            if(isset($data['save_category']))
            {
                    $array = array(                     
                      "astrologer_id"=>$id,           
                      "from_date"=>$this->input->post("from_date"),                         
                      "to_date"=>$this->input->post("to_date"),                         
                      "status"=>$this->input->post("status"),                         
                                         
                          );
                    $this->db->insert('schedule_vacation',$array);
                    // echo $this->db->last_query(); die;
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
               
                
            }
            elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                    $array = array(         
                      "from_date"=>$this->input->post("from_date"),                         
                      "to_date"=>$this->input->post("to_date"),                         
                      "status"=>$this->input->post("status"),                       
                      );
                    $create = $this->Astrologers_model->get_all_result($array,'update','schedule_vacation',array('id'=>$id));
                    // echo $this->db->last_query(); die;
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
               
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }

        $query = 'SELECT * FROM `schedule_vacation` WHERE `status` <> "2" AND astrologer_id = '.$id.' ORDER BY `id` ASC';
        $template['list'] = $this->Astrologers_model->get_all_result($query,'select','','');
     
        $template['page'] = "Astrologers_admin/schedule_vacation";
        // $template['page'] = "sd/app_management/posts";
        $template['page_title'] = "Schedule Vacation";
        $this->load->view('templates_astrologers',$template);
    }

    public function delete_schedule_vacation()
    {
      // print_r("expression"); die;
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->Astrologers_model->get_all_result($array,'update','schedule_vacation',array('id'=>$id));
        if ($create) 
        {
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully!','class' => 'success'));
            redirect($this->agent->referrer());   
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
            redirect($this->agent->referrer());
        }
    }

     public function schedule_vacation_status()
    {
        $id = $this->uri->segment(4);
        $status = $this->uri->segment(5);
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
        $s = $this->db->query("UPDATE `schedule_vacation` SET `status`='$status' WHERE `id`='$id'");
        $this->session->set_flashdata('message', array(
            'message' => 'Schedule Vacation Successfully '.$a,
            'class' => $class
        ));
        redirect($_SERVER['HTTP_REFERER']);
    }


        public function performance()
    {

      $this->checkLogin();
      $id = $_SESSION['astrologer_id'];
     

     
    $template['new_user_data'] = $this->db->query("SELECT DATE(created_at) as  created_at, sum(payable_amount)  as score_user from bookings WHERE status = 1 AND created_at BETWEEN DATE_SUB( CURDATE() + INTERVAL 1 DAY ,INTERVAL 30 DAY ) AND CURDATE() + INTERVAL 1 DAY GROUP BY DATE(created_at)")->result();
 // echo $this->db->last_quzery(); die;
      $template['new_user_data_total'] = $this->db->query("SELECT MAX(s.score_user) as max_user FROM (SELECT DATE(created_at) as  created_at, sum(payable_amount)  as score_user from bookings WHERE status = 1 AND created_at BETWEEN DATE_SUB( CURDATE() + INTERVAL 1 DAY ,INTERVAL 30 DAY ) AND CURDATE() + INTERVAL 1 DAY GROUP BY DATE(created_at)
) as s;")->row();

       // echo $this->db->last_query(); die;
       $template['page'] = "Astrologers_admin/performance";
      $template['page_title'] = "Graph";
        // print_r($template['new_user_data']); die;
      $this->load->view('templates_astrologers',$template);
    }   






}
