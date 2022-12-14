<?php 
class Card_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}
	function get_card($table){
			$this->db->select('*');     
			$this->db->from($table );
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
    public function insert_report($table,$data)
    {
        $this->db->insert($table, $data);
    }

     public function add_carddetails($data)
 	{	

		 $data['card_no']=$this->input->post('card_no');
		 $data['cvv']=$this->input->post('cvv');
		 $data['parfrom']=$this->input->post('parfrom');
		 $data['paid_through']=$this->input->post('paid_through');
		 $data['paid_date']=$this->input->post('paid_date');
		 $data['valid']=$this->input->post('valid');
		 $data['mobile']=$this->input->post("mobile");
		 $data['status']=$this->input->post("status");
         $result = $this->db->insert('card_table', $data);
         return $result;
		
 	}
 	public function get_carddetails($table)
 	{
		$query = $this->db->get($table);
		$result = $query->result();
		return $result;
 	}
     public function card_delete($id){ 
     	
		 $this->db->where('id',$id);
		 $result = $this->db->delete('card_table');
		 if($result) {
			return "success"; 
		 }
		 else {
			 return "error";
		 }
		
	 }
	 function carddetails_edit($data, $id){	
			   $this->db->where('id', $id);
			   $result = $this->db->update('card_table', $data); 
			   return $result;
		
	 }
	 /**Get Single**/
	function get_single_card($id){		  
		       $this->db->where('id',$id);
			   $query = $this->db->get('card_table');
			   $result = $query->row();
			   return $result;  
	}
	/**Edit**/
	
	 	public function get_single_table($table,$array)
	{
		$query = $this->db->get_where($table,$array);
		return $query->row();
	}
	
 	 public function add_cardmember($data)
 	{	
		 $data['card_id']=$this->input->post('card_id');
		 $data['member_name']=$this->input->post('member_name');
		 $data['dob']=$this->input->post('dob');
		 $data['status']=$this->input->post('status');
         $result = $this->db->insert('card_member', $data);
         return $result;
		
 	}
     
	 public function card_memberdelete($id){ 
     	
		 $this->db->where('member_id',$id);
		 $result = $this->db->delete('card_member');
		 if($result) {
			return "success"; 
		 }
		 else {
			 return "error";
		 }
		
	 }

	  public function get_member_list($id){
   
        return $this->db->query("SELECT * FROM `card_member` WHERE `card_id`='$id'")->result();
     
    }
    public function get_tbl_data($con)
    {         
        $this->db->select("*");
        $this->db->from('card_member');
        $this->db->join('card_table','card_table.id = card_member.card_id', 'left');
        $this->db->where($con);
        $query = $this->db->get();
       // print_r($this->db->last_query());die;
       return ($query->num_rows()>0)?$query->result():FALSE;       

    } 
    function get_single_cardmember($id){		  
		       $this->db->where('member_id',$id);
			   $query = $this->db->get('card_member');
			   $result = $query->row();
			   return $result;  
	}
	function cardmember_edit($data, $id){	
			   $this->db->where('member_id', $id);
			   $result = $this->db->update('card_member', $data); 
			   return $result;
		
	 }
	 public function check_all($table,$con)
        { 
            $query = $this->db->get_where($table,$con);
            return $query->row();
        } 
}