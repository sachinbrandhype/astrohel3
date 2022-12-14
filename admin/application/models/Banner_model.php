<?php 
class Banner_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}
	function get_banner($table){
			$this->db->select('*');     
			$this->db->from($table);
			$this->db->where('type',"main");
			$query = $this->db->get();
			$result = $query->result();
			return $result;	
	}
	function get_banner_coupan($table){
			$this->db->select('*');     
			$this->db->from($table);
			$query = $this->db->get();
			$result = $query->result();
			return $result;	
	}
	function get_banner_mid($table){
			$this->db->select('*');     
			$this->db->from($table);
			$this->db->where('type',"mid");
			$query = $this->db->get();
			$result = $query->result();
			return $result;	
	}
		public function get_single_banner($id){
		$this->db->where('id',$id);
		$query = $this->db->get('banner');
		$result = $query->row();
		return $result;  
	}

	 public function get_row($tbl,$where)
    {
        $row = $this->db->get_where($tbl,$where);
        if(count($row->result()>0))
        {
            return $row->row();
        }
        return false;

    } 
     public function patientbanner_delete($id,$img){ 
     
     	
		 $this->db->where('id',$id);
		 $result = $this->db->delete('banner');
		 if($result) {
		 	 unlink('./uploads/banner/user'.'/'.$img);
			return "success"; 
		 }
		 else {
			 return "error";
		 }
		
	 }

	  public function doctorbanner_delete($id,$img){ 
     
     	
		 $this->db->where('id',$id);
		 $result = $this->db->delete('doctor_banner');
		 if($result) {
		 	 unlink('./uploads/banner/doctor_banner'.'/'.$img);
			return "success"; 
		 }
		 else {
			 return "error";
		 }
		
	 }
	public function get_single_table($table,$array)
	{
		$query = $this->db->get_where($table,$array);
		return $query->row();
	}
	 public function add_bannerdetails($table,$data)
 	{	

		 $data['added_on']=time();
         $result = $this->db->insert($table, $data);
         return $result;
		
 	}
 	public function get_bannerdetails($table)
 	{
 		$this->db->where('type',"main");
		$query = $this->db->get($table);
		$result = $query->result();
		return $result;
 	}
 	public function get_bannerdetails_mid($table)
 	{
 		$this->db->where('type',"mid");
		$query = $this->db->get($table);
		$result = $query->result();
		return $result;
 	}
 	function update_patient_status($table,$data,$data1){
			$this->db->where('id',$data);
			$result = $this->db->update($table,$data1);
			return $result; 
	    }
     
	
}