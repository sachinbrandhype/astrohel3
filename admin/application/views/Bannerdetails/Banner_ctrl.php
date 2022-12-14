<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner_ctrl extends CI_Controller {
	public function __construct() {
	parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Banner_model');
		$this->load->helper('directory');
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }
	public function view_patientbanner(){  
		  $template['page'] = "Bannerdetails/view-patientbanner";
		  $template['page_title'] = "View banner";
		  $template['data'] = $this->Banner_model->get_banner('banner');
		  $this->load->view('template',$template);
	  }

	  public function add_patientbanner()
	  {
	  	  $template['page'] = "Bannerdetails/add_patientbanner";
		  $template['page_title'] = "Add Patient banner";
		  $this->load->view('template',$template);
	  }
	  public function insert_patientbanner()
	{
		//print_r($_FILES);
		if($_POST){		  
				  	$data = $_POST;
				  	if(!empty($_FILES['image'])){
					 	$config['upload_path']          = 'uploads/banner/patient_banner';
		                $config['allowed_types']        = 'gif|jpg|png';
		                $config['max_size']             = '';
		                $config['max_width']            = '';
		                $config['max_height']           = '';
		                $config['encrypt_name'] 		= TRUE;
		                $this->load->library('upload', $config);
		                $imageUpload = '';

		                if ( ! $this->upload->do_upload('image'))
		                {
	                        $error = array('error' => $this->upload->display_errors());
		                }
		                else
		                {
	                        $imageUpload =  $this->upload->data();
	                        
                            
		                }
		               
							$data['image'] = $imageUpload['file_name'];
					}else{
						$data['image']= '';
					}

				  $result = $this->Banner_model->add_bannerdetails('banner',$data);
				  //echo $this->db->last_query();die;
				  if($result) {
					 $this->session->set_flashdata('message',array('message' => 'Add banner Details successfully','class' => 'success'));
				  }
			  }

			  $template['data'] = $this->Banner_model->get_bannerdetails('banner');
			  $template['page'] = "Bannerdetails/view-patientbanner";
		  	  $template['page_title'] = "View Patient Banner";
			  $this->load->view('template',$template);
		
	}
	  public function delete_patientbanner() {
	  	
		 $id = $this->uri->segment(3);
		 $image_url= $this->Banner_model->get_row('banner', array('id'=>$id));

         if($image_url){
               $img = $image_url->image;
           }
                         
		$result= $this->Banner_model->patientbanner_delete($id,$img);
		
		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
	    redirect(base_url().'banner_ctrl/view_patientbanner');
	 }

	 public function patient_status(){
    	
		$data1 = array(
						"status" => '0'
		);
		$id = $this->uri->segment(3);		   
		$s=$this->Banner_model->update_patient_status('banner',$id, $data1);
		
		$this->session->set_flashdata('message', array('message' => 'Doctor Successfully Disabled','class' => 'warning'));
	    redirect(base_url().'banner_ctrl/view_patientbanner');
	 }
	 public function patient_active(){
	 	
		  $data1 = array(
		  "status" => '1'
					 );
		  $id = $this->uri->segment(3);	   
		  $s=$this->Banner_model->update_patient_status('banner',$id, $data1);

		  $this->session->set_flashdata('message', array('message' => 'patient Successfully Enabled','class' => 'success'));
	    redirect(base_url().'banner_ctrl/view_patientbanner');
	    }

	    public function view_doctorbanner(){  
		  $template['page'] = "Bannerdetails/view-doctorbanner";
		  $template['page_title'] = "View banner";
		  $template['data'] = $this->Banner_model->get_banner('doctor_banner');
		  $this->load->view('template',$template);
	  }

	  public function add_doctorbanner()
	  {
	  	  $template['page'] = "Bannerdetails/add_doctorbanner";
		  $template['page_title'] = "Add doctor banner";
		  $this->load->view('template',$template);
	  }
	  public function insert_doctorbanner()
	{
		//print_r($_FILES);
		if($_POST){		  
				  	$data = $_POST;
				  	if(!empty($_FILES['image'])){
					 	$config['upload_path']          = 'uploads/banner/doctor_banner';
		                $config['allowed_types']        = 'gif|jpg|png';
		                $config['max_size']             = '';
		                $config['max_width']            = '';
		                $config['max_height']           = '';
		                $config['encrypt_name'] 		= TRUE;
		                $this->load->library('upload', $config);
		                $imageUpload = '';

		                if ( ! $this->upload->do_upload('image'))
		                {
	                        $error = array('error' => $this->upload->display_errors());
		                }
		                else
		                {
	                        $imageUpload =  $this->upload->data();
	                        
                            
		                }
		               
							$data['image'] = $imageUpload['file_name'];
					}else{
						$data['image']= '';
					}

				  $result = $this->Banner_model->add_bannerdetails('doctor_banner',$data);
				  //echo $this->db->last_query();die;
				  if($result) {
					 $this->session->set_flashdata('message',array('message' => 'Add banner Details successfully','class' => 'success'));
				  }
			  }
 redirect(base_url().'banner_ctrl/view_doctorbanner');
		
	}
	  public function delete_doctorbanner() {
	  	
		 $id = $this->uri->segment(3);
		 $image_url= $this->Banner_model->get_row('doctor_banner', array('id'=>$id));

         if($image_url){
               $img = $image_url->image;
           }
                         
		$result= $this->Banner_model->doctorbanner_delete($id,$img);
		
		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
	    redirect(base_url().'banner_ctrl/view_doctorbanner');
	 }

	 public function doctor_status(){
    	
		$data1 = array(
						"status" => '0'
		);
		$id = $this->uri->segment(3);		   
		$s=$this->Banner_model->update_patient_status('doctor_banner',$id, $data1);
		
		$this->session->set_flashdata('message', array('message' => 'Doctor Successfully Disabled','class' => 'warning'));
	    redirect(base_url().'banner_ctrl/view_doctorbanner');
	 }
	 public function doctor_active(){
	 	
		  $data1 = array(
		  "status" => '1'
					 );
		  $id = $this->uri->segment(3);	   
		  $s=$this->Banner_model->update_patient_status('doctor_banner',$id, $data1);

		  $this->session->set_flashdata('message', array('message' => 'doctor Successfully Enabled','class' => 'success'));
	    redirect(base_url().'banner_ctrl/view_doctorbanner');
	    }
} 
?>