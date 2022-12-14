<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pooja extends CI_Controller {
    public function __construct() {
    parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('pooja_model','p_m');
        $this->load->library('pagination');
        $this->load->library('upload');

        if(!$this->session->userdata('logged_in')) { 
            redirect(base_url());
        }
    }

    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = 'uploads/puja';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '20000';
        // $config['width']      = '600';
        // $config['height']      = '340';


        $config['overwrite']     = FALSE;

        return $config;
    }
    public function index($rowno=0)
    {
        $config = array();


        // Row per page
        $rowperpage = 10;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }

        $config["base_url"] = base_url() . "pooja/index";
        $config["total_rows"] = $this->p_m->record_count_pooja();
        $template['per_page'] =  $config["per_page"] = $rowperpage;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;

        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open']     = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']     = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']     = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']     = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']     = '<li class="page-item">';
        $config['next_tagl_close']     = '<span aria-hidden="true">&raquo;</span></li>';
        $config['prev_tag_open']     = '<li class="page-item">';
        $config['prev_tagl_close']     = '</li>';
        $config['first_tag_open']     = '<li class="page-item">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']     = '<li class="page-item">';
        $config['last_tagl_close']     = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template["results"] = $this->p_m->
        fetch_poojas($rowperpage, $rowno);


        $template['page_no'] = $page == 0 ? 1 : $page;
        $template["links"] = $this->pagination->create_links();
        $template['page_title'] = 'All Pooja\'s';
        $template['page'] = "pooja/view_poojas";
        $this->load->view('template',$template);
    }

    public function puja_location_link($pooja_id=0)
    {
        if($_POST){
           
            if(isset($_POST['save_category'])){
                $d['location_id']=$_POST['location_id'];
                $d['puja_id']=$pooja_id;

                if($this->p_m->is_already_link_this_location($pooja_id, $d['location_id'])){
					
                    $this->session->set_flashdata('message', array('message' => 'This location is already linked to this puja','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
				$d['venue_id']= implode("|",$_POST['venue']);
                $this->db->insert('puja_location_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($_POST['update_category'])) {
                $d['location_id']=$_POST['location_id'];
                $id = $_POST['category_id'];

                if($this->p_m->is_already_link_this_location($pooja_id, $d['location_id'],$id)){
                    $this->session->set_flashdata('message', array('message' => 'This location is already linked to this puja','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                $d['prices'] = 0;//trim($_POST['prices']);
                $d['puja_id']=$pooja_id;

                $d['discount_prices'] = 0;//trim($_POST['discount_prices']);
                $d['discount_comment'] = '';//trim($_POST['discount_comment']);
                $d['discount_comment_hindi'] = '';//trim($_POST['discount_comment_hindi']);
                $d['discount_comment_gujrati'] = '';//trim($_POST['discount_comment_gujrati']);
                $d['description'] = trim($_POST['description']);
                $d['desc_in_hindi'] = trim($_POST['desc_in_hindi']);
                $d['desc_in_gujrati'] = trim($_POST['desc_in_gujrati']);
                $d['booking_time'] = trim($_POST['booking_time']);
                $d['reshudule_time'] = trim($_POST['reshudule_time']);
                $d['status'] = $_POST['status'];
                $this->db->where('id',$id);
                $this->db->update('puja_location_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
        $template['pooja'] = $pooja;
        $template['results'] = $this->p_m->get_all_pooja_locations_link($pooja_id);
        $template['page_title'] = 'Puja Defined Locations : ['.$pooja->name.']';
        $template['locations'] = $this->p_m->get_pooja_locations();
        $template['page'] = "pooja/puja_location_link";
        $this->load->view('template',$template);
    }
    public function delete_pooja_location_link($pooja_id)
    {
        if(empty($pooja_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$pooja_id);
        $this->db->update('puja_location_table',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }

    public function puja_venue_link($location_id=0)
    {
        if($_POST){
            if(isset($_POST['save_category'])){
                $d['venue_name']=trim($_POST['venue_name']);
                $d['name_in_hindi']=trim($_POST['name_in_hindi']);
                $d['name_in_gujrati']=trim($_POST['name_in_gujrati']);
                $d['location_id']=trim($_POST['location_id']);
                $d['prices'] = 0;//trim($_POST['prices']);
                $d['discount_prices'] = 0;//trim($_POST['discount_prices']);
                $d['status'] = $_POST['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('puja_venue_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($_POST['update_category'])) {
                $d['location_id']=trim($_POST['location_id']);
                $id = $_POST['category_id'];
                $d['venue_name']=trim($_POST['venue_name']);
                $d['name_in_hindi']=trim($_POST['name_in_hindi']);
                $d['name_in_gujrati']=trim($_POST['name_in_gujrati']);
                $d['prices'] = 0;//trim($_POST['prices']);
                $d['location_id']= trim($_POST['location_id']);
                $d['discount_prices'] = 0;//trim($_POST['discount_prices']);
                $d['status'] = $_POST['status'];
                $this->db->where('id',$id);
                $this->db->update('puja_venue_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $pooja_location_data = $this->p_m->get_pooja_location_link_data($location_id);

        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_location_data->puja_id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
        $template['pooja'] = $pooja;
        $template['location_id'] = $location_id;
        $template['breadcrumb'] = 'pooja/puja_location_link/'.$pooja_location_data->puja_id;
        $template['results'] = $this->p_m->get_all_pooja_venues_link($location_id);
        $template['page_title'] = 'Puja : ['.$pooja->name.'] | Location : ['.$pooja_location_data->location_name.']';
        $template['page'] = "pooja/puja_venue_link";
        $this->load->view('template',$template);
    }
    public function delete_pooja_venue_link($location_id)
    {
        if(empty($location_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$location_id);
        $this->db->update('puja_venue_table',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }
    public function add_pooja()
    {
        if($_POST){
			//echo "<pre>";
			//print_r($_POST);die;
            $d['name']=$_POST['name'];
            $d['name_in_hindi']=$_POST['name_in_hindi'];
            $d['name_in_gujrati']=$_POST['name_in_gujrati'];
            $d['pooja_type']=$_POST['pooja_type'];
            $d['category_id']=$_POST['category_id'];
            $d['price'] = $_POST['price'];
            $d['discount_type'] = $_POST['discount_type'];
            $d['discount_price'] = $_POST['discount_price'];
            //$d['discount_comment'] = $_POST['discount_comment'];
           // $d['discount_comment_hindi']=$_POST['discount_comment_hindi'];
           // $d['discount_comment_gujrati']=$_POST['discount_comment_gujrati'];
            $d['description']=$_POST['description'];
            $d['desc_in_hindi']=$_POST['desc_in_hindi'];
            $d['desc_in_gujrati'] = $_POST['desc_in_gujrati'];
            $d['status'] = $_POST['status'];
            $d['position'] = $_POST['position'];
            $d['booking_cut_of_hour'] = $_POST['booking_cut_of_hour'];
            $d['reschedule_cut_of_hour'] = $_POST['reschedule_cut_of_hour'];
            //$d['city_id'] = $_POST['multiple_location'];
            $d['can_book_puja'] = $_POST['can_book_puja'];
            if (!empty($this->input->post("gods"))) 
            {
               $d['gods'] = implode('|', $this->input->post("gods"));
            }
            else
            {
                $d['gods'] = '';
            }

            if (!empty($this->input->post("temples"))) 
            {
               $d['temples'] = implode('|', $this->input->post("temples"));
            }
            else
            {
                $d['temples'] = '';
            }
            

            if ($_FILES['image']['size'] > 0) {

                $target_path = "uploads/puja/";
                $target_dir = "uploads/puja/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time() . "." . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                chmod($target_path . $actual_image_name, 0777); 
                if (!empty($actual_image_name) && !empty($extension)) {
                    $d['image'] = $actual_image_name;
                }
            }
            $d['added_on'] = date('Y-m-d H:i:s');
             $d['venue_ids'] = implode('|',$_POST['venue']);
			
            $this->db->insert('puja',$d);
			$last_id = $this->db->insert_id();
			$commission_role = $_POST['commission_role'];
			$commission_type = $_POST['commission_type'];
			$commission_rate = $_POST['commission_rate'];
			for($i=0;$i<count($commission_role);$i++) {
				$d1['puja_id'] = $last_id;
				$d1['role'] = $commission_role[$i];
				$d1['type'] = $commission_type[$i];
				$d1['rate'] = $commission_rate[$i];
				$d1['added_on'] = date('Y-m-d H:i:s');
				$d1['status'] = 1;
				$this->db->insert('puja_commission_table',$d1);
			}
			
			
            $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
            redirect(base_url().'pooja');
            
        }
        $template['page_title'] = 'Add Pooja';
        $template['pooja_category'] = $this->p_m->get_pooja_categories();
        $template['pooja_locations'] = $this->p_m->get_pooja_locations();
        $template['master_god'] = $this->db->get_where("master_god",array("status"=>1))->result();
        $template['master_temple'] = $this->db->get_where("master_temple",array("status"=>1))->result();
        $template['page'] = "pooja/add_pooja";
        $this->load->view('template',$template);
    }
	public function get_venue(){
		$id = $_POST['id'];
		$result = $this->db->query("select * from venues where city_id = ".$id)->result();
		echo json_encode($result);
	}


    public function edit_pooja($pooja_id)
    {  

        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_id])->row();
        
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
		//echo "<pre>";
		//print_r($pooja);die;
        if($_POST){
            $d['name']=$_POST['name'];
            $d['name_in_hindi']=$_POST['name_in_hindi'];
            $d['name_in_gujrati']=$_POST['name_in_gujrati'];
            $d['pooja_type']=$_POST['pooja_type'];
            $d['category_id']=$_POST['category_id'];
            $d['price'] = $_POST['price'];
            $d['discount_type'] = $_POST['discount_type'];
            $d['discount_price'] = $_POST['discount_price'];
            //$d['discount_comment'] = $_POST['discount_comment'];
           // $d['discount_comment_hindi']=$_POST['discount_comment_hindi'];
           // $d['discount_comment_gujrati']=$_POST['discount_comment_gujrati'];
            $d['description']=$_POST['description'];
            $d['desc_in_hindi']=$_POST['desc_in_hindi'];
            $d['desc_in_gujrati'] = $_POST['desc_in_gujrati'];
            $d['status'] = $_POST['status'];
            $d['position'] = $_POST['position'];
            $d['booking_cut_of_hour'] = $_POST['booking_cut_of_hour'];
            $d['reschedule_cut_of_hour'] = $_POST['reschedule_cut_of_hour'];
            //$d['city_id'] = $_POST['multiple_location'];
            $d['can_book_puja'] = $_POST['can_book_puja'];
            if (!empty($this->input->post("gods"))) 
            {
               $d['gods'] = implode('|', $this->input->post("gods"));
            }
            else
            {
                $d['gods'] = '';
            }

            if (!empty($this->input->post("temples"))) 
            {
               $d['temples'] = implode('|', $this->input->post("temples"));
            }
            else
            {
                $d['temples'] = '';
            }
            if ($_FILES['image']['size'] > 0) {

                $target_path = "uploads/puja/";
                $target_dir = "uploads/puja/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time() . "." . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                chmod($target_path . $actual_image_name, 0777); 
                if (!empty($actual_image_name) && !empty($extension)) {
                    $d['image'] = $actual_image_name;
                }
            } else {
				$d['image'] = $_POST['old_image'];
				
			}
           
           
            $this->db->where('id',$pooja_id);
            $this->db->update('puja',$d);
			
			$this->db->where("puja_id",$pooja_id);
			$this->db->delete("puja_commission_table");
			$commission_role = $_POST['commission_role'];
			$commission_type = $_POST['commission_type'];
			$commission_rate = $_POST['commission_rate'];
			//echo "<pre>";
			//print_r($commission_role);die;
			
			for($i=0;$i<count($commission_role);$i++) {
				$com = $commission_role[$i]; 
				if(!empty($com)) {
				$d1['puja_id'] = $pooja_id;
				$d1['role'] = $commission_role[$i];
				$d1['type'] = $commission_type[$i];
				$d1['rate'] = $commission_rate[$i];
				$d1['added_on'] = date('Y-m-d H:i:s');
				$d1['status'] = 1;
				$this->db->insert('puja_commission_table',$d1);
				}
			}
			
            $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
            redirect(base_url().'pooja');
        }
        // print_r($pooja);
        // die;
        $template['pooja'] = $pooja;
		$template['puja_commission']=$this->db->get_where('puja_commission_table',['puja_id'=>$pooja_id])->result();  
        $template['page_title'] = 'Edit Pooja';
        $template['pooja_category'] = $this->p_m->get_pooja_categories();
         $template['pooja_locations'] = $pooja_locations = $this->p_m->get_pooja_locations();
         $template['pooja_venue'] = $this->db->query("select * from venues where city_id = ".$pooja->city_id)->result();
        $template['master_god'] = $this->db->get_where("master_god",array("status"=>1))->result();
        $template['master_temple'] = $this->db->get_where("master_temple",array("status"=>1))->result();
        $template['page'] = "pooja/edit_pooja";
        $this->load->view('template',$template);

    }
 public function clone_pooja($pooja_id)
    {  
  $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_id])->row();
        
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
       
        if($_POST){
            $d['name']=$_POST['name'];
            $d['name_in_hindi']=$_POST['name_in_hindi'];
            $d['name_in_gujrati']=$_POST['name_in_gujrati'];
            $d['pooja_type']=$_POST['pooja_type'];
            $d['category_id']=$_POST['category_id'];
            $d['price'] = $_POST['price'];
            $d['discount_type'] = $_POST['discount_type'];
            $d['discount_price'] = $_POST['discount_price'];
            //$d['discount_comment'] = $_POST['discount_comment'];
           // $d['discount_comment_hindi']=$_POST['discount_comment_hindi'];
           // $d['discount_comment_gujrati']=$_POST['discount_comment_gujrati'];
            $d['description']=$_POST['description'];
            $d['desc_in_hindi']=$_POST['desc_in_hindi'];
            $d['desc_in_gujrati'] = $_POST['desc_in_gujrati'];
            $d['status'] = $_POST['status'];
            $d['position'] = $_POST['position'];
            $d['booking_cut_of_hour'] = $_POST['booking_cut_of_hour'];
            $d['reschedule_cut_of_hour'] = $_POST['reschedule_cut_of_hour'];
            //$d['city_id'] = $_POST['multiple_location'];
            $d['can_book_puja'] = $_POST['can_book_puja'];
            if (!empty($this->input->post("gods"))) 
            {
               $d['gods'] = implode('|', $this->input->post("gods"));
            }
            else
            {
                $d['gods'] = '';
            }

            if (!empty($this->input->post("temples"))) 
            {
               $d['temples'] = implode('|', $this->input->post("temples"));
            }
            else
            {
                $d['temples'] = '';
            }
            if ($_FILES['image']['size'] > 0) {

                $target_path = "uploads/puja/";
                $target_dir = "uploads/puja/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time() . "." . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                chmod($target_path . $actual_image_name, 0777); 
                if (!empty($actual_image_name) && !empty($extension)) {
                    $d['image'] = $actual_image_name;
                }
            } else {
                $d['image'] = $_POST['old_image'];
                
            }
           
           

            $d['added_on'] = date('Y-m-d H:i:s');
             $d['venue_ids'] = implode('|',$_POST['venue']);
            
            $this->db->insert('puja',$d);
            $last_id = $this->db->insert_id();
            $commission_role = $_POST['commission_role'];
            $commission_type = $_POST['commission_type'];
            $commission_rate = $_POST['commission_rate'];
            for($i=0;$i<count($commission_role);$i++) {
                $d1['puja_id'] = $last_id;
                $d1['role'] = $commission_role[$i];
                $d1['type'] = $commission_type[$i];
                $d1['rate'] = $commission_rate[$i];
                $d1['added_on'] = date('Y-m-d H:i:s');
                $d1['status'] = 1;
                $this->db->insert('puja_commission_table',$d1);
            }


            // $this->db->where('id',$pooja_id);
            // $this->db->update('puja',$d);
            
            // $this->db->where("puja_id",$pooja_id);
            // $this->db->delete("puja_commission_table");
            // $commission_role = $_POST['commission_role'];
            // $commission_type = $_POST['commission_type'];
            // $commission_rate = $_POST['commission_rate'];
            // //echo "<pre>";
            // //print_r($commission_role);die;
            
            // for($i=0;$i<count($commission_role);$i++) {
            //     $com = $commission_role[$i]; 
            //     if(!empty($com)) {
            //     $d1['puja_id'] = $pooja_id;
            //     $d1['role'] = $commission_role[$i];
            //     $d1['type'] = $commission_type[$i];
            //     $d1['rate'] = $commission_rate[$i];
            //     $d1['added_on'] = date('Y-m-d H:i:s');
            //     $d1['status'] = 1;
            //     $this->db->insert('puja_commission_table',$d1);
            //     }
            // }
            
            $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
            redirect(base_url().'pooja');
        }
        // print_r($pooja);
        // die;
        $template['pooja'] = $pooja;
        $template['puja_commission']=$this->db->get_where('puja_commission_table',['puja_id'=>$pooja_id])->result();  
        $template['page_title'] = 'Edit Pooja';
        $template['pooja_category'] = $this->p_m->get_pooja_categories();
         $template['pooja_locations'] = $pooja_locations = $this->p_m->get_pooja_locations();
         $template['pooja_venue'] = $this->db->query("select * from venues where city_id = ".$pooja->city_id)->result();
        $template['master_god'] = $this->db->get_where("master_god",array("status"=>1))->result();
        $template['master_temple'] = $this->db->get_where("master_temple",array("status"=>1))->result();
        $template['page'] = "pooja/edit_pooja";
        $this->load->view('template',$template);

    }


       public function puja_status()
    {
        $id = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        if ($status == 1) 
        {
            $a = 'enabled';
            $class = 'success';
        }
        elseif ($status == 0) 
        {
            $a = 'disabled';
            $class = 'success';
        }
        elseif ($status == 2) 
        {
            $a = 'deleted';
            $class = 'success';
        }
        $s = $this->db->query("UPDATE `puja` SET `status`='$status' WHERE `id`='$id'");
        // echo $this->db->last_query(); die;
        $this->session->set_flashdata('message', array(
            'message' => 'Puja Successfully '.$a,
            'class' => $class
        ));
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function puja_gallery($pooja_id)
    {

        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        if($_POST){
            if ($_FILES['image']['size'] > 0) {

                $target_path = "uploads/puja/";
                $target_dir = "uploads/puja/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time() . "." . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                chmod($target_path . $actual_image_name, 0777); 
                if (!empty($actual_image_name) && !empty($extension)) {
                    $explode = array_filter(explode('|',$pooja->images));
                    $explode[] = $actual_image_name;
                    $d['images'] = implode('|',$explode);
                    $this->db->where('id',$pooja_id);
                    $this->db->update('puja',$d);
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
                }
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['pooja'] = $pooja;
        $explode = array_filter(explode('|',$pooja->images));
        $template['results'] = $explode;

        $template['page_title'] = 'Puja Gallery : ['.$pooja->name.']';
        $template['pooja_category'] = $this->p_m->get_pooja_categories();
        $template['pooja_locations'] = $this->p_m->get_pooja_locations();
        $template['page'] = "pooja/puja_gallery";
        $this->load->view('template',$template);

    }

    public function delete_puja_image($id,$name)
    {
        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }

        $explode = array_filter(explode('|',$pooja->images));
        $key = array_search($name, $explode);
        unset($explode[$key]);
        $d['images'] = implode('|',$explode);
        $this->db->where('id',$id);
        $this->db->update('puja',$d);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }

    
    public function time_slots_manage($pooja_id)
    {

        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
        if($_POST){
            // foreach ($_POST as $key => $value) 
            // {
            // print_r($value); die;
            // }

           

            $results = $_POST['break'];
            $new_arr = [];
            foreach ($results as $key=>$v) {
                $start_time = $v['start'];
                $end_time = $v['end'];
                $stock = $v['stock'];
                $obj = [];
                $length = count($start_time);
                for ($i=0; $i < $length; $i++) {
                    $obj[] = [
                        'start'=>$start_time[$i],
                        'end'=>$end_time[$i],
                        'stock'=>$stock[$i]
                    ];
                }


                $new_arr[$key] = $obj;
            }

          
            // $d['booking_time'] = '{"mon":' . json_encode($_POST['monday']) . ',' . '"tue":' . json_encode($_POST['tuesday']) . ',' . '"wed":' . json_encode($_POST['wednesday']) . ',' . '"thu":' . json_encode($_POST['thursday']) . ',' . '"fri":' . json_encode($_POST['friday']) . ',' . '"sat":' . json_encode($_POST['saturday']) . ',' . '"sun":' . json_encode($_POST['sunday']) . '}';
            $d['booking_time']  = json_encode($new_arr);
            $this->db->where('id',$pooja_id);
            $this->db->update('pooja',$d);
            $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
            redirect($this->agent->referrer());
        }
        $template['pooja'] = $pooja;
        $template['pooja_category'] = $this->p_m->get_pooja_categories();
        $template['pooja_locations'] = $this->p_m->get_pooja_locations();
        $template['page_title'] = 'Edit Time Slots | '.'Puja : '.strtoupper($pooja->name);
        $template['days'] = array('mon','tue','wed','thu','fri','sat','sun');

        $template['page'] = "pooja/time_manage";
        $this->load->view('template',$template);

    }


    public function time_slots_manage_by_location($pooja_location_id)
    {

        $this->db->where_in('status',[0,1]);
        $pooja_location=$this->db->get_where('puja_location_table',['id'=>$pooja_location_id])->row();
        if(empty($pooja_location)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        if($_POST){
		//	echo "<pre>";
			//print_r($_POST);die;
            $results = $_POST['break'];
            $new_arr = [];
            foreach ($results as $key=>$v) {
                $start_time = $v['start'];
                $end_time = $v['end'];
                $obj = [];
                $length = count($start_time);
                for ($i=0; $i < $length; $i++) {
                    if ($start_time[$i] != '') 
                    {
                        $start=date("h:ia", strtotime($start_time[$i]));
                    }
                    else
                    {
                        $start='';
                    }
                    if ($end_time[$i] != '') 
                    {
                        $end=date("h:ia", strtotime($end_time[$i]));
                    }
                    else
                    {
                        $end='';
                    }
                    $obj[] = [
                       
                        "start"=>$start,
                        "end"=>$end
                        
                    ];
                }


                $new_arr[$key] = $obj;
            }

            $results_stocks = $_POST['stocks'];
            $new_arr_stock = [];
            $ix = 0;
            foreach ($results_stocks as $keys=>$vs) {
                if ($ix == 0) 
                {
                    $new_arr_stock['mon'] = $vs;
                }
                elseif ($ix == 1) 
                {
                    $new_arr_stock['tue'] = $vs;
                }
                elseif ($ix == 2) 
                {
                    $new_arr_stock['wed'] = $vs;
                }
                elseif ($ix == 3) 
                {
                    $new_arr_stock['thu'] = $vs;
                }
                elseif ($ix == 4) 
                {
                    $new_arr_stock['fri'] = $vs;
                }
                elseif ($ix == 5) 
                {
                    $new_arr_stock['sat'] = $vs;
                }
                elseif ($ix == 6) 
                {
                    $new_arr_stock['sun'] = $vs;
                }
                $ix++;
            }
			$anytime = $_POST['anytime'];
			$all_days = array('mon','tue','wed','thu','fri','sat','sun');
			$anytime_array = array();
			
			
			for($ii=0;$ii<count($all_days);$ii++) {
				$anytime_array[$all_days[$ii]] = 0;
				foreach($anytime as $key=>$val) {
				 if($key == $all_days[$ii]) {
					 $anytime_array[$all_days[$ii]] = 1;
				 } 
				}
			}
			//echo "<pre>";
			//print_r($anytime_array);die;
			
			
            $d['day_wise_time']  = json_encode($new_arr);
            $d['day_wise_stock']  = json_encode($new_arr_stock);
            $d['any_time']  = json_encode($anytime_array);
            $this->db->where('id',$pooja_location_id);
            $this->db->update('puja_location_table',$d);
            $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
            redirect($this->agent->referrer());
        }
        $template['pooja_location_id'] = $pooja_location_id;

        $pooja=$this->db->get_where('puja',['id'=>$pooja_location->puja_id])->row();
        $template['pooja'] = $pooja;
        $template['pooja_location'] = $pooja_location;


        $location=$this->db->get_where('puja_location',['id'=>$pooja_location->location_id])->row();

        $template['page_title'] = 'Time Manage | '.'Puja : '.strtoupper($pooja->name).' | Location : '.strtoupper($location->name);
        $template['days'] = array('mon','tue','wed','thu','fri','sat','sun');

        $template['breadcrumb'] = 'pooja/puja_location_link/'.$pooja->id;

        $template['page'] = "pooja/time_manage_by_location";
        $this->load->view('template',$template);

    }

    public function save_time_manage($pooja_location_id=0)
    {
        $data = json_decode($_POST['time'],true);
        // $pooja_location_id = $_POST['pooja_location_id'];
        $length = count($data);
        $days =  array('mon','tue','wed','thu','fri','sat','sun');
        $new_arr = [];
        for ($i=0; $i < $length ; $i++) { 
            // $new_arr[$days[$i]] = 

            $length_2 = count($data[$i]['periods']);
            for ($j=0; $j < $length_2; $j++) { 
                $new_arr[$days[$i]][] = [
                    'start' => date('g:ia',strtotime(date('Y-m-d').' '.$data[$i]['periods'][$j]['start'])),
                    'end' => date('g:ia',strtotime(date('Y-m-d').' '.$data[$i]['periods'][$j]['end'])),
                    'stock'=>0
                ];
            }
        }
        if(!empty($new_arr)){
        $d['day_wise_time']  = json_encode($new_arr);
        $this->db->where('id',$pooja_location_id);
        $this->db->update('puja_location_table',$d);
        $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
        // redirect($this->agent->referrer());
        }
        echo json_encode(['status'=>true]);
        // print_r($new_arr);

    }

    public function datewisetime_list($pooja_id=0)
    {
        $pooja_location=$this->db->get_where('puja_location_table',['id'=>$pooja_id])->row();
        $pooja=$this->db->get_where('puja',['id'=>@$pooja_id])->row();

        $template['page_title'] = '['.@$pooja->name.'] Date Wise Lists';
        $template['puja_id'] = $pooja_id;

        $results = $this->db->get_where('puja_time_slots',['puja_id'=>$pooja_id,'status !='=>2])->result();
        // print_r($results);
        // die;
        $template['pooja_id'] = $pooja_id;

        $template['results'] = $results;
        $template['page'] = "pooja/datewisetime_list";
        $this->load->view('template',$template);
    }

    public function delete_datewisetime($id)
    {
       $this->db->where('id',$id);
       $this->db->delete('puja_time_slots');
       $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }
    public function datewisetime($pooja_id=0)
    {
        if($_POST){
            $data = $_POST;
            $d['date'] = trim($data['date']);
            $d['puja_id'] = trim($pooja_id);
            $d['stock'] = trim($data['stock']);
            $count = count($data['start']);
            $new_arr = [];
            for ($i=0; $i < $count; $i++) { 
                if(!empty($data['start'][$i])){

                    $new_arr[] = [
                        'start'=>date("h:ia", strtotime($data['start'][$i])),
                        'end'=>date("h:ia", strtotime($data['end'][$i]))
                    ];
                }
            }
            $d['json'] = json_encode($new_arr);
            $d['status'] = $data['status'];
            $d['added_on'] = date('Y-m-d H:i:s');
            
            $this->db->where('date',$d['date']);
            $this->db->where('puja_id',$pooja_id);
            $r=$this->db->get('puja_time_slots')->row();
            if(!empty($r)){
                $this->session->set_flashdata('message', array('message' => 'Data of this date - '.$d['date'].' already exists in the system.','class' => 'warning'));
                redirect($this->agent->referrer());

            }

            $this->db->insert('puja_time_slots',$d);
            $id = $this->db->insert_id();
            $this->session->set_flashdata('message', array('message' => 'Successfully Saved','class' => 'success'));
            redirect(base_url('pooja/edit_datewisetime/'.$id));
        }
        $pooja_location=$this->db->get_where('puja_location_table',['id'=>$pooja_id])->row();

        $pooja=$this->db->get_where('puja',['id'=>$pooja_id])->row();

        $template['page_title'] = 'Puja : ['.$pooja->name.'] | Add Date Wise Time';
        $template['pooja_id'] = $pooja_id;

        $template['page'] = "pooja/datewisetime";
        $this->load->view('template',$template);
    }
    public function edit_datewisetime($id=0)
    {
        $this->db->where('id',$id);
        $pdata = $this->db->get('puja_time_slots')->row();
        // print_r($pdata);die;
        if($_POST){
            $data = $_POST;
            unset($data['puja_id']);
            $d['date'] = trim($data['date']);
            $d['stock'] = trim($data['stock']);
            $count = count($data['start']);
            $new_arr = [];
            for ($i=0; $i < $count; $i++) { 
                if(!empty($data['start'][$i])){
                    $new_arr[] = [
                        'start'=>date("h:ia", strtotime($data['start'][$i])),
                        'end'=>date("h:ia", strtotime($data['end'][$i]))
                        
                    ];
                }
            }
            $d['json'] = json_encode($new_arr);
            $d['status'] = $data['status'];

            $this->db->where('date',$d['date']);
            $this->db->where('id != ',$id);
            $this->db->where('puja_id',$pdata->puja_id);
            $r=$this->db->get('puja_time_slots')->row();
            if(!empty($r)){
                $this->session->set_flashdata('message', array('message' => 'Data of this date - '.$d['date'].' already exists in the system.','class' => 'warning'));
                redirect($this->agent->referrer());

            }

            $this->db->where('id',$id);
            $this->db->update('puja_time_slots',$d);
            $this->session->set_flashdata('message', array('message' => 'Successfully Saved','class' => 'success'));
            redirect($this->agent->referrer());
        }
       
        $pooja_location=$this->db->get_where('puja_location_table',['id'=>$pdata->puja_id])->row();

        $pooja=$this->db->get_where('puja',['id'=>$pooja_location->puja_id])->row();

        $template['page_title'] = 'Puja : ['.$pooja->name.'] Date : ['.$pdata->date.'] Date Wise Time';
        $template['pooja_id'] = $pdata->puja_id;
        $template['editp'] = $pdata;

        $template['page'] = "pooja/edit_datewisetime";
        $this->load->view('template',$template);
    }
    public function time_slots_manage_by_location_demo($pooja_location_id)
    {

        $this->db->where_in('status',[0,1]);
        $pooja_location=$this->db->get_where('puja_location_table',['id'=>$pooja_location_id])->row();
        if(empty($pooja_location)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        if($_POST){

            $results = $_POST['break'];
            $new_arr = [];
            foreach ($results as $key=>$v) {
                $start_time = $v['start'];
                $end_time = $v['end'];
                $stock = $v['stock'];
                $obj = [];
                $length = count($start_time);
                for ($i=0; $i < $length; $i++) {
                    $obj[] = [
                        'start'=>$start_time[$i],
                        'end'=>$end_time[$i],
                        'stock'=>$stock[$i]
                    ];
                }


                $new_arr[$key] = $obj;
            }

          
            // $d['booking_time'] = '{"mon":' . json_encode($_POST['monday']) . ',' . '"tue":' . json_encode($_POST['tuesday']) . ',' . '"wed":' . json_encode($_POST['wednesday']) . ',' . '"thu":' . json_encode($_POST['thursday']) . ',' . '"fri":' . json_encode($_POST['friday']) . ',' . '"sat":' . json_encode($_POST['saturday']) . ',' . '"sun":' . json_encode($_POST['sunday']) . '}';
            $d['day_wise_time']  = json_encode($new_arr);
            $this->db->where('id',$pooja_location_id);
            $this->db->update('puja_location_table',$d);
            $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
            redirect($this->agent->referrer());
        }
        $pooja=$this->db->get_where('puja',['id'=>$pooja_location->puja_id])->row();
        $template['pooja'] = $pooja;
        $template['pooja_location'] = $pooja_location;
        $location=$this->db->get_where('puja_location',['id'=>$pooja_location->location_id])->row();
        $template['page_title'] = 'Time Manage | '.'Puja : '.strtoupper($pooja->name).' | Location : '.strtoupper($location->name);
        $template['days'] = array('mon','tue','wed','thu','fri','sat','sun');
        $template['breadcrumb'] = 'pooja/puja_location_link/'.$pooja->id;
        $template['pooja_location_id'] = $pooja_location_id;

        $day_wise_data = json_decode($pooja_location->day_wise_time,true);
        $i_n = 0;
        $time_arr = [];
        foreach ($day_wise_data as $key => $value) {
            $count = count($value);
            $periods = [];
            foreach ($value as $tim) {
                $periods[] = [
                    'start'=>date('H:i',strtotime(date('Y-m-d').' '.$tim['start'])),
                    'end'=>date('H:i',strtotime(date('Y-m-d').' '.$tim['end'])),
                    'backgroundColor'=>"rgba(82, 155, 255, 0.5)",
                    'borderColor'=>"rgb(42, 60, 255)",
                    'textColor'=>"rgb(0, 0, 0)",
                    'title'=>''
                ];
            }
            $time_arr[] = [
                'day'=>$i_n,
                'periods'=>$periods
            ];
            $i_n++;
        }
    
        $template['time_arr'] = json_encode($time_arr);
        $template['page'] = "pooja/time_manage_2";
        $this->load->view('template',$template);

    }

    
    public function puja_gallery_by_location($pooja_location_id)
    {

        $this->db->where_in('status',[0,1]);
        $pooja_location=$this->db->get_where('puja_location_table',['id'=>$pooja_location_id])->row();
        if(empty($pooja_location)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        if($_POST){
            if ($_FILES['image']['size'] > 0) {

                $target_path = "uploads/puja/";
                $target_dir = "uploads/puja/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time() . "." . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                chmod($target_path . $actual_image_name, 0777); 
                if (!empty($actual_image_name) && !empty($extension)) {
                    $explode = array_filter(explode('|',$pooja_location->gallery));
                    $explode[] = $actual_image_name;
                    $d['gallery'] = implode('|',$explode);
                    $this->db->where('id',$pooja_location_id);
                    $this->db->update('puja_location_table',$d);
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
                }
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $pooja=$this->db->get_where('puja',['id'=>$pooja_location->puja_id])->row();
        $template['pooja'] = $pooja;
        $template['pooja_location'] = $pooja_location;
        $explode = array_filter(explode('|',$pooja_location->gallery));
        $template['results'] = $explode;
        $location=$this->db->get_where('puja_location',['id'=>$pooja_location->location_id])->row();

        $template['page_title'] = 'Gallery | '.'Puja : '.strtoupper($pooja->name).' | Location : '.strtoupper($location->name);
        $template['days'] = array('mon','tue','wed','thu','fri','sat','sun');
        $template['breadcrumb'] = 'pooja/puja_location_link/'.$pooja->id;
        $template['page'] = "pooja/puja_gallery_by_location";
        $this->load->view('template',$template);

    }
    public function delete_puja_image_of_location($pooja_location_id,$name)
    {
        $this->db->where_in('status',[0,1]);
        $pooja_location=$this->db->get_where('puja_location_table',['id'=>$pooja_location_id])->row();
        if(empty($pooja_location)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }

        $explode = array_filter(explode('|',$pooja_location->gallery));
        $key = array_search($name, $explode);
        unset($explode[$key]);
        $d['gallery'] = implode('|',$explode);
        $this->db->where('id',$pooja_location_id);
        $this->db->update('puja_location_table',$d);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }
    public function any_time_slots_manage_by_location($pooja_id)
    {

        if($_POST)
        {
            $pooja_id = $this->input->post('any_id');
            $d['anytime_stock'] = '{"mon":' . json_encode($_POST['monday']) . ',' . '"tue":' . json_encode($_POST['tuesday']) . ',' . '"wed":' . json_encode($_POST['wednesday']) . ',' . '"thu":' . json_encode($_POST['thursday']) . ',' . '"fri":' . json_encode($_POST['friday']) . ',' . '"sat":' . json_encode($_POST['saturday']) . ',' . '"sun":' . json_encode($_POST['sunday']) . '}';
            $d['anytime_stock']  = $d['anytime_stock'];
            $this->db->where('id',$pooja_id);
            $this->db->update('puja_location_table',$d);
            $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
            redirect($this->agent->referrer());
        }

    }
   public function any_time_slots_manage($pooja_id)
    {

       
        if($_POST)
        {
            $pooja_id = $this->input->post('any_id');

         $d['stock'] = '{"mon":' . json_encode($_POST['monday']) . ',' . '"tue":' . json_encode($_POST['tuesday']) . ',' . '"wed":' . json_encode($_POST['wednesday']) . ',' . '"thu":' . json_encode($_POST['thursday']) . ',' . '"fri":' . json_encode($_POST['friday']) . ',' . '"sat":' . json_encode($_POST['saturday']) . ',' . '"sun":' . json_encode($_POST['sunday']) . '}';
            $d['stock']  = $d['stock'];
            $this->db->where('id',$pooja_id);
            $this->db->update('pooja',$d);
            $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
            redirect(base_url().'pooja');
        }
       
    }

    public function delete_pooja($pooja_id)
    {
        if(empty($pooja_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
        $this->db->where('id',$pooja_id);
        $this->db->delete('puja');
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }


    public function pooja_categories()
    {
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category'])){
                $d['name'] = $data['name'];
                $d['position'] = $data['position'];
                $d['status'] = $data['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('pooja_category',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) {
                $d['name'] = $data['name'];
                $d['position'] = $data['position'];
                $d['status'] = $data['status'];
                $id = $data['category_id'];
                $this->db->where('id',$id);
                $this->db->update('pooja_category',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
           
        }
        $template['page_title'] = 'Puja Categories';
        $template['results'] = $this->p_m->get_all_pooja_categories();
        $template['page'] = "pooja/pooja_category";
        $this->load->view('template',$template);
    }

    public function delete_pooja_category($cat_id)
    {
        if(empty($cat_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$cat_id);
        $this->db->update('pooja_category',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }


    public function pooja_venues()
    {
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category'])){
                $d['name'] = $data['name'];
                $d['puja_id'] = $data['puja_id'];
                $d['status'] = $data['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('pooja_venus_list',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) {
                $d['name'] = $data['name'];
                $d['puja_id'] = $data['puja_id'];
                $d['status'] = $data['status'];
                $id = $data['category_id'];
                $this->db->where('id',$id);
                $this->db->update('pooja_venus_list',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['page_title'] = 'Puja Venues';
        $template['results'] = $this->p_m->get_all_pooja_venues();
        $template['poojas'] = $this->p_m->get_active_poojas();
        $template['page'] = "pooja/pooja_venues";
        $this->load->view('template',$template);
    }

    public function delete_pooja_venue($venue_id)
    {
        if(empty($venue_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$venue_id);
        $this->db->update('pooja_venus_list',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }


    
    public function pooja_yajmans()
    {
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category'])){
                $d['name'] = $data['name'];
                $d['puja_id'] = $data['puja_id'];
                $d['status'] = $data['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('pooja_yajman_list',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) {
                $d['name'] = $data['name'];
                $d['puja_id'] = $data['puja_id'];
                $d['status'] = $data['status'];
                $id = $data['category_id'];
                $this->db->where('id',$id);
                $this->db->update('pooja_yajman_list',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['page_title'] = 'Puja Yajman';
        $template['results'] = $this->p_m->get_all_pooja_yajmans();
        $template['poojas'] = $this->p_m->get_active_poojas();
        $template['page'] = "pooja/pooja_yajmans";
        $this->load->view('template',$template);
    }


    public function delete_pooja_yajman($yajman_id)
    {
        if(empty($yajman_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$yajman_id);
        $this->db->update('pooja_yajman_list',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }


    public function pooja_locations()
    {
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category'])){
                $d['name'] = $data['name'];
                $d['hindi'] = $data['hindi'];
                $d['gujrati'] = $data['gujrati'];
                $d['status'] = $data['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('puja_location',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) {
                $d['name'] = $data['name'];
                $d['hindi'] = $data['hindi'];
                $d['gujrati'] = $data['gujrati'];
                $d['status'] = $data['status'];
                $id = $data['category_id'];
                $this->db->where('id',$id);
                $this->db->update('puja_location',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['page_title'] = 'Puja Locations';
        $template['results'] = $this->p_m->get_all_pooja_locations();
        $template['page'] = "pooja/pooja_locations";
        $this->load->view('template',$template);
    }

    public function delete_pooja_location($yajman_id)
    {
        if(empty($yajman_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$yajman_id);
        $this->db->update('puja_location',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }


    public function puja_location_priest($location_id=0)
    {
        if($_POST){
            if(isset($_POST['save_category'])){
                $d['puja_location_id']=trim($_POST['puja_location_id']);
                $d['priest_id']=trim($_POST['priest_id']);
                $d['added_by'] = 1;
                $d['status'] = $_POST['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('puja_location_priest_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($_POST['update_category'])) {
                $id = $_POST['category_id'];
                $d['status'] = $_POST['status'];
                $this->db->where('id',$id);
                $this->db->update('puja_location_priest_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $pooja_location_data = $this->p_m->get_pooja_location_link_data($location_id);
        $location_ = $this->p_m->get_pooja_location_link_data($location_id);
        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_location_data->puja_id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
        $template['pooja'] = $pooja;
        $template['location_id'] = $location_id;
        $template['breadcrumb'] = 'pooja/puja_location_link/'.$pooja_location_data->puja_id;
        $template['results'] = $this->db->get_where("puja_location_priest_table",array("puja_location_id"=>$location_id,"status<>"=>2))->result();
        $template['priest_list'] = $this->db->get_where("priest",array("status"=>1,"location"=>$pooja_location_data->location_id))->result();
        $template['already_priest'] = array();
        if (count($template['results']) > 0) 
        {
            foreach ($template['results'] as $key) 
            {
                array_push($template['already_priest'], $key->priest_id);
            }
        }
        $template['page_title'] = "Puja's Priest : ['.$pooja->name.'] | Location : ['.$pooja_location_data->location_name.']";
        $template['page'] = "pooja/puja_priest_link";
        $this->load->view('template',$template);
    }
    public function delete_puja_location_priest($location_id)
    {
        if(empty($location_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$location_id);
        $this->db->update('puja_location_priest_table',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }

    public function puja_commission($location_id=0)
    {
        if($_POST){
            if(isset($_POST['save_category'])){
                $d['puja_id']=trim($_POST['puja_location_id']);
                $d['role']=trim($_POST['role']);
                $d['type']=trim($_POST['type']);
                $d['value']=trim($_POST['value']);
                $d['added_by'] = 1;
                $d['status'] = $_POST['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('puja_commission_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($_POST['update_category'])) {
                $id = $_POST['category_id'];
                $d['role']=trim($_POST['role']);
                $d['type']=trim($_POST['type']);
                $d['value']=trim($_POST['value']);
                $d['status'] = $_POST['status'];
                $this->db->where('id',$id);
                $this->db->update('puja_commission_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        
        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$location_id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
        $template['pooja'] = $pooja;
        $template['location_id'] = $location_id;
        $template['breadcrumb'] = 'pooja';
        $template['results'] = $this->db->get_where("puja_commission_table",array("puja_id"=>$location_id,"status<>"=>2))->result();
        $template['page_title'] = 'Puja : ['.$pooja->name.']';
        $template['page'] = "pooja/puja_commission_link";
        $this->load->view('template',$template);
    }
    public function delete_pooja_commission_link($location_id)
    {
        if(empty($location_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$location_id);
        $this->db->update('puja_commission_table',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }

    public function puja_commission_location_wise($location_id=0)
    {
        if($_POST){
            if(isset($_POST['save_category'])){
                $d['puja_location_id']=trim($_POST['puja_location_id']);
                $d['role']=trim($_POST['role']);
                $d['type']=trim($_POST['type']);
                $d['value']=trim($_POST['value']);
                $d['added_by'] = 1;
                $d['status'] = $_POST['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('puja_location_commission_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($_POST['update_category'])) {
                $id = $_POST['category_id'];
                $d['role']=trim($_POST['role']);
                $d['type']=trim($_POST['type']);
                $d['value']=trim($_POST['value']);
                $d['status'] = $_POST['status'];
                $this->db->where('id',$id);
                $this->db->update('puja_location_commission_table',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $pooja_location_data = $this->p_m->get_pooja_location_link_data($location_id);

        $this->db->where_in('status',[0,1]);
        $pooja=$this->db->get_where('puja',['id'=>$pooja_location_data->puja_id])->row();
        if(empty($pooja)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect(base_url().'pooja');
        }
        $template['pooja'] = $pooja;
        $template['location_id'] = $location_id;
        $template['breadcrumb'] = 'pooja/puja_location_link/'.$pooja_location_data->puja_id;
        $template['results'] = $this->db->get_where("puja_location_commission_table",array("puja_location_id"=>$location_id,"status<>"=>2))->result();
        $template['page_title'] = 'Puja : ['.$pooja->name.'] | Location : ['.$pooja_location_data->location_name.']';
        $template['page'] = "pooja/puja_commission_link";
        $this->load->view('template',$template);
    }
    public function delete_pooja_commission_link_location_wise($location_id)
    {
        if(empty($location_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$location_id);
        $this->db->update('puja_location_commission_table',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }





}