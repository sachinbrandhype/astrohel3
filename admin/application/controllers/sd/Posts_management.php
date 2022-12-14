<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_management extends CI_Controller{

	function __construct () {
		parent::__construct();
		$this->load->model("Speedhuntson_m","c_m");
		$this->load->library('encryption');
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->library('user_agent');
		$this->load->library('session');
        if(!$this->session->userdata('logged_in')) 
        { 
            redirect(base_url());
        }
	}

    

    public function posts()
    {
        
        if($_POST){
            // print_r($_FILES); die;
            $data = $_POST;
            if(isset($data['save_category']))
            {
                $target_path = "uploads/post/"; 
                $target_dir = "uploads/post/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imagename = basename($_FILES["image"]["name"]);
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);

                // $target_file_file = $target_dir . basename($_FILES["video_file"]["name"]);
                // $imagename = basename($_FILES["video_file"]["name"]);
                // $extension_file = substr(strrchr($_FILES['video_file']['name'], '.'), 1);
                // $actual_file_name = time().".".$extension_file;
                // move_uploaded_file($_FILES["video_file"]["tmp_name"],$target_path.$actual_file_name);
                // print_r($actual_file_name); die;
                if(!empty($actual_image_name) && !empty($extension))
                {
                    $array = array(
                      "thumbnail"=>$actual_image_name,
                      // "media"=>$actual_file_name,
                       "astrologer_id"=>$this->input->post("astrologer_id"),   
                      "name"=>$this->input->post("name"),                         
                      "description"=>$this->input->post("description"),                         
                      "status"=>$this->input->post("status"),                         
                      "media_type"=>3,                         
                          );
                    $this->db->insert('posts',$array);
                    // echo $this->db->last_query(); die;
                    $this->session->set_flashdata('message', array('message' => 'Successfully Done','class' => 'success'));
                    redirect($this->agent->referrer());
                    
                }
                else
                {
                    $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                    redirect($this->agent->referrer());
                }
                
            }
            elseif (isset($data['update_category'])) 
            {   
                $id = $data['id'];

                  if (!empty($_FILES['image']['name'])) 
                {
                    $target_path = "uploads/post/"; 
                    $target_path = "uploads/post/"; 
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imagename = basename($_FILES["image"]["name"]);
                    $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                    $actual_image_name = time().".".$extension;
                    move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                }
                else{
                      $actual_image_name = $this->input->post("old_image");
                }
                //   if (!empty($_FILES['video_file']['name'])) 
                // {
                //    $target_path = "uploads/post/"; 
                //     $target_path = "uploads/post/"; 
                //     $target_file = $target_dir . basename($_FILES["video_file"]["name"]);
                //     $imagename = basename($_FILES["video_file"]["name"]);
                //     $extension = substr(strrchr($_FILES['video_file']['name'], '.'), 1);
                //     $actual_file_name = time().".".$extension;
                //     move_uploaded_file($_FILES["video_file"]["tmp_name"],$target_path.$actual_file_name);
                // }
                // else{
                //       $actual_file_name = $this->input->post("old_video");
                // }



                
                    $array = array(  
                    
                       "thumbnail"=>$actual_image_name,
                      // "media"=>$actual_file_name,
                      "astrologer_id"=>$this->input->post("astrologer_id"),                         
                      "name"=>$this->input->post("name"),                         
                      "description"=>$this->input->post("description"),                         
                      "status"=>$this->input->post("status")                         


                      ,);
                    $create = $this->c_m->get_all_result($array,'update','posts',array('id'=>$id));
                    $this->session->set_flashdata('message', array('message' => 'Successfully Updated','class' => 'success'));
                    redirect($this->agent->referrer());
               
            }
            else
            {
                $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
                redirect($this->agent->referrer());
            }
        }

        $query = 'SELECT * FROM `posts` WHERE `status` <> "2" ORDER BY `id` ASC';
        $template['list'] = $this->c_m->get_all_result($query,'select','','');
     
        $query1 = 'SELECT * FROM `astrologers` WHERE `status` <> "2" ORDER BY `id` ASC';
        $template['astrologers_list'] = $this->c_m->get_all_result($query1,'select','','');
     
        $template['page'] = "sd/app_management/posts";
        $template['page_title'] = "Post";
        $this->load->view('template',$template);
    }

    public function delete_posts()
    {
        $id = htmlentities(trim($this->uri->segment(4)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','posts',array('id'=>$id));
        if ($create) 
        {
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully!','class' => 'success'));
            redirect($this->agent->referrer());   
        }
        else
        {
            $this->session->set_flashdata('message', array('message' => 'Something went wrong','class' => 'warning'));
            redirect($this->agent->referrer());
        }
    }

    public function approval_post()
    {
       if ($_POST) 
       {   
            $approval_id =  $this->input->post("approval_id");
            $data = array("approved"=>1);
            $create = $this->c_m->get_all_result($data,'update','posts',array('id'=>$approval_id));
            if ($create) 
            {
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
                $this->session->set_flashdata('message', array('message' => 'Approvae Successfully','class' => 'success')); 
                redirect($_SERVER['HTTP_REFERER']);
            }   
      }
    }
}