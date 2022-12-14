<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Astrologer_m extends CI_Model {
 
    function __construct() 
    {
    parent::__construct();
 		$this->load->library('encryption');
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

	   public function get_total_astrologers($astrologer_data='',$astrologer_mode= '')
    {
	    $r = "SELECT COUNT(*) AS A FROM astrologers WHERE approved = 0 AND status IN(1, 0)" ;
	    if(!empty($astrologer_data))
	    {
	      	$r.=" AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
	    }
	    if(!empty($astrologer_mode))
	    {
	        $r.=" AND online_consult = ".$astrologer_mode."";
	    }
	    $query = $this->db->query($r)->row();
        return $query->A;
    }

    function get_astrologers_for_pagination($start = 0, $limit,$astrologer_data='',$astrologer_mode=''){
        $query = "SELECT * from astrologers where approved = 0 AND status IN(1, 0) ";
        if ($start == 0)
        {
          if($astrologer_data != '')
          {
              $query.= " AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
          }
          if($astrologer_mode != '')
          {
            $query.= " AND online_consult = ".$astrologer_mode."";
          }
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($astrologer_data != '')
          {
              $query.= " AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
          }
          if($astrologer_mode != '')
          {
            $query.= " AND online_consult = ".$astrologer_mode."";
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

    public function get_total_astrologers_verified($astrologer_data='',$astrologer_mode= '')
    {
      $r = "SELECT COUNT(*) AS A FROM astrologers WHERE approved = 1 AND status = 1" ;
      if(!empty($astrologer_data))
      {
          $r.=" AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
      }
      if(!empty($astrologer_mode))
      {
          $r.=" AND online_consult = ".$astrologer_mode."";
      }
      $query = $this->db->query($r)->row();
        return $query->A;
    }

    function get_astrologers_for_pagination_verified($start = 0, $limit,$astrologer_data='',$astrologer_mode=''){
        $query = "SELECT * from astrologers where approved = 1 AND status = 1";
        if ($start == 0)
        {
          if($astrologer_data != '')
          {
              $query.= " AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
          }
          if($astrologer_mode != '')
          {
            $query.= " AND online_consult = ".$astrologer_mode."";
          }
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($astrologer_data != '')
          {
              $query.= " AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
          }
          if($astrologer_mode != '')
          {
            $query.= " AND online_consult = ".$astrologer_mode."";
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

    public function get_total_astrologers_disable($astrologer_data='',$astrologer_mode= '')
    {
      $r = "SELECT COUNT(*) AS A FROM astrologers WHERE approved = 1 AND status = 0" ;
      if(!empty($astrologer_data))
      {
          $r.=" AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
      }
      if(!empty($astrologer_mode))
      {
          $r.=" AND online_consult = ".$astrologer_mode."";
      }
      $query = $this->db->query($r)->row();
        return $query->A;
    }

    function get_astrologers_for_pagination_disable($start = 0, $limit,$astrologer_data='',$astrologer_mode=''){
        $query = "SELECT * from astrologers where approved = 1 AND status = 0";
        if ($start == 0)
        {
          if($astrologer_data != '')
          {
              $query.= " AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
          }
          if($astrologer_mode != '')
          {
            $query.= " AND online_consult = ".$astrologer_mode."";
          }
            $query.=" ORDER BY id DESC LIMIT $limit";
            $q = $this->db->query($query);
        }
        else
        {
          if($astrologer_data != '')
          {
              $query.= " AND name = '".$astrologer_data."' OR  email  = '".$astrologer_data."' OR mobile  = '".$astrologer_data."'";
          }
          if($astrologer_mode != '')
          {
            $query.= " AND online_consult = ".$astrologer_mode."";
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

    public function insert_table_data($table,$data)
 	{	
        $this->db->insert($table, $data);
        $result=$this->db->insert_id();
        return $result;
	}

   public function update_table_data($id,$table,$data)
  { 
    $query =  $this->db->where('id', $id);
         $result = $query->update($table, $data);
         return $result;
    
  }

  public function get_single_($id){
    $this->db->where('id',$id);
    $query = $this->db->get('astrologers');
    $result = $query->row();
    return $result;  
  }

}