<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Affiliate_ctrl extends CI_Controller {
	public function __construct() {
	parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model("Speedhuntson_m","c_m");
		$this->load->library('pagination');
          $this->load->library('upload');
        $this->load->library('csvimport');
		$this->load->model('Affiliated_model');
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }
	 public function add_affiliatedetails(){	
		if($_POST){		  
			$data = $_POST; 
			$result = $this->Affiliated_model->add_affiliatedetails($data);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Add Affiliated Details successfully','class' => 'success'));
			}
			else {
				$this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
			}
	  }
	  $template['page'] = "Affiliateddetails/add-affiliate";
	  $template['page_title'] = "Add affiliate";
	  $template['data'] = $this->Affiliated_model->get_affiliatedetails();
	  $this->load->view('template',$template);
	 }
	 public function delete_affiliation() {
		  $id = $this->uri->segment(3);
		  $result= $this->Affiliated_model->affliated_delete($id);
		  $this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
		  redirect(base_url().'Affiliate_ctrl/add_affiliatedetails');
	 }
	 public function edit_affiliatedval(){
		  $template['page'] = "Affiliateddetails/edit-affiliate";
		  $template['page_title'] = "Edit affiliate";
		  $id = $this->uri->segment(3); 
		  $template['data'] = $this->Affiliated_model->get_single_affiliate($id);
		  if($_POST){
			$data = $_POST;
			$result = $this->Affiliated_model->affiliatedetails_edit($data, $id);
			if($result) {
				$this->session->set_flashdata('message',array('message' => 'Edit Affiliated Details Updated successfully','class' => 'success'));
				redirect(base_url().'Affiliate_ctrl/add_affiliatedetails');
			}
			else {
				 $this->session->set_flashdata('message', array('message' => 'Error','class' => 'error')); 
				 redirect(base_url().'Affiliate_ctrl/add_affiliatedetails');
			}
		}	
	  $this->load->view('template',$template); 	
    }

    public function view_department()
    {
    	$query2 = "SELECT * FROM `departments` ORDER BY `name` ASC";
		$template['departments'] = $this->Affiliated_model->get_all_result($query2,'select','','');
		$template['page'] = "_sd/departments";
	  	$template['page_title'] = "Add Departments";
 		$this->load->view('template',$template);
    }
    public function add_department()
    {
    	$check = $this->db->get_where("departments",array("name"=>$this->input->post('name')))->result();
		if (count($check) > 0) 
		{
			$this->session->set_flashdata('message',array('message' => 'Same name department already exist','class' => 'danger'));
			redirect("affiliate_ctrl/view_department");
		}
		else
		{
			$array = array("name"=>$this->input->post("name"),
						   "added_on"=>time(),
						   "status"=>1);
			$this->db->insert('departments',$array);
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("affiliate_ctrl/view_department");
		}
    }

    public function delete_departments()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `departments` WHERE `id` = '$id'";
		$r = $this->Affiliated_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("affiliate_ctrl/view_department");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("affiliate_ctrl/view_department");
		}
	}

	public function edit_departments()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		if ($_POST) {
			$array = array("name"=>$this->input->post("name"));
			$create = $this->Affiliated_model->get_all_result($array,'update','departments',array('id'=>$id));
			if ($create) {
				$this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
		    	redirect("affiliate_ctrl/edit_departments/".$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("affiliate_ctrl/edit_departments/".$id);	
		    }
		}
		else
		{
		  $query = "SELECT * FROM `departments` WHERE `id` = '$id'";
		  $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
		  $template['page'] = "_sd/edit_departments";
		  $template['page_title'] = "Add Departments";
	 	  $this->load->view('template',$template);
		}
	}

	 public function view_post()
    {
    	$query2 = "SELECT * FROM `post` ORDER BY `name` ASC";
		$template['post'] = $this->Affiliated_model->get_all_result($query2,'select','','');
		$template['page'] = "_sd/post";
	  	$template['page_title'] = "Add Post";
 		$this->load->view('template',$template);
    }
    public function add_post()
    {
    	$check = $this->db->get_where("post",array("name"=>$this->input->post('name')))->result();
		if (count($check) > 0) 
		{
			$this->session->set_flashdata('message',array('message' => 'Same name department already exist','class' => 'danger'));
			redirect("affiliate_ctrl/view_post");
		}
		else
		{
			$array = array("name"=>$this->input->post("name"),
						   "added_on"=>time(),
						   );
			$this->db->insert('post',$array);
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("affiliate_ctrl/view_post");
		}
    }

    public function delete_post()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `post` WHERE `id` = '$id'";
		$r = $this->Affiliated_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("affiliate_ctrl/view_post");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("affiliate_ctrl/view_post");
		}
	}

	public function edit_post()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		if ($_POST) {
			$array = array("name"=>$this->input->post("name"));
			$create = $this->Affiliated_model->get_all_result($array,'update','post',array('id'=>$id));
			if ($create) {
				$this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
		    	redirect("affiliate_ctrl/edit_post/".$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("affiliate_ctrl/edit_post/".$id);	
		    }
		}
		else
		{
		  $query = "SELECT * FROM `post` WHERE `id` = '$id'";
		  $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
		  $template['page'] = "_sd/edit_post";
		  $template['page_title'] = "Edit Post";
	 	  $this->load->view('template',$template);
		}
	}

 public function common_service()
    {
        //print_r($_SESSION['logged_in']['username']);die;
        $config = array();
        $config["base_url"] = base_url() . "Affiliate_ctrl/common_service";
        $config["total_rows"] = $this->c_m->get_count_common_service('common_service');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 50;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
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
        $template['list'] = $this->c_m->get_pagination_common_service($config["per_page"],$template['page'],'common_service');
        $template["links"] = $this->pagination->create_links();


        // $query2 = "SELECT * FROM `common_service`  ORDER BY `service_name` ASC";
  //    $query2 = 'SELECT * FROM `common_service` WHERE `status` <> "2" ORDER BY `service_name` ASC';
        // $template['list'] = $this->Affiliated_model->get_all_result($query2,'select','','');
        $template['page'] = "_sd/common_service";
        $template['page_title'] = "Add Common Service";
        $this->load->view('template',$template);
    }

    public function common_medical_service()
    {
        //print_r($_SESSION['logged_in']['username']);die;
        $config = array();
        $config["base_url"] = base_url() . "Affiliate_ctrl/common_service";
        $config["total_rows"] = $this->c_m->get_count_medical_service('common_service');
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
        $template['list'] = $this->c_m->get_pagination_common_medical_service($config["per_page"],$template['page'],'common_service');
        $template["links"] = $this->pagination->create_links();


        // $query2 = "SELECT * FROM `common_service`  ORDER BY `service_name` ASC";
  //    $query2 = 'SELECT * FROM `common_service` WHERE `status` <> "2" ORDER BY `service_name` ASC';
        // $template['list'] = $this->Affiliated_model->get_all_result($query2,'select','','');
        $template['page'] = "_sd/common_medical_service";
        $template['page_title'] = "Add Common Service";
        $this->load->view('template',$template);
    }


     public function export_common_service()
    {

        $uri = $this->uri->segment(3);
        //print_r($uri);die;
        if ($uri == "common_service" ) 
        {
        $query = 'SELECT * FROM `common_service` WHERE status = 1 AND type = "nurse" ORDER BY `service_name` ASC';
            
        }
        elseif ($uri == "medical_services" ) 
        {
        $query = 'SELECT * FROM `common_service` WHERE status = 1 AND type = "services" ORDER BY `service_name` ASC';
        }
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Service Name","Price","Added By","Added On");
        
    $i=1;
    foreach($details as $user)
    {
      

      $data[] = array(
        "#" =>$i,
        "service_name"=>$user['service_name'],
        "price"=>$user['price'],
        "added_by"=>$_SESSION['logged_in']['username'],
        "added_on"=>$user['added_on'],
      
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_common_service".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }


 public function add_common_service()
    {


      //  print_r($_SESSION['id']);die;
        if ($_POST) 
        {  
             $uri = $this->uri->segment(3);
             if ($uri == "nurse") {
                $type_by = "nurse";  
             }
             elseif ($uri == "medical_services") {
                $type_by = "services";
             }
           
            $array = array(
                "service_name"=>$this->input->post("service_name"),
                "price"=>$this->input->post("price"),
                "status"=>1,
                "type"=>$type_by,
                "added_by"=>$_SESSION['id'],
                "added_on"=>date('Y-m-d H:i:s'),
            
                );
            $this->db->insert('common_service',$array);
            //echo $this->db->last_query(); die;
            $news_id = $this->db->insert_id();
            $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
            redirect("Affiliate_ctrl/common_service");
        }
              
        else
        {
          
            $template['page'] = "_sd/add_common_service";
            $template['page_title'] = "Add Common Service";
            $this->load->view('template',$template);
        }
    }


     public function add_common_medical_services()
    {
      //  print_r($_SESSION['id']);die;  for nurse services,for medical services doorstep
        if ($_POST) 
        {  
            $type = $this->input->post("type");
            if ($type == 2) {
                $type_by = "services";
            }
           
            $array = array(
                "service_name"=>$this->input->post("service_name"),
                "price"=>$this->input->post("price"),
                "status"=>1,
                "type"=>$type_by,
                "added_by"=>$_SESSION['id'],
                "added_on"=>date('Y-m-d H:i:s'),
            
                );
            $this->db->insert('common_service',$array);
            //echo $this->db->last_query(); die;
            $news_id = $this->db->insert_id();
            $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
            redirect("Affiliate_ctrl/common_medical_service");
        }
              
        else
        {
          
            $template['page'] = "_sd/add_common_medical_services";
            $template['page_title'] = "Add Common Service";
            $this->load->view('template',$template);
        }
    }


    public function edit_common_service()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {


            $array = array(
                          "service_name"=>$this->input->post("service_name"),
                "price"=>$this->input->post("price"),
                "status"=>1,
                "added_by"=>$_SESSION['id'],
                "added_on"=>date('Y-m-d H:i:s'),
                            );
             $create = $this->Affiliated_model->get_all_result($array,'update','common_service',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
                redirect("Affiliate_ctrl/common_service/");
            }
            else
            {
                $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
                redirect("Affiliate_ctrl/common_service/");  
            }
        }
        else
        {
          $query = "SELECT * FROM `common_service` WHERE `id` = '$id'";
          $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
           $template['page'] = "_sd/edit_common_service";
          $template['page_title'] = "Edit Medical Equipment";
          $this->load->view('template',$template);
        }
    }

    public function edit_common_medical_service()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {

            
            $array = array(
                          "service_name"=>$this->input->post("service_name"),
                "price"=>$this->input->post("price"),
                "status"=>1,
                "added_by"=>$_SESSION['id'],
                "added_on"=>date('Y-m-d H:i:s'),
                            );
             $create = $this->Affiliated_model->get_all_result($array,'update','common_service',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
                redirect("Affiliate_ctrl/common_medical_service/");
            }
            else
            {
                $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
                redirect("Affiliate_ctrl/common_medical_service/");  
            }
        }
        else
        {
          $query = "SELECT * FROM `common_service` WHERE `id` = '$id'";
          $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
           $template['page'] = "_sd/edit_common_medical_service";
          $template['page_title'] = "Edit Medical Equipment";
          $this->load->view('template',$template);
        }
    }

    

      public function delete_common_service()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $uri_data = htmlentities(trim($this->uri->segment(4)));
       // print_r($nurse);die;

        if ($uri_data == "nurse") {
        $array = array("status"=>2);
        $create = $this->Affiliated_model->get_all_result($array,'update','common_service',array('id'=>$id));
        if ($create) {
           // $this->session->set_flashdata('delete','Delete Successfully...');
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully','class' => 'success')); 
            redirect("Affiliate_ctrl/common_service");  
        }
        else
        {
           // $this->session->set_flashdata('err','Something went wrong please try again...');
             $this->session->set_flashdata('message', array('message' => 'Something went wrong please try again...','class' => 'danger')); 
            redirect("Affiliate_ctrl/common_service");
        }
        }

        elseif ($uri_data == "medical_service") {
             $array = array("status"=>2);
        $create = $this->Affiliated_model->get_all_result($array,'update','common_service',array('id'=>$id));
        if ($create) {
           // $this->session->set_flashdata('delete','Delete Successfully...');
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully','class' => 'success')); 
            redirect("Affiliate_ctrl/common_medical_service");  
        }
        else
        {
           // $this->session->set_flashdata('err','Something went wrong please try again...');
             $this->session->set_flashdata('message', array('message' => 'Something went wrong please try again...','class' => 'danger')); 
            redirect("Affiliate_ctrl/common_medical_service");
        }
        }
        
    }
    //allergies


    public function view_allergies($rowno=0)
    {
        $data = array();
         $allergies_id = "";
        if($this->input->post('submit') != NULL ){
            $allergies_id = $this->input->post('allergies_id');
            $sess = $this->session->set_userdata(array("allergies_id"=>$allergies_id));
        }if($this->input->post('reset') != NULL)
        {
            unset(
                    $_SESSION['allergies_id']
                );
        }else{
            if($this->session->userdata('allergies_id') != NULL){
                $allergies_id = $this->session->userdata('allergies_id');
            }
        }
        $rowperpage = 100;
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        $total_records = $this->c_m->get_total_allergies_details($allergies_id);
        $template['allergies'] = $this->c_m->get_allergies_details_for_pagination($rowno,$rowperpage,$allergies_id);
        $config["base_url"] = base_url() . "Affiliate_ctrl/view_allergies";
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
        $template['allergies_id'] = $allergies_id;
        $template['allergies_lists'] = $this->c_m->get_allergies_lists();
        $template['page'] = "_sd/allergies";
        $template['page_title'] = "Add Allergies";
        $this->load->view('template',$template);
    }

    public function view_allergies_old()
    {

        $config = array();
        $config["base_url"] = base_url() . "Affiliate_ctrl/view_allergies";
        $config["total_rows"] = $this->c_m->get_count_surgeries('master_allergies');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 100;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
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
        $template['allergies'] = $this->c_m->get_pagination_surgeries($config["per_page"],$template['page'],'master_allergies');
        $template["links"] = $this->pagination->create_links();
    	// $query2 = "SELECT * FROM `master_allergies` ORDER BY `name` ASC";
		// $template['allergies'] = $this->Affiliated_model->get_all_result($query2,'select','','');
		$template['page'] = "_sd/allergies";
	  	$template['page_title'] = "Add Allergies";
 		$this->load->view('template',$template);
    }

    public function add_allergies()
    {

        if ($_POST) 
        {
        	$check = $this->db->get_where("master_allergies",array("name"=>$this->input->post('name')))->result();
    		if (count($check) > 0) 
    		{
    			$this->session->set_flashdata('message',array('message' => 'Same name Allergies already exist','class' => 'danger'));
    			redirect("affiliate_ctrl/view_allergies");
    		}
    		else
    		{
    			$array = array("name"=>$this->input->post("name"),
    						  );
    			$this->db->insert('master_allergies',$array);
    			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
    			redirect("affiliate_ctrl/view_allergies");
    		}
        }
        $template['page'] = "_sd/add_allergies";
        $template['page_title'] = "Add Allergies";
        $this->load->view('template',$template);
    }

    public function delete_allergies()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `master_allergies` WHERE `id` = '$id'";
		$r = $this->Affiliated_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("affiliate_ctrl/view_allergies");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("affiliate_ctrl/view_allergies");
		}
	}

	public function edit_allergies()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		if ($_POST) {
			$array = array("name"=>$this->input->post("name"));
			$create = $this->Affiliated_model->get_all_result($array,'update','master_allergies',array('id'=>$id));
			if ($create) {
				$this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
		    	redirect("affiliate_ctrl/edit_allergies/".$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("affiliate_ctrl/edit_allergies/".$id);	
		    }
		}
		else
		{
		  $query = "SELECT * FROM `master_allergies` WHERE `id` = '$id'";
		  $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
		  $template['page'] = "_sd/edit_allergies";
		  $template['page_title'] = "Add Allergies";
	 	  $this->load->view('template',$template);
		}
	}



	  public function export_allergies()
    {
        $query = 'SELECT * FROM `master_allergies`  ORDER BY `name` ASC';
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name");
        
    $i=1;
    foreach($details as $user)
    {
      

      $data[] = array(
        "#" =>$i,
        "allergies_name"=>$user['name']
      
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_allergies".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }

//view_illnesses

  public function view_illnesses($rowno=0)
    {
        $data = array();
         $illnesses_id = "";
        if($this->input->post('submit') != NULL ){
            $illnesses_id = $this->input->post('illnesses_id');
            $sess = $this->session->set_userdata(array("illnesses_id"=>$illnesses_id));
        }if($this->input->post('reset') != NULL)
        {
            unset(
                    $_SESSION['illnesses_id']
                );
        }else{
            if($this->session->userdata('illnesses_id') != NULL){
                $illnesses_id = $this->session->userdata('illnesses_id');
            }
        }
        $rowperpage = 100;
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        $total_records = $this->c_m->get_total_illnesses_details($illnesses_id);
        $template['illnesses'] = $this->c_m->get_illnesses_details_for_pagination($rowno,$rowperpage,$illnesses_id);
        $config["base_url"] = base_url() . "Affiliate_ctrl/view_illnesses";
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
        $template['illnesses_id'] = $illnesses_id;
        $template['illnesses_lists'] = $this->c_m->get_illnesses_lists();
        $template['page'] = "_sd/illnesses";
        $template['page_title'] = "Add illnesses";
        $this->load->view('template',$template);
    }


	 public function view_illnesses_old()
    {

        $config = array();
        $config["base_url"] = base_url() . "Affiliate_ctrl/view_illnesses";
        $config["total_rows"] = $this->c_m->get_count_surgeries('master_illnesses');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 100;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
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
        $template['illnesses'] = $this->c_m->get_pagination_surgeries($config["per_page"],$template['page'],'master_illnesses');
        $template["links"] = $this->pagination->create_links();


  //   	$query2 = "SELECT * FROM `master_illnesses` ORDER BY `name` ASC";
		// $template['illnesses'] = $this->Affiliated_model->get_all_result($query2,'select','','');
		$template['page'] = "_sd/illnesses";
	  	$template['page_title'] = "Add illnesses";
 		$this->load->view('template',$template);
    }

    public function add_illnesses()
    {
        if ($_POST) 
        {        
        	$check = $this->db->get_where("master_illnesses",array("name"=>$this->input->post('name')))->result();
    		if (count($check) > 0) 
    		{
    			$this->session->set_flashdata('message',array('message' => 'Same name illnesses already exist','class' => 'danger'));
    			redirect("affiliate_ctrl/view_illnesses");
    		}
    		else
    		{
    			$array = array("name"=>$this->input->post("name"),
    						  );
    			$this->db->insert('master_illnesses',$array);
    			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
    			redirect("affiliate_ctrl/view_illnesses");
    		}
        }
        $template['page'] = "_sd/add_illnesses";
        $template['page_title'] = "Add illnesses";
        $this->load->view('template',$template);

    }

    public function delete_illnesses()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `master_illnesses` WHERE `id` = '$id'";
		$r = $this->Affiliated_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("affiliate_ctrl/view_illnesses");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("affiliate_ctrl/view_illnesses");
		}
	}

	public function edit_illnesses()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		if ($_POST) {
			$array = array("name"=>$this->input->post("name"));
			$create = $this->Affiliated_model->get_all_result($array,'update','master_illnesses',array('id'=>$id));
			if ($create) {
				$this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
		    	redirect("affiliate_ctrl/edit_illnesses/".$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("affiliate_ctrl/edit_illnesses/".$id);	
		    }
		}
		else
		{
		  $query = "SELECT * FROM `master_illnesses` WHERE `id` = '$id'";
		  $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
		  $template['page'] = "_sd/edit_illnesses";
		  $template['page_title'] = "Add illnesses";
	 	  $this->load->view('template',$template);
		}
	}

	  public function export_illnesses()
    {
        $query = 'SELECT * FROM `master_illnesses`  ORDER BY `name` ASC';
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name");
        
    $i=1;
    foreach($details as $user)
    {
      

      $data[] = array(
        "#" =>$i,
        "illnesses_name"=>$user['name']
      
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_illnesses".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }



	//surgeries

  public function view_surgeries($rowno=0)
    {
        // print_r("expression");die;
        $data = array();
         $surgeries_id = "";
        if($this->input->post('submit') != NULL ){
            $surgeries_id = $this->input->post('surgeries_id');
            $sess = $this->session->set_userdata(array("surgeries_id"=>$surgeries_id));
        }if($this->input->post('reset') != NULL)
        {
            unset(
                    $_SESSION['surgeries_id']
                );
        }else{
            if($this->session->userdata('surgeries_id') != NULL){
                $surgeries_id = $this->session->userdata('surgeries_id');
            }
        }
        $rowperpage = 100;
        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        $total_records = $this->c_m->get_total_surgeries_details($surgeries_id);
        $template['surgeries'] = $this->c_m->get_surgeries_details_for_pagination($rowno,$rowperpage,$surgeries_id);
        $config["base_url"] = base_url() . "Affiliate_ctrl/view_surgeries";
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
        $template['surgeries_id'] = $surgeries_id;
        $template['surgeries_lists'] = $this->c_m->get_surgeries_lists();
        $template['page'] = "_sd/surgeries";
        $template['page_title'] = "Add surgeries";
        $this->load->view('template',$template);
    }



	 public function view_surgeries_old()
    {

        $config = array();
        $config["base_url"] = base_url() . "Affiliate_ctrl/view_surgeries";
        $config["total_rows"] = $this->c_m->get_count_surgeries('master_surgeries');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 100;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
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
        $template['surgeries'] = $this->c_m->get_pagination_surgeries($config["per_page"],$template['page'],'master_surgeries');
        $template["links"] = $this->pagination->create_links();


  //   	$query2 = "SELECT * FROM `master_surgeries` ORDER BY `name` ASC";
		// $template['surgeries'] = $this->Affiliated_model->get_all_result($query2,'select','','');
		$template['page'] = "_sd/surgeries";
	  	$template['page_title'] = "Add surgeries";
 		$this->load->view('template',$template);
    }

    public function add_surgeries()
    {

        if ($_POST) 
        {
        	$check = $this->db->get_where("master_surgeries",array("name"=>$this->input->post('name')))->result();
    		if (count($check) > 0) 
    		{
    			$this->session->set_flashdata('message',array('message' => 'Same name surgeries already exist','class' => 'danger'));
    			redirect("affiliate_ctrl/view_surgeries");
    		}
    		else
    		{
    			$array = array("name"=>$this->input->post("name"),
    						  );
    			$this->db->insert('master_surgeries',$array);
    			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
    			redirect("affiliate_ctrl/view_surgeries");
    		}
        }
        $template['page'] = "_sd/add_surgeries";
        $template['page_title'] = "Add surgeries";
        $this->load->view('template',$template);
    }

    public function delete_surgeries()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		$query = "DELETE FROM `master_surgeries` WHERE `id` = '$id'";
		$r = $this->Affiliated_model->get_all_result($query,'delete','','');
		if ($r) {
			$this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
			redirect("affiliate_ctrl/view_surgeries");
		}
		else
		{
			$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
			redirect("affiliate_ctrl/view_surgeries");
		}
	}

	public function edit_surgeries()
	{
		$id = htmlentities(trim($this->uri->segment(3)));
		if ($_POST) {
			$array = array("name"=>$this->input->post("name"));
			$create = $this->Affiliated_model->get_all_result($array,'update','master_surgeries',array('id'=>$id));
			if ($create) {
				$this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
		    	redirect("affiliate_ctrl/edit_surgeries/".$id);
		    }
		    else
		    {
		    	$this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
		    	redirect("affiliate_ctrl/edit_surgeries/".$id);	
		    }
		}
		else
		{
		  $query = "SELECT * FROM `master_surgeries` WHERE `id` = '$id'";
		  $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
		  $template['page'] = "_sd/edit_surgeries";
		  $template['page_title'] = "Add surgeries";
	 	  $this->load->view('template',$template);
		}
	}

	 public function export_surgeries()
    {
        $query = 'SELECT * FROM `master_surgeries`  ORDER BY `name` ASC';
        $details=  $this->c_m->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name");
        
    $i=1;
    foreach($details as $user)
    {
      

      $data[] = array(
        "#" =>$i,
        "surgeries_name"=>$user['name']
      
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_surgeries".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }

  public function import_allergies()
     {
            $data['error'] = '';
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '100000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // print_r($_FILES);die;
            if (!$this->upload->do_upload('name')) {
                $data['error'] = $this->upload->display_errors();
                print_r($data['error']);die;
                // $this->session->set_flashdata('delete','Something went wrong...');
            } else {
                $file_data = $this->upload->data();
                $file_path =  'uploads/'.$file_data['file_name'];
                if ($this->csvimport->get_array($file_path)) {
                    // print_r("shubham");die;
                    $csv_array = $this->csvimport->get_array($file_path);
                    $this->output->get_header('content-type');
                    // print_r($csv_array);die;
                    foreach ($csv_array as $row) {

                        $insert_data = array(
                            'name'=>$row['name']
                        );
                        $this->c_m->get_all_result($insert_data,'insert','master_allergies','');
                    }
               redirect("affiliate_ctrl/view_allergies");                    
                } 
            }
        }

         public function import_surgeries()
     {
            $data['error'] = '';
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '100000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // print_r($_FILES);die;
            if (!$this->upload->do_upload('name')) {
                $data['error'] = $this->upload->display_errors();
                print_r($data['error']);die;
                // $this->session->set_flashdata('delete','Something went wrong...');
            } else {
                $file_data = $this->upload->data();
                $file_path =  'uploads/'.$file_data['file_name'];
                if ($this->csvimport->get_array($file_path)) {
                    // print_r("shubham");die;
                    $csv_array = $this->csvimport->get_array($file_path);
                    $this->output->get_header('content-type');
                    // print_r($csv_array);die;
                    foreach ($csv_array as $row) {

                        $insert_data = array(
                            'name'=>$row['name']
                        );
                        $this->c_m->get_all_result($insert_data,'insert','master_surgeries','');
                    }
               redirect("affiliate_ctrl/view_surgeries");                    
                } 
            }
        }

          public function import_illnesses()
     {
            $data['error'] = '';
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '100000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // print_r($_FILES);die;
            if (!$this->upload->do_upload('name')) {
                $data['error'] = $this->upload->display_errors();
                print_r($data['error']);die;
                // $this->session->set_flashdata('delete','Something went wrong...');
            } else {
                $file_data = $this->upload->data();
                $file_path =  'uploads/'.$file_data['file_name'];
                if ($this->csvimport->get_array($file_path)) {
                    // print_r("shubham");die;
                    $csv_array = $this->csvimport->get_array($file_path);
                    $this->output->get_header('content-type');
                    // print_r($csv_array);die;
                    foreach ($csv_array as $row) {

                        $insert_data = array(
                            'name'=>$row['name']
                        );
                        $this->c_m->get_all_result($insert_data,'insert','master_illnesses','');
                    }
               redirect("affiliate_ctrl/view_illnesses");                    
                } 
            }
        }


        
     public function view_complain_reason()
    {
        $query2 = "SELECT * FROM `master_complain_reason` ORDER BY `name` ASC";
        $template['complain_reason'] = $this->Affiliated_model->get_all_result($query2,'select','','');
        $template['page'] = "_sd/complain_reason";
        $template['page_title'] = "Add complain Reason";
        $this->load->view('template',$template);
    }

    public function add_complain_reason()
    {
        $check = $this->db->get_where("master_complain_reason",array("name"=>$this->input->post('name')))->result();
        if (count($check) > 0) 
        {
            $this->session->set_flashdata('message',array('message' => 'Same name already exist','class' => 'danger'));
            redirect("affiliate_ctrl/view_complain_reason");
        }
        else
        {
            $array = array("name"=>$this->input->post("name"),
                          );
            $this->db->insert('master_complain_reason',$array);
            $this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
            redirect("affiliate_ctrl/view_complain_reason");
        }
    }

    public function delete_complain_reason()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $query = "DELETE FROM `master_complain_reason` WHERE `id` = '$id'";
        $r = $this->Affiliated_model->get_all_result($query,'delete','','');
        if ($r) {
            $this->session->set_flashdata('message',array('message' => 'Delete Successfully','class' => 'success'));
            redirect("affiliate_ctrl/view_complain_reason");
        }
        else
        {
            $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
            redirect("affiliate_ctrl/view_complain_reason");
        }
    }

    public function edit_complain_reason()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {
            $array = array("name"=>$this->input->post("name"));
            $create = $this->Affiliated_model->get_all_result($array,'update','master_complain_reason',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
                redirect("affiliate_ctrl/edit_complain_reason/".$id);
            }
            else
            {
                $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
                redirect("affiliate_ctrl/edit_complain_reason/".$id); 
            }
        }
        else
        {
          $query = "SELECT * FROM `master_complain_reason` WHERE `id` = '$id'";
          $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
          $template['page'] = "_sd/edit_complain_reason";
          $template['page_title'] = "Add surgeries";
          $this->load->view('template',$template);
        }
    }



     public function view_time_limit()
    {
        $query2 = "SELECT * FROM `master_time_limit` ";
        $template['time_limit'] = $this->Affiliated_model->get_all_result($query2,'select','','');
        $template['page'] = "_sd/time_limit";
        $template['page_title'] = "Add complain Reason";
        $this->load->view('template',$template);
    }

    public function add_time_limit()
    {
       
            $array = array("video_time"=>$this->input->post("video_time"),
                "chat_time"=>$this->input->post("chat_time"),
                "audio_time"=>$this->input->post("audio_time"),
                          );
            $this->db->insert('master_time_limit',$array);
            $this->session->set_flashdata('message',array('message' => 'Add Successfully','class' => 'success'));
            redirect("affiliate_ctrl/view_time_limit");
        
    }

    public function delete_time_limit()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $query = "DELETE FROM `master_time_limit` WHERE `id` = '$id'";
        $r = $this->Affiliated_model->get_all_result($query,'delete','','');
        if ($r) {
            $this->session->set_flashdata('message',array('message' => 'Delete Successfully','class' => 'success'));
            redirect("affiliate_ctrl/view_time_limit");
        }
        else
        {
            $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
            redirect("affiliate_ctrl/view_time_limit");
        }
    }

    public function edit_time_limit()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if ($_POST) {
            $array = array("video_time"=>$this->input->post("video_time"),
                "chat_time"=>$this->input->post("chat_time"),
                "audio_time"=>$this->input->post("audio_time"));
            $create = $this->Affiliated_model->get_all_result($array,'update','master_time_limit',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message',array('message' => 'Update Successfully...','class' => 'success'));
                redirect("affiliate_ctrl/edit_time_limit/".$id);
            }
            else
            {
                $this->session->set_flashdata('message',array('message' => 'Something went wrong please try again...','class' => 'danger'));
                redirect("affiliate_ctrl/edit_time_limit/".$id); 
            }
        }
        else
        {
          $query = "SELECT * FROM `master_time_limit` WHERE `id` = '$id'";
          $template['list'] = $this->Affiliated_model->get_all_result($query,'single_row','','');
          $template['page'] = "_sd/edit_time_limit";
          $template['page_title'] = "Add surgeries";
          $this->load->view('template',$template);
        }
    }



    // function insert_bank_data()
    //     {
         
    //       for ($i=0; $i < 10; $i++)
    //       {
    //         $data = array
    //         (
    //             'booking_type'=>1,
    //             'online_mode'=>'0',
    //             'doorstep_type'=>'emergency',
    //             'service_id'=>0,
    //             'patient_id'=>0,
    //             'assign_id'=>0,
    //             'doctor_id'=>0,
    //             'ambulance_assign_id'=>0,
    //             'ambulance_cat_id'=>0,
    //             'booking_for'=>'self',
    //             'name'=>'sd',
    //             'gender'=>'0',
    //             'dob'=>'0',
    //             'address'=>'address',
    //             'area'=>'area',
    //             'pincode'=>'1234',
    //             'city_state'=>'city_state',
    //             'problem'=>'problem',
    //             'booking_date'=>'0',
    //             'booking_time'=>'0',
    //             'booking_date_time'=>'2019-10-18 17:53:59',
    //             'nurse_assign_id'=>'0',
    //             'nurse_gender_prefer'=>'0',
    //             'coupan_code'=>'0',
    //             'coupan_code_id'=>'0',
    //             'total_amount'=>'10919.00',
    //             'wallet_amount'=>'0',
    //             'referral_amount'=>'81.00',
    //             'discount_amount'=>'0',
    //             'tax_amount'=>'0',
    //             'base_amount'=>'0',
    //             'trxn_status'=>'success',
    //             'trxn_mode'=>'ss',
    //             'trxn_id'=>'pay_DVX8UyefZPIbZP',
    //             'assign_by'=>'0',
    //             'status'=>'0',
    //             'added_on'=>'2019-10-18 17:53:59',
    //             'complete_on'=>'2019-10-18 17:53:59',
    //             'otp_for_appointment'=>'276339',
    //             'appointment_token'=>'0',
    //             'cancel_by_id'=>'0',
    //             'assign_time'=>'0',
    //             'cancel_time'=>'0',
    //             'images'=>'0',
    //             'payment_gateway'=>'razorpay',
    //             'currency'=>'INR',
    //             'payment_status'=>'authorized',
    //             'description'=>'1|emergency|12',
    //             'created_at'=>'1571401764',
    //             'method'=>'netbanking',
    //             'fee'=>'0',
    //             'tax'=>'0',
    //             'payment_method_email'=>'sachinappslure@gmail.com',
    //             'payment_method_contact'=>'+918290838118',
    //             'refernece_id'=>'0',
    //             'prescription_type'=>'0',
    //             'prescription_content'=>'0',
    //             'prescription_added_on'=>'0',
    //             'refund_status'=>'0',
    //             'refund_status'=>'0',
    //             'refund_trxn_id'=>'0',
    //             'refund_date'=>'0',
    //             'refund_by'=>'0',
    //             'is_package'=>'0',
    //         );
    //         $this->db->insert('booking',$data);
    //         }
    //         echo "Done";
    //     }




}	