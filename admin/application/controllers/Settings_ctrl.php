<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings_ctrl extends CI_Controller {	
	public function __construct(){
		parent:: __construct();		
	      date_default_timezone_set("Asia/Kolkata");
		  $this->load->model('Settings_model');		  
		  $this->load->library('image_lib');
		  if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		 }
	} 

	public function report_upload() 
	{
		//print_r($_FILES);
		// print_r($_POST);
		// print_r($_GET);
		//die;
			$funcNum = $this->input->get('CKEditorFuncNum');
		  $target_path = "uploads/common/"; 
        $target_dir = "uploads/common/";
        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $imagename = basename($_FILES["upload"]["name"]);
        $extension = substr(strrchr($_FILES['upload']['name'], '.'), 1);
        $actual_image_name = time().".".$extension;
        move_uploaded_file($_FILES["upload"]["tmp_name"],$target_path.$actual_image_name);
        if(!empty($actual_image_name) && !empty($extension))
        {
        			
           $url = base_url('uploads/common/')."/".$actual_image_name;
           	 $message = 'Upload success!';
               echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";

        }
       
	}

	public function report() {
	    $uri = htmlentities(trim($this->uri->segment(3)));
		// print_r( $id); die;

		$template['page'] = 'Settings/report';



		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 
			



			 if (!empty($_FILES['image'])) 
                {
                    $target_path = "uploads/common/"; 
                    $target_dir = "uploads/common/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                    if(!empty($actual_image_name) && !empty($extension))
                    {
                        $data['image'] = $actual_image_name;
                    }
                   
                }
                
                
			


			// print_r($_FILES['image']); die;

			 $this->db->where('type', $uri);
            $result = $this->db->update('website_services', $data);


			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Report Details Updated successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
		if ( $uri == 1) 
		{
		$template['page_title'] = 'Career Report';
		$template['type'] = 1;
		}
		elseif ( $uri == 2) 
		{
		$template['page_title'] = 'Education Report';
		$template['type'] = 2;
		}
		elseif ( $uri == 3) 
		{
		$template['page_title'] = 'Marriage Report';
		$template['type'] = 3;
		}

		elseif ( $uri == 4) 
		{
		$template['page_title'] = 'Love Report';
		$template['type'] = 4;
		}

		elseif ( $uri == 5) 
		{
		$template['page_title'] = 'Child Report';
		$template['type'] = 5;
		}

		elseif ( $uri == 6) 
		{
		$template['page_title'] = 'Business Report';
		$template['type'] = 6;
		}

		elseif ( $uri == 7) 
		{
		$template['page_title'] = 'Foreign Report';
		$template['type'] = 7;
		}

		elseif ( $uri == 8) 
		{
		$template['page_title'] = 'Property Report';
		$template['type'] = 8;
		}

		elseif ( $uri == 9) 
		{
		$template['page_title'] = 'Astrology Course';
		$template['type'] = 9;
		}

		elseif ( $uri == 10) 
		{
		$template['page_title'] = 'Tarot Course';
		$template['type'] = 10;
		}

		elseif ( $uri == 11) 
		{
		$template['page_title'] = 'Vastu Course';
		$template['type'] = 11;
		}

		elseif ( $uri == 12) 
		{
		$template['page_title'] = 'Palmistry Course';
		$template['type'] = 12;
		}

		elseif ( $uri == 13) 
		{
		$template['page_title'] = 'Office Vastu';
		$template['type'] = 13;
		}

		elseif ( $uri == 14) 
		{
		$template['page_title'] = 'Industrial Vastu';
		$template['type'] = 14;
		}




		$template['result'] = $this->db->query("select * from website_services where type = $uri")->row();

		$this->load->view('template',$template);
		} 



    public function view_settings() {
		$template['currencies']=$this->Settings_model->get_currencies();
		$template['page'] = 'Settings/add-settings';
		$template['page_title'] = 'Add Settings';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 


			if(isset($_FILES['logo'])) {  
				$config = set_upload_logo('uploads/common');
				$this->load->library('upload');
				$new_name = time()."_".$_FILES["logo"]['name'];
				$config['file_name'] = $new_name;
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('logo')) {
					unset($data['logo']);
				}
				else {
					$upload_data = $this->upload->data();
					$data['logo'] = $config['upload_path']."/".$upload_data['file_name'];
				}
			}





			if(isset($_FILES['website_banner'])) {  
				$config = set_upload_logo('uploads/common');
				$this->load->library('upload');
				$new_name = time()."_".$_FILES["website_banner"]['name'];
				$config['file_name'] = $new_name;
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('website_banner')) {
					unset($data['website_banner']);
				}
				else {
					$upload_data = $this->upload->data();
					$data['website_banner'] = $upload_data['file_name'];
				}
			}

			

			if(isset($_FILES['favicon'])) {  
				$config = set_upload_logo('uploads/common');
				$this->load->library('upload');
				$new_name = time()."_".$_FILES["favicon"]['name'];
				$config['file_name'] = $new_name;
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('favicon')) {
					unset($data['favicon']);
				}
				else {
					$upload_data = $this->upload->data();
					$data['favicon'] = $config['upload_path']."/".$upload_data['file_name'];
				}
			}
			$result = $this->Settings_model->update_settings($data);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Settings Details Updated successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
		$resulttitles = $this->Settings_model->settings_viewing();
		$sessing_arrays = array(
								'title' => $resulttitles->title
							);
		$this->session->set_userdata('title', $sessing_arrays);
		$template['result'] = $this->Settings_model->settings_viewing();
		// $template['language'] = $this->Settings_model->get_languages(); 
		$this->load->view('template',$template);
		} 

    public function view_policy() {
		$template['currencies']=$this->Settings_model->get_currencies();
		$template['page'] = 'Settings/add-policy';
		$template['page_title'] = 'Add policy';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 
		// print_r($data); die;
			$result = $this->Settings_model->update_settings($data);

			// echo $this->db->last_query(); die;
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Policy Details Updated successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
		$resulttitles = $this->Settings_model->settings_viewing();
		$sessing_arrays = array(
								'title' => $resulttitles->title
							);
		$this->session->set_userdata('title', $sessing_arrays);
		$template['result'] = $this->Settings_model->settings_viewing();
		// $template['language'] = $this->Settings_model->get_languages(); 
		$this->load->view('template',$template);
		} 

		public function price() {
			// print_r("shubham");die;
		$template['currencies']=$this->Settings_model->get_currencies();
		$template['page'] = 'Settings/price';
		$template['page_title'] = 'price';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 
			
			
			$result = $this->Settings_model->update_price($data);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Peice Details Updated successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
		$resulttitles = $this->Settings_model->price_viewing();
	
		$template['result'] = $this->Settings_model->price_viewing();
		$template['language'] = $this->Settings_model->get_languages(); 
		$this->load->view('template',$template);
		} 


		public function common_pdf() {
			// print_r("shubham");die;
		$template['page'] = 'Settings/common_pdf';
		$template['page_title'] = 'price';
		$id = $this->session->userdata('logged_in')['id'];
		
	
		$template['result'] = $this->Settings_model->settings_viewing();

		$this->load->view('template',$template);
		} 


		public function edit_common_pdf() {
			// print_r("shubham");die;
		$template['page'] = 'Settings/edit_common_pdf';
		$template['page_title'] = 'price';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 


			if(!empty($_FILES['userfile'])){
					 	$config['upload_path']          = 'uploads/common_pdf/';
		                $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
		                $config['max_size']             = '';
		                $config['max_width']            = '';
		                $config['max_height']           = '';
		                $config['encrypt_name'] 		= TRUE;
		                 $this->load->library('upload');
         				 $this->upload->initialize($config);
		                // $this->load->library('upload', $config);
		                $imageUpload = '';

		                if ( ! $this->upload->do_upload('userfile'))
		                {
	                        $error = array('error' => $this->upload->display_errors());
		                }
		                else
		                {
	                        $imageUpload =  $this->upload->data();
	                        
                            
		                }
		               
							$guide = $imageUpload['file_name'];
					}else{
						$guide= '';
					}

					
			// if (!empty($_FILES['userfile']) && !empty(trim($_FILES['userfile']['name']))) {
			// 	$target_path = "uploads/common_pdf/";
	  //           $target_dir = "uploads/common_pdf/";
	  //           $target_file_logo = $target_dir . basename($_FILES["userfile"]["name"]);

	  //           if(is_array($_FILES['userfile'])) 
	  //           {
	  //              foreach($_FILES as $fileKey => $fileVal)
	  //             {
	  //                    $flag_image = basename($_FILES["userfile"]["name"]);
	  //                    $title_extension = substr(strrchr($_FILES['userfile']['name'], '.'), 1);
	  //                            $flag_image_name = time().".".$title_extension;
	  //                    move_uploaded_file($_FILES["userfile"]["tmp_name"],$target_path.$flag_image_name);
	                                    
	  //                if(!empty($title_extension))
	  //                {
	  //                    $guide = $flag_image_name;
	  //                     // unlink('./uploads/flag_image'.'/'.$img);
	  //                }
	  //                }
	  //            }
	  //            else{
	  //            	 $guide = '';
	  //            } 
			// }
			// else
			// {
			// 	$guide  = $this->input->post('pdf');
			// }

			$data_pdf = array(
				'common_pdf' => $guide,
				
			);
			
			
		$result = $this->Settings_model->update_table_data(1, 'settings', $data_pdf);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Peice Details Updated successfully','class' => 'success'));
				redirect(base_url('Settings_ctrl/common_pdf/'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
	
		$template['result'] = $this->Settings_model->settings_viewing();

		$this->load->view('template',$template);
		} 


		public function magzine() {
			// print_r("shubham");die;
		$template['page'] = 'Settings/magzine';
		$template['page_title'] = 'magzine';
		$id = $this->session->userdata('logged_in')['id'];
		
	
		$template['result'] = $this->Settings_model->settings_viewing();

		$this->load->view('template',$template);
		} 


		public function edit_magzine() 
		{
		$template['page'] = 'Settings/edit_magzine';
		$template['page_title'] = 'magzine';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 

			if(!empty($_FILES['userfile'])){
					 	$config['upload_path']          = 'uploads/magzine/';
		                $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
		                $config['max_size']             = '';
		                $config['max_width']            = '';
		                $config['max_height']           = '';
		                $config['encrypt_name'] 		= TRUE;
		                 $this->load->library('upload');
         				 $this->upload->initialize($config);
		                // $this->load->library('upload', $config);
		                $imageUpload = '';

		                if ( ! $this->upload->do_upload('userfile'))
		                {
	                        $error = array('error' => $this->upload->display_errors());
		                }
		                else
		                {
	                        $imageUpload =  $this->upload->data();
	                        
                            
		                }
		               
							$guide = $imageUpload['file_name'];
					}else{
						$guide= '';
					}


			$data_pdf = array(
				'magzine' => $guide,
				
			);
			
			
		$result = $this->Settings_model->update_table_data(1, 'settings', $data_pdf);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Magzine Details Updated successfully','class' => 'success'));
				redirect(base_url('Settings_ctrl/magzine/'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
	
		$template['result'] = $this->Settings_model->settings_viewing();

		$this->load->view('template',$template);
		} 



		public function sample_pdfs() {
			// print_r("shubham");die;
		$template['page'] = 'Settings/sample_pdfs';
		$template['page_title'] = 'sample_pdfs';
		$id = $this->session->userdata('logged_in')['id'];
		
	
		$template['result'] = $this->Settings_model->settings_viewing();

		$this->load->view('template',$template);
		} 


		public function edit_sample_pdfs() {
			// print_r("shubham");die;
		$template['page'] = 'Settings/edit_sample_pdfs';
		$template['page_title'] = 'sample_pdfs';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 

				if(!empty($_FILES['userfile'])){
					 	$config['upload_path']          = 'uploads/pdffree/';
		                $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
		                $config['max_size']             = '';
		                $config['max_width']            = '';
		                $config['max_height']           = '';
		                $config['encrypt_name'] 		= TRUE;
		                 $this->load->library('upload');
         				 $this->upload->initialize($config);
		                // $this->load->library('upload', $config);
		                $imageUpload = '';

		                if ( ! $this->upload->do_upload('userfile'))
		                {
	                        $error = array('error' => $this->upload->display_errors());
		                }
		                else
		                {
	                        $imageUpload =  $this->upload->data();
	                        
                            
		                }
		               
							$guide = $imageUpload['file_name'];
					}else{
						$guide= '';
					}




			// if (!empty($_FILES['userfile']) && !empty(trim($_FILES['userfile']['name']))) {
			// 	$target_path = "uploads/pdffree/";
	  //           $target_dir = "uploads/pdffree/";
	  //           $target_file_logo = $target_dir . basename($_FILES["userfile"]["name"]);

	  //           if(is_array($_FILES['userfile'])) 
	  //           {
	  //              foreach($_FILES as $fileKey => $fileVal)
	  //             {
	  //                    $flag_image = basename($_FILES["userfile"]["name"]);
	  //                    $title_extension = substr(strrchr($_FILES['userfile']['name'], '.'), 1);
	  //                            $flag_image_name = time().".".$title_extension;
	  //                    move_uploaded_file($_FILES["userfile"]["tmp_name"],$target_path.$flag_image_name);
	                                    
	  //                if(!empty($title_extension))
	  //                {
	  //                    $guide = $flag_image_name;
	  //                     // unlink('./uploads/flag_image'.'/'.$img);
	  //                }
	  //                }
	  //            }
	  //            else{
	  //            	 $guide = '';
	  //            } 
			// }
			// else
			// {
			// 	$guide  = $this->input->post('pdf');
			// }

			$data_pdf = array(
				'sample_pdfs' => $guide,
				
			);
			
			
		$result = $this->Settings_model->update_table_data(1, 'settings', $data_pdf);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Sample Pdf Updated successfully','class' => 'success'));
				redirect(base_url('Settings_ctrl/sample_pdfs/'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
	
		$template['result'] = $this->Settings_model->settings_viewing();

		$this->load->view('template',$template);
		} 

		public function gandmool() {
			// print_r("shubham");die;
		$template['page'] = 'Settings/gandmool';
		$template['page_title'] = 'gandmool';
		$id = $this->session->userdata('logged_in')['id'];
			if($_POST){
			$data = $_POST;
			unset($data['submit']); 
			

			$data_pdf = array(
				'gandmool' => $this->input->post('gandmool'),
				
			);
			
			
		$result = $this->Settings_model->update_table_data(1, 'settings', $data_pdf);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Dandmool Updated successfully','class' => 'success'));
				redirect(base_url('Settings_ctrl/gandmool/'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
	
		$template['result'] = $this->Settings_model->settings_viewing();

		$this->load->view('template',$template);
		} 


		public function tax_management() {
			// print_r("shubham");die;
		$template['page'] = 'Settings/tax_management';
		$template['page_title'] = 'tax_management';
		$id = $this->session->userdata('logged_in')['id'];
			if($_POST){
			$data = $_POST;
			unset($data['submit']); 
			

			$data_pdf = array(
				'online_consultation' => $this->input->post('online_consultation'),
				'in_person' => $this->input->post('in_person'),
				'match_making' => $this->input->post('match_making'),
				'life_prediction' => $this->input->post('life_prediction'),
				'class_package' => $this->input->post('class_package'),
				'gems_booking' => $this->input->post('gems_booking'),
				'pdf_booking' => $this->input->post('pdf_booking'),
				'medical_booking' => $this->input->post('medical_booking'),
				'financial_booking' => $this->input->post('financial_booking'),
			);
			
			
		$result = $this->Settings_model->update_table_data(1, 'master_tax', $data_pdf);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Tax Management Updated successfully','class' => 'success'));
				redirect(base_url('Settings_ctrl/tax_management/'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
	
		$template['list'] = $this->Settings_model->master_tax_viewing();
// print_r($template['result']); die;
		$this->load->view('template',$template);
		}


		


}