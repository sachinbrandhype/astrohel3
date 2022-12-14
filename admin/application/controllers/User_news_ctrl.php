<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_news_ctrl extends CI_Controller {
	public function __construct() {
	parent::__construct();	
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Lab_model');
    $this->load->model('User_news_model');
	    $this->load->library('pagination');
	     $this->load->library('csvimport');
          $this->load->helper('directory');

		 $this->load->library('form_validation');		
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }





  //user_news


     public function user_news($rowno=0)
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
        $total_records = $this->User_news_model->get_total_news($title_data,$start_date,$end_date);
        // echo $this->db->last_query();die;
        $template['lab_package'] = $this->User_news_model->get_news_for_pagination($rowno,$rowperpage,$title_data,$start_date,$end_date);
        $config['base_url'] = base_url() . '/User_news_ctrl/user_news/';
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

      $template['page'] = "user_news/user_news";
    $template['page_title'] = "View Gems Products ";
  
    $this->load->view('template',$template);
  }



  public function user_news_1()
  {
      $config = array();
        $config["base_url"] = base_url() . "User_news_ctrl/user_news";
        $config["total_rows"] = $this->User_news_model->get_count('user_news');
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
        $template['lab_package'] = $this->User_news_model->get_pagination_data_user_news($config["per_page"],$template['page'],'user_news');
        $template["links"] = $this->pagination->create_links();

      $template['page'] = "user_news/user_news";
    $template['page_title'] = "View Gems Products ";
    //$template['lab_package'] = $this->Lab_model->get_lab_package();
    //echo $this->db->last_query();die;
    $this->load->view('template',$template);
  }


  public function add_user_news(){
    $template['page'] = "user_news/add_user_news";
    $template['page_title'] = "Add  user_news";
   
    if($_POST){ 
      // print_r($_FILES); die;

      if(($_FILES['image']['size'] > 0)) {
                    $config = $this->set_upload_options();
          $this->load->library('upload');
          $this->upload->initialize($config);
          if ( ! $this->upload->do_upload('image')) {
            //$result = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('message', array('message' => $this->upload->display_errors().'Error Occured While Uploading Files','class' => 'danger'));
            //echo $this->upload->display_errors();
            redirect($this->agent->referrer());
          }
          $upload_data = $this->upload->data();
          $data['image'] = $upload_data['file_name'];
                }



     
   // print_r( $data['image']);die;

      $check = $this->db->get_where("user_news",array("title"=>$this->input->post('title')))->result();
    if (count($check) > 0) 
    {
      $this->session->set_flashdata('message',array('message' => 'Same title already exist','class' => 'danger'));
      redirect("User_news_ctrl/user_news");
    }
    else 
    {
  
    $data = array(
        'title' => $this->input->post('title'),
        'date' => $this->input->post('date'),
        'description' => $this->input->post('description'),
        'position' => $this->input->post('position'),
        'status' => $this->input->post('status'),
        'url' => $this->input->post('url'),
        'image' => $data['image'],
        'added_on' =>date("Y-m-d H:i:s"),
               );
    // print_r($data);die;
      
      $result = $this->User_news_model->add($data,'user_news');
      if($result) {
        $this->session->set_flashdata('message',array('message' => 'Add user_news Details successfully','class' => 'success'));
        redirect(base_url().'User_news_ctrl/user_news');
      }
      else {
        $this->session->set_flashdata('message', array('message' => 'Error','class' => 'error'));  
        redirect(base_url().'User_news_ctrl/user_news');
      }
      }
    } 
    $this->load->view('template',$template);
  }






  public function edit_user_news(){
// print_r("expression");die;
    $template['page'] = "user_news/edit_user_news";
    $template['page_title'] = "Edit edit_user_news";
    $id = $this->uri->segment(3);
    $template['data'] = $this->User_news_model->get_single_data($id,'user_news');
    
    if($_POST){
    //print_r($_POST);die;

      $old_img = $this->input->post('image11');
      
      $id = $this->uri->segment(3);
      if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
        $config['upload_path'] = 'uploads/news/';
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
        'date' => $this->input->post('date'),
        'description' => $this->input->post('description'),
        'position' => $this->input->post('position'),
        'status' => $this->input->post('status'),
        'url' => $this->input->post('url'),
        'image' => $display_image,
        
               );
    $result = $this->User_news_model->edit($data_table, $id,'user_news');        
        $this->session->set_flashdata('message',array('message' => 'News Updated successfully','class' => 'success'));
        redirect(base_url().'User_news_ctrl/user_news');
      
    } 
    $this->load->view('template',$template);  
  }


    private function set_upload_options($path='uploads/news') {   
    //upload an image options
    $config = array();
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size']      = '10000';
    $config['overwrite']     = FALSE;

    return $config;
  }


  public function delete_user_news(){
    $id = $this->uri->segment(3);
  
  $data_table = array('status' =>0,
               );
  $result = $this->User_news_model->delete($data_table, $id,'user_news');    
 
    $this->session->set_flashdata('message', array('message' => 'Deleted Successfully','class' => 'success'));
     redirect(base_url().'User_news_ctrl/user_news');
  }


   public function export_user_news()
    {
        $query = 'SELECT * FROM `user_news`  ORDER BY `name` ASC';
        $details=  $this->User_news_model->get_all_result_array($query,'select','','');
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
      header("Content-Disposition: attachment; filename=\"export_user_news".".csv\"");
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