<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Priest extends CI_Controller {
	public function __construct() {
	parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('pooja_model','p_m');
        $this->load->model('supervisor_model','s_m');
        $this->load->model('priest_model','pr_m');


        $this->load->library('pagination');
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }

    public function index()
    {
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category'])){

                if($this->pr_m->isEmailExist($data['email'])){
                    $this->session->set_flashdata('message', array('message' => $data['email'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }elseif ($this->pr_m->isMobileExist($data['mobile'])) {
                    $this->session->set_flashdata('message', array('message' => $data['mobile'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                $d['name'] = trim($data['name']);
                $d['email'] = trim(strtolower($data['email']));
                $d['mobile'] = trim($data['mobile']);
                $d['password'] = trim($data['password']);
                $d['location'] = trim($data['location']);
                $d['status'] = $data['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $this->db->insert('priest',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_category'])) {
                $d['name'] = trim($data['name']);
                $d['email'] = trim(strtolower($data['email']));
                $d['mobile'] = trim($data['mobile']);
                $d['password'] = trim($data['password']);
                $d['location'] = trim($data['location']);
                $d['status'] = $data['status'];
                $id = $data['category_id'];
                if($this->pr_m->isEmailExist($data['email'],[$id])){
                    $this->session->set_flashdata('message', array('message' => $data['email'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }elseif ($this->pr_m->isMobileExist($data['mobile'],[$id])) {
                    $this->session->set_flashdata('message', array('message' => $data['mobile'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                $this->db->where('id',$id);
                $this->db->update('priest',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['pooja_locations'] = $this->p_m->get_pooja_locations();
        $template['page_title'] = "Priest's Lists";
        $template['results'] = $this->pr_m->get_all_priests();
        $template['page'] = "priest/lists";
        $this->load->view('template',$template);
    }

    public function delete_priest($priest_id)
    {
        if(empty($priest_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$priest_id);
        $this->db->update('priest',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }

}