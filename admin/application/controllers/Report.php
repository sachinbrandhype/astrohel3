<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller {
	public function __construct() {
	parent::__construct();	
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('report_model');
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }
	 public function index(){
		$template['page'] = "report/audit_trail";
		$template['page_title'] = "Audit Trail Report";	  
		if($_POST){		  
			
		}
		//$template['data'] = $this->report_model->get_audit_trail_report();
		$this->load->view('template',$template);
	}
	 
	 
}