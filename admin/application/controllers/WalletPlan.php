<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class WalletPlan extends CI_Controller {
	public function __construct() {
	parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		if(!$this->session->userdata('logged_in')) { 
			redirect(base_url());
		}
    }
    public function getdata(){

        if($_POST && isset($_POST['add_plan'])){
            $recharge = floatval($_POST['recharge']);
            $benefit = floatval($_POST['benefit']);
            $for_new_user = intval($_POST['for_new_user']);
            $position = floatval($_POST['position']);
            if($recharge <= 0 ){
                $this->session->set_flashdata('message',array('message' => 'Recharge Amount should not be empty or less than or equal to zero','class' => 'danger'));
                redirect($this->agent->referrer());
            }
            if($benefit==0){
                $benefit=$recharge;
            }

            $check = $this->db->get_where('wallet_plans',['recharge'=>$recharge])->row();
            if($check){
                $this->db->where('id',$check->id);
                $data = $this->db->update('wallet_plans',[
                    'recharge'=>$recharge,
                    'benefit'=>$benefit,
                    'for_new_user'=>$for_new_user,
                    'position'=>$position,
                ]);
                $this->session->set_flashdata('message',array('message' => 'Plan added successfully','class' => 'success'));
            }else{
                $data = $this->db->insert('wallet_plans',[
                    'recharge'=>$recharge,
                    'benefit'=>$benefit,
                    'for_new_user'=>$for_new_user,
                    'position'=>$position,
                    'created_at'=>date('Y-m-d H:i:s')
                ]);
                $this->session->set_flashdata('message',array('message' => 'Plan added successfully','class' => 'success'));
            }

           
            redirect($this->agent->referrer());
        }elseif($_POST && isset($_POST['edit_plan']) && $_POST['id']){
            // print_r($_POST);die;
            $recharge = floatval($_POST['recharge']);
            $benefit = floatval($_POST['benefit']);
            $for_new_user = intval($_POST['for_new_user']);
            $position = floatval($_POST['position']);
            if($recharge <= 0 ){
                $this->session->set_flashdata('message',array('message' => 'Recharge Amount should not be empty or less than or equal to zero','class' => 'danger'));
                redirect($this->agent->referrer());
            }
            if($benefit==0){
                $benefit=$recharge;
            }
            $check = $this->db->get_where('wallet_plans',['recharge'=>$recharge])->row();
            // print_r($_POST);die;
            if($check){
                $this->db->where('id',$check->id);
                $data = $this->db->update('wallet_plans',[
                    'recharge'=>$recharge,
                    'benefit'=>$benefit,
                    'for_new_user'=>$for_new_user,
                    'position'=>$position,
                ]);
                $this->session->set_flashdata('message',array('message' => 'Plan added successfully','class' => 'success'));
            }else{
                $this->db->where('id',trim($_POST['id']));
                $data = $this->db->update('wallet_plans',[
                    'recharge'=>$recharge,
                    'benefit'=>$benefit,
                    'for_new_user'=>$for_new_user,
                    'position'=>$position,
                ]);
                $this->session->set_flashdata('message',array('message' => 'Plan added successfully','class' => 'success'));
               
            }
            // print_r($_POST);die;
            redirect($this->agent->referrer());
          
        }
      
        $template['page'] = "walletplan/plans";
        $template['page_title'] = "Wallet Plans";
        $this->db->order_by('position','asc');
        $data= $this->db->get_where('wallet_plans',['status'=>1])->result();
        $template['plans'] = $data;
        $this->load->view('template',$template);
    }

    public function delete_plan($id)
    {
        $this->db->where('id',$id);
        $this->db->update('wallet_plans',['status'=>2]);
        $this->session->set_flashdata('message',array('message' => 'Plan Removed successfully','class' => 'success'));
        redirect($this->agent->referrer());

    }
  
}