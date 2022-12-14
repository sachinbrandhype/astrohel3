<?php 
class App_horoscope_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}
	function get_app_horoscope(){
		$query = $this->db->get('horoscope');
		$result = $query->result();
		return $result;
	}
	function add_app_horoscope($data){
		$result = $this->db->insert('horoscope', $data);
		return $result;
	}
	function app_horoscope_delete($id){
		$this->db->where('id', $id);
		$result = $this->db->delete('horoscope');
		if($result) {
			return "success"; 
		 }
		 else{
			 return "error";
		 }
	}
	function get_single_app_horoscope($id){
		$this->db->where('id', $id);
		$query = $this->db->get('horoscope');
		$result = $query->row();
		return $result;
	}
	function app_horoscopedetails_edit($data, $id){
		$this->db->where('id', $id);
		$result = $this->db->update('horoscope', $data);
		return $result;
	}
}