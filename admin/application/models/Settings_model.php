<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
   }
	  function get_currencies(){
		  $query = $this->db->get('countries');
		  return $result = $query->result();
	  }
	 function settings_viewing(){
		  $query = $this->db->query(" SELECT * FROM `settings` order by id DESC ")->row();
		  return $query ;
	 } 

	 function master_tax_viewing(){
		  $query = $this->db->query(" SELECT * FROM `master_tax` order by id DESC ")->row();
		  return $query ;
	 }
	 public function update_settings($data){
		   $result = $this->db->update('settings', $data); 
		   return $result;
	 }

	 	 public function update_table_data($id,$table,$data)
 	{	
 		$query =  $this->db->where('id', $id);
         $result = $query->update($table, $data);
         return $result;
		
 	}

 	
	 // public function get_languages(){
		//  $query = $this->db->get("language_set");
		//  return $query->result();
	 // }

	 public function update_price($data){
		   $result = $this->db->update('master_price', $data); 
		   return $result;
	 }

	 function price_viewing(){
		  $query = $this->db->query(" SELECT * FROM `master_price` order by id DESC ")->row();
		  return $query ;
	 }
  
}
?>