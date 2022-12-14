<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Yogas_management extends CI_Controller{

	function __construct () {
		parent::__construct();
		$this->load->model("Speedhuntson_m","c_m");
		$this->load->library('encryption');
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->library('user_agent');
		$this->load->library('session');
        if(!$this->session->userdata('logged_in')) 
        { 
            redirect(base_url());
        }
	}

    public function yogas()
    {
        
        if($_POST){
            $data = $_POST;
            // print_r($_POST); die;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/yoga/"; 
                $target_dir = "uploads/yoga/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array("image"=>$actual_image_name,
                           "status"=>$this->input->post("status"),
                           "name"=>$this->input->post("name"),
                           "price"=>$this->input->post("price"),
                           "position"=>$this->input->post("position"),
                           
                           "description"=>$this->input->post("description"),
                         
                          );
                    $this->db->insert('yogas',$array);
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
                }
                else
                {
                    $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                
            }
            elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/yoga/"; 
                    $target_dir = "uploads/yoga/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                    if(!empty($actual_image_name) && !empty($extension))
                    {
                        $array = array("image"=>$actual_image_name,
                              "status"=>$this->input->post("status"),
                           "name"=>$this->input->post("name"),
                           "price"=>$this->input->post("price"),
                           "position"=>$this->input->post("position"),
                           "description"=>$this->input->post("description"),
                                );
                        $create = $this->c_m->get_all_result($array,'update','yogas',array('id'=>$id));
                        $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                        redirect($this->agent->referrer());
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                        redirect($this->agent->referrer());
                    }
                }
                else
                {
                    $array = array(  "status"=>$this->input->post("status"),
                           "name"=>$this->input->post("name"),
                           "price"=>$this->input->post("price"),
                           "position"=>$this->input->post("position"),
                           "description"=>$this->input->post("description"),);
                    $create = $this->c_m->get_all_result($array,'update','yogas',array('id'=>$id));
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
                }
                
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `yogas` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/app_management/yogas";
        $template['page_title'] = "Yoga";
        $this->load->view('template',$template);
    }

    public function delete_yogas()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','yogas',array('id'=>$id));
        if ($create) 
        {
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully!','class' => 'success'));
            redirect($this->agent->referrer());   
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
            redirect($this->agent->referrer());
        }
    }


    public function yoga_videos()
    {
        
        if($_POST){
            // print_r($_FILES); die;
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/yoga/video/"; 
                $target_dir = "uploads/yoga/video/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);

                $target_file_file = $target_dir . basename($_FILES["video_file"]["name"]);
                $imagename = basename($_FILES["video_file"]["name"]);
                $extension_file = substr(strrchr($_FILES['video_file']['name'], '.'), 1);
                $actual_file_name = time().".".$extension_file;
                move_uploaded_file($_FILES["video_file"]["tmp_name"],$target_path.$actual_file_name);
                // print_r($actual_file_name); die;
                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array(
                      "image"=>$actual_image_name,
                      "file"=>$actual_file_name,
                      "yoga_id"=>$this->input->post("yoga_id"),                         
                          );
                    $this->db->insert('yoga_videos',$array);
                    // echo $this->db->last_query(); die;
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
                }
                else
                {
                    $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                
            }
            elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];

                  if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/yoga/video/"; 
                    $target_path = "uploads/yoga/video/"; 
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                }
                else{
                      $actual_image_name = $this->input->post("old_image");
                }
                  if (!empty($_FILES['video_file']['name'])) 
                {
                   $target_path = "uploads/yoga/video/"; 
                    $target_path = "uploads/yoga/video/"; 
                    $target_file = $target_dir . basename($_FILES["video_file"]["name"]);
                    $imagename = basename($_FILES["video_file"]["name"]);
                    $extension = substr(strrchr($_FILES['video_file']['name'], '.'), 1);
                    $actual_file_name = time().".".$extension;
                    move_uploaded_file($_FILES["video_file"]["tmp_name"],$target_path.$actual_file_name);
                }
                else{
                      $actual_file_name = $this->input->post("old_video");
                }



                
                    $array = array(  
                      "image"=>$actual_image_name,
                      "file"=>$actual_file_name,
                      "yoga_id"=>$this->input->post("yoga_id"),);
                    $create = $this->c_m->get_all_result($array,'update','yoga_videos',array('id'=>$id));
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
               
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `yoga_videos` ORDER BY `yoga_id` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $query1 = 'SELECT * FROM `yogas` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['yogas'] = $this->c_m->get_all_result($query1,'select','','');
        $template['page'] = "sd/app_management/yoga_videos";
        $template['page_title'] = "Yoga Video";
        $this->load->view('template',$template);
    }

    public function delete_yoga_videos()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','yoga_videos',array('id'=>$id));
        if ($create) 
        {
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully!','class' => 'success'));
            redirect($this->agent->referrer());   
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
            redirect($this->agent->referrer());
        }
    }
}