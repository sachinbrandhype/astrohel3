<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agent extends CI_Controller {
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

                if($this->pr_m->isEmailExist_agent($data['email'])){
                    $this->session->set_flashdata('message', array('message' => $data['email'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }elseif ($this->pr_m->isMobileExist_agent($data['mobile'])) {
                    $this->session->set_flashdata('message', array('message' => $data['mobile'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                $d['username'] = trim($data['username']);
                $d['email'] = trim(strtolower($data['email']));
                $d['mobile'] = trim($data['mobile']);
                $d['password'] = md5($data['password']);
                $d['user_type'] = 3;
                $d['status'] = $data['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $d['added_by'] = 1;
                $this->db->insert('admin',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_agent'])) {
                $d['username'] = trim($data['username']);
                $d['email'] = trim(strtolower($data['email']));
                $d['mobile'] = trim($data['mobile']);
                $d['status'] = $data['status'];
                $id = $data['id'];
                if($this->s_m->isEmailExist($data['email'],[$id])){
                    $this->session->set_flashdata('message', array('message' => $data['email'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }elseif ($this->s_m->isMobileExist($data['mobile'],[$id])) {
                    $this->session->set_flashdata('message', array('message' => $data['mobile'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                $this->db->where('id',$id);
                $this->db->update('admin',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            elseif (isset($data['update_password'])) {
                $d['password'] = md5($data['password']);
                $id = $data['id'];
                $this->db->where('id',$id);
                $this->db->update('admin',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['pooja_locations'] = $this->p_m->get_pooja_locations();
        $template['page_title'] = "Agent's Lists";
        $template['Main'] = "Agent";
        $template['results'] = $this->pr_m->get_all_agents();
        $template['page'] = "agent/lists";
        $this->load->view('template',$template);
    }

    public function delete_agent($priest_id)
    {
        if(empty($priest_id)){
            $this->session->set_flashdata('message', array('message' => 'Something went wrong.','class' => 'danger'));
            redirect($this->agent->referrer());
        }
        $this->db->where('id',$priest_id);
        $this->db->update('admin',['status'=>2]);
        $this->session->set_flashdata('message', array('message' => 'Successfully Deleted','class' => 'success'));
        redirect($this->agent->referrer());
    }

    public function enterprise($value='')
    {
       
        if($_POST){
            $data = $_POST;
            if(isset($data['save_category'])){

                if($this->pr_m->isEmailExist_entagent($data['email'])){
                    $this->session->set_flashdata('message', array('message' => $data['email'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }elseif ($this->pr_m->isMobileExist_entagent($data['mobile'])) {
                    $this->session->set_flashdata('message', array('message' => $data['mobile'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                $d['username'] = trim($data['username']);
                $d['email'] = trim(strtolower($data['email']));
                $d['mobile'] = trim($data['mobile']);
                $d['password'] = md5($data['password']);
                $d['user_type'] = 2;
                $d['status'] = $data['status'];
                $d['added_on'] = date('Y-m-d H:i:s');
                $d['added_by'] = 1;
                $this->db->insert('admin',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                redirect($this->agent->referrer());
            }elseif (isset($data['update_agent'])) {
                $d['username'] = trim($data['username']);
                $d['email'] = trim(strtolower($data['email']));
                $d['mobile'] = trim($data['mobile']);
                $d['status'] = $data['status'];
                $id = $data['id'];
                if($this->s_m->isEmailExist($data['email'],[$id])){
                    $this->session->set_flashdata('message', array('message' => $data['email'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }elseif ($this->s_m->isMobileExist($data['mobile'],[$id])) {
                    $this->session->set_flashdata('message', array('message' => $data['mobile'].' already exists!','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                $this->db->where('id',$id);
                $this->db->update('admin',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }
            elseif (isset($data['update_password'])) {
                $d['password'] = md5($data['password']);
                $id = $data['id'];
                $this->db->where('id',$id);
                $this->db->update('admin',$d);
                $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }
        $template['pooja_locations'] = $this->p_m->get_pooja_locations();
        $template['page_title'] = "EntrpriseAgent's Lists";
        $template['Main'] = "EntrpriseAgent";
        $template['results'] = $this->pr_m->get_all_entagents();
        $template['page'] = "agent/lists";
        $this->load->view('template',$template);
    }

}