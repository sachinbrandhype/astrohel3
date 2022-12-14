<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_video_ctrl extends CI_Controller {
	public function __construct() {
	parent::__construct();	
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Lab_model');
    $this->load->model('User_video_model');
	    $this->load->library('pagination');
	     $this->load->library('csvimport');
		 $this->load->library('form_validation');		
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }





  //user_video

    public function user_video($rowno=0)
  {
       $data = array();
         $title_data = "";
         $start_date = "";
         $end_date = "";
        if($this->input->post('submit') != NULL ){
            $title_data = $this->input->post('title_data');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $sess = $this->session->set_userdata(array("title_data"=>$title_data,"start_date"=>$start_date,"end_date" => $end_date));
        }if($this->input->post('reset') != NULL)
        {
            unset(
                    $_SESSION['title_data'],
                    $_SESSION['start_date'],
                    $_SESSION['end_date']
                  
                );
        }else{
            if($this->session->userdata('title_data') != NULL){
                $title_data = $this->session->userdata('title_data');
            }
            if($this->session->userdata('start_date') != NULL){
                $start_date = $this->session->userdata('start_date');
            }
            if($this->session->userdata('end_date') != NULL){
                $end_date = $this->session->userdata('end_date');
            }
        }
        $rowperpage = 20;

        if($rowno != 0){
            $rowno = ($rowno-1) * $rowperpage;
        }
        // print_r($title_data);die;
        $total_records = $this->User_video_model->get_total_video($title_data,$start_date,$end_date);
        $template['lab_package'] = $this->User_video_model->get_video_for_pagination($rowno,$rowperpage,$title_data,$start_date,$end_date);
        // echo $this->db->last_query();die;
        $config['base_url'] = base_url() . '/User_video_ctrl/user_video/';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $rowperpage;
        $config['cur_tag_open'] = '<a class="current">';  
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);
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
        $template["links"] = $this->pagination->create_links();
        $template['row'] = $rowno;
        $template['title_data'] = $title_data;
        $template['start_date'] = $start_date;
        $template['end_date'] = $end_date;

      $template['page'] = "user_video/user_video";
    $template['page_title'] = "View Video  ";
 
    $this->load->view('template',$template);
  }



  public function user_video_1()
  {
      $config = array();
        $config["base_url"] = base_url() . "User_video_ctrl/user_video";
        $config["total_rows"] = $this->User_video_model->get_count('user_video');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 100;
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
        $template['lab_package'] = $this->User_video_model->get_pagination_data_user_video($config["per_page"],$template['page'],'user_video');
        $template["links"] = $this->pagination->create_links();

      $template['page'] = "user_video/user_video";
    $template['page_title'] = "View Gems Products ";
    //$template['lab_package'] = $this->Lab_model->get_lab_package();
    //echo $this->db->last_query();die;
    $this->load->view('template',$template);
  }


  


  public function add_user_video(){
    $template['page'] = "user_video/add_user_video";
    $template['page_title'] = "Add  user_video";
   
    if($_POST){ 

      if (!empty($_FILES['image'])) {
        $config['upload_path'] = 'uploads/video/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');
          $this->upload->initialize($config);
        $imageUpload = '';
        if (!$this->upload->do_upload('image')) {
          $error = array(
            'error' => $this->upload->display_errors()
          );
          $display_image = 'default.png';
          // print_r($error);
        }
        else {
          $imageUpload = $this->upload->data();
          $display_image = $imageUpload['file_name'];
        }
      }
      else {
        $display_image = 'default.png';
      }
   // print_r($_POST);die;

      $check = $this->db->get_where("user_video",array("title"=>$this->input->post('title')))->result();
    if (count($check) > 0) 
    {
      $this->session->set_flashdata('message',array('message' => 'Same title already exist','class' => 'danger'));
      redirect("User_video_ctrl/user_video");
    }
    else 
    {
  
    $data = array(
        'title' => $this->input->post('title'),
        'in_app' => $this->input->post('in_app'),
        'youtube_url' => $this->input->post('youtube_url'),
        'position' => $this->input->post('position'),
        'status' => $this->input->post('status'),
        'thumbnail_image' => $display_image,
        'added_on' =>date("Y-m-d H:i:s"),
               );
    // print_r($data);die;
      
      $result = $this->User_video_model->add($data,'user_video');
      if($result) {
        $this->session->set_flashdata('message',array('message' => 'Add user_video Details successfully','class' => 'success'));
        redirect(base_url().'User_video_ctrl/user_video');
      }
      else {
        $this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
        redirect(base_url().'User_video_ctrl/user_video');
      }
      }
    } 
    $this->load->view('template',$template);
  }

  public function edit_user_video(){
// print_r("expression");die;
    $template['page'] = "user_video/edit_user_video";
    $template['page_title'] = "Edit edit_user_video";
    $id = $this->uri->segment(3);
    $template['data'] = $this->User_video_model->get_single_data($id,'user_video');
    
    if($_POST){
    //print_r($_POST);die;

      $old_img = $this->input->post('image11');
      
      $id = $this->uri->segment(3);
      if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
        $config['upload_path'] = 'uploads/video/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['encrypt_name'] = TRUE;
         $this->load->library('upload');
          $this->upload->initialize($config);
        $imageUpload = '';
        if (!$this->upload->do_upload('image')) {
          $display_image = $old_img;
          $error = array(
            'error' => $this->upload->display_errors()
          );
        }
        else {
          $imageUpload = $this->upload->data();
          $display_image = $imageUpload['file_name'];
          
          unlink($old_img);
          

        }
      }
      else {
        $display_image = $old_img;
      }


 
    $data_table = array( 
       'title' => $this->input->post('title'),
        'in_app' => $this->input->post('in_app'),
        'youtube_url' => $this->input->post('youtube_url'),
        'position' => $this->input->post('position'),
        'status' => $this->input->post('status'),
        'thumbnail_image' => $display_image,
        
               );
    $result = $this->User_video_model->edit($data_table, $id,'user_video');        
        $this->session->set_flashdata('message',array('message' => 'Test Package Lab Details Updated successfully','class' => 'success'));
        redirect(base_url().'User_video_ctrl/user_video');
      
    } 
    $this->load->view('template',$template);  
  }

  public function delete_user_video(){
    $id = $this->uri->segment(3);
  
  $data_table = array('status' =>0,
               );
  $result = $this->User_video_model->delete($data_table, $id,'user_video');    
 
    $this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
     redirect(base_url().'User_video_ctrl/user_video');
  }


   public function export_user_video()
    {
        $query = 'SELECT * FROM `user_video`  ORDER BY `name` ASC';
        $details=  $this->user_video_model->get_all_result_array($query,'select','','');
        //print_r($details);die;
    $data[] = array("#","Name","description","benfits","Discount Price","price","position","Show In App","status","image","Added On");
        
    $i=1;
    foreach($details as $user)
    {
      if ($user['in_app'] == 1) {
        $show_in_app = "Yes";
      }
      else
      {
        $show_in_app = "No";
      }

       if ($user['status'] == 1) {
        $status = "Active";
      }
      else
      {
        $status = "Delete";
      }
    

      $data[] = array(
        "#" =>$i,
        "name"=>$user['name'],
        "description"=>$user['description'],
        "benfits"=>$user['benfits'],
        "discount_price"=>$user['discount_price'],
        "price"=>$user['price'],
        "position"=>$user['position'],
        
        "show_in_app"=>$show_in_app,
        "status"=>$status,
        "image"=>$user['image'],
    
        "added_on"=>$user['added_on'],
      );
       $i++;
    }

    header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=\"export_user_video".".csv\"");
      header("Pragma: no-cache");
      header("Expires: 0");

      $handle = fopen('php://output', 'w');

      foreach ($data as $data) {
          fputcsv($handle, $data);
      }
                  
      fclose($handle);
      exit;
  }


    



}