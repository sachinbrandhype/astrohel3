<?php 
class Report_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}
	
	function get_audit_trail_report(){
		$query = $this->db->get('cities');
		$result = $query->result();
		return $result;
	}
	
}