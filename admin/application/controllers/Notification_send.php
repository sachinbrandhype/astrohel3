<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;


use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

class Notification_send extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set("Asia/Kolkata");
    $this->load->model('Patient_model');
    $this->load->library('pagination');
    if (!$this->session->userdata('logged_in')) {
      redirect(base_url());
    }
  }





  public function userList()
  {

    if (!empty($_POST["keyword"])) {
      $query = "SELECT * FROM user WHERE name like '" . $_POST["keyword"] . "%'  or phone like '" . $_POST["keyword"] . "%' or email like '" . $_POST["keyword"] . "%' ORDER BY name LIMIT 0,25";
      $result = $this->db->query($query)->result_array();
      // echo $this->db->last_query(); die;
      // print_r($result);
      if (!empty($result)) {
?>
        <ul id="country-list">
          <?php
          foreach ($result as $user_d) {

          ?>
            <li onClick="selectCountry('<?php echo $user_d["id"] . "_" . $user_d["name"] . "(" . $user_d["phone"] . ")"; ?>');"><?php echo $user_d["name"] . "(" . $user_d["phone"] . ")"; ?></li>
          <?php } ?>
        </ul>
      <?php }
    }
  }

  public function astrologerList()
  {

    if (!empty($_POST["keyword"])) {
      $query = "SELECT * FROM astrologers WHERE name like '" . $_POST["keyword"] . "%'  or phone like '" . $_POST["keyword"] . "%' or email like '" . $_POST["keyword"] . "%' ORDER BY name LIMIT 0,25";
      $result = $this->db->query($query)->result_array();
      // print_r($result);
      if (!empty($result)) {
      ?>
        <ul id="country-list">
          <?php
          foreach ($result as $user_d) {

          ?>
            <li onClick="selectCountry('<?php echo $user_d["id"] . "_" . $user_d["name"] . "(" . $user_d["phone"] . ")"; ?>');"><?php echo $user_d["name"] . "(" . $user_d["phone"] . ")"; ?></li>
          <?php } ?>
        </ul>
<?php }
    }
  }



  //mail


  public function send_mail()
  {
    $template['page'] = "Notification/send_single_mail";
    $template['page_title'] = "Send Single Mail";
    $this->load->view('template', $template);
  }

  public function send_mail_to_all()
  {
    $template['page'] = "Notification/send_mail_to_all";
    $template['page_title'] = "Send Mail to All";
    $this->load->view('template', $template);
  }

  public function send_single_mail_astrologer()
  {
    $template['page'] = "Notification/send_single_mail_astrologer";
    $template['page_title'] = "Send Single Notification";
    $this->load->view('template', $template);
  }



  public function send_mail_to_all_astrologer()
  {
    $template['page'] = "Notification/send_mail_to_all_astrologer";
    $template['page_title'] = "Send Notification to All";
    $this->load->view('template', $template);
  }


  public function send_mail_to_all_supervisor()
  {
    $template['page'] = "Notification/send_mail_to_all_supervisor";
    $template['page_title'] = "Send Notification to All";
    $this->load->view('template', $template);
  }


  public function send_mail_to_all_priest()
  {
    $template['page'] = "Notification/send_mail_to_all_priest";
    $template['page_title'] = "Send Notification to All";
    $this->load->view('template', $template);
  }







  // Notification


  public function send_single()
  {
    $template['page'] = "Notification/send_single_notification";
    $template['page_title'] = "Send Single Notification";
    $this->load->view('template', $template);
  }

  public function send_single_astrologer()
  {
    $template['page'] = "Notification/single_astrologer_notification";
    $template['page_title'] = "Send Single Notification";
    $this->load->view('template', $template);
  }

  public function send_single_supervisor()
  {
    $template['page'] = "Notification/single_supervisor_notification";
    $template['page_title'] = "Send Single Notification";
    $this->load->view('template', $template);
  }

  public function send_single_priest()
  {
    $template['page'] = "Notification/single_priest_notification";
    $template['page_title'] = "Send Single Notification";
    $this->load->view('template', $template);
  }

  public function send_to_all()
  {
    $template['page'] = "Notification/send_all_notification";
    $template['page_title'] = "Send Notification to All";
    $this->load->view('template', $template);
  }

  public function send_to_all_astrologer()
  {
    $template['page'] = "Notification/send_all_astrologer_notification";
    $template['page_title'] = "Send Notification to All";
    $this->load->view('template', $template);
  }


  public function send_to_all_supervisor()
  {
    $template['page'] = "Notification/send_all_supervisor_notification";
    $template['page_title'] = "Send Notification to All";
    $this->load->view('template', $template);
  }


  public function send_to_all_priest()
  {
    $template['page'] = "Notification/send_all_priest_notification";
    $template['page_title'] = "Send Notification to All";
    $this->load->view('template', $template);
  }




  public function send_single_notification()
  {
    // print_r($_POST); die;
    if (!empty($_POST)) {
      if (!empty($_FILES['image'])) {
        $config['upload_path'] = 'uploads/notification/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $imageUpload = '';
        if (!$this->upload->do_upload('image')) {
          $error = array(
            'error' => $this->upload->display_errors()
          );
          $display_image = 'default.png';
        } else {
          $imageUpload = $this->upload->data();
          $display_image = $imageUpload['file_name'];
        }
      }

      $image =      base_url("uploads/notification") . "/" . $display_image;
      $message = $this->input->post('message');
      $title = $this->input->post('title');
      $selected_android_user1 = array();
      $selected_ios_user1 = array();

      $user_id = $_POST['name_id'];
      $device_token = $this->db->query("SELECT * FROM `user` WHERE status = 1 AND  device_token !='' AND id = $user_id")->row();
      // echo $this->db->last_query(); die;
      if ($device_token->device_type == 'android') {
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","image":"' . $image . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'image' => $image,
          'sound' => 'Default',
          'type' => $this->input->post('type'),
          'link' => $this->input->post('link'),
        );
        $a = $this->sendMessageThroughFCM([$device_token->device_token], $message2, 1);
      } else {
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'sound' => 'Default',
          'type' => $this->input->post('type'),
          'link' => $this->input->post('link'),
        );
        $a = $this->send_ios_notification([$device_token->device_token], $message2, "ios");
      }
      $insert_array = array(
        'user_id' => $user_id,
        'user_type' => 1,
        'status' => 1,
        'read' => 0,
        'title' => $title,
        'image' => $image,
        'notification' => $message,
        'type' => 'admin',
        'added_on' => date('Y-m-d H:i:s')
      );
      // print_r($insert_array);die;

      $insert = $this->db->insert('user_notification', $insert_array);
      // echo $this->db->last_query(); die;
      $this->session->set_flashdata('message', array('message' => 'Notification sent successfully.', 'class' => 'success'));
      redirect($this->agent->referrer());
    }
  }



  public function send_single_mail()
  {
    // print_r($_POST); die;
    if (!empty($_POST)) {
      $target_path = "uploads/notification/";
      if (is_array($_FILES)) {
        $imagename = basename($_FILES["image"]["name"]);
        $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
        $actual_image_name = 'afi' . time() . "." . $extension;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
        if (!empty($actual_image_name) && !empty($extension)) {
          $display_image = $actual_image_name;
        } else {
          $display_image = "";
        }
      }

      $fil_package_deatils = "/uploads/notification/" . $display_image;
      $fil_package_deatils_new = "";

      $image =      base_url("uploads/notification") . "/" . $display_image;
      $message = $this->input->post('message');
      $title = $this->input->post('title');
      // print_r($fil_package_deatils); die;

      $user_id = $_POST['name_id'];

      $type = $this->input->post("type");

      if ($type == 1) {
        $device_token = $this->db->query("SELECT * FROM `user` WHERE id = $user_id")->row();
        // echo $this->db->last_query(); die;
        $this->check_curl_mail($device_token->email, $title, $message, $device_token->name, '', '', $fil_package_deatils, $fil_package_deatils_new);
      } elseif ($type == 2) {
        $device_token = $this->db->query("SELECT * FROM `astrologers` WHERE id = $user_id")->row();
        // echo $this->db->last_query(); die;
        $this->check_curl_mail($device_token->email, $title, $message, $device_token->name, '', '', $fil_package_deatils, $fil_package_deatils_new);
      } elseif ($type == 3) {
        $device_token = $this->db->query("SELECT * FROM `supervisor` WHERE id = $user_id")->row();
        // echo $this->db->last_query(); die;
        $this->check_curl_mail($device_token->email, $title, $message, $device_token->name, '', '', $fil_package_deatils, $fil_package_deatils_new);
      } elseif ($type == 4) {
        $device_token = $this->db->query("SELECT * FROM `priest` WHERE id = $user_id")->row();
        // echo $this->db->last_query(); die;
        $this->check_curl_mail($device_token->email, $title, $message, $device_token->name, '', '', $fil_package_deatils, $fil_package_deatils_new);
      }



      $insert_array = array(
        'user_id' => $user_id,
        'user_type' => 1,
        'status' => 1,
        'read' => 0,
        'title' => $title,
        'image' => $image,
        'notification' => $message,
        'type' => 'admin',
        'added_on' => date('Y-m-d H:i:s')
      );
      // print_r($insert_array);die;

      $insert = $this->db->insert('user_notification', $insert_array);
      // echo $this->db->last_query(); die;
      $this->session->set_flashdata('message', array('message' => 'Notification sent successfully.', 'class' => 'success'));
      redirect($this->agent->referrer());
    }
  }

  public function send_single_astrologer_notification()
  {
    if (!empty($_POST)) {
      // print_r($_POST); die;

      if (!empty($_FILES['image'])) {
        $config['upload_path'] = 'uploads/notification/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $imageUpload = '';
        if (!$this->upload->do_upload('image')) {
          $error = array(
            'error' => $this->upload->display_errors()
          );
          $display_image = 'default.png';
        } else {
          $imageUpload = $this->upload->data();
          $display_image = $imageUpload['file_name'];
        }
      }

      $image =      base_url("uploads/notification") . "/" . $display_image;
      $message = $this->input->post('message');
      $title = $this->input->post('title');
      $selected_android_user1 = array();
      $selected_ios_user1 = array();
      $user_id = $_POST['name_id'];

      $device_token = $this->db->query("SELECT * FROM `astrologers` WHERE status = 1 AND  device_token !='' AND id = $user_id")->row();
      // echo $this->db->last_query(); die;
      if ($device_token->device_type == 'android') {
        // print_r($device_token); die;
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","image":"' . $image . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'image' => $image,
          'sound' => 'Default'
        );
        $a = $this->sendMessageThroughFCM([$device_token->device_token], $message2, 2);
      } else {
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'sound' => 'Default'
        );
        $a = $this->send_ios_notification([$device_token->device_token], $message2, "ios");
      }
      $insert_array = array(
        'user_id' => $user_id,
        'title' => $title,
        'image' => $image,
        'notification' => $message,
        'type' => 'admin',
        'added_on' => date('Y-m-d H:i:s')
      );
      // print_r($insert_array);die;

      $insert = $this->db->insert('astrologer_notification', $insert_array);

      $this->session->set_flashdata('message', array('message' => 'Notification sent successfully.', 'class' => 'success'));
      redirect($this->agent->referrer());
    }
  }


  public function send_single_supervisor_notification()
  {
    if (!empty($_POST)) {
      // print_r($_POST); die;

      if (!empty($_FILES['image'])) {
        $config['upload_path'] = 'uploads/notification/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $imageUpload = '';
        if (!$this->upload->do_upload('image')) {
          $error = array(
            'error' => $this->upload->display_errors()
          );
          $display_image = 'default.png';
        } else {
          $imageUpload = $this->upload->data();
          $display_image = $imageUpload['file_name'];
        }
      }

      $image =      base_url("uploads/notification") . "/" . $display_image;
      $message = $this->input->post('message');
      $title = $this->input->post('title');
      $selected_android_user1 = array();
      $selected_ios_user1 = array();
      $user_id = $_POST['name_id'];

      $device_token = $this->db->query("SELECT * FROM `supervisor` WHERE status = 1 AND  device_token !='' AND id = $user_id")->row();

      if ($device_token->device_type == 'android') {
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","image":"' . $image . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'image' => $image,
          'sound' => 'Default'
        );
        $a = $this->sendMessageThroughFCM([$device_token->device_token], $message2, 3);
      } else {
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'sound' => 'Default'
        );
        $a = $this->send_ios_notification([$device_token->device_token], $message2, "ios");
      }
      $insert_array = array(
        'user_id' => $user_id,
        'title' => $title,
        'image' => $image,
        'notification' => $message,
        'type' => 'admin',
        'added_on' => date('Y-m-d H:i:s')
      );
      // print_r($insert_array);die;

      $insert = $this->db->insert('supervisor_notification', $insert_array);

      $this->session->set_flashdata('message', array('message' => 'Notification sent successfully.', 'class' => 'success'));
      redirect($this->agent->referrer());
    }
  }



  public function send_single_priest_notification()
  {
    if (!empty($_POST)) {
      // print_r($_POST); die;

      if (!empty($_FILES['image'])) {
        $config['upload_path'] = 'uploads/notification/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '';
        $config['max_width'] = '';
        $config['max_height'] = '';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $imageUpload = '';
        if (!$this->upload->do_upload('image')) {
          $error = array(
            'error' => $this->upload->display_errors()
          );
          $display_image = 'default.png';
        } else {
          $imageUpload = $this->upload->data();
          $display_image = $imageUpload['file_name'];
        }
      }

      $image =      base_url("uploads/notification") . "/" . $display_image;
      $message = $this->input->post('message');
      $title = $this->input->post('title');
      $selected_android_user1 = array();
      $selected_ios_user1 = array();
      $user_id = $_POST['name_id'];

      $device_token = $this->db->query("SELECT * FROM `priest` WHERE status = 1 AND  device_token !='' AND id = $user_id")->row();
      // echo $this->db->last_query(); die;
      if ($device_token->device_type == 'android') {
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","image":"' . $image . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'image' => $image,
          'sound' => 'Default'
        );
        // print_r( $message2); die;
        $a = $this->sendMessageThroughFCM([$device_token->device_token], $message2, 4);
      } else {
        $notification_type1 = "text";
        $respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title . '","msg":"' . $message . '","type":"no"}';
        $message2 = array(
          'body' => $message,
          'title' => $title,
          'sound' => 'Default'
        );
        $a = $this->send_ios_notification([$device_token->device_token], $message2, "ios");
      }
      $insert_array = array(
        'user_id' => $user_id,
        'title' => $title,
        'image' => $image,
        'notification' => $message,
        'type' => 'admin',
        'added_on' => date('Y-m-d H:i:s')
      );
      // print_r($insert_array);die;

      $insert = $this->db->insert('priest_notification', $insert_array);

      $this->session->set_flashdata('message', array('message' => 'Notification sent successfully.', 'class' => 'success'));
      redirect($this->agent->referrer());
    }
  }




  public function sendMessageThroughFCM($registatoin_ids, $message, $type)
  {
    // print_r($registatoin_ids); die;
    $settings = $this->db->get_where('settings', array('id' => 1))->row();
    if ($type == 1) {
      // $android_firbase = $settings->firebase_key;  
      $k = "AAAASiCBx_0:APA91bEFg-o01tvj86QiCtxS7L9OwP_FJ0n7vaB-HHGucY2QC3Ixm9ZUWfhxVeXsZAEo0GgLbxuf4jn0Ms-94YSneZQxEqsUCXURzUjdqg_GAV0NXDoxKcuqTPLRmgKWEU2BPgJ9sb2C";
    } elseif ($type == 2) {
      // $android_firbase = $settings->astrologer_firebase;  
      $k = "AAAAA-Vq-4w:APA91bHMazogQxvqHJqR8N9Uz0gC6UeVaH4SRC4YFILWUqsytLcxNrkhm750cdczKBvwsctBTZRVWSlRJNACPpRedPbiVbXYnyy0Y_AihAPpPZFUfZauiJM3r2XlZkDXeEldAE-EnKjt";
    }

    // print_r( $k);
    $url = 'https://fcm.googleapis.com/fcm/send';

    $notification = $message;
    unset($notification['link']);
    $fields = array(
      'registration_ids' => $registatoin_ids,
      'data' => $message,
      'notification' => $notification
    );
    // print_r($fields); die;
    //Setup headers:

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key=' . $k;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //Setup curl, add headers and post parameters.

    $result = curl_exec($ch);
    // print_r($result);     die;         
    if ($result === FALSE) {
      die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    //print_r($registatoin_ids);
  }

  public function send_ios_notification($device_token, $message_text, $type)
  {
    // print_r($message_text['body']); die;
    // $message_text ="hello";
    @$payload = '{"aps":{"alert":"' . $message_text['body'] . '","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"genral"}';

    // @$payload='{"aps":{"alert":"'.$message_text.'","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"genral"}';
    //include_once("Cow.pem");
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', '/var/www/html/kundali_expert/notification_key/kundali.pem');
    // $fp=stream_socket_client('ssl://gateway.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
    @$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
    if ($fp) {
      // echo "Connected".$err;
    }
    foreach ($device_token as $key) {
      // print_r($key); die;
      $msg = chr(0) . pack("n", 32) . pack("H*", str_replace(' ', '', $key)) . pack("n", strlen($payload)) . $payload;
      // print_r($msg); die;
    }
    @$res = fwrite($fp, $msg);
    if ($res) {
      //print_r($res);  
    }
    fclose($fp);
    return true;
  }



  public function check_curl_mail($email = '', $subject = '', $message = '', $name = '', $bcc_email = '', $bcc_line = '', $fil_package_deatils = '', $fil_package_deatils_two = '')
  {
    // print_r($email);die;
    $mail = new PHPMailer(TRUE);
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );
    $mail->Host = 'mail4.ushamartintech.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = "communication@shaktipeethdigital.com";
    $mail->Password = "N!v@kx?$$65";
    $mail->setFrom('no-reply@webappfactory.co', 'Shaktipeeth Digital');
    $mail->addAddress($email, $name);
    $mail->WordWrap = 500;
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;



    if ($fil_package_deatils == "/uploads/notification/") {
      $e = "";
    } else {
      $path = '/var/www/html/shaktipeeth_website/admin/' . $fil_package_deatils;
      $mail->addAttachment($path);
    }



    if (!$mail->send()) {
      // echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
    } else {
      // echo 1;
      return true;
    }
  }

  public function check_curl_mail1($email = '', $subject = '', $message = '', $name = '', $bcc_email = '', $bcc_line = '', $fil_package_deatils = '', $fil_package_deatils_two = '')
  {
    // print_r($email); die;
    $url = base_url('api/curl_mail_fun');
    $curl = curl_init();
    $post['email'] = $email; // our data todo in received
    $post['subject'] = $subject; // our data todo in received
    $post['message'] = $message; // our data todo in received
    $post['name'] = $name; // our data todo in received
    $post['bcc_email'] = $bcc_email;
    $post['bcc_line'] = $bcc_line;
    $post['fil_package_deatils'] = $fil_package_deatils;
    $post['fil_package_deatils_two'] = $fil_package_deatils_two;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

    curl_setopt($curl, CURLOPT_USERAGENT, 'api');

    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl,  CURLOPT_RETURNTRANSFER, false);
    curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10);

    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

    $re = curl_exec($curl);
    curl_close($curl);
    print_r($re);
    die;
    return true;
  }
}
