<?php 
class Priest_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}


     public function get_all_priests()
     {
         $this->db->where_in('status',[0,1]);
         $this->db->order_by('id','DESC');
         return $this->db->get('priest')->result();
     }

     public function isEmailExist($email,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('priest',['email'=>trim($email),"status<>"=>2])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

     public function isMobileExist($mobile,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('priest',['mobile'=>trim($mobile),"status<>"=>2])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

     public function get_all_agents()
     {
         $this->db->where_in('status',[0,1]);
         $this->db->where('user_type',3);
         $this->db->order_by('id','DESC');
         return $this->db->get('admin')->result();
     }

     public function isEmailExist_agent($email,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('admin',['email'=>trim($email)])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

     public function isMobileExist_agent($email,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('admin',['mobile'=>trim($email)])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

     public function get_all_entagents()
     {
         $this->db->where_in('status',[0,1]);
         $this->db->where('user_type',2);
         $this->db->order_by('id','DESC');
         return $this->db->get('admin')->result();
     }

     public function isEmailExist_entagent($email,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('admin',['email'=>trim($email)])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

     public function isMobileExist_entagent($email,$exclude_id=[])
     {
        if(!empty($exclude_id)){
            $this->db->where_not_in('id',$exclude_id);
        }
        $q= $this->db->get_where('admin',['mobile'=>trim($email)])->row();
        if(empty($q)){
            return false;
        }
        return true;
     }

}