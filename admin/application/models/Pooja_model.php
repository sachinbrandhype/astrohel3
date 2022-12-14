<?php 
class Pooja_model extends CI_Model {
	public function _consruct(){
		parent::_construct();
 	}

     public function get_pooja_categories()
     {
         $this->db->order_by('position','ASC');
         return $this->db->get_where('pooja_category',['status'=>1])->result();
     }


     public function get_all_pooja_categories()
     {
         $this->db->where_in('status',[0,1]);
         $this->db->order_by('position','ASC');
         return $this->db->get('pooja_category')->result();
     }

     public function get_all_pooja_venues()
     {
        $this->db->select('pv.*,p.name as puja_name');
        $this->db->from('pooja_venus_list pv');
        $this->db->where_in('pv.status',[0,1]);
        $this->db->join('puja p', 'p.id = pv.puja_id');
        $query = $this->db->get();
         return $query->result();
     }
     public function get_all_pooja_yajmans()
     {
        $this->db->select('pv.*,p.name as puja_name');
        $this->db->from('pooja_yajman_list pv');
        $this->db->where_in('pv.status',[0,1]);
        $this->db->join('puja p', 'p.id = pv.puja_id');
        $query = $this->db->get();
         return $query->result();
     }

     public function is_already_link_this_location($puja_id=0,$location_id=0,$ignore_id=0)
     {
        //  $this->db->where_in('status',[0,1]);
        if(!empty($ignore_id)){
            $this->db->where_not_in('id',[$ignore_id]);
        }
         $r = $this->db->get_where('puja_location_table',['puja_id'=>$puja_id,'location_id'=>$location_id,'status !='=>2])->row();
         return $r ? $r : false;
     }


     public function get_all_pooja_locations_link($puja_id=0)
     {
        $this->db->select('pl.*,p.name as puja_name,l.name as location_name');
        $this->db->from('puja_location_table pl');
        $this->db->where_in('pl.status',[0,1]);
        $this->db->where('pl.puja_id',$puja_id);
        $this->db->join('puja p', 'p.id = pl.puja_id');
        $this->db->join('puja_location l', 'l.id = pl.location_id');

        $query = $this->db->get();
         return $query->result();
     }

     public function get_pooja_location_link_data($location_id)
     {
        $this->db->select('pl.*,l.name as location_name');
        $this->db->from('puja_location_table pl');
        $this->db->where('pl.id',$location_id);
        $this->db->join('puja_location l', 'l.id = pl.location_id');

        $query = $this->db->get();
         return $query->row();
     }

    public function get_all_pooja_venues_link($location_id=0)
    {
        return $this->db->get_where('puja_venue_table',['location_id'=>$location_id,'status !='=>2])->result();
    }


     public function get_pooja_locations()
     {
         return $this->db->get_where('puja_location',['status'=>1])->result();
     }

     public function get_all_pooja_locations()
     {
        $this->db->where_in('status',[0,1]);
         return $this->db->get('puja_location')->result();
     }

     public function get_poojas()
     {
         $this->db->where_in('status',[0,1]);
         $this->db->order_by('id','DESC');
         return $this->db->get('puja')->result();
     }


     public function get_active_poojas()
     {
         $this->db->where('status',1);
         $this->db->order_by('id','DESC');
         return $this->db->get('puja')->result();
     }


     public function record_count_pooja() {
        if (isset($_GET['search'])) {
            $search = trim($_GET['search']);
            if($search !== ''){
                $this->db->like('name',$search);

            }
        }
         $this->db->where_in('status',[0,1]);
        return $this->db->count_all("puja");
    }

    public function fetch_poojas($limit, $start) {

        if (isset($_GET['search'])) {
            $search = trim($_GET['search']);
            if($search !== ''){
                $this->db->like('name',$search);

            }
        }
        $this->db->limit($limit, $start);
        $this->db->where_in('status',[0,1]);
        $this->db->order_by('id','DESC');
        $query = $this->db->get("puja");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
}