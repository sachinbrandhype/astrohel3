<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf_booking_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
 		$this->load->library('encryption');
    }
//docter List

    public function get_count($tbl) {
        $this->db->where_in('status',array(1, 0));
        $this->db->where('planned_visit','1');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_data($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        
        $this->db->order_by("doctor_firstname","ASC");
        $this->db->where_in('status',array(1, 0));
        $this->db->where('planned_visit','1');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }



     //online

     
    public function get_count_online_new_booking($tbl) {
        $this->db->where('status','0');
        $this->db->where('booking_type','4');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_new_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','0');
        $this->db->where('booking_type','4');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }



    public function get_count_online_all_booking($tbl) {
        $this->db->where('booking_type','4');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_all_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('booking_type','4');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

     public function get_count_online_complete_booking($tbl) {
        $this->db->where('status','1');
        $this->db->where('booking_type','4');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_complete_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','1');
        $this->db->where('booking_type','4');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

      public function get_count_online_cancel_booking($tbl) {
        $this->db->where_in('status',array(2, 3));
        $this->db->where('booking_type','4');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_cancel_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where_in('status',array(2, 3));
        $this->db->where('booking_type','4');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }




   //all_booking
    
   public function get_count_all_booking($tbl) {
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_all_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

    //plan_complete_booking
    public function get_count_complete_booking($tbl) {
        $this->db->where('status','1');
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_complete_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','1');
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

    //plan_cancel_booking

    public function get_count_cancel_booking($tbl) {
        $this->db->where_in('status',array(2, 3));
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_cancel_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where_in('status',array(2, 3));
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }


    //plan_new_booking
    public function get_count_new_booking($tbl) {
        $this->db->where('status','0');
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_new_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','0');
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','planned_visit');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }


//emergency_doctor_list

    public function get_count_emergency_doctor($tbl) {
         $this->db->where_in('status',array(1, 0));
        $this->db->where('emergency','1');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_emergency_doctor($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("doctor_firstname","ASC");
        $this->db->where_in('status',array(1, 0));
        $this->db->where('emergency','1');
       
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

//get_pagination_e_all_booking

       public function get_count_e_all_booking($tbl) {
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','emergency');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_e_all_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('booking_type','1');
        $this->db->where('doorstep_type','emergency');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

    //emergency_complete_booking

  public function get_count_e_complete_booking($tbl) {
        $this->db->where('booking_type','1');
         $this->db->where('status','1');
        $this->db->where('doorstep_type','emergency');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_e_complete_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('booking_type','1');
         $this->db->where('status','1');
        $this->db->where('doorstep_type','emergency');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }


    //emergency_cancel_booking
   
    public function get_count_e_cancel_booking($tbl) {
        $this->db->where('booking_type','1');
        $this->db->where_in('status',array(2, 3));
        $this->db->where('doorstep_type','emergency');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_e_cancel_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('booking_type','1');
        $this->db->where_in('status',array(2, 3));
        $this->db->where('doorstep_type','emergency');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

    //emergency_new_booking
    public function get_count_e_new_booking($tbl) {
        $this->db->where('booking_type','1');
        $this->db->where_in('status','0');
        $this->db->where('doorstep_type','emergency');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_e_new_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('booking_type','1');
        $this->db->where_in('status','0');
        $this->db->where('doorstep_type','emergency');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
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


          // offline booking
    public function get_count_offline_all_booking($tbl) {
        $this->db->where('booking_type','5');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_offline_all_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('booking_type','5');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }
    public function get_count_offline_complete_booking($tbl) {
        $this->db->where('status','1');
        $this->db->where('booking_type','5');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_offline_complete_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','1');
        $this->db->where('booking_type','5');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }
    public function get_count_offline_cancel_booking($tbl) {
        $this->db->where_in('status',array(2, 3));
        $this->db->where('booking_type','5');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_offline_cancel_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where_in('status',array(2, 3));
        $this->db->where('booking_type','5');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }
    public function get_count_offline_new_booking($tbl) {
        $this->db->where('status','0');
        $this->db->where('booking_type','5');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_offline_new_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','0');
        $this->db->where('booking_type','5');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }


     public function get_total_online_all_booking($user_name_mobile='',$doctor_n= '',$user_mode='')
    {
      $r = "SELECT COUNT(*) AS A FROM pdf_booking WHERE 1 ";
      if(!empty($user_name_mobile))
      {
        // print_r($user_name_mobile);die;
        $r.=" AND name LIKE '%".$user_name_mobile."%'  OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
      }
      $query = $this->db->query($r)->row();
      // echo $this->db->last_query(); die;
        return $query->A;
    }



    function get_get_total_online_all_booking_pagination($start = 0, $limit,$user_name_mobile='',$doctor_n='',$user_mode=''){
        $query = "SELECT * from pdf_booking where 1  ";
        if ($start == 0)
        {
          if($user_name_mobile != '')
          {
               $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
          }
         
          
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($user_name_mobile != '')
          {
               $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
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

    //new

      public function get_total_online_new_booking($user_name_mobile='',$doctor_n= '',$user_mode='')
    {
      $r = "SELECT COUNT(*) AS A FROM pdf_booking WHERE status = 0 ";
      if(!empty($user_name_mobile))
      {
        // print_r($user_name_mobile);die;
        $r.=" AND name LIKE '%".$user_name_mobile."%'  OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
      }
      $query = $this->db->query($r)->row();
      // echo $this->db->last_query(); die;
        return $query->A;
    }



    function get_get_total_online_new_booking_pagination($start = 0, $limit,$user_name_mobile='',$doctor_n='',$user_mode=''){
        $query = "SELECT * from pdf_booking where status = 0   ";
        if ($start == 0)
        {
          if($user_name_mobile != '')
          {
               $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
          }
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($user_name_mobile != '')
          {
               $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
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

//complete

      public function get_total_online_complete_booking($user_name_mobile='',$doctor_n= '',$user_mode='')
    {
      $r = "SELECT COUNT(*) AS A FROM pdf_booking WHERE status = 1 ";
      if(!empty($user_name_mobile))
      {
        // print_r($user_name_mobile);die;
        $r.=" AND name LIKE '%".$user_name_mobile."%'  OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
      }
      $query = $this->db->query($r)->row();
      // echo $this->db->last_query(); die;
        return $query->A;
    }



    function get_get_total_online_complete_booking_pagination($start = 0, $limit,$user_name_mobile='',$doctor_n='',$user_mode=''){
        $query = "SELECT * from pdf_booking where status = 1   ";
        if ($start == 0)
        {
          if($user_name_mobile != '')
          {
               $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
          }
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($user_name_mobile != '')
          {
               $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
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
//cancel

      public function get_total_online_cancel_booking($user_name_mobile='',$doctor_n= '',$user_mode='')
    {
      $r = "SELECT COUNT(*) AS A FROM pdf_booking WHERE status IN(2, 3,4)  ";
      if(!empty($user_name_mobile))
      {
        // print_r($user_name_mobile);die;
        $r.=" AND name LIKE '%".$user_name_mobile."%'  OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
      }
      $query = $this->db->query($r)->row();
      // echo $this->db->last_query(); die;
        return $query->A;
    }



    function get_get_total_online_cancel_booking_pagination($start = 0, $limit,$user_name_mobile='',$doctor_n='',$user_mode=''){
        $query = "SELECT * from pdf_booking where  status IN(2, 3,4)   ";
        if ($start == 0)
        {
          if($user_name_mobile != '')
          {
             $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
          }
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($user_name_mobile != '')
          {
               $query.= "AND name LIKE '%".$user_name_mobile."%' OR  email LIKE '%".$user_name_mobile."%' OR  mobile  LIKE '%".$user_name_mobile."%' ";
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



     function update_rating_status($data,$data1){
            $this->db->where('id',$data);
            $result = $this->db->update('rating_expert',$data1);
            return $result; 
        }







}