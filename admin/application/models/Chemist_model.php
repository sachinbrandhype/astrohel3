<?php 
class Chemist_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}
	function get_chemist(){
			$this->db->select('*');     
			$this->db->from('chemist' );
			$query = $this->db->get();
			$result = $query->result();
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
     public function chemist_delete($id,$img){ 
     
     	
		 $this->db->where('id',$id);
		 $result = $this->db->delete('chemist');
		 if($result) {
		 	 unlink('./uploads/chemist'.'/'.$img);
			return "success"; 
		 }
		 else {
			 return "error";
		 }
		
	 }

	 /**Get Single**/
	function get_single_chemist($id){		  
		       $this->db->where('id',$id);
			   $query = $this->db->get('chemist');
			   $result = $query->row();
			   return $result;  
	}
	/**Edit**/
	function chemistdetails_edit($data, $id){	
			   $this->db->where('id', $id);
			   $result = $this->db->update('chemist', $data); 
			   return $result;
		
	 }
	 	public function get_single_table($table,$array)
	{
		$query = $this->db->get_where($table,$array);
		return $query->row();
	}
	 public function add_chemistdetails($data)
 	{	

		 $data['name']=$this->input->post('name');
		 $data['mobile']=$this->input->post('mobile');
		 $data['address']=$this->input->post('address');
		 $data['offer']=$this->input->post('offer');
		 $data['latitude']=$this->input->post('latitude');
		 $data['longitude']=$this->input->post('longitude');
		 $data['added_on']=date("Y-m-d H:i:s");
         $result = $this->db->insert('chemist', $data);
         return $result;
		
 	}
 	 public function insert_table_data($table,$data)
 	{	
         $this->db->insert($table, $data);
         $result=$this->db->insert_id();
       // echo $this->db->last_query();die;
         return $result;
		
 	}

 	 function update_chemist_status($data,$data1){
			$this->db->where('id',$data);
			$result = $this->db->update('chemist',$data1);
			return $result; 
	    }


 	public function get_chemistdetails()
 	{
		$query = $this->db->get('chemist');
		$result = $query->result();
		return $result;
 	}

 	    public function get_single_chemis($id){
		$this->db->where('id',$id);
		$query = $this->db->get('chemist');
		$result = $query->row();
		return $result;  
	}
     
	
}