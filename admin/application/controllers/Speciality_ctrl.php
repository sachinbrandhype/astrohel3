<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Speciality_ctrl extends CI_Controller {
	public function __construct() {
	parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Speciality_model');
		$this->load->model('Affiliated_model','h');
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }
	 public function add_speciality(){
	 	// print_r($_FILES);
			  $template['page'] = "Specialitydetails/add-speciality";
			  $template['page_title'] = "Add Speciality";
			  $query = "SELECT * FROM `departments`";
		  	  $template['department'] = $this->h->get_all_result($query,'select','','');

		  	  $query1 = "SELECT * FROM `hospital`";
		  	  $template['hospital'] = $this->h->get_all_result($query1,'select','','');
		      	  
		      if($_POST){
				  	$check = $this->db->get_where("specialty_categories",array("specialty_name"=>$this->input->post('name'),"hospital_id"=>$this->input->post('hospital_id')))->result();
					if (count($check) > 0) 
					{
						$this->session->set_flashdata('message',array('message' => 'Already have this Speciality!','class' => 'danger'));
						redirect("Speciality_ctrl/add_speciality");
					}
					else
					{
					$type ="Image";
                    $config['upload_path']          = 'uploads/speciality/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = '';
                    $config['max_width']            = '';
                    $config['max_height']           = '';
                    $upload_dir                     = 'uploads/speciality/';
                    $upload_dir_thumbs              = 'uploads/speciality/thumbnail';    
                    $this->load->library('upload', $config);
                    $imageUpload = [];
                    $number_of_files = count($_FILES['file']['name']);
                    if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
                       
                            $_FILES['file']['name']     = $_FILES['file']['name'];
                            $_FILES['file']['type']     = $_FILES['file']['type'];
                            $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'];
                            $_FILES['file']['error']     = $_FILES['file']['error'];
                            $_FILES['file']['size']     = $_FILES['file']['size'];
                        if (!$this->upload->do_upload('file'))
                        {
                            $error = array('error' => $this->upload->display_errors());
                            // print_r($error);die;
                            $this->session->set_flashdata('delete', 'Image does not upload');
                        }
                        else {
 						$fileName = base_url('uploads/speciality').'/'.$this->upload->data('file_name');
                            $sourceProperties = getimagesize($fileName);
                            $resizeFileName = $this->upload->data('file_name');
                            $uploadPath = "uploads/speciality/";
                            $fileExt = pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION);
                            $uploadImageType = $sourceProperties[2];
                            $sourceImageWidth = $sourceProperties[0];
                            $sourceImageHeight = $sourceProperties[1];
                            switch ($uploadImageType) {
                            case IMAGETYPE_JPEG:
                                $resourceType = imagecreatefromjpeg($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagejpeg($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_GIF:
                                $resourceType = imagecreatefromgif($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagegif($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_PNG:
                                $resourceType = imagecreatefrompng($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagepng($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            default:

                                $imageProcess = 0;
                                break;
                            }

                            $fileName1 = $this->upload->data('file_name');
					  }
					}

					$specialty_name = $this->input->post('name');

					$check = $this->db->get_where('specialty_categories', array('specialty_name' => $specialty_name), 1);

		  	        if ($check->num_rows() > 0) {
		  	         $this->session->set_flashdata('message',array('message' => 'This Specialty name already exists in our database','class' => 'danger'));
						redirect('Speciality_ctrl/add_speciality/');  
			            //$this->set_message('unique_user_name', 'This name already exists in our database');

			            return FALSE;
			        }
			        else {


			            $arraydata = array(
			             'description'      =>  $this->input->post('description'),
		                'specialty_name'      =>  $this->input->post('name'),
		                'department'           =>  $this->input->post('department'),
		                'is_top'      			=>  $this->input->post('is_top'),
		                'status'      			=>  $this->input->post('status'),
		                'position'        		=>  $this->input->post('position'),
		                'image'        		  	=>  $fileName1,
			            );

		            	$total_ins = $this->db->insert('specialty_categories',$arraydata);
			            $this->session->set_flashdata('message',array('message' => 'Add Specialty Details successfully','class' => 'success'));
			            redirect('Speciality_ctrl/add_speciality/');   
					}

			        }
			  }
			  $template['data'] = $this->Speciality_model->get_specialitydetails();
			  $this->load->view('template',$template);
	 }
	 public function delete_speciality() {
		 $id = $this->uri->segment(3);
		 $result= $this->Speciality_model->speciality_delete($id);
		 $this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
	     redirect(base_url().'Speciality_ctrl/add_speciality');
	 }
	 public function edit_speciality(){
		$template['page'] = "Specialitydetails/edit-speciality";
	    $template['page_title'] = "Edit Speciality";
		$id = $this->uri->segment(3); 
		$template['data'] = $this->Speciality_model->get_single_speciality($id);
		$query = "SELECT * FROM `departments`";
	  	$template['department'] = $this->h->get_all_result($query,'select','','');
	  	$query1 = "SELECT * FROM `hospital`";
		$template['hospital'] = $this->h->get_all_result($query1,'select','','');
	    if($_POST){
			$id = $this->input->post("id");
			
			// $target_path = "uploads/specialty/";
			// $target_dir = "uploads/specialty/";
			//$target_file_logo = $target_dir . basename($_FILES["author"]["name"]);
			if (!empty($_FILES["file"]["name"])) 
			{
				if(is_array($_FILES)) 
				{
					$type ="Image";
                    $config['upload_path']          = 'uploads/speciality/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = '';
                    $config['max_width']            = '';
                    $config['max_height']           = '';
                    $upload_dir                     = 'uploads/speciality/';
                    $upload_dir_thumbs              = 'uploads/speciality/thumbnail';    
                    $this->load->library('upload', $config);
                    $imageUpload = [];
                    $number_of_files = count($_FILES['file']['name']);
                    if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
                       
                            $_FILES['file']['name']     = $_FILES['file']['name'];
                            $_FILES['file']['type']     = $_FILES['file']['type'];
                            $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'];
                            $_FILES['file']['error']     = $_FILES['file']['error'];
                            $_FILES['file']['size']     = $_FILES['file']['size'];
                        if ( ! $this->upload->do_upload('file'))
                        {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('delete', 'Image does not upload');
                        }
                        else {
 				$fileName = base_url('uploads/speciality').'/'.$this->upload->data('file_name');
                            $sourceProperties = getimagesize($fileName);
                            $resizeFileName = $this->upload->data('file_name');
                            $uploadPath = "uploads/speciality/";
                            $fileExt = pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION);
                            $uploadImageType = $sourceProperties[2];
                            $sourceImageWidth = $sourceProperties[0];
                            $sourceImageHeight = $sourceProperties[1];
                            switch ($uploadImageType) {
                            case IMAGETYPE_JPEG:
                                $resourceType = imagecreatefromjpeg($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagejpeg($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_GIF:
                                $resourceType = imagecreatefromgif($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagegif($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_PNG:
                                $resourceType = imagecreatefrompng($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagepng($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            default:

                                $imageProcess = 0;
                                break;
                            }

                            $icon = $this->upload->data('file_name');
					  }
					}
			    }	
			}
			else
			{
				$icon =  $template['data']->image;
			}
			
			$array = array( 
			                'description'      =>  $this->input->post('description'),
							'specialty_name'      =>  $this->input->post('specialty_name'),
			                'department'           =>  $this->input->post('department'),
			                'is_top'      =>  $this->input->post('is_top'),
			                 'status'      =>  $this->input->post('status'),
							'position'        		=>  $this->input->post('position'),

			                'image'        		  =>  $icon,
			            );
			$create = $this->h->get_all_result($array,'update','specialty_categories',array('id'=>$id));
			if ($create) {
		    	$this->session->set_flashdata('message',array('message' => 'Update Successfully','class' => 'success'));
		    	redirect("Speciality_ctrl/edit_speciality".'/'.$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("Speciality_ctrl/edit_speciality".'/'.$id);	
		    }
			
		}	
		 $this->load->view('template',$template); 	
	 }


	  public function resizeImage($resourceType,$image_width,$image_height) {
        $resizeWidth = 200;
        $resizeHeight = 200;
        $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
        $white = imagecolorallocatealpha($imageLayer, 255, 255, 255, 120);
        imagefill($imageLayer, 0, 0, $white);
        imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
        return $imageLayer;
    }


}