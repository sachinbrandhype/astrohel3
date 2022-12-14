<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcasts_management extends CI_Controller{

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

    

    public function broadcasts()
    {

        // print_r("expression"); die;
        
        if($_POST){
            // print_r($_FILES); die;
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/post/"; 
                $target_dir = "uploads/post/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);

                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array(
                      "thumbnail"=>$actual_image_name,
                       "astrologer_id"=>$this->input->post("astrologer_id"),   
                      "name"=>$this->input->post("name"),                         
                      "description"=>$this->input->post("description"),                         
                      "status"=>$this->input->post("status"),                         
                      "media_type"=>3,                         
                          );
                    $this->db->insert('posts',$array);
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


                
                    $array = array(  
                    
                      
                      "astrologer_id"=>$this->input->post("astrologer_id"),                         
                      "name"=>$this->input->post("name"),                         
                      "description"=>$this->input->post("description"),                         
                      "status"=>$this->input->post("status")                         


                      ,);
                    $create = $this->c_m->get_all_result($array,'update','posts',array('id'=>$id));
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
               
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }

        $query = 'SELECT * FROM `broadcasts` ORDER BY `id` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
     
     
        $template['page'] = "broadcasts/broadcasts";
        $template['page_title'] = "Broadcasts";
        $this->load->view('template',$template);
    }

    public function delete_broadcasts()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','broadcasts',array('id'=>$id));
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

    public function approval_post()
    {
       if ($_POST) 
       {   
            $approval_id =  $this->input->post("approval_id");
            $data = array("approved"=>1);
            $create = $this->c_m->get_all_result($data,'update','posts',array('id'=>$approval_id));
            if ($create) 
            {
             
                $this->session->set_flashdata('message', array('message' => 'Approvae Successfully','class' => 'success')); 
                redirect($_SERVER['HTTP_REFERER']);
            }   
      }
    }
}