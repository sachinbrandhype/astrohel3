<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Services extends CI_Controller {
	public function __construct() {
	parent::__construct();	
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Services_model');
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }
	 public function add_services(){
		$template['page'] = "Services/add-services";
		$template['page_title'] = "Add Services";	  
		if($_POST){		  
			$data = $_POST;
			$result = $this->Services_model->add_services($data);
			if($result) {
				$this->session->set_flashdata('message',array('message' => ' Services Added  successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
		$template['data'] = $this->Services_model->get_services();
		$this->load->view('template',$template);
	}
	 public function delete_services() {
		  $id = $this->uri->segment(3);
		  $result= $this->Services_model->services_delete($id);
		  $this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
		  redirect(base_url().'Services/add_services');
	 } 
	 public function edit_services(){
		$template['page'] = "Services/edit-services";
		$template['page_title'] = "Edit Services";
		$id = $this->uri->segment(3); 
		$template['data'] = $this->Services_model->get_single_services($id);		
		//print_r($_POST);die; 
		if($_POST){
			$data = $_POST;
			$result = $this->Services_model->services_edit($data, $id);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Requested Service Updated successfully','class' => 'success'));
				redirect(base_url().'Services/add_services');
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error')); 
				redirect(base_url().'Services/add_services');
			}
		}	
		$this->load->view('template',$template); 	
	 }
}