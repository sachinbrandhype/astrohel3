<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Astrologers extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Speedhuntson_m", "c_m");
        $this->load->model("sd/Astrologer_m", "a_m");
        $this->load->library('encryption');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->library('user_agent');
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }
    }






    public function astrologers_position()
    {
        if ($_POST) {
            // print_r($_POST); die;
            $id = $this->input->post("booking_ide");
            $type = $this->input->post("type");
            if ($type == "chat") {
                $data1 = array(
                    "chat_position" => $this->input->post("position"),
                );
            } elseif ($type == "video") {
                $data1 = array(
                    "video_position" => $this->input->post("position"),
                );
            } else {
                $data1 = array(
                    "audio_position" => $this->input->post("position"),
                );
            }

            // print_r($data1); die;
            $s = $this->update_position('astrologers', $id, $data1);
            $this->session->set_flashdata('message', array('message' => 'Astrologer position Update successfully', 'class' => 'success'));
            redirect($this->agent->referrer());
        }
    }

    public function update_position($table, $data, $data1)
    {
        $this->db->where('id', $data);
        $result = $this->db->update($table, $data1);
        return $result;
    }



    public function astologers_position($x = '', $rowno = 1)
    {

        $rowperpage = 30;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }


        // All records count
        $allcount = $this->count_total_astologers_position();
        // Get records
        $s = $this->get_total_astologers_position_paginate($rowno, $rowperpage);
        // echo $this->db->last_query(); die;
        // Pagination Configuration
        $uri = $this->uri->segment(3);
        $config['base_url'] = base_url() . "sd/Astrologers/astologers_position/" . $uri;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $template['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open']     = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']     = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']     = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']     = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']     = '<li class="page-item">';
        $config['next_tagl_close']     = '<span aria-hidden="true">&raquo;</span></li>';
        $config['prev_tag_open']     = '<li class="page-item">';
        $config['prev_tagl_close']     = '</li>';
        $config['first_tag_open']     = '<li class="page-item">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']     = '<li class="page-item">';
        $config['last_tagl_close']     = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        // Initialize
        $this->pagination->initialize($config);
        $language = "SELECT * FROM `language_categories` ORDER BY `language_name` ASC";
        $template['language'] = $this->c_m->get_all_result($language, 'select', '', '');

        $offered = "SELECT * FROM `master_specialization` WHERE type = 2 ORDER BY `name` ASC";
        $template['service_offered'] = $this->c_m->get_all_result($offered, 'select', '', '');

        $specialization = "SELECT * FROM `master_specialization` WHERE type = 1 ORDER BY `name` ASC";
        $template['specialization'] = $this->c_m->get_all_result($specialization, 'select', '', '');

        $template['page'] = "sd/astologers/astologers_position";
        $template['page_title'] = "Add Top Astrologer For Website ";
        $template['links'] = $this->pagination->create_links();

        $template['data'] = $s;
        // print_r($template['list']);die;
        $template['row'] = $rowno;
        $this->load->view('template', $template);
    }




    private function count_total_astologers_position()
    {
        $uri = $this->uri->segment(4);




        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['phone'])) {


            if ($_GET['phone'] != '') {
                $this->db->or_like('phone', $_GET['phone']);
            }
            if ($_GET['name'] != '') {
                $this->db->or_like('name', $_GET['name']);
            }
            if ($_GET['email'] != '') {
                $this->db->or_like('email', $_GET['email']);
            }
            if ($_GET['start_date'] != '') {
                $this->db->where('DATE(added_on) >=', $_GET['start_date']);
            }
            if ($_GET['end_date'] != '') {
                $this->db->where('DATE(added_on) <=', $_GET['end_date']);
            }
        }


        $this->db->select('*');
        $this->db->from('astrologers');
        $this->db->where_in('status', array(1));
        $this->db->where_in('approved', array(1));

        if ($uri == "chat") {
            $this->db->where('chat_status', 1);
            $this->db->order_by('chat_position', 'ASC');
        } elseif ($uri == "video") {
            $this->db->where('video_status', 1);
            $this->db->order_by('video_status', 'ASC');
        } elseif ($uri == "audio") {
            $this->db->where('audio_status', 1);
            $this->db->order_by('audio_status', 'ASC');
        }

        $this->db->group_by('id');
        $query = $this->db->get();
        return count($query->result());
    }

    private function get_total_astologers_position_paginate($start = 0, $limit)
    {

        $uri = $this->uri->segment(4);


        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['phone'])) {
            // $first_date = date('Y-m-d', strtotime($_GET['start_date']));
            // $second_date = date('Y-m-d', strtotime($_GET['end_date']));;
            if ($_GET['phone'] != '') {
                $this->db->or_like('phone', $_GET['phone']);
            }
            if ($_GET['name'] != '') {
                $this->db->or_like('name', $_GET['name']);
            }
            if ($_GET['email'] != '') {
                $this->db->or_like('email', $_GET['email']);
            }
            if ($_GET['start_date'] != '') {
                $this->db->where('DATE(added_on) >=', $_GET['start_date']);
            }
            if ($_GET['end_date'] != '') {
                $this->db->where('DATE(added_on) <=', $_GET['end_date']);
            }
        }

        if ($limit != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->select('*');
        $this->db->from('astrologers');
        $this->db->where_in('status', array(1));
        $this->db->where_in('approved', array(1));

        if ($uri == "chat") {
            $this->db->where('chat_status', 1);
            $this->db->order_by('chat_position', 'ASC');
        } elseif ($uri == "video") {
            $this->db->where('video_status', 1);
            $this->db->order_by('video_status', 'ASC');
        } elseif ($uri == "audio") {
            $this->db->where('audio_status', 1);
            $this->db->order_by('audio_status', 'ASC');
        }




        $query = $this->db->get();
        return $query->result();
    }







    public function astologers_list($x = '', $rowno = 1)
    {
        // print_r($rowno); die;




        if ($_POST) {
            $id = $_POST['pass_id'];
            // print_r( $_POST ); die;
            if ($id) {


                $data_doc = array(
                    'random_password' => $_POST['password'],
                    'password' => md5($_POST['password']),
                );


                $this->db->where('id', $id);
                $result = $this->db->update('astrologers', $data_doc);
                // echo $this->db->last_query(); die;


                $this->session->set_flashdata('message', array('message' => 'Password Updated Successfully', 'class' => 'success'));
                redirect($this->agent->referrer());
            }
        }



        if (isset($_GET['get_export_data'])) {
            $data[] = array("#", "Name", "Email", "Mobile", "Astrologer Experience", "Share Percentage", "Languages", "Speciality", "Service", "Address", "Per Minute Chat Charge", "Per Minute Video Charge", "Per Minute Audio Charge", "In House Astrologers", "Is Premium Astrologer", "Aadhar Number", "Pan Number", "Bank Name", "Bank Account Number", "IFSC Code", "Status", "Area of Expertise", "Biography", "Image", "Added On");
            $acounts = $this->get_total_astologers_paginate(0, '');
            // echo $this->db->last_query(); die;
            $i = 1;
            foreach ($acounts as $user) {
                $added_on = date("d-m-Y", strtotime($user->added_on));

                switch ($user->status) {
                    case '1':
                        $st = "COMPLETE";

                        break;

                    default:
                        $st = "PENDING";
                        $fl = '';

                        break;
                }

                switch ($user->is_premium) {
                    case '1':
                        $is_premium = "Yes";
                        break;

                    default:
                        $is_premium = "No";

                        break;
                }






                $data[] = array(
                    "#" => $i,

                    "name" => $user->name,
                    "email" => $user->email,
                    "mobile" => $user->phone,
                    "experience" => $user->experience,
                    "share_percentage" => $user->share_percentage,
                    "languages" => $user->languages,
                    "price_per_mint_chat" => $user->price_per_mint_chat,
                    "price_per_mint_video" => $user->price_per_mint_video,
                    "price_per_mint_audio" => $user->price_per_mint_audio,
                    "is_premium" => $is_premium,
                    "aadhar_number" => $user->aadhar_number,
                    "pan_number" => $user->pan_number,
                    "bankName" => $user->bankName,
                    "bank_account_no" => $user->bank_account_no,
                    "ifsc_code" => $user->ifsc_code,
                    "status" => $st,
                    "expertise" => $user->expertise,
                    "bio" => $user->bio,
                    "image" => base_url('uploads/astrologers/' . $user->image),
                    "added_on" => $added_on,
                );
                $i++;
            }
            $string_file = date("d-m-Y h:i:s A");
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"astologers" . $string_file . ".csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($data as $data) {
                fputcsv($handle, $data);
            }
            fclose($handle);
            exit;
        }


        // Row per page
        $rowperpage = 30;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }


        // All records count
        $allcount = $this->count_total_astologers();
        // Get records
        $s = $this->get_total_astologers_paginate($rowno, $rowperpage);

        // echo $this->db->last_query(); die;
        // Pagination Configuration
        $uri = $this->uri->segment(3);
        $config['base_url'] = base_url() . "sd/Astrologers/astologers_list/" . $uri;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $template['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open']     = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']     = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']     = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']     = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']     = '<li class="page-item">';
        $config['next_tagl_close']     = '<span aria-hidden="true">&raquo;</span></li>';
        $config['prev_tag_open']     = '<li class="page-item">';
        $config['prev_tagl_close']     = '</li>';
        $config['first_tag_open']     = '<li class="page-item">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']     = '<li class="page-item">';
        $config['last_tagl_close']     = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        // Initialize
        $this->pagination->initialize($config);
        $language = "SELECT * FROM `language_categories` ORDER BY `language_name` ASC";
        $template['language'] = $this->c_m->get_all_result($language, 'select', '', '');

        $offered = "SELECT * FROM `master_specialization` WHERE type = 2 ORDER BY `name` ASC";
        $template['service_offered'] = $this->c_m->get_all_result($offered, 'select', '', '');

        $specialization = "SELECT * FROM `master_specialization` WHERE type = 1 ORDER BY `name` ASC";
        $template['specialization'] = $this->c_m->get_all_result($specialization, 'select', '', '');

        $template['page'] = "sd/astologers/astologers_list";
        $template['page_title'] = "Add Top Astrologer For Website ";
        $template['links'] = $this->pagination->create_links();

        $template['data'] = $s;
        // print_r($template['list']);die;
        $template['row'] = $rowno;

        $template['counter_for_index'] = $rowno;


        $this->load->view('template', $template);
    }





    private function count_total_astologers()
    {
        $uri = $this->uri->segment(4);

        if ($uri == "approved") {
            $status = array(1);
            $approved = array(1);
        } elseif ($uri == "pending") {
            $status = array(0, 1);
            $approved = array(0);
        } elseif ($uri == "disable") {
            $status = array(0);
            $approved = array(1);
        } else {
            $status = array(0, 1);
            $approved = array(0, 1);
        }


        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['phone'])) {


            if ($_GET['phone'] != '') {
                $this->db->or_like('phone', $_GET['phone']);
            }
            if ($_GET['name'] != '') {
                $this->db->or_like('name', $_GET['name']);
            }
            if ($_GET['email'] != '') {
                $this->db->or_like('email', $_GET['email']);
            }
            if ($_GET['start_date'] != '') {
                $this->db->where('DATE(added_on) >=', $_GET['start_date']);
            }
            if ($_GET['end_date'] != '') {
                $this->db->where('DATE(added_on) <=', $_GET['end_date']);
            }
        }


        $this->db->select('*');
        $this->db->from('astrologers');
        $this->db->where_in('status', $status);
        $this->db->where_in('approved', $approved);
        $this->db->group_by('id');
        $query = $this->db->get();
        return count($query->result());
    }


    private function get_total_astologers_paginate($start = 0, $limit)
    {
        // print_r($start); die;

        $uri = $this->uri->segment(4);


        if ($uri == "approved") {
            $status = array(1);
            $approved = array(1);
        } elseif ($uri == "pending") {
            $status = array(0, 1);
            $approved = array(0);
        } elseif ($uri == "disable") {
            $status = array(0);
            $approved = array(1);
        } else {
            $status = array(1);
            $approved = array(1);
        }

        if (isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['name']) || isset($_GET['email']) || isset($_GET['phone'])) {
            // $first_date = date('Y-m-d', strtotime($_GET['start_date']));
            // $second_date = date('Y-m-d', strtotime($_GET['end_date']));;
            if ($_GET['phone'] != '') {
                $this->db->or_like('phone', $_GET['phone']);
            }
            if ($_GET['name'] != '') {
                $this->db->or_like('name', $_GET['name']);
            }
            if ($_GET['email'] != '') {
                $this->db->or_like('email', $_GET['email']);
            }
            if ($_GET['start_date'] != '') {
                $this->db->where('DATE(added_on) >=', $_GET['start_date']);
            }
            if ($_GET['end_date'] != '') {
                $this->db->where('DATE(added_on) <=', $_GET['end_date']);
            }
        }

        if ($limit != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->select('*');
        $this->db->from('astrologers');
        $this->db->where_in('status', $status);
        $this->db->where_in('approved', $approved);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }







    public function astologers_list_pending($rowno = 0)
    {
        $for = $this->uri->segment(5);
        $data = array();
        $astrologer_data = "";
        $astrologer_mode = "";
        if ($this->input->post('submit') != NULL) {
            $astrologer_data = $this->input->post('astrologer_data');
            $astrologer_mode = $this->input->post('astrologer_mode');
            $sess = $this->session->set_userdata(array("astrologer_data" => $astrologer_data, "astrologer_mode" => $astrologer_mode));
        }
        if ($this->input->post('reset') != NULL) {
            unset($_SESSION['astrologer_data'], $_SESSION['astrologer_mode']);
        } else {
            if ($this->session->userdata('astrologer_data') != NULL) {
                $astrologer_data = $this->session->userdata('astrologer_data');
            }
            if ($this->session->userdata('astrologer_mode') != NULL) {
                $astrologer_mode = $this->session->userdata('astrologer_mode');
            }
        }
        $rowperpage = 20;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $total_records = $this->a_m->get_total_astrologers($astrologer_data, $astrologer_mode);
        $template['data'] = $this->a_m->get_astrologers_for_pagination($rowno, $rowperpage, $astrologer_data, $astrologer_mode);
        $config['base_url'] = base_url() . '/sd/astrologers/astologers_list_pending';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $rowperpage;
        $config['cur_tag_open'] = '<a class="current">';
        $choice = $config["total_rows"] / $config["per_page"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $template["links"] = $this->pagination->create_links();
        $template['row'] = $rowno;
        $template['astrologer_data'] = $astrologer_data;
        $template['astrologer_mode'] = $astrologer_mode;
        $template['page'] = "sd/astologers/astologers_list";
        $template['page_title'] = "View Top Astrologer For Website";
        $this->load->view('template', $template);
    }

    public function add_astrologers()
    {
        $language = "SELECT * FROM `language_categories` ORDER BY `language_name` ASC";
        $template['language'] = $this->c_m->get_all_result($language, 'select', '', '');


        $offered = "SELECT * FROM `master_specialization` WHERE type = 2 AND status = 1 ORDER BY `name` ASC";
        $template['service_offered'] = $this->c_m->get_all_result($offered, 'select', '', '');

        $specialization = "SELECT * FROM `master_specialization` WHERE type = 1 AND status = 1 ORDER BY `name` ASC";
        $template['specialization'] = $this->c_m->get_all_result($specialization, 'select', '', '');



        $template['page'] = "sd/astologers/add_astrologer_new";
        $template['page_title'] = "Add Top Astrologer For Website ";
        $this->load->view('template', $template);
    }

    public function check_email_phone($value = '')
    {
        $this->db->where('email', $_POST['email']);
        $this->db->where_in('status', array(1, 0));
        $query = $this->db->get('astrologers');
        if ($query->num_rows()  > 0) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }

    public function insert()
    {
        $random_password = $this->input->post('random_password');
        $md_password = md5($random_password);
        if ($_POST) {
            // print_r($_POST); die;
            $email =  $this->input->post('email');
            $phone = $this->input->post('mobile');
            $check = $this->db->query('SELECT * FROM `astrologers` where status !=2 AND email = "' . $email . '"')->result();
            $check1 = $this->db->query('SELECT * FROM `astrologers` where status !=2 AND phone = "' . $phone . '"')->result();
            if (count($check) > 0) {
                $this->session->set_flashdata('message', array('message' => 'Same email already exist', 'class' => 'danger'));
                redirect(base_url('sd/astrologers/add_astrologers'));
            } elseif (count($check1) > 0) {
                $this->session->set_flashdata('message', array('message' => 'Same phone number already exist', 'class' => 'danger'));
                redirect(base_url('sd/astrologers/add_astrologers'));
            } else {
                // $video_time = '{"mon":' . json_encode($_POST['monday_video']) . ',' . '"tue":' . json_encode($_POST['tuesday_video']) . ',' . '"wed":' . json_encode($_POST['wednesday_video']) . ',' . '"thu":' . json_encode($_POST['thursday_video']) . ',' . '"fri":' . json_encode($_POST['friday_video']) . ',' . '"sat":' . json_encode($_POST['saturday_video']) . ',' . '"sun":' . json_encode($_POST['sunday_video']) . '}';

                if (!empty($this->input->post("languages"))) {
                    $languages = implode('|', $this->input->post("languages"));
                } else {
                    $languages = '';
                }
                // if (!empty($this->input->post("speciality"))) 
                // {
                //     $speciality = implode('|', $this->input->post("speciality"));
                // }
                // else
                // {
                $speciality = '';
                // }
                // if (!empty($this->input->post("service"))) 
                // {
                //     $service = implode('|', $this->input->post("service"));
                // }
                // else
                // {
                $service = '';
                // }
                if (!empty($_FILES['image'])) {
                    $target_path = "uploads/astrologers/";
                    $target_dir = "uploads/astrologers/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time() . "." . $extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                    if (!empty($actual_image_name) && !empty($extension)) {
                        $display_image = $actual_image_name;
                    } else {
                        $display_image = 'default.png';
                    }
                } else {
                    $display_image = 'default.png';
                }

                $price_for_chat = 0;
                if ($this->input->post("price_for_chat")) {
                    $price_for_chat = $this->input->post("price_for_chat");
                }

                $price_for_video = 0;
                if ($this->input->post("price_for_video")) {
                    $price_for_video = $this->input->post("price_for_video");
                }

                $price_for_audio = 0;
                if ($this->input->post("price_for_audio")) {
                    $price_for_audio = $this->input->post("price_for_audio");
                }


                $price_per_mint_chat = 0;
                $chat_status = 0;
                if ($this->input->post("price_per_mint_chat")) {
                    $price_per_mint_chat = $this->input->post("price_per_mint_chat");
                    $chat_status = 1;
                }

                $price_per_mint_video = 0;
                $video_status = 0;
                if ($this->input->post("price_per_mint_video")) {
                    $price_per_mint_video = $this->input->post("price_per_mint_video");
                    $video_status = 1;
                }

                $price_per_mint_audio = 0;
                $audio_status = 0;
                if ($this->input->post("price_per_mint_audio")) {
                    $price_per_mint_audio = $this->input->post("price_per_mint_audio");
                    $audio_status = 1;
                }

                $can_take_horoscope = $this->input->post('can_take_horoscope');
                $horoscope_price = $this->input->post('price_per_mint_broadcast');
                $broadcast_price = $this->input->post('broadcast_price');

                $data_doc = array(
                    'share_percentage' => $this->input->post('share_percentage'),
                    // 'is_home' => $this->input->post('is_home'),
                    // 'present_physically' => $this->input->post('present_physically'),
                    'is_premium' => $this->input->post('is_premium'),
                    'location' => $this->input->post('location'),
                    'status' => $this->input->post('status'),
                    'expertise' => $this->input->post('expertise'),
                    'bankName' => $this->input->post('bankName'),
                    'email' => trim($this->input->post('email')),
                    'password' => $md_password,
                    'random_password' => $this->input->post('random_password'),
                    'name' => $this->input->post('name'),
                    'bio' => $this->input->post('bio'),
                    'image' => $display_image,
                    'experience' => $this->input->post('experience'),
                    // 'online_counsult_time' => $video_time,
                    'phone' => trim($this->input->post('mobile')),
                    'device_id' => '',
                    'device_token' => '',
                    'device_type' => '',
                    // 'is_approval' => $this->input->post('is_approval') ,
                    'aadhar_number' => $this->input->post('aadhar_number'),
                    'pan_number' => $this->input->post('pan_number'),
                    'bank_account_no' => $this->input->post('bank_account_no'),
                    'ifsc_code' => $this->input->post('ifsc_code'),
                    'online_consult' => 4,
                    // 'in_house_astrologers'=>$this->input->post('in_house_astrologers'),
                    'can_take_broadcast' => $this->input->post('can_take_broadcast'),
                    'price_for_chat' => $price_for_chat,
                    'price_for_video' => $price_for_video,
                    'price_for_audio' => $price_for_audio,
                    'price_per_mint_chat' => $price_per_mint_chat,
                    'price_per_mint_video' => $price_per_mint_video,
                    'price_per_mint_audio' => $price_per_mint_audio,

                    'audio_status' => $audio_status,
                    'chat_status' => $chat_status,
                    'video_status' => $video_status,


                    'can_take_horoscope' => $can_take_horoscope,
                    'horoscope_price' => $horoscope_price,
                    'price_per_mint_broadcast' => $broadcast_price,
                    'added_on' => date('Y-m-d H:i:s'),
                    'register_from' => 'admin',
                    'languages' => $languages,
                    // 'speciality'=>"",
                    // 'service'=>"",
                    'added_by' => $this->session->userdata('id')
                );
                $result = $this->a_m->insert_table_data('astrologers', $data_doc);
                // echo $this->db->last_query();die;
                if ($result) {
                    // print_r($this->input->post("price")); die;
                    // print_r($this->input->post("service_offered")); die;
                    if (!empty($this->input->post("service_offered"))) {

                        $service_offered = $this->input->post("service_offered");
                        $i = 0;
                        foreach ($service_offered as $key) {
                            $data_service = array(
                                'user_id' => $result,
                                'speciality_id' => $key,
                                'horoscope_price' => $_POST['price'][$i],
                                'type' => 2,
                                'give_horoscope' => 1,
                            );
                            // print_r($data_service); die;
                            $result_service = $this->a_m->insert_table_data('skills', $data_service);
                            $i++;
                        }
                        //  print_r($service_offered); die;
                    }


                    if (!empty($this->input->post("specialization"))) {
                        $specialization =  $this->input->post("specialization");
                        $c = 0;
                        foreach ($specialization as $key2) {
                            $data_specialization = array(
                                'user_id' => $result,
                                'speciality_id' => $key2,
                                'horoscope_price' => $_POST['specialization_price'][$c],
                                'type' => 1,
                                'give_horoscope' => 1,
                            );
                            $result_specialization = $this->a_m->insert_table_data('skills', $data_specialization);
                            $c++;
                        }
                    }



                    $this->session->set_flashdata('message', array('message' => 'Add Astrologers Details successfully', 'class' => 'success'));
                    redirect(base_url('sd/astrologers/astologers_list_pending'));
                } else {
                    $this->session->set_flashdata('message', array('message' => 'Something went wrong', 'class' => 'danger'));
                    redirect(base_url('sd/astrologers/astologers_list_pending'));
                }
            }
        }
    }

    public function saveAstrologer()
    {
        $data = $_POST;
        // echo "<pre>";
        // print_r($data);die;
        $permissions = $data['permissions'];

        $chat_status = in_array('chat', $permissions) ? 1 : 0;
        $video_status = in_array('audio', $permissions) ? 1 : 0;
        $audio_status = in_array('video', $permissions) ? 1 : 0;;

        // $can_take_horoscope = $permissions == 'report' ? 1 : 0;
        // $can_take_broadcast = $permissions == 'broadcast' ? 1 : 0;

        $can_take_horoscope = in_array('report', $permissions) ? 1 : 0;
        $can_take_broadcast = in_array('broadcast', $permissions) ? 1 : 0;



        $arr = [
            'online_consult' => 0,
            'chat_status' => 0,
            'video_status' => 0,
            'audio_status' => 0
        ];
        if ($chat_status) {
            $online_consult = 1;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'audio_status' => 0,
                'video_status' => 0
            ];
        }
        if ($audio_status) {
            $online_consult = 3;
            $arr = [
                'online_consult' => $online_consult,
                'audio_status' => 1,
                'chat_status' => 0,
                'video_status' => 0
            ];
        }
        if ($video_status) {
            $online_consult = 2;
            $arr = [
                'online_consult' => $online_consult,
                'video_status' => 1,
                'chat_status' => 0,
                'audio_status' => 0,
            ];
        }
        if ($chat_status && $audio_status) {
            $online_consult = 6;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'audio_status' => 1,
                'video_status' => 0
            ];
        }

        if ($chat_status && $video_status) {
            $onlin_consult = 5;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'video_status' => 1,
                'audio_status' => 0
            ];
        }
        if ($video_status && $audio_status) {
            $online_consult = 7;
            $arr = [
                'online_consult' => $online_consult,
                'video_status' => 1,
                'audio_status' => 1,
                'chat_status' => 0
            ];
        }

        if ($video_status && $audio_status && $chat_status) {
            $online_consult = 4;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'video_status' => 1,
                'audio_status' => 1
            ];
        }

        if (!$video_status && !$audio_status && !$chat_status) {
            $online_consult = 0;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 0,
                'video_status' => 0,
                'audio_status' => 0
            ];
        }
        $random_password = $this->input->post('random_password');
        $md_password = md5($random_password);
        if (($_FILES['image']['size'] > 0)) {
            $target_path = "uploads/astrologers/";
            $target_dir = "uploads/astrologers/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imagename = basename($_FILES["image"]["name"]);
            $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
            $actual_image_name = time() . "." . $extension;
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
            if (!empty($actual_image_name) && !empty($extension)) {
                $display_image = $actual_image_name;
            } else {
                $display_image = 'default.png';
            }
        } else {
            $display_image = 'default.png';
        }

        if (($_FILES['aadhar_card_front_image']['size'] > 0)) {
            $target_path = "uploads/astrologers/";
            $target_dir = "uploads/astrologers/";
            $target_file = $target_dir . basename($_FILES["aadhar_card_front_image"]["name"]);
            $aadhar_card_front_imagename = basename($_FILES["aadhar_card_front_image"]["name"]);
            $extension = substr(strrchr($_FILES['aadhar_card_front_image']['name'], '.'), 1);
            $actual_aadhar_card_front_image_name = time() . "." . $extension;
            move_uploaded_file($_FILES["aadhar_card_front_image"]["tmp_name"], $target_path . $actual_aadhar_card_front_image_name);
            if (!empty($actual_aadhar_card_front_image_name) && !empty($extension)) {
                $display_aadhar_card_front_image = $actual_aadhar_card_front_image_name;
            } else {
                $display_aadhar_card_front_image = 'default.png';
            }
        } else {
            $display_aadhar_card_front_image = 'default.png';
        }

        if (($_FILES['pan_card_image']['size'] > 0)) {
            $target_path = "uploads/astrologers/";
            $target_dir = "uploads/astrologers/";
            $target_file = $target_dir . basename($_FILES["pan_card_image"]["name"]);
            $pan_card_imagename = basename($_FILES["pan_card_image"]["name"]);
            $extension = substr(strrchr($_FILES['pan_card_image']['name'], '.'), 1);
            $actual_pan_card_image_name = time() . "." . $extension;
            move_uploaded_file($_FILES["pan_card_image"]["tmp_name"], $target_path . $actual_pan_card_image_name);
            if (!empty($actual_pan_card_image_name) && !empty($extension)) {
                $display_pan_card_image = $actual_pan_card_image_name;
            } else {
                $display_pan_card_image = 'default.png';
            }
        } else {
            $display_pan_card_image = 'default.png';
        }

        $price_per_mint_audio = floatval($this->input->post("price_per_mint_chat"));
        $price_per_mint_video = floatval($this->input->post("price_per_mint_video"));
        $price_per_mint_chat = floatval($this->input->post("price_per_mint_chat"));
        $price_per_mint_broadcast = floatval($this->input->post("broadcast_price"));
        $languages = implode('|', $data['languages']);
        $data_doc = array(
            'aadhar_card_front_image' => $display_aadhar_card_front_image,
            'pan_card_image' => $display_pan_card_image,
            'share_percentage' => $this->input->post('share_percentage'),
            'is_premium' => intval($this->input->post('is_premium')),
            'location' => $this->input->post('location'),
            'address' => $this->input->post('location'),
            'dob' => $this->input->post('dob'),
            'city' => $this->input->post('city'),
            'status' => $this->input->post('status'),
            'gender' => $this->input->post('gender'),
            'expertise' => $this->input->post('expertise'),
            'bankName' => $this->input->post('bankName'),
            'pan_number' => $this->input->post('pan_number'),
            'email' => trim($this->input->post('email')),
            'password' => $md_password,
            'random_password' => $this->input->post('random_password'),
            'name' => $this->input->post('name'),
            // 'award_status' => $this->input->post('award_status') ,

            'bio' => $this->input->post('bio'),
            'image' => $display_image,
            'experience' => $this->input->post('experience'),
            'phone' => trim($this->input->post('phone')),
            'discount' => $this->input->post('discount'),
            'device_id' => '',
            'device_token' => '',
            'device_type' => '',
            'aadhar_number' => $this->input->post('aadhar_number'),
            'pan_number' => $this->input->post('pan_number'),
            'bank_account_no' => $this->input->post('bank_account_no'),
            'ifsc_code' => $this->input->post('ifsc_code'),
            'online_consult' => $arr['online_consult'],
            'online_status' => 0,
            'can_take_broadcast' => $this->input->post('can_take_broadcast'),
            'expertise' => trim($this->input->post('expertise')),
            'price_for_chat' => $price_per_mint_chat,
            'price_for_video' => $price_per_mint_video,
            'price_for_audio' => $price_per_mint_audio,
            'price_per_mint_chat' => $price_per_mint_chat,
            'price_per_mint_video' => $price_per_mint_video,
            'price_per_mint_audio' => $price_per_mint_audio,
            'price_per_mint_broadcast' => $price_per_mint_broadcast,
            'contribute_hours' => intval($this->input->post('contribute_hours')),

            'morning_start_date' => date('H:i',strtotime($this->input->post('morning_start_date'))),
            'morning_end_date' => date('H:i',strtotime($this->input->post('morning_end_date'))),
            'afternoon_start_date' => date('H:i',strtotime($this->input->post('afternoon_start_date'))),     
            'afternoon_end_date' => date('H:i',strtotime($this->input->post('afternoon_end_date'))),
            'evening_start_date' => date('H:i',strtotime($this->input->post('evening_start_date'))),
            'evening_end_date' => date('H:i',strtotime($this->input->post('evening_end_date'))),

            'audio_status' => $arr['audio_status'],
            'chat_status' => $arr['chat_status'],
            'video_status' => $arr['video_status'],
            'can_take_horoscope' => $can_take_horoscope,
            'can_take_broadcast' => $can_take_broadcast,
            'added_on' => date('Y-m-d H:i:s'),
            'register_from' => 'admin',
            'languages' => $languages,
            'experience' => intval($this->input->post('experience')),
            'approved' => intval($data['approved']),
            // 'speciality'=>"",
            // 'service'=>"",
            'added_by' => $this->session->userdata('id')
        );
        // echo "<pre>";
        // print_r($data_doc);die;
        $result = $this->a_m->insert_table_data('astrologers', $data_doc);
        if ($result) {
            if (!empty($this->input->post("service_offered"))) {

                $service_offered = $this->input->post("service_offered");
                foreach ($service_offered as $key) {
                    if (isset($key['id']) && !empty($key['id'])) {
                        $data_service = array(
                            'user_id' => $result,
                            'speciality_id' => $key['id'],
                            'horoscope_price' => floatval($key['price']),
                            'type' => 2,
                            'give_horoscope' => 1,
                        );
                        $this->a_m->insert_table_data('skills', $data_service);
                    }
                }
            }
            if (!empty($this->input->post("specialization"))) {
                $specialization =  $this->input->post("specialization");
                $c = 0;
                foreach ($specialization as $key2) {
                    $data_specialization = array(
                        'user_id' => $result,
                        'speciality_id' => $key2,
                        'horoscope_price' => 0,
                        'type' => 1,
                        'give_horoscope' => 0,
                    );
                    $result_specialization = $this->a_m->insert_table_data('skills', $data_specialization);
                    $c++;
                }
            }
            $this->session->set_flashdata('message', array('message' => 'Add Astrologers Details successfully', 'class' => 'success'));
            // redirect(base_url('sd/astrologers/astologers_list_pending'));
            if ($data_doc['approved'] == 1) {
                redirect(base_url('sd/astrologers/astologers_list/approved'));
            } else {
                redirect(base_url('sd/astrologers/astologers_list_pending'));
            }
        } else {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong', 'class' => 'danger'));
            redirect($this->agent->referrer());
        }
    }



    public function updateAstrologer($astrologer_id = 0)
    {
        // PHP code to get the MAC address of Client
        $MAC = exec('getmac');

        // Storing 'getmac' value in $MAC
        $MAC = strtok($MAC, ' ');

        $data = $_POST;
        // echo "<pre>";
        // print_r($data);
        // die;
        $astrologer = $this->db->get_where('astrologers', ['id' => $astrologer_id])->row();
        $permissions = $data['permissions'];

        $chat_status = in_array('chat', $permissions) ? 1 : 0;
        $video_status = in_array('audio', $permissions) ? 1 : 0;
        $audio_status = in_array('video', $permissions) ? 1 : 0;


        $arr = [
            'online_consult' => 0,
            'chat_status' => 0,
            'video_status' => 0,
            'audio_status' => 0
        ];
        if ($chat_status) {
            $online_consult = 1;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'audio_status' => 0,
                'video_status' => 0
            ];
        }
        if ($audio_status) {
            $online_consult = 3;
            $arr = [
                'online_consult' => $online_consult,
                'audio_status' => 1,
                'chat_status' => 0,
                'video_status' => 0
            ];
        }
        if ($video_status) {
            $online_consult = 2;
            $arr = [
                'online_consult' => $online_consult,
                'video_status' => 1,
                'chat_status' => 0,
                'audio_status' => 0,
            ];
        }
        if ($chat_status && $audio_status) {
            $online_consult = 6;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'audio_status' => 1,
                'video_status' => 0
            ];
        }

        if ($chat_status && $video_status) {
            $onlin_consult = 5;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'video_status' => 1,
                'audio_status' => 0
            ];
        }
        if ($video_status && $audio_status) {
            $online_consult = 7;
            $arr = [
                'online_consult' => $online_consult,
                'video_status' => 1,
                'audio_status' => 1,
                'chat_status' => 0
            ];
        }

        if ($video_status && $audio_status && $chat_status) {
            $online_consult = 4;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 1,
                'video_status' => 1,
                'audio_status' => 1
            ];
        }

        if (!$video_status && !$audio_status && !$chat_status) {
            $online_consult = 0;
            $arr = [
                'online_consult' => $online_consult,
                'chat_status' => 0,
                'video_status' => 0,
                'audio_status' => 0
            ];
        }
        $random_password = $this->input->post('random_password');
        $md_password = md5($random_password);
        if (($_FILES['image']['size'] > 0)) {
            $target_path = "uploads/astrologers/";
            $target_dir = "uploads/astrologers/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imagename = basename($_FILES["image"]["name"]);
            $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
            $actual_image_name = time() . "." . $extension;
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
            if (!empty($actual_image_name) && !empty($extension)) {
                $display_image = $actual_image_name;
            } else {
                $display_image = 'default.png';
            }
        } else {
            $display_image = $astrologer->image;
        }

        if (($_FILES['aadhar_card_front_image']['size'] > 0)) {
            $target_path = "uploads/astrologers/";
            $target_dir = "uploads/astrologers/";
            $target_file = $target_dir . basename($_FILES["aadhar_card_front_image"]["name"]);
            $aadhar_card_front_imagename = basename($_FILES["aadhar_card_front_image"]["name"]);
            $extension = substr(strrchr($_FILES['aadhar_card_front_image']['name'], '.'), 1);
            $actual_aadhar_card_front_image_name = time() . "." . $extension;
            move_uploaded_file($_FILES["aadhar_card_front_image"]["tmp_name"], $target_path . $actual_aadhar_card_front_image_name);
            if (!empty($actual_aadhar_card_front_image_name) && !empty($extension)) {
                $display_aadhar_card_front_image = $actual_aadhar_card_front_image_name;
            } else {
                $display_aadhar_card_front_image = 'default.png';
            }
        } else {
            $display_aadhar_card_front_image = $astrologer->aadhar_card_front_image;
        }


        if (($_FILES['pan_card_image']['size'] > 0)) {
            $target_path = "uploads/astrologers/";
            $target_dir = "uploads/astrologers/";
            $target_file = $target_dir . basename($_FILES["pan_card_image"]["name"]);
            $pan_card_imagename = basename($_FILES["pan_card_image"]["name"]);
            $extension = substr(strrchr($_FILES['pan_card_image']['name'], '.'), 1);
            $actual_pan_card_image_name = time() . "." . $extension;
            move_uploaded_file($_FILES["pan_card_image"]["tmp_name"], $target_path . $actual_pan_card_image_name);
            if (!empty($actual_pan_card_image_name) && !empty($extension)) {
                $display_pan_card_image = $actual_pan_card_image_name;
            } else {
                $display_pan_card_image = 'default.png';
            }
        } else {
            $display_pan_card_image = $astrologer->pan_card_image;
        }


        $price_per_mint_audio = floatval($this->input->post("price_per_mint_chat"));
        $price_per_mint_video = floatval($this->input->post("price_per_mint_video"));
        $price_per_mint_chat = floatval($this->input->post("price_per_mint_chat"));
        $price_per_mint_broadcast = floatval($this->input->post("broadcast_price"));
        $languages = implode('|', $data['languages']);


        // $can_take_horoscope = $permissions == 'report' ? 1 : 0;
        // $can_take_broadcast = $permissions == 'broadcast' ? 1 : 0;
        $can_take_horoscope = in_array('report', $permissions) ? 1 : 0;
        $can_take_broadcast = in_array('broadcast', $permissions) ? 1 : 0;
        // print_r($can_take_horoscope); die;
        $data_doc = array(
            'aadhar_card_front_image' => $display_aadhar_card_front_image,
            'pan_card_image' => $display_pan_card_image,
            'share_percentage' => $this->input->post('share_percentage'),
            'is_premium' => intval($this->input->post('is_premium')),
            'location' => $this->input->post('location'),
            'address' => $this->input->post('location'),

            'dob' => $this->input->post('dob'),
            'city' => $this->input->post('city'),
            'status' => $this->input->post('status'),
            'gender' => $this->input->post('gender'),
            'expertise' => trim($this->input->post('expertise')),
            'bankName' => $this->input->post('bankName'),
            'pan_number' => $this->input->post('pan_number'),
            'email' => trim($this->input->post('email')),
            'password' => $md_password,
            'random_password' => $this->input->post('random_password'),
            'contribute_hours' => intval($this->input->post('contribute_hours')),
            'name' => $this->input->post('name'),
            // 'award_status' => $this->input->post('award_status') ,
            'bio' => $this->input->post('bio'),
            'image' => $display_image,
            'phone' => trim($this->input->post('phone')),
            'discount' => trim($this->input->post('discount')),
            'device_id' => '',
            'device_token' => '',
            'device_type' => '',
            'aadhar_number' => $this->input->post('aadhar_number'),
            'pan_number' => $this->input->post('pan_number'),
            'bank_account_no' => $this->input->post('bank_account_no'),
            'ifsc_code' => $this->input->post('ifsc_code'),
            'online_consult' => $arr['online_consult'],
            'online_status' => 0,
            // 'can_take_broadcast'=>$this->input->post('can_take_broadcast'),
            'price_for_chat' => $price_per_mint_chat,
            'price_for_video' => $price_per_mint_video,
            'price_for_audio' => $price_per_mint_audio,
            'price_per_mint_chat' => $price_per_mint_chat,
            'price_per_mint_video' => $price_per_mint_video,
            'price_per_mint_audio' => $price_per_mint_audio,
            'price_per_mint_broadcast' => $price_per_mint_broadcast,
            'audio_status' => $arr['audio_status'],
            'chat_status' => $arr['chat_status'],
            'video_status' => $arr['video_status'],
            'can_take_horoscope' => $can_take_horoscope,
            'can_take_broadcast' => $can_take_broadcast,
            'added_on' => date('Y-m-d H:i:s'),
            'register_from' => 'admin',
            'languages' => $languages,
            'experience' => intval($this->input->post('experience')),
            'approved' => intval($data['approved']),
            // 'speciality'=>"",
            // 'service'=>"",
            'added_by' => $this->session->userdata('id'),

            'morning_start_date' => date('H:i',strtotime($this->input->post('morning_start_date'))),
            'morning_end_date' => date('H:i',strtotime($this->input->post('morning_end_date'))),
            'afternoon_start_date' => date('H:i',strtotime($this->input->post('afternoon_start_date'))),     
            'afternoon_end_date' => date('H:i',strtotime($this->input->post('afternoon_end_date'))),
            'evening_start_date' => date('H:i',strtotime($this->input->post('evening_start_date'))),
            'evening_end_date' => date('H:i',strtotime($this->input->post('evening_end_date'))),

            'ip_address' => $this->input->ip_address(),
            'upadted_by' => "admin",
            'update_type' => "update",
            'update_date' => date("d-m-Y h:i:s A"),
            'system_address' => $MAC
        );
        // echo "<pre>";
        // print_r($data_doc);die;
        $this->db->where('id', $astrologer_id);
        $result = $this->db->update('astrologers', $data_doc);
        if ($result) {
            $this->db->where('user_id', $astrologer_id);
            $this->db->delete('skills');
            if (!empty($this->input->post("service_offered"))) {

                $service_offered = $this->input->post("service_offered");
                foreach ($service_offered as $key) {
                    if (isset($key['id']) && !empty($key['id'])) {
                        $data_service = array(
                            'user_id' => $astrologer_id,
                            'speciality_id' => $key['id'],
                            'horoscope_price' => floatval($key['price']),
                            'type' => 2,
                            'give_horoscope' => 1,
                        );
                        $this->a_m->insert_table_data('skills', $data_service);
                    }
                }
                //  print_r($service_offered); die;
            }
            if (!empty($this->input->post("specialization"))) {
                $specialization =  $this->input->post("specialization");
                $c = 0;

                foreach ($specialization as $key2) {
                    $data_specialization = array(
                        'user_id' => $astrologer_id,
                        'speciality_id' => $key2,
                        'horoscope_price' => 0,
                        'type' => 1,
                        'give_horoscope' => 0,
                    );
                    $result_specialization = $this->a_m->insert_table_data('skills', $data_specialization);
                    $c++;
                }
            }
            $this->session->set_flashdata('message', array('message' => 'Update Astrologers Details successfully', 'class' => 'success'));
            if ($data_doc['approved'] == 1) {
                redirect(base_url('sd/astrologers/astologers_list/approved'));
            } else {
                redirect(base_url('sd/astrologers/astologers_list_pending'));
            }
        } else {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong', 'class' => 'danger'));
            redirect($this->agent->referrer());
        }
    }


    public function approval_astrologers()
    {
        if ($_POST) {
            $approval_id =  $this->input->post("approval_id");
            $data = array("approved" => 1);
            $create = $this->c_m->get_all_result($data, 'update', 'astrologers', array('id' => $approval_id));
            if ($create) {
                // $doc_detail = $this->db->get_where("doctor",array("id"=>$approval_id))->row();
                // $image = base_url()."/uploads/mail_template_/diskuss.jpg";
                // $subject = "DISKUSS ONBOARDING CONFIRMATION";
                // $message = "DISKUSS ONBOARDING CONFIRMATION";
                // $mail_message= "Dear Sir,<br><br> With reference to your request to provide Online Consultation at DISKUSS, we are pleased to confirm that your request has been approved and activated.<br><br>Please ensure that you strictly follow the Consultation Online times you have agreed upon.<br><br>We look forward to a fruitful and long lasting relationship and once again welcome you to be a core team of Experts at DISKUSS.<br><br><br>Best Regards<br>OnBoarding Team<br>DISCUSS<br>www.diskussit.com";
                // $title1 = "Your approval Doctor Account";
                // $this->check_curl($doc_detail->email,$subject,$mail_message,$doc_detail->doctor_firstname); 
                // $selected_android_user1 = array();
                // if($doc_detail->deviceType == 'android')
                // {   
                //     if($doc_detail->deviceToken!='abc')
                //     {
                //       array_push($selected_android_user1, $doc_detail->deviceToken);
                //     }

                // }
                // if(count($selected_android_user1))
                // {
                //     $notification_type1 = "text";
                //     $respJson1 = '{"notification_type":"'.$notification_type1.'","title":"'.$title1.'","msg":"'.$message.'","image":"'.$image.'","type":"no"}';
                //     //$message = array("m" => $respJson, "click_action"=>"SecondActivity");
                //     $message2 = array(
                //             'body' => $message,
                //             'title' => $title1,
                //             'image' => $image,
                //             'sound' => 'default'
                //         );
                //     // print_r($message2); die;
                //   $a = $this->sendMessageThroughFCM_1($selected_android_user1,$message2);
                // }
                $this->session->set_flashdata('message', array('message' => 'Update Successfully', 'class' => 'success'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function astrologer_status($id, $status)
    {
        // $id = $this->uri->segment(4);
        // $status = $this->uri->segment(5);

        // PHP code to get the MAC address of Client
        $MAC = exec('getmac');

        // Storing 'getmac' value in $MAC
        $MAC = strtok($MAC, ' ');

        if ($status == 1) {

            $data_astro = array(
                'ip_address' => $this->input->ip_address(),
                'upadted_by' => "admin",
                'update_type' => "enabled",
                'update_date' => date("d-m-Y h:i:s A"),
                'system_address' => $MAC
            );

            $a = 'enabled';
            $class = 'success';
        } elseif ($status == 0) {
            $data_astro = array(
                'ip_address' => $this->input->ip_address(),
                'upadted_by' => "admin",
                'update_type' => "disabled",
                'update_date' => date("d-m-Y h:i:s A"),
                'system_address' => $MAC
            );

            $a = 'disabled';
            $class = 'success';
        } elseif ($status == 2) {
            $data_astro = array(
                'ip_address' => $this->input->ip_address(),
                'upadted_by' => "admin",
                'update_type' => "deleted",
                'update_date' => date("d-m-Y h:i:s A"),
                'system_address' => $MAC
            );


            $a = 'deleted';
            $class = 'success';
        }
        $this->db->where('id', $id);
        $upd = $this->db->update('astrologers', ['status' => $status]);

        $result = $this->a_m->update_table_data($id, 'astrologers', $data_astro);

        //    echo $upd;die;
        // $s = $this->db->query("UPDATE `astrologers` SET `status`='$status' WHERE `id`='$id'");
        if ($upd) {
            $this->session->set_flashdata('message', array(
                'message' => 'Astrologer Successfully ' . $a,
                'class' => $class
            ));
        } else {
            $this->session->set_flashdata('message', array(
                'message' => 'Something went wrong',
                'class' => 'danger'
            ));
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function doctor_active()

    {
        $data1 = array(
            "status" => '1'
        );
        $id = $this->uri->segment(3);
        $s = $this->Doctordetail_model->update_doctor_status($id, $data1);
        $this->session->set_flashdata('message', array(
            'message' => 'Doctor Successfully Enabled',
            'class' => 'success'
        ));
        redirect($_SERVER['HTTP_REFERER']);
        //redirect(base_url('Doctordetail_ctrl/view_doctordetails'));
    }





    public function pdf_astrologer()
    {

        $id = htmlentities(trim($this->uri->segment(4)));
        $template["astrologer_id"] = $id;
        // print_r($id); die;
        $get_details = $this->db->get_where('astrologers', array("id" => $id))->row();
        if ($get_details) {

            // print_r($get_details); die;
            $pdf_data = array();
            $pdf_data['id'] = $get_details->id;
            $pdf_data['name'] = $get_details->name;
            $pdf_data['email'] = $get_details->email;
            $pdf_data['experience'] = $get_details->experience;
            $pdf_data['location'] = $get_details->location;
            $pdf_data['share_percentage'] = $get_details->share_percentage;
            $pdf_data['mobile'] = $get_details->phone;
            $pdf_data['aadhar_number'] = $get_details->aadhar_number;
            $pdf_data['pan_number'] = $get_details->pan_number;
            $pdf_data['bank_account_no'] = $get_details->bank_account_no;
            $pdf_data['ifsc_code'] = $get_details->ifsc_code;
            $pdf_data['languages'] = $get_details->languages;
            $pdf_data['speciality'] = $get_details->speciality;
            $pdf_data['service'] = $get_details->service;
            $pdf_data['expertise'] = $get_details->expertise;
            $pdf_data['in_house_astrologers'] = $get_details->in_house_astrologers;
            $pdf_data['is_premium'] = $get_details->is_premium;
            $pdf_data['price_per_mint_chat'] = $get_details->price_per_mint_chat;
            $pdf_data['price_per_mint_video'] = $get_details->price_per_mint_video;
            $pdf_data['price_per_mint_audio'] = $get_details->price_per_mint_audio;
            $pdf_data['image'] = $get_details->image;
            $pdf_data['status'] = $get_details->status;

            $pdf_data['added_on'] = date('d/m/Y', strtotime($get_details->added_on));
            // print_r($pdf_data);die;
            $htmlcode = $this->load->view('sd/astologers/astologer_pdf', $pdf_data, TRUE);
            // print_r($htmlcode);
            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('LOL');
            $pdf->SetTitle('Ambulance');
            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            if (@file_exists(dirname(_FILE_) . '/lang/eng.php')) {
                require_once(dirname(_FILE_) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->AddPage();
            $htmlcode = $this->load->view('sd/astologers/astologer_pdf', $pdf_data, TRUE);
            $pdf_data['order_number'] = time();
            $pdf->writeHTML($htmlcode, true, false, true, false, '');
            $newFile  = FCPATH . "/assets/uploads/astologer_pdf/" . $pdf_data['order_number'] . '-invoice.pdf';
            ob_clean();
            $pdf->Output($newFile, 'I');
            $pdffname = $pdf_data['order_number'] . '-invoice.pdf';

            //print_r($newFile); die;
            return $pdffname;
        } else {
            return false;
        }
    }





    public function edit_astrologers()
    {
        $language = "SELECT * FROM `language_categories` ORDER BY `language_name` ASC";
        $template['language'] = $this->c_m->get_all_result($language, 'select', '', '');

        $offered = "SELECT * FROM `master_specialization` WHERE type = 2 AND status = 1 ORDER BY `name` ASC";
        $template['service_offered'] = $this->c_m->get_all_result($offered, 'select', '', '');

        $specialization = "SELECT * FROM `master_specialization` WHERE type = 1 AND status = 1 ORDER BY `name` ASC";
        $template['specialization'] = $this->c_m->get_all_result($specialization, 'select', '', '');



        $id = htmlentities(trim($this->uri->segment(4)));
        $template["astrologer_id"] = $id;
        $skills = $this->db->get_where('skills', ['user_id' => $id])->result();;

        $skills_arr = [];
        if (!empty($skills)) {
            foreach ($skills as $sk) {
                $skills_arr[] = $sk->speciality_id;
            }
        }
        //     echo "<pre>";
        //    print_r($template['specialization']);die;
        $template['skills_arr'] = $skills_arr;

        $template['page'] = "sd/astologers/edit_astrologer_new";
        $template['page_title'] = "Edit Astrologer Details";
        $template['data'] = $astrologer = $this->db->get_where('astrologers', array("id" => $id))->row();
        $template['astrologer'] = $astrologer;
        $this->load->view('template', $template);
    }

    public function edit_astrologers_details()
    {
        $random_password = $this->input->post('random_password');
        $md_password = md5($random_password);
        if ($_POST) {
            // print_r($_POST); die;
            $astro_id = $this->input->post('astro_id');
            // $video_time = '{"mon":' . json_encode($_POST['monday_video']) . ',' . '"tue":' . json_encode($_POST['tuesday_video']) . ',' . '"wed":' . json_encode($_POST['wednesday_video']) . ',' . '"thu":' . json_encode($_POST['thursday_video']) . ',' . '"fri":' . json_encode($_POST['friday_video']) . ',' . '"sat":' . json_encode($_POST['saturday_video']) . ',' . '"sun":' . json_encode($_POST['sunday_video']) . '}';

            if (!empty($this->input->post("languages"))) {
                $languages = implode('|', $this->input->post("languages"));
            } else {
                $languages = '';
            }


            // if (!empty($this->input->post("speciality"))) 
            //    {
            //        $speciality = implode('|', $this->input->post("speciality"));
            //    }
            //    else
            //    {
            //        $speciality = '';
            //    }
            //    if (!empty($this->input->post("service"))) 
            //    {
            //        $service = implode('|', $this->input->post("service"));
            //    }
            //    else
            //    {
            $service = '';
            // }


            $price_for_chat = 0;
            if ($this->input->post("price_for_chat")) {
                $price_for_chat = $this->input->post("price_for_chat");
            }

            $price_for_video = 0;
            if ($this->input->post("price_for_video")) {
                $price_for_video = $this->input->post("price_for_video");
            }

            $price_for_audio = 0;
            if ($this->input->post("price_for_audio")) {
                $price_for_audio = $this->input->post("price_for_audio");
            }


            $price_per_mint_chat = 0;
            $chat_status = 0;
            if ($this->input->post("price_per_mint_chat")) {
                $price_per_mint_chat = $this->input->post("price_per_mint_chat");
                $chat_status = 1;
            }

            $price_per_mint_video = 0;
            $video_status = 0;
            if ($this->input->post("price_per_mint_video")) {
                $price_per_mint_video = $this->input->post("price_per_mint_video");
                $video_status = 1;
            }

            $price_per_mint_audio = 0;
            $audio_status = 0;
            if ($this->input->post("price_per_mint_audio")) {
                $price_per_mint_audio = $this->input->post("price_per_mint_audio");
                $audio_status = 1;
            }

            // $online_consult = $this->input->post('online_consult');
            $can_take_horoscope = $this->input->post('can_take_horoscope');
            $horoscope_price = $this->input->post('horoscope_price');
            $broadcast_price = $this->input->post('broadcast_price');
            //     if ($this->input->post('is_approval') == 0) 
            //     {
            //         $online_consult = 0;
            //         $price_per_mint_chat = 0;
            //         $price_per_mint_video = 0;
            //         $price_per_mint_audio = 0;
            //         $price_for_audio = 0;
            //         $price_for_video = 0;
            //         $price_for_chat = 0;


            //         $can_take_horoscope = 0;
            //         $horoscope_price = 0;
            //     }
            // elseif ($this->input->post('is_approval') == 2) 
            // {
            //     $online_consult = 0;

            //     $price_for_audio = 0;
            //     $price_for_video = 0;
            //     $price_for_chat = 0;

            // }
            $old_img = $this->input->post('image11');
            $id = $this->uri->segment(4);
            if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
                $target_path = "uploads/astrologers/";
                $target_dir = "uploads/astrologers/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time() . "." . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                if (!empty($actual_image_name) && !empty($extension)) {
                    $display_image = $actual_image_name;
                } else {
                    $display_image = 'default.png';
                }
            } else {
                $display_image = $old_img;
            }
            $data_astro = array(
                'share_percentage' => $this->input->post('share_percentage'),
                // 'present_physically' => $this->input->post('present_physically'),
                'location' => $this->input->post('location'),
                'status' => $this->input->post('status'),
                'expertise' => $this->input->post('expertise'),
                'bankName' => $this->input->post('bankName'),
                'email' => trim($this->input->post('email')),
                'password' => $md_password,
                'random_password' => $this->input->post('random_password'),
                'name' => $this->input->post('name'),
                'bio' => $this->input->post('bio'),
                'image' => $display_image,
                'experience' => $this->input->post('experience'),
                // 'online_counsult_time' => $video_time,
                'phone' => trim($this->input->post('phone')),
                // 'is_approval' => $this->input->post('is_approval') ,
                'aadhar_number' => $this->input->post('aadhar_number'),
                'pan_number' => $this->input->post('pan_number'),
                'bank_account_no' => $this->input->post('bank_account_no'),
                'ifsc_code' => $this->input->post('ifsc_code'),
                'online_consult' => 4,
                // 'in_house_astrologers'=>$this->input->post('in_house_astrologers'),
                'can_take_broadcast' => $this->input->post('can_take_broadcast'),
                'is_premium' => $this->input->post('is_premium'),
                'price_for_chat' => $price_for_chat,
                'price_for_video' => $price_for_video,
                'price_for_audio' => $price_for_audio,
                'price_per_mint_chat' => $price_per_mint_chat,
                'price_per_mint_video' => $price_per_mint_video,
                'price_per_mint_audio' => $price_per_mint_audio,

                'audio_status' => $audio_status,
                'chat_status' => $chat_status,
                'video_status' => $video_status,


                'can_take_horoscope' => $can_take_horoscope,
                'horoscope_price' => $horoscope_price,
                'price_per_mint_broadcast' => $broadcast_price,
                'languages' => $languages,
                // 'speciality'=>$speciality,
                //         'service'=>$service,
            );
            $result = $this->a_m->update_table_data($astro_id, 'astrologers', $data_astro);

            if ($result) {
                if (!empty($this->input->post("service_offered"))) {
                    $this->db->where('user_id', $astro_id);
                    $this->db->where('type', 2);
                    $this->db->delete('skills');
                    $service_offered = $this->input->post("service_offered");
                    $i = 0;
                    foreach ($service_offered as $key) {
                        $data_service = array(
                            'user_id' => $astro_id,
                            'speciality_id' => $key,
                            'horoscope_price' => $_POST['price'][$i],
                            'type' => 2,
                            'give_horoscope' => 1,
                        );
                        $result_service = $this->a_m->insert_table_data('skills', $data_service);
                        $i++;
                    }
                }


                if (!empty($this->input->post("specialization"))) {
                    $this->db->where('user_id', $astro_id);
                    $this->db->where('type', 1);
                    $this->db->delete('skills');

                    $specialization =  $this->input->post("specialization");
                    $c = 0;
                    foreach ($specialization as $key2) {
                        $data_specialization = array(
                            'user_id' => $astro_id,
                            'speciality_id' => $key2,
                            'horoscope_price' => $_POST['specialization_price'][$c],
                            'type' => 1,
                            'give_horoscope' => 1,
                        );
                        $result_specialization = $this->a_m->insert_table_data('skills', $data_specialization);
                        $c++;
                    }
                }
            }

            $template['data'] = $this->a_m->get_single_($astro_id);
            $this->session->set_flashdata('message', array(
                'message' => 'Astrologers Details Updated Successfully',
                'class' => 'success'
            ));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function a_view($id)
    {
        $template['page'] = "sd/astologers/profile";
        $template['page_title'] = "View Astrologers Details";
        // $id = htmlentities(trim($this->uri->segment(4)));
        $template["astrologer_id"] = $id;
        $template['astrologer']  = $astrologer = $this->db->get_where('astrologers', array("id" => $id, "status !=" => 2))->row();
        if (!$astrologer) {
            $this->session->set_flashdata('message', array(
                'message' => 'Astrologer not found',
                'class' => 'danger'
            ));
            redirect($this->agent->referrer());
        }

        $skills = $this->db->get_where('skills', ['user_id' => $id])->result();;

        $skills_arr = [];
        $all_skills_arr = [];
        $profession = '';
        if (!empty($skills)) {
            foreach ($skills as $sk) {
                $skills_arr[] = $sk->speciality_id;
                $spclty = $this->db->get_where('master_specialization', ['id' => $sk->speciality_id])->row();
                if ($sk->type == 1) {
                    $profession .= $spclty ? ($spclty->name) . ', ' : '';
                }
                $sk->name = $spclty ? ($spclty->name) : '';
                $all_skills_arr[] = $sk;
            }
        }
        $template['all_skills_arr'] = $all_skills_arr;

        $this->db->where('astrologer_id', $id);
        $template['total_followers'] = $total_followers =  $this->db->count_all_results('followers');

        $this->db->where('assign_id', $id);
        $this->db->where('status', 2);
        $this->db->where('type', 1);
        $this->db->where('booking_type', 2);
        $template['total_video_calls']  =  $this->db->count_all_results('bookings');

        $this->db->where('assign_id', $id);
        $this->db->where('status', 2);
        $this->db->where('type', 2);
        $this->db->where('booking_type', 2);
        $template['total_audio_calls']  = $this->db->count_all_results('bookings');

        $this->db->where('assign_id', $id);
        $this->db->where('status', 2);
        $this->db->where('type', 3);
        $this->db->where('booking_type', 2);
        $template['total_chat_calls']  =  $this->db->count_all_results('bookings');

        $this->db->where('assign_id', $id);
        $this->db->where('status', 2);
        $this->db->where('type', 4);
        $this->db->where('booking_type', 2);
        $template['total_report_calls']  =  $this->db->count_all_results('bookings');

        $this->db->where('astrologer_id', $id);
        $this->db->where('status', 2);
        $template['total_lives']  =  $this->db->count_all_results('broadcasts');

        $this->db->where('astrologer_id', $id);
        // $this->db->where('status',2);
        $template['total_gifts']  =  $this->db->count_all_results('send_gifts');

        $this->db->where('assign_id', $id);
        $this->db->where('status', 2);
        $this->db->where('type', 5);
        $this->db->where('booking_type', 2);
        $template['total_live_joiners']  =  $this->db->count_all_results('bookings');

        $this->db->where('assign_id', $id);
        $this->db->where('status', 2);
        $this->db->where('booking_type', 2);
        $template['total_client_served']  =  $this->db->count_all_results('bookings');

        $bk = $this->db->query("Select SUM(total_minutes) as total from bookings WHERE booking_type = 2 AND assign_id=$id")->row_array();
        $template['total_booking_minutes']  =  $bk['total'] ? $bk['total'] :  0;

        $bk2 = $this->db->query("Select SUM(total_minutes) as total from broadcasts WHERE status = 2 AND astrologer_id=$id")->row_array();
        $template['total_live_minutes']  =  $bk2['total'] ? $bk2['total'] :  0;

        $bk = $this->db->query("Select SUM(astrologer_comission_amount) as total from bookings WHERE booking_type = 2 AND assign_id=$id")->row_array();
        $template['total_astrologer_earning']  =  $bk['total'] ? $bk['total'] :  0;

        $template['profession'] = rtrim($profession, ', ');
        $template['skills_arr'] = $skills_arr;

        $this->db->order_by('id', 'desc');
        $reviews = $this->db->get_where('reviews', ['type' => 2, 'type_id' => $id])->result();
        $template['reviews'] = $reviews;

        $template['data'] = $this->a_m->get_single_($id);
        $this->load->view('template', $template);
    }

    public function ajaxCheckIfAstroEmailPhoneExists()
    {
        if ($_POST) {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $this->db->where('email', trim($email));
            $emaildata = $this->db->get_where('astrologers', [])->row();

            $this->db->where('phone', trim($phone));
            $phonedata = $this->db->get_where('astrologers', [])->row();
            if ($emaildata && $phonedata) {
                echo json_encode([
                    'status' => true,
                    'message' => 'Email address & Phone number already exists',
                ]);
            } elseif ($emaildata) {
                echo json_encode([
                    'status' => true,
                    'message' => 'Email address',
                ]);
            } elseif ($phonedata) {
                echo json_encode([
                    'status' => true,
                    'message' => 'Phone number address',
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => '',
                ]);
            }
        }
    }

    public function ajaxCheckIfAstroPhoneExists()
    {
        if ($_POST) {
            $email = $_POST['phone'];
            $this->db->where('phone', trim($email));
            $data = $this->db->get_where('astrologers', [])->row();
            echo json_encode([
                'status' => $data ? true : false,
                'message' => '',
                'data' => $data
            ]);
        }
    }


    public function astologers_list_verified($rowno = 0)
    {
        $for = $this->uri->segment(5);
        $data = array();
        $astrologer_data = "";
        $astrologer_mode = "";
        if ($this->input->post('submit') != NULL) {
            $astrologer_data = $this->input->post('astrologer_data');
            $astrologer_mode = $this->input->post('astrologer_mode');
            $sess = $this->session->set_userdata(array("astrologer_data" => $astrologer_data, "astrologer_mode" => $astrologer_mode));
        }
        if ($this->input->post('reset') != NULL) {
            unset($_SESSION['astrologer_data'], $_SESSION['astrologer_mode']);
        } else {
            if ($this->session->userdata('astrologer_data') != NULL) {
                $astrologer_data = $this->session->userdata('astrologer_data');
            }
            if ($this->session->userdata('astrologer_mode') != NULL) {
                $astrologer_mode = $this->session->userdata('astrologer_mode');
            }
        }
        $rowperpage = 20;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $total_records = $this->a_m->get_total_astrologers_verified($astrologer_data, $astrologer_mode);
        $template['data'] = $this->a_m->get_astrologers_for_pagination_verified($rowno, $rowperpage, $astrologer_data, $astrologer_mode);
        $config['base_url'] = base_url() . '/sd/astrologers/astologers_list_verified';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $rowperpage;
        $config['cur_tag_open'] = '<a class="current">';
        $choice = $config["total_rows"] / $config["per_page"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $template["links"] = $this->pagination->create_links();
        $template['row'] = $rowno;
        $template['astrologer_data'] = $astrologer_data;
        $template['astrologer_mode'] = $astrologer_mode;
        $template['page'] = "sd/astologers/astologers_list";
        $template['page_title'] = "View Astologers";
        $this->load->view('template', $template);
    }

    public function astologers_list_disabled($rowno = 0)
    {
        $for = $this->uri->segment(5);
        $data = array();
        $astrologer_data = "";
        $astrologer_mode = "";
        if ($this->input->post('submit') != NULL) {
            $astrologer_data = $this->input->post('astrologer_data');
            $astrologer_mode = $this->input->post('astrologer_mode');
            $sess = $this->session->set_userdata(array("astrologer_data" => $astrologer_data, "astrologer_mode" => $astrologer_mode));
        }
        if ($this->input->post('reset') != NULL) {
            unset($_SESSION['astrologer_data'], $_SESSION['astrologer_mode']);
        } else {
            if ($this->session->userdata('astrologer_data') != NULL) {
                $astrologer_data = $this->session->userdata('astrologer_data');
            }
            if ($this->session->userdata('astrologer_mode') != NULL) {
                $astrologer_mode = $this->session->userdata('astrologer_mode');
            }
        }
        $rowperpage = 20;
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $total_records = $this->a_m->get_total_astrologers_disable($astrologer_data, $astrologer_mode);
        $template['data'] = $this->a_m->get_astrologers_for_pagination_disable($rowno, $rowperpage, $astrologer_data, $astrologer_mode);
        $config['base_url'] = base_url() . '/sd/astrologers/astologers_list_disabled';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $rowperpage;
        $config['cur_tag_open'] = '<a class="current">';
        $choice = $config["total_rows"] / $config["per_page"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $template["links"] = $this->pagination->create_links();
        $template['row'] = $rowno;
        $template['astrologer_data'] = $astrologer_data;
        $template['astrologer_mode'] = $astrologer_mode;
        $template['page'] = "sd/astologers/astologers_list";
        $template['page_title'] = "View Astologers";
        $this->load->view('template', $template);
    }
}
