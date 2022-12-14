<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_management extends CI_Controller{

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

    public function gallery()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/gallery/"; 
                $target_dir = "uploads/gallery/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array("image"=>$actual_image_name,
                           "added_on"=>date('Y-m-d H:i:s'),
                           "status"=>$this->input->post("status"),
                           "position"=>$this->input->post("position"),
                           "added_by"=>$this->session->userdata('id')
                          );
                    $this->db->insert('gallery',$array);
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
                    $target_path = "uploads/gallery/"; 
                    $target_dir = "uploads/gallery/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                    if(!empty($actual_image_name) && !empty($extension))
                    {
                        $array = array("image"=>$actual_image_name,
                                "status"=>$this->input->post("status"),
                                "position"=>$this->input->post("position")
                                );
                        $create = $this->c_m->get_all_result($array,'update','gallery',array('id'=>$id));
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
                    $array = array("position"=>$this->input->post("position"),
                                    "status"=>$this->input->post("status"),);
                    $create = $this->c_m->get_all_result($array,'update','gallery',array('id'=>$id));
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
        $query = 'SELECT * FROM `gallery` WHERE `status` <> "2" ORDER BY `position` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/app_management/gallery";
        $template['page_title'] = "Gallery";
        $this->load->view('template',$template);
    }

    public function delete_gallery()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','gallery',array('id'=>$id));
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


    public function FunctionName($value='')
    {
        # code...
    }

    public function testimonials()
    {
        $query = 'SELECT * FROM `testimonials` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/app_management/testimonials";
        $template['page_title'] = "Testimonials";
        $this->load->view('template',$template);
    }

    public function add_testimonials()
    {
        if ($_POST) 
        {   
            $array = array(
                "name"=>$this->input->post("name"),
                "rating"=>$this->input->post("rating"),
                "comments"=>$this->input->post("comments"),
                "status"=>$this->input->post("status"),
                "added_on"=>date('Y-m-d H:i:s')
            );
            $this->db->insert('testimonials',$array);
            $news_id = $this->db->insert_id();
            $this->session->set_flashdata('delete','Add Successfully!!!!!!');
            redirect("sd/app_management/testimonials");
        }
    }

    public function edit_testimonials()
    {
        if ($_POST) {
            $id = $this->input->post("id");
            $query = "SELECT * FROM `testimonials` WHERE `id` = '$id'";
            $this->data['list'] = $this->c_m->get_all_result($query,'single_row','','');
            $array = array("name"=>$this->input->post("name"),
                            "rating"=>$this->input->post("rating"),
                            "comments"=>$this->input->post("comments"),
                            "status"=>$this->input->post("status"),);
            $create = $this->c_m->get_all_result($array,'update','testimonials',array('id'=>$id));
            if ($create) {
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect("sd/app_management/testimonials");
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect("sd/app_management/testimonials");
            }
        }
    }

    public function delete_testimonials()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','testimonials',array('id'=>$id));
        if ($create) {
            $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
            redirect("sd/app_management/testimonials");   
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
            redirect("sd/app_management/testimonials");
        }
    }
}