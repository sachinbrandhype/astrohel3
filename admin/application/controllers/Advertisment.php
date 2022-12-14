<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Advertisment extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Doctordetail_model');
        $this->load->model('Affiliated_model','h');
        $this->load->model("Speedhuntson_m","c_m");
        $this->load->helper('directory');
        $this->load->library('pagination');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }
    }
    public function advertisment_mange()

    {


        $config = array();
        $config["base_url"] = base_url() . "Advertisment/advertisment_mange";
        $config["total_rows"] = $this->c_m->get_count('articles');
        //print_r($config["total_rows"]);die;
        $config['per_page'] = 50;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
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
        $template['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $template['list'] = $this->c_m->get_pagination_advertisment($config["per_page"],$template['page'],'articles');
        $template["links"] = $this->pagination->create_links();


        // $query = 'SELECT * FROM `articles`  WHERE `status`="1" ';
  //        $template['list'] = $this->c_m->get_all_result($query,'select','','');

        $template['page'] = "Advertisment/advertisment_mange";
        $template['page_title'] = "View advertisment_mange";
                
        $this->load->view('template', $template);
    }

    public function add_advertisment_mange11()
    {

        if ($_POST) 
        {

            $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        //print_r(expression)
            if ((($_FILES['file']["type"] == "video/mp4") || ($_FILES['file']["type"] == "audio/mp3") || ($_FILES['file']["type"] == "audio/wma") || ($_FILES['file']["type"] == "image/pjpeg") || ($_FILES['file']["type"] == "image/gif") || ($_FILES['file']["type"] == "image/jpeg") || ($_FILES['file']["type"] == "image/png") || ($_FILES['file']["type"] == "image/jpg")) && in_array($extension, $allowedExts))
            {

                if($_FILES['file']["type"] == "video/mp4"){
                     /* uploading directory */
                    $type ="Video";
                    $uploaddir = "uploads/article/video/";
                    $uploadfile = $uploaddir . time()."-".basename($_FILES['file']['name']);
                }elseif($_FILES['file']["type"] == "image/jpeg" || $_FILES['file']["type"] == "image/jpg" || $_FILES['file']["type"] == "image/png" ){
                   
                     /* uploading directory */
                     $type ="Image";
                     $uploaddir = "uploads/article/image/";
                     $uploadfile = $uploaddir . time()."-".basename($_FILES['file']['name']);
                }
          
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        
                    $img=$uploadfile;

                        $array = array(
                            "title"=>$this->input->post("title"),
                            "type"=>$type,
                            "file"=>$img,
                            "added_on"=>date('Y-m-d H:i:s'),
                            "status"=>1,
                            "added_by"=>$_SESSION['id'],
                            );

                      // print_r($array);die;

                       $this->db->insert('articles',$array);
                       $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("Advertisment/advertisment_mange");
                    }
                }
                elseif($_POST['file'])
                {
        print_r($_FILES);die;    

                    $type ="Url";
                    $uploadfile = $this->input->post("file");
                      $array = array(
                            "title"=>$this->input->post("title"),
                            "type"=>$type,
                            "file"=>$uploadfile,
                            "added_on"=>date('Y-m-d H:i:s'),
                            "status"=>1,
                            "added_by"=>$_SESSION['id'],
                            );
                        $this->db->insert('articles',$array);
                        $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("Advertisment/advertisment_mange");
                }
                else
                {
                    echo "dsafds";die;
                }
            
               

            }
        
       
        $template['page'] = "Advertisment/add_advertisment_mange";
        $template['page_title'] = "Add Advertisment Mange";
        $this->load->view('template', $template);
    }

    public function add_advertisment_mange()
    {

        if ($_POST) 
        {
            if(!empty($_POST['file']))
                    {
                            //print_r("files");die;

                            $type ="Url";
                            $uploadfile = $this->input->post("file");
                              $array = array(
                                    "title"=>$this->input->post("title"),
                                    "type"=>$type,
                                    "file"=>$uploadfile,
                                    "added_on"=>date('Y-m-d H:i:s'),
                                    "description"=>$this->input->post("description"),
                                    "status"=>1,
                                    "added_by"=>$_SESSION['id'],
                                    );
                                $this->db->insert('articles',$array);
                                $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                                redirect("Advertisment/advertisment_mange");
                    }

            $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if((($_FILES['file']["type"] == "video/mp4") || ($_FILES['file']["type"] == "audio/mp3") || ($_FILES['file']["type"] == "audio/wma") || ($_FILES['file']["type"] == "image/pjpeg") || ($_FILES['file']["type"] == "image/gif") || ($_FILES['file']["type"] == "image/jpeg") || ($_FILES['file']["type"] == "image/png") || ($_FILES['file']["type"] == "image/jpg")) && in_array($extension, $allowedExts)){

                if($_FILES['file']["type"] == "video/mp4")
                {
                    //print_r("Video"); die;
                   
                    $type ="Video";
                    $uploaddir = "uploads/article/video/";
                    $uploadfile = $uploaddir . time()."-".basename($_FILES['file']['name']);
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
                     $array = array(
                                "title"=>$this->input->post("title"),
                                "type"=>$type,
                                "file"=>$uploadfile,
                                "description"=>$this->input->post("description"),
                                "added_on"=>date('Y-m-d H:i:s'),
                                "status"=>1,
                                "added_by"=>$_SESSION['id'],
                                );
                    $image_upload = $this->db->insert('articles',$array);

                    if($image_upload)
                    {
                    
                        $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("Advertisment/advertisment_mange");
                    }
                    else
                    {
                        $this->session->set_flashdata('delete', 'Something Went Wrong');
                        redirect("Advertisment/advertisment_mange");
                    }
                }
                elseif($_FILES['file']["type"] == "image/jpeg" || $_FILES['file']["type"] == "image/jpg" || $_FILES['file']["type"] == "image/png" )
                {
                      // print_r("Image"); die;
           
                    $type ="Image";
                    $config['upload_path']          = 'uploads/article/image/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['max_size']             = '';
                    $config['max_width']            = '';
                    $config['max_height']           = '';
                    $upload_dir                     = 'uploads/article/image/';
                    $upload_dir_thumbs              = 'uploads/article/image/thumbnail';    
                 
                    $this->load->library('upload', $config);
                    $imageUpload = [];
                    $number_of_files = count($_FILES['file']['name']);
                     // print_r($number_of_files);die;
                    if(isset($_FILES['file']['name'][0]) && !empty($_FILES['file']['name'][0]))
                    {
                       
                        $_FILES['file']['name']     = $_FILES['file']['name'];
                        $_FILES['file']['type']     = $_FILES['file']['type'];
                        $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'];
                        $_FILES['file']['error']     = $_FILES['file']['error'];
                        $_FILES['file']['size']     = $_FILES['file']['size'];
                        if ( ! $this->upload->do_upload('file'))
                        {
                            $error = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('delete', 'Image does not upload');
                            redirect("Advertisment/advertisment_mange");
                        }
                        else
                        {
                           
                            $fileName = base_url('uploads/article/image').'/'.$this->upload->data('file_name');
                            $sourceProperties = getimagesize($fileName);
                            $resizeFileName = $this->upload->data('file_name');
                            $uploadPath = "uploads/article/image/";
                            $fileExt = pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION);
                            $uploadImageType = $sourceProperties[2];
                            $sourceImageWidth = $sourceProperties[0];
                            $sourceImageHeight = $sourceProperties[1];
                            // print_r($sourceProperties);die;
                            switch ($uploadImageType) {
                            case IMAGETYPE_JPEG:
                                $resourceType = imagecreatefromjpeg($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagejpeg($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_GIF:
                            // echo "AwerwerSddddd";die;
                                $resourceType = imagecreatefromgif($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagegif($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_PNG:
                                $resourceType = imagecreatefrompng($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagepng($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                // print_r($upload_dir_thumbs."/".$resizeFileName);die;
                                break;

                            default:
                            // echo "AewtrwSddddd";die;

                                $imageProcess = 0;
                                break;
                            }
                            // echo "ASddddd";die;


                            // move_uploaded_file($file, $uploadPath.'/'.$resizeFileName. ".". $fileExt);
                            $fileName1 = $this->upload->data('file_name');
                            // $pro_image[] = $fileName1;
                        }
                
               
                        $array = array(
                                "title"=>$this->input->post("title"),
                                "description"=>$this->input->post("description"),
                                "type"=>$type,
                                "file"=>$fileName1,
                                "added_on"=>date('Y-m-d H:i:s'),
                                "status"=>1,
                                "added_by"=>$_SESSION['id'],
                                );
                        $image_upload = $this->db->insert('articles',$array);
                        if($image_upload)
                        {
                            
                            $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                            redirect("Advertisment/advertisment_mange");
                        }
                        else
                        {
                            $this->session->set_flashdata('delete', 'Something Went Wrong');
                            redirect("Advertisment/advertisment_mange");
                        }
                    } 
            
                            
                       
                  
                }
                
                
            }



        }
        
       
        $template['page'] = "Advertisment/add_advertisment_mange";
        $template['page_title'] = "Add Advertisment Mange";
        $this->load->view('template', $template);
    }




    public function edit_advertisment_mange()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        if($_POST) {
            // print_r($_POST); die;
            // print_r($_FILES);;die;
            $old_img = $this->input->post('image11');
            $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if($_POST['file'])
            {
                $type ="Url";
                $uploadfile = $this->input->post("file");
                $array = array(
                            "title"=>$this->input->post("title"),
                            "type"=>$type,
                            "file"=>$uploadfile,
                            "description"=>$this->input->post("description"),
                            "added_by"=>$_SESSION['id'],
                            );
                    $create = $this->c_m->get_all_result($array,'update','articles',array('id'=>$id));
                        $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("Advertisment/advertisment_mange");
            }else{


                 if($_FILES['file']["type"] == "video/mp4" && in_array($extension, $allowedExts))
                {
                     /* uploading directory */
                    $type ="Video";
                    $uploaddir = "uploads/article/video/";
                    $fileName1 = $uploaddir . time()."-".basename($_FILES['file']['name']);
                    move_uploaded_file($_FILES['file']['tmp_name'], $fileName1);
                   
                }
                elseif($_FILES['file']["type"] == "image/jpeg" || $_FILES['file']["type"] == "image/png" || $_FILES['file']["type"] == "image/jpg" )
                {
                    $type ="Image";

                    if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
                    {
                        $config['upload_path']          = 'uploads/article/image/';
                        $config['allowed_types']        = 'gif|jpg|png';
                        $config['max_size']             = '';
                        $config['max_width']            = '';
                        $config['max_height']           = '';
                        $this->load->library('upload', $config);
                        $imageUpload = [];
                        if ( ! $this->upload->do_upload('file'))
                        {
                            echo "Adsasd";die;
                            $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $filename = $this->input->post('image11');
                            $fileName = base_url('uploads/article/image/').$this->upload->data('file_name');
                            $sourceProperties = getimagesize($fileName);
                            $resizeFileName = $this->upload->data('file_name');
                            $uploadPath = "uploads/article/image/";
                            $upload_dir_thumbs = "uploads/article/image/thumbnail/";
                            $fileExt = pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION);
                            $uploadImageType = $sourceProperties[2];
                            $sourceImageWidth = $sourceProperties[0];
                            $sourceImageHeight = $sourceProperties[1];

                            switch ($uploadImageType) {
                            case IMAGETYPE_JPEG:
                                $resourceType = imagecreatefromjpeg($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagejpeg($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_GIF:
                                $resourceType = imagecreatefromgif($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagegif($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            case IMAGETYPE_PNG:
                                $resourceType = imagecreatefrompng($fileName); 
                                $imageLayer = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                                imagepng($imageLayer,$upload_dir_thumbs."/".$resizeFileName);
                                break;

                            default:
                                $imageProcess = 0;
                                break;
                            }
                            // move_uploaded_file($file, $uploadPath.'/'.$resizeFileName. ".". $fileExt);
                            $fileName1 = $this->upload->data('file_name');
                            
                        }
                 
                    }
                }

                if($fileName1 == ''){
                    $array = array(
                            "title"=>$this->input->post("title")
                            );
                }else{
                     $array = array(
                            "title"=>$this->input->post("title"),
                            "type"=>$type,
                            "description"=>$this->input->post("description"),
                            "file"=>$fileName1
                            );
                }
                    $image_upload = $this->c_m->get_all_result($array,'update','articles',array('id'=>$id));
                     $this->session->set_flashdata('message', array('message' => 'Add Successfully','class' => 'success'));
                        redirect("Advertisment/advertisment_mange");
            }
            
          
        }
                
          $query = "SELECT * FROM `articles` WHERE `id` = '$id'";
          $template['list'] = $this->c_m->get_all_result($query,'single_row','','');
          $template['page'] = "Advertisment/edit_advertisment_mange";
          $template['page_title'] = "Edit Ambulance";
          $this->load->view('template',$template);
        }
    





    public function delete_advertisment_mange()
    {
        $id = htmlentities(trim($this->uri->segment(3)));
        $array = array("status"=>2);
        $create = $this->c_m->get_all_result($array,'update','articles',array('id'=>$id));
        if ($create) {
           // $this->session->set_flashdata('delete','Delete Successfully...');
            $this->session->set_flashdata('message', array('message' => 'Delete Successfully','class' => 'success')); 
            redirect("Advertisment/advertisment_mange");  
        }
        else
        {
           // $this->session->set_flashdata('err','Something went wrong please try again...');
             $this->session->set_flashdata('message', array('message' => 'Something went wrong please try again...','class' => 'danger')); 
            redirect("Advertisment/advertisment_mange");
        }
    }

    public function resizeImage($resourceType,$image_width,$image_height) {
        $resizeWidth = 200;
        $resizeHeight = 200;
        $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
        $white = imagecolorallocatealpha($imageLayer, 255, 255, 255, 120);
        imagefill($imageLayer, 0, 0, $white);
        imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
        return $imageLayer;
    }

    
}
?>