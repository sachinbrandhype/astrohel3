<?php 
class Affiliated_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}
 	function add_affiliatedetails($data){
         if($this->db->insert('affilliated_hospitals', $data)):
			return true;
		endif;	
 	}
 	function get_affiliatedetails(){
         $query = $this->db->get('affilliated_hospitals');
         $result = $query->result();
         return $result;
 	}
 	function affliated_delete($id){
 		 $this->db->where('id', $id);
 		 $result = $this->db->delete('affilliated_hospitals');
 		 if($result) {
 		 	return "Success";
 		 }
 		 else{
 		 	return "Error";
 		 }
 	}	
	function get_single_affiliate($id){
		$this->db->where('id',$id);
		$query = $this->db->get('affilliated_hospitals');
		$result = $query->row();
		return $result;
	}
	function affiliatedetails_edit($data,$id){
		$this->db->where('id', $id);
		$result = $this->db->update('affilliated_hospitals', $data);
		return $result;
	}

	public function get_all_result($query,$query_type,$table,$condition)
	{
		
		if ($query_type == 'select') {
			return $this->db->query($query)->result();	
		}
		elseif ($query_type == 'delete') {
			$this->db->query($query);
			return true;
		}
		elseif ($query_type == 'insert') {
			$query = $this->db->insert($table,$query);
			return $this->db->insert_id();
		}
		elseif ($query_type == 'single_row') {
			return $this->db->query($query)->row();
		}
		elseif ($query_type == 'update') {
			$query2 = $this->db->where($condition);
			$this->db->update($table,$query);
			return true;
		}
		else
		{
			return false;
		}
		
	}

	public function get_all_result_array($query,$query_type,$table,$condition)
    {

    if ($query_type == 'select') {
    return $this->db->query($query)->result_array();  
    }
    elseif ($query_type == 'delete') {
    $this->db->query($query);
    return true;
    }
    elseif ($query_type == 'insert') {
    $query = $this->db->insert($table,$query);
    return $this->db->insert_id();
    }
    elseif ($query_type == 'single_row') {
    return $this->db->query($query)->row_array();
    }
    elseif ($query_type == 'update') {
    $query2 = $this->db->where($condition);
    $this->db->update($table,$query);
    return TRUE;
    }
    else
    {
    return false;
    }

    }
 }