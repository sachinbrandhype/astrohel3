<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();		
		date_default_timezone_set("Asia/Kolkata");
        $this->load->helper(array('form'));
		$this->load->model('login_model');
		$this->load->model('Settings_model');		
		// if($this->session->userdata('logged_in')) { 
		// 	redirect(base_url().'welcome');
		// }		
 	}
	 function getMacLinux() {
		 //Buffering the output
		 ob_start();  
   
		 //Getting configuration details 
		 system('ipconfig /all');  
		 
		 //Storing output in a variable 
		 $configdata=ob_get_contents();  
		 
		 // Clear the buffer  
		 ob_clean();  
		 
		 //Extract only the physical address or Mac address from the output
		 $mac = "Physical";  
		 $pmac = strpos($configdata, $mac);
		 
		 // Get Physical Address  
		 $macaddr=substr($configdata,($pmac+36),17);  
		 
		 //Display Mac Address  
		 echo $macaddr; 
	}
	public function index(){
// 		print_r($this->getMacLinux());
// die;

		$template['page_title'] = "Login";
		if(isset($_POST)) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');              
			if($this->form_validation->run() == TRUE) {
				redirect(base_url().'welcome');
			}
		}
		$this->load->view('login-form');
	}
	function check_database($password) {

		$ip_Address = $this->input->ip_address();
		// $ip_Address_arr = ['192.168.1.9','192.168.1.7','192.168.1.13','122.177.66.208','103.195.201.52','103.199.224.181','122.177.71.203','223.233.64.248','122.177.73.230'];
		// if(!in_array($ip_Address,$ip_Address_arr)){
		// 	$this->form_validation->set_message('check_database', 'Invalid username or password');

		// 	return false;
		// }
		$username = $this->input->post('username');
		$result = $this->login_model->login($username, md5($password));
		if($result) {
			$user=$result->id;
			if($result->user_type == 1){
				$user="admin";
			}
			$sess_array = array();
			$sess_array = array(
								'id' => $result->id,
								'username' => $result->username,
								'user_type' => $result->user_type,
								'created_user' =>$user,
								);
			$resulttitles = $this->Settings_model->settings_viewing();
			$sessing_arrays = array(
									'title' => $resulttitles->title
								);
			$this->session->set_userdata('title', $sessing_arrays);
			$this->session->set_userdata('logged_in',$sess_array);
			$this->session->set_userdata('admin',$result->user_type);
			$this->session->set_userdata('id',$result->id);
			$this->session->set_userdata('profile_pic',$result->profile_picture);
			return TRUE;
		}
		else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
}
