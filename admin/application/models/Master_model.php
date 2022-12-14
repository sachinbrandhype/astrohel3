<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
   }
	public function update_table_data($id,$table,$data)
 	{	
 		$query =  $this->db->where('id', $id);
         $result = $query->update($table, $data);
         return $result;
		
 	}

	  	 function master_config_contants_viewing(){
		  $query = $this->db->query(" SELECT * FROM `master_config_contants` order by id DESC ")->row();
		  return $query ;
	 }


	  function expert_management_viewing(){
		  $query = $this->db->query(" SELECT * FROM `expert_management` where id = 1 ")->row();
		  return $query ;
	 }




	  function master_minutes_contants_viewing(){
		  $query = $this->db->query(" SELECT * FROM `master_time` order by id DESC ")->row();
		  return $query ;
	 }
	
	
	 public function update($data,$table){
		   $result = $this->db->update($table, $data); 
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


	 
  
}
?>