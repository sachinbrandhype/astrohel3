<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Speedhuntson_m extends CI_Model {
 
    function __construct() {
        parent::__construct();
 		$this->load->library('encryption');
    }



 public function get_total_enquiry($sup_name='',$doctor_mode= '',$status)
    {
      $r = "SELECT COUNT(*) AS A FROM user_support WHERE status  = '".$status."'  ";
      if(!empty($sup_name))
      {
        $r.=" AND name = '".$sup_name."'";
      }
      if(!empty($sup_email))
      {
        $r.=" AND email = '".$sup_email."'";
      }
      $query = $this->db->query($r)->row();
        return $query->A;
    }



    function get_enquiry_for_pagination($start = 0, $limit,$sup_name='',$sup_email='',$status){
        $query = "SELECT * from user_support where status = '".$status."'  ";
        if ($start == 0)
        {
          if($sup_name != '')
          {
              $query.= " AND name = '".$sup_name."'";
          }
          if($sup_email != '')
          {
            $query.= " AND email = '".$sup_email."'";
          }
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
         if($sup_name != '')
          {
              $query.= " AND name = '".$sup_name."'";
          }
          if($sup_email != '')
          {
            $query.= " AND email = '".$sup_email."'";
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

    
//support_enquiry

     function get_allergies_lists() {
                $query= $this->db->select('id,name ');
                $query = $this->db->get('master_allergies');
                $result = $query->result();
                return $result;
     }

       public function get_total_allergies_details($allergies_id='')
    {
      $r = "SELECT COUNT(*) AS A FROM master_allergies WHERE 1 ";
      if(!empty($allergies_id))
      {
        $r.=" AND id = ".$allergies_id."";
      }    
      $query = $this->db->query($r)->row();
        return $query->A;
    }


     function get_allergies_details_for_pagination($start = 0, $limit,$allergies_id=''){
        $query = "SELECT * from master_allergies where 1  ";
        if ($start == 0)
        {
          if($allergies_id != '')
          {
              $query.= "AND id = '".$allergies_id."'";
          }
            $query.=" ORDER BY name ASC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($allergies_id != '')
          {
              $query.= "AND id = '".$allergies_id."'";
          }
          $query.=" ORDER BY name ASC LIMIT $limit OFFSET $start";
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



      function get_surgeries_lists() {
                $query= $this->db->select('id,name ');
                $query= $this->db->order_by('name');
                $query = $this->db->get('master_surgeries');
                $result = $query->result();
                return $result;
     }

       public function get_total_surgeries_details($surgeries_id='')
    {
      $r = "SELECT COUNT(*) AS A FROM master_surgeries WHERE 1 ";
      if(!empty($surgeries_id))
      {
        $r.=" AND id = ".$surgeries_id."";
      }    
      $query = $this->db->query($r)->row();
        return $query->A;
    }


     function get_surgeries_details_for_pagination($start = 0, $limit,$surgeries_id=''){
        $query = "SELECT * from master_surgeries where 1  ";
        if ($start == 0)
        {
          if($surgeries_id != '')
          {
              $query.= "AND id = '".$surgeries_id."'";
          }
            $query.=" ORDER BY name ASC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($surgeries_id != '')
          {
              $query.= "AND id = '".$surgeries_id."'";
          }
          $query.=" ORDER BY name ASC LIMIT $limit OFFSET $start";
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


    function get_illnesses_lists() {
                $query= $this->db->select('id,name ');
                $query= $this->db->order_by('name');
                $query = $this->db->get('master_illnesses');
                $result = $query->result();
                return $result;
     }

       public function get_total_illnesses_details($illnesses_id='')
    {
      $r = "SELECT COUNT(*) AS A FROM master_illnesses WHERE 1 ";
      if(!empty($illnesses_id))
      {
        $r.=" AND id = ".$illnesses_id."";
      }    
      $query = $this->db->query($r)->row();
        return $query->A;
    }


     function get_illnesses_details_for_pagination($start = 0, $limit,$illnesses_id=''){
        $query = "SELECT * from master_illnesses where 1  ";
        if ($start == 0)
        {
          if($illnesses_id != '')
          {
              $query.= "AND id = '".$illnesses_id."'";
          }
            $query.=" ORDER BY name ASC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($illnesses_id != '')
          {
              $query.= "AND id = '".$illnesses_id."'";
          }
          $query.=" ORDER BY name ASC LIMIT $limit OFFSET $start";
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



  public function get_count_support_enquiry_all($tbl) {
       // $this->db->where('status','0');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_all_support_enquiry($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id","DESC");
        //$this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

      public function get_count_support_enquiry_new($tbl) {
        $this->db->where('status','0');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_new_support_enquiry($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id","DESC");
        $this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

     public function get_count_support_enquiry_cancel($tbl) {
       $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_cancel_support_enquiry($limit, $start, $tbl) {
       $this->db->limit($limit, $start);
        $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }

    public function get_count_support_enquiry_complete($tbl) {
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_complete_support_enquiry($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }

    


//Pharmacy Enquiry

        public function get_count_all_pharmacy($tbl) {
       // $this->db->where('status','0');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_all_pharmacy($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id","DESC");
        //$this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

      public function get_count_new_pharmacy($tbl) {
        $this->db->where('status','0');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_new_pharmacy($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id","DESC");
        $this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

     public function get_count_cancel_pharmacy($tbl) {
       $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_cancel_pharmacy($limit, $start, $tbl) {
       $this->db->limit($limit, $start);
        $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }

    public function get_count_complete_pharmacy($tbl) {
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_complete_pharmacy($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }


     function update_medical_equipment_status($data,$data1){
            $this->db->where('id',$data);
            $result = $this->db->update('medical_equipment',$data1);
            return $result; 
        }



    //orders_for__purchase
      public function get_count_orders_for_purchase($tbl) {
        $this->db->where('equipment_type','Purchase');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

     public function get_pagination_orders_for_purchase($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('equipment_type','Purchase');
        $this->db->order_by("added_on","DESC");
         // echo  $this->db->last_query(); die;
        $query = $this->db->get($tbl);
        return $query->result();
    }

    //orders_for_rentals
      public function get_count_orders_for_rentals($tbl) {
        $this->db->where('equipment_type','Rental');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

     public function get_pagination_orders_for_rentals($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('equipment_type','Rental');
        $this->db->order_by("added_on","DESC");
        // echo  $this->db->last_query(); die;
        $query = $this->db->get($tbl);
        return $query->result();
    }


     //orders_for_complete
      public function get_count_orders_for_complete($tbl) {
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

     public function get_pagination_orders_for_complete($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->order_by("added_on","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }



     //orders_for_cancel
      public function get_count_orders_for_cancel($tbl) {
        $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

     public function get_pagination_orders_for_cancel($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->order_by("added_on","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }



     public function get_count_all_booking_ambulance($tbl) {
       // $this->db->where('status','0');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_all_booking_ambulance($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id","DESC");
        //$this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

      public function get_count_new_booking_ambulance($tbl) {
        $this->db->where('status','0');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_new_booking_ambulance($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id","DESC");
        $this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

     public function get_count_cancel_booking_ambulance($tbl) {
       $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_cancel_booking_ambulance($limit, $start, $tbl) {
       $this->db->limit($limit, $start);
        $ids = array(2,3);
        $this->db->where_in('status',$ids);
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }

    public function get_count_complete_booking_ambulance($tbl) {
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_complete_booking_ambulance($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }




     public function get_count_rental($tbl) {
        $this->db->where('for','Rental');
        //$this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_data_rental($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('for','Rental');
       $this->db->where('status','1');
        $query = $this->db->get($tbl);
        return $query->result();
    }

     public function get_count_sell($tbl) {
        $this->db->where('for','Purchase');
        //$this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_data_sell($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->where('for','Purchase');
       // $this->db->where('status','1');
        $query = $this->db->get($tbl);
        return $query->result();
    }


    public function medical_equipment_gallery($id){
        $this->db->where('medical_equipment_id',$id);
        $query = $this->db->get('medical_equipment_gallery');
        $result = $query->result();
        return $result;  
    }

     public function get_count_equipment_gallery($tbl) {
       // $this->db->where('status','1');
        //$this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

      public function get_pagination_data_equipment_gallery($limit, $start, $tbl, $id) {
        $this->db->limit($limit, $start);
        $this->db->where('medical_equipment_id',$id);

       // $this->db->order_by("name","ASC");
       // $this->db->where('status','1');
        $query = $this->db->get($tbl);
        return $query->result();
    }

    public function get_count($tbl) {
        $this->db->where('status','1');
        //$this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_count_ambulance($tbl) {
         $ids = array(1,0);
        $this->db->where_in('status',$ids);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

 public function get_count_medical_equipment_filter($equipment_name='')
    {
      $r = "SELECT COUNT(*) AS A FROM medical_equipment WHERE 1 AND status IN (1,0)";
      // echo $stock;die;
      if(!empty($equipment_name))
      {
        $r.=" AND name LIKE '%".$equipment_name."%'";
      }
    
      
      $query = $this->db->query($r)->row();

        return $query->A;
      
        
    }

    function get_pagination_data_medical_equipment_filter($start = 0, $limit,$equipment_name=''){
        // echo $status;die;
        $query = "SELECT * from medical_equipment where 1 AND status IN (1,0)  ";
       
           // echo $start;die;
        if ($start == 0)
        {
         
          if($equipment_name != '')
          {
              $query.= " AND name LIKE '%".$equipment_name."%'";
          }
          

            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
           
          if($equipment_name != '')
          {
               $query.= " AND name LIKE '%".$equipment_name."%'";
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

     


     public function get_count_medical_equipment($tbl) {
        $ids = array(1,0);
        $this->db->where_in('status',$ids);

        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    //new Booking pagination
    
    public function get_count_all_booking($tbl) {
       // $this->db->where('status','0');
         $this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_all_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("added_on","DESC");
         $this->db->where('booking_type','6');
        //$this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

    //new Booking pagination
   public function get_count_new_booking($tbl) {
        $this->db->where('status','0');
         $this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_new_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
         $this->db->where('booking_type','6');
        $this->db->order_by("added_on","DESC");
        $this->db->where('status','0');
        $query = $this->db->get($tbl);
        return $query->result();
    }

//cancel booking pagination
     public function get_count_cancel_booking($tbl) {
        $ids = array(2,3);
        $this->db->where_in('status',$ids);
         $this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_cancel_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $ids = array(2,3);
         $this->db->where('booking_type','6');
        $this->db->where_in('status',$ids);
        $this->db->order_by("added_on","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }
//get_pagination_complete_booking
     public function get_count_complete_booking($tbl) {
        $ids = array('1');
        $this->db->where_in('status',$ids);
         $this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }
    public function get_pagination_complete_booking($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $ids = array('1');
        $this->db->where_in('status',$ids);
        $this->db->where('booking_type','6');
        $this->db->order_by("added_on","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }


     public function get_pagination_data($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("name","ASC");
        $this->db->where('status','1');
        $query = $this->db->get($tbl);
        return $query->result();
    }

     public function get_pagination_data_ambulance($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
         $ids = array(0,1);
        $this->db->order_by("name","ASC");
        $this->db->where_in('status',$ids);
        $query = $this->db->get($tbl);
        return $query->result();
    }



    

     public function get_pagination_data_medical_equipment($limit, $start, $tbl) {
        $ids = array(0,1);
        $this->db->limit($limit, $start);
        $this->db->where_in('status',$ids);
        $this->db->order_by("id","desc");
        $query = $this->db->get($tbl);
        return $query->result();
    }


     public function get_pagination_common_service($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("service_name","ASC");
        
        $this->db->where('status','1');
        $this->db->where('type','nurse');
        $query = $this->db->get($tbl);
//echo $this->db->last_query(); die;
        return $query->result();
    }


     public function get_count_surgeries($tbl) {
        //$this->db->where('booking_type','6');
         $this->db->order_by("name","ASC");
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }


     public function get_pagination_surgeries($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("name","ASC");
      
        $query = $this->db->get($tbl);
//echo $this->db->last_query(); die;
        return $query->result();
    }


     public function get_count_common_service($tbl) {
        $this->db->where('status','1');
         $this->db->where('type','nurse');
        //$this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

      public function get_pagination_common_medical_service($limit, $start, $tbl) {
        $ids = array(0,1);
         $this->db->where_in('status',$ids);

        $this->db->limit($limit, $start);
        $this->db->order_by("service_name","ASC");
        
        // $this->db->where('status','1');
        $this->db->where('type','services');
        $query = $this->db->get($tbl);
//echo $this->db->last_query(); die;
        return $query->result();
    }

     public function get_count_medical_service($tbl) {
         $ids = array(0,1);
         $this->db->where_in('status',$ids);
         $this->db->where('type','services');
        //$this->db->where('booking_type','6');
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }


    
     public function get_pagination_advertisment($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
      //  $this->db->order_by("name","ASC");
        $this->db->where('status','1');
        $query = $this->db->get($tbl);
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


	public function get_total_list()
    {
    	$r = $this->db->query("SELECT COUNT(*) AS A FROM `tournament_match`")->row();
		
		return $r->A;
    }

    public function get__list($limit, $start = 0)
    {
    	if ($start == 0) {
			$query = $this->db->query("SELECT * FROM tournament_match  ORDER BY `start_date` DESC LIMIT $limit");
			// echo $this->db->last_query();
		}
		else
		{
			$query = $this->db->query("SELECT * FROM tournament_match ORDER BY `start_date` DESC LIMIT $limit OFFSET $start ");
			// echo $this->db->last_query();
		}
		
		 
		if ($query->num_rows() > 0) 
	        {
	            foreach ($query->result() as $row) 
	            {
	                $data[] = $row;
	            }
	             
	            return $data;
	        }
	 
	        return false;
    } 

    public function get_upcomingtotal_list()
    {
        $date = date('Y-m-d');
        $r = $this->db->query("SELECT COUNT(*) AS A FROM `tournament_match` WHERE date(`start_date`) >= '$date' AND `match_status_checking` = 'not_stop'")->row();
        
        return $r->A;
    }

    public function get__upcominglist($limit, $start = 0)
    {
        $date = date('Y-m-d');
        if ($start == 0) {
            $query = $this->db->query("SELECT * FROM tournament_match  WHERE date(`start_date`) >= '$date' AND `match_status_checking` = 'not_stop'  ORDER BY `start_date` ASC LIMIT $limit");
            // echo $this->db->last_query();
        }
        else
        {
            $query = $this->db->query("SELECT * FROM tournament_match  WHERE date(`start_date`) >= '$date' AND `match_status_checking` = 'not_stop' ORDER BY `start_date` ASC LIMIT $limit OFFSET $start ");
            // echo $this->db->last_query();
        }
        
         
        if ($query->num_rows() > 0) 
            {
                foreach ($query->result() as $row) 
                {
                    $data[] = $row;
                }
                 
                return $data;
            }
     
            return false;
    } 

    public function get_recenttotal_list()
    {
        $date = date('Y-m-d');
        $r = $this->db->query("SELECT COUNT(*) AS A FROM `tournament_match` WHERE date(`start_date`) <= '$date' AND `match_status_checking` = 'stop' AND `is_done` = 'Y'")->row();
        
        return $r->A;
    }

    public function get__recentlist($limit, $start = 0)
    {
        $date = date('Y-m-d');
        if ($start == 0) {
            $query = $this->db->query("SELECT * FROM tournament_match  WHERE date(`start_date`) <= '$date' AND `match_status_checking` = 'stop' AND `is_done` = 'Y'  ORDER BY `start_date` DESC LIMIT $limit");
            // echo $this->db->last_query();
        }
        else
        {
            $query = $this->db->query("SELECT * FROM tournament_match  WHERE date(`start_date`)<= '$date' AND `match_status_checking` = 'stop' AND `is_done` = 'Y' ORDER BY `start_date` DESC LIMIT $limit OFFSET $start ");
            // echo $this->db->last_query();
        }
        
         
        if ($query->num_rows() > 0) 
            {
                foreach ($query->result() as $row) 
                {
                    $data[] = $row;
                }
                 
                return $data;
            }
     
            return false;
    } 

    public function get_livetotal_list()
    {
        $date = date('Y-m-d');
        $r = $this->db->query("SELECT COUNT(*) AS A FROM `tournament_match` WHERE `match_status_checking` = 'stop' AND `is_done` = 'N'")->row();
        
        return $r->A;
    }

    public function get__livelist($limit, $start = 0)
    {
        $date = date('Y-m-d');
        if ($start == 0) {
            $query = $this->db->query("SELECT * FROM tournament_match  WHERE `match_status_checking` = 'stop' AND `is_done` = 'N'  ORDER BY `start_date` DESC LIMIT $limit");
            // echo $this->db->last_query();
        }
        else
        {
            $query = $this->db->query("SELECT * FROM tournament_match  WHERE `match_status_checking` = 'stop' AND `is_done` = 'N' ORDER BY `start_date` DESC LIMIT $limit OFFSET $start ");
            // echo $this->db->last_query();
        }
        
         
        if ($query->num_rows() > 0) 
            {
                foreach ($query->result() as $row) 
                {
                    $data[] = $row;
                }
                 
                return $data;
            }
     
            return false;
    } 

    public function get_flag_image($team_name)
    {
    	switch ($team_name) 
    	{
    		case 'Afghanistan':
    				return 'afghanistan.png';
    			break;

    		case 'afghanistan':
    				return 'afghanistan.png';
    			break;

    		case 'Australia':
    				return 'australia.png';
    			break;

    		case 'australia':
    				return 'australia.png';
    			break;

    		case 'Bangladesh':
    				return 'bangladesh.png';
    			break;

    		case 'bangladesh':
    				return 'bangladesh.png';
    			break;

    		case 'Canada':
    				return 'canada.png';
    			break;

    		case 'canada':
    				return 'canada.png';
    			break;

    		case 'England':
    				return 'england.png';
    			break;

    		case 'england':
    				return 'england.png';
    			break;

    		case 'Denmark':
    				return 'denmark.png';
    			break;

    		case 'denmark':
    				return 'denmark.png';
    			break;

    		case 'India':
    				return 'india.png';
    			break;

    		case 'india':
    				return 'india.png';
    			break;

    		case 'Germany':
    				return 'germany.png';
    			break;

    		case 'germany':
    				return 'germany.png';
    			break;

    		case 'Kenya':
    				return 'Kenya.png';
    			break;

    		case 'kenya':
    				return 'Kenya.png';
    			break;

    		case 'Pakistan':
    				return 'pakistan.png';
    			break;

    		case 'pakistan':
    				return 'pakistan.png';
    			break;

    		case 'New-Zealand':
    				return 'new-zealand.png';
    			break;

    		case 'new-zealand':
    				return 'new-zealand.png';
    			break;

    		case 'New Zealand':
    				return 'new-zealand.png';
    			break;

    		case 'Netherlands':
    				return 'Netherlands.png';
    			break;

    		case 'netherlands':
    				return 'Netherlands.png';
    			break;

    		case 'South Africa':
    				return 'south-africa.png';
    			break;
    		case 'South-Africa':
    				return 'south-africa.png';
    			break;
    		case 'south-africa':
    				return 'south-africa.png';
    			break;
			case 'south-africa':
    				return 'south-africa.png';
    			break;

    		case 'Sri Lanka':
    				return 'srilanka.png';
    			break;
    		case 'sri lanka':
    				return 'srilanka.png';
    			break;
			case 'Srilanka':
    				return 'srilanka.png';
    			break;
    		case 'srilanka':
    				return 'srilanka.png';
    			break;

    		case 'West Indies':
    				return 'west-indies.png';
    			break;
    		case 'west indies':
    				return 'west-indies.png';
    			break;
			case 'West-Indies':
    				return 'west-indies.png';
    			break;
    		case 'west-indies':
    				return 'west-indies.png';
    			break;
    		
    		default:
    				return 'flag.png';
    			break;
    	}
    	
    }

    public function get_match_squad($match_id)
	{
		return $this->db->query("SELECT`id`, `match_id`, `team`, `player_name`, `runs`, `balls`, `fours`, `six`, `dismissal`, `overs`, `maidens`, `bowling_runs`, `wickets`, `wides`, `nballs`, `added_on`, `modified_on`, `squad_bench` FROM `match_team` WHERE `match_id`='$match_id'")->result();
	}

	public function get_match_detail($match_id)
	{
		return $this->db->query("SELECT `id`, `match_id`, `tournament_id`, `name`, `timezone`, `openDate`, `start_date`, `marketCount`, `matchUniqueID`, `team_one_name`, `team_two_name`, `team_one_image`, `team_two_image`, `match_number`, `match_date`, `match_type`, `is_done`, `match_status`, `match_status_checking`, `match_cancel`, `winner_team`, `srs`, `toss`, `status_of_time`, `venue_name`, `venue_location`, `official`, `start_time`, `added_on`, `modified_on`, `market_id`, `back_price`, `lay_price`, `fav_team` FROM `tournament_match` WHERE `match_id`='$match_id'")->row();
	}

    function datediff($interval, $datefrom, $dateto, $using_timestamps = false)
    {
        /*
        $interval can be:
        yyyy - Number of full years
        q    - Number of full quarters
        m    - Number of full months
        y    - Difference between day numbers
               (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
        d    - Number of full days
        w    - Number of full weekdays
        ww   - Number of full weeks
        h    - Number of full hours
        n    - Number of full minutes
        s    - Number of full seconds (default)
        */

        if (!$using_timestamps) {
            $datefrom = strtotime($datefrom, 0);
            $dateto   = strtotime($dateto, 0);
        }

        $difference        = $dateto - $datefrom; // Difference in seconds
        $months_difference = 0;

        switch ($interval) {
            case 'yyyy': // Number of full years
                $years_difference = floor($difference / 31536000);
                if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
                    $years_difference--;
                }

                if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
                    $years_difference++;
                }

                $datediff = $years_difference;
            break;

            case "q": // Number of full quarters
                $quarters_difference = floor($difference / 8035200);

                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }

                $quarters_difference--;
                $datediff = $quarters_difference;
            break;

            case "m": // Number of full months
                $months_difference = floor($difference / 2678400);

                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }

                $months_difference--;

                $datediff = $months_difference;
            break;

            case 'y': // Difference between day numbers
                $datediff = date("z", $dateto) - date("z", $datefrom);
            break;

            case "d": // Number of full days
                $datediff = floor($difference / 86400);
            break;

            case "w": // Number of full weekdays
                $days_difference  = floor($difference / 86400);
                $weeks_difference = floor($days_difference / 7); // Complete weeks
                $first_day        = date("w", $datefrom);
                $days_remainder   = floor($days_difference % 7);
                $odd_days         = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?

                if ($odd_days > 7) { // Sunday
                    $days_remainder--;
                }

                if ($odd_days > 6) { // Saturday
                    $days_remainder--;
                }

                $datediff = ($weeks_difference * 5) + $days_remainder;
            break;

            case "ww": // Number of full weeks
                $datediff = floor($difference / 604800);
            break;

            case "h": // Number of full hours
                $datediff = floor($difference / 3600);
            break;

            case "n": // Number of full minutes
                $datediff = floor($difference / 60);
            break;

            default: // Number of full seconds (default)
                $datediff = $difference;
            break;
        }

        return $datediff;
    }

    public function get_total_sd_contact_us()
    {
        $r = $this->db->query("SELECT COUNT(*) AS A FROM sd_contact_us")->row();
        
        return $r->A;
    }

    public function get__list_sd_contact_us($limit, $start = 0)
    {
        if ($start == 0) {
            $query = $this->db->query("SELECT * FROM sd_contact_us ORDER BY `id` DESC LIMIT $limit");
            // echo $this->db->last_query();
        }
        else
        {
            $query = $this->db->query("SELECT * FROM sd_contact_us ORDER BY `id` DESC LIMIT $limit OFFSET $start ");
            // echo $this->db->last_query();
        }
        
         
        if ($query->num_rows() > 0) 
            {
                foreach ($query->result() as $row) 
                {
                    $data[] = $row;
                }
                 
                return $data;
            }
     
            return false;
    } 

    public function get_total_list_coupan()
    {
        $r = $this->db->query("SELECT COUNT(*) AS A FROM `coupan` WHERE `status` <> 2")->row();
        
        return $r->A;
    }

    public function get__list_coupan($limit, $start = 0)
    {
        if ($start == 0) {
            $query = $this->db->query("SELECT * FROM coupan WHERE `status` <> 2 ORDER BY id DESC LIMIT $limit");
            // echo $this->db->last_query();
        }
        else
        {
            $query = $this->db->query("SELECT * FROM coupan WHERE `status` <> 2 ORDER BY id DESC LIMIT $limit OFFSET $start ");
            // echo $this->db->last_query();
        }
        
         
        if ($query->num_rows() > 0) 
            {
                foreach ($query->result() as $row) 
                {
                    $data[] = $row;
                }
                 
                return $data;
            }
     
            return false;
    }   


     function update_ambulance_status($data,$data1){
            $this->db->where('id',$data);
            $result = $this->db->update('ambulance',$data1);
            return $result; 
        }

        function update_ambulance_category_status($data,$data1){
            $this->db->where('id',$data);
            $result = $this->db->update('ambulance_category',$data1);
            return $result; 
        }

        function update_common_service_status($data,$data1){
            $this->db->where('id',$data);
            $result = $this->db->update('common_service',$data1);
            return $result; 
        }



        public function send_ios_notification($device_token,$message_text,$type)
    {
$payload='{"aps":{"alert":"'.$message_text.'","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"'.$type.'"}';
        //include_once("Cow.pem");
        $ctx=stream_context_create();
        stream_context_set_option($ctx,'ssl','local_cert','/var/www/html/picasoid/notification_key/api.pem');
        // $fp=stream_socket_client('ssl://gateway.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        $fp=stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
        if($fp)
        {
        // echo "Connected".$err;
        }
        $msg=chr(0).pack("n",32).pack("H*",str_replace(' ','',$device_token)).pack("n",strlen($payload)).$payload;
        $res=fwrite($fp,$msg);
        if($res)
        {
         //print_r($res);  
        }
        fclose($fp);
        return true;
    }

    public function sendMessageThroughFCM($registatoin_ids, $message)
{
    $k = 'AAAAlzqnLIw:APA91bGHHrKabusAQDnlaXoTT095ynYXsQQ8uPhcO91mYHR-sDHHeUHqVxJWpJ4F4KJTXGC-27VHt2aE3kUiS3od8V87me7lkNf7PDhYqNdQMUesS0naYNsODH8kMySG7uk8f3p3C_k9';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message
        );
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='.$k;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //Setup curl, add headers and post parameters.
       
        $result = curl_exec($ch);  
        // print_r($result);            
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }


}