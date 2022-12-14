<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_detailsview extends CI_Controller {
	public function __construct() {
		parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $this->load->model('Admin_model');
		 		$this->load->model("Speedhuntson_m","c_m");
		 if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		 }
    }
	public function index()
	{
		
	$template['page'] = 'Viewadmindetails/index';
	$template['page_title'] = "Admin List";					
	// $id = $this->session->userdata('logged_in')['id'];



	  if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
            	$email =  $this->input->post('email');
            	$check = $this->db->query('SELECT * FROM `admin` where  email = "'.$email.'"')->result();
	            if (count($check) > 0) 
	            {
	                $this->session->set_flashdata('message',array('message' => 'Same email already exist','class' => 'danger'));
	                 redirect($this->agent->referrer());
	            }
	            else{
	            	$array = array(
						"username"=>$this->input->post("username"),
						"user_type"=>$this->input->post("user_type"),
						"email"=>$this->input->post("email"),
						"password"=>md5($this->input->post("password")),
						"mobile"=>$this->input->post("mobile"),
						"added_on"=>date('Y-m-d H:i:s'),
						"status"=>$this->input->post("status"),
						"added_by"=>$this->session->userdata('id')
                          );
                $this->db->insert('admin',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
	            }

                
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array(
                	"username"=>$this->input->post("username"),
						"user_type"=>$this->input->post("user_type"),
						"email"=>$this->input->post("email"),
						"mobile"=>$this->input->post("mobile"),
						"status"=>$this->input->post("status"),
                              );
                $create = $this->c_m->get_all_result($array,'update','admin',array('id'=>$id));

                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }



	$query1 = 'SELECT * FROM `role` ORDER BY `id` ASC';
	$template['role'] = $this->c_m->get_all_result($query1,'select','','');


	$template['result'] = $this->Admin_model->get_Admin();
	//print_r($template['result']);die;
	$this->load->view('template', $template);
		
		
	}
	public function role(){
		
	$template['page'] = 'Viewadmindetails/role';
	$template['page_title'] = "Admin Role";					
	$id = $this->session->userdata('logged_in')['id'];
	$template['result'] = $this->Admin_model->get_role();
	if($_POST) {
		$data = $_POST;
		$d['name'] = $data['name'];
		$this->db->insert("role",$d);
		$this->session->set_flashdata('message', array('message' => 'Role Added successfully', 'title' => 'Success !', 'class' => 'success'));
	    redirect(base_url().'Admin_detailsview/role');  
	}
	//print_r($template['result']);die;
	$this->load->view('template', $template);
		
		
	}
	public function access(){
		
	$template['page'] = 'Viewadmindetails/access';
	$template['page_title'] = "Access Management";					
	$id = $this->session->userdata('logged_in')['id'];
	$template['result'] = $this->Admin_model->get_role();
	
	if($_POST) {
		$data = $_POST;
		$template['role_id'] = @$data['role'];
		$template['side_bar_list'] = $this->Admin_model->get_menu_list();
		
		if(@$data['submit'] == 'submit') {
			$role_id = $data['role_id'];
			  $query = $this->db->query("DELETE FROM `permissions` WHERE `role_id` = '$role_id'");
			for($i = 0; $i<count($data['menu_id']); $i++) {
				if(@$data['menu'.$data['menu_id'][$i]]) {
				$d['role_id'] = $role_id;
				$d['menu_id'] = @$data['menu'.$data['menu_id'][$i]];
				$this->db->insert('permissions',$d);
				}
			}
			$this->session->set_flashdata('message', array('message' => 'Access Updated successfully', 'title' => 'Success !', 'class' => 'success'));
			redirect(base_url().'Admin_detailsview/access');
		}
		  
		
	}
	//print_r($template['result']);die;
	$this->load->view('template', $template);
		
		
	}
	public function Admin_change_password(){
		$template['page'] = 'Viewadmindetails/View-admin-profile';
		$template['page_title'] = "View Admin profile";					
		$id = $this->session->userdata('logged_in')['id'];
		if(isset($_POST) and !empty($_POST)) {
			if(isset($_POST['reset_pwd'])) {
			$data = $_POST;
				if($data['n_password'] !== $data['c_password']) {
					$this->session->set_flashdata('message', array('message' => 'Password doesn\'t match', 'title' => 'Error !', 'class' => 'danger'));
					redirect(base_url().'Admin_detailsview/Admin_profile_view');
				}
				else {
					unset($data['c_password']);						
					$result = $this->Admin_model->update_admin_passwords($data, $id);
					// echo $this->db->last_query(); die;
					// print_r($result ); die;
					if($result) {
						if($result === "notexist") {
							$this->session->set_flashdata('message', array('message' => 'Invalid Password', 'title' => 'Warning !', 'class' => 'warning'));
							redirect(base_url().'Admin_detailsview/Admin_profile_view');
						}
						else {
							$this->session->set_flashdata('message', array('message' => 'Password updated successfully', 'title' => 'Success !', 'class' => 'success'));
							redirect(base_url().'Admin_detailsview/Admin_profile_view');
						}
					}
					else {
						$this->session->set_flashdata('message', array('message' => 'Sorry, Error Occurred', 'title' => 'Error !', 'class' => 'danger'));
						redirect(base_url().'Admin_detailsview/Admin_profile_view');
					}
				}
			}
		}
	$this->load->view('template', $template);
	}
	   public function Admin_profile_view() {
			$template['page'] = 'Viewadmindetails/View-admin-profile';
			$template['page_title'] = "View Admin profile";			
			$id = $this->session->userdata('logged_in')['id'];
			if(isset($_POST['picturechecker']) && !empty($_POST['picturechecker'])){	
				if(isset($_FILES['profile_picture'])) {
				$config = set_upload_profilepic('assets/uploads/profile_pic/admin');
				$this->load->library('upload');
				$new_name = time()."_".$_FILES["profile_picture"]['name'];
				$config['file_name'] = $new_name;
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('profile_picture')) {
						unset($data['profile_picture']);
				}
				else{
					$upload_data = $this->upload->data();
					$data['username'] = $this->session->userdata('logged_in')['username'];
					$data['profile_picture'] =$config['upload_path']."/".$upload_data['file_name'];
					if($id == $this->session->userdata('logged_in')['id']) {
							$this->session->set_userdata('profile_picture',$data['profile_picture']);	
					}
				}
				$result = $this->Admin_model->update_admin_profile($data, $id);							
			}
			}
			$template['data'] = $this->Admin_model->get_admin_profile_details($id);
			$this->load->view('template', $template);
	   }	



	     public function delete_admin() {
	  	
		 $id = $this->uri->segment(3);
		           
		$result= $this->delete_admin_data($id);
		// echo $this->db->last_query(); die;
		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
	    redirect($this->agent->referrer());
	 }	 

	     public function delete_admin_data($id){ 
     
     	
		 $this->db->where('id',$id);
		 $result = $this->db->delete('admin');
		 if($result) {
			return "success"; 
		 }
		 else {
			 return "error";
		 }
		
	 } 
}	


