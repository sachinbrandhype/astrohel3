<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Order_modal extends CI_Model {
 
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
         $this->db->where_in('booking_type',array(1, 2));
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_new_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','0');
         $this->db->where_in('booking_type',array(1, 2));
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }


    //inperson


      public function get_count_inperson_new_booking($tbl) {
        $this->db->where('status','0');
        $this->db->where('booking_type','4');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_inperson_new_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','0');
        $this->db->where('booking_type','4');
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

    

     public function get_count_inperson_all_booking($tbl) {
        $this->db->where('booking_type','4');
         // $this->db->where_in('booking_type',array(1, 2));
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_inperson_all_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
         $this->db->where('booking_type','4');
        // $this->db->where_in('booking_type',array(1, 2));
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        // echo $this->db->last_query();die;
        return $query->result();
    }


     public function get_count_inperson_complete_booking($tbl) {
        $this->db->where('status','1');
         $this->db->where('booking_type','4');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_inperson_complete_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','1');
         $this->db->where('booking_type','4');
         $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

      public function get_count_inperson_cancel_booking($tbl) {
        $this->db->where_in('status',array(2, 3));
         $this->db->where('booking_type','4');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_inperson_cancel_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where_in('status',array(2, 3));
         $this->db->order_by("id","DESC");
         $this->db->where('booking_type','4');
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }





    public function get_count_online_all_booking($tbl) {
        // $this->db->where('booking_type','4');
         $this->db->where_in('booking_type',array(1, 2));
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_all_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where_in('booking_type',array(1, 2));
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

     public function get_count_online_complete_booking($tbl) {
        $this->db->where('status','1');
        $this->db->where_in('booking_type',array(1, 2));
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_complete_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('status','1');
         $this->db->where_in('booking_type',array(1, 2));
         $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }

      public function get_count_online_cancel_booking($tbl) {
        $this->db->where_in('status',array(2, 3));
        $this->db->where_in('booking_type',array(1, 2));
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_online_cancel_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where_in('status',array(2, 3));
         $this->db->order_by("id","DESC");
     $this->db->where_in('booking_type',array(1, 2));
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
                $this->db->order_by("id","DESC");
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
                $this->db->order_by("id","DESC");
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
                $this->db->order_by("id","DESC");

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
                $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");
        $this->db->where_in('status',array(1, 0));
        $this->db->where('emergency','1');
             $this->db->order_by("id","DESC");
 
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
        $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");

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
        $this->db->order_by("id","DESC");

        $query = $this->db->get($tbl);
        //echo $this->db->last_query();die;
        return $query->result();
    }


}