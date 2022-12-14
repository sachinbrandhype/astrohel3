<?php
class Horoscope_model extends CI_Model
{
    private $horoscope_matching_booking = "horoscope_matching_booking";
    public function _consruct()
    {
        parent::_construct();
    }

    public function fetch_bookings($rowno, $rowperpage, $search = "", $sortBy = "", $order = "",$user_id = "", $today = 0, $status = 0)
    {

        if (!empty($user_id)) {
            $this->db->where('b.user_id', $user_id);
        }

        // if (!empty($status)) {
            if ($status == 0) { /** new booking */
                // $this->db->where_in('b.status', [3, 4]);
                $this->db->where('b.status', 0);
            } elseif ($status == 1) { /** complete */
                $this->db->where('b.status', 1);
            } elseif($status == 2) { /*** cancel bookings */
                $this->db->where_in('b.status', [2,3,4]);
            }elseif($status == 3) { /*** All bookings */
                $this->db->where_in('b.status', [0,1,2,3,4]);
            }
        // }

        if (!empty($today)) {
            if ($today == 1) {
                $date = date('Y-m-d');
                $this->db->where('DATE(b.added_on)', $date);
            } elseif ($today == 2) {
                $datetime = new DateTime('tomorrow');
                $date = $datetime->format('Y-m-d');
                $this->db->where('DATE(b.added_on)', $date);
            }
        }
        $this->db->select("b.*,u.name,u.email,u.phone");
        $this->db->from("$this->horoscope_matching_booking as b");
        $this->db->join('user u', 'b.user_id = u.id');
        $this->db->order_by("b.$sortBy", $order);

        if ($search != '') {
            $this->db->like('b.id', $search);
            $this->db->or_like('b.added_on', $search);
        }

        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();

        $res = $query->result();

        return $res;
    }

    public function count_bookings($search = '', $user_id = 0, $today = 0, $status = 0)
    {
        if (!empty($user_id)) {
            $this->db->where('b.user_id', $user_id);
        }
        if (!empty($status)) {
            if ($status == 0) { /** new booking */
                // $this->db->where_in('b.status', [3, 4]);
                $this->db->where('b.status', 0);
            } elseif ($status == 1) { /** complete */
                $this->db->where('b.status', 1);
            } elseif($status == 2) { /*** cancel bookings */
                $this->db->where_in('b.status', [2,3,4]);
            }
        }
        if (!empty($today)) {
            if ($today == 1) {
                $date = date('Y-m-d');
                $this->db->where('DATE(b.added_on)', $date);
            } elseif ($today == 2) {
                $datetime = new DateTime('tomorrow');
                $date = $datetime->format('Y-m-d');
                $this->db->where('DATE(b.added_on)', $date);
            }
        }
        $this->db->select('count(*) as allcount');
        $this->db->from("$this->horoscope_matching_booking as b");
        $this->db->join('user u', 'b.user_id = u.id');
        if ($search != '') {
            $this->db->like('b.id', $search);
            $this->db->or_like('b.added_on', $search);
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->allcount;
    }
}
