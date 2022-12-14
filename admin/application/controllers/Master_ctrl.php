<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_ctrl extends CI_Controller {	
	public function __construct(){
		parent:: __construct();		
	      date_default_timezone_set("Asia/Kolkata");
		  $this->load->model('Master_model');		  
		  $this->load->library('image_lib');
		  $this->load->helper('directory');
		  if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		 }
	} 
  

		public function expert_management() 
		{
		$template['page'] = 'Master/expert_management';
		$template['page_title'] = 'Expert Management';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST)
		{
			$chat_time = '{"mon":' . json_encode($_POST['monday_chat']) . ',' . '"tue":' . json_encode($_POST['tuesday_chat']) . ',' . '"wed":' . json_encode($_POST['wednesday_chat']) . ',' . '"thu":' . json_encode($_POST['thursday_chat']) . ',' . '"fri":' . json_encode($_POST['friday_chat']) . ',' . '"sat":' . json_encode($_POST['saturday_chat']) . ',' . '"sun":' . json_encode($_POST['sunday_chat']) . '}';

			$old_img = $this->input->post('image11');
			// print_r("ff".$old_img); die;
			 if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
			 	// print_r("expression"); die;
		        $config['upload_path'] = 'uploads/expert/';
		        $config['allowed_types'] = 'gif|jpg|png|jpeg';
		        $config['max_size'] = '';
		        $config['max_width'] = '';
		        $config['max_height'] = '';
		        $config['encrypt_name'] = TRUE;
		       	$this->load->library('upload');
			    $this->upload->initialize($config);
		        $imageUpload = '';
		        if (!$this->upload->do_upload('image')) {
		        	//print_r("sssss"); die;
		          $display_image = $old_img;
		          $error = array(
		            'error' => $this->upload->display_errors()
		          );
		        }
		        else {

		        	//print_r("aaaa"); die;
		          $imageUpload = $this->upload->data();
		          $display_image = $imageUpload['file_name'];
		          
		         // unlink($old_img);
		          

		        }
		      }
		      else {
		        $display_image = $old_img;
		      }

		      $expertise = "";
			if (isset($_POST['expertise'])) {
				foreach($_POST['expertise'] as $expertise_all) {
					$expertise.= $expertise_all.",";
				}
			}



// print_r($display_image); die;
			$data_expert = array(
				
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile') ,
				'password' => $this->input->post('password'),
				'experience' => $this->input->post('experience'),
				'bio' => $this->input->post('bio'),
				'image' => $display_image,
				'expertise' => rtrim($expertise, ','),
				'online_counsult_time' => $chat_time,
				'latitude' => $this->input->post('latitude') ,
				'longitude' => $this->input->post('longitude') ,
				'location' => $this->input->post('location') ,
				
			

			);
			//print_r($data_doc);die;
			$result = $this->Master_model->update_table_data(1, 'expert_management', $data_expert);

			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Eexpert Management Contants Updated successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}

	
		}
		$template['result'] = $this->Master_model->expert_management_viewing();
		$this->load->view('template',$template);
		} 

		public function limit_member() 
		{
		$template['page'] = 'Master/limit_member';
		$template['page_title'] = 'Master Relationship';
		$id = $this->session->userdata('logged_in')['id'];
		if($_POST){
			$data = $_POST;
			unset($data['submit']); 			
			$result = $this->Master_model->update($data,'master_config_contants');
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Master Config Contants Updated successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
		}
		$template['result'] = $this->Master_model->master_config_contants_viewing();
		$this->load->view('template',$template);
		} 

		 public function view_relationship()
    {
    	$query2 = "SELECT * FROM `master_relationship` ORDER BY `name` ASC";
		$template['post'] = $this->Master_model->get_all_result($query2,'select','','');
		$template['page'] = "Master/relationship";
	  	$template['page_title'] = "Add view_relationship";
 		$this->load->view('template',$template);
    }



    public function add_relationship()
    {
    	if ($_POST) 
    	{
       	$check = $this->db->get_where("master_relationship",array("name"=>$this->input->post('name')))->result();
		if (count($check) > 0) 
		{
			$this->session->set_flashdata('message',array('message' => 'Same name name already exist','class' => 'danger'));
			redirect("Master_ctrl/view_relationship");
		}
		else
		{
			$array = array("name"=>$this->input->post("name"),
						   );
			$this->db->insert('master_relationship',$array);
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("Master_ctrl/view_relationship");
		}
			
    	}

	    $template['page'] = "Master/add_relationship";
	  	$template['page_title'] = "Add view_relationship";
 		$this->load->view('template',$template);
    }

    public function delete_relationship()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `master_relationship` WHERE `id` = '$id'";
		$r = $this->Master_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("Master_ctrl/view_relationship");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("Master_ctrl/view_relationship");
		}
	}


		 public function master_minutes()
    {
    	$query2 = "SELECT * FROM `master_time` ORDER BY `minute` ASC";
		$template['post'] = $this->Master_model->get_all_result($query2,'select','','');
		$template['page'] = "Master/master_minutes";
	  	$template['page_title'] = "Add Master Minutes";
 		$this->load->view('template',$template);
    }


     public function add_master_minutes()
    {
    	if ($_POST) 
    	{
       	$check = $this->db->get_where("master_time",array("minute"=>$this->input->post('minute')))->result();
		if (count($check) > 0) 
		{
			$this->session->set_flashdata('message',array('message' => 'Same minute already exist','class' => 'danger'));
			redirect("Master_ctrl/master_minutes");
		}
		else
		{
			$array = array("minute"=>$this->input->post("minute"),
						   );
			$this->db->insert('master_time',$array);
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("Master_ctrl/master_minutes");
		}
			
    	}

	    $template['page'] = "Master/add_master_minutes";
	  	$template['page_title'] = "Add master_minutes";
 		$this->load->view('template',$template);
    }


    public function delete_master_minutes()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `master_time` WHERE `id` = '$id'";
		$r = $this->Master_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Delete Successfully','class' => 'success'));
			redirect("Master_ctrl/master_minutes");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("Master_ctrl/master_minutes");
		}
	}



		 public function master_price_management()
    {
    	$query2 = "SELECT * FROM `master_price_management` ORDER BY `for_` ASC";
		$template['post'] = $this->Master_model->get_all_result($query2,'select','','');
		$template['page'] = "Master/master_price_management";
	  	$template['page_title'] = "Add master_price_management";
 		$this->load->view('template',$template);
    }

     public function edit_master_time()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		if ($_POST) {
			$array = array(
				"price"=>$this->input->post("price"),
				"status"=>$this->input->post("status"),
			);
			$create = $this->Master_model->get_all_result($array,'update','master_price_management',array('id'=>$id));
			if ($create) {
				$this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
		    	redirect("Master_ctrl/edit_master_time/".$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("Master_ctrl/edit_master_time/".$id);	
		    }
		}
		else
		{
		  $query = "SELECT * FROM `master_price_management` WHERE `id` = '$id'";
		  $template['list'] = $this->Master_model->get_all_result($query,'single_row','','');
		  $template['page'] = "Master/edit_master_time";
		  $template['page_title'] = "Edit master_price_list";
	 	  $this->load->view('template',$template);
		}
	}



  //    public function add_master_price_management()
  //   {
  //   	if ($_POST) 
  //   	{
  //      	$check = $this->db->get_where("master_time",array("minute"=>$this->input->post('minute')))->result();
		// if (count($check) > 0) 
		// {
		// 	$this->session->set_flashdata('message',array('message' => 'Same minute already exist','class' => 'danger'));
		// 	redirect("Master_ctrl/add_master_price_management");
		// }
		// else
		// {
		// 	$array = array("minute"=>$this->input->post("minute"),
		// 				   );
		// 	$this->db->insert('master_time',$array);
		// 	$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
		// 	redirect("Master_ctrl/master_price_management");
		// }
			
  //   	}

	 //    $template['page'] = "Master/add_master_price_management";
	 //  	$template['page_title'] = "Add master_price_management";
 	// 	$this->load->view('template',$template);
  //   }


    public function delete_master_price_management()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `master_time` WHERE `id` = '$id'";
		$r = $this->Master_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Delete Successfully','class' => 'success'));
			redirect("Master_ctrl/master_price_management");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("Master_ctrl/master_price_management");
		}
	}



	 public function master_price_list()
    {
    	$query2 = "SELECT * FROM `master_price_list` ORDER BY `id` ASC";
		$template['post'] = $this->Master_model->get_all_result($query2,'select','','');
		$template['page'] = "Master/master_price_list";
	  	$template['page_title'] = "Add master_price_list";
 		$this->load->view('template',$template);
    }


     public function add_master_price_list()
    {
    	if ($_POST) 
    	{
       	$check = $this->db->get_where("master_price_list",array("match_making_price"=>$this->input->post('match_making_price'),"life_prediction_price"=>$this->input->post('life_prediction_price')))->result();
       //	echo $this->db->last_query(); die;
		if (count($check) > 0) 
		{
			$this->session->set_flashdata('message',array('message' => 'Same master price already exist','class' => 'danger'));
			redirect("Master_ctrl/add_master_price_list");
		}
		else
		{
			$array = array(
				"match_making_price"=>$this->input->post("match_making_price"),
				"life_prediction_price"=>$this->input->post("life_prediction_price"),
						   );
			$this->db->insert('master_price_list',$array);
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("Master_ctrl/master_price_list");
		}
			
    	}

	    $template['page'] = "Master/add_master_price_list";
	  	$template['page_title'] = "Add master_price_list";
 		$this->load->view('template',$template);
    }

    public function edit_master_price_list()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		if ($_POST) {
			$array = array(
				"match_making_price"=>$this->input->post("match_making_price"),
				"life_prediction_price"=>$this->input->post("life_prediction_price"),
				"varshphal_pdf"=>$this->input->post("varshphal_pdf"),
				"medical_price"=>$this->input->post("medical_price"),
				"financial_price"=>$this->input->post("financial_price"),
			);
			$create = $this->Master_model->get_all_result($array,'update','master_price_list',array('id'=>$id));
			if ($create) {
				$this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
		    	redirect("Master_ctrl/edit_master_price_list/".$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("Master_ctrl/edit_master_price_list/".$id);	
		    }
		}
		else
		{
		  $query = "SELECT * FROM `master_price_list` WHERE `id` = '$id'";
		  $template['list'] = $this->Master_model->get_all_result($query,'single_row','','');
		  $template['page'] = "Master/edit_master_price_list";
		  $template['page_title'] = "Edit master_price_list";
	 	  $this->load->view('template',$template);
		}
	}


    public function delete_master_price_list()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `master_price_list` WHERE `id` = '$id'";
		$r = $this->Master_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Delete Successfully','class' => 'success'));
			redirect("Master_ctrl/master_price_list");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("Master_ctrl/master_price_list");
		}
	}






}