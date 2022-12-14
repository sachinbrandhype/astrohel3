<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_master extends CI_Controller{

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




// Gift


 public function gifts()
    {
        
        if($_POST){
            $data = $_POST;
            // print_r($_FILES); die;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/gift/"; 
                $target_dir = "uploads/gift/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                // print_r($extension); die;

                    $array = array(
                            "image"=>$actual_image_name,
                           "name"=>$this->input->post("name"),
                           "price"=>$this->input->post("price"),
                           "position"=>$this->input->post("position"),
                           "status"=>$this->input->post("status"),
                          );
                  
                $this->db->insert('gifts',$array);
                // echo $this->db->last_query(); die;
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());  
              


            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];

                  if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/gift/"; 
                    $target_dir = "uploads/gift/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                }
                else{
                      $actual_image_name = $this->input->post("old_image");
                }


                $array = array(
                    "image"=>$actual_image_name,
                    "name"=>$this->input->post("name"),
                     "price"=>$this->input->post("price"),
                           "position"=>$this->input->post("position"),
                              "status"=>$this->input->post("status"),);


                $create = $this->c_m->get_all_result($array,'update','gifts',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `gifts` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
         // echo $this->db->last_query(); die;
        $template['page'] = "sd/edit_master/gifts";
        $template['page_title'] = "Gifts";
        $this->load->view('template',$template);
    } 

    public function delete_gifts()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','gifts',array('id'=>$id));
         // echo $this->db->last_query(); die;
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


// master_service_offered


 public function master_service_offered()
    {
        
        if($_POST){
            $data = $_POST;
            // print_r($_FILES); die;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/specialities/"; 
                $target_dir = "uploads/specialities/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                // print_r($extension); die;

                    $array = array("image"=>$actual_image_name,
                           "name"=>$this->input->post("name"),
                           "in_home"=>$this->input->post("in_home"),
                           "position"=>$this->input->post("position"),
                           "type"=>2,
                           "added_on"=>date('Y-m-d H:i:s'),
                           "status"=>$this->input->post("status"),
                          );
                  
                $this->db->insert('master_specialization',$array);
                // echo $this->db->last_query(); die;
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());  
              


            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];

                  if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/specialities/"; 
                    $target_dir = "uploads/specialities/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                }
                else{
                      $actual_image_name = $this->input->post("old_image");
                }


                $array = array(
                    "image"=>$actual_image_name,
                    "name"=>$this->input->post("name"),
                     "in_home"=>$this->input->post("in_home"),
                           "position"=>$this->input->post("position"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','master_specialization',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_specialization` WHERE `status` <> "2" AND type = 2 ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
         // echo $this->db->last_query(); die;
        $template['page'] = "sd/edit_master/master_service_offered";
        $template['page_title'] = "Master Service Offered";
        $this->load->view('template',$template);
    } 

    public function delete_master_service_offered()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','master_specialization',array('id'=>$id));
         // echo $this->db->last_query(); die;
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


// master_specialization


 public function master_specialization()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                           "type"=>1,
                           "added_on"=>date('Y-m-d H:i:s'),
                           "status"=>$this->input->post("status"),
                          );
                $this->db->insert('master_specialization',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','master_specialization',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_specialization` WHERE `status` <> "2" AND type = 1 ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_specialization";
        $template['page_title'] = "Master Specialization";
        $this->load->view('template',$template);
    } 

    public function delete_master_specialization()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','master_specialization',array('id'=>$id));
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




    public function master_god()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array(
                    "name"=>$this->input->post("name"),
                    "hindi_name"=>$this->input->post("hindi_name"),
                    "gujrati_name"=>$this->input->post("gujrati_name"),
                           "added_on"=>date('Y-m-d H:i:s'),
                           "status"=>$this->input->post("status"),
                           "added_by"=>$this->session->userdata('id')
                          );
                $this->db->insert('master_god',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                      "hindi_name"=>$this->input->post("hindi_name"),
                    "gujrati_name"=>$this->input->post("gujrati_name"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','master_god',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_god` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_god";
        $template['page_title'] = "Master God";
        $this->load->view('template',$template);
    } 

    public function delete_master_god()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','master_god',array('id'=>$id));
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
    public function master_temple()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                           "added_on"=>date('Y-m-d H:i:s'),
                            "hindi_name"=>$this->input->post("hindi_name"),
                    "gujrati_name"=>$this->input->post("gujrati_name"),
                           "status"=>$this->input->post("status"),
                           "added_by"=>$this->session->userdata('id')
                          );
                $this->db->insert('master_temple',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                     "hindi_name"=>$this->input->post("hindi_name"),
                    "gujrati_name"=>$this->input->post("gujrati_name"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','master_temple',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_temple` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_temple";
        $template['page_title'] = "Master Temple";
        $this->load->view('template',$template);
    } 

    public function delete_master_temple()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','master_temple',array('id'=>$id));
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



    public function master_occupation()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                           "added_on"=>date('Y-m-d H:i:s'),
                           "status"=>$this->input->post("status"),
                           "added_by"=>$this->session->userdata('id')
                          );
                $this->db->insert('master_occupation',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','master_occupation',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_occupation` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_occupation";
        $template['page_title'] = "Master Occupation";
        $this->load->view('template',$template);
    } 

    public function delete_master_occupation()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','master_occupation',array('id'=>$id));
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

// cities

    public function master_cities()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                           
                           "status"=>$this->input->post("status"),
                         
                          );
                $this->db->insert('cities',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','cities',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `cities` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_cities";
        $template['page_title'] = "Master Cities";
        $this->load->view('template',$template);
    } 

    public function delete_master_cities()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','cities',array('id'=>$id));
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

// cities

    public function master_venues()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                           
                           "city_id"=>$this->input->post("city_id"),
                           "status"=>$this->input->post("status"),
                         
                          );
                $this->db->insert('venues',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array(
                    "name"=>$this->input->post("name"),
                    "city_id"=>$this->input->post("city_id"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','venues',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `venues` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');

        $query1 = 'SELECT * FROM `puja_location` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['cities'] = $this->c_m->get_all_result($query1,'select','','');


        $template['page'] = "sd/edit_master/master_venues";
        $template['page_title'] = "Master Venues";
        $this->load->view('template',$template);
    } 

    public function delete_master_venues()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','venues',array('id'=>$id));
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

// skills

    public function skills()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array(
                        "user_id"=>$this->input->post("user_id"),
                        "speciality_id"=>$this->input->post("speciality_id"),
                        "experience"=>$this->input->post("experience"),
                        "status"=>$this->input->post("status"),
                         
                          );
                $this->db->insert('skills',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array(
                  "user_id"=>$this->input->post("user_id"),
                        "speciality_id"=>$this->input->post("speciality_id"),
                        "experience"=>$this->input->post("experience"),
                        "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','skills',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `skills` WHERE `status` <> "2" ORDER BY `id` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');

        $query1 = 'SELECT * FROM `astrologers` WHERE `status` <> "2" ORDER BY `id` ASC';
        $template['astrologers'] = $this->c_m->get_all_result($query1,'select','','');


        $query1 = 'SELECT * FROM `specialities` WHERE `status` <> "2" ORDER BY `id` ASC';
        $template['specialities'] = $this->c_m->get_all_result($query1,'select','','');


        $template['page'] = "sd/edit_master/skills";
        $template['page_title'] = "Skills";
        $this->load->view('template',$template);
    } 

    public function delete_skills()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','skills',array('id'=>$id));
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

// specialities

    public function specialities()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/specialities/"; 
                $target_dir = "uploads/specialities/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);

                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array("image"=>$actual_image_name,
                           // "created_at"=>date('Y-m-d H:i:s'),
                           "name"=>$this->input->post("name"),
                           "description"=>$this->input->post("description"),
                           "type"=>$this->input->post("type"),
                           "status"=>$this->input->post("status"),
                           "show_home"=>$this->input->post("show_home"),
                           "position"=>$this->input->post("position"),
                           "added_by"=>$this->session->userdata('id')
                          );
                    $this->db->insert('specialities',$array);
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
                }

            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                  if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/specialities/"; 
                    $target_dir = "uploads/specialities/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                }
                else{
                      $actual_image_name = $this->input->post("old_image");
                }
                        $array = array("image"=>$actual_image_name,
                                 "name"=>$this->input->post("name"),
                                   "description"=>$this->input->post("description"),
                                   "type"=>$this->input->post("type"),
                                   "status"=>$this->input->post("status"),
                                   "show_home"=>$this->input->post("show_home"),
                                    "status"=>$this->input->post("status"),
                                    "position"=>$this->input->post("position")
                                );
                        $create = $this->c_m->get_all_result($array,'update','specialities',array('id'=>$id));
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
        $query = 'SELECT * FROM `specialities` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');

      

        $template['page'] = "sd/edit_master/specialities";
        $template['page_title'] = "Specialities";
        $this->load->view('template',$template);
    } 

    public function delete_specialities()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','specialities',array('id'=>$id));
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

public function horoscopes()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/horoscope/"; 
                $target_dir = "uploads/horoscope/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);

                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array("image"=>$actual_image_name,
                           // "created_at"=>date('Y-m-d H:i:s'),
                           "name"=>$this->input->post("name"),
                           "description"=>$this->input->post("description"),
                           "start_date"=>$this->input->post("start_date"),
                           "status"=>$this->input->post("status"),
                           "end_date"=>$this->input->post("end_date"),
                            "status"=>$this->input->post("status"),
                            "position"=>$this->input->post("position"),
                           "added_by"=>$this->session->userdata('id')
                          );
                    $this->db->insert('horoscopes',$array);
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
                }

            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                  if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/horoscope/"; 
                    $target_dir = "uploads/horoscope/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                }
                else{
                      $actual_image_name = $this->input->post("old_image");
                }
                        $array = array("image"=>$actual_image_name,
                                 "name"=>$this->input->post("name"),
                                   "description"=>$this->input->post("description"),
                                   "start_date"=>$this->input->post("start_date"),
                                   "status"=>$this->input->post("status"),
                                   "end_date"=>$this->input->post("end_date"),
                                    "status"=>$this->input->post("status"),
                                    "position"=>$this->input->post("position")
                                );
                        $create = $this->c_m->get_all_result($array,'update','horoscopes',array('id'=>$id));
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
        $query = 'SELECT * FROM `horoscopes` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');

      

        $template['page'] = "sd/edit_master/horoscopes";
        $template['page_title'] = "Horoscopes";
        $this->load->view('template',$template);
    } 

    public function delete_horoscopes()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','horoscopes',array('id'=>$id));
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



    public function marital_status()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                           "added_on"=>date('Y-m-d H:i:s'),
                           "status"=>$this->input->post("status"),
                           "added_by"=>$this->session->userdata('id')
                          );
                $this->db->insert('master_marital_status',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','master_marital_status',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_marital_status` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_marital_status";
        $template['page_title'] = "Master Marital Status";
        $this->load->view('template',$template);
    } 

    public function delete_master_marital_status()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','master_marital_status',array('id'=>$id));
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

 public function master_problems()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                           "added_on"=>date('Y-m-d H:i:s'),
                           "status"=>$this->input->post("status"),
                           "added_by"=>$this->session->userdata('id')
                          );
                $this->db->insert('master_problems',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                              "status"=>$this->input->post("status"),);
                $create = $this->c_m->get_all_result($array,'update','master_problems',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_problems` WHERE `status` <> "2" ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_problems";
        $template['page_title'] = "Master Problems";
        $this->load->view('template',$template);
    } 

    public function delete_master_problems()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','master_problems',array('id'=>$id));
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


    public function zodiac()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array("name"=>$this->input->post("name"),
                          );
                $this->db->insert('master_zodiac',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array("name"=>$this->input->post("name"),
                            );
                $create = $this->c_m->get_all_result($array,'update','master_zodiac',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_zodiac`  ORDER BY `name` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/zodiac";
        $template['page_title'] = "Master Zodiac";
        $this->load->view('template',$template);
    } 

    public function delete_zodiac_status()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
      
        $create = $this->db->query("DELETE FROM `master_zodiac` WHERE id = $id");
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
// faq
    public function faq()
    {
        
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $array = array(

                    "type"=>$this->input->post("type"),
                    "quection"=>$this->input->post("quection"),
                    "answer"=>$this->input->post("answer"),
                    "status"=>$this->input->post("status"),
                          );
                $this->db->insert('faq',$array);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array(

                    "type"=>$this->input->post("type"),
                    "quection"=>$this->input->post("quection"),
                    "answer"=>$this->input->post("answer"),
                    "status"=>$this->input->post("status"),

                            );
                $create = $this->c_m->get_all_result($array,'update','faq',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `faq`  ORDER BY `id` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/faq";
        $template['page_title'] = "FAQ";
        $this->load->view('template',$template);
    } 

    public function delete_faq_status()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
      
        $create = $this->db->query("DELETE FROM `faq` WHERE id = $id");
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

    public function master_cancellation()
    {
        if($_POST){
            $data = $_POST;
            if (isset($data['update_category'])) 
            {   
                $id = $data['id'];
                $array = array(
                            "less_than_12_hours"=>$this->input->post("less_than_12_hours"),
                              "between_12_to_24_hours"=>$this->input->post("between_12_to_24_hours"),
                              "before_24_hours"=>$this->input->post("before_24_hours"),);
                $create = $this->c_m->get_all_result($array,'update','master_cancellation',array('id'=>$id));
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $query = 'SELECT * FROM `master_cancellation` ORDER BY `type` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
        $template['page'] = "sd/edit_master/master_cancellation";
        $template['page_title'] = "Master cancellation";
        $this->load->view('template',$template);
    }


}