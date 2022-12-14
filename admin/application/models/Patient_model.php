<?php 
class Patient_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}


	function update_patient_status($data,$data1){
			$this->db->where('id',$data);
			$result = $this->db->update('user',$data1);
			return $result; 
	    }



public function get_doc_history_details($patient_id){
		 $query = $this->db->where(array('patient_id'=>$patient_id))->get('booking');
		 $result = $query->result();
		 return $result;
     }

     public function get_lab_history_details($patient_id){
		 $query = $this->db->where(array('patient_id'=>$patient_id))->get('booking_test');
		 $result = $query->result();
		 return $result;
     }

     public function get_pharmacy_history_details($patient_id){
		 $query = $this->db->where(array('patient_id'=>$patient_id))->get('pharmacy_enquiry');
		 $result = $query->result();
		 return $result;
     }


public function get_quotation_history_details($patient_id){
		 $query = $this->db->where(array('user_id'=>$patient_id))->get('surgery_enquiry_quotation');
		 $result = $query->result();
		 return $result;
     }


     public function get_count_notification($tbl) {
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }


      public function get_pagination_data_notification($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("added_on","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }

     public function get_count_patientdetails($tbl) {
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

      public function get_pagination_data_patientdetails($limit, $start, $tbl) {
        $this->db->limit($limit, $start);
        $this->db->order_by("id","DESC");
        $query = $this->db->get($tbl);
        return $query->result();
    }



	 function get_patientdetails(){
		 $query = $this->db->get('patient');
		 $result = $query->result();
		 return $result;
     }
     public function get_tbl_data($con)
    {         
        $this->db->select("*");
        $this->db->from('user_member');
        $this->db->where($con);
        $this->db->where('status',0);
        $query = $this->db->get();
       // print_r($this->db->last_query());die;
       return ($query->num_rows()>0)?$query->result():FALSE;       

    } 

    public function get_memberdetails($patient_id){
		 $query = $this->db->where(array('user_id'=>$patient_id,'status'=>1))->get('user_member');
		 $result = $query->result();
		 return $result;
     }

    function get_transactiondetails($patient_id){
		 $query = $this->db->where(array('patient_id'=>$patient_id))->get('patient_transaction_history');
		 $result = $query->result();
		 return $result;
     }
	 function view_popup_patient($id){
		$this->db->select('patient.id as id,patient.*,
						   insurance_categories.insurance_name, 
						   language_categories.language_name, 
						   GROUP_CONCAT(distinct insurance_categories.insurance_name) as insurance_name,
						   GROUP_CONCAT(distinct language_categories.language_name) as language_name');
		$this->db->from('patient as patient' );
		$this->db->join('insurance_categories', 'FIND_IN_SET(insurance_categories.id, patient.insurance) > 0','left');
		$this->db->join('language_categories', 'FIND_IN_SET(language_categories.id, patient.languages) > 0','left');
		$this->db->group_by('patient.id');  
		$this->db->where('patient.id',$id);  
		$query = $this->db->get();
		$result = $query->row();
		return $result;	    
     }
	 public function patient_delete($id){ 
		 $this->db->where('id',$id);
		 $result = $this->db->delete('user');
		 if($result) {
			return "success"; 
		 }
		 else {
			 return "error";
		 }
	 }
	  function  patientdetails_add($data){
		  	$this->db->where('email', $data['email']);
			$query1 = $this->db->get('patient');
			$result1 = $query1->row(); 
			if($result1){  
				return false;
			}
			else{
				$this->db->where('email', $data['email']);
				$query2 = $this->db->get('doctor');
				$result2 = $query2->row(); 
				if($result2){  
					return false;
				}
				else{
					$this->db->where('email', $data['email']);
					$query3 = $this->db->get('clinic');
					$result3 = $query3->row(); 
					if($result3){  
						return false;
					}
					else{
						$this->db->where('email', $data['email']);
						$query4 = $this->db->get('hospital');
						$result4 = $query4->row(); 
						if($result4){  
							return false;
						}
						else{
							$this->db->where('email', $data['email']);
							$query5 = $this->db->get('medical_center');
							$result5 = $query5->row(); 
							if($result5){  
								return false;
							}
							else{
								$array = $data['languages'];
								$comma_separated = implode(",", $array);
								$data['languages']=$comma_separated;
								$array = $data['insurance'];
								$comma_separated = implode(",", $array);
								$data['insurance']=$comma_separated;
								$data['password'] = md5($data['password']);
								$result = $this->db->insert('patient', $data);
								return $result;
							}
						}
					}
				}
			}
      }
	  public function get_single_patient($id){
		   $query = $this->db->where('id',$id);
		   $query = $this->db->get('user');
		   $result = $query->row();
		   return $result;  
	   }

	 function patientdetails_edit($data, $id){
		    $this->db->where('email', $data['email']);
			$this->db->where('id<>', $id);
			$query1 = $this->db->get('patient');
			$result1 = $query1->row(); 
			if($result1){  
				return false;
			}
			else{
				$this->db->where('email', $data['email']);
				$query2 = $this->db->get('doctor');
				$result2 = $query2->row(); 
				if($result2){  
					return false;
				}
				else{
					$this->db->where('email', $data['email']);
					$query3 = $this->db->get('clinic');
					$result3 = $query3->row(); 
					if($result3){  
						return false;
					}
					else{
						$this->db->where('email', $data['email']);
						$query4 = $this->db->get('hospital');
						$result4 = $query4->row(); 
						if($result4){  
							return false;
						}
						else{
							$this->db->where('email', $data['email']);
							$query5 = $this->db->get('medical_center');
							$result5 = $query5->row(); 
							if($result5){  
								return false;
							}
							else{
								$array = $data['languages'];
								$comma_separated = implode(",", $array);
								$data['languages']=$comma_separated;
								$array = $data['insurance'];
								$comma_separated = implode(",", $array);
								$data['insurance']=$comma_separated;
								$this->db->where('id', $id);
								$result = $this->db->update('patient', $data);
								return $result;
							}
						}
					}
				}
			} 
	 }
	 public function get_patientval(){
		$places=$_POST['place'];
		$type='establishment';
		$key = $this->config->item('encryption_key');
		$jsonResults = file_get_contents("https://maps.googleapis.com/maps/api/place/textsearch/json?query=$places&location=$lat,$long&radius=50000&type=$type&key=$key");
		$json_decode = json_decode($jsonResults);
		foreach($json_decode->results as $arrayval){  
			$name= $arrayval->name;
			$id=$arrayval->id;
			echo '<option data-lat="'.$lat.'" data-lon="'.$lon.'" data-id="'.$id.'" value="'.$name.'">'.$name.'</option>';
		}
	 }
	  public function get_patientstateval()
	  {
         $places=$_POST['place'];
		 $type='establishment';
	     $key = $this->config->item('encryption_key');
	     $jsonResults = file_get_contents("https://maps.googleapis.com/maps/api/place/textsearch/json?query=$places&location=$lat,$long&radius=50000&type=$type&key=$key");
		 $json_decode = json_decode($jsonResults);
		 foreach($json_decode->results as $arrayval){
			$name= $arrayval->name;
			$id=$arrayval->id;
			echo '<option data-lat="'.$lat.'" data-lon="'.$lon.'" data-id="'.$id.'" value="'.$name.'">'.$name.'</option>';
		 }
	  }
	  function get_patientcountryval(){
		   $places=$_POST['place'];
		   $type='establishment';
		   $key = $this->config->item('encryption_key');
		   $jsonResults = file_get_contents("https://maps.googleapis.com/maps/api/place/textsearch/json?query=$places&location=$lat,$long&radius=50000&type=$type&key=$key");
		   $json_decode = json_decode($jsonResults);
		   foreach($json_decode->results as $arrayval)
		   { 
				$name= $arrayval->name;
				$id=$arrayval->id;
				echo '<option data-lat="'.$lat.'" data-lon="'.$lon.'" data-id="'.$id.'" value="'.$name.'">'.$name.'</option>';
		   }
	  }
	  function gets_language() {
		   $query = $this->db->get('language_categories');
		   $result = $query->result();
		   return $result;
	  }
	   function gets_insuranceval() {
		  $query = $this->db->get('insurance_categories');
		  $result = $query->result();
		  return $result;
	  } 

	   public function get_count($tbl,$user_id) {
        $this->db->where('referral_from',$user_id);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }

    public function get_pagination_data($limit, $start, $tbl, $user_id) {
        $this->db->limit($limit, $start);
        $this->db->where('appy_by',$user_id);
        $query = $this->db->get($tbl);
        echo $this->db->last_query();die;
        return $query->result();

        //SELECT * FROM `referral_code_history` WHERE `appy_by` = '11' LIMIT 1
    }

     public function get_order_data($limit, $start = 0, $tbl, $user_id)
   {
       if ($start == 0) {
           $query = $this->db->query("SELECT * FROM $tbl WHERE `referral_from` = $user_id ORDER BY `added_on` DESC  LIMIT $limit");
       }
       else
       {
           $query = $this->db->query("SELECT * FROM $tbl WHERE `referral_from` = $user_id ORDER BY `added_on` DESC LIMIT $limit OFFSET $start ");
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

 public function get_count_wallet($tbl,$user_id) {
        $this->db->where('user_id',$user_id);
        $this->db->from($tbl);
        return $this->db->count_all_results();
    }


     public function get_order_data_wallet($limit, $start = 0, $tbl, $user_id)
   {
       if ($start == 0) {
           $query = $this->db->query("SELECT * FROM $tbl WHERE `user_id` = $user_id ORDER BY `created_at` DESC  LIMIT $limit");
       }
       else
       {
           $query = $this->db->query("SELECT * FROM $tbl WHERE `patient_id` = $user_id ORDER BY `added_on` DESC LIMIT $limit OFFSET $start ");
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


    public function get_pagination_data_notify($limit, $start, $tbl,$status) {
        $this->db->limit($limit, $start);
        
        $this->db->order_by("added_on","DESC");
        $this->db->where('type',$status);
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


	 public function get_total_patientdetails($user_id='',$number= '',$start_date='',$end_date= '')
    {
      $r = "SELECT COUNT(*) AS A FROM user WHERE status <> 2";
      if(!empty($user_id))
      {
      	$r.=" AND id = ".$user_id."";
      }
      if(!empty($number))
      {
        $r.=" AND id = ".$number."";
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



    function get_patientdetails_pagination($start = 0, $limit,$user_id='',$number='',$start_date='',$end_date= ''){
        $query = "SELECT * from user where status <> 2  ";
        if ($start == 0)
        {
          if($user_id != '')
          {
              $query.= "AND id = '".$user_id."'";
          }
          if($number != '')
          {
            $query.= " AND id = '".$number."'";
          }
           if(!empty($start_date) && empty($end_date))
          {
              $query.= "AND added_on  = '".$start_date."'";
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
          if($user_id != '')
          {
              $query.= "AND id = '".$user_id."'";
          }
          if($number != '')
          {
            $query.= " AND id = '".$number."'";
          }
           if(!empty($start_date) && empty($end_date))
          {
              $query.= "AND added_on  = '".$start_date."'";
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

    function user_details() {
	 			$query=	$this->db->select('id,name,phone,address');
	 			$query= $this->db->where("status<>","2");
		        $query = $this->db->get('user');
			    $result = $query->result();
			    return $result;
	 }


}
?>