<?php 
class User_video_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}




   public function message($message, $status) {
    if ($status == 'warning') {
        return $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-no-border alert-close alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'. $message .'</div>');
    }
    if ($status == 'success') {

       return $this->session->set_flashdata('msg', '<div class="alert bounce alert-animate alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <b>Success! </b>'. $message .'</div>');
    }
    if ($status == 'error') { 
            
        return $this->session->set_flashdata('msg', '<div class="alert bounce alert-animate alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
            <b>Error! </b>'. $message .'</div>');
    }
  }

	//gems_products


     public function get_count($tbl) {
        $this->db->where('status','1');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

	  public function get_pagination_data_user_video($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        
        $this->db->order_by("title","ASC");
        $this->db->where('status','1');
        $query = $this->db->get($tbl);
        return $query->result();
    }


     function add($data,$table){
  
    $this->db->insert($table,$data);
    $result = $this->db->insert_id();
    return $result;
  }


  function get_single_data($id,$table){
    $this->db->select('*');
        $this->db->from($table);
    $this->db->where('id', $id);
    $query = $this->db->get();
    $result = $query->row();
    return $result;
  }


    function edit($data, $id,$table){
  
    $this->db->where('id', $id);

    $result = $this->db->update($table,$data);
    return $result;
  }



  function delete($data, $id,$table){
    $this->db->where('id', $id);
    $result = $this->db->update($table,$data);
    if($result){
      return "Success";
    }
    else{
      return "Error";
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

   public function get_total_video($title_data='',$start_date='',$end_date= '')
    {
      $r = "SELECT COUNT(*) AS A FROM user_video WHERE status <> 2";

       if(!empty($title_data))
      {
         $r.=" AND title LIKE '%".$title_data."%'";
      }

      if(!empty($start_date) && empty($end_date))
      {
        $r.=" AND added_on LIKE '%".$start_date."%'";
      }
      if(!empty($end_date))
      {
        $r.=" AND DATE(added_on) BETWEEN  '".$start_date."' AND '".$end_date."' ";
      }
      $query = $this->db->query($r)->row();
        return $query->A;
    }


    function get_video_for_pagination($start = 0, $limit,$title_data='',$start_date='',$end_date= ''){
        // echo $status;die;
        $query = "SELECT * from user_video where status <> 2  ";
           // echo $start;die;
        if ($start == 0)
        {

           if(!empty($title_data))
          {
            $query.=" AND title LIKE '%".$title_data."%'";
          }

         
        if(!empty($start_date) && empty($end_date))
          {
              $query.= "AND added_on LIKE '%".$start_date."%'";
          }
          if(!empty($end_date))
      {
        // echo $stock;die;
        $query.=" AND DATE(added_on) BETWEEN  '".$start_date."' AND '".$end_date."' ";
      }
         

         
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {

           if(!empty($title_data))
          {
             $query.=" AND title LIKE '%".$title_data."%'";

            
          }
           
         if(!empty($start_date) && empty($end_date))
          {
              $query.= "AND added_on LIKE '%".$start_date."%'";
          }
         if(!empty($end_date))
          {
            // echo $stock;die;
              $query.=" AND DATE(added_on) BETWEEN  '".$start_date."' AND '".$end_date."' ";
          }
         


          $query.=" ORDER BY id DESC LIMIT $limit OFFSET $start";
          $q = $this->db->query($query);
        }
        if ($q->num_rows() > 0)
        {
          foreach ($q->result() as $row)
          {
                $data[] = $row;
          }  
          return $data;
        }
        return false;
    }






}