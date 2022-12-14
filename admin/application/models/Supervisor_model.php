<?php 
class Supervisor_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}


     public function get_all_supervisors()
     {
         $this->db->where_in('status',[0,1]);
         $this->db->order_by('id','DESC');
         return $this->db->get('supervisor')->result();
     }

     public function isEmailExist($email,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('supervisor',['email'=>trim($email)])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

     public function isMobileExist($email,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('supervisor',['email'=>trim($email)])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

}