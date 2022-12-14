<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kumbh_management extends CI_Controller{

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

    public function kumbh()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/ropeway/"; 
                $target_dir = "uploads/ropeway/";
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
                           "title"=>$this->input->post("title"),
                           "hindi_title"=>$this->input->post("hindi_title"),
                           "gujrati_title"=>$this->input->post("gujrati_title"),
                           "subtitle"=>$this->input->post("subtitle"),
                           "hindi_subtitle"=>$this->input->post("hindi_subtitle"),
                           "gujrati_subtitle"=>$this->input->post("gujrati_subtitle"),
                           "description"=>$this->input->post("description"),
                           "hindi_description"=>$this->input->post("hindi_description"),
                           "gujrati_description"=>$this->input->post("gujrati_description"),
                           "added_by"=>$this->session->userdata('id')
                          );
                    $this->db->insert('kumbh',$array);
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
                    $target_path = "uploads/ropeway/"; 
                    $target_dir = "uploads/ropeway/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                    if(!empty($actual_image_name) && !empty($extension))
                    {
                        $array = array("image"=>$actual_image_name,
                                "status"=>$this->input->post("status"),
                                "title"=>$this->input->post("title"),
                               "hindi_title"=>$this->input->post("hindi_title"),
                               "gujrati_title"=>$this->input->post("gujrati_title"),
                               "subtitle"=>$this->input->post("subtitle"),
                               "hindi_subtitle"=>$this->input->post("hindi_subtitle"),
                               "gujrati_subtitle"=>$this->input->post("gujrati_subtitle"),
                               "description"=>$this->input->post("description"),
                               "hindi_description"=>$this->input->post("hindi_description"),
                               "gujrati_description"=>$this->input->post("gujrati_description"),
                                );
                        $create = $this->c_m->get_all_result($array,'update','kumbh',array('id'=>$id));
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
                    $array = array("title"=>$this->input->post("title"),
                                   "hindi_title"=>$this->input->post("hindi_title"),
                                   "gujrati_title"=>$this->input->post("gujrati_title"),
                                   "subtitle"=>$this->input->post("subtitle"),
                                   "hindi_subtitle"=>$this->input->post("hindi_subtitle"),
                                   "gujrati_subtitle"=>$this->input->post("gujrati_subtitle"),
                                   "description"=>$this->input->post("description"),
                                   "hindi_description"=>$this->input->post("hindi_description"),
                                   "gujrati_description"=>$this->input->post("gujrati_description"),
                                    "status"=>$this->input->post("status"),);
                    $create = $this->c_m->get_all_result($array,'update','kumbh',array('id'=>$id));
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
        $query = 'SELECT * FROM `kumbh` WHERE `status` <> "2" ORDER BY `title` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/app_management/kumbh";
        $template['page_title'] = "Kumbh";
        $this->load->view('template',$template);
    }

    public function delete_kumbh()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','kumbh',array('id'=>$id));
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