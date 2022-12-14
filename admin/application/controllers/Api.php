<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	exit(0);
}
class Api extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Api_Model', 'w_m');
		$this->load->library('form_validation');
	}

	public function index()
	{
		echo 1;
		// print_r($this->input->get_request_header('HTTP_X_API_KEY'));
	}

	private function fail_auth()
	{
		echo json_encode([
			'status'	=> 	'failed',
			'message'	=> 	'Unable to authenticate the request. It seems like the API key provided is not valid.'
		]);
	}

	function encrypt_decrypt($action, $string)
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'SECRET_KEY';
		$secret_iv = 'SECRET_IV';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'encrypt') {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if ($action == 'decrypt') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

	//Astroleger

	public function Signin_astrologer()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$result = $this->w_m->Signin_astrologer($data);
				echo json_encode($result);
			}
		}
	}

	public function Isemailexist_astrologer($email)
	{
		$user = $this->w_m->isEmailExist_astrologer($email);
		if ($user) {
			return false;
		} else {
			return true;
		}
	}
	public function Isphoneexist_astrologer($mobile, $country_code = '')
	{
		$user = $this->w_m->Isphoneexist_astrologer($mobile, $country_code);
		if ($user) {
			return false;
		} else {
			return true;
		}
	}

	public function Isphoneexist_astrologer_code($mobile, $country_code)
	{
		$user = $this->w_m->Isphoneexist_astrologer_country_code($mobile, $country_code);
		if ($user) {
			return false;
		} else {
			return true;
		}
	}

	public function otp_send_astrologer()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			if ($data['email'] && $data['mobile']) {
				if ($this->isEmailExist_astrologer($data['email'])) {
					$result = array('status' => false, 'msg' => 'Email already registered, please use another mail id');
				} elseif ($this->Isphoneexist_astrologer($data['mobile'])) {
					$result = array('status' => false, 'msg' => 'Mobile number already registered, please use another');
				} else {
					$result = $this->w_m->otp_send_astrologer($data);
				}
			} else {
				$result = array('status' => false, 'msg' => 'something error happen please try again later!');
			}
			echo json_encode($result);
		}
	}

	public function astrologer_forget_password_otp()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$result = array('status' => false, 'msg' => 'not found in db');
			if ($this->isEmailExist_astrologer($data['email_phone'])) {
				$this->w_m->otp_send_astrologer_register($data);
				$result = $this->w_m->otp_send_astrologer_register($data);
			} elseif ($this->Isphoneexist_astrologer($data['email_phone'])) {
				$result = $this->w_m->otp_send_astrologer_register($data);
			}
			echo json_encode($result);
		}
	}

	public function change_password_astrologer()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$password = $this->encrypt_decrypt('encrypt', $data['password']);
			$this->db->query("UPDATE astrologers SET `password` = '" . $password . "',`random_password` = '" . $data['password'] . "' WHERE `id` = " . $data['id']);
			$result = array('status' => true, 'msg' => 'done');
			echo json_encode($result);
		}
	}

	public function master_states()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('state_name', 'asc')->get_where("state_categories", array())->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_city()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('city_name', 'asc')->get_where("city_categories", array("state_id" => $data['state_id']))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_service_offered()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_service_offered", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_education_degree()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_education_degree", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_specialization()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_specialization", array("status" => 1, "type" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function language_categories()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('language_name', 'asc')->get_where("language_categories", array())->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function Signup_astrologer()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			// if($this->Isemailexist_doctor($data['email'])){
			// 	$data = array('status'=>false,'msg'=>'We already have this email address');
			// }elseif ($this->Isphoneexist_doctor($data['mobile'])) {
			// 	$data = array('status'=>false,'msg'=>'We already have this mobile number');
			// }
			// else{
			$password = $this->encrypt_decrypt('encrypt', $data['password']);
			$result = $this->w_m->signup_astrologer($data, $password, $data['password']);
			if ($result > 0) {
				$user_detail = $this->w_m->global_multiple_query('astrologers', array('id' => $result), 'row()');
				if (!empty($user_detail->image)) {
					$img = base_url('/uploads/astrologers') . '/' . $user_detail->image;
				} else {
					$img = base_url('/uploads/astrologers/') . '/' . 'default.png';
				}
				if (!is_null($user_detail->gender)) {
					$gender = $user_detail->gender;
				} else {
					$gender = '';
				}


				if (!is_null($user_detail->dob)) {
					$dob = $user_detail->dob;
				} else {
					$dob = '';
				}

				if (!is_null($user_detail->address)) {
					$address = $user_detail->address;
				} else {
					$address = '';
				}

				if (!is_null($user_detail->state)) {
					$state = $user_detail->state;
				} else {
					$state = '';
				}

				if (!is_null($user_detail->city)) {
					$city = $user_detail->city;
				} else {
					$city = '';
				}

				if (!is_null($user_detail->pincode)) {
					$pincode = $user_detail->pincode;
				} else {
					$pincode = '';
				}

				$user_detail1 = array(
					"user_id" => $user_detail->id,
					"name" => $user_detail->name,
					"email" => $user_detail->email,
					"mobile" => $user_detail->phone,
					"image" => $img,
					"dob" => $dob,
					"gender" => $gender,
					"address" => $address,
					"state" => $state,
					"city" => $city,
					"pincode" => $pincode,
				);
				$data = array('status' => true, 'msg' => 'Successfully Registered. Please login to your account', 'user_detail' => $user_detail1);
			}
			// }
			echo json_encode($data);
		}
	}


	public function check_all_steps()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$response = array('status' => false, 'msg' => 'No astrologer found');
			$check_user_ = $this->db->get_where('astrologers', array("id" => $user_id));
			if ($check_user_->num_rows() > 0) {
				$check_user = $check_user_->row();
				if ($check_user->registartion_from == 'app') {
					$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user->status, 'professional_details_status' => $check_user->professional_details, 'bank_details_status' => $check_user->bank_details_status, 'docs_status' => $check_user->docs_status, 'approved' => $check_user->approved);
				} elseif ($check_user->registartion_from == 'admin') {
					$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user->status, 'professional_details_status' => 1, 'bank_details_status' => 1, 'docs_status' => 1, 'approved' => $check_user->approved);
				}
			}
			echo json_encode($response);
		}
	}

	public function update_professional_details()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$response = array('status' => false, 'msg' => 'No astrologer found');
			$check_user_ = $this->db->get_where('astrologers', array("id" => $user_id));
			if ($check_user_->num_rows() > 0) {
				$info = array(
					'languages' => $data['languages'],
					'experience' => $data['experience'],
					'working_on_digital' => $data['working_on_digital'],
					'similar_app' => $data['similar_app'],
					'can_take_horoscope' => $data['can_take_horoscope'],
					'service_offered' => $data['service_offered'],
					'specialization' => $data['specialization'],
					'educational_background' => $data['educational_background'],
					'professional_details' => 1

				);
				if ($data['specialization']) {
					$d = explode('|', $data['specialization']);
					if (count($d) > 0) {
						for ($ispe = 0; $ispe < count($d); $ispe++) {
							$check_already_there = $this->db->get_where('skills', array('user_id' => $user_id, 'speciality_id' => $d[$ispe], 'status' => 1));
							if ($check_already_there->num_rows() > 0) {
								# code...
							} else {
								$array = array('user_id' => $user_id, 'speciality_id' => $d[$ispe], 'type' => 1);
								$this->db->insert('skills', $array);
							}
						}
					}
				}
				$this->db->where('id', $user_id);
				$this->db->update('astrologers', $info);
				$check_user = $check_user_->row();
				$check_user_2 = $this->db->get_where('astrologers', array("id" => $user_id))->row();
				if ($check_user_2->registartion_from == 'app') {
					$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user_2->status, 'professional_details_status' => $check_user_2->professional_details, 'bank_details_status' => $check_user_2->bank_details_status, 'docs_status' => $check_user_2->docs_status, 'approved' => $check_user_2->approved);
				} elseif ($check_user_2->registartion_from == 'admin') {
					$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user_2->status, 'professional_details_status' => 1, 'bank_details_status' => 1, 'docs_status' => 1, 'approved' => $check_user_2->approved);
				}
			}
			echo json_encode($response);
		}
	}

	public function update_bank_details()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$response = array('status' => false, 'msg' => 'No astrologer found');
			$check_user_ = $this->db->get_where('astrologers', array("id" => $user_id));
			if ($check_user_->num_rows() > 0) {
				$info = array(
					'pan_number' => $data['pan_number'],
					'aadhar_number' => $data['aadhar_number'],
					'bankName' => $data['bankName'],
					'bank_account_holder_name' => $data['bank_account_holder_name'],
					'bank_account_no' => $data['bank_account_no'],
					'bank_account_type' => $data['bank_account_type'],
					'ifsc_code' => $data['ifsc_code'],
					'gst_number' => $data['gst_number'],
					'bank_details_status' => 1
				);
				$this->db->where('id', $user_id);
				$this->db->update('astrologers', $info);
				$check_user = $check_user_->row();
				$check_user_2 = $this->db->get_where('astrologers', array("id" => $user_id))->row();
				if ($check_user_2->registartion_from == 'app') {
					$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user_2->status, 'professional_details_status' => $check_user_2->professional_details, 'bank_details_status' => $check_user_2->bank_details_status, 'docs_status' => $check_user_2->docs_status, 'approved' => $check_user_2->approved);
				} elseif ($check_user_2->registartion_from == 'admin') {
					$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user_2->status, 'professional_details_status' => 1, 'bank_details_status' => 1, 'docs_status' => 1, 'approved' => $check_user_2->approved);
				}
			}
			echo json_encode($response);
		}
	}

	public function update_docs()
	{
		$user_id = $this->input->post('user_id');
		$response = array('status' => false, 'msg' => 'No astrologer found');
		$check_user_ = $this->db->get_where('astrologers', array("id" => $user_id));
		if ($check_user_->num_rows() > 0) {
			$path = base_url('uploads/user/');
			$bio = $this->input->post('bio');
			$terms_work = $this->input->post('terms_work');
			$terms_and_conditions = $this->input->post('terms_and_conditions');

			$aadhar_front_image_ = '';
			$aadhar_back_image_ = '';
			$pan_image_ = '';
			$color_image_ = '';

			$target_path = "uploads/astrologers/astrologers_doc/";
			$target_path_profile = "uploads/astrologers/";
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["aadhar_front_image"]["name"]);
				$extension = substr(strrchr($_FILES['aadhar_front_image']['name'], '.'), 1);
				$actual_image_name = 'afi' . time() . "." . $extension;
				move_uploaded_file($_FILES["aadhar_front_image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$aadhar_front_image_ = $actual_image_name;
				}

				$imagename_back = basename($_FILES["aadhar_back_image"]["name"]);
				$extension_back = substr(strrchr($_FILES['aadhar_back_image']['name'], '.'), 1);
				$actual_image_name_back = 'abi' . time() . "." . $extension_back;
				move_uploaded_file($_FILES["aadhar_back_image"]["tmp_name"], $target_path . $actual_image_name_back);
				if (!empty($actual_image_name_back) && !empty($extension_back)) {
					$aadhar_back_image_ = $actual_image_name_back;
				}

				$imagename_pan = basename($_FILES["pan_card_image"]["name"]);
				$extension_pan = substr(strrchr($_FILES['pan_card_image']['name'], '.'), 1);
				$actual_image_name_pan = 'pi' . time() . "." . $extension_pan;
				move_uploaded_file($_FILES["pan_card_image"]["tmp_name"], $target_path . $actual_image_name_pan);
				if (!empty($actual_image_name_pan) && !empty($actual_image_name_pan)) {
					$pan_image_ = $actual_image_name_pan;
				}

				$imagename_profile = basename($_FILES["profile_image"]["name"]);
				$extension_profile = substr(strrchr($_FILES['profile_image']['name'], '.'), 1);
				$actual_image_name_profile = 'pri' . time() . "." . $extension_profile;
				move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_path_profile . $actual_image_name_profile);
				if (!empty($actual_image_name_profile) && !empty($actual_image_name_profile)) {
					$color_image_ = $actual_image_name_profile;
				}

				if (
					$aadhar_front_image_ != '' and
					$aadhar_back_image_ != '' and
					$pan_image_ != '' and
					$color_image_ != ''
				) {
					$info = array(
						'aadhar_card_front_image' => $aadhar_front_image_,
						'aadhar_card_back_image' => $aadhar_back_image_,
						'pan_card_image' => $pan_image_,
						'image' => $color_image_,
						'bio' => $bio,
						'terms_and_conditions' => $terms_and_conditions,
						'terms_work' => $terms_work,
						'docs_status' => 1
					);
					$this->db->where('id', $user_id);
					$this->db->update('astrologers', $info);
					$check_user = $check_user_->row();
					$check_user_2 = $this->db->get_where('astrologers', array("id" => $user_id))->row();
					if ($check_user_2->registartion_from == 'app') {
						$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user_2->status, 'professional_details_status' => $check_user_2->professional_details, 'bank_details_status' => $check_user_2->bank_details_status, 'docs_status' => $check_user_2->docs_status, 'approved' => $check_user_2->approved);
					} elseif ($check_user_2->registartion_from == 'admin') {
						$response = array('status' => true, 'msg' => 'astrologer found', 'app_status' => $check_user_2->status, 'professional_details_status' => 1, 'bank_details_status' => 1, 'docs_status' => 1, 'approved' => $check_user_2->approved);
					}
				}
			}
		}
		echo json_encode($response);
	}

	public function get_profile_astrologers()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$result = $this->w_m->get_profile_astrologers($data);
				echo json_encode($result);
			}
		}
	}

	public function update_superviser_profile()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			$user_id = $data['user_id'];
			$name = $data['name'];
			$dob = $data['dob'];
			$gender = $data['gender'];
			$service_offered = $data['service_offered'];
			$specialization = $data['specialization'];
			$language = $data['language'];
			$experience = $data['experience'];
			$array = array(
				'name' => $name,
				'dob' => $dob,
				'gender' => $gender,
				'service_offered' => $service_offered,
				'specialization' => $specialization,
				'languages' => $language,
				'experience' => $experience,
			);
			$this->db->where('id', $user_id);
			$this->db->update('astrologers', $array);
			$check_user_2 = $this->db->get_where('astrologers', array("id" => $user_id))->row();
			$response = array("status" => true, "msg" => "Update done", "details" => $check_user_2);
			echo json_encode($response);
		}
	}

	public function change_status_consultations()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$astrologer_id = $data['astrologer_id'];
		$chat_status = $data['chat_status'];
		$video_status = $data['video_status'];
		$audio_status = $data['audio_status'];
		$astrologer = $this->db->get_where('astrologers', ['id' => $astrologer_id])->row();
		$online_consult = $astrologer->online_consult;
		$arr = [];
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

		$this->db->where('id', $astrologer_id);
		$this->db->update('astrologers', $arr);
		echo json_encode([
			'status' => true,
			'message' => 'updated'
		]);
	}



	public function online_offline_status()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$date = date("Y-m-d H:i:s");
			$for = $data['for'] . '_status';
			$what = $data['what'];
			if ($data['for'] == '') {
				if ($what == 1) {
					$this->db->query("UPDATE `astrologers` SET `online_status`='1',`video_status`='0',`audio_status`='0',`chat_status`='0' WHERE `id` = '" . $data['user_id'] . "'");
				} else {
					$this->db->query("UPDATE `astrologers` SET `online_status`='0',`video_status`='0',`audio_status`='0',`chat_status`='0' WHERE `id` = '" . $data['user_id'] . "'");
				}
			} else {
				if ($what == 1) {
					$this->db->query("UPDATE `astrologers` SET `" . $for . "`='$what', `online_status`='1' WHERE `id` = '" . $data['user_id'] . "'");
				} else {
					$this->db->query("UPDATE `astrologers` SET `" . $for . "`='$what' WHERE `id` = '" . $data['user_id'] . "'");
				}
			}



			// if ($data['what'] == 1 || $data['what'] == '1') 
			// {
			// 	$this->send_live_notification_alert($data['user_id']);
			// }

			echo json_encode(array("status" => true));
		}
	}


	public function home_astrologers()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_details = array();
			$user_detail_ = $this->db->get_where("astrologers", array("id" => $data['user_id']));
			if ($user_detail_->num_rows() > 0) {
				$user_details = $user_detail_->row();
				$user_details->user_image_path = base_url('uploads/astrologers/') . '/';
			}
			$booking_details = array();
			$today_date = date('Y-m-d');
			$is_chat_or_video_start = 0;
			$is_booking = 0;
			$booking_id = 0;
			$chat_g_id = 0;
			$booking_type = '';
			$user_id = '';
			$get_user_name_ = '';
			$user_gender = '';
			$get_booking_ = $this->db->query("SELECT * FROM `bookings` WHERE schedule_date = '$today_date' AND `assign_id` = '" . $data['user_id'] . "' AND `type` IN ('1','2','3') AND `booking_type`='2' AND `status` = 0 AND (`is_chat_or_video_start` = '1' or `is_chat_or_video_start` = '2') LIMIT 1");
			if ($get_booking_->num_rows() > 0) {
				$get_booking = $get_booking_->row();
				if ($get_booking->type == 1) {
					$booking_type = 'video';
				} elseif ($get_booking->type == 2) {
					$booking_type = 'audio';
				} elseif ($get_booking->type == 3) {
					$booking_type = 'chat';
				}
				$current_time = time();
				$booking_date_time = strtotime($get_booking->schedule_date_time);
				$endTime = strtotime(date('Y-m-d H:i:s', strtotime("+" . $get_booking->total_minutes . " minutes", $booking_date_time)));
				if ($endTime > $current_time) {
					$is_booking = 1;
					$booking_id = $get_booking->id;
					$is_chat_or_video_start = $get_booking->is_chat_or_video_start;
					$chat_g_id = $get_booking->bridge_id;
					$booking_type = $booking_type;
					$user_id = $get_booking->user_id;
					$get_user_name = $this->db->get_where("user", array("id" => $user_id));
					$get_user_name_ = $get_booking->user_name;
					$user_gender = '';
					$img = base_url('/uploads/user/') . '/' . 'default.png';
					if ($get_user_name->num_rows() > 0) {
						$u_details = $get_user_name->row();
						$img = base_url('/uploads/user/') . '/' . $u_details->image;
						$user_gender = is_null($u_details->gender) ? '' : $u_details->gender;
					}
				}

				$booking_details = array("is_chat_or_video_start" => $is_chat_or_video_start, "booking_id" => $booking_id, "chat_g_id" => $chat_g_id, "is_booking" => $is_booking, "user_name" => $get_user_name_, "booking_type" => $booking_type, "user_id" => $user_id, "user_gender" => $user_gender, "user_wallet" => $u_details->wallet);
			}
			$response = array("status" => true, "user_detail" => $user_details, "bookings_details" => $booking_details);
			echo json_encode($response);
		}
	}

	public function astrologer_online_offline()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$astrologer_id = $data['astrologer_id'];
		$online = $data['online'];
		$this->db->where('id', $astrologer_id);
		$arr = [
			'online_status' => $online ? 1 : 0
		];
		$this->db->update('astrologers', $arr);

		if ($online == 1) {


			$this->db->select('user.id,user.device_token,user.name');
			$this->db->from('user');
			$this->db->join('followers', 'followers.user_id = user.id');
			$this->db->where('followers.astrologer_id', $astrologer_id);
			$query = $this->db->get();
			$userss = $query->result();

			$astrologerss = $this->db->get_where('astrologers', ['id' => $astrologer_id])->row();
			$title = "Astrologer online";

			foreach ($userss as $key => $value) {
				$body = "Hi " . $value->name . ", Astrologer " . $astrologerss->name . " is now online, Please Join!";
				$msg = array(
					'body' => $body,
					'data' => [],
					'title' => $title,
					'sound' => 'default',
					"icon" => "ic_launcher"

				);
				$this->send_push_notification($value->device_token, $msg);
			}
		}

		echo json_encode(['status' => true, 'online' => $online]);
	}

	public function send_push_notification($registatoin_ids, $message)
	{
		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		$API_SERVER_KEY = "AAAASiCBx_0:APA91bEFg-o01tvj86QiCtxS7L9OwP_FJ0n7vaB-HHGucY2QC3Ixm9ZUWfhxVeXsZAEo0GgLbxuf4jn0Ms-94YSneZQxEqsUCXURzUjdqg_GAV0NXDoxKcuqTPLRmgKWEU2BPgJ9sb2C";

		if (!is_array($registatoin_ids)) {
			$device_tokens = [$registatoin_ids];
		} else {
			$device_tokens = $registatoin_ids;
		}
		$fields = array(
			'registration_ids' => $device_tokens,
			'data' => $message,
			'notification' => $message
			// 'sound'=>'default'
		);
		$headers = array(
			'Authorization:key=' . $API_SERVER_KEY,
			'Content-Type:application/json'
		);

		// Open connection  
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// Execute post

		$result = curl_exec($ch);

		// Close connection
		curl_close($ch);
		// print_r($result);
		return true;
		// print_r($result);
	}

	public function astrologers_dynamic()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$today_date = date('Y-m-d');
			$update_array = array("device_token" => $data['device_token'], "device_id" => $data['device_id'], "device_type" => $data['device_type']);
			$this->db->where("id", $data['user_id']);
			$this->db->update("astrologers", $update_array);
			$is_chat_or_video_start = 0;
			$is_booking = 0;
			$booking_id = 0;
			$chat_g_id = 0;
			$booking_type = '';
			$user_id = '';
			$is_start = 2;
			/**no booking if 0<-waitng for customer to accept, 1<- customer accept the request please join */
			$get_user_name_ = '';
			$user_gender = '';
			$request_array = array();
			$user_member = [];
			$get_booking_ = $this->db->query("SELECT * FROM `bookings` WHERE schedule_date = '$today_date' AND `assign_id` = '" . $data['user_id'] . "' AND `type` IN ('1','2','3') AND `booking_type`='2' AND `status` IN (0,1,6) AND (`is_chat_or_video_start` = '1' or `is_chat_or_video_start` = '2') LIMIT 1");
			if ($get_booking_->num_rows() > 0) {
				$get_booking = $get_booking_->row();
				if ($get_booking->status == 6) {
					$is_start = 1;
				} else {
					$is_start = 0;
				}

				$this->db->order_by('id', 'desc');
				// $$this->db->get_where('members',['user_id'=>$user_id,'is_default'=>1]);
				$user_member = $this->db->get_where('members', ['user_id' => $get_booking->user_id, 'is_default' => 1])->row();


				$start_time = $get_booking->schedule_date_time;
				$startTime = strtotime($start_time);
				$endTime = strtotime("+" . $get_booking->total_minutes . " minutes", strtotime($start_time));

				$current_time = time();
				$remaining_time = 0;

				if ($current_time < $endTime) {
					$diff = $endTime - $current_time;
					$remaining_time = abs($diff);
				}
				$user_member->remaining_time = $remaining_time;

				if ($get_booking->type == 1) {
					$booking_type = 'video';
				} elseif ($get_booking->type == 2) {
					$booking_type = 'audio';
				} elseif ($get_booking->type == 3) {
					$booking_type = 'chat';
				}
				if ($get_booking->is_premium == 1) {
					$current_time = time();
					$booking_date_time = strtotime($get_booking->schedule_date_time);
					$endTime = strtotime(date('Y-m-d H:i:s', strtotime("+" . $get_booking->total_minutes . " minutes", $booking_date_time)));
					if ($endTime > $current_time) {
						$is_booking = 1;
						$booking_id = $get_booking->id;
						$is_chat_or_video_start = $get_booking->is_chat_or_video_start;
						$chat_g_id = $get_booking->bridge_id;
						$booking_type = $booking_type;
						$user_id = $get_booking->user_id;
						$get_user_name = $this->db->get_where("user", array("id" => $user_id));
						$get_user_name_ = $get_booking->user_name;
						$user_gender = '';
						$img = base_url('/uploads/user/') . '/' . 'default.png';
						if ($get_user_name->num_rows() > 0) {
							$u_details = $get_user_name->row();
							$img = base_url('/uploads/user/') . '/' . $u_details->image;
							$user_gender = is_null($u_details->gender) ? '' : $u_details->gender;
						}
					}
				} else {
					$is_booking = 1;
					$booking_id = $get_booking->id;
					$is_chat_or_video_start = $get_booking->is_chat_or_video_start;
					$chat_g_id = $get_booking->bridge_id;
					$booking_type = $booking_type;
					$user_id = $get_booking->user_id;
					$get_user_name = $this->db->get_where("user", array("id" => $user_id));
					$get_user_name_ = $get_booking->user_name;
					$user_gender = '';
					$img = base_url('/uploads/user/') . '/' . 'default.png';
					if ($get_user_name->num_rows() > 0) {
						$u_details = $get_user_name->row();
						$img = base_url('/uploads/user/') . '/' . $u_details->image;
						$user_gender = is_null($u_details->gender) ? '' : $u_details->gender;
						$user_member->wallet = $u_details->wallet;
					}
				}
			}
			$path = base_url('uploads/user/') . '/';
			$request = $this->db->query("SELECT a.`id`,CONCAT('$path', `image`) AS img, `user_id`, `astrologer_id`, `price_per_mint`, `type`, a.`status`, a.`accept_date`, a.`reject_date`, a.`created_at`,name,COALESCE(TIMESTAMPDIFF(YEAR, dob, CURDATE()),'') AS age,gender FROM `booking_request` a JOIN user b ON b.id=a.user_id WHERE `astrologer_id` = '" . $data['user_id'] . "' AND a.`status` = '0' ORDER BY `created_at`")->result();

			if ($request) {
				$is_start = 3;
			}


			$response = array("status" => true, 'is_start' => $is_start, "is_chat_or_video_start" => $is_chat_or_video_start, "booking_id" => $booking_id, "chat_g_id" => $chat_g_id, "is_booking" => $is_booking, "user_name" => $get_user_name_, "booking_type" => $booking_type, "user_id" => $user_id, "user_gender" => $user_gender, "request_array" => $request, 'user_member' => $user_member);
			echo json_encode($response);
		}
	}

	public function accept_reject_request()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$this->db->where_in('status', [0, 4]);
			$get_data = $this->db->get_where("booking_request", array("id" => $data['id']))->row();

			$update_array_booking = array("status" => 2, "complete_date" => date('Y-m-d H:i:s'));
			$this->db->where("assign_id", $get_data->astrologer_id);
			$this->db->where("status", 6);
			$this->db->update("bookings", $update_array_booking);

			

			$date = date('Y-m-d H:i:s');
			$this->db->where_in('type', [1, 2, 3]);
			$this->db->where_in('status', [0, 1, 6]);


		
			// $this->db->where('schedule_date_time >=', $date.' 00:00:00');
			// $this->db->where('schedule_date_time <=', $date.' 24:00:00');
			$check_if_any_ongoing_booking = $this->db->get_where('bookings', ['assign_id' => $get_data->astrologer_id])->row();

			if ($data['what'] == '1') {


				// $date=date('Y-m-d H:i:s');
				// $this->db->where_in('type',[1,2,3]);
				// $this->db->where_in('status',[0,1,6]);
				// // $this->db->where('schedule_date_time >=', $date.' 00:00:00');
				// // $this->db->where('schedule_date_time <=', $date.' 24:00:00');
				// $check_if_any_ongoing_booking = $this->db->get_where('bookings',['assign_id'=>$get_data->astrologer_id])->row();
				if (!$check_if_any_ongoing_booking) {

					
					



					$update_array = array("status" => 1, "accept_date" => date('Y-m-d H:i:s'));
					$this->db->where("id", $data['id']);
					$this->db->update("booking_request", $update_array);
					$this->create_booking_live_consult($get_data->user_id, $get_data->astrologer_id, $get_data->price_per_mint, $get_data->type, $get_data->id, $get_data->member_id);
					$res = array("status" => true, "message" => "done");
					echo json_encode($res);
					die;
				} else {
					echo json_encode(['status' => false, 'message' => 'already ongoing booking']);
					die;
				}
			} elseif ($data['what'] == '2') {
				$update_array = array("status" => 2, "reject_date" => date('Y-m-d H:i:s'));
			} else {
				$update_array = array("status" => 2, "reject_date" => date('Y-m-d H:i:s'));
			}
			$this->db->where("id", $data['id']);
			$this->db->update("booking_request", $update_array);
			$res = array("status" => true, "message" => "done");
			echo json_encode($res);
		}
	}

	public function create_booking_live_consult($user_id, $astrologer_id, $price, $type, $id, $member_id)
	{
		if ($type == 2) {
			$ch = curl_init();
			$curlConfig = array(
				CURLOPT_URL            => "https://astrohelp24.com:5030/api/make_audio_call_astrologer",
				CURLOPT_POST           => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS     => array(
					'user_id' => $user_id,
					'astrologer_id' => $astrologer_id,
					'price_per_mint' => $price
				)
			);
			curl_setopt_array($ch, $curlConfig);
			$result = curl_exec($ch);
			curl_close($ch);
			return;
		}
		$date = date('Y-m-d H:i:s');
		$get_user = $this->w_m->get_user($user_id);
		// $wallet = $get_user->wallet;
		// $update_wallet = $wallet-$price;
		// $this->db->query("UPDATE `user` SET wallet='".$update_wallet."' WHERE `id`='".$user_id."'");
		// $transactions_array = array("user_id"=>$user_id,
		// 							"name"=>$get_user->name,
		// 							"booking_txn_id"=>time(),
		// 							"payment_mode"=>"wallet",
		// 							"txn_for"=>"Astrologer online consult",
		// 							"type"=>"debit",
		// 							"old_wallet"=>$wallet,
		// 							"txn_amount"=>$price,
		// 							"update_wallet"=>$update_wallet,
		// 							"status"=>1,
		// 							"txn_mode"=>"other",
		// 							"created_at"=>$date);
		// $this->db->insert("transactions",$transactions_array);
		// $transaction_id = $this->db->insert_id();
		// $get_astrologer = $this->w_m->get_user($user_id);


		$this->db->order_by('id', 'desc');
		if (!empty($member_id)) {
			$this->db->where('id', $member_id);
		}
		$member = $this->db->get_where('members', ['user_id' => $user_id, 'status' => 1])->row();
		$user_gender = '';
		$user_dob = '';
		$user_tob = '';
		$user_pob = '';
		if ($member) {
			$user_name = $member->name;
			$user_gender = $member->gender;
			$user_dob = $member->dob;
			$user_pob = $member->pob;
			$user_tob = $member->tob;
		} else {
			$user_name = $get_user->name;
			$user_gender = $get_user->gender;
			$user_dob = $get_user->dob;
			$user_pob = $get_user->place_of_birth;
			$user_tob = $get_user->birth_time;
		}

		// $user_name = $get_user->name;


		$array = array(
			"orderID" => 'AST' . $id,
			"user_id" => $user_id,
			"type" => $type,
			"booking_type" => 2,
			"assign_id" => $astrologer_id,
			"subtotal" => $price,
			"payable_amount" => $price,
			"coupon_code" => null,
			"booking_for" => 'self',
			"user_name" => $user_name,
			'member_id' =>  $member ? $member->id : 0,
			"user_phone" => $get_user->phone,
			"user_email" => $get_user->email,

			"user_gender" => $user_gender,
			"user_dob" => $user_dob,
			"user_tob" => $user_tob,
			"user_pob" => $user_pob,

			"schedule_date" => date('Y-m-d', strtotime($date)),
			"schedule_time" => date('H:i', strtotime($date)),
			"schedule_date_time" => $date,
			"start_time" => null,
			"payment_mode" => 'wallet',
			"status" => 0,
			"is_chat_or_video_start" => 1,
			"bridge_id" => time() . $id,
			"auto_intiate" => 1,
			"created_at" => $date,
			"price_per_mint" => $price,
		);
		$this->db->insert("bookings", $array);
		$booking_id = $this->db->insert_id();;
		// $this->db->query("UPDATE `transactions` SET `booking_id`='$booking_id' WHERE `id`='$transaction_id'");

	}

	public function booking_timer_status()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$booking_id = $data['booking_id'];
			$get_detail = $this->db->get_where("bookings", array("id" => $booking_id))->row();
			$start_or_end = 0;
			if ($get_detail->is_premium == 1) {
				// if($get_detail_->num_rows() > 0)
				// {
				$current_time = time();
				$booking_date_time_list = strtotime($get_detail->schedule_date_time);
				$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $get_detail->total_minutes . " minutes", $booking_date_time_list)));
				$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("-15 seconds", $booking_date_time_list)));
				if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
					if ($get_detail->status == 2) {
						$start_or_end = 0;
					} else {
						$start_or_end = 1;
					}
				}
				// }
			} else {
				if ($get_detail->status == 2) {
					$start_or_end = 0;
				} else {
					$start_or_end = 1;
				}
			}


			$response = array("status" => true, "start_or_end" => $start_or_end);
			echo json_encode($response);
		}
	}

	public function start_status_booking()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$booking_id = $data['booking_id'];
			$what = $data['what'];
			$from = $data['from'];
			$this->db->query("UPDATE `booking` SET `is_chat_or_video_start` = '$what' WHERE `id`='$booking_id'");
			if ($from == 'doctor') {
				$key = $this->db->get_where("booking", array("id" => $booking_id))->row();
				$title1 = "DISKUSS ONLINE CONSULTATION"; //"Your ".$key->online_mode." consultation is started";
				$doctor_detail = $this->db->get_where("doctor", array("id" => $key->doctor_id))->row();
				$message1 = "Your Online " . $key->online_mode . " Consulting Session with " . $doctor_detail->doctor_firstname . " is starting now at " . date('h:ia'); //"Your ".$key->online_mode." - with ".$doctor_detail->doctor_firstname." is started. Open anytimedoc app to counsult. Ignore if already start.";
				$patient_detail = $this->w_m->get_user($key->patient_id);
				$selected_android_user1 = array();
				if ($patient_detail->device_type == 'android') {
					if ($patient_detail->device_token != 'abc') {
						array_push($selected_android_user1, $patient_detail->device_token);
					}
				} elseif ($key->device_type == 'ios') {
					$this->w_m->send_ios_notification($patient_detail->device_token, $message1, $key->booking_mode);
				}
				if (count($selected_android_user1)) {
					$notification_type1 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title1 . '","msg":"' . $message1 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message2 = array(
						'body' => $message1,
						'title' => $title1,
						'sound' => 'default'
					);



					$a = $this->w_m->sendMessageThroughFCM($selected_android_user1, $message2);
				}
			}

			echo json_encode(array("status" => true));
		}
	}

	public function autoInitiate()
	{
		for ($i = 0; $i < 59; ++$i) {
			$today_date = date('Y-m-d');
			$get_booking = $this->db->query("SELECT * FROM `bookings` WHERE schedule_date = '$today_date' AND `type` IN ('1','2','3') AND `booking_type`='2' AND `status` = 0 AND `is_chat_or_video_start` = 0 AND `is_premium`='1'")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key) {
					$current_time = time();
					$booking_date_time = strtotime($key->schedule_date_time);
					$endTime = strtotime(date('Y-m-d H:i:s', strtotime("-6 seconds", $booking_date_time)));
					if ($current_time >= $endTime && $current_time < $booking_date_time) {

						$this->db->where("id", $key->id);
						$this->db->update("bookings", array("is_chat_or_video_start" => 1, "auto_intiate" => 1));
						$this->send_start_consult_notification_alert($key->assign_id, $key->user_id, $key->type);
						$this->common_notification($key->id, 'send_start_consult_notification_alert');
					}
				}
			}
			sleep(1);
		}
	}

	public function send_start_consult_notification_alert($doc_id, $user_id, $mode)
	{
		$url = base_url('notification_apps/to_doctor_start_consultation');
		$curl = curl_init();
		$post['doc_id'] = $doc_id; // our data todo in received
		$post['user_id'] = $user_id; // our data todo in received
		$post['mode'] = $mode; // our data todo in received
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
		return true;
	}

	public function astrologer_booking_done_complete()
	{
		$date = date('Y-m-d');
		for ($i = 0; $i < 30; ++$i) {
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_booking = $this->db->query("SELECT * FROM `bookings` WHERE schedule_date = '$date' AND `schedule_time` <> 'ANY TIME' AND `status` = 0 AND `type` IN ('1','2','3') AND `booking_type`='2' AND `is_premium`='1'")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key) {
					$current_time = time();
					$booking_date_time_list = strtotime($key->schedule_date_time);
					$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $key->total_minutes . " minutes", $booking_date_time_list)));
					$endTime_list_5seconds = strtotime(date('Y-m-d H:i:s', strtotime("+1 second", $endTime_list)));
					if ($current_time > $endTime_list) {
						// echo 1;
						// $get_user_name = $this->w_m->get_user($key->user_id);
						if ($key->is_chat_or_video_start == 2 || $key->is_chat_or_video_start == '2') {
							$status = 2;
							// $method = 'completed_booking';
							// $this->send_invoice_temp($key->id,'Booking completed!','complete');
						} elseif ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == '1') {
							$status = 2;
							// $method = 'completed_booking';
							// $this->send_invoice_temp($key->id,'Booking completed!','complete');
						} else {
							$status = 5;
							// $method = 'missed_booking';
						}
						$completed_on = date('Y-m-d H:i:s');
						$this->db->query("UPDATE `bookings` SET `complete_date`='" . $completed_on . "', `status` = '" . $status . "' WHERE `id` = '$key->id'");
						$this->common_notification($key->id, 'complete_astrologer_bookings');
					}
				}
			}
			sleep(1);
		}
	}



	public function last_chat_insert()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$booking_id = $data['booking_id'];
			$get_detail = $this->db->get_where("bookings", array("id" => $booking_id))->row();
			$mint = $get_detail->total_minutes;
			$current_time = time();
			$booking_date_time_list = strtotime($get_detail->schedule_date_time);
			$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $mint . " minutes", $booking_date_time_list)));
			$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("-15 seconds", $booking_date_time_list)));
			if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
				if ($get_detail->type == '3') {
					if ($get_detail->status == 1) {
						$start_or_end = 0;
					} else {
						$start_or_end = 1;
						$result = $this->last_chat_insert_($data);
					}
				} else {
					$start_or_end = 0;
				}
			} else {
				$start_or_end = 0;
			}

			$response = array("status" => true, "start_or_end" => $start_or_end);
			echo json_encode($response);
		}
	}

	public function last_chat_insert_($data)
	{
		$sender_id = $data['sender_id'];
		$sender_type = $data['sender_type'];
		$reciever_id = $data['reciever_id'];
		$reciever_type = $data['reciever_type'];
		$chat = $data['message'];
		$booking_id = $data['booking_id'];
		$chat_group_id = $data['chat_group_id'];
		$check = $this->db->get_where("astrologer_chat_history", array("sender_id" => $sender_id, "receiver_id" => $reciever_id))->row();
		$array = array("chat_group_id" => $chat_group_id, "sender_id" => $sender_id, "receiver_id" => $reciever_id, "booking_id" => $booking_id, "message" => $chat, "sender_type" => $sender_type, "reciever_type" => $reciever_type, "added_on" => date('Y-m-d H:i:s'));
		$this->db->insert("astrologer_chat_history", $array);
		$insert_id = $this->db->insert_id();
		if ($insert_id > 0) {
			if ($reciever_type == 'user') {
				$get_user = $this->db->get_where('user', array("id" => $reciever_id))->row();
				$astrologers = $this->db->get_where('astrologers', array("id" => $sender_id))->row();
				$imag = base_url('uploads/astrologers/') . $astrologers->image;
				$title1 = "[New Message] by " . $astrologers->name;
				$selected_android_user1 = array();
				$message1 = $chat;
				if ($get_user->device_type == 'android') {
					if ($get_user->device_token != 'abc') {
						array_push($selected_android_user1, $get_user->device_token);
					}
				} elseif ($get_user->device_type == 'ios') {
					$this->send_ios_notification($get_user->device_token, $message1, 'chat');
				}
				if (count($selected_android_user1)) {
					$notification_type1 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title1 . '","msg":"' . $message1 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message2 = array(
						'body' => $message1,
						'title' => $title1,
						'sound' => 'Default',
						'image' => $imag,
						'booking_id' => $booking_id,
						'sd_type' => 'chat'
					);

					$regIdChunk1 = array_chunk($selected_android_user1, 1000);
					foreach ($regIdChunk1 as $RegId1) {
						$a = $this->sendMessageThroughFCM($RegId1, $message2);
					}
				}
			} elseif ($reciever_type == 'astrologer') {
				$get_astrologers_details = $this->db->get_where('astrologers', array("id" => $reciever_id))->row();
				$get_u = $this->db->get_where('user', array("id" => $sender_id))->row();
				$imag = base_url('uploads/user/') . $get_u->image;
				$title1 = "[New Message] by " . $get_u->name;
				$selected_android_user1 = array();
				$message1 = $chat;
				if ($get_astrologers_details->device_type == 'android') {
					if ($get_astrologers_details->device_token != 'abc') {
						array_push($selected_android_user1, $get_astrologers_details->device_token);
					}
				} elseif ($get_astrologers_details->device_type == 'ios') {
					$this->send_ios_notification($get_astrologers_details->device_token, $message1, 'chat');
				}
				if (count($selected_android_user1)) {
					$notification_type1 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title1 . '","msg":"' . $message1 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message2 = array(
						'body' => $message1,
						'title' => $title1,
						'sound' => 'Default',
						'image' => $imag,
						'booking_id' => $booking_id,
						'sd_type' => 'chat'
					);

					$regIdChunk1 = array_chunk($selected_android_user1, 1000);
					foreach ($regIdChunk1 as $RegId1) {
						$a = $this->sendMessageThroughFCMastrologer($RegId1, $message2);
					}
				}
			}


			$array1 = array(
				"chat_id" => $insert_id,
				"chat_group_id" => $chat_group_id,
				"user_id" => $sender_id,
				"user_type" => $sender_type,
				"is_read" => 1
			);
			$array2 = array(
				"chat_id" => $insert_id,
				"chat_group_id" => $chat_group_id,
				"user_id" => $reciever_id,
				"user_type" => $reciever_type,
				"is_read" => 0
			);
			$this->db->insert('astrologer_chat_read', $array1);
			$this->db->insert('astrologer_chat_read', $array2);
		}
		$response = array("status" => true, "msg" => "insert successfully");
		return $response;
	}

	public function chat_history()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$history = array();

			$sorting_array = array();

			$user_member = [];
			$today_date = date('Y-m-d');

			$get_booking_ = $this->db->query("SELECT * FROM `bookings` WHERE schedule_date = '$today_date' AND `assign_id` = '" . $data['user_id'] . "' AND `type` IN ('1','2','3') AND `booking_type`='2' AND (`is_chat_or_video_start` = '1' or `is_chat_or_video_start` = '2') LIMIT 1");
			if ($get_booking_->num_rows() > 0) {
				$get_booking = $get_booking_->row();

				$this->db->order_by('id', 'desc');
				$user_member = $this->db->get_where('members', ['user_id' => $get_booking->user_id, 'is_default' => 1])->row();
			}

			$check_chat_history = $this->db->query("SELECT p1.* 
													FROM astrologer_chat_history p1
													INNER JOIN
													(
													    SELECT max(id) MaxId, chat_group_id
													    FROM astrologer_chat_history
													    WHERE `sender_id` = '" . $user_id . "' OR `receiver_id` = '" . $user_id . "'
													    GROUP BY chat_group_id
													) p2
													  ON p1.chat_group_id = p2.chat_group_id
													  AND p1.id = p2.MaxId
													order by p1.id desc")->result();
			if (count($check_chat_history) > 0) {
				foreach ($check_chat_history as $key) {
					$total_unread_message = $this->db->query("SELECT COUNT(*) AS A FROM `astrologer_chat_read` WHERE `chat_group_id` = '" . $key->chat_group_id . "' AND `user_id` = '" . $user_id . "' AND `is_read` = '0'")->row();
					$is_read_ = $this->db->get_where("astrologer_chat_read", array("user_id" => $data['user_id'], "chat_id" => $key->id, "chat_group_id" => $key->chat_group_id));
					if ($is_read_->num_rows() > 0) {
						$is_read = $is_read_->row();
						if ($is_read->is_read == 0) {
							$is_read_by_user = 0;
						} else {
							$is_read_by_user = 1;
						}
					} else {
						$is_read_by_user = 0;
					}
					$get_booking_details = $this->db->get_where("bookings", array("id" => $key->booking_id))->row();
					if ($key->sender_id == $user_id) {
						$is_user = 1;
					} else {
						$is_user = 0;
					}

					$b_time = $get_booking_details->schedule_time;

					$sender_type = $key->sender_type;
					$receiver_type = $key->reciever_type;
					if ($key->sender_type == 'astrologer') {
						$astrologers = $this->db->get_where("astrologers", array("id" => $key->sender_id))->row();
						$sender_name = $astrologers->name;
						$sender_image = base_url('uploads/astrologers/') . '/' . $astrologers->image;


						$user_details = $this->db->get_where("user", array("id" => $key->receiver_id))->row();

						$receiver_name = $user_details->name;
						$receiver_image = base_url('uploads/user/') . '/' . $user_details->image;
						$reciever_type = $key->reciever_type;
					} elseif ($key->sender_type == 'user') {
						$astrologers = $this->db->get_where("astrologers", array("id" => $key->receiver_id))->row();
						$receiver_name = $astrologers->name;
						$receiver_image = base_url('uploads/astrologers/') . '/' . $astrologers->image;

						$user_details = $this->db->get_where("user", array("id" => $key->sender_id))->row();
						$sender_name = $user_details->name;
						$sender_image = base_url('uploads/user/') . '/' . $user_details->image;
					}


					$time2 = time();
					$comment_time2 = strtotime($key->added_on);
					$difference2 = round(abs($time2 - $comment_time2) / 3600, 2);
					$date2 = date('d M Y');
					$comment_date2 = date('d M Y', strtotime($key->added_on));
					if ($difference2 > 168) {
						$time_comment2 = $this->datediff('ww', $comment_date2, $date2, false) . ' weeks ago';
					} elseif ($difference2 > 24) {
						$time_comment2 = $this->datediff('d', $comment_date2, $date2, false) . ' Days ago';
					} else {
						$date2 = date('d M Y H:i:s');
						$comment_date2 = date('d M Y H:i:s', strtotime($key->added_on));
						$time_comment2 = $this->datediff('h', $comment_date2, $date2, false) . ' Hours ago';
					}


					$sorting_array[$comment_time2] = array(
						"chat_id" => $key->id,
						"chat_group_id" => $key->chat_group_id,
						"sender_id" => $key->sender_id,
						"sender_name" => $sender_name,
						"sender_image" => $sender_image,
						"sender_type" => $sender_type,
						"reciever_id" => $key->receiver_id,
						"receiver_name" => $receiver_name,
						"receiver_image" => $receiver_image,
						"reciever_type" => $receiver_type,
						"is_user" => $is_user,
						"message" => $key->message,
						"added_on" => $time_comment2,
						"booking_id" => $get_booking_details->id,
						"booking_date" => $get_booking_details->schedule_date,
						"booking_time" => $b_time,
						"is_read" => $is_read_by_user,
						"total_unread_messages" => $total_unread_message->A,
						'user_member' => [
							'id' => $get_booking_details->member_id,
							'user_id' => $get_booking_details->user_id,
							'type' => 'host',
							'name' => $get_booking_details->user_name,
							'fathername' => '',
							'mothername' => '',
							'email' => $get_booking_details->user_email,
							'phone' => $get_booking_details->user_phone,
							'zodiac' => '',
							'occupation' => '',
							'language' => '',
							'message' => $get_booking_details->message,
							'dob' => $get_booking_details->user_dob,
							'tob' => $get_booking_details->user_tob,
							'gender' => $get_booking_details->user_gender,
							'pob' => $get_booking_details->user_pob,
							'gotro' => $get_booking_details->user_gotro,
							'spouse' => $get_booking_details->user_spouse,
							'relation' => '',
							'location' => '',
							'latitude' => '',
							'longitude' => '',
							'status' => 1,
							'created_at' => ''
						]
					);
				}
			}

			if (!empty($sorting_array)) {
				krsort($sorting_array);
				foreach ($sorting_array as $sort_key) {
					$history[] = array(
						"chat_id" => $sort_key['chat_id'],
						"chat_group_id" => $sort_key['chat_group_id'],
						"sender_id" => $sort_key['sender_id'],
						"sender_name" => $sort_key['sender_name'],
						"sender_image" => $sort_key['sender_image'],
						"sender_type" => $sort_key['sender_type'],
						"reciever_id" => $sort_key['reciever_id'],
						"receiver_name" => $sort_key['receiver_name'],
						"receiver_image" => $sort_key['receiver_image'],
						"reciever_type" => $sort_key['reciever_type'],
						"is_user" => $sort_key['is_user'],
						"message" => $sort_key['message'],
						"added_on" => $sort_key['added_on'],
						"booking_id" => $sort_key['booking_id'],
						"booking_date" => $sort_key['booking_date'],
						"booking_time" => $sort_key['booking_time'],
						"is_read" => $sort_key['is_read'],
						"total_unread_messages" => $sort_key['total_unread_messages'],
						'user_member' => $user_member,
					);
				}
			} else {
				$history = array();
			}
			$response = array("status" => true, "history" => $history);
			echo json_encode($response);
		}
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
				if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom) + $years_difference) > $dateto) {
					$years_difference--;
				}

				if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto) - ($years_difference + 1)) > $datefrom) {
					$years_difference++;
				}

				$datediff = $years_difference;
				break;

			case "q": // Number of full quarters
				$quarters_difference = floor($difference / 8035200);

				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($quarters_difference * 3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
					$months_difference++;
				}

				$quarters_difference--;
				$datediff = $quarters_difference;
				break;

			case "m": // Number of full months
				$months_difference = floor($difference / 2678400);

				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
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


	public function chat_read_as_us()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$this->db->query("UPDATE `astrologer_chat_read` SET `is_read` = '1' WHERE `chat_group_id`='" . $data['chat_group_id'] . "' AND `user_type`='" . $data['user_type'] . "' AND `user_id`='" . $data['user_id'] . "'");
			$response = array("status" => true, "msg" => "read successfully");
			echo json_encode($response);
		}
	}

	public function call_history()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$specific_date = $data['specific_date'];
			$specific_date_end = $data['specific_date_end'];
			$where = '';
			if ($specific_date) {
				$where .= "AND DATE(`schedule_date`)>='" . $specific_date . "' AND DATE(`schedule_date`)<='" . $specific_date_end . "'";
			}
			$date = date('Y-m-d');
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_booking = $this->db->query("SELECT * FROM `bookings` WHERE `assign_id` = '" . $data['user_id'] . "' AND `type` = 2 $where ORDER BY schedule_date_time DESC")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key) {
					$imaggess = '';
					$booking_mode = 'Audio Consult';
					$apoint_date = $key->schedule_date;
					if (strtotime($date) <= strtotime($apoint_date)) {
						$diff = strtotime($apoint_date) - strtotime($date);
						$remain_date = round($diff / (60 * 60 * 24));
					} else {
						$remain_date = 0;
					}

					$start_time = $key->schedule_time;
					$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->schedule_time)));
					$total_appointment_time = strtotime($key->schedule_date . ' ' . $key->schedule_time);
					$time_remain = 60 * 60 * 1;
					$before_three_hours_date = strtotime($key->schedule_date . ' ' . $key->schedule_time) - $time_remain;
					if ($total_appointment_time > $current_date_time) {
						$complete_power = 1;
						$accept_power = 1;
						$cancel_power = 1;
					} else {
						$complete_power = 0;
						$accept_power = 0;
						$cancel_power = 0;
					}
					$booking_status = '';
					if ($key->status == 0) {
						$complete_power = 1;
						$booking_status = 'pending';
					} elseif ($key->status == 2) {
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
						$booking_status = 'complete';
					} elseif ($key->status == 3 || $key->status == 5) {
						$booking_status = 'cancel';
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
					}

					$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();
					if ($key->booking_for != 'self') {
						$img = 'default.png';
					} else {
						$img = $user_detail->image;
					}

					$coupan_code_create = 0;
					if ($key->status == 2) {
						$check_cc = $this->db->get_where('astrologer_coupans', array("astrologer_id" => $data['user_id'], 'user_id' => $key->user_id, 'booking_id' => $key->id));
						if ($check_cc->num_rows() > 0) {
						} else {
							$coupan_code_create = 1;
						}
					}


					$booking_list[] = array(
						"id" => $key->id,
						"status" => $key->status,
						"online_mode" => 'audio',
						"user_id" => $key->user_id,
						"booking_for" => $key->booking_for,
						"booking_mode" => $booking_mode,
						"name" => $key->user_name,
						"booking_date" => date('d M Y', strtotime($key->schedule_date)) . ', ' . date('h:i A', strtotime($key->schedule_time)),
						"accept_power" => $accept_power,
						"complete_power" => $complete_power,
						"cancel_power" => $cancel_power,
						"remain_date" => $remain_date,
						"total_minutes" => $key->total_minutes,
						"start_time_end_time" => $start_time . ' TO ' . $endTime,
						"is_prescription" => '',
						"booking_status" => $booking_status,
						"coupan_code_create" => $coupan_code_create,
						'payable_amount' => $key->payable_amount,
						'astrologer_comission_amount' => $key->astrologer_comission_amount
					);
				}
				$response = array("status" => true, "lists" => $booking_list);
			} else {
				$response = array("status" => false, "message" => "no booking found");
			}
			echo json_encode($response);
		}
	}


	public function horoscope_history()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			// videos
			// $limit_count = 6;
			$limit_from = 0; //$data['limit_from'];
			$user_id = $data['user_id'];
			$fetch_status = isset($data['status']) ? $data['status'] : '';
			if ($fetch_status == 'pending') {

				$query = "SELECT * FROM `bookings` WHERE `assign_id` = '$user_id' AND `booking_type`='2' AND `type`='4' AND status IN(0,1) ORDER BY `created_at` DESC ";
			} elseif ($fetch_status == 'complete') {
				$query = "SELECT * FROM `bookings` WHERE `assign_id` = '$user_id' AND `booking_type`='2' AND `type`='4' AND status=2 ORDER BY `created_at` DESC ";
			} else {

				$query = "SELECT * FROM `bookings` WHERE `assign_id` = '$user_id' AND `booking_type`='2' AND `type`='4' ORDER BY `created_at` DESC "; //LIMIT $limit_from,$limit_count";
			}
			$all_list = $this->db->query($query)->result();
			if (count($all_list) > 0) {
				foreach ($all_list as $key) {
					$imaggess = array();
					if ($key->uploads_doc) {
						$img = explode('||', $key->uploads_doc);
						foreach ($img as $key2) {
							$r1img = explode(',', $key2);
							if (isset($r1img[0]) && isset($r1img[1])) {
								$path_r1img = $r1img[0];
								$type_r1img = $r1img[1];
								$imar = array(
									"path" => base_url('uploads/horoscope_matching/') . '/' . $path_r1img,
									"type" => $type_r1img
								);
								array_push($imaggess, $imar);
							}
						}
					}

					if ($key->status == 0) {
						$stat_us = 'new';
					} elseif ($key->status == 1) {
						$stat_us = 'confirmed';
					} elseif ($key->status == 2) {
						$stat_us = 'completed';
					} elseif ($key->status == 3) {
						$stat_us = 'cancel';
					} elseif ($key->status == 4) {
						$stat_us = 'refund';
					} else {
						$stat_us = '-';
					}

					$lists[] = array(
						"id" => $key->id,
						"user_id" => $key->user_id,
						"user_name" => is_null($key->user_name) ? '' : $key->user_name,
						"user_phone" => $key->user_phone,
						"user_email" => is_null($key->user_email) ? '' : $key->user_email,
						"user_gender" => is_null($key->user_gender) ? '' : $key->user_gender,
						"user_dob" => is_null($key->user_dob) ? '' : $key->user_dob,
						"user_tob" => is_null($key->user_tob) ? '' : $key->user_tob,
						"user_pob" => is_null($key->user_pob) ? '' : $key->user_pob,
						"user_fathername" => is_null($key->user_fathername) ? '' : $key->user_fathername,
						"user_mothername" => is_null($key->user_mothername) ? '' : $key->user_mothername,
						"occupation" => "",
						"problem_area" => $key->message,
						"horoscope_message" => $key->horoscope_message,
						"status" => $key->status,
						"added_on" => date('d/m/Y', strtotime($key->created_at)),
						"time" => date('h:ia', strtotime($key->created_at)),
						"stat_us" => $stat_us,
						"imagess" => $imaggess,
						"zodiac_sign" => $key->zodiac_sign,
						"address" => $key->address,
						"payable_amount" => $key->payable_amount,
						"horoscope_name" => $key->horoscope_name,
						'astrologer_comission_amount' => $key->astrologer_comission_amount
					);
				}
				$response = array("status" => true, "lists" => $lists, "limit_from" => $limit_from);
			} else {
				$lists = array();
				$response = array("status" => false, "lists" => $lists, "limit_from" => $limit_from);
			}
			// echo $query;die;

			echo json_encode($response);
		}
	}


	// Prescription for Video document uploads by doctor
	public function image_attchment_upload_horoscope()
	{
		$user_id = $this->input->post('user_id');
		$id = $this->input->post('id');
		$flag = $this->input->post('flag');
		$response = array("status" => false, "msg" => "image upload falied plesae try again latter thanks");
		if ($flag == '1') {
			$target_path = "uploads/horoscope_matching/";
			$target_dir = "uploads/horoscope_matching/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$type = '';
				if ($_FILES["image"]["type"] == 'image/png') {
					$type = 'image';
				} elseif ($_FILES["image"]["type"] == 'image/jpeg') {
					$type = 'image';
				} elseif ($_FILES["image"]["type"] == 'application/pdf') {
					$type = 'pdf';
				} elseif ($_FILES["image"]["type"] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
					$type = 'docs';
				}
				if ($type != '') {
					$imagename = basename($_FILES["image"]["name"]);
					$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
					$actual_image_name = "HOROSCOPE" . time() . "." . $extension;
					move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
					if (!empty($actual_image_name) && !empty($extension)) {
						$array = array(
							"user_id" => $user_id,
							"booking_id" => $id, "type" => $type, "image" => $actual_image_name
						);
						$this->db->insert('horoscope_temporary_images', $array);
						$get_images = $this->db->get_where("horoscope_temporary_images", array("user_id" => $user_id, "booking_id" => $id))->result();
						$response = array("status" => true, "msg" => "Add Successfully", "images" => $get_images, "path" => base_url('uploads/horoscope_matching') . '/');
					}
				}
			}
		}
		echo json_encode($response);
	}

	// Remove all images of video bookings by doctor
	public function delete_images_horoscope()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$r_ = $this->db->get_where("horoscope_temporary_images", array("user_id" => $data['user_id'], "id" => $data['file_id']));
			if ($r_->num_rows() > 0) {
				$r = $r_->row();
				// foreach ($r as $key) 
				// {
				if (file_exists(FCPATH . "uploads/horoscope_matching/" . $r->image)) {
					unlink(FCPATH . "uploads/horoscope_matching/" . $r->image);
				}
				// }
				$this->db->query("DELETE FROM `horoscope_temporary_images` WHERE `user_id` = '" . $data['user_id'] . "' AND `id` = '" . $data['file_id'] . "'");
			}
			$r2 = $this->db->get_where("horoscope_temporary_images", array("user_id" => $data['user_id'], "booking_id" => $data['id']))->result();
			$response = array("status" => true, "msg" => "Delete successfully", "list_of_images" => $r2, "path" => base_url('uploads/horoscope_matching') . '/');
			echo json_encode($response);
		}
	}

	public function list_upload_horoscope()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$r2 = $this->db->get_where("horoscope_temporary_images", array("user_id" => $data['user_id'], "booking_id" => $data['id']))->result();
			if (count($r2) > 0) {
				$response = array("status" => true, "list" => $r2, "path" => base_url('uploads/horoscope_matching') . '/');
			} else {
				$response = array("status" => false, "message" => "not_found");
			}
			echo json_encode($response);
		}
	}


	public function complete_horoscope()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$date = date('Y-m-d');
			$key_ = $this->db->query("SELECT * FROM `bookings` WHERE `id`='" . $data['id'] . "' AND `status` = 0");
			if ($key_->num_rows() > 0) {
				$key = $key_->row();
				$astrologer_name = 'Astrologer';
				$astrologer_ = $this->db->query("SELECT * FROM `astrologers` WHERE `id`='" . $key->assign_id . "'");
				if ($astrologer_->num_rows() > 0) {
					$astrologer = $astrologer_->row();
					$astrologer_name = $astrologer->name;
				}
				$get_user_name = $this->db->get_where("user", array("id" => $key->user_id))->row();
				$date_time = date('Y-m-d H:i:s');
				$this->db->query("UPDATE `bookings` SET `status` = '2',`updated_at`='$date_time',`horoscope_message`='" . $data['horoscope_message'] . "',`uploads_doc`='" . $data['uploads_doc'] . "' WHERE `id` = '$key->id'");
				$this->load->model('ApiCommonNotify');
				$settings = $this->w_m->get_settings();
				// send to patient notification
				$title2 = "Your Horoscope booking completed successfully!";
				$message2 = "Your Horoscope booking completed successfully -" . date('d M Y', strtotime($date_time)) . ' with ' . $astrologer_name;
				$selected_android_user2 = array();
				if ($get_user_name->device_type == 'android') {
					if ($get_user_name->device_token != 'abc') {
						array_push($selected_android_user2, $get_user_name->device_token);
					}
				} elseif ($get_user_name->device_type == 'ios') {
					//$this->send_ios_notification($get_user_name->device_token,$message2,$key->booking_mode);
				}
				if (count($selected_android_user2)) {
					$notification_type2 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type2 . '","title":"' . $title2 . '","msg":"' . $message2 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message3 = array(
						'body' => $message2,
						'title' => $title2,
						'sound' => 'default'
					);

					$a = $this->ApiCommonNotify->sendMessageThroughFCM($selected_android_user2, $message3, $settings->firebase_key);
				}
				// $this->ApiCommonNotify->send_invoice_temp($data['id'],'Booking completed!','complete');

				$sms_message_user = $message2;
				$this->ApiCommonNotify->send_sms($key->user_phone, $sms_message_user, '+91');
				$response = array("status" => true, "message" => "done");
			} else {
				$response = array("status" => true, "message" => "no booking found");
			}
			echo json_encode($response);
		}
	}

	public function video_history()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$specific_date = $data['specific_date'];
			$specific_date_end = $data['specific_date_end'];
			$where = '';
			if ($specific_date) {
				$where .= "AND DATE(`schedule_date`)>='" . $specific_date . "' AND DATE(`schedule_date`)<='" . $specific_date_end . "'";
			}
			$date = date('Y-m-d');
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_booking = $this->db->query("SELECT * FROM `bookings` WHERE `assign_id` = '" . $data['user_id'] . "' AND `type` = 1 $where ORDER BY schedule_date_time DESC")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key) {
					$imaggess = '';
					$booking_mode = 'Video Consult';
					$apoint_date = $key->schedule_date;
					if (strtotime($date) <= strtotime($apoint_date)) {
						$diff = strtotime($apoint_date) - strtotime($date);
						$remain_date = round($diff / (60 * 60 * 24));
					} else {
						$remain_date = 0;
					}

					$start_time = $key->schedule_time;
					$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->schedule_time)));
					$total_appointment_time = strtotime($key->schedule_date . ' ' . $key->schedule_time);
					$time_remain = 60 * 60 * 1;
					$before_three_hours_date = strtotime($key->schedule_date . ' ' . $key->schedule_time) - $time_remain;
					if ($total_appointment_time > $current_date_time) {
						$complete_power = 1;
						$accept_power = 1;
						$cancel_power = 1;
					} else {
						$complete_power = 0;
						$accept_power = 0;
						$cancel_power = 0;
					}
					$booking_status = '';
					if ($key->status == 0) {
						$complete_power = 1;
						$booking_status = 'pending';
					} elseif ($key->status == 2) {
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
						$booking_status = 'confirm';
					} elseif ($key->status == 3 || $key->status == 5) {
						$booking_status = 'cancel';
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
					} elseif ($key->status == 2) {
						$booking_status = 'completed';
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
					}


					$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();
					if ($key->booking_for != 'self') {
						$img = 'default.png';
					} else {
						$img = $user_detail->image;
					}

					$coupan_code_create = 0;
					if ($key->status == 2) {
						$check_cc = $this->db->get_where('astrologer_coupans', array("astrologer_id" => $data['user_id'], 'user_id' => $key->user_id, 'booking_id' => $key->id));
						if ($check_cc->num_rows() > 0) {
						} else {
							$coupan_code_create = 1;
						}
					}

					$booking_list[] = array(
						"id" => $key->id,
						"status" => $key->status,
						"online_mode" => 'video',
						"user_id" => $key->user_id,
						"booking_for" => $key->booking_for,
						"booking_mode" => $booking_mode,
						"name" => $key->user_name,
						"booking_date" => date('d M Y', strtotime($key->schedule_date)) . ', ' . date('h:i A', strtotime($key->schedule_time)),
						"accept_power" => $accept_power,
						"complete_power" => $complete_power,
						"cancel_power" => $cancel_power,
						"remain_date" => $remain_date,
						"total_minutes" => $key->total_minutes,
						"start_time_end_time" => $start_time . ' TO ' . $endTime,
						"is_prescription" => '',
						"booking_status" => $booking_status,
						"coupan_code_create" => $coupan_code_create,
						'payable_amount' => $key->payable_amount,
						'astrologer_comission_amount' => $key->astrologer_comission_amount
					);
				}
				$response = array("status" => true, "lists" => $booking_list);
			} else {
				$response = array("status" => false, "message" => "no booking found");
			}
			echo json_encode($response);
		}
	}

	public function astrologers_earning()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$total_income = 0;
		$paid = 0;
		if (isset($data) && !empty($data)) {
			// $dateFilter = '';
			// if(array_key_exists('form_date', $data) && array_key_exists('to_date', $data)) {
			// 	$formDate = date('Y-m-d', strtotime($data['from_date']));
			// 	$toDate = date('Y-m-d', strtotime($data['to_date']));
			// 	$dateFilter = "' AND DATE(created_at) between $formDate and $toDate ";
			// }
			$list = array();

			$user_id = $data['user_id'];
			if ($data['condition'] == '10 data') {
				$total_income_ = $this->db->query("SELECT SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2'  ORDER BY `id` DESC LIMIT 10");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' ORDER BY `id` DESC LIMIT 10")->result();
				$comission = $this->db->query("SELECT SUM(astrologer_comission_amount) 
				AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND is_comission_paid = 1 ORDER BY `id` DESC LIMIT 10")->result();

				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} elseif ($data['condition'] == 'weekly') {
				$total_income_ = $this->db->query("SELECT SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+6 DAY AND DATE(`schedule_date`) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-1 DAY");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * from bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+6 DAY AND DATE(`schedule_date`) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-1 DAY")->result();
				

				$comission = $this->db->query("SELECT SUM(astrologer_comission_amount) 
				AS TotalQuantity from bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+6 DAY AND DATE(`schedule_date`) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-1 DAY AND is_comission_paid = 1")->result();
				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} elseif ($data['condition'] == 'month') {
				$total_income_ = $this->db->query("SELECT SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()")->result();

				$comission = $this->db->query("SELECT SUM(astrologer_comission_amount) 
				AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() AND is_comission_paid = 1")->result();
				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} elseif ($data['condition'] == 'prev_month') {
				$total_income_ = $this->db->query("SELECT SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01 00:00:00') AND DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), '%Y-%m-%d 23:59:59')");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}

				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01 00:00:00') AND DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), '%Y-%m-%d 23:59:59')")->result();

				$comission = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01 00:00:00') AND DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), '%Y-%m-%d 23:59:59') AND is_comission_paid = 1")->result();
				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} elseif ($data['condition'] == 'specific_date') {
				$total_income_ = $this->db->query("SELECT COUNT(`id`) AS A,SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "'");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "'")->result();
				$comission = $this->db->query("SELECT SUM(astrologer_comission_amount) 
				AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND DATE(`schedule_date`) BETWEEN '" . $data['start_date'] . "' AND '" . $data['end_date'] . "' AND is_comission_paid = 1")->result();
				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$total_income = $total_income;
				$paid = (float) $com;
			} elseif ($data['condition'] == 'video') {
				$total_income_ = $this->db->query("SELECT COUNT(`id`) AS A,SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `type`='1' AND  `status` = '2'");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='1' AND  `status` = '2'")->result();
				$comission = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='1' AND  `status` = '2'  AND is_comission_paid = 1")->result();

				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} elseif ($data['condition'] == 'audio') {
				$total_income_ = $this->db->query("SELECT COUNT(`id`) AS A,SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `type`='2' AND  `status` = '2'");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='2' AND  `status` = '2'")->result();

				$comission = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='2' AND  `status` = '2' AND is_comission_paid = 1")->result();
				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} elseif ($data['condition'] == 'chat') {
				$total_income_ = $this->db->query("SELECT COUNT(`id`) AS A,SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `type`='3' AND  `status` = '2'");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='3' AND  `status` = '2'")->result();

				$comission = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='3' AND  `status` = '2' AND is_comission_paid = 1")->result();

				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} elseif ($data['condition'] == 'report') {
				$total_income_ = $this->db->query("SELECT COUNT(`id`) AS A,SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `type`='4' AND  `status` = '2'");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='4' AND  `status` = '2'")->result();
				$comission = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `type`='4' AND  `status` = '2' AND is_comission_paid = 1")->result();
				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			} else {
				$total_income_ = $this->db->query("SELECT COUNT(`id`) AS A,SUM(astrologer_comission_amount) 
					AS TotalQuantity FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2'");
				if ($total_income_->num_rows() > 0) {
					$a = $total_income_->row();
					$total_income = $a->TotalQuantity;
				}
				$list = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2'")->result();
				$comission = $this->db->query("SELECT * FROM bookings WHERE `assign_id` = '$user_id' AND `status` = '2' AND is_comission_paid = 1")->result();
				$com = 0;
				foreach ($comission as $c) {
					$com += (float)  $c->TotalQuantity;
				}
				$paid = (float) $com;
			}

			$unpaid = round((float) $total_income - (float) $paid, 2);
			$response = array(
				"status" => true, "list" => $list,
				"total_income" => is_null($total_income) ? '0' : $total_income,
				'paid_commission' => is_null($paid) ? 0 : $paid,
				'unpaid_commission' => is_null($unpaid) ? 0 : $unpaid,

			);
			echo json_encode($response);
		}
	}

	public function my_booking()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$specific_date = $data['specific_date'];
			$specific_date_end = $data['specific_date_end'];
			$where = '';
			if ($specific_date) {
				$where .= "AND DATE(`schedule_date`)>='" . $specific_date . "' AND DATE(`schedule_date`)<='" . $specific_date_end . "'";
			}
			$date = date('Y-m-d');
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_booking = $this->db->query("SELECT * FROM `bookings` WHERE `assign_id` = '" . $data['user_id'] . "' AND `type` IN (1,2,3,4) $where ORDER BY created_at DESC")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key) {
					$imaggess = '';
					$booking_mode = '';
					if ($key->type == '1') {
						$booking_mode = 'Video Consult';
					} elseif ($key->type == '2') {
						$booking_mode = 'Audio Consult';
					} elseif ($key->type == '3') {
						$booking_mode = 'Chat Consult';
					} elseif ($key->type == '4') {
						$booking_mode = 'Horoscope Consult';
					}
					$apoint_date = $key->schedule_date;
					if (strtotime($date) <= strtotime($apoint_date)) {
						$diff = strtotime($apoint_date) - strtotime($date);
						$remain_date = round($diff / (60 * 60 * 24));
					} else {
						$remain_date = 0;
					}


					$complete_power = 0;
					$accept_power = 0;
					$cancel_power = 0;
					$start_time = '';
					$endTime = '';
					$booking_status = '';
					$coupan_code_create = 0;
					if ($key->type != 4 && $key->is_premium == 1) {
						$start_time = $key->schedule_time;
						$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->schedule_time)));
						$total_appointment_time = strtotime($key->schedule_date_time);
						$time_remain = 60 * 60 * 1;
						$before_three_hours_date = strtotime($key->schedule_date_time) - $time_remain;
						if ($before_three_hours_date > $current_date_time) {
							$complete_power = 1;
							$accept_power = 1;
							$cancel_power = 1;
						}
						if ($key->status == 2) {
							$check_cc = $this->db->get_where('astrologer_coupans', array("astrologer_id" => $data['user_id'], 'user_id' => $key->user_id, 'booking_id' => $key->id));
							if ($check_cc->num_rows() > 0) {
							} else {
								$coupan_code_create = 1;
							}
						}
					}
					if ($key->status == 0) {
						$complete_power = 1;
						$booking_status = 'pending';
					} elseif ($key->status == 1) {
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
						$booking_status = 'confirm';
					} elseif ($key->status == 3 || $key->status == 5) {
						$booking_status = 'cancel';
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
					} elseif ($key->status == 2) {
						$booking_status = 'completed';
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
					}


					$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();
					if ($key->booking_for != 'self') {
						$img = 'default.png';
					} else {
						$img = $user_detail->image;
					}

					$imaggess = array();
					if ($key->uploads_doc) //!is_null($key->uploads_doc) OR !empty($key->uploads_doc))
					{
						$img = explode('||', $key->uploads_doc);
						foreach ($img as $key2) {
							$r1img = explode(',', $key2);
							$path_r1img = $r1img[0];
							$type_r1img = $r1img[1];

							$imar = array(
								"path" => base_url('uploads/horoscope_matching/') . '/' . $path_r1img,
								"type" => $type_r1img
							);
							array_push($imaggess, $imar);
						}
					}



					$booking_list[] = array(
						"id" => $key->id,
						"orderID" => $key->orderID,
						"status" => $key->status,
						"booking_type" => $key->type,
						"user_id" => $key->user_id,
						"booking_for" => $key->booking_for,
						"booking_mode" => $booking_mode,
						"name" => $key->user_name,
						"booking_date" => date('d M Y', strtotime($key->schedule_date)) . ', ' . date('h:i A', strtotime($key->schedule_time)),
						"accept_power" => $accept_power,
						"complete_power" => $complete_power,
						"cancel_power" => $cancel_power,
						"remain_date" => $remain_date,
						"total_minutes" => $key->total_minutes,
						"time_minutes" => $key->time_minutes,
						"start_time_end_time" => $start_time . ' TO ' . $endTime,
						"is_prescription" => '',
						"booking_status" => $booking_status,
						"user_name" => is_null($key->user_name) ? '' : $key->user_name,
						"user_phone" => $key->user_phone,
						"user_email" => is_null($key->user_email) ? '' : $key->user_email,
						"user_gender" => is_null($key->user_gender) ? '' : $key->user_gender,
						"user_dob" => is_null($key->user_dob) ? '' : $key->user_dob,
						"user_tob" => is_null($key->user_tob) ? '' : $key->user_tob,
						"user_pob" => is_null($key->user_pob) ? '' : $key->user_pob,
						"user_fathername" => is_null($key->user_fathername) ? '' : $key->user_fathername,
						"user_mothername" => is_null($key->user_mothername) ? '' : $key->user_mothername,
						"imagess" => $imaggess,
						"coupan_code_create" => $coupan_code_create
					);
				}
				$response = array("status" => true, "lists" => $booking_list);
			} else {
				$response = array("status" => false, "message" => "no booking found");
			}
			echo json_encode($response);
		}
	}

	public function my_schedule_bookings()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$specific_date = $data['specific_date'];
			$specific_date_end = $data['specific_date_end'];
			$where = '';
			if ($specific_date) {
				$where .= "AND DATE(`schedule_date`)>='" . $specific_date . "' AND DATE(`schedule_date`)<='" . $specific_date_end . "'";
			}
			$date = date('Y-m-d');
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_booking = $this->db->query("SELECT * FROM `bookings` WHERE `assign_id` = '" . $data['user_id'] . "' AND `is_premium`='1' AND `type` IN (1,2,3) $where ORDER BY schedule_date_time DESC")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key) {
					$imaggess = '';
					$booking_mode = '';
					if ($key->type == '1') {
						$booking_mode = 'Video Consult';
					} elseif ($key->type == '2') {
						$booking_mode = 'Audio Consult';
					} elseif ($key->type == '3') {
						$booking_mode = 'Chat Consult';
					} elseif ($key->type == '4') {
						$booking_mode = 'Horoscope Consult';
					}
					$apoint_date = $key->schedule_date;
					if (strtotime($date) <= strtotime($apoint_date)) {
						$diff = strtotime($apoint_date) - strtotime($date);
						$remain_date = round($diff / (60 * 60 * 24));
					} else {
						$remain_date = 0;
					}


					$complete_power = 0;
					$accept_power = 0;
					$cancel_power = 0;
					$start_time = '';
					$endTime = '';
					$coupan_code_create = 0;

					if ($key->type != 4 && $key->is_premium == 1) {
						$start_time = $key->schedule_time;
						$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->schedule_time)));
						$total_appointment_time = strtotime($key->schedule_date_time);
						$time_remain = 60 * 60 * 1;
						$before_three_hours_date = strtotime($key->schedule_date_time) - $time_remain;
						if ($before_three_hours_date > $current_date_time) {
							$complete_power = 1;
							$accept_power = 1;
							$cancel_power = 1;
						}
						if ($key->status == 2) {
							$check_cc = $this->db->get_where('astrologer_coupans', array("astrologer_id" => $data['user_id'], 'user_id' => $key->user_id, 'booking_id' => $key->id));
							if ($check_cc->num_rows() > 0) {
							} else {
								$coupan_code_create = 1;
							}
						}
					}
					if ($key->status == 0) {
						$complete_power = 1;
						$booking_status = 'pending';
					} elseif ($key->status == 1) {
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
						$booking_status = 'confirm';
					} elseif ($key->status == 3 || $key->status == 5) {
						$booking_status = 'cancel';
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
					} elseif ($key->status == 2) {
						$booking_status = 'completed';
						$accept_power = 0;
						$complete_power = 0;
						$cancel_power = 0;
					}


					$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();
					if ($key->booking_for != 'self') {
						$img = 'default.png';
					} else {
						$img = $user_detail->image;
					}

					$imaggess = array();
					if ($key->uploads_doc) //!is_null($key->uploads_doc) OR !empty($key->uploads_doc))
					{
						$img = explode('||', $key->uploads_doc);
						foreach ($img as $key2) {
							$r1img = explode(',', $key2);
							$path_r1img = $r1img[0];
							$type_r1img = $r1img[1];

							$imar = array(
								"path" => base_url('uploads/horoscope_matching/') . '/' . $path_r1img,
								"type" => $type_r1img
							);
							array_push($imaggess, $imar);
						}
					}

					$booking_list[] = array(
						"id" => $key->id,
						"orderID" => $key->orderID,
						"status" => $key->status,
						"booking_type" => $key->type,
						"user_id" => $key->user_id,
						"booking_for" => $key->booking_for,
						"booking_mode" => $booking_mode,
						"name" => $key->user_name,
						"booking_date" => date('d M Y', strtotime($key->schedule_date)) . ', ' . date('h:i A', strtotime($key->schedule_time)),
						"accept_power" => $accept_power,
						"complete_power" => $complete_power,
						"cancel_power" => $cancel_power,
						"remain_date" => $remain_date,
						"total_minutes" => $key->total_minutes,
						"start_time_end_time" => $start_time . ' TO ' . $endTime,
						"is_prescription" => '',
						"booking_status" => $booking_status,
						"user_name" => is_null($key->user_name) ? '' : $key->user_name,
						"user_phone" => $key->user_phone,
						"user_email" => is_null($key->user_email) ? '' : $key->user_email,
						"user_gender" => is_null($key->user_gender) ? '' : $key->user_gender,
						"user_dob" => is_null($key->user_dob) ? '' : $key->user_dob,
						"user_tob" => is_null($key->user_tob) ? '' : $key->user_tob,
						"user_pob" => is_null($key->user_pob) ? '' : $key->user_pob,
						"user_fathername" => is_null($key->user_fathername) ? '' : $key->user_fathername,
						"user_mothername" => is_null($key->user_mothername) ? '' : $key->user_mothername,
						"imagess" => $imaggess,
						"coupan_code_create" => $coupan_code_create
					);
				}
				$response = array("status" => true, "lists" => $booking_list);
			} else {
				$response = array("status" => false, "message" => "no booking found");
			}
			echo json_encode($response);
		}
	}



	public function cancel_astrologer_bookings()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$response = array('status' => false, 'msg' => 'no booking found!');

			$booking_id = $data['id'];
			$booking_check_ = $this->db->get_where('bookings', array("id" => $booking_id));
			if ($booking_check_->num_rows() > 0) {
				$booking_check = $booking_check_->row();
				if ($booking_check->status == 0) {
					$refernece_id = time() . rand(10 * 45, 100 * 98);
					$this->db->query("UPDATE `bookings` SET `status` = '3',`cancel_by`='3',`cancel_by_id`='" . $data['user_id'] . "' WHERE `id`='$booking_id'");
					$this->load->library('My_PHPMailer');
					$settings = $this->w_m->get_settings();

					$detail_s_ = $this->db->get_where('bookings', array("id" => $booking_id));
					if ($detail_s_->num_rows() > 0) {
						$detail_s = $detail_s_->row();
						$get_user_detail = $this->w_m->get_user($detail_s->user_id);
						if ($detail_s->payable_amount > 0) {
							$add_to_wallet = $detail_s->payable_amount;
							if ($add_to_wallet > 0) {
								$user_wallet = $get_user_detail->wallet;
								$update_wallet = $get_user_detail->wallet + $add_to_wallet;
								$this->db->where("id", $get_user_detail->id);
								$this->db->update("user", array("wallet" => $update_wallet));
								$array = array(
									"user_id" => $detail_s->user_id,
									"name" => $get_user_detail->name,
									"booking_id" => $detail_s->id,
									"booking_txn_id" => time(),
									"payment_mode" => "wallet",
									"txn_for" => "Booking cancel by astrologer",
									"old_wallet" => $user_wallet,
									"txn_amount" => $update_wallet,
									"update_wallet" => $add_to_wallet,
									"status" => 1,
									"is_refund" => 1,
									"txn_mode" => 'other',
									"bank_name" => '',
									"bank_txn_id" => '',
									"ifsc" => '',
									"account" => '',
									"created_at" => date("Y-m-d H:i:s"),
									"updated_at" => date("Y-m-d H:i:s")
								);
								$this->db->insert("transactions", $array);
							}
						}
						$bid = $detail_s->id;
						$user_detail = $this->w_m->get_user($detail_s->user_id);
						if ($user_detail) {
							$booking_mode = '';
							if ($detail_s->type == '1') {
								$booking_mode = 'Video Consult';
							} elseif ($detail_s->type == '2') {
								$booking_mode = 'Audio Consult';
							} elseif ($detail_s->type == '3') {
								$booking_mode = 'Chat Consult';
							} elseif ($detail_s->type == '4') {
								$booking_mode = 'Horoscope Consult';
							}


							$astrologer_details = $this->db->get_where("astrologers", array("id" => $detail_s->assign_id))->row();
							// For send sms
							if ($user_detail->phone) {
								$sms_message = "Dear " . $user_detail->name . ",  Refund initiated for Order Id " . $detail_s->orderID . " Booking Cancellation.";
								$this->load->model('ApiCommonNotify');
								$this->ApiCommonNotify->send_sms($user_detail->phone, $sms_message, '+91');
							}
							$settings = $this->w_m->get_settings();
							if ($user_detail->email) {
								$subject = "Astrologer Booking Cancel" . $booking_mode;
								$mail_message = '<div id=":1iu" class="ii gt"> <div id=":1it" class="a3s aiL msg8519675303135148619"> <u></u> <div style="margin:0;font-family:\'Quicksand\',sans-serif"> <div style="border:2px solid #f3914a;margin:10px;border-radius:10px"> <div style="padding:20px"> <img src="' . base_url('uploads/mail_template_') . '/shakti.png" alt="certificate logo" style="width:150px;display:block;margin:0 auto;margin-top:15px" data-image-whitelisted="" class="CToWUd"> <div style="padding:0 10px"> <p style="color:#171717;font-size:14px;margin:3px 0;font-weight:400"><span> Hi ' . $user_detail->name . ',<br>Refund initiated for astrologer ' . $booking_mode . ' Order Id ' . $detail_s->orderID . ' Booking Cancellation. <br><br>Regards<br>Shaktipeeth Digital<br>(This is a system generated email. Please do not reply) </span> </p></div></div></div><br></div><div class="yj6qo"></div><div class="adL"> </div></div></div>';
								$this->w_m->check_curl($user_detail->email, $subject, $mail_message, $user_detail->name);
							}

							// For user
							// $title_message = "DISKUSS ONLINE CONSULTATION";
							$title_message = "Astrologer Booking Cancel" . $booking_mode;
							$notification_message = "Dear " . $user_detail->name . ",  Refund initiated for Order Id " . $detail_s->orderID . "Booking Cancellation.";
							if ($user_detail->device_type == 'android') {
								if ($user_detail->device_token != 'abc') {
									$notification_type1 = "text";
									$message2 = array(
										'body' => $notification_message,
										'title' => $title_message,
										'sound' => 'Default',
										// 'image'=>base_url('uploads/notification_image.png'),
										'type' => 'cancel_booking',
										'booking_id' => $bid
									);

									$this->sendMessageThroughFCM(array($user_detail->device_token), $message2);
								}
							} elseif ($user_detail->device_type == 'ios') {
								$this->send_ios_notification($user_detail->device_token, $notification_message, 'new_booking');
							}

							$noti_array = array("type" => "online", "user_id" => $detail_s->user_id, "for_" => "user", "booking_id" => $bid, "title" => $title_message, "notification" => $notification_message, "added_on" => date('Y-m-d H:i:s'));
							$this->db->insert('user_notification', $noti_array);
						}
						$response = array('status' => true, 'msg' => 'cancel successfully');
					}
				}
			}
			echo json_encode($response);
		}
	}

	public function puja_list_for_coupan()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$gods = ''; //$data['gods'];
			$category_id = ''; //$data['category_id'];
			$temples = ''; //$data['temples'];
			$location = ''; //$data['location'];

			$response = array("status" => false, "msg" => "no puja found!");
			$get_all_pujas = $this->w_m->fetch_puja($user_id, $gods, $category_id, $temples, $location);
			if (count($get_all_pujas) > 0) {
				$puja_list = array();
				foreach ($get_all_pujas as $key) {
					if ($location == '') {
						// $location_details = array();
						// $get_one_puja_location_details = $this->db->get_where("puja_location_table",array("puja_id"=>$key->id,"status"=>1),1)->row();
						// if (count($get_one_puja_location_details) > 0) 
						// {
						// 	$gallery = array();
						// 	if ($get_one_puja_location_details->gallery) 
						// 	{
						// 		$f1 = explode('|', $get_one_puja_location_details->gallery);
						// 		if (count($f1) > 0) 
						// 		{
						// 			for ($i=0; $i < count($f1); $i++) 
						// 			{ 
						// 				array_push($gallery, base_url('uploads/puja/').'/'.$f1[$i]);
						// 			}
						// 		}
						// 	}
						// 	$location_details = $this->db->get_where("puja_location",array("id"=>$get_one_puja_location_details->location_id))->row();
						// 	$location_name = '';
						// 	if (count($location_details) > 0) 
						// 	{
						// 		$location_name = $location_details->name;
						// 	}
						// 	$location_details = array(
						// 		"id"=>$get_one_puja_location_details->id,
						// 		"location_id"=>$get_one_puja_location_details->location_id,
						// 		"location_name"=>$location_name,
						// 		"price"=>$get_one_puja_location_details->prices,
						// 		"discount_prices"=>$get_one_puja_location_details->discount_prices,
						// 		"discount_comment"=>$get_one_puja_location_details->discount_comment,
						// 		"discount_comment_hindi"=>$get_one_puja_location_details->discount_comment_hindi,
						// 		"discount_comment_gujrati"=>$get_one_puja_location_details->discount_comment_gujrati,
						// 		"description"=>$get_one_puja_location_details->description,
						// 		"desc_in_hindi"=>$get_one_puja_location_details->desc_in_hindi,
						// 		"desc_in_gujrati"=>$get_one_puja_location_details->desc_in_gujrati,
						// 		"gallery"=>$gallery);
						// }
						$puja_list[] = array(
							"id" => $key->id,
							"name" => $key->name,
							"name_in_hindi" => $key->name_in_hindi,
							"name_in_gujrati" => $key->name_in_gujrati,
							"image" => base_url('uploads/puja') . '/' . $key->image,
							"pooja_type" => $key->pooja_type,
							"min_percenatge" => 25,
							// "location_details"=>$location_details,
							// "get_locations"=>$this->get_multiple_locations($key->id),
						);
					}
					// else
					// {
					// 	$get_one_puja_location_details = $this->db->get_where("puja_location_table",array("location_id"=>$location,"puja_id"=>$key->id,"status"=>1),1)->row();
					// 	if (count($get_one_puja_location_details) > 0) 
					// 	{
					// 		$location_details = array();
					// 		$gallery = array();
					// 		if ($get_one_puja_location_details->gallery) 
					// 		{
					// 			$f1 = explode('|', $get_one_puja_location_details->gallery);
					// 			if (count($f1) > 0) 
					// 			{
					// 				for ($i=0; $i < count($f1); $i++) 
					// 				{ 
					// 					array_push($gallery, base_url('uploads/puja/').'/'.$f1[$i]);
					// 				}
					// 			}
					// 		}
					// 		$location_details = $this->db->get_where("puja_location",array("id"=>$get_one_puja_location_details->location_id))->row();
					// 		$location_name = '';
					// 		if (count($location_details) > 0) 
					// 		{
					// 			$location_name = $location_details->name;
					// 		}
					// 		$location_details[] = array(
					// 			"id"=>$get_one_puja_location_details->id,
					// 			"location_id"=>$get_one_puja_location_details->location_id,
					// 			"location_name"=>$location_name,
					// 			"price"=>$get_one_puja_location_details->prices,
					// 			"discount_prices"=>$get_one_puja_location_details->discount_prices,
					// 			"discount_comment"=>$get_one_puja_location_details->discount_comment,
					// 			"discount_comment_hindi"=>$get_one_puja_location_details->discount_comment_hindi,
					// 			"discount_comment_gujrati"=>$get_one_puja_location_details->discount_comment_gujrati,
					// 			"description"=>$get_one_puja_location_details->description,
					// 			"desc_in_hindi"=>$get_one_puja_location_details->desc_in_hindi,
					// 			"desc_in_gujrati"=>$get_one_puja_location_details->desc_in_gujrati,
					// 			"gallery"=>$gallery);

					// 		$puja_list[] = array("id"=>$key->id,
					// 					 "name"=>$key->name,
					// 					 "name_in_hindi"=>$key->name_in_hindi,
					// 					 "name_in_gujrati"=>$key->name_in_gujrati,
					// 					 "image"=>base_url('uploads/puja').'/'.$key->image,
					// 					 "pooja_type"=>$key->pooja_type,
					// 					 "location_details"=>$location_details,
					// 					 "get_locations"=>$this->get_multiple_locations($key->id),
					// 					);
					// 	}
					// }
					$response = array("status" => true, "puja_lists" => $puja_list);
				}
			}
			echo json_encode($response);
		}
	}

	public function create_astrologer_coupans_for_user()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$response = array('status' => false, 'msg' => 'no booking found!');
			$id = $data['id'];
			$check = $this->db->get_where('astrologer_coupans', array("astrologer_id" => $data['astrologer_id'], 'user_id' => $data['user_id'], 'booking_id' => $data['id']));
			if ($check->num_rows() > 0) {
				$response = array('status' => false, 'msg' => 'coupan already created');
			} else {
				$refernece_id = 'ASTR' . rand(10 * 451, 100 * 978);
				$array = array(
					"astrologer_id" => $data['astrologer_id'],
					"user_id" => $data['user_id'],
					"puja_id" => $data['puja_id'],
					"booking_id" => $data['id'],
					"coupan_code" => $refernece_id,
					"price" => $data['percentage'],
					"discounttype" => 1,
					"expiry_date" => date('Y-m-d', strtotime(date('Y-m-d') . ' + 6 days')),
					"status" => 1,
					"added_on" => date('Y-m-d H:i:s')
				);
				$this->db->insert('astrologer_coupans', $array);
				$insertid = $this->db->insert_id();
				if ($insertid > 0) {
					$get_puja = $this->db->get_where('puja', array("id" => $data['puja_id']))->row();
					$settings = $this->w_m->get_settings();
					$user_detail = $this->w_m->get_user($data['user_id']);
					$astrologer_details  = $this->db->get_where("astrologers", array("id" => $data['astrologer_id']))->row();
					if ($user_detail) {
						if ($user_detail->phone) {
							$sms_message = "Dear " . $user_detail->name . ",  coupan code for booking puja " . $get_puja->name . " " . $refernece_id . ".";
							$this->load->model('ApiCommonNotify');
							$this->ApiCommonNotify->send_sms($user_detail->phone, $sms_message, '+91');
						}
						$settings = $this->w_m->get_settings();
						if ($user_detail->email) {
							$subject = "Coupan Code for puja booking refered by astrologer " . $astrologer_details->name;
							$mail_message = '<div id=":1iu" class="ii gt"> <div id=":1it" class="a3s aiL msg8519675303135148619"> <u></u> <div style="margin:0;font-family:\'Quicksand\',sans-serif"> <div style="border:2px solid #f3914a;margin:10px;border-radius:10px"> <div style="padding:20px"> <img src="' . base_url('uploads/mail_template_') . '/images/shakti.png" alt="certificate logo" style="width:150px;display:block;margin:0 auto;margin-top:15px" data-image-whitelisted="" class="CToWUd"> <div style="padding:0 10px"> <p style="color:#171717;font-size:14px;margin:3px 0;font-weight:400"><span> Hi ' . $user_detail->name . ',<br>For puja ' . $get_puja->name . ' coupan code refer by astrologer is ' . $refernece_id . '.<br><br>Regards<br>Shaktipeeth Digital<br>(This is a system generated email. Please do not reply) </span> </p></div></div></div><br></div><div class="yj6qo"></div><div class="adL"> </div></div></div>';
							$this->w_m->check_curl($user_detail->email, $subject, $mail_message, $user_detail->name);
						}

						// For user
						// $title_message = "DISKUSS ONLINE CONSULTATION";
						$title_message = "Coupan Code For Puja Booking";
						$notification_message = "Dear " . $user_detail->name . ",  coupan code for puja " . $refernece_id . ".";
						if ($user_detail->device_type == 'android') {
							if ($user_detail->device_token != 'abc') {
								$notification_type1 = "text";
								$message2 = array(
									'body' => $notification_message,
									'title' => $title_message,
									'sound' => 'Default',
									// 'image'=>base_url('uploads/notification_image.png'),
									'type' => 'cancel_booking',
									'booking_id' => $data['id']
								);

								$this->sendMessageThroughFCM(array($user_detail->device_token), $message2);
							}
						} elseif ($user_detail->device_type == 'ios') {
							$this->send_ios_notification($user_detail->device_token, $notification_message, 'new_booking');
						}

						$noti_array = array("type" => "online", "user_id" => $data['user_id'], "user_type" => "1", "booking_id" => $data['id'], "title" => $title_message, "notification" => $notification_message, "added_on" => date('Y-m-d H:i:s'));
						$this->db->insert('user_notification', $noti_array);
					}
					$response = array('status' => true, 'msg' => 'added successfully');
				}
			}
			echo json_encode($response);
		}
	}


	public function puja_booking_history()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$where = '';
			//$specific_date = $data['specific_date'];
			// $specific_date_end = $data['specific_date_end'];
			// $where = '';
			// if ($specific_date) 
			// {
			// 	$where .= "AND DATE(`schedule_date`)>='".$specific_date."' AND DATE(`schedule_date`)<='".$specific_date_end."'";
			// }
			$date = date('Y-m-d');
			$booking_list = array();
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_coupans = $this->db->query("SELECT * FROM `astrologer_coupans` WHERE `astrologer_id` = '" . $data['user_id'] . "' AND `status` = 1 $where ORDER BY added_on DESC")->result();
			if (count($get_coupans) > 0) {
				foreach ($get_coupans as $keyc) {
					$get_any_booking_ = $this->db->query("SELECT * FROM `bookings` WHERE `coupon_code` = '" . $keyc->coupan_code . "' AND `booking_type` = '1' $where ORDER BY created_at DESC");
					if ($get_any_booking_->num_rows() > 0) {
						$get_any_booking = $get_any_booking_->row();
						$get_booking = $this->db->query("SELECT * FROM `booking_history` WHERE `booking_id` = '" . $get_any_booking->id . "'")->result();
						if (count($get_booking) > 0) {
							foreach ($get_booking as $key) {
								$puja_details = $this->db->get_where('puja', array("id" => $key->puja_id))->row();
								$r = array(
									"id" => $key->id,
									"name" => $key->host_name,
									"status" => $key->status,
									"booking_date" => date('d M Y', strtotime($key->schedule_date)) . ', ' . date('h:i A', strtotime($key->schedule_time)),
									"puja_details" => $puja_details->name,
									"puja_type" => ucfirst($key->mode),
									"order_date" => date('d M Y h:ia', strtotime($key->created_at))
								);
								array_push($booking_list, $r);
							}
						}
					}
				}
			}
			$response = array("status" => false, "message" => "no booking found");
			if (!empty($booking_list)) {
				$response = array("status" => true, "lists" => $booking_list);
			}
			echo json_encode($response);
		}
	}


	public function sendMessageThroughFCM($registatoin_ids, $message)
	{
		$settings = $this->w_m->get_settings();
		if ($settings->firebase_key) {
			$k = $settings->firebase_key;
		} else {
			$k = 'AAAACG4WdJ8:APA91bGqlYNvKwRPHjXBaBBUgWxqfzmeWkLt_Nu5QdHcENb6w1GBZwLjJDtDPU2kxnj5z67kWaXNOsloO0QNusBIQPQRHSfclXp1cqgsYikIOdRmr5uvX_65VC4Y_ntXBpzFGpdkqqsP';
		}

		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			'registration_ids' => $registatoin_ids,
			'data' => $message,
			'notification' => $message
		);
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
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
	}

	public function send_ios_notification($device_token, $message_text, $type)
	{
		$payload = '{"aps":{"alert":"' . $message_text . '","badge":0,"content-available":1,"mutable-content":"1","category" : "myNotificationCategory", "sound":"default"},"sd_type":"' . $type . '"}';
		//include_once("Cow.pem");
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', '/var/www/html/picasoid/notification_key/api.pem');
		// $fp=stream_socket_client('ssl://gateway.push.apple.com:2195',$err,$errstr,60,STREAM_CLIENT_CONNECT,$ctx);
		$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
		if ($fp) {
			// echo "Connected".$err;
		}
		$msg = chr(0) . pack("n", 32) . pack("H*", str_replace(' ', '', $device_token)) . pack("n", strlen($payload)) . $payload;
		$res = fwrite($fp, $msg);
		if ($res) {
			//print_r($res);   
		}
		fclose($fp);
		return true;
	}



	//Fresh Code Above for astrologer
	public function get_rashi()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$query = $this->w_m->get_user($data['user_id']);
			$dob = $query->dob;
			$d = $get_zodiac_sign = $this->zodiac($dob);
			echo json_encode($d);
		}
	}

	private function zodiac($birthdate)
	{
		$zodiac = '';
		$zodiac_hindi = '';
		list($year, $month, $day) = explode('-', $birthdate);
		if (($month == 3 && $day > 20) || ($month == 4 && $day < 20)) {
			$zodiac = "Aries";
			$zodiac_hindi = "मेष";
		} elseif (($month == 4 && $day > 19) || ($month == 5 && $day < 21)) {
			$zodiac = "Taurus";
			$zodiac_hindi = "वृषभ";
		} elseif (($month == 5 && $day > 20) || ($month == 6 && $day < 21)) {
			$zodiac = "Gemini";
			$zodiac_hindi = "मिथुन";
		} elseif (($month == 6 && $day > 20) || ($month == 7 && $day < 23)) {
			$zodiac = "Cancer";
			$zodiac_hindi = "कर्क";
		} elseif (($month == 7 && $day > 22) || ($month == 8 && $day < 23)) {
			$zodiac = "Leo";
			$zodiac_hindi = "सिंह";
		} elseif (($month == 8 && $day > 22) || ($month == 9 && $day < 23)) {
			$zodiac = "Virgo";
			$zodiac_hindi = "कन्या";
		} elseif (($month == 9 && $day > 22) || ($month == 10 && $day < 23)) {
			$zodiac = "Libra";
			$zodiac_hindi = "तुला";
		} elseif (($month == 10 && $day > 22) || ($month == 11 && $day < 22)) {
			$zodiac = "Scorpio";
			$zodiac_hindi = "वृश्चिक";
		} elseif (($month == 11 && $day > 21) || ($month == 12 && $day < 22)) {
			$zodiac = "Sagittarius";
			$zodiac_hindi = "धनु";
		} elseif (($month == 12 && $day > 21) || ($month == 1 && $day < 20)) {
			$zodiac = "Capricorn";
			$zodiac_hindi = "मकर";
		} elseif (($month == 1 && $day > 19) || ($month == 2 && $day < 19)) {
			$zodiac = "Aquarius";
			$zodiac_hindi = "कुंभ";
		} elseif (($month == 2 && $day > 18) || ($month == 3 && $day < 21)) {
			$zodiac = "Pisces";
			$zodiac_hindi = "मीन";
		}
		return array("status" => true, "english_name" => $zodiac, "hindi_name" => $zodiac_hindi);
	}

	public function list_astrologer_notification()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$r2 = $this->db->order_by('id', 'DESC')->get_where("astrologer_notification", array("user_id" => $data['user_id']))->result();
			if (count($r2) > 0) {
				$response = array("status" => true, "list" => $r2,);
			} else {
				$response = array("status" => false, "message" => "not_found");
			}
			echo json_encode($response);
		}
	}

	public function faq()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('id', 'asc')->get_where("f_a_q_s", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function aboutus()
	{
		// $data =json_decode(file_get_contents('php://input'), true);	
		// if(isset($data) && !empty($data)){
		$this->data['settings'] = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
		$this->load->view("appcontent/about", $this->data);
		// }
	}

	public function terms()
	{
		// $data =json_decode(file_get_contents('php://input'), true);	
		// if(isset($data) && !empty($data)){
		$this->data['settings'] = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
		$this->load->view("appcontent/terms", $this->data);
		// }
	}

	public function privacy()
	{
		// $data =json_decode(file_get_contents('php://input'), true);	
		// if(isset($data) && !empty($data)){
		$this->data['settings'] = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
		$this->load->view("appcontent/privacy", $this->data);
		// }
	}

	public function Signin()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->form_validation->set_data($data);
				if ($this->form_validation->run('login') !== false) {
					$result = $this->w_m->signin($data);
					echo json_encode($result);
				} else {
					$result =  array('status' => false, 'message' => "some inputs not be blank");
					echo json_encode($result);
				}
			}
		}
	}


	public function Signup()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->form_validation->set_data($data);
				if ($this->form_validation->run('signup') !== false) {
					if ($this->Isemailexist($data['email'])) {
						$data = array('status' => false, 'msg' => 'We already have this email address');
					} elseif ($this->Isphoneexist($data['mobile'], $data['country_code'])) {
						$data = array('status' => false, 'msg' => 'We already have this mobile number');
					} else {
						$password = $data['password']; //123456;
						$password_enc = $this->encrypt_decrypt('encrypt', $password);
						$result = $this->w_m->signup($data, $password_enc, $password);
						if ($result > 0) {
							$user_detail = $this->w_m->global_multiple_query('user', array('id' => $result), 'row()');
							if (!empty($user_detail->image)) {
								$img = base_url('/uploads/user') . '/' . $user_detail->image;
							} else {
								$img = base_url('/uploads/user/') . '/' . 'default.png';
							}

							if (!is_null($user_detail->gender)) {
								$gender = $user_detail->gender;
							} else {
								$gender = '';
							}


							if (!is_null($user_detail->dob)) {
								$dob = $user_detail->dob;
							} else {
								$dob = '';
							}

							if (!is_null($user_detail->address)) {
								$address = $user_detail->address;
							} else {
								$address = '';
							}

							if (!is_null($user_detail->country)) {
								$country = $user_detail->country;
							} else {
								$country = '';
							}

							if (!is_null($user_detail->state)) {
								$state = $user_detail->state;
							} else {
								$state = '';
							}

							if (!is_null($user_detail->area)) {
								$area = $user_detail->area;
							} else {
								$area = '';
							}

							if (!is_null($user_detail->city)) {
								$city = $user_detail->city;
							} else {
								$city = '';
							}

							if (!is_null($user_detail->birth_time)) {
								$birth_time = $user_detail->birth_time;
							} else {
								$birth_time = '';
							}

							if (!is_null($user_detail->place_of_birth)) {
								$place_of_birth = $user_detail->place_of_birth;
							} else {
								$place_of_birth = '';
							}

							if (!is_null($user_detail->language)) {
								$language = $user_detail->language;
							} else {
								$language = '';
							}

							if (!is_null($user_detail->marital_status)) {
								$marital_status = $user_detail->marital_status;
							} else {
								$marital_status = '';
							}

							if (!is_null($user_detail->occupation)) {
								$occupation = $user_detail->occupation;
							} else {
								$occupation = '';
							}

							if (!is_null($user_detail->annual_income)) {
								$annual_income = $user_detail->annual_income;
							} else {
								$annual_income = '';
							}


							$user_detail1 = array(
								"user_id" => $user_detail->id,
								"first_name" => $user_detail->name,
								"last_name" => $user_detail->last_name,
								"email" => $user_detail->email,
								"country_code" => $user_detail->country_code,
								"mobile" => $user_detail->phone,
								"image" => $img,
								"wallet" => $user_detail->wallet,
								"refferal_code" => $user_detail->referral_code,
								"dob" => $dob,
								"gender" => $gender,
								"address" => $address,
								"country" => $country,
								"state" => $state,
								"city" => $city,
								"language" => $language,
								"marital_status" => $marital_status,
								"occupation" => $occupation,
								"annual_income" => $annual_income,

							);
							$data = array('status' => true, 'msg' => 'Successfully Registered. Please login to your account', 'user_detail' => $user_detail1);
						}
					}
				} else {
					$data =  array('status' => false, 'message' => "some inputs not be blank");
				}
				echo json_encode($data);
			}
		}
	}

	public function otp()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				if ($data['email'] && $data['mobile'] && $data['country_code']) {
					if ($this->Isemailexist($data['email'])) {
						$result = array('status' => false, 'msg' => 'Email already registered, please use another mail id');
					} elseif ($this->Isphoneexist($data['mobile'], $data['country_code'])) {
						$result = array('status' => false, 'msg' => 'Mobile number already registered, please use another');
					} else {
						$result = $this->w_m->otp_send($data);
					}
				} else {
					$result = array('status' => false, 'msg' => 'email and mobile needed!');
				}

				echo json_encode($result);
			} else {
				$this->fail_auth();
			}
		}
	}

	public function occupation()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_occupation", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function marital_status()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_marital_status", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_zodiac()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_zodiac", array())->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_relationship()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_relationship", array())->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function Forget_password_send_password()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$result = $this->w_m->forget_password_send_password($data['email']);
			echo json_encode($result);
		}
	}

	public function Forget_password()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$result = $this->w_m->forget_password($data['email'], $data['otp']);
				echo json_encode($result);
			}
		}
	}

	public function change_password_user()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				if (strpos($data['email'], '@') !== false) {
					$get_user = $this->db->query("SELECT * FROM `user` WHERE `email`='" . $data['email'] . "' AND `status`='1'")->row();
				} else {
					$get_user = $this->db->query("SELECT * FROM `user` WHERE `phone`='" . $data['email'] . "' AND `status`='1'")->row();
				}
				if (count($get_user) > 0) {
					$password = $this->encrypt_decrypt('encrypt', $data['password']);
					$this->db->query("UPDATE user SET `password` = '" . $password . "',`password1` = '" . $data['password'] . "' WHERE `id` = " . $get_user->id);
					// $sms_message = "Your Shakitpeeth Account Password has changed Successfully, Your New Password is ".$data['password'];
					// $this->send_sms($get_user->phone,$sms_message,$get_user->country_code);
					$settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
					$subject = "Shakitpeeth Account Password Changed";
					$mail_message = "Hello,<br>Your Shakitpeeth Account Password has changed Successfully, Your New Password is" . $data['password'] . ".<br><br>For any Help Assistance and Support you can reach out to us on our helpline number " . $settings->helpline_number . " Looking forward to Care for your Mind and Body.<br><br>Regards<br>SHAKTIPEETH SUPPORT";
					$this->w_m->check_curl($get_user->email, $subject, $mail_message, $get_user->name);
					$result = array('status' => true, 'msg' => 'done');
				} else {
					$result = array('status' => false, 'msg' => 'not found in db');
				}
				echo json_encode($result);
			}
		}
	}

	public function Isemailexist($email)
	{
		$user = $this->w_m->isEmailExist($email);
		if ($user) {
			return false;
		} else {
			return true;
		}
	}
	public function Isphoneexist($mobile, $country_code)
	{
		$user = $this->w_m->Isphoneexist($mobile, $country_code);
		if ($user) {
			return false;
		} else {
			return true;
		}
	}

	public function Isphoneexist_country_code($mobile, $country_code)
	{
		$user = $this->w_m->Isphoneexist_country_code($mobile, $country_code);
		if ($user) {
			return false;
		} else {
			return true;
		}
	}

	// public function otp(){
	// 	$data =json_decode(file_get_contents('php://input'), true);
	// 	if(isset($data) && !empty($data)){
	// 			if($this->Isemailexist($data['email'])){
	// 				$result = array('status'=>false,'msg'=>'We already have this email address');
	// 			}elseif ($this->Isphoneexist_country_code($data['mobile'],$data['country_code'])) {
	// 				$result = array('status'=>false,'msg'=>'We already have this mobile number');
	// 			}
	// 			else{
	// 				$result = $this->w_m->otp_send($data);
	// 			}
	// 			echo json_encode($result);
	// 		}
	// }

	public function verify_referral()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				if ($this->Isemailexist($data['email'])) {
					$result = array('status' => false, 'msg' => 'We already have this email address');
				} elseif ($this->Isphoneexist($data['mobile'], $data['country_code'])) {
					$result = array('status' => false, 'msg' => 'We already have this mobile number');
				} else {
					$result = $this->w_m->verify_referral($data);
				}
				echo json_encode($result);
			} else {
				$this->fail_auth();
			}
		}
	}

	public function otp_for_login()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			if ($this->Isphoneexist_country_code($data['mobile'], $data['country_code'])) {
				$result = $this->w_m->otp_send_for_login($data);
			} else {
				$result = array('status' => false, 'msg' => 'not found in db');
			}
			echo json_encode($result);
		}
	}


	public function user_detail_after_otp()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			if ($this->Isphoneexist($data['mobile'])) {
				$result = $this->w_m->user_detail_after_otp($data);
			} else {
				$result = array('status' => false, 'msg' => 'not found in db');
			}
			echo json_encode($result);
		}
	}

	public function get_profile()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$result = $this->w_m->get_profile($data);
				echo json_encode($result);
			}
		}
	}

	public function add_member()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_id = $data['user_id'];
				$name = $data['name'];
				$gender = $data['gender'];
				$relation = $data['relation'];
				$dob = $data['dob'];
				$tob = $data['tob'];
				$pob = $data['pob'];
				$email = $data['email'];
				$mobile = $data['mobile'];
				$zodiac = $data['zodiac'];
				$occupation = $data['occupation'];
				$problem_area = $data['problem_area'];
				$check_member_name = $this->w_m->check_member_name($email, $mobile, $user_id);
				if ($check_member_name > 0) {
					$response = array("status" => false, "msg" => "member name already in database");
				} else {
					$info = array(
						'user_id' => $user_id,
						'name' => $name,
						'gender' => $gender,
						'relation' => $relation,
						'dob' => $dob,
						'tob' => $tob,
						'pob' => $pob,
						'email' => $email,
						'mobile' => $mobile,
						'zodiac' => $zodiac,
						'occupation' => $occupation,
						'problem_area' => $problem_area,
						'added_on' => date('Y-m-d H:i:s'),
						'status' => 1
					);
					$this->db->insert('user_member', $info);
					$get_member_list = $this->db->get_where("user_member", array("user_id" => $user_id, "status" => 1))->result();
					$response = array("status" => true, "msg" => "add member Successfully", "member_list" => $get_member_list);
				}
				echo json_encode($response);
			}
		}
	}


	public function delete_member()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->db->query("UPDATE `user_member` SET `status` = '2' WHERE id = '" . $data['member_id'] . "'");
				$member_list = $this->db->get_where('user_member', array("user_id" => $data['user_id'], "status" => 1))->result();
				if (count($member_list) > 0) {
					$response = array("status" => true, "member_list" => $member_list);
				} else {
					$response = array("status" => false, "msg" => "no member found");
				}
				echo json_encode($response);
			}
		}
	}

	public function list_member()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$member_list = $this->db->query("SELECT *,'' AS is_selected from user_member where `user_id` = '" . $data['user_id'] . "' AND `status` = '1'")->result();
				// $this->db->get_where('user_member',array("user_id"=>$data['user_id'],"status"=>1))->result();
				if (count($member_list) > 0) {
					$response = array("status" => true, "member_list" => $member_list);
				} else {
					$response = array("status" => false, "msg" => "no member found");
				}
				echo json_encode($response);
			}
		}
	}

	public function add_address()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_id = $data['user_id'];
				$address = $data['address'];
				$area = $data['area'];
				$pincode = $data['pincode'];
				$city_state = $data['city_state'];
				$check = $this->db->get_where("user_saved_address", array("user_id" => $user_id))->row();
				if (count($check) > 0) {
					$is_deafult = 0;
				} else {
					$is_deafult = 1;
				}
				$info = array(
					'user_id' => $user_id,
					'address' => $address,
					'area' => $area,
					'pincode' => $pincode,
					'city_state' => $city_state,
					'is_deafult' => $is_deafult,
					'added_on' => date('Y-m-d H:i:s')
				);

				$this->db->insert('user_saved_address', $info);
				$recent_add_id = $this->db->insert_id();
				$address_recent = $this->db->get_where("user_saved_address", array("id" => $recent_add_id))->row();
				$address = $this->db->get_where("user_saved_address", array("user_id" => $user_id))->result();
				$response = array("status" => true, "msg" => "add address Successfully", "user_saved_address" => $address, "address_recent" => $address_recent);
				echo json_encode($response);
			}
		}
	}

	public function list_user_address()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_saved_address = $this->db->get_where('user_saved_address', array("user_id" => $data['user_id']))->result();
				if (count($user_saved_address) > 0) {
					$response = array("status" => true, "user_saved_address" => $user_saved_address);
				} else {
					$response = array("status" => false, "msg" => "no user_saved_address found");
				}
				echo json_encode($response);
			}
		}
	}

	public function make_default_address()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->db->where("user_id", $data['user_id']);
				$this->db->update("user_saved_address", array("is_deafult" => 0));
				$this->db->where("id", $data['address_id']);
				$this->db->update("user_saved_address", array("is_deafult" => 1));
				$user_saved_address = $this->db->get_where('user_saved_address', array("user_id" => $data['user_id']))->result();
				if (count($user_saved_address) > 0) {
					$response = array("status" => true, "user_saved_address" => $user_saved_address);
				} else {
					$response = array("status" => false, "msg" => "no user_saved_address found");
				}
				echo json_encode($response);
			}
		}
	}

	public function update_address()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->db->where("id", $data['id']);
				$info = array(
					'address' => $data['address'],
					'area' => $data['area'],
					'pincode' => $data['pincode'],
					'city_state' => $data['city_state'],

				);
				$this->db->update("user_saved_address", $info);
				$user_saved_address = $this->db->get_where('user_saved_address', array("user_id" => $data['user_id']))->result();
				if (count($user_saved_address) > 0) {
					$response = array("status" => true, "user_saved_address" => $user_saved_address);
				} else {
					$response = array("status" => false, "msg" => "no user_saved_address found");
				}
				echo json_encode($response);
			}
		}
	}

	public function delete_address()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->db->query("DELETE FROM `user_saved_address` WHERE id = '" . $data['id'] . "'");
				echo $this->list_user_address_($data['user_id']);
			}
		}
	}

	public function list_user_address_($value)
	{
		$user_saved_address = $this->db->get_where('user_saved_address', array("user_id" => $value))->result();
		if (count($user_saved_address) > 0) {
			$response = array("status" => true, "user_saved_address" => $user_saved_address);
		} else {
			$response = array("status" => false, "msg" => "no user_saved_address found");
		}
		return json_encode($response);
	}

	public function logout()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = $data['user_id'];
		$device_id = $data['device_id'];
		$this->db->query("UPDATE `user` SET `device_id`='',`device_token`='',`device_type`='',`voip_token`='' WHERE `id`='$user_id'");
		$insert_array = array(
			"user_id" => $user_id,
			"device_id" => $device_id,
			"added_on" => date('Y-m-d H:i:s')
		);
		$this->db->insert("user_logout_track", $insert_array);
		$response = array("status" => true, "msg" => "logout successfully");
		echo json_encode($response);
	}

	public function update_user_configuration()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = $data['user_id'];
		$for = $data['for'];
		$value = $data['value'];
		if ($for == 'direction') {
			$this->db->query("UPDATE `user` SET `chart_style`='$value' WHERE `id`='$user_id'");
		} elseif ($for == 'language') {
			$this->db->query("UPDATE `user` SET `language`='$value' WHERE `id`='$user_id'");
		} elseif ($for == 'notification') {
			$this->db->query("UPDATE `user` SET `notification_config`='$value' WHERE `id`='$user_id'");
		}
		$response = array("status" => true, "msg" => "done successfully");
		echo json_encode($response);
	}

	public function update_profile()
	{
		// $AUTH = $this->db->where( 'key', md5($this->input->get_request_header('HTTP_X_API_KEY')) )
		// 	->get( 'restapi_keys' )
		// 	->result_array();
		// if( ! $AUTH ) {
		// 	$this->fail_auth();
		// } else {
		$path = base_url('uploads/user/');
		$user_id = $this->input->post('user_id');
		$name = $this->input->post('name');
		$flag = $this->input->post('flag');
		// $gender = $this->input->post('gender');
		$dob = $this->input->post('dob');
		$birth_time = $this->input->post('birth_time');
		$address = $this->input->post('address');
		$father_name = $this->input->post('father_name');
		$mother_name = $this->input->post('mother_name');
		$gotro = $this->input->post('gotro');
		$spouse_name = $this->input->post('spouse_name');
		$place_of_birth = $this->input->post('place_of_birth');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		if ($flag == '1') {
			$target_path = "uploads/user/";
			$target_dir = "uploads/user/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$this->db->query("UPDATE `user` SET `name`='$name',`email`='$email',`image`='$actual_image_name',`address`='$address',`dob`='$dob',`birth_time`='$birth_time',`address`='$address',`father_name`='$father_name',`mother_name`='$mother_name',`gotro`='$gotro',`spouse_name`='$spouse_name',`place_of_birth`='$place_of_birth',`latitude`='$latitude',`longitude`='$longitude' WHERE `id` = '$user_id'");
					$query = $this->w_m->get_user($user_id);
					if (!empty($query->image)) {
						$img = base_url('/uploads/user') . '/' . $query->image;
					} else {
						$img = base_url('/uploads/user') . '/' . 'default.png';
					}

					if (!is_null($query->gender)) {
						$gender = $query->gender;
					} else {
						$gender = '';
					}


					if (!is_null($query->dob)) {
						$dob = $query->dob;
					} else {
						$dob = '';
					}

					if (!is_null($query->address)) {
						$address = $query->address;
					} else {
						$address = '';
					}

					if (!is_null($query->country)) {
						$country = $query->country;
					} else {
						$country = '';
					}

					if (!is_null($query->state)) {
						$state = $query->state;
					} else {
						$state = '';
					}

					if (!is_null($query->city)) {
						$city = $query->city;
					} else {
						$city = '';
					}

					if (!is_null($query->marital_status)) {
						$marital_status = $query->marital_status;
					} else {
						$marital_status = '';
					}

					if (!is_null($query->birth_time)) {
						$birth_time = $query->birth_time;
					} else {
						$birth_time = '';
					}

					if (!is_null($query->father_name)) {
						$father_name = $query->father_name;
					} else {
						$father_name = '';
					}

					if (!is_null($query->mother_name)) {
						$mother_name = $query->mother_name;
					} else {
						$mother_name = '';
					}

					if (!is_null($query->gotro)) {
						$gotro = $query->gotro;
					} else {
						$gotro = '';
					}

					if (!is_null($query->spouse_name)) {
						$spouse_name = $query->spouse_name;
					} else {
						$spouse_name = '';
					}

					$user_details = array(
						"status" => $query->status,
						"user_id" => $query->id,
						"email" => $query->email,
						"first_name" => $query->name,
						"mobile" => $query->phone,
						"image" => $img,
						"gender" => $gender,
						"dob" => $dob,
						"address" => $address,
						"country" => $country,
						"state" => $state,
						"city" => $city,
						"birth_time" => $birth_time,
						"father_name" => $father_name,
						"mother_name" => $mother_name,
						"gotro" => $gotro,
						"spouse_name" => $spouse_name
					);
					$response = array("status" => true, "msg" => "Update Successfully", "user_detail" => $user_details);
				} else {
					$response = array("status" => false, "msg" => "image upload falied plesae try again latter thanks");
				}
				echo json_encode($response);
			} else {
				$this->fail_auth();
			}
		} elseif ($flag == '0') {
			$this->db->query("UPDATE `user` SET `name`='$name',`address`='$address',`dob`='$dob',`birth_time`='$birth_time',`address`='$address',`father_name`='$father_name',`mother_name`='$mother_name',`gotro`='$gotro',`spouse_name`='$spouse_name',`place_of_birth`='$place_of_birth',`latitude`='$latitude',`longitude`='$longitude' WHERE `id` = '$user_id'");
			$query = $this->w_m->get_user($user_id);
			if (!empty($query->image)) {
				$img = base_url('/uploads/user') . '/' . $query->image;
			} else {
				$img = base_url('/uploads/user') . '/' . 'default.png';
			}


			if (!is_null($query->gender)) {
				$gender = $query->gender;
			} else {
				$gender = '';
			}


			if (!is_null($query->dob)) {
				$dob = $query->dob;
			} else {
				$dob = '';
			}

			if (!is_null($query->address)) {
				$address = $query->address;
			} else {
				$address = '';
			}

			if (!is_null($query->country)) {
				$country = $query->country;
			} else {
				$country = '';
			}

			if (!is_null($query->state)) {
				$state = $query->state;
			} else {
				$state = '';
			}

			if (!is_null($query->city)) {
				$city = $query->city;
			} else {
				$city = '';
			}

			if (!is_null($query->marital_status)) {
				$marital_status = $query->marital_status;
			} else {
				$marital_status = '';
			}

			if (!is_null($query->birth_time)) {
				$birth_time = $query->birth_time;
			} else {
				$birth_time = '';
			}

			if (!is_null($query->father_name)) {
				$father_name = $query->father_name;
			} else {
				$father_name = '';
			}

			if (!is_null($query->mother_name)) {
				$mother_name = $query->mother_name;
			} else {
				$mother_name = '';
			}

			if (!is_null($query->gotro)) {
				$gotro = $query->gotro;
			} else {
				$gotro = '';
			}

			if (!is_null($query->spouse_name)) {
				$spouse_name = $query->spouse_name;
			} else {
				$spouse_name = '';
			}

			$user_details = array(
				"status" => $query->status,
				"user_id" => $query->id,
				"email" => $query->email,
				"first_name" => $query->name,
				// "last_name"=>$query->last_name,
				"mobile" => $query->phone,
				"image" => $img,
				"gender" => $gender,
				"dob" => $dob,
				"address" => $address,
				"country" => $country,
				"state" => $state,
				"city" => $city,
				"birth_time" => $birth_time,
				"father_name" => $father_name,
				"mother_name" => $mother_name,
				"gotro" => $gotro,
				"spouse_name" => $spouse_name
			);
			$response = array("status" => true, "msg" => "Update Successfully", "user_detail" => $user_details);
			echo json_encode($response);
		} else {
			$this->fail_auth();
		}
		// }
	}

	public function update_language()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			$language = $data['language'];
			$user_id = $data['user_id'];
			$this->db->query("UPDATE `user` SET `language`='$language' WHERE `id` = '$user_id'");
			$query = $this->w_m->get_user($user_id);
			if (!empty($query->image)) {
				$img = base_url('/uploads/user') . '/' . $query->image;
			} else {
				$img = base_url('/uploads/user') . '/' . 'default.png';
			}


			if (!is_null($query->gender)) {
				$gender = $query->gender;
			} else {
				$gender = '';
			}


			if (!is_null($query->dob)) {
				$dob = $query->dob;
			} else {
				$dob = '';
			}

			if (!is_null($query->address)) {
				$address = $query->address;
			} else {
				$address = '';
			}

			if (!is_null($query->country)) {
				$country = $query->country;
			} else {
				$country = '';
			}

			if (!is_null($query->state)) {
				$state = $query->state;
			} else {
				$state = '';
			}

			if (!is_null($query->city)) {
				$city = $query->city;
			} else {
				$city = '';
			}

			if (!is_null($query->annual_income)) {
				$annual_income = $query->annual_income;
			} else {
				$annual_income = '';
			}

			if (!is_null($query->occupation)) {
				$occupation = $query->occupation;
			} else {
				$occupation = '';
			}

			if (!is_null($query->marital_status)) {
				$marital_status = $query->marital_status;
			} else {
				$marital_status = '';
			}

			$user_details = array(
				"status" => $query->status,
				"user_id" => $query->id,
				"email" => $query->email,
				"first_name" => $query->name,
				"last_name" => $query->last_name,
				"mobile" => $query->phone,
				"image" => $img,
				"gender" => $gender,
				"dob" => $dob,
				"address" => $address,
				"country" => $country,
				"state" => $state,
				"city" => $city,
				"language" => $query->language,
				"annual_income" => $annual_income,
				"occupation" => $occupation,
				"marital_status" => $marital_status
			);
			$response = array("status" => true, "msg" => "Update Successfully", "user_detail" => $user_details);
			echo json_encode($response);
		}
	}

	public function get_magzine()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$get_Settings = $this->db->get_where("settings", array("id" => 1))->row();
			echo json_encode(array('status' => true, "magzine_link" => base_url('uploads/magzine') . '/' . $get_Settings->magzine));
		}
	}



	public function home_user_old()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_detail = $this->db->get_where("user", array("id" => $data['user_id']))->row();
				if (count($user_detail) > 0) {
					$user_detail = $user_detail;
					$user_detail->user_image_path = base_url('uploads/user') . '/';
				} else {
					$user_detail = array();
				}
				$get_Settings = $this->db->query("SELECT `company_name`,`address`,`website_link`,`support_email`, `helpline_number`,`landline`, `facebook_link`, `instagram_link`, `twitter_link`, `linkedin_link`, `youtube_link`,`google_play_app_link`, `ios_app_link` FROM `settings` WHERE id = 1")->row(); //get_where("settings",array("id"=>1))->row();
				// Patient Banners
				$banner = $this->db->order_by('position', 'ASC')->get_where("banner", array("type" => "patient", "is_active" => 1))->result();
				$banners = array();
				if (count($banner) > 0) {
					foreach ($banner as $key) {
						array_push($banners, base_url('uploads/banner/user') . '/' . $key->image);
					}
				} else {
					array_push($banners, base_url('uploads/banner/user/banner-1.png'));
					array_push($banners, base_url('uploads/banner/user/banner-2.png'));
					array_push($banners, base_url('uploads/banner/user/banner-3.png'));
					array_push($banners, base_url('uploads/banner/user/banner-4.png'));
				}



				$puja = array();
				$r2 = $this->db->order_by('position', 'ASC')->get_where("pooja", array("in_app" => 1, "status" => 1))->result();
				if (count($r2) > 0) {
					foreach ($r2 as $key4) {
						$gems_products = array();
						$puja[] = array(
							"id" => $key4->id,
							"name" => $key4->name,
							"image" => base_url('uploads/puja/') . '/' . $key4->image,
						);
					}
				}

				/* Live classses module
					$query = "SELECT `id`, `expert_id`, `session_id`, `token`, `is_done`, `video_url`,`archive_id`,`added_on` FROM `expert_live_session` WHERE `is_done` = '0' ORDER BY `added_on` DESC LIMIT 1";
					$all_list = $this->db->query($query)->row();
					if (count($all_list) > 0) 
					{
						$check_user_have_active_package = $this->db->get_where("class_package_history",array("user_id"=>$data['user_id'],"status"=>1))->result();
						if (count($check_user_have_active_package) > 0) 
						{
							$expert_details = $this->db->get_where('expert_management',array("id"=>$all_list->expert_id))->row();
							$live_details = array("status"=>true,"expert_id"=>$all_list->expert_id,"name"=>$expert_details->name,"image"=>base_url('uploads/expert').'/'.$expert_details->image,"session_id"=>$all_list->session_id,"chat_id"=>'g'.$all_list->id,"token"=>$all_list->token);
						}
						else
						{
							$expert_details = $this->db->get_where('expert_management',array("id"=>$all_list->expert_id))->row();
							$live_details = array("status"=>true,"expert_id"=>$all_list->expert_id,"name"=>$expert_details->name,"image"=>base_url('uploads/expert').'/'.$expert_details->image,"session_id"=>$all_list->session_id,"chat_id"=>'g'.$all_list->id,"token"=>$all_list->token);
							//$live_details = array("status"=>false);
						}
						
					}
					else
					{
						$live_details = array("status"=>false);
					}

					$tax = $this->tax_config();*/

				$response = array("status" => true, "banners" => $banners, "emergency_number" => $get_Settings->helpline_number, "puja" => $puja, "user_detail" => $user_detail, "get_Settings" => $get_Settings); //"live_details"=>$live_details,"tax_details"=>$tax);
				echo json_encode($response);
			}
		}
	}

	public function puja_details_old()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
				->get('restapi_keys')
				->result_array();
			if (!$AUTH) {
				$this->fail_auth();
			} else {
				$query = "SELECT * FROM `pooja` WHERE `status` = '1' AND `id`='" . $data['id'] . "'";
				$all_list = $this->db->query($query)->row();
				if (count($all_list) > 0) {
					if (!isset($data['user_id'])) {
						$data['user_id'] = 0;
					}
					$percent = 0;
					if ($all_list->discount_price != 0.00 || $all_list->discount_price != 0) {
						$percent = (($all_list->price - $all_list->discount_price) * 100) / $all_list->price;
					}
					$is_cart = 0;
					$check_cart = $this->db->get_where("puja_temp_cart", array("main_user_id" => $data['user_id'], "puja_id" => $all_list->id))->row();
					if (count($check_cart) > 0) {
						$is_cart = 1;
					}
					$imaggess = array();
					if (!is_null($all_list->images) or !empty($all_list->images)) {
						$img = explode('|', $all_list->images);
						foreach ($img as $key2) {
							array_push($imaggess, base_url('uploads/puja') . '/' . $key2);
						}
					}

					$multiple_location = array();
					if (!is_null($all_list->multiple_location) or !empty($all_list->multiple_location)) {
						$img1 = explode('|', $all_list->multiple_location);
						foreach ($img1 as $key3) {
							array_push($multiple_location, $key3);
						}
					}


					$response = array(
						"status" => true, "id" => $all_list->id,
						"name" => $all_list->name,
						"description" => $all_list->description,
						"multiple_location" => $multiple_location,
						"base_price" => $all_list->price,
						"discount_price" => $all_list->discount_price,
						"percent" => $percent,
						"image" => base_url('uploads/puja') . '/' . $all_list->image,
						"is_cart" => $is_cart,
						"imaggess" => $imaggess,
					);
				} else {
					$response = array("status" => false, "message" => "not found any product");
				}
				echo json_encode($response);
			}
		}
	}

	public function home_user()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$query = $this->db->get_where("user", array("id" => $data['user_id']))->row();
				if (count($query) > 0) {
					if (!empty($query->image)) {
						$img = base_url('/uploads/user') . '/' . $query->image;
					} else {
						$img = base_url('/uploads/user') . '/' . 'default.png';
					}

					if (!is_null($query->gender)) {
						$gender = $query->gender;
					} else {
						$gender = '';
					}


					if (!is_null($query->dob)) {
						$dob = $query->dob;
					} else {
						$dob = '';
					}

					if (!is_null($query->address)) {
						$address = $query->address;
					} else {
						$address = '';
					}

					if (!is_null($query->country)) {
						$country = $query->country;
					} else {
						$country = '';
					}

					if (!is_null($query->state)) {
						$state = $query->state;
					} else {
						$state = '';
					}

					if (!is_null($query->city)) {
						$city = $query->city;
					} else {
						$city = '';
					}

					if (!is_null($query->annual_income)) {
						$annual_income = $query->annual_income;
					} else {
						$annual_income = '';
					}

					if (!is_null($query->occupation)) {
						$occupation = $query->occupation;
					} else {
						$occupation = '';
					}

					if (!is_null($query->marital_status)) {
						$marital_status = $query->marital_status;
					} else {
						$marital_status = '';
					}

					$user_detail = array(
						"status" => $query->status,
						"user_id" => $query->id,
						"email" => $query->email,
						"first_name" => $query->name,
						"last_name" => $query->last_name,
						"mobile" => $query->phone,
						"image" => $img,
						"gender" => $gender,
						"dob" => $dob,
						"address" => $address,
						"country" => $country,
						"state" => $state,
						"city" => $city,
						"language" => $query->language,
						"annual_income" => $annual_income,
						"occupation" => $occupation,
						"marital_status" => $marital_status
					);
				} else {
					$user_detail = array();
				}
				$get_Settings = $this->db->query("SELECT `whats_number`,`company_name`,`address`,`website_link`,`support_email`, `helpline_number`,`landline`, `facebook_link`, `instagram_link`, `twitter_link`, `linkedin_link`, `youtube_link`,`google_play_app_link`, `ios_app_link` FROM `settings` WHERE id = 1")->row();
				// Main Banners
				$banner = $this->db->order_by('position', 'ASC')->get_where("banner", array("type" => "main", "is_active" => 1))->result();
				$banners = array();
				if (count($banner) > 0) {
					foreach ($banner as $key) {
						array_push($banners, base_url('uploads/banner/user') . '/' . $key->image);
					}
				} else {
					array_push($banners, base_url('uploads/banner/user/banner-1.png'));
					array_push($banners, base_url('uploads/banner/user/banner-2.png'));
					array_push($banners, base_url('uploads/banner/user/banner-3.png'));
					array_push($banners, base_url('uploads/banner/user/banner-4.png'));
				}


				$midbanner = $this->db->order_by('position', 'ASC')->get_where("banner", array("type" => "main", "is_active" => 1))->result();
				$midbanners = array();
				if (count($midbanner) > 0) {
					foreach ($midbanner as $key2) {
						array_push($midbanners, base_url('uploads/banner/user') . '/' . $key2->image);
					}
				} else {
					array_push($midbanners, base_url('uploads/banner/user/banner-1.png'));
					array_push($midbanners, base_url('uploads/banner/user/banner-2.png'));
					array_push($midbanners, base_url('uploads/banner/user/banner-3.png'));
					array_push($midbanners, base_url('uploads/banner/user/banner-4.png'));
				}

				$gallery = $this->db->order_by('position', 'ASC')->get_where("gallery", array("status" => 1))->result();
				$gallerys = array();
				if (count($banner) > 0) {
					foreach ($gallery as $keyg) {
						array_push($gallerys, base_url('uploads/gallery') . '/' . $keyg->image);
					}
				}

				$testimonial = $this->db->order_by('rating', 'DESC')->get_where("testimonials", array("status" => 1))->result();
				$testimonials = array();
				if (count($banner) > 0) {
					foreach ($testimonial as $keyt) {
						$testimonials[] = array(
							"name" => $keyt->name,
							"rating" => $keyt->rating,
							"comments" => $keyt->comments
						);
					}
				}


				$astrologers = array();
				$r2 = $this->db->query("SELECT `id`, `name`, `image`,  `price_for_chat`, `price_for_audio`, `price_for_video`, `languages`,`experience`, `status`, `is_approval`, `online_consult`, `online_status`, `in_house_astrologers`, `price_per_mint_chat`, `price_per_mint_video`, `price_per_mint_audio` FROM `astrologers` WHERE `status` = '1' AND `is_home`='1' AND `approved`='1' AND `is_premium` = '1' AND (`is_approval`='2' OR `is_approval`='3')")->result();
				if (count($r2) > 0) {
					foreach ($r2 as $key4) {
						$langaguge = '';
						if ($key4->languages) {
							$languages_array = array();
							$lang1 = explode(',', $key4->languages);
							if (count($lang1) > 0) {
								foreach ($lang1 as $keyspec) {
									if ($keyspec) {
										array_push($languages_array, $keyspec);
									}
								}
								if (!empty($languages_array)) {
									$langaguge = implode(', ', $languages_array);
								}
							}
						}
						$astrologers[] = array(
							"id" => $key4->id,
							"name" => $key4->name,
							"image" => base_url('uploads/astrologers/') . '/' . $key4->image,
							"experience" => $key4->experience,
							"rating" => 5,
							"langaguge" => $langaguge,
							"price_per_mint_chat" => $key4->price_per_mint_chat,
							"price_per_mint_video" => $key4->price_per_mint_video,
							"price_per_mint_audio" => $key4->price_per_mint_audio,
							"online_status" => 1
						);
					}
				}
				$this->w_m->user_device_update($data);
				$response = array("status" => true, "banners" => $banners, "midbanners" => $midbanners, "whats_number" => $get_Settings->whats_number, "gallerys" => $gallerys, "user_detail" => $user_detail, "get_Settings" => $get_Settings, "astrologers" => $astrologers, "testimonials" => $testimonials);
				echo json_encode($response);
			}
		}
	}

	public function get_multiple_locations($id)
	{
		$loc = array();
		$l = $this->db->get_where("puja_location_table", array("puja_id" => $id))->result();
		if (count($l) > 0) {
			foreach ($l as $key) {
				$get_location_name = $this->db->get_where("puja_location", array("id" => $key->location_id))->row();
				if (count($get_location_name) > 0) {
					$gallery = array();
					if ($key->gallery) {
						$f1 = explode('|', $key->gallery);
						if (count($f1) > 0) {
							for ($i = 0; $i < count($f1); $i++) {
								array_push($gallery, base_url('uploads/puja/') . '/' . $f1[$i]);
							}
						}
					}
					$loc[] = array(
						"id" => $key->id,
						"location_name" => $get_location_name->name,
						"price" => $key->prices,
						"discount_prices" => $key->discount_prices,
						"discount_comment" => $key->discount_comment,
						"discount_comment_hindi" => $key->discount_comment_hindi,
						"discount_comment_gujrati" => $key->discount_comment_gujrati,
						"description" => $key->description,
						"desc_in_hindi" => $key->desc_in_hindi,
						"desc_in_gujrati" => $key->desc_in_gujrati,
						"gallery" => $gallery,
						"is_selected" => "",
						"venues" => $this->get_venues($key->id)
					);
				}
			}
		}
		return $loc;
	}

	public function master_god()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_god", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_temple()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("master_temple", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_pooja_category()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("pooja_category", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function master_pooja_location()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$get_Settings = $this->db->order_by('name', 'asc')->get_where("puja_location", array("status" => 1))->result();
		echo json_encode(array('status' => true, "list" => $get_Settings));
	}

	public function puja_list()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_id = $data['user_id'];
				$gods = $data['gods'];
				$category_id = $data['category_id'];
				$temples = $data['temples'];
				$location = $data['location'];

				$response = array("status" => false, "msg" => "no puja found!");
				$get_all_pujas = $this->w_m->fetch_puja($user_id, $gods, $category_id, $temples, $location);
				if (count($get_all_pujas) > 0) {
					$puja_list = array();
					foreach ($get_all_pujas as $key) {
						if ($location == '') {
							$location_details = array();
							$get_one_puja_location_details = $this->db->get_where("puja_location_table", array("puja_id" => $key->id, "status" => 1), 1)->row();
							if (count($get_one_puja_location_details) > 0) {
								$gallery = array();
								if ($get_one_puja_location_details->gallery) {
									$f1 = explode('|', $get_one_puja_location_details->gallery);
									if (count($f1) > 0) {
										for ($i = 0; $i < count($f1); $i++) {
											array_push($gallery, base_url('uploads/puja/') . '/' . $f1[$i]);
										}
									}
								}
								$location_details = $this->db->get_where("puja_location", array("id" => $get_one_puja_location_details->location_id))->row();
								$location_name = '';
								if (count($location_details) > 0) {
									$location_name = $location_details->name;
								}
								$location_details = array(
									"id" => $get_one_puja_location_details->id,
									"location_id" => $get_one_puja_location_details->location_id,
									"location_name" => $location_name,
									"price" => $get_one_puja_location_details->prices,
									"discount_prices" => $get_one_puja_location_details->discount_prices,
									"discount_comment" => $get_one_puja_location_details->discount_comment,
									"discount_comment_hindi" => $get_one_puja_location_details->discount_comment_hindi,
									"discount_comment_gujrati" => $get_one_puja_location_details->discount_comment_gujrati,
									"description" => $get_one_puja_location_details->description,
									"desc_in_hindi" => $get_one_puja_location_details->desc_in_hindi,
									"desc_in_gujrati" => $get_one_puja_location_details->desc_in_gujrati,
									"gallery" => $gallery
								);
							}
							$puja_list[] = array(
								"id" => $key->id,
								"name" => $key->name,
								"name_in_hindi" => $key->name_in_hindi,
								"name_in_gujrati" => $key->name_in_gujrati,
								"image" => base_url('uploads/puja') . '/' . $key->image,
								"pooja_type" => $key->pooja_type,
								"location_details" => $location_details,
								"get_locations" => $this->get_multiple_locations($key->id),
							);
						} else {
							$get_one_puja_location_details = $this->db->get_where("puja_location_table", array("location_id" => $location, "puja_id" => $key->id, "status" => 1), 1)->row();
							if (count($get_one_puja_location_details) > 0) {
								$location_details = array();
								$gallery = array();
								if ($get_one_puja_location_details->gallery) {
									$f1 = explode('|', $get_one_puja_location_details->gallery);
									if (count($f1) > 0) {
										for ($i = 0; $i < count($f1); $i++) {
											array_push($gallery, base_url('uploads/puja/') . '/' . $f1[$i]);
										}
									}
								}
								$location_details = $this->db->get_where("puja_location", array("id" => $get_one_puja_location_details->location_id))->row();
								$location_name = '';
								if (count($location_details) > 0) {
									$location_name = $location_details->name;
								}
								$location_details[] = array(
									"id" => $get_one_puja_location_details->id,
									"location_id" => $get_one_puja_location_details->location_id,
									"location_name" => $location_name,
									"price" => $get_one_puja_location_details->prices,
									"discount_prices" => $get_one_puja_location_details->discount_prices,
									"discount_comment" => $get_one_puja_location_details->discount_comment,
									"discount_comment_hindi" => $get_one_puja_location_details->discount_comment_hindi,
									"discount_comment_gujrati" => $get_one_puja_location_details->discount_comment_gujrati,
									"description" => $get_one_puja_location_details->description,
									"desc_in_hindi" => $get_one_puja_location_details->desc_in_hindi,
									"desc_in_gujrati" => $get_one_puja_location_details->desc_in_gujrati,
									"gallery" => $gallery
								);

								$puja_list[] = array(
									"id" => $key->id,
									"name" => $key->name,
									"name_in_hindi" => $key->name_in_hindi,
									"name_in_gujrati" => $key->name_in_gujrati,
									"image" => base_url('uploads/puja') . '/' . $key->image,
									"pooja_type" => $key->pooja_type,
									"location_details" => $location_details,
									"get_locations" => $this->get_multiple_locations($key->id),
								);
							}
						}
						$response = array("status" => true, "puja_lists" => $puja_list);
					}
				}
				echo json_encode($response);
			}
		}
	}

	public function puja_details()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
				->get('restapi_keys')
				->result_array();
			if (!$AUTH) {
				$this->fail_auth();
			} else {
				$query = "SELECT * FROM `puja_location_table` WHERE `status` = '1' AND `puja_id` = '" . $data['puja_id'] . "' AND `id`='" . $data['location_id'] . "'";
				$all_list = $this->db->query($query)->row();
				if (count($all_list) > 0) {
					$percent = 0;
					if ($all_list->discount_prices != 0.00 || $all_list->discount_prices != 0) {
						$percent = (($all_list->prices - $all_list->discount_prices) * 100) / $all_list->prices;
					}
					$is_cart = 0;
					$check_cart = $this->db->get_where("puja_temp_cart", array("main_user_id" => $data['user_id'], "puja_id" => $all_list->id))->row();
					if (count($check_cart) > 0) {
						$is_cart = 1;
					}
					$imaggess = array();
					if (!is_null($all_list->gallery)) {
						$img = explode('|', $all_list->gallery);
						foreach ($img as $key2) {
							if ($key2) {
								array_push($imaggess, base_url('uploads/puja') . '/' . $key2);
							}
						}
					}

					if (empty($imaggess)) {
						array_push($imaggess, base_url('uploads/puja/purohitServices.jpg'));
					}

					$tax_name = '';
					$tax_percentage = '';
					$tax_id = 0;

					if ($all_list->gst_prices != 0) {
						$get_tax_ = $this->db->get_where("master_tax", array("id" => $all_list->gst_prices))->row();
						if (count($get_tax_) > 0) {
							$tax_name = $get_tax_->tax_name;
							$tax_percentage = $get_tax_->rate;
							$tax_id = $get_tax_->id;
						}
					}

					$response = array(
						"status" => true,
						"id" => $all_list->id,
						"description" => $all_list->description,
						"base_price" => $all_list->prices,
						"discount_price" => $all_list->discount_prices,
						"discount_comment" => $all_list->discount_comment,
						"tax_name" => $tax_name,
						"tax_percentage" => $tax_percentage,
						"tax_id" => $tax_id,
						"percent" => $percent,
						"is_cart" => $is_cart,
						"imaggess" => $imaggess,
						"venues" => $this->get_venues($all_list->id)
					);
				} else {
					$response = array("status" => false, "message" => "not found any product");
				}
				echo json_encode($response);
			}
		}
	}

	public function get_venues($id)
	{
		$loc = array();
		$l = $this->db->order_by("position", "ASC")->get_where("puja_venue_table", array("location_id" => $id, "status" => 1))->result();
		if (count($l) > 0) {
			foreach ($l as $key) {
				$percent = 0;
				if ($key->discount_prices != 0.00 || $key->discount_prices != 0) {
					$percent = (($key->prices - $key->discount_prices) * 100) / $key->prices;
					$percent = number_format((float)$percent, 2, '.', '');
				}

				$tax_name = '';
				$tax_percentage = '';
				$tax_id = 0;

				if ($key->gst_prices != 0) {
					$get_tax_ = $this->db->get_where("master_tax", array("id" => $key->gst_prices))->row();
					if (count($get_tax_) > 0) {
						$tax_name = $get_tax_->tax_name;
						$tax_percentage = $get_tax_->rate;
						$tax_id = $get_tax_->id;
					}
				}

				$loc[] = array(
					"id" => $key->id,
					"venue_name" => $key->venue_name,
					"is_selected" => "",
					"base_price" => $key->prices,
					"discount_price" => $key->discount_prices,
					"tax_name" => $tax_name,
					"tax_percentage" => $tax_percentage,
					"tax_id" => $tax_id,
					"percent" => $percent
				);
			}
		}
		return $loc;
	}

	public function add_to_cart_puja()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$puja_id = $data['puja_id'];
				$user_id = $data['user_id'];
				$order_price = $data['order_price'];
				// $check_cart = $this->db->get_where("puja_temp_cart",array("main_user_id"=>$user_id,"puja_id"=>$puja_id))->row();
				// if (count($check_cart) > 0) 
				// {
				// 	$response = array("status"=>false,"message"=>"Already added in cart");
				// }
				// else
				// {
				if ($data['booking_time'] == 'ANY TIME') {
					$bt = '';
					$convert_booking_date_time = date('Y-m-d H:i:s');
				}
				if ($data['puja_mode'] == 'ground') {
					$bt = '';
					$convert_booking_date_time = date('Y-m-d H:i:s');
				} else {
					$bt = date('h:ia', strtotime($data['booking_time']));
					$convert_booking_date_time = date('Y-m-d H:i:s', strtotime($data['booking_date'] . ' ' . $data['booking_time']));
				}

				$array = array(
					"main_user_id" => $data['user_id'],
					"booking_type" => 1,
					"online_mode" => "video",
					"puja_mode" => $data['puja_mode'],
					"booking_for" => $data['booking_for'],
					"member_id" => $data['member_id'],
					"puja_id" => $data['puja_id'],
					"booking_time" => $data['booking_time'],
					"booking_date" => $data['booking_date'],
					"total_minutes" => $data['total_minutes'],
					"name" => $data['host_name'],
					"gender" => $data['gender'],
					"dob" => $data['dob'],
					"tob" => $data['tob'],
					"pob" => $data['place'],
					// "pob_lat"=>$data['lat'],
					// "pob_long"=>$data['long'],
					// "pob_lat_long_address"=>$data['lat_long_address'],
					"country" => $data['country'],
					"remark" => $data['remark'],
					"order_price" => $data['order_price'],
					"current_address" => $data['current_address'],
					"mother_name" => $data['mother_name'],
					"father_name" => $data['father_name'],
					"family_gotra" => $data['family_gotra'],
					"spouse_name" => $data['spouse_name'],
					"attending_family_name" => $data['attending_family_name'],
					"members_name" => $data['members_name'],
					"venue_id" => $data['venue_id'],
					"documents" => $data['images'],
					"added_on" => date('Y-m-d H:i:s'),
					"booking_location" => $data['booking_location'],
				);
				$this->db->insert("puja_temp_cart", $array);
				$response = array("status" => true, "message" => "added successfully");

				// }

				echo json_encode($response);
			}
		}
	}

	public function list_cart_puja()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$get_list = $this->db->query("SELECT * FROM `puja_temp_cart` WHERE `main_user_id` = '" . $data['user_id'] . "' ORDER BY `id` DESC")->result();
				if (count($get_list) > 0) {
					$sum = $this->db->query("SELECT SUM(`order_price`) as A FROM `puja_temp_cart` WHERE `main_user_id` = '" . $data['user_id'] . "'")->row();
					$tax = 0;
					$per = 18;
					$total_amount = 0;
					if ($sum->A > 0) {
						$GST_Amount = ($sum->A * $per) / 100;
						$total_amount = $GST_Amount + $sum->A;
					}
					foreach ($get_list as $key) {
						$is_valid = 0;
						if (strtotime($key->booking_date) >= strtotime(date('Y-m-d'))) {
							$is_valid = $this->is_valid($key);
						}
						$get_products_detail = $this->db->get_where("puja_location_table", array("id" => $key->puja_id))->row();
						if ($get_products_detail->discount_prices != 0.00 || $get_products_detail->discount_prices != 0) {
							$percent = (($get_products_detail->prices - $get_products_detail->discount_prices) * 100) / $get_products_detail->prices;
						} else {
							$percent = '';
						}

						$name = '';
						$image = base_url('uploads/puja/birthday.jpg');
						$get_puja = $this->db->get_where("puja", array("id" => $key->puja_id))->row();
						if (count($get_puja) > 0) {
							$name = $get_puja->name;
							$image = base_url('uploads/puja/') . '/' . $get_puja->image;
						}

						$venue_ = '';
						if ($key->venue_id != 0) {
							$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
							if (count($get_venue) > 0) {
								$venue_  = $get_venue->venue_name;
							}
						}

						$list[] = array(
							"cart_id" => $key->id,
							"puja_id" => $key->id,
							"order_price" => $key->order_price,
							"name" => $name,
							"booking_date" => $key->booking_date,
							"booking_time" => $key->booking_time,
							"venue" => $venue_,
							"puja_id" => $key->id,
							"base_price" => $get_products_detail->prices,
							"discount_price" => $get_products_detail->discount_prices,
							"description" => $get_products_detail->description,
							"image" => $image, //
							"is_valid" => $is_valid
						);
					}
					$response = array('status' => true, "list" => $list, "total" => $sum->A, "sum_total" => $total_amount, "tax_amount" => $GST_Amount, "tax_percent" => $per);
				} else {
					$response = array('status' => false, "message" => "empty cart");
				}
				echo json_encode($response);
			}
		}
	}

	public function is_valid($data)
	{
		$is_valid = 0;
		$apointment_date = $data->booking_date;
		$id = $data->puja_id;
		$user_id = $data->main_user_id;
		$booking_time = $data->booking_time;
		$day = strtolower(date('D', strtotime($apointment_date)));
		$today_date = strtotime(date('Y-m-d'));
		$given_date = strtotime($apointment_date);
		$response = array("status" => false, "msg" => "not found any slots");
		if ($given_date >= $today_date) {
			$CHECK_time_slots = $this->db->get_where("puja_time_slots", array("puja_id" => $id, "date" => $apointment_date, 'status' => 1))->row();
			if (count($CHECK_time_slots) > 0) {
				$master = $this->db->get_where('puja_location_table', array("id" => $id, "status" => 1))->row();
				if (count($master) > 0) {
					$before_time_can_book = 10;
					if ($master->booking_time > 0) {
						$before_time_can_book = $master->booking_time;
					}
					$working_time = json_decode($CHECK_time_slots->json, true);
					if (!empty($working_time)) {
						if (count($working_time) > 0) {
							$live_time_plus_minutes = date('Y-m-d H:i', strtotime("+" . $before_time_can_book . " minutes", strtotime(date('Y-m-d H:i'))));
							if ($CHECK_time_slots->stock > 0) {
								$get_total_stocks_booked = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `status` IN (0,1,5)")->row();
								$total_stock_book = $get_total_stocks_booked->A;
								$total_stock = $CHECK_time_slots->stock;
								$remain_stock = $total_stock - $total_stock_book;
								if ($remain_stock > 0) {
									if ($booking_time == 'ANY TIME') {
										$is_valid = 1;
									} else {

										for ($i = 0; $i < count($working_time); $i++) {
											$start_time_get = strtotime($working_time[$i]['start']);
											$start_time = strtotime($booking_time);

											if ($start_time_get == $start_time) {
												$comparison = strtotime($live_time_plus_minutes);
												$time_derive_with_given_date = ($apointment_date . ' ' . $booking_time);
												$comparison_with = strtotime($time_derive_with_given_date);
												if ($comparison_with >= $comparison) {
													$check_bt_ = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$apointment_date' AND `puja_mode`='online' AND `booking_time` = '" . $booking_time . "' AND `puja_id` = '$id' AND `user_id` = '" . $user_id . "' AND `status` IN ('0','1','5')")->result();
													$already_in_time_check = array();
													if (count($check_bt_) > 0) {
													} else {
														$is_valid = 1;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			} else {
				$master = $this->db->get_where('puja_location_table', array("id" => $id))->row();
				if (count($master) > 0) {
					$working_time = json_decode($master->day_wise_time, true);
					if (!empty($working_time)) {
						$day_wise_stock = json_decode($master->day_wise_stock, true);
						if (!empty($day_wise_stock)) {
							if ($day == 'mon') {
								$day_wise = 'mon_stock';
							} elseif ($day == 'tue') {
								$day_wise = 'tue_stock';
							} elseif ($day == 'wed') {
								$day_wise = 'wed_stock';
							} elseif ($day == 'thu') {
								$day_wise = 'thu_stock';
							} elseif ($day == 'fri') {
								$day_wise = 'fri_stock';
							} elseif ($day == 'sat') {
								$day_wise = 'sat_stock';
							} elseif ($day == 'sun') {
								$day_wise = 'sun_stock';
							}
							if (!empty($day_wise_stock[$day_wise])) {
								if ($day_wise_stock[$day_wise] > 0) {
									if (!empty($working_time[$day])) {
										$before_time_can_book = 10;
										if ($master->booking_time > 0) {
											$before_time_can_book = $master->booking_time;
										}
										$get_total_stocks_booked = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `status` IN (0,1,5)")->row();
										$total_stock_book = $get_total_stocks_booked->A;
										$total_stock = $day_wise_stock[$day_wise];
										$remain_stock = $total_stock - $total_stock_book;
										if ($remain_stock > 0) {
											if ($booking_time == 'ANY TIME') {
												$is_valid = 1;
											} else {
												for ($i = 0; $i < count($working_time[$day]); $i++) {
													$start_time_get = strtotime($working_time[$day][$i]['start']);
													$start_time = strtotime($booking_time);
													if ($start_time_get == $start_time) {
														$live_time_plus_minutes = date('Y-m-d H:i', strtotime("+" . $before_time_can_book . " minutes", strtotime(date('Y-m-d H:i'))));
														$comparison = strtotime($live_time_plus_minutes);
														$time_derive_with_given_date = ($apointment_date . ' ' . $booking_time);
														$comparison_with = strtotime($time_derive_with_given_date);
														if ($comparison_with >= $comparison) {
															$check_bt_ = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$apointment_date' AND `puja_mode`='online' AND `booking_time` = '" . $booking_time . "' AND `puja_id` = '$id' AND `user_id` = '" . $user_id . "' AND `status` IN ('0','1','5')")->result();
															$already_in_time_check = array();
															if (count($check_bt_) > 0) {
															} else {
																$is_valid = 1;
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $is_valid;
	}

	public function delete_cart_puja()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->db->where("id", $data['cart_id']);
				$this->db->delete('puja_temp_cart');
				$get_list = $this->db->query("SELECT * FROM `puja_temp_cart` WHERE `main_user_id` = '" . $data['user_id'] . "' ORDER BY `id` DESC")->result();
				if (count($get_list) > 0) {
					$sum = $this->db->query("SELECT SUM(`order_price`) as A FROM `puja_temp_cart` WHERE `main_user_id` = '" . $data['user_id'] . "'")->row();
					$response = array('status' => true, "sum_total" => $sum->A);
				} else {
					$response = array('status' => false, "message" => "empty cart");
				}
				echo json_encode($response);
			}
		}
	}

	public function common_time_slots_comm_old()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$apointment_date = $data['select_date'];
				$id = $data['id'];
				$user_id = $data['user_id'];
				$day = strtolower(date('D', strtotime($apointment_date)));
				//Check today date
				$today_date = strtotime(date('Y-m-d'));
				$given_date = strtotime($apointment_date);
				// $yajman_list = $this->db->get_where("pooja_yajman_list",array("puja_id"=>$id))->result();
				$venue_list = $this->db->get_where("pooja_venus_list", array("puja_id" => $id))->result();
				if ($given_date >= $today_date) {
					$master = $this->db->get_where('pooja', array("id" => $id))->row();
					// print_r($master->booking_time); die;
					if (count($master) > 0) {
						$check_bt_ = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$apointment_date' AND `puja_id` = '$id' AND `status` = '0'")->result();
						$already_in_time_check = array();
						if (count($check_bt_) > 0) {
							foreach ($check_bt_ as $keybt) {
								$time_bt = $keybt->booking_time;
								$minutes = $keybt->total_minutes;

								$one_Cal_time = strtotime($time_bt);
								$cal_time = strtotime('+' . $minutes . ' minutes', strtotime($time_bt));

								$array_inn_ol = array("time_bt" => $one_Cal_time, "time_bt_add" => $cal_time, "minutes_bt" => $minutes);
								array_push($already_in_time_check, $array_inn_ol);
							}
						}


						$working_time = json_decode($master->booking_time, true);
						if (!empty($working_time)) {
							//1st session timing
							if (!empty($working_time[$day][0]['start'])) {
								$live_time_plus_minutes = date('H:i', strtotime("+3 minutes", strtotime(date('Y-m-d H:i'))));
								$slot = array();
								$anytimes = array("time" => 'ANY TIME', "is_selected" => "");
								array_push($slot, $anytimes);
								if (!empty($working_time[$day][0]['start']) && !empty($working_time[$day][0]['end'])) {
									$start_time = strtotime($working_time[$day][0]['start']);
									$end_time = strtotime($working_time[$day][0]['end']);
									$fifteen_minutes = 900; //strtotime("+15 minutes");
									$new_end_time = date('H:i', strtotime("+15 minutes", strtotime($working_time[$day][0]['end'])));
									$start = new DateTimeImmutable($working_time[$day][0]['start']);
									$end = new DateTimeImmutable($new_end_time);
									$interval = new DateInterval('PT15M'); //15 minute interval
									$range = new DatePeriod($start, $interval, $end);
									foreach ($range as $time) {
										$time_derive = $time->format('h:ia');
										$time_derive_with_given_date = $time->format($apointment_date . ' h:ia');
										$comparison = strtotime($live_time_plus_minutes);
										$comparison_with = strtotime($time_derive_with_given_date);
										if ($comparison_with >= $comparison) {
											if (!empty($already_in_time_check)) {
												$check_old_booking_ = $this->check_old_recur($already_in_time_check, $time_derive);
												if ($check_old_booking_) {
													if (strtotime($time_derive) < $end_time) {
														$times = array(
															"time" => $time_derive,
															"is_selected" => ""
														);
														array_push($slot, $times);
													}
												}
											} else {
												if (strtotime($time_derive) < $end_time) {
													$times = array(
														"time" => $time_derive,
														"is_selected" => ""
													);
													array_push($slot, $times);
												}
											}
										}
									}
								}

								// 2nd session timing
								if (!empty($working_time[$day][1]['start'])) {
									if (!empty($working_time[$day][1]['start']) && !empty($working_time[$day][1]['end'])) {
										$start_time2 = strtotime($working_time[$day][1]['start']);
										$end_time2 = strtotime($working_time[$day][1]['end']);
										$fifteen_minutes2 = 900; //strtotime("+15 minutes");
										$new_end_time2 = date('H:i', strtotime("+15 minutes", strtotime($working_time[$day][1]['end'])));
										$start2 = new DateTimeImmutable($working_time[$day][1]['start']);
										$end2 = new DateTimeImmutable($new_end_time2);
										$interval2 = new DateInterval('PT15M'); //15 minute interval
										$range2 = new DatePeriod($start2, $interval2, $end2);
										foreach ($range2 as $time2) {
											$time_derive2 = $time2->format('h:ia');
											$time_derive_with_given_date2 = $time2->format($apointment_date . ' h:ia');
											$comparison2 = strtotime($live_time_plus_minutes);
											$comparison_with2 = strtotime($time_derive_with_given_date2);
											if ($comparison_with2 >= $comparison2) {
												if (!empty($already_in_time_check)) {
													$check_old_booking_2 = $this->check_old_recur($already_in_time_check, $time_derive2);
													if ($check_old_booking_2) {
														if (strtotime($time_derive2) < $end_time2) {
															$times = array(
																"time" => $time_derive2,
																"is_selected" => ""
															);
															array_push($slot, $times);
														}
													}
												} else {
													if (strtotime($time_derive2) < $end_time2) {
														$times = array(
															"time" => $time_derive2,
															"is_selected" => ""
														);
														array_push($slot, $times);
													}
												}
											}
										}
									}
								}
								$response = array("status" => true, "slot" => $slot, "venue_list" => $venue_list);
							} else {
								$response = array("status" => false, "msg" => "no time slots", "venue_list" => $venue_list);
							}
						} else {
							$response = array("status" => false, "msg" => "no time slots found", "venue_list" => $venue_list);
						}
					} else {
						$response = array("status" => false, "msg" => "no time slots found", "venue_list" => $venue_list);
					}
				} else {
					$response = array("status" => false, "msg" => "date is on past", "venue_list" => $venue_list);
				}
				echo json_encode($response);
			}
		}
	}

	public function common_time_slots_comm_old1()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$apointment_date = $data['select_date'];
				$id = $data['id'];
				$user_id = $data['user_id'];
				$day = strtolower(date('D', strtotime($apointment_date)));
				//Check today date
				$today_date = strtotime(date('Y-m-d'));
				$given_date = strtotime($apointment_date);
				$venue_list = $this->db->get_where("pooja_venus_list", array("puja_id" => $id))->result();
				$response = array("status" => false, "msg" => "not found any slots", "venue_list" => $venue_list);
				if ($given_date >= $today_date) {
					$master = $this->db->get_where('pooja', array("id" => $id))->row();
					if (count($master) > 0) {
						$check_bt_ = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$apointment_date' AND `puja_id` = '$id' AND `status` = '0'")->result();
						$already_in_time_check = array();
						if (count($check_bt_) > 0) {
							foreach ($check_bt_ as $keybt) {
								$time_bt = $keybt->booking_time;
								$minutes = $keybt->total_minutes;

								$one_Cal_time = strtotime($time_bt);
								$cal_time = strtotime('+' . $minutes . ' minutes', strtotime($time_bt));

								$array_inn_ol = array("time_bt" => $one_Cal_time, "time_bt_add" => $cal_time, "minutes_bt" => $minutes);
								array_push($already_in_time_check, $array_inn_ol);
							}
						}

						$wt = '{"mon":[{"start":"09:00am","end":"11:00am","stock":"8"},{"start":"12:00pm","end":"01:00pm","stock":"10"},{"start":"02:00pm","end":"04:00pm","stock":"10"},{"start":"02:00pm","end":"04:00pm","stock":"10"},{"start":"05:00pm","end":"06:00pm","stock":"10"},{"start":"07:00pm","end":"09:00pm","stock":"10"}],"tue":[{"start":"09:00am","end":"11:00am","stock":"8"},{"start":"12:00pm","end":"01:00pm","stock":"10"},{"start":"02:00pm","end":"04:00pm","stock":"10"}],"wed":[{"start":"09:00am","end":"11:00am","stock":"8"},{"start":"12:00pm","end":"01:00pm","stock":"10"},{"start":"02:00pm","end":"04:00pm","stock":"10"}],"thu":[{"start":"09:00am","end":"11:00am","stock":"8"},{"start":"12:00pm","end":"01:00pm","stock":"10"},{"start":"01:15pm","end":"02:00pm","stock":"8"},{"start":"02:00pm","end":"04:00pm","stock":"10"}],"fri":[{"start":"09:00am","end":"11:00am","stock":"8"},{"start":"12:00pm","end":"01:00pm","stock":"10"},{"start":"02:00pm","end":"04:00pm","stock":"10"}],"sat":[{"start":"09:00am","end":"11:00am","stock":"8"},{"start":"12:00pm","end":"01:00pm","stock":"10"},{"start":"02:00pm","end":"04:00pm","stock":"10"}],"sun":[{"start":"09:00am","end":"11:00am","stock":"8"},{"start":"12:00pm","end":"01:00pm","stock":"10"},{"start":"02:00pm","end":"04:00pm","stock":"10"}]}';
						$working_time = json_decode($master->booking_time, true);
						if (!empty($working_time)) {
							//1st session timing
							if (!empty($working_time[$day])) {
								$live_time_plus_minutes = date('H:i', strtotime("+10 minutes", strtotime(date('Y-m-d H:i'))));
								$slot = array();
								$anytimes = array("time" => 'ANY TIME', "is_selected" => "", "end_time" => '', "minutes" => 0, "stock" => 5);
								array_push($slot, $anytimes);
								for ($i = 0; $i < count($working_time[$day]); $i++) {

									// echo "<br>".$working_time[$day][$i]['start'];
									// echo "<br>".$working_time[$day][$i]['end'];
									// echo "<br>".$working_time[$day][$i]['stock'];
									if ($working_time[$day][$i]['stock'] > 0) {
										$get_total_stocks_booked = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `booking_time` = '" . $working_time[$day][$i]['start'] . "' AND `status` IN (0,1,5)")->row();
										$get_total_stocks_booked_cart = $this->db->query("SELECT COUNT(*) AS A FROM `puja_temp_cart` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `booking_time` = '" . $working_time[$day][$i]['start'] . "'")->row();
										$total_stock_book = $get_total_stocks_booked->A + $get_total_stocks_booked_cart->A;
										$total_stock = $working_time[$day][$i]['stock'];
										$remain_stock = $total_stock - $total_stock_book;
										if ($remain_stock > 0) {
											$start_time = strtotime($working_time[$day][$i]['start']);
											$end_time = strtotime($working_time[$day][$i]['end']);
											$comparison = strtotime($live_time_plus_minutes);
											$time_derive_with_given_date = ($apointment_date . ' ' . $working_time[$day][$i]['start']);
											$comparison_with = strtotime($time_derive_with_given_date);
											if ($comparison_with >= $comparison) {
												$start_time_with_date = strtotime($apointment_date . ' ' . $working_time[$day][$i]['start']);
												$end_time_with_date = strtotime($apointment_date . ' ' . $working_time[$day][$i]['end']);
												$minutes = ($end_time_with_date - $start_time_with_date) / 60;
												$times = array(
													"time" => $working_time[$day][$i]['start'],
													"is_selected" => "",
													"stock" => $remain_stock,
													"end_time" => $working_time[$day][$i]['end'],
													"minutes" => $minutes
												);
												array_push($slot, $times);
											}
										}
									}
								}

								if (!empty($slot)) {
									$response = array("status" => true, "slot" => $slot, "venue_list" => $venue_list);
								}
							}
						}
					}
				}
				echo json_encode($response);
			}
		}
	}

	public function common_time_slots_comm()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$apointment_date = $data['select_date'];
				$id = $data['id'];
				$user_id = $data['user_id'];
				$day = strtolower(date('D', strtotime($apointment_date)));

				//Check today date
				$today_date = strtotime(date('Y-m-d'));
				$given_date = strtotime($apointment_date);
				$response = array("status" => false, "msg" => "not found any slots");
				if ($given_date >= $today_date) {
					$CHECK_time_slots = $this->db->get_where("puja_time_slots", array("puja_id" => $id, "date" => $apointment_date, 'status' => 1))->row();
					if (count($CHECK_time_slots) > 0) {
						$slot = array();
						$check_bt_ = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$apointment_date' AND `puja_mode`='online' AND `booking_time` <> 'ANY TIME' AND `puja_id` = '$id' AND `user_id` = '$user_id' AND `status` IN ('0','1','5')")->result();
						$already_in_time_check = array();
						if (count($check_bt_) > 0) {
							// foreach ($check_bt_ as $keybt) 
							// {
							// 	$time_bt = $keybt->booking_time;
							// 	$minutes = $keybt->total_minutes;

							// 	$one_Cal_time = strtotime($time_bt);
							// 	$cal_time = strtotime('+'.$minutes.' minutes',strtotime($time_bt));

							// 	$array_inn_ol = array("time_bt"=>$one_Cal_time,"time_bt_add"=>$cal_time,"minutes_bt"=>$minutes);
							// 	array_push($already_in_time_check, $array_inn_ol);
							// }
						}
						$master = $this->db->get_where('puja_location_table', array("id" => $id))->row();
						if (count($master) > 0) {
							$before_time_can_book = 10;
							if ($master->booking_time > 0) {
								$before_time_can_book = $master->booking_time;
							}
							$morning_slot_array = array();
							$evening_slot_array = array();


							/*anytime
							if (!empty($anytime_working_time)) 
							{
								if ($anytime_working_time[$day] > 0) 
								{
									$get_total_stocks_anytime_booked = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `booking_time` = 'ANY TIME' AND `status` IN (0,1,5)")->row();
									$total_stock_book_anytime = $get_total_stocks_anytime_booked->A;
									$total_stock_anytime = $anytime_working_time[$day];
									$remain_stock_anytime = $total_stock_anytime - $total_stock_book_anytime;
									if ($remain_stock_anytime > 0) 
									{
										
									}
								}
							}

							//end anytime*/
						}
						$working_time = json_decode($CHECK_time_slots->json, true);
						if (!empty($working_time)) {
							if (count($working_time) > 0) {
								$live_time_plus_minutes = date('Y-m-d H:i', strtotime("+" . $before_time_can_book . " minutes", strtotime(date('Y-m-d H:i'))));
								if ($CHECK_time_slots->stock > 0) {
									$get_total_stocks_booked = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `status` IN (0,1,5)")->row();
									$total_stock_book = $get_total_stocks_booked->A;
									$total_stock = $CHECK_time_slots->stock;
									$remain_stock = $total_stock - $total_stock_book;
									if ($remain_stock > 0) {
										$anytime_flag = 0;
										$comparison_anytime = strtotime($live_time_plus_minutes);
										$time_derive_with_given_date_anytime = ($apointment_date . ' ' . date('h:ia'));
										$comparison_with_anytime = strtotime($time_derive_with_given_date_anytime);
										if ($comparison_with_anytime >= $comparison_anytime) {
											$anytime_flag = 1;
											$anytimes = array("time" => 'ANY TIME', "is_selected" => "", "end_time" => '', "minutes" => 0, "stock" => $remain_stock);
											array_push($morning_slot_array, $anytimes);
											array_push($evening_slot_array, $anytimes);
										}
										for ($i = 0; $i < count($working_time); $i++) {
											$start_time = strtotime($working_time[$i]['start']);
											$end_time = strtotime($working_time[$i]['end']);
											$comparison = strtotime($live_time_plus_minutes);
											$time_derive_with_given_date = ($apointment_date . ' ' . $working_time[$i]['start']);
											$comparison_with = strtotime($time_derive_with_given_date);
											if ($comparison_with >= $comparison) {
												if (!empty($already_in_time_check)) {
													$check_old_booking_ = $this->check_old_recur($already_in_time_check, $working_time[$i]['start']);
													if ($check_old_booking_) {
														$start_time_with_date = strtotime($apointment_date . ' ' . $working_time[$i]['start']);
														$end_time_with_date = strtotime($apointment_date . ' ' . $working_time[$i]['end']);
														$minutes = ($end_time_with_date - $start_time_with_date) / 60;
														$times = array(
															"time" => $working_time[$i]['start'],
															"is_selected" => "",
															"stock" => $remain_stock,
															"end_time" => $working_time[$i]['end'],
															"minutes" => $minutes
														);
														if (strtotime($working_time[$i]['start']) >= strtotime('12:00am') && strtotime($working_time[$i]['start']) <= strtotime('11:59am')) {
															array_push($morning_slot_array, $times);
														} elseif (strtotime($working_time[$i]['start']) >= strtotime('12:00pm') && strtotime($working_time[$i]['start']) <= strtotime('11:59pm')) {
															array_push($evening_slot_array, $times);
														}
													}
												} else {
													$start_time_with_date = strtotime($apointment_date . ' ' . $working_time[$i]['start']);
													$end_time_with_date = strtotime($apointment_date . ' ' . $working_time[$i]['end']);
													$minutes = ($end_time_with_date - $start_time_with_date) / 60;
													$times = array(
														"time" => $working_time[$i]['start'],
														"is_selected" => "",
														"stock" => $remain_stock,
														"end_time" => $working_time[$i]['end'],
														"minutes" => $minutes
													);
													if (strtotime($working_time[$i]['start']) >= strtotime('12:00am') && strtotime($working_time[$i]['start']) <= strtotime('11:59am')) {
														array_push($morning_slot_array, $times);
													} elseif (strtotime($working_time[$i]['start']) >= strtotime('12:00pm') && strtotime($working_time[$i]['start']) <= strtotime('11:59pm')) {
														array_push($evening_slot_array, $times);
													}
												}
											}
										}
										if ($anytime_flag == 0 && !empty($morning_slot_array)) {
											$anytimes = array("time" => 'ANY TIME', "is_selected" => "", "end_time" => '', "minutes" => 0, "stock" => $remain_stock);
											array_push($morning_slot_array, $anytimes);
										} elseif ($anytime_flag == 0 && !empty($evening_slot_array)) {
											$anytimes = array("time" => 'ANY TIME', "is_selected" => "", "end_time" => '', "minutes" => 0, "stock" => $remain_stock);
											array_push($evening_slot_array, $anytimes);
										}
									}
								}
							}
						}
						if (!empty($morning_slot_array) || !empty($evening_slot_array)) {
							$response = array("status" => true, "morning_slot_array" => $morning_slot_array, "evening_slot_array" => $evening_slot_array);
						}
					} else {
						$master = $this->db->get_where('puja_location_table', array("id" => $id))->row();
						if (count($master) > 0) {
							$slot = array();
							$check_bt_ = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$apointment_date' AND `booking_time` <> 'ANY TIME' AND `puja_id` = '$id' AND `user_id` = '$user_id' AND `status` IN ('0','1','5')")->result();
							$already_in_time_check = array();
							if (count($check_bt_) > 0) {
								// foreach ($check_bt_ as $keybt) 
								// {
								// 	$time_bt = $keybt->booking_time;
								// 	$minutes = $keybt->total_minutes;

								// 	$one_Cal_time = strtotime($time_bt);
								// 	$cal_time = strtotime('+'.$minutes.' minutes',strtotime($time_bt));

								// 	$array_inn_ol = array("time_bt"=>$one_Cal_time,"time_bt_add"=>$cal_time,"minutes_bt"=>$minutes);
								// 	array_push($already_in_time_check, $array_inn_ol);
								// }
							}

							/*anytime
							$anytime = $master->anytime_stock;
							$anytime_working_time = json_decode($anytime,true);
							if (!empty($anytime_working_time)) 
							{
								if ($anytime_working_time[$day] > 0) 
								{
									$get_total_stocks_anytime_booked = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `booking_time` = 'ANY TIME' AND `status` IN (0,1,5)")->row();
									$total_stock_book_anytime = $get_total_stocks_anytime_booked->A;
									$total_stock_anytime = $anytime_working_time[$day];
									$remain_stock_anytime = $total_stock_anytime - $total_stock_book_anytime;
									if ($remain_stock_anytime > 0) 
									{
										$anytimes = array("time"=>'ANY TIME',"is_selected"=>"","end_time"=>'',"minutes"=>0,"stock"=>$remain_stock_anytime);
										array_push($slot, $anytimes);
									}
								}
							}

							//end anytime*/
							$working_time = json_decode($master->day_wise_time, true);
							if (!empty($working_time)) {
								$day_wise_stock = json_decode($master->day_wise_stock, true);
								if (!empty($day_wise_stock)) {
									if ($day == 'mon') {
										$day_wise = 'mon_stock';
									} elseif ($day == 'tue') {
										$day_wise = 'tue_stock';
									} elseif ($day == 'wed') {
										$day_wise = 'wed_stock';
									} elseif ($day == 'thu') {
										$day_wise = 'thu_stock';
									} elseif ($day == 'fri') {
										$day_wise = 'fri_stock';
									} elseif ($day == 'sat') {
										$day_wise = 'sat_stock';
									} elseif ($day == 'sun') {
										$day_wise = 'sun_stock';
									}

									if (!empty($day_wise_stock[$day_wise])) {
										if ($day_wise_stock[$day_wise] > 0) {
											if (!empty($working_time[$day])) {
												$before_time_can_book = 10;
												if ($master->booking_time > 0) {
													$before_time_can_book = $master->booking_time;
												}
												$morning_slot_array = array();
												$evening_slot_array = array();

												$get_total_stocks_booked = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `puja_id` = '$id' AND `booking_date`='$apointment_date' AND `status` IN (0,1,5)")->row();
												$total_stock_book = $get_total_stocks_booked->A;
												$total_stock = $day_wise_stock[$day_wise];
												$remain_stock = $total_stock - $total_stock_book;
												if ($remain_stock > 0) {
													$live_time_plus_minutes = date('Y-m-d H:i', strtotime("+" . $before_time_can_book . " minutes", strtotime(date('Y-m-d H:i'))));
													$anytime_flag = 0;
													$comparison_anytime = strtotime($live_time_plus_minutes);
													$time_derive_with_given_date_anytime = ($apointment_date . ' ' . date('h:ia'));
													$comparison_with_anytime = strtotime($time_derive_with_given_date_anytime);
													if ($comparison_with_anytime >= $comparison_anytime) {
														$anytime_flag = 1;
														$anytimes = array("time" => 'ANY TIME', "is_selected" => "", "end_time" => '', "minutes" => 0, "stock" => $remain_stock);
														array_push($morning_slot_array, $anytimes);
														array_push($evening_slot_array, $anytimes);
													}


													for ($i = 0; $i < count($working_time[$day]); $i++) {
														$start_time = strtotime($working_time[$day][$i]['start']);
														$end_time = strtotime($working_time[$day][$i]['end']);
														$comparison = strtotime($live_time_plus_minutes);
														$time_derive_with_given_date = ($apointment_date . ' ' . $working_time[$day][$i]['start']);
														$comparison_with = strtotime($time_derive_with_given_date);
														if ($comparison_with >= $comparison) {
															if (!empty($already_in_time_check)) {
																$check_old_booking_ = $this->check_old_recur($already_in_time_check, $working_time[$day][$i]['start']);
																if ($check_old_booking_) {
																	$start_time_with_date = strtotime($apointment_date . ' ' . $working_time[$day][$i]['start']);
																	$end_time_with_date = strtotime($apointment_date . ' ' . $working_time[$day][$i]['end']);
																	$minutes = ($end_time_with_date - $start_time_with_date) / 60;
																	$times = array(
																		"time" => $working_time[$day][$i]['start'],
																		"is_selected" => "",
																		"stock" => $remain_stock,
																		"end_time" => $working_time[$day][$i]['end'],
																		"minutes" => $minutes
																	);
																	if (strtotime($working_time[$day][$i]['start']) >= strtotime('12:00am') && strtotime($working_time[$day][$i]['start']) <= strtotime('11:59am')) {
																		array_push($morning_slot_array, $times);
																	} elseif (strtotime($working_time[$day][$i]['start']) >= strtotime('12:00pm') && strtotime($working_time[$day][$i]['start']) <= strtotime('11:59pm')) {
																		array_push($evening_slot_array, $times);
																	}
																}
															} else {
																$start_time_with_date = strtotime($apointment_date . ' ' . $working_time[$day][$i]['start']);
																$end_time_with_date = strtotime($apointment_date . ' ' . $working_time[$day][$i]['end']);
																$minutes = ($end_time_with_date - $start_time_with_date) / 60;
																$times = array(
																	"time" => $working_time[$day][$i]['start'],
																	"is_selected" => "",
																	"stock" => $remain_stock,
																	"end_time" => $working_time[$day][$i]['end'],
																	"minutes" => $minutes
																);
																if (strtotime($working_time[$day][$i]['start']) >= strtotime('12:00am') && strtotime($working_time[$day][$i]['start']) <= strtotime('11:59am')) {
																	array_push($morning_slot_array, $times);
																} elseif (strtotime($working_time[$day][$i]['start']) >= strtotime('12:00pm') && strtotime($working_time[$day][$i]['start']) <= strtotime('11:59pm')) {
																	array_push($evening_slot_array, $times);
																}
															}
														}
													}
												}

												if ($anytime_flag == 0 && !empty($morning_slot_array)) {
													$anytimes = array("time" => 'ANY TIME', "is_selected" => "", "end_time" => '', "minutes" => 0, "stock" => $remain_stock);
													array_push($morning_slot_array, $anytimes);
												} elseif ($anytime_flag == 0 && !empty($evening_slot_array)) {
													$anytimes = array("time" => 'ANY TIME', "is_selected" => "", "end_time" => '', "minutes" => 0, "stock" => $remain_stock);
													array_push($evening_slot_array, $anytimes);
												}

												if (!empty($morning_slot_array) || !empty($evening_slot_array)) {
													$response = array("status" => true, "morning_slot_array" => $morning_slot_array, "evening_slot_array" => $evening_slot_array);
												}
											}
										}
									}
								}
							}
						}
					}
				}
				echo json_encode($response);
			}
		}
	}

	private function check_old_recur($already_in_time_check, $time_derive)
	{
		// echo "<br>".print_r($already_in_time_check);
		//echo "<br><br>". $time_derive."<br>";
		// $time_slots_ = array();
		// //$time_slots_allow = array();
		// $for = 'chat';
		// $get_for = $this->db->get_where("master_price_management",array("for_"=>$for,"status"=>1))->result();
		// foreach ($get_for as $key2) 
		// {
		// 	$time_min = $this->db->get_where("master_time",array("id"=>$key2->time_id))->row();
		// 	if (!in_array($time_min->minute, $time_slots_)) 
		// 	{
		// 		array_push($time_slots_, $time_min->minute);		
		// 	}
		// }
		$i = 0;
		$array = array();
		$convert_time = strtotime($time_derive);
		foreach ($already_in_time_check as $key) {
			if ($convert_time >= $key['time_bt'] && $convert_time <= $key['time_bt_add']) {
				array_push($array, $convert_time);
			}
			/* Further Development else
			// {
			// 	echo "<br>"."xx2xx";
			// }
			// echo "<br><br>". $time_derive."<br>".print_r($time_slots_allow);
			// echo "<br>".$time_derive;
			// 
			// echo "<br>".date('H:ia', $key['time_bt']);
			// echo "<br>".date('H:ia', $key['time_bt_add']);
			// echo "<br>";
			// $i++; */
		}

		if (empty($array)) {
			return true;
		} else {
			return false;
		}
	}

	public function time_slots_with_price()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$apointment_date = $data['select_date'];
			$id = $data['id'];
			$user_id = $data['user_id'];
			$time_slots = $data['time_slots'];
			$get_bookings = strtotime($apointment_date . ' ' . $time_slots);
			$details = $this->db->order_by('price', 'ASC')->get_where('master_price_management', array("for_" => $data['for'], "status" => 1))->result();
			if (count($details) > 0) {
				$list = array();
				foreach ($details as $key) {
					$get_minutes = $this->db->get_where("master_time", array("id" => $key->time_id))->row();
					$one_Cal_time = strtotime($time_slots);
					$cal_time = strtotime('+' . $get_minutes->minute . ' minutes', strtotime($time_slots));
					$cal_time = strtotime('- 1 second', $cal_time);
					//echo $time_slots.date('h:ia:s',$cal_time);
					$check = $this->db->query("SELECT `id`,`booking_date`, `booking_time` FROM `booking` WHERE `booking_date` = '" . $apointment_date . "' AND `status` IN ('1','0') AND `timeinnumber` BETWEEN '" . $one_Cal_time . "' AND '" . $cal_time . "'")->result();
					if (count($check) > 0) {
					} else {
						$list[] = array("minutes" => $get_minutes->minute, "price" => $key->price, "is_selected" => "");
					}
				}
				$response = array("status" => true, "detail" => $list);
			} else {
				$response = array("status" => false, "detail" => "not found!");
			}
			echo json_encode($response);
		}
	}
	/* End Bookmark Module of add doctor */


	//Add Booking in temporary booking 
	//Add Booking in temporary booking 
	public function add_temporary_booking()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				/* ['for']
					
					['Module']
					2 			=>			'Online Counsult'
					3 			=>			'gems products'
				
				*/
				$this->form_validation->set_data($data);
				if ($this->form_validation->run('on_appointment') !== false) {
					$for = $data['for'];
					$module = $data['module'];
					if ($for == 1) {
						$this->add_in_puja_temp($data);
					} elseif ($for == 2) {
						$this->add_in_puja_cart_temp($data);
					} else {
						$result =  array('status' => false, 'message' => "not found for any module contact with team");
						echo json_encode($result);
					}
				} else {
					$result =  array('status' => false, 'message' => array_values($this->form_validation->get_errors_as_array()));
					echo json_encode($result);
				}
			}
		}
	}

	public function add_in_puja_temp($data)
	{
		$get_user = $this->w_m->get_user($data['user_id']);
		if ($data['booking_time'] == 'ANY TIME') {
			$bt = '';
			$convert_booking_date_time = date('Y-m-d H:i:s');
		} else {
			$bt = date('h:ia', strtotime($data['booking_time']));
			$convert_booking_date_time = date('Y-m-d H:i:s', strtotime($data['booking_date'] . ' ' . $data['booking_time']));
		}

		$array = array(
			"booking_type" => 1,
			"user_id" => $data['user_id'],
			"online_mode" => 'video',
			"puja_id" => $data['puja_id'],
			"booking_for" => 'self', //$data['booking_for'],
			"booking_time" => $data['booking_time'],
			"booking_date" => $data['booking_date'],
			"total_minutes" => $data['total_minutes'],
			"timeinnumber" => '',
			"booking_date_time" => $convert_booking_date_time,
			"name" => $data['name'],
			"gender" => $data['gender'],
			"dob" => $data['dob'],
			"tob" => $data['tob'],
			"pob" => $data['place'],
			"pob_lat" => $data['lat'],
			"pob_long" => $data['long'],
			"pob_lat_long_address" => $data['lat_long_address'],
			"country" => $data['country'],
			"remark" => $data['remark'],
			"coupan_code" => $data['coupan_code'],
			"coupan_code_id" => $data['coupan_code_id'],
			"from_payment_gateway" => 0,
			"total_amount" => $data['total_amount'],
			"discount_amount" => $data['discount_amount'],
			"tax_amount" => $data['tax_amount'],
			"added_on" => date('Y-m-d H:i:s'),
			"booking_location" => $data['booking_location'],
			"current_address" => $data['current_address'],
			"mother_name" => $data['mother_name'],
			"father_name" => $data['father_name'],
			"family_gotra" => $data['family_gotra'],
			"spouse_name" => $data['spouse_name'],
			"attending_family_name" => $data['attending_family_name'],
			"members_name" => $data['members_name'],
			"venue_id" => $data['venue_id'],
			"yajman" => $data['yajman'],
			"images" => $data['images']
		);
		$this->db->insert("booking_temp", $array);
		$bid = $this->db->insert_id();
		$response = array("status" => true, "id" => $bid);
		echo json_encode($response);
	}

	public function add_booking()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$get_booking_details = $this->db->get_where("booking_temp", array("id" => $data['id']))->row();
				if (count($get_booking_details) > 0) {
					if ($get_booking_details->booking_time == 'ANY TIME') {
						$bt = '';
						$convert_booking_date_time = date('Y-m-d H:i:s');
					} else {
						$bt = date('h:ia', strtotime($get_booking_details->booking_time));
						$convert_booking_date_time = date('Y-m-d H:i:s', strtotime($get_booking_details->booking_date . ' ' . $get_booking_details->booking_time));
					}

					$array = array(
						"booking_type" => 1,
						"user_id" => $get_booking_details->user_id,
						"online_mode" => 'video',
						"puja_id" => $get_booking_details->puja_id,
						"booking_for" => 'self', //$data['booking_for'],
						"booking_time" => $get_booking_details->booking_time,
						"booking_date" => $get_booking_details->booking_date,
						"total_minutes" => $get_booking_details->total_minutes,
						"timeinnumber" => '',
						"booking_date_time" => $convert_booking_date_time,
						"name" => $get_booking_details->name,
						"gender" => $get_booking_details->gender,
						"dob" => $get_booking_details->dob,
						"tob" => $get_booking_details->tob,
						"pob" => $get_booking_details->pob,
						"pob_lat" => $get_booking_details->pob_lat,
						"pob_long" => $get_booking_details->pob_long,
						"pob_lat_long_address" => $get_booking_details->pob_lat_long_address,
						"country" => $get_booking_details->country,
						"remark" => $get_booking_details->remark,
						"coupan_code" => $get_booking_details->coupan_code,
						"coupan_code_id" => $get_booking_details->coupan_code_id,
						"from_payment_gateway" => 0,
						"total_amount" => $get_booking_details->total_amount,
						"wallet_amount" => $get_booking_details->wallet_amount,
						"referral_amount" => $get_booking_details->referral_amount,
						"discount_amount" => $get_booking_details->discount_amount,
						"tax_amount" => $get_booking_details->tax_amount,
						"trxn_status" => 'success',
						"trxn_mode" => 'normal',
						"added_on" => date('Y-m-d H:i:s'),
						"trxn_id" => time(),
						"currency" => 'INR',
						"payment_status" => 'authorized',
						"description" => '',
						"created_at" => '',
						"method" => 'normal',
						"fee" => '',
						"tax" => '',
						"payment_method_email" => '',
						"payment_method_contact" => '',
						"payment_gateway" => '',
						"booking_location" => $get_booking_details->booking_location,
						"images" => $get_booking_details->images
					);
					$this->db->insert("booking", $array);
					$bid = $this->db->insert_id();
					$bridge_id = $this->encrypt_decrypt('encrypt', 'booking' . $bid);
					$this->db->query("UPDATE `booking` SET `bridge_id` = '$bridge_id' WHERE id='$bid'");

					$booking_other_details = array(
						"booking_id" => $bid,
						"current_address" => $get_booking_details->current_address,
						"mother_name" => $get_booking_details->mother_name,
						"father_name" => $get_booking_details->father_name,
						"family_gotra" => $get_booking_details->family_gotra,
						"spouse_name" => $get_booking_details->spouse_name,
						"attending_family_name" => $get_booking_details->attending_family_name,
						"members_name" => $get_booking_details->members_name,
						"venue_id" => $get_booking_details->venue_id,
						"yajman" => $get_booking_details->yajman,
					);
					$this->db->insert("booking_other_details", $booking_other_details);
					$get_booking_detail = $this->db->get_where("booking", array("id" => $bid))->row();
					$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $bid))->row();

					if ($get_booking_details->coupan_code_id != 0) {
						$this->coupan_used_increment($get_booking_details->coupan_code_id, 'puja', $bid, $get_booking_details->user_id);
					}

					if ($get_booking_details->images !== '' || $get_booking_details->images !== 0) {
						$delete_images = explode('|', $get_booking_details->images);
						for ($i = 0; $i < count($delete_images); $i++) {
							$check_image_exist = $this->db->get_where("puja_temporary_images", array("image" => $delete_images[$i]))->row();
							if (count($check_image_exist) > 0) {
								$this->db->where("id", $check_image_exist->id);
								$this->db->delete("puja_temporary_images");
							}
						}
					}


					$user_detail = $this->w_m->get_user($get_booking_details->user_id);
					if (count($user_detail) > 0) {
						$sum_total = $get_booking_details->total_amount;
						$get_puja_detail = $this->db->get_where("pooja", array("id" => $get_booking_details->puja_id))->row();
						// For send sms
						/*$sms_message = "Booking added successfully.[".$data['module']." (Online Counsult)] Bookingid:KUNDALIEXPERT-".$bid." Booking date ".$data['booking_date'].','.$data['booking_time']." with ".$get_expert_detail->name;
						$this->send_sms($user_detail->phone,$sms_message,$user_detail->country_code);*/
						$settings = $this->w_m->get_settings();

						$subject = "Booking added " . $get_puja_detail->name . " for " . $get_booking_details->booking_date . " at " . $bt;

						if ($settings->facebook_link) {
							$facebook = '<a href="' . $settings->twitter_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="facebook" src="https://ci4.googleusercontent.com/proxy/OdfuUga4ndDEHFyW6v2aCVjn7QxSHtfjvDowQ6BYpfqnE6xNDVO5PfjPyLZHEQjXBJw7xsIZ5oxLtDdSj19o8BRh7TZbWkULuWVVi9mX1UxkpPHbm-QR5cXDQakMC8vpnXMmCM4LNEPNzfyr-EHKQ_W60gPrmBNEXLNr4g=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Facebook.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$facebook = '';
						}

						if ($settings->twitter_link) {
							$twitter = '<a href="' . $settings->twitter_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="twitter" src="https://ci5.googleusercontent.com/proxy/tezSUjJj4fldIi0UXQ7R1hMi5nCZ_XHUzoRGLksVPkD5rc5UOOtOIFjvM1lsU9OYyz8fqn5lnf0c1X3j69RvccB33B5IZKesVzTr8HIBNr55HrofBYcn5nBp4N4aqQAcrTG7DhRq76P0c6Si8EGwAbWIboQdr-ensOK1=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Twitter.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$twitter = '';
						}


						if ($settings->instagram_link) {
							$instagram = '<a href="' . $settings->instagram_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="instagram" src="https://ci6.googleusercontent.com/proxy/gzxYa0OnFnJh9yh0cTzXyAqCsr5lWZyWX6sbRuUIdIdmTa5gVAP98LmHEt42hW-thQI-cK1u5S7OcRcTDd37iY_exZrcCKMwRHrqqF6LByuN8jUoD7AbBmNV2UApKdwjhPzcwiQ0iUJBstPQCDA6R6ck7N4WAOUtOOpmwMw=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Instagram.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$instagram = '';
						}


						if ($settings->youtube_link) {

							$youtube_link = '<a href="' . $settings->youtube_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="youtube" src="' . base_url('uploads/email_temp/youtube.png') . '" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$youtube_link = '';
						}

						if ($settings->website_link) {
							$kundali_exp = '<a href="' . $settings->website_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:0;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="shaktipeeth" src="' . base_url('uploads/email_temp/smalllogo.png') . '" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$kundali_exp = '';
						}


						$booking_mode_image = base_url('uploads/email_temp/complete.png');

						$mail_message = '<table style="margin:0;background:#f3f3f3;background-color:#e96125;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;padding:0;padding-left:8px;padding-right:8px;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td align="center" valign="top" style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <center style="min-width:580px;width:100%"> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#e96125;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:36px;margin-top:36px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <center style="min-width:580px;width:100%"><img alt="Shaktipeeth Logo" src="' . base_url('uploads/email_temp/logo.png') . '" style="Margin:0 auto;clear:both;display:block;float:none;height:38px;margin:0 auto;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto" class="CToWUd"> </center> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <h6 style="margin:0;margin-bottom:0;color:inherit;font-family:sans-serif;font-size:18px;font-weight:400;line-height:1.3;padding:0;text-align:left;word-wrap:normal">Hi ' . $get_booking_details->name . ' </h6> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:normal;margin-top:12px;padding:0;text-align:left">Thank you for booking with Shaktipeeth. Your booking details are given below.</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;background-color:#fcfcfc;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:20px;padding-left:32px;padding-right:32px;padding-top:20px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:center"><img src="' . base_url('uploads/email_temp/logo.png') . '" style="clear:both;display:inline-block;height:21px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:auto" alt="tick-icon.png" class="CToWUd"><span style="color:#333;font-size:16px;font-weight:500;margin-left:5px;vertical-align:middle">Online Booking Successfully Placed</span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><img src="https://ci5.googleusercontent.com/proxy/ztG3VpqbKb4vrW_qkmJX_O2E0i-sxq7g7BvEgUsrjpYtCdA7EPVTW7A3hlcLBb-5tfcjjuoD3yQk8KxOPCiQSDbCT1mXKbbAngpbuuFxteDI5sdNhTKEIqtTXgFSUZ2behksjojqRe7duGE=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/Clock.png" style="clear:both;display:inline-block;height:15px;margin-right:4px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:auto" alt="Clock.png" class="CToWUd"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Booking Time</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">' . date('d M Y', strtotime($get_booking_details->booking_date)) . ' | ' . $bt . ' | 15' . ' minutes </span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><img src="' . $booking_mode_image . '" style="clear:both;display:inline-block;height:15px;margin-right:4px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:auto" alt="Clock.png" class="CToWUd"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Booking Mode</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">Video</span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><img src="' . base_url("uploads/puja/") . $get_puja_detail->image . '" style="clear:both;display:inline-block;height:13px;margin-right:4px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:auto" alt="location.png" class="CToWUd"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Puja Details</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">' . $get_puja_detail->name . '</span><span style="color:#535353;display:inline-block;font-size:14px;font-weight:500;vertical-align:top"> <br><span>' . $get_puja_detail->description . '</span> <br></span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <div style="border-top:1px solid #eee;margin-bottom:16px;margin-top:16px"></div><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.3;padding:0;text-align:left">Total Amount</th> <td style="margin:0;border-collapse:collapse!important;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.3;padding:0;text-align:right;vertical-align:top;word-wrap:break-word">₹' . $sum_total . ' </td></tr></tbody> </table> <div style="border-top:1px dashed #dbdbdb;margin-bottom:16px;margin-top:16px"></div></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:564px"></th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"></td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.4;margin-top:5px;padding:0;text-align:left">Have a question?</p><p style="margin:0;margin-bottom:0;color:#535353;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:8px;padding:0;text-align:left">Feel free to shoot an email at <span style="color:#e14a1d"><a href="mailto:' . $settings->support_email . '" rel="noreferrer" target="_blank">' . $settings->support_email . '</a></span> or reach out to us via in-app support for any query or suggestion.</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;background-color:#fcfcfc;border-bottom-left-radius:6px;border-bottom-right-radius:6px;border-top:1px solid #eee;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:left">Regards,</p><p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:5px;padding:0;text-align:left">Team ' . $settings->title . '</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.4;margin-top:5px;padding:0;text-align:left"></p><p style="margin:0;margin-bottom:0;color:#535353;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:8px;padding:0;text-align:left"> <p style="text-align: center;">We work for your profit</p><p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#e96125;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:48px;margin-top:48px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:center">' . $facebook . $twitter . $instagram . $youtube_link . $kundali_exp . '</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> </center> </td></tr></tbody></table>';

						$this->w_m->check_curl($user_detail->email, $subject, $mail_message, $settings->support_email, 'Booking added successfully!');
						$title_message = "Booking Added Successfully";
						$notification_message = "Booking added successfully.Boooking ID:SHAKTIPEETH-" . $bid . " Booking date " . $get_booking_details->booking_date . ',' . $bt . " for " . $get_puja_detail->name;
						if ($user_detail->device_type == 'android') {
							if ($user_detail->device_token != 'abc') {
								$notification_type1 = "text";
								$message2 = array(
									'body' => $notification_message,
									'title' => $title_message,
									'sound' => 'Default'
								);

								//$this->w_m->sendMessageThroughFCM(array($user_detail->device_token),$message2);

							}
						}/*
						elseif ($user_detail->device_type == 'ios') 
						{
							$this->send_ios_notification($user_detail->device_token,$notification_message,'booking_history');
						}*/

						$noti_array = array("type" => "online", "user_id" => $get_booking_details->user_id, "title" => $title_message, "notification" => $notification_message, "added_on" => date('Y-m-d H:i:s'), "booking_id" => $bid);
						$this->db->insert('user_notification', $noti_array);
					}

					// $this->db->where("id",$data['id']);
					// $this->db->delete("booking_temp");
					$response = array("status" => true, "id" => $bid);
				} else {
					$response = array("status" => false, "id" => "not found any id");
				}
				echo json_encode($response);
			}
		}
	}

	public function add_permanent_booking()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->form_validation->set_data($data);
				if ($this->form_validation->run('on_appointment') !== false) {
					$for = $data['for'];
					$module = $data['module'];
					if ($for == 1) {
						$this->add_in_puja($data);
					} elseif ($for == 2) {
						$this->add_in_puja_from_cart($data);
					} elseif ($for == 3) {
						$this->add_in_lifeprediction($data);
					} else {
						$result =  array('status' => false, 'message' => "not found for any module contact with team");
						echo json_encode($result);
					}
				} else {
					$result =  array('status' => false, 'message' => "some values coming blank kindly recheck");
					echo json_encode($result);
				}
			}
		}
	}

	public function check_any_refer_done($user_id)
	{
		$signal = 0;
		$check_puja_booking_any = $this->db->get_where("booking", array("user_id" => $user_id))->result();
		if (count($check_puja_booking_any) > 0) {
			$signal = 1;
		}
		return $signal;
	}
	// Permanent booking
	public function add_in_puja_permanent($data)
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$get_user = $this->w_m->get_user($data['user_id']);
				if ($data['booking_time'] == 'ANY TIME') {
					$bt = 'ANY TIME';
					$convert_booking_date_time = date('Y-m-d H:i:s');
				} else {
					$bt = date('h:ia', strtotime($data['booking_time']));
					$convert_booking_date_time = date('Y-m-d H:i:s', strtotime($data['booking_date'] . ' ' . $data['booking_time']));
				}



				$array = array(
					"booking_type" => 1,
					"user_id" => $data['user_id'],
					"online_mode" => 'video',
					"puja_id" => $data['puja_id'],
					"booking_for" => $data['booking_for'],
					"member_id" => $data['member_id'],
					"puja_mode" => $data['puja_mode'],
					"booking_time" => $data['booking_time'],
					"booking_date" => $data['booking_date'],
					"total_minutes" => $data['total_minutes'],
					"timeinnumber" => '',
					"booking_date_time" => $convert_booking_date_time,
					"name" => $data['host_name'],
					// "pob_lat"=>$data['lat'],
					// "pob_long"=>$data['long'],
					// "pob_lat_long_address"=>$data['lat_long_address'],
					"coupan_code" => $data['coupan_code'],
					"coupan_code_id" => $data['coupan_code_id'],
					"from_payment_gateway" => 0,
					"total_amount" => $data['total_amount'],
					"wallet_amount" => $data['wallet_amount'],
					"referral_amount" => $data['referral_amount'],
					"discount_amount" => $data['discount_amount'],
					"tax_amount" => $data['tax_amount'],
					"trxn_status" => 'success',
					"trxn_mode" => 'normal',
					"added_on" => date('Y-m-d H:i:s'),
					"trxn_id" => time(),
					"currency" => 'INR',
					"payment_status" => 'authorized',
					"description" => '',
					"created_at" => '',
					"method" => 'normal',
					"fee" => '',
					"tax" => '',
					"payment_method_email" => '',
					"payment_method_contact" => '',
					"payment_gateway" => '',
					"booking_location" => $data['booking_location'],
				);
				$this->db->insert("booking", $array);
				$bid = $this->db->insert_id();
				if ($bid > 0) {
					$bridge_id = $this->encrypt_decrypt('encrypt', 'booking' . $bid);
					$this->db->query("UPDATE `booking` SET `bridge_id` = '$bridge_id' WHERE id='$bid'");
					$tax_id = 0;
					$tax_percent = '';
					if (isset($data['tax_id'])) {
						$tax_id = $data['tax_id'];
					}

					if (isset($data['tax_percent'])) {
						$tax_percent = $data['tax_percent'];
					}

					$booking_other_details = array(
						"booking_id" => $bid,
						"host_name" => $data['host_name'],
						"gender" => $data['gender'],
						"dob" => $data['dob'],
						"tob" => $data['tob'],
						"pob" => $data['place'],
						"country" => $data['country'],
						"remark" => $data['remark'],
						"current_address" => $data['current_address'],
						"mother_name" => $data['mother_name'],
						"father_name" => $data['father_name'],
						"family_gotra" => $data['family_gotra'],
						"spouse_name" => $data['spouse_name'],
						"attending_family_name" => $data['attending_family_name'],
						"members_name" => $data['members_name'],
						"venue_id" => $data['venue_id'],
						"tax_id" => $tax_id,
						"tax_percent" => $tax_percent
					);
					$this->db->insert("booking_other_details", $booking_other_details);
					$get_booking_detail = $this->db->get_where("booking", array("id" => $bid))->row();
					$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $bid))->row();

					if ($data['coupan_code_id'] != 0) {
						$this->coupan_used_increment($data['coupan_code_id'], 'puja', $bid, $data['user_id']);
					}

					if ($get_booking_detail->images !== '' || $get_booking_detail->images !== 0) {
						$delete_images = explode('|', $get_booking_detail->images);
						for ($i = 0; $i < count($delete_images); $i++) {
							$check_image_exist = $this->db->get_where("puja_temporary_images", array("image" => $delete_images[$i]))->row();
							if (count($check_image_exist) > 0) {
								$this->db->where("id", $check_image_exist->id);
								$this->db->delete("puja_temporary_images");
							}
						}
					}

					// Deduction from user wallet
					if ($data['wallet_amount'] > 0) {
						$get_user_detail = $this->w_m->get_user($data['user_id']);
						if (count($get_user_detail) > 0) {
							$user_wallet = $get_user_detail->wallet;
							if ($user_wallet >= $data['wallet_amount']) {
								$update_wallet = $user_wallet - $data['wallet_amount'];
								$array = array(
									"user_id" => $get_user_detail->id,
									"payment_from" => "wallet",
									"booking_id" => $bid,
									"update_wallet" => $update_wallet,
									"previous_wallet" => $user_wallet,
									"trxn_status" => 'success',
									"added_on" => date('Y-m-d H:i:s'),
									"trxn_id" => $get_booking_detail->trxn_id,
									"currency" => 'INR',
									"payment_status" => 'authorized',
									"description" => 'Booking for online from wallet',
									"created_at" => '',
									"method" => '',
									"fee" => '',
									"tax" => '',
									"payment_method_email" => '',
									"payment_method_contact" => '',
									"added_on" => date("Y-m-d H:i:s"),
									"deduct_amount" => $data['wallet_amount'],
									"payment_for" => "booking_puja"
								);
								$this->db->insert("user_wallet_referral_history", $array);
								$this->db->query("UPDATE `user` SET `wallet`='$update_wallet' WHERE `id`='$get_user_detail->id'");
							}
						}
					}

					$check_any_refer_done = $this->check_any_refer_done($data['user_id']);
					if ($check_any_refer_done == 0) {
						$get_refer_details = $this->db->query("SELECT * FROM `referral_code_history` WHERE `appy_by` = '" . $data['user_id'] . "' AND `is_used` = '0' LIMIT 1");
						if (count($get_refer_details) > 0) {
							$user_one_detail = $this->db->get_where("user", array("id" => $get_refer_details->appy_by, "status" => 1))->row();
							$user_two_detail = $this->db->get_where("user", array("id" => $get_refer_details->apply_to, "status" => 1))->row();
							if (count($user_one_detail) > 0 && count($user_two_detail) > 0) {
								$settings_refer = $this->get_settings();
								if ($settings->refferal_wallet > 0) {
									$user_wallet_one = $user_one_detail->wallet;
									$update_wallet_one = $user_wallet_one + $settings->refferal_wallet;
									$trxnrefferal = time();
									$array_one = array(
										"user_id" => $user_one_detail->id,
										"payment_from" => "wallet",
										"do_sum_minus" => "add",
										"booking_id" => $bid,
										"update_wallet" => $update_wallet_one,
										"previous_wallet" => $user_wallet_one,
										"trxn_status" => 'success',
										"added_on" => date('Y-m-d H:i:s'),
										"trxn_id" => $trxnrefferal,
										"currency" => 'INR',
										"payment_status" => 'authorized',
										"description" => 'Referral Added to wallet',
										"created_at" => '',
										"method" => '',
										"fee" => '',
										"tax" => '',
										"payment_method_email" => '',
										"payment_method_contact" => '',
										"added_on" => date("Y-m-d H:i:s"),
										"amount" => $settings->refferal_wallet,
										"payment_for" => "booking_puja"
									);
									$this->db->insert("user_wallet_referral_history", $array_one);
									$this->db->query("UPDATE `user` SET `wallet`='$update_wallet_one' WHERE `id`='$user_one_detail->id'");
									$subject_user_one = '[' . $settings->title . ']Refer code verified successfully and refer value added!';
									$mail_message_user_one = '<h1 style="color: green;">Congratulations !!</h1>Hi @' . $user_one_detail->name . ',<br><br>Welcome to ' . $settings->title . '.<br>Your refer code is verified successfully and refer value is added to your wallet.<br><br><br>Sincerely,<br>Support Team <br>' . $settings->company_name . '.<br> Website: ' . $settings->website_link . '<br><br><p style="text-align: center;">We work for your profit</p><p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p>';
									$this->w_m->check_curl($user_one_detail->email, $subject_user_one, $mail_message_user_one, $user_one_detail->name);

									$user_wallet_two = $user_two_detail->wallet;
									$update_wallet_two = $user_wallet_two + $settings->refferal_wallet;
									$array_two = array(
										"user_id" => $user_two_detail->id,
										"payment_from" => "wallet",
										"do_sum_minus" => "add",
										"booking_id" => $bid,
										"update_wallet" => $update_wallet_two,
										"previous_wallet" => $user_wallet_two,
										"trxn_status" => 'success',
										"added_on" => date('Y-m-d H:i:s'),
										"trxn_id" => $trxnrefferal,
										"currency" => 'INR',
										"payment_status" => 'authorized',
										"description" => 'Referral Added to wallet',
										"created_at" => '',
										"method" => '',
										"fee" => '',
										"tax" => '',
										"payment_method_email" => '',
										"payment_method_contact" => '',
										"added_on" => date("Y-m-d H:i:s"),
										"amount" => $settings->refferal_wallet,
										"payment_for" => "booking_puja"
									);
									$this->db->insert("user_wallet_referral_history", $array_two);
									$this->db->query("UPDATE `user` SET `wallet`='$update_wallet_one' WHERE `id`='$user_one_detail->id'");
									$subject_user_two = '[' . $settings->title . ']Refer code verified successfully and refer value added!';
									$mail_message_user_two = '<h1 style="color: green;">Congratulations !!</h1>Hi @' . $user_two_detail->name . ',<br><br>Welcome to ' . $settings->title . '.<br>Your refer code is verified successfully and refer value is added to your wallet.<br><br><br>Sincerely,<br>Support Team <br>' . $settings->company_name . '.<br> Website: ' . $settings->website_link . '<br><br><p style="text-align: center;">We work for your profit</p><p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p>';
									$this->w_m->check_curl($user_two_detail->email, $subject_user_two, $mail_message_user_two, $user_two_detail->name);
								}
							}
						}
					}


					// Booking confirm mail 
					$user_detail = $this->w_m->get_user($data['user_id']);
					if (count($user_detail) > 0) {
						$sum_total = $data['total_amount'];
						$get_puja_detail = $this->db->query("SELECT a.`id`,b.`name`,b.`image`,a.`description` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '" . $data['booking_locationi'] . "'")->row(); //$this->db->get_where("puja",array("id"=>$data['puja_id']))->row();
						$total_minutes = $get_booking_detail->total_minutes;
						// For send sms
						/*$sms_message = "Booking added successfully.[".$data['module']." (Online Counsult)] Bookingid:KUNDALIEXPERT-".$bid." Booking date ".$data['booking_date'].','.$data['booking_time']." with ".$get_expert_detail->name;
						$this->send_sms($user_detail->phone,$sms_message,$user_detail->country_code);*/
						$settings = $this->w_m->get_settings();

						$subject = "Booking added " . $get_puja_detail->name . " for " . $data['booking_date'] . " at " . $bt;

						if ($settings->facebook_link) {
							$facebook = '<a href="' . $settings->twitter_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="facebook" src="https://ci4.googleusercontent.com/proxy/OdfuUga4ndDEHFyW6v2aCVjn7QxSHtfjvDowQ6BYpfqnE6xNDVO5PfjPyLZHEQjXBJw7xsIZ5oxLtDdSj19o8BRh7TZbWkULuWVVi9mX1UxkpPHbm-QR5cXDQakMC8vpnXMmCM4LNEPNzfyr-EHKQ_W60gPrmBNEXLNr4g=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Facebook.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$facebook = '';
						}

						if ($settings->twitter_link) {
							$twitter = '<a href="' . $settings->twitter_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="twitter" src="https://ci5.googleusercontent.com/proxy/tezSUjJj4fldIi0UXQ7R1hMi5nCZ_XHUzoRGLksVPkD5rc5UOOtOIFjvM1lsU9OYyz8fqn5lnf0c1X3j69RvccB33B5IZKesVzTr8HIBNr55HrofBYcn5nBp4N4aqQAcrTG7DhRq76P0c6Si8EGwAbWIboQdr-ensOK1=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Twitter.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$twitter = '';
						}


						if ($settings->instagram_link) {
							$instagram = '<a href="' . $settings->instagram_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="instagram" src="https://ci6.googleusercontent.com/proxy/gzxYa0OnFnJh9yh0cTzXyAqCsr5lWZyWX6sbRuUIdIdmTa5gVAP98LmHEt42hW-thQI-cK1u5S7OcRcTDd37iY_exZrcCKMwRHrqqF6LByuN8jUoD7AbBmNV2UApKdwjhPzcwiQ0iUJBstPQCDA6R6ck7N4WAOUtOOpmwMw=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/icons_colored/Instagram.png" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$instagram = '';
						}


						if ($settings->youtube_link) {

							$youtube_link = '<a href="' . $settings->youtube_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:24px;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="youtube" src="' . base_url('uploads/email_temp/youtube.png') . '" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$youtube_link = '';
						}

						if ($settings->website_link) {
							$prowebsite_exp = '<a href="' . $settings->website_link . '" style="margin:0;background-color:#fff;border-radius:6px;color:#2199e8;display:inline-block;font-family:sans-serif;font-weight:400;height:50px;line-height:1.3;margin-right:0;padding:0;text-align:left;text-decoration:none;vertical-align:middle;width:50px" rel="noreferrer" target="_blank" data-saferedirecturl=""><img alt="shaktipeeth" src="' . base_url('uploads/email_temp/smalllogo.png') . '" style="border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto" class="CToWUd"></a>';
						} else {
							$prowebsite_exp = '';
						}


						$booking_mode_image = base_url('uploads/email_temp/complete.png');

						$mail_message = '<table style="margin:0;background:#f3f3f3;background-color:#e96125;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;padding:0;padding-left:8px;padding-right:8px;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td align="center" valign="top" style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <center style="min-width:580px;width:100%"> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#e96125;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:36px;margin-top:36px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <center style="min-width:580px;width:100%"><img alt="Shaktipeeth Logo" src="' . base_url('uploads/email_temp/logo.png') . '" style="Margin:0 auto;clear:both;display:block;float:none;height:38px;margin:0 auto;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto" class="CToWUd"> </center> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <h6 style="margin:0;margin-bottom:0;color:inherit;font-family:sans-serif;font-size:18px;font-weight:400;line-height:1.3;padding:0;text-align:left;word-wrap:normal">Hi ' . $data['name'] . ' </h6> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:normal;margin-top:12px;padding:0;text-align:left">Thank you for booking with Shaktipeeth. Your booking details are given below.</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;background-color:#fcfcfc;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:20px;padding-left:32px;padding-right:32px;padding-top:20px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:center"><img src="' . base_url('uploads/email_temp/logo.png') . '" style="clear:both;display:inline-block;height:21px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:auto" alt="tick-icon.png" class="CToWUd"><span style="color:#333;font-size:16px;font-weight:500;margin-left:5px;vertical-align:middle">Online Booking Successfully Placed</span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><img src="https://ci5.googleusercontent.com/proxy/ztG3VpqbKb4vrW_qkmJX_O2E0i-sxq7g7BvEgUsrjpYtCdA7EPVTW7A3hlcLBb-5tfcjjuoD3yQk8KxOPCiQSDbCT1mXKbbAngpbuuFxteDI5sdNhTKEIqtTXgFSUZ2behksjojqRe7duGE=s0-d-e1-ft#https://s3-us-west-2.amazonaws.com/grofers-stage-consumer-webcdn/emails/images/Clock.png" style="clear:both;display:inline-block;height:15px;margin-right:4px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:auto" alt="Clock.png" class="CToWUd"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Booking Time</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">' . date('d M Y', strtotime($data['booking_date'])) . ' | ' . $bt . ' </span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;border-bottom:1px solid #eee;border-top-left-radius:6px;border-top-right-radius:6px;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><img src="' . $booking_mode_image . '" style="clear:both;display:inline-block;height:15px;margin-right:4px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:auto" alt="Clock.png" class="CToWUd"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Booking Mode</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">Video</span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:0;padding:0;text-align:left"><span style="color:#666;display:inline-block;font-size:14px;font-weight:500;text-transform:uppercase;vertical-align:middle;width:144px">Puja Details</span> <span style="margin-left:24px;margin-right:12px">:</span> <span style="color:#333;display:inline-block;font-size:14px;font-weight:600;vertical-align:middle">' . $get_puja_detail->name . '</span><span style="color:#535353;display:inline-block;font-size:14px;font-weight:500;vertical-align:top"> <br><span>' . $get_puja_detail->description . '</span> <br></span> </p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <div style="border-top:1px solid #eee;margin-bottom:16px;margin-top:16px"></div><table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.3;padding:0;text-align:left">Total Amount</th> <td style="margin:0;border-collapse:collapse!important;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.3;padding:0;text-align:right;vertical-align:top;word-wrap:break-word">₹' . $sum_total . ' </td></tr></tbody> </table> <div style="border-top:1px dashed #dbdbdb;margin-bottom:16px;margin-top:16px"></div></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:564px"></th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"></td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.4;margin-top:5px;padding:0;text-align:left">Have a question?</p><p style="margin:0;margin-bottom:0;color:#535353;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:8px;padding:0;text-align:left">Feel free to shoot an email at <span style="color:#e14a1d"><a href="mailto:' . $settings->support_email . '" rel="noreferrer" target="_blank">' . $settings->support_email . '</a></span> or reach out to us via in-app support for any query or suggestion.</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;background-color:#fcfcfc;border-bottom-left-radius:6px;border-bottom-right-radius:6px;border-top:1px solid #eee;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:24px;padding-left:32px;padding-right:32px;padding-top:24px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:left">Regards,</p><p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:5px;padding:0;text-align:left">Team ' . $settings->title . '</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#fff;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:4px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:32px;padding-left:32px;padding-right:32px;padding-top:32px;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#333;font-family:sans-serif;font-size:14px;font-weight:600;line-height:1.4;margin-top:5px;padding:0;text-align:left"></p><p style="margin:0;margin-bottom:0;color:#535353;font-family:sans-serif;font-size:14px;font-weight:500;line-height:1.4;margin-top:8px;padding:0;text-align:left"> <p style="text-align: center;">We work for your profit</p><p style="text-align: center;">"Destiny is not about stars alone, the benefit of guidance helps you take the right path to success."</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> <table align="center" style="margin:0 auto;background:#fefefe;background-color:#e96125;border-collapse:collapse;border-radius:6px;border-spacing:0;float:none;margin-bottom:48px;margin-top:48px;max-width:600px;padding:0;text-align:center;vertical-align:top;width:100%!important"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="margin:0;border-collapse:collapse!important;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.3;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0 auto;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:564px"> <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0;text-align:left"> <p style="margin:0;margin-bottom:0;color:#666;font-family:sans-serif;font-size:13px;font-weight:400;line-height:1.4;margin-top:5px;padding:0;text-align:center">' . $facebook . $twitter . $instagram . $youtube_link . $prowebsite_exp . '</p></th> <th style="margin:0;color:#0a0a0a;font-family:sans-serif;font-size:16px;font-weight:400;line-height:1.3;padding:0!important;text-align:left;width:0"></th> </tr></tbody> </table> </th> </tr></tbody> </table> </td></tr></tbody> </table> </center> </td></tr></tbody></table>';

						$this->w_m->check_curl($user_detail->email, $subject, $mail_message, $settings->support_email, 'Booking added successfully!');
						$title_message = "Booking Added Successfully";
						$notification_message = "Booking added successfully.Boooking ID:SHAKTIPEETH-" . $bid . " Booking date " . $data['booking_date'] . ',' . $bt . " for " . $get_puja_detail->name;
						if ($user_detail->device_type == 'android') {
							if ($user_detail->device_token != 'abc') {
								$notification_type1 = "text";
								$message2 = array(
									'body' => $notification_message,
									'title' => $title_message,
									'sound' => 'Default'
								);

								$this->w_m->sendMessageThroughFCM(array($user_detail->device_token), $message2, $settings->firebase_key);
							}
						}/*
						elseif ($user_detail->device_type == 'ios') 
						{
							$this->send_ios_notification($user_detail->device_token,$notification_message,'booking_history');
						}*/

						$noti_array = array("type" => "online", "user_id" => $data['user_id'], "title" => $title_message, "notification" => $notification_message, "added_on" => date('Y-m-d H:i:s'), "booking_id" => $bid);
						$this->db->insert('user_notification', $noti_array);
					}

					$this->common_notification($bid, 'new_booking_to_all_supervisor');
					$response = array("status" => true, "id" => $bid);
				}

				echo json_encode($response);
			}
		}
	}

	public function add_in_puja_from_cart($data)
	{
		$cart_ids = $data['cart_ids'];
		$derive = explode('|', $cart_ids);
		if (count($derive) > 0) {
			$get_user = $this->w_m->get_user($data['user_id']);
			$discount_amount = $data['discount_amount'];
			$total_amount = $data['total_amount'];
			$tax_amount = $data['tax_amount'];
			$tax_percent = $data['tax_percent'];
			if ($data['coupan_code_id'] != 0) {
				$cid = $this->coupan_used_increment($data['coupan_code_id'], 'puja', 0, $data['user_id']);
				$discount_amount = $data['discount_amount'] / count($derive);
			}
			$bids = '';
			for ($i = 0; $i < count($derive); $i++) {
				$get_cart_detail = $this->db->get_where("puja_temp_cart", array("id" => $derive[$i]))->row();
				if (count($get_cart_detail) > 0) {
					if ($get_cart_detail->booking_time == 'ANY TIME') {
						$bt = '';
						$convert_booking_date_time = date('Y-m-d H:i:s');
					} else {
						$bt = date('h:ia', strtotime($get_cart_detail->booking_time));
						$convert_booking_date_time = date('Y-m-d H:i:s', strtotime($get_cart_detail->booking_date . ' ' . $get_cart_detail->booking_time));
					}

					$total_amount = $get_cart_detail->order_price;
					$GST_Amount = 0;
					if (count($tax_amount) > 0) {
						$GST_Amount = ($get_cart_detail->order_price * $tax_percent) / 100;
						$total_amount = $GST_Amount + $get_cart_detail->order_price;
					}

					$array = array(
						"booking_type" => 1,
						"user_id" => $data['user_id'],
						"online_mode" => 'video',
						"puja_id" => $get_cart_detail->puja_id,
						"booking_for" => 'self',
						"booking_time" => $get_cart_detail->booking_time,
						"booking_date" => $get_cart_detail->booking_date,
						"total_minutes" => $get_cart_detail->total_minutes,
						"timeinnumber" => '',
						"booking_date_time" => $convert_booking_date_time,
						"name" => $get_cart_detail->name,
						"gender" => $get_cart_detail->gender,
						"dob" => $get_cart_detail->dob,
						"tob" => $get_cart_detail->tob,
						"pob" => $get_cart_detail->pob,
						"pob_lat" => $get_cart_detail->pob_lat,
						"pob_long" => $get_cart_detail->pob_long,
						"pob_lat_long_address" => $get_cart_detail->pob_lat_long_address,
						"country" => $get_cart_detail->country,
						"remark" => $get_cart_detail->remark,
						"coupan_code" => $data['coupan_code'],
						"coupan_code_id" => $data['coupan_code_id'],
						"from_payment_gateway" => 0,
						"total_amount" => $total_amount,
						"wallet_amount" => 0,
						"referral_amount" => 0,
						"discount_amount" => $discount_amount,
						"tax_amount" => $GST_Amount,
						"images" => $get_cart_detail->documents,
						"trxn_status" => 'success',
						"trxn_mode" => 'normal',
						"added_on" => date('Y-m-d H:i:s'),
						"trxn_id" => time(),
						"currency" => 'INR',
						"payment_status" => 'authorized',
						"description" => '',
						"created_at" => '',
						"method" => 'normal',
						"fee" => '',
						"tax" => '',
						"payment_method_email" => '',
						"payment_method_contact" => '',
						"payment_gateway" => '',
						"booking_location" => $get_cart_detail->booking_location,
					);
					$this->db->insert("booking", $array);
					$bid = $this->db->insert_id();
					$bridge_id = $this->encrypt_decrypt('encrypt', 'booking' . $bid);
					$this->db->query("UPDATE `booking` SET `bridge_id` = '$bridge_id' WHERE id='$bid'");
					$booking_other_details = array(
						"booking_id" => $bid,
						"current_address" => $get_cart_detail->current_address,
						"mother_name" => $get_cart_detail->mother_name,
						"father_name" => $get_cart_detail->father_name,
						"family_gotra" => $get_cart_detail->family_gotra,
						"spouse_name" => $get_cart_detail->spouse_name,
						"attending_family_name" => $get_cart_detail->attending_family_name,
						"members_name" => $get_cart_detail->members_name,
						"venue_id" => $get_cart_detail->venue_id,
						"yajman" => $get_cart_detail->yajman,
						"tax_percent" => $tax_percent
					);
					$this->db->insert("booking_other_details", $booking_other_details);
					$send_to_all_supervisor = $this->common_notification($bid, 'new_booking_to_all_supervisor');
					$bids .= '|' . $bid;
					$this->db->where("id", $derive[$i]);
					$this->db->delete("puja_temp_cart");
				}
			}
			if (isset($cid)) {
				$this->db->where("id", $cid);
				$this->db->update("coupan_history", array("booking_id" => $bids));
			}
			$response = array("status" => true);
		} else {
			$response = array("status" => false);
		}
		echo json_encode($response);
	}



	public function delete_images()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$temp_id = $data['temp_id'];
				$r = $this->db->get_where("puja_temporary_images", array("user_id" => $data['user_id'], "id" => $data['id']))->row();
				if (count($r) > 0) {
					// foreach ($r as $key) 
					// {
					if (file_exists(FCPATH . "uploads/puja_documents/" . $r->image)) {
						unlink(FCPATH . "uploads/puja_documents/" . $r->image);
					}
					// }
					$this->db->query("DELETE FROM `puja_temporary_images` WHERE `user_id` = '" . $data['user_id'] . "' AND `id` = '" . $data['id'] . "'");
				}
				$path = base_url('uploads/puja_documents') . '/';
				$r2 = $this->db->query("SELECT `id`,CONCAT( '$path', `image`) as image_full_url,image AS image_name FROM `puja_temporary_images` WHERE `user_id`='" . $data['user_id'] . "' AND `temp_id`='" . $temp_id . "' AND `puja_id`='" . $data['puja_id'] . "'")->result();
				$response = array("status" => true, "temp_id" => $temp_id, "msg" => "Delete successfully", "list_of_images" => $r2);
				echo json_encode($response);
			}
		}
	}

	public function list_upload_images()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$temp_id = $data['temp_id'];
				$path = base_url('uploads/puja_documents') . '/';
				$r2 = $this->db->query("SELECT `temp_id`,`id`,CONCAT( '$path', `image`) as image_full_url,image AS image_name FROM `puja_temporary_images` WHERE `user_id`='" . $data['user_id'] . "' AND `puja_id`='" . $data['puja_id'] . "'")->result();
				if (count($r2) > 0) {
					$response = array("status" => true, "temp_id" => $temp_id, "list" => $r2);
				} else {
					$response = array("status" => false, "message" => "not_found");
				}
				echo json_encode($response);
			}
		}
	}

	// Rajor Payment gateway
	public function rajor_pay_payment_gateway_url()
	{
		$data1 = json_decode(file_get_contents('php://input'), true);
		$data2 = json_encode($data1);
		$this->load->helper('file');
		$date = date('Y-m-d');
		$time = date('h-i-s');
		$file_name_ = $date . '_' . $time . '-' . time() . 'payment';
		$path = './razor_pay/' . $file_name_ . '.txt';

		if (!write_file($path, $data2)) {
		} else {
			$f = json_decode($data2, true);
			if ($f) {
				$status =  $f['payload']['payment']['entity']['status'];
				$payment_id =  $f['payload']['payment']['entity']['id'];
				$amount =  $f['payload']['payment']['entity']['amount'];
				$currency =  $f['payload']['payment']['entity']['currency'];
				$status =  $f['payload']['payment']['entity']['status'];
				$description =  $f['payload']['payment']['entity']['description'];
				$created_at =  $f['payload']['payment']['entity']['created_at'];
				$method =  $f['payload']['payment']['entity']['method'];
				$email =  $f['payload']['payment']['entity']['email'];
				$contact =  $f['payload']['payment']['entity']['contact'];
				$fee =  $f['payload']['payment']['entity']['fee'];
				$tax =  $f['payload']['payment']['entity']['tax'];
				$desc = explode('|', $description);
				$user_id = $desc[0];
				$payment_for = $desc[1];
				if ($status == 'authorized') {
					if ($payment_for == 'online') {
						$this->online_success_script($f);
					} elseif ($payment_for == 'gems') {
						$this->gems_product_success_script($f);
					} elseif ($payment_for == 'add_wallet') {
						$this->add_wallet_success_script($f);
					} elseif ($payment_for == 'matchmaking') {
						$this->matchmaking_success_script($f);
					} elseif ($payment_for == 'lifeprediction') {
						$this->lifeprediction_success_script($f);
					} elseif ($payment_for == 'inperson') {
						$this->inperson_success_script($f);
					} elseif ($payment_for == 'classpackage') {
						$this->classpackage_success_script($f);
					} elseif ($payment_for == 'pdfbooking') {
						$this->pdfbooking_success_script($f);
					} elseif ($payment_for == 'medical') {
						$this->medical_success_script($f);
					} elseif ($payment_for == 'financial') {
						$this->financial_success_script($f);
					}
				} elseif ($status == 'failed') {
					$fail_array = array(
						"user_id" => $user_id,
						"created_at" => $created_at,
						"payment_id" => $payment_id,
						"module" => $payment_for,
						"amount" => ($amount) / 100,
						"currency" => $currency,
						"status" => $status,
						"description" => $description,
						"method" => $method,
						"email" => $email,
						"contact" => $contact,
						"fee" => $fee,
						"tax" => $tax,
						"added_on" => date('Y-m-d H:i:s')
					);
					$this->db->insert('failure_transactions', $fail_array);
				}
			}
		}
	}

	public function rajor_pay_payment_gateway_url1()
	{
		// Patern = user_id|online|booking_id
		$value = '{"entity":"event","account_id":"628605015394","event":"payment.authorized","contains":["payment"],"payload":{"payment":{"entity":{"id":"018418141006","entity":"payment","amount":601800,"currency":"INR","status":"authorized","order_id":null,"invoice_id":null,"international":false,"method":"upi","amount_refunded":0,"refund_status":null,"captured":false,"description":"41|pdfbooking|32","card_id":null,"bank":null,"wallet":null,"vpa":"","email":"rishabh.adlakha1710@gmail.com","contact":"+919999838804","notes":[],"fee":null,"tax":null,"error_code":null,"error_description":null,"error_source":null,"error_step":null,"error_reason":null,"acquirer_data":{"rrn":"017319455253"},"created_at":1592762578}}},"created_at":1592762613}';
		$f = json_decode($value, true);
		if ($f) {
			$status =  $f['payload']['payment']['entity']['status'];
			$payment_id =  $f['payload']['payment']['entity']['id'];
			$amount =  $f['payload']['payment']['entity']['amount'];
			$currency =  $f['payload']['payment']['entity']['currency'];
			$status =  $f['payload']['payment']['entity']['status'];
			$description =  $f['payload']['payment']['entity']['description'];
			$created_at =  $f['payload']['payment']['entity']['created_at'];
			$method =  $f['payload']['payment']['entity']['method'];
			$email =  $f['payload']['payment']['entity']['email'];
			$contact =  $f['payload']['payment']['entity']['contact'];
			$fee =  $f['payload']['payment']['entity']['fee'];
			$tax =  $f['payload']['payment']['entity']['tax'];
			$desc = explode('|', $description);
			$user_id = $desc[0];
			$payment_for = $desc[1];
			if ($status == 'authorized') {
				if ($payment_for == 'online') {
					$this->online_success_script($f);
				} elseif ($payment_for == 'gems') {
					$this->gems_product_success_script($f);
				} elseif ($payment_for == 'add_wallet') {
					$this->add_wallet_success_script($f);
				} elseif ($payment_for == 'matchmaking') {
					$this->matchmaking_success_script($f);
				} elseif ($payment_for == 'lifeprediction') {
					$this->lifeprediction_success_script($f);
				} elseif ($payment_for == 'inperson') {
					$this->inperson_success_script($f);
				} elseif ($payment_for == 'classpackage') {
					$this->classpackage_success_script($f);
				} elseif ($payment_for == 'pdfbooking') {
					$this->pdfbooking_success_script($f);
				} elseif ($payment_for == 'medical') {
					$this->medical_success_script($f);
				} elseif ($payment_for == 'financial') {
					$this->financial_success_script($f);
				}
			} elseif ($status == 'failed') {
				$fail_array = array(
					"user_id" => $user_id,
					"created_at" => $created_at,
					"payment_id" => $payment_id,
					"module" => $payment_for,
					"amount" => ($amount) / 100,
					"currency" => $currency,
					"status" => $status,
					"description" => $description,
					"method" => $method,
					"email" => $email,
					"contact" => $contact,
					"fee" => $fee,
					"tax" => $tax,
					"added_on" => date('Y-m-d H:i:s')
				);
				$this->db->insert('failure_transactions', $fail_array);
			}
		}
		// }
	}

	public function check_curl()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://139.59.76.223/kundali_expert/api/curl_mail_fun?authkey=315747AeqFpJNgt5e326cbdP1",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		print_r($response);
		$err = curl_error($curl);
		curl_close($curl);
		print_r($err);
	}

	public function curl_mail_fun_old()
	{

		$email = $this->input->post("email");
		$subject = $this->input->post("subject");
		$message = $this->input->post("message");
		$name = $this->input->post("name");
		$bcc_email = $this->input->post("bcc_email");
		$bcc_line = $this->input->post("bcc_line");
		$fil_package_deatils = $this->input->post("fil_package_deatils");
		// $google_email = 'kundliexpert12@gmail.com';
		// $oauth2_clientId = '173312080437-dntubar209cf6r6jm2r3kihh1j9pd4jh.apps.googleusercontent.com';
		// $oauth2_clientSecret = '-ONN8LIE3o6LwMxEEvNhV-Pz';
		// $oauth2_refreshToken = '1//0gsDpbEvmqS0GCgYIARAAGBASNgF-L9IrOCDKzit4GLQqw0N37s29hi7hkHXQl8rYno1j4W3YDd5M6g8xBrdG74LyFOUq8wbNrA';
		$google_email = 'shaktipeet1@gmail.com';
		$oauth2_clientId = '206205456312-e3gr80kabo0ihuaumv806fkeia6e3j8f.apps.googleusercontent.com';
		$oauth2_clientSecret = 'YI9LK3qOapK8br0oMsixyIJg';
		$oauth2_refreshToken = '1//0gZhVfxddKjDKCgYIARAAGBASNwF-L9IrNaXbFfGQ_tSI-vWASi6jSQx0Zcb09hqg5CXY67EPQ3s8wwKBSIgqJdj5JzuXxRRa3Ww';

		$mail = new PHPMailer(TRUE);

		try {

			$mail->setFrom($google_email, 'Shaktipeeth Digital');
			$mail->addAddress($this->input->post("email"), $name);
			// if ($bcc_email) 
			// {
			// 	$mail->addBcc($bcc_email, $bcc_line);	
			// }
			$mail->WordWrap = 500;
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $message;
			if ($fil_package_deatils) {
				$path = '/var/www/html/shaktipeeth/' . $fil_package_deatils;
				$mail->addAttachment($path);
			}
			$mail->isSMTP();
			$mail->Port = 587;
			$mail->SMTPAuth = TRUE;
			$mail->SMTPSecure = 'tls';

			/* Google's SMTP */
			$mail->Host = 'smtp.gmail.com';

			/* Set AuthType to XOAUTH2. */
			$mail->AuthType = 'XOAUTH2';

			/* Create a new OAuth2 provider instance. */
			$provider = new Google(
				[
					'clientId' => $oauth2_clientId,
					'clientSecret' => $oauth2_clientSecret,
					'accessType' => 'offline'
				]
			);

			/* Pass the OAuth provider instance to PHPMailer. */
			$mail->setOAuth(
				new OAuth(
					[
						'provider' => $provider,
						'clientId' => $oauth2_clientId,
						'clientSecret' => $oauth2_clientSecret,
						'refreshToken' => $oauth2_refreshToken,
						'userName' => $google_email,
					]
				)
			);

			/* Finally send the mail. */
			$mail->send();
		} catch (Exception $e) {
			$e->errorMessage();
		} catch (\Exception $e) {
			$e->getMessage();
		}
		/*$this->load->library('My_PHPMailer');
		$settings = $this->w_m->get_settings();
		$body= $message;
        $mail = new PHPMailer;
		$mail->isSMTP();				  
		$mail->Host = $settings->smtp_host;//'smtp.gmail.com'; //'md-70.webhostbox.net';
		$mail->SMTPAuth = true;
		$mail->Username = $settings->smtp_username;//'form41app@gmail.com'; //'mail@appsgenic.com';
	    $mail->Password = $settings->smtp_password;//'appslure123'; // '@appsgenic123@';
		$mail->SMTPSecure = 'tls';
		$mail->Port =587;
		$mail->From = $settings->support_email;
		$mail->FromName = $settings->title;
		$mail->addAddress($email, $settings->title);
	    $mail->WordWrap = 500;
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->send();*/
	}

	public function curl_mail_fun()
	{
		$email = $this->input->post("email");
		$subject = $this->input->post("subject");
		$message = $this->input->post("message");
		$name = $this->input->post("name");
		// $bcc_email = $this->input->post("bcc_email");
		// $bcc_line = $this->input->post("bcc_line");
		$fil_package_deatils = $this->input->post("fil_package_deatils");
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
		if ($fil_package_deatils) {
			$path = '/var/www/html/shaktipeeth_website/admin/' . $fil_package_deatils;
			$mail->addAttachment($path);
		}
		if (!$mail->send()) {
			// echo 'Mailer Error: ' . $mail->ErrorInfo;
			return true;
		} else {
			// echo 1;
			return true;
		}
	}

	public function online_booking_history()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				// videos
				$limit_count = 6;
				$limit_from = $data['limit_from'];
				$user_id = $data['user_id'];
				$query = "SELECT * FROM `booking` WHERE `user_id` = '$user_id' AND `booking_type` IN ('1') ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
				$all_list = $this->db->query($query)->result();
				if (count($all_list) > 0) {
					$date = date('Y-m-d');
					$current_date_time = strtotime(date('Y-m-d H:i:s'));
					foreach ($all_list as $key) {
						switch ($key->booking_type) {
							case '1':
								$booking_type = 'Puja Booking';
								break;
							case '2':
								$booking_type = 'Puja Booking';
								break;
						}


						$apoint_date = $key->booking_date;
						if (strtotime($date) <= strtotime($apoint_date)) {
							$diff = strtotime($apoint_date) - strtotime($date);
							$remain_date = round($diff / (60 * 60 * 24));
						} else {
							$remain_date = 0;
						}


						if ($key->booking_time == 'ANY TIME') {
							if (strtotime($date) <= strtotime($apoint_date)) {
								$cancel_power = 1;
								$reshedule_power = 1;
							} else {
								$cancel_power = 0;
								$reshedule_power = 0;
							}
						} else {
							$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
							$time_remain = 60 * 60 * 1;
							$before_three_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
							// if ($total_appointment_time > $current_date_time) 
							// {
							$cancel_power = 1;
							$reshedule_power = 1;
							// }
							// else
							// {
							// 	$cancel_power = 0;
							// 	$reshedule_power = 0;
							// }
						}


						if ($key->status == 0) {
							$booking_status = 'pending';
							if ($key->booking_time == 'ANY TIME') {
								if (strtotime($date) <= strtotime($apoint_date)) {
									$cancel_power = 1;
									$reshedule_power = 1;
								} else {
									$cancel_power = 0;
									$reshedule_power = 0;
								}
							} else {
								// if ($current_date_time < $before_three_hours_date) 
								// {
								$cancel_power = 1;
								$reshedule_power = 1;
								// }
								// else
								// {
								// 	$cancel_power = 0;
								// 	$reshedule_power = 0;
								// }	
							}
						} elseif ($key->status == 2 || $key->status == 3) {
							$booking_status = 'cancelled';
							$cancel_power = 0;
							$reshedule_power = 0;
						} elseif ($key->status == 1) {
							$booking_status = 'complete';
							$cancel_power = 0;
							$reshedule_power = 0;
						} elseif ($key->status == 4) {
							$booking_status = 'Refund';
							$cancel_power = 0;
							$reshedule_power = 0;
						} else {
							$booking_status = '';
						}

						$base_url_expert = base_url('uploads/puja/');
						$puja_details = $this->db->query("SELECT b.`image`,a.`id`,b.`name`,'" . $base_url_expert . "' AS `base_url_expert` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row();

						$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();

						$venue_details = '';
						$tax_percent = '';
						if (count($get_booking_other_detail) > 0) {
							$current_address = $get_booking_other_detail->current_address;
							$mother_name = $get_booking_other_detail->mother_name;
							$father_name = $get_booking_other_detail->father_name;
							$family_gotra = $get_booking_other_detail->family_gotra;
							$spouse_name = $get_booking_other_detail->spouse_name;
							$attending_family_name = $get_booking_other_detail->attending_family_name;
							$members_name = $get_booking_other_detail->members_name;
							$yajman = $get_booking_other_detail->yajman;
							$tax_percent = $get_booking_other_detail->tax_percent;
							$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
							if (count($get_venue) > 0) {
								$venue_details = $get_venue->venue_name;
							}
						}

						$supervisor = '';
						if ($key->supervisor_id != 0) {
							$get_supervisordetail = $this->db->get_where("supervisor", array("id" => $key->supervisor_id))->row();
							if (count($get_supervisordetail) > 0) {
								$supervisor = $get_supervisordetail->name;
							}
						}

						/*Rating Module*/
						// $get_rating_check = $this->db->query("SELECT * FROM `rating_expert` WHERE `user_id` = '".$user_id."' AND `booking_for` IN ('1','2')")->row();
						// if (count($get_rating_check) > 0) 
						// {
						// 	if ($get_rating_check->is_shown_to_user == 1) 
						// 	{
						// 		$is_rate = 1;
						// 		$rating_flag = array("id"=>$get_rating_check->id,"review"=>$get_rating_check->review,"rating"=>$get_rating_check->rating,"added_on"=>date('d/m/Y h:ia', strtotime($get_rating_check->added_on)));
						// 	}
						// 	else
						// 	{
						// 		$is_rate = 2;
						// 		$rating_flag = array();
						// 	}
						// }
						// else
						// {
						// 	$is_rate = 0;
						// 	$rating_flag = array();
						// }
						$puja_amount = $key->total_amount - $key->tax_amount - $key->discount_amount;
						$lists[] = array(
							'module' => $key->online_mode,
							'puja_details' => $puja_details,
							'appointment_date' => $key->booking_date,
							'appointment_time' => $key->booking_time,
							'booking_id' => $key->id,
							'booking_status' => $booking_status,
							'remain_days' => $remain_date,
							'cancel_power' => $cancel_power,
							// 'reshedule_power'=>$reshedule_power,
							// 'booking_type'=>$booking_type,
							'appointment_id' => 'SHAKTIPEETH-' . $key->id,
							// 'booking_for'=>$key->booking_for,
							'status' => $key->status,
							'group_id' => $key->bridge_id,
							'trxn_id' => $key->trxn_id,
							'total_amount' => $key->total_amount,
							'puja_amount' => $puja_amount,
							'from_payment_gateway' => $key->from_payment_gateway,
							'discount_price' => $key->discount_amount,
							'tax_amount' => $key->tax_amount,
							'tax_percent' => $tax_percent,
							//'wallet_amount'=>$key->wallet_amount ,
							//'referral_amount'=> $key->referral_amount ,
							'discount_amount' => $key->discount_amount,
							"venue" => $venue_details,
							"Assigner" => $supervisor,
							"booking_location" => $key->booking_location

						);
					}
					$response = array("status" => true, "lists" => $lists, "limit_from" => $limit_from);
				} else {
					$lists = array();
					$response = array("status" => false, "lists" => $lists, "limit_from" => $limit_from);
				}

				echo json_encode($response);
			}
		}
	}

	public function sasasa()
	{
		date_default_timezone_set('Etc/UTC');
		$fil_package_deatils = '/var/www/html/kundali_expert' . '/uploads/class_package/1587185543.pdf';
		/* Information from the XOAUTH2 configuration. */
		$google_email = 'kmstech88@gmail.com';
		$oauth2_clientId = '594945680122-j0n9dut8lg8hatg3damodk0qm7efl0j2.apps.googleusercontent.com';
		$oauth2_clientSecret = 'c0kwB7-ozK_x6PGkTrdNRb4r';
		$oauth2_refreshToken = '1//0gBTlpZKoHQVICgYIARAAGBASNwF-L9Ir-FH--Rjlb69rGOfJS32-f7H9PkkgFhDN3zidy9LW994YVIzxiGR-VbAoxB9uG3qU-zE';

		$mail = new PHPMailer(TRUE);

		try {

			$mail->setFrom($google_email, 'Darth Vader');
			$mail->addAddress('sachinappslure@gmail.com', 'Emperor');
			$mail->Subject = 'Force';
			$mail->Body = 'There is a great disturbance in the Force.';
			$mail->isSMTP();
			$mail->Port = 587;
			$mail->SMTPAuth = TRUE;
			$mail->SMTPSecure = 'tls';
			// if ($fil_package_deatils) 
			// {
			// 	$mail->addAttachment($fil_package_deatils);
			// }
			/* Google's SMTP */
			$mail->Host = 'smtp.gmail.com';

			/* Set AuthType to XOAUTH2. */
			$mail->AuthType = 'XOAUTH2';

			/* Create a new OAuth2 provider instance. */
			$provider = new Google(
				[
					'clientId' => $oauth2_clientId,
					'clientSecret' => $oauth2_clientSecret,
				]
			);

			/* Pass the OAuth provider instance to PHPMailer. */
			$mail->setOAuth(
				new OAuth(
					[
						'provider' => $provider,
						'clientId' => $oauth2_clientId,
						'clientSecret' => $oauth2_clientSecret,
						'refreshToken' => $oauth2_refreshToken,
						'userName' => $google_email,
					]
				)
			);

			/* Finally send the mail. */
			$mail->send();
			echo 1;
		} catch (Exception $e) {
			echo $e->errorMessage();
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

	public function curl_send_mail($value = '')
	{
		$sub = 'New Enquiry from ';
		$body = 'Name: ';
		$name = '[New Enquiry]';
		$email = 'sachinappslure@gmail.com';
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
		$mail->setFrom('communication@shaktipeethdigital.com', 'communication');
		$mail->addAddress($email, $name);
		$mail->WordWrap = 500;
		$mail->isHTML(true);
		$mail->Subject = $sub;
		$mail->Body = $body;
		if (!$mail->send()) {
			echo 0;
		} else {
			echo 1;
		}
	}

	public function amodelsassa()
	{
		$this->w_m->check_curl();
	}

	public function send_sms($mobile, $sms_message, $country_code)
	{
		//echo "https://api.msg91.com/api/sendhttp.php?mobiles=".$mobile."&authkey=315747AeqFpJNgt5e326cbdP1&route=4&sender=KUNDEX&message=".$sms_message."&country=".$country_code;
		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		//   CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?mobiles=".$mobile."&authkey=315747AeqFpJNgt5e326cbdP1&route=4&sender=KUNDEX&message=".$sms_message."&country=".$country_code
		//   ,
		//   CURLOPT_RETURNTRANSFER => true,
		//   CURLOPT_ENCODING => "",
		//   CURLOPT_MAXREDIRS => 10,
		//   CURLOPT_TIMEOUT => 30,
		//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		//   CURLOPT_CUSTOMREQUEST => "POST",
		//   CURLOPT_POSTFIELDS => "",
		//   CURLOPT_SSL_VERIFYHOST => 0,
		//   CURLOPT_SSL_VERIFYPEER => 0,
		// ));
		// $response = curl_exec($curl);
		// $err = curl_error($curl);
		// curl_close($curl);
		return true;
	}

	// Doctor App Api's
	public function Signin_expert()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$result = $this->w_m->Signin_expert($data);
			echo json_encode($result);
		}
	}

	// public function Forget_password_expert()
	// {
	// 	$data =json_decode(file_get_contents('php://input'), true);
	// 	if(isset($data) && !empty($data)){
	// 			$result = $this->w_m->forget_password_doctor($data['email']);
	// 			echo json_encode($result);
	// 		}
	// }

	public function home_expert()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$date = date('Y-m-d');
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$limit_count = 6;
			$limit_from = $data['limit_from'];
			$user_id = $data['user_id'];
			if ($data['condition'] == 'upcoming') {
				$query = "SELECT * FROM `booking` WHERE `expert_id` = '$user_id' AND `booking_type` IN ('1','2','4') AND `status` = '0' ORDER BY `booking_date_time` DESC";
				$all_list = $this->db->query($query)->result();
				if (count($all_list) > 0) {
					foreach ($all_list as $key) {
						if ($key->booking_type == '1' || $key->booking_type == '2') {
							if ($key->booking_type == '1') {
								$booking_modal_name = 'Ask a Question';
							} else {
								$booking_modal_name = 'Online Consult';
							}

							/* Video chat audio logic start */
							$current_time = time();
							$booking_date_time_list = strtotime($key->booking_date_time);
							$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $key->total_minutes . " minutes", $booking_date_time_list)));

							$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("-10 seconds", $booking_date_time_list)));

							if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
								if ($key->bridge_id !== 0) {
									$video_start = 1;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = $key->bridge_id;
									$get_user = $this->db->get_where("user", array("id" => $key->user_id))->row();
									$get_user_name = $get_user->name;
								} else {
									$video_start = 0;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = 0;
									$get_user_name = 0;
								}
							} else {
								$video_start = 0;
								$is_chat_or_video_start = $key->is_chat_or_video_start;
								$chat_g_id_list = 0;
								$get_user_name = 0;
							}
							/* Video chat audio logic end */


							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$start_time = $key->booking_time;
							$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->booking_time)));
							$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
							$time_remain = 60 * 60 * 1;
							$before_three_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
							if ($total_appointment_time > $current_date_time) {
								$complete_power = 1;
								$accept_power = 1;
								$cancel_power = 1;
							} else {
								$complete_power = 0;
								$accept_power = 0;
								$cancel_power = 0;
							}

							if ($key->status == 0) {
								$complete_power = 1;
								$booking_status = 'pending';
							} elseif ($key->status == 1) {
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
								$booking_status = 'complete';
							} elseif ($key->status == 2 || $key->status == 3 || $key->status == 4) {
								$booking_status = 'cancel';
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();
							if ($key->booking_for !== 'self') {
								$img = 'default.png';
								$get_member_detail = $this->db->get_where("user_member", array("id" => $key->member_id))->row();
								$booking_person_name = $get_member_detail->member_name;
							} else {
								$img = $user_detail->image;
								$booking_person_name = $user_detail->name;
							}

							if (!is_null($key->problem)) {
								$problem = $key->problem;
							} else {
								$problem = '';
							}

							if ($cancel_power == 1) {
								if ($is_chat_or_video_start == 1 || $is_chat_or_video_start == 2) {
									$cancel_power = 0;
								}
							}
							$booking_list[] = array(
								"bookings_flag" => "online",
								"Booking_Heading" => $booking_modal_name,
								"id" => $key->id,
								"status" => $key->status,
								"online_mode" => $key->online_mode,
								"user_id" => $key->user_id,
								"booking_for" => $key->booking_for,
								"booking_mode" => ucfirst($key->online_mode) . ' consult',
								"member_id" => $key->member_id,
								"name" => $booking_person_name,
								"image" => base_url('uploads/user') . '/' . $img,
								"booking_date" => date('d M Y', strtotime($key->booking_date)) . ', ' . date('h:i A', strtotime($key->booking_time)),
								"accept_power" => $accept_power,
								"complete_power" => $complete_power,
								"cancel_power" => $cancel_power,
								"remain_days" => $remain_days,
								"email" => $user_detail->email,
								"mobile" => $user_detail->phone,
								"start_time_end_time" => $start_time . ' TO ' . $endTime,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id" => $chat_g_id_list,
								"get_user_name" => $get_user_name,
								"total_amount" => $key->total_amount,
								"from_payment_gateway" => $key->from_payment_gateway,
								"wallet_amount" => $key->wallet_amount,
								"referral_amount" => $key->referral_amount,
								"discount_amount" => $key->discount_amount,
								"tax_amount" => $key->tax_amount,
								"trxn_status" => $key->trxn_status,
								"trxn_mode" => $key->trxn_mode,
								"trxn_id" => $key->trxn_id,
							);
						} elseif ($key->booking_type == '4') {
							$booking_modal_name = 'In Person Consultation';
							$video_start = 0;
							$is_chat_or_video_start = $key->is_chat_or_video_start;
							$chat_g_id_list = 0;
							$get_user_name = 0;

							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$start_time = $key->booking_time;
							$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->booking_time)));
							$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
							$time_remain = 60 * 60 * 1;
							$before_three_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
							if ($total_appointment_time > $current_date_time) {
								$complete_power = 1;
								$accept_power = 1;
								$cancel_power = 1;
							} else {
								$complete_power = 0;
								$accept_power = 0;
								$cancel_power = 0;
							}

							if ($key->status == 0) {
								$complete_power = 1;
								$booking_status = 'pending';
							} elseif ($key->status == 1) {
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
								$booking_status = 'complete';
							} elseif ($key->status == 2 || $key->status == 3 || $key->status == 4) {
								$booking_status = 'cancel';
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$user_details_array = $this->user_details_array($key->multiple_members);

							if (!is_null($key->problem)) {
								$problem = $key->problem;
							} else {
								$problem = '';
							}

							if ($cancel_power == 1) {
								if ($is_chat_or_video_start == 1 || $is_chat_or_video_start == 2) {
									$cancel_power = 0;
								}
							}

							$get_event_detail = $this->db->get_where("in_person_events", array("id" => $key->event_id))->row();

							$booking_list[] = array(
								"bookings_flag" => "offline",
								"Booking_Heading" => $booking_modal_name,
								"id" => $key->id,
								"status" => $key->status,
								"booking_status" => $booking_status,
								"event_name" => $get_event_detail->title,
								"event_lat" => $get_event_detail->lat,
								"event_longi" => $get_event_detail->longi,
								"event_lat_long_address" => $get_event_detail->lat_long_address,
								"event_price_per_person" => $get_event_detail->price_per_person,
								"event_start_date" => date('d M Y', strtotime($get_event_detail->start_date)),
								"event_end_date" => date('d M Y', strtotime($get_event_detail->end_date)),
								"user_id" => $key->user_id,
								"booking_for" => $key->booking_for,
								"user_details_array" => $user_details_array,
								"booking_date" => date('d M Y', strtotime($key->booking_date)) . ', ' . date('h:i A', strtotime($key->booking_time)),
								"accept_power" => $accept_power,
								"complete_power" => $complete_power,
								"cancel_power" => $cancel_power,
								"remain_days" => $remain_days,
								"email" => $user_detail->email,
								"mobile" => $user_detail->phone,
								"start_time_end_time" => $start_time . ' TO ' . $endTime,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id" => $chat_g_id_list,
								"get_user_name" => $get_user_name,
								"total_amount" => $key->total_amount,
								"from_payment_gateway" => $key->from_payment_gateway,
								"wallet_amount" => $key->wallet_amount,
								"referral_amount" => $key->referral_amount,
								"discount_amount" => $key->discount_amount,
								"tax_amount" => $key->tax_amount,
								"trxn_status" => $key->trxn_status,
								"trxn_mode" => $key->trxn_mode,
								"trxn_id" => $key->trxn_id,
							);
						}
					}

					if (!empty($booking_list)) {
						$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from);
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from);
					}
				} else {
					$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from);
				}
			} elseif ($data['condition'] == 'past') {
				$query = "SELECT * FROM `booking` WHERE `expert_id` = '$user_id' AND `booking_type` IN ('1','2','4') AND `status`<> '0' ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
				$all_list = $this->db->query($query)->result();
				if (count($all_list) > 0) {
					foreach ($all_list as $key) {
						if ($key->booking_type == '1' || $key->booking_type == '2') {
							if ($key->booking_type == '1') {
								$booking_modal_name = 'Ask a Question';
							} else {
								$booking_modal_name = 'Online Consult';
							}

							/* Video chat audio logic start */
							$current_time = time();
							$booking_date_time_list = strtotime($key->booking_date_time);
							$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $key->total_minutes . " minutes", $booking_date_time_list)));

							$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("-10 seconds", $booking_date_time_list)));

							if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
								if ($key->bridge_id !== 0) {
									$video_start = 1;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = $key->bridge_id;
									$get_user = $this->db->get_where("user", array("id" => $key->user_id))->row();
									$get_user_name = $get_user->name;
								} else {
									$video_start = 0;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = 0;
									$get_user_name = 0;
								}
							} else {
								$video_start = 0;
								$is_chat_or_video_start = $key->is_chat_or_video_start;
								$chat_g_id_list = 0;
								$get_user_name = 0;
							}
							/* Video chat audio logic end */


							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$start_time = $key->booking_time;
							$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->booking_time)));
							$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
							$time_remain = 60 * 60 * 1;
							$before_three_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
							if ($total_appointment_time > $current_date_time) {
								$complete_power = 1;
								$accept_power = 1;
								$cancel_power = 1;
							} else {
								$complete_power = 0;
								$accept_power = 0;
								$cancel_power = 0;
							}

							if ($key->status == 0) {
								$complete_power = 1;
								$booking_status = 'pending';
							} elseif ($key->status == 1) {
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
								$booking_status = 'complete';
							} elseif ($key->status == 2 || $key->status == 3 || $key->status == 4 || $key->status == 5) {
								$booking_status = 'cancel';
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();
							if ($key->booking_for !== 'self') {
								$img = 'default.png';
								$get_member_detail = $this->db->get_where("user_member", array("id" => $key->member_id))->row();
								$booking_person_name = $get_member_detail->member_name;
							} else {
								$img = $user_detail->image;
								$booking_person_name = $user_detail->name;
							}

							if (!is_null($key->problem)) {
								$problem = $key->problem;
							} else {
								$problem = '';
							}

							if ($cancel_power == 1) {
								if ($is_chat_or_video_start == 1 || $is_chat_or_video_start == 2) {
									$cancel_power = 0;
								}
							}
							$booking_list[] = array(
								"bookings_flag" => "online",
								"Booking_Heading" => $booking_modal_name,
								"id" => $key->id,
								"status" => $key->status,
								"booking_status" => $booking_status,
								"online_mode" => $key->online_mode,
								"user_id" => $key->user_id,
								"booking_for" => $key->booking_for,
								"booking_mode" => ucfirst($key->online_mode) . ' consult',
								"member_id" => $key->member_id,
								"name" => $booking_person_name,
								"image" => base_url('uploads/user') . '/' . $img,
								"booking_date" => date('d M Y', strtotime($key->booking_date)) . ', ' . date('h:i A', strtotime($key->booking_time)),
								"accept_power" => $accept_power,
								"complete_power" => $complete_power,
								"cancel_power" => $cancel_power,
								"remain_days" => $remain_days,
								"email" => $user_detail->email,
								"mobile" => $user_detail->phone,
								"start_time_end_time" => $start_time . ' TO ' . $endTime,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id" => $chat_g_id_list,
								"get_user_name" => $get_user_name,
								"total_amount" => $key->total_amount,
								"from_payment_gateway" => $key->from_payment_gateway,
								"wallet_amount" => $key->wallet_amount,
								"referral_amount" => $key->referral_amount,
								"discount_amount" => $key->discount_amount,
								"tax_amount" => $key->tax_amount,
								"trxn_status" => $key->trxn_status,
								"trxn_mode" => $key->trxn_mode,
								"trxn_id" => $key->trxn_id,
							);
						} elseif ($key->booking_type == '4') {
							$booking_modal_name = 'In Person Consultation';
							$video_start = 0;
							$is_chat_or_video_start = $key->is_chat_or_video_start;
							$chat_g_id_list = 0;
							$get_user_name = 0;

							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$start_time = $key->booking_time;
							$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->booking_time)));
							$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
							$time_remain = 60 * 60 * 1;
							$before_three_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
							if ($total_appointment_time > $current_date_time) {
								$complete_power = 1;
								$accept_power = 1;
								$cancel_power = 1;
							} else {
								$complete_power = 0;
								$accept_power = 0;
								$cancel_power = 0;
							}

							if ($key->status == 0) {
								$complete_power = 1;
								$booking_status = 'pending';
							} elseif ($key->status == 1) {
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
								$booking_status = 'complete';
							} elseif ($key->status == 2 || $key->status == 3 || $key->status == 4 || $key->status == 5) {
								$booking_status = 'cancel';
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$user_details_array = $this->user_details_array($key->multiple_members);

							if (!is_null($key->problem)) {
								$problem = $key->problem;
							} else {
								$problem = '';
							}

							if ($cancel_power == 1) {
								if ($is_chat_or_video_start == 1 || $is_chat_or_video_start == 2) {
									$cancel_power = 0;
								}
							}

							$get_event_detail = $this->db->get_where("in_person_events", array("id" => $key->event_id))->row();

							$booking_list[] = array(
								"bookings_flag" => "offline",
								"Booking_Heading" => $booking_modal_name,
								"id" => $key->id,
								"status" => $key->status,
								"booking_status" => $booking_status,
								"event_name" => $get_event_detail->title,
								"event_lat" => $get_event_detail->lat,
								"event_longi" => $get_event_detail->longi,
								"event_lat_long_address" => $get_event_detail->lat_long_address,
								"event_price_per_person" => $get_event_detail->price_per_person,
								"event_start_date" => date('d M Y', strtotime($get_event_detail->start_date)),
								"event_end_date" => date('d M Y', strtotime($get_event_detail->end_date)),
								"user_id" => $key->user_id,
								"booking_for" => $key->booking_for,
								"user_details_array" => $user_details_array,
								"booking_date" => date('d M Y', strtotime($key->booking_date)) . ', ' . date('h:i A', strtotime($key->booking_time)),
								"accept_power" => $accept_power,
								"complete_power" => $complete_power,
								"cancel_power" => $cancel_power,
								"remain_days" => $remain_days,
								"email" => $user_detail->email,
								"mobile" => $user_detail->phone,
								"start_time_end_time" => $start_time . ' TO ' . $endTime,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id" => $chat_g_id_list,
								"get_user_name" => $get_user_name,
								"total_amount" => $key->total_amount,
								"from_payment_gateway" => $key->from_payment_gateway,
								"wallet_amount" => $key->wallet_amount,
								"referral_amount" => $key->referral_amount,
								"discount_amount" => $key->discount_amount,
								"tax_amount" => $key->tax_amount,
								"trxn_status" => $key->trxn_status,
								"trxn_mode" => $key->trxn_mode,
								"trxn_id" => $key->trxn_id,
							);
						}
					}

					if (!empty($booking_list)) {
						$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from);
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from);
					}
				} else {
					$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from);
				}
			} elseif ($data['condition'] == 'cancel') {
				$query = "SELECT * FROM `booking` WHERE `expert_id` = '$user_id' AND `booking_type` IN ('1','2','4') AND (`status` <> '0' AND `status` <> '1') ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
				$all_list = $this->db->query($query)->result();
				if (count($all_list) > 0) {
					foreach ($all_list as $key) {
						if ($key->booking_type == '1' || $key->booking_type == '2') {
							if ($key->booking_type == '1') {
								$booking_modal_name = 'Ask a Question';
							} else {
								$booking_modal_name = 'Online Consult';
							}

							/* Video chat audio logic start */
							$current_time = time();
							$booking_date_time_list = strtotime($key->booking_date_time);
							$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $key->total_minutes . " minutes", $booking_date_time_list)));

							$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("-10 seconds", $booking_date_time_list)));

							if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
								if ($key->bridge_id !== 0) {
									$video_start = 1;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = $key->bridge_id;
									$get_user = $this->db->get_where("user", array("id" => $key->user_id))->row();
									$get_user_name = $get_user->name;
								} else {
									$video_start = 0;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = 0;
									$get_user_name = 0;
								}
							} else {
								$video_start = 0;
								$is_chat_or_video_start = $key->is_chat_or_video_start;
								$chat_g_id_list = 0;
								$get_user_name = 0;
							}
							/* Video chat audio logic end */


							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$start_time = $key->booking_time;
							$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->booking_time)));
							$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
							$time_remain = 60 * 60 * 1;
							$before_three_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
							if ($total_appointment_time > $current_date_time) {
								$complete_power = 1;
								$accept_power = 1;
								$cancel_power = 1;
							} else {
								$complete_power = 0;
								$accept_power = 0;
								$cancel_power = 0;
							}

							if ($key->status == 0) {
								$complete_power = 1;
								$booking_status = 'pending';
							} elseif ($key->status == 1) {
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
								$booking_status = 'complete';
							} elseif ($key->status == 2 || $key->status == 3 || $key->status == 4 || $key->status == 5) {
								$booking_status = 'cancel';
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();
							if ($key->booking_for !== 'self') {
								$img = 'default.png';
								$get_member_detail = $this->db->get_where("user_member", array("id" => $key->member_id))->row();
								$booking_person_name = $get_member_detail->member_name;
							} else {
								$img = $user_detail->image;
								$booking_person_name = $user_detail->name;
							}

							if (!is_null($key->problem)) {
								$problem = $key->problem;
							} else {
								$problem = '';
							}

							if ($cancel_power == 1) {
								if ($is_chat_or_video_start == 1 || $is_chat_or_video_start == 2) {
									$cancel_power = 0;
								}
							}
							$booking_list[] = array(
								"bookings_flag" => "online",
								"Booking_Heading" => $booking_modal_name,
								"id" => $key->id,
								"status" => $key->status,
								"online_mode" => $key->online_mode,
								"user_id" => $key->user_id,
								"booking_for" => $key->booking_for,
								"booking_mode" => ucfirst($key->online_mode) . ' consult',
								"member_id" => $key->member_id,
								"name" => $booking_person_name,
								"image" => base_url('uploads/user') . '/' . $img,
								"booking_date" => date('d M Y', strtotime($key->booking_date)) . ', ' . date('h:i A', strtotime($key->booking_time)),
								"accept_power" => $accept_power,
								"complete_power" => $complete_power,
								"cancel_power" => $cancel_power,
								"remain_days" => $remain_days,
								"email" => $user_detail->email,
								"mobile" => $user_detail->phone,
								"start_time_end_time" => $start_time . ' TO ' . $endTime,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id" => $chat_g_id_list,
								"get_user_name" => $get_user_name,
								"total_amount" => $key->total_amount,
								"from_payment_gateway" => $key->from_payment_gateway,
								"wallet_amount" => $key->wallet_amount,
								"referral_amount" => $key->referral_amount,
								"discount_amount" => $key->discount_amount,
								"tax_amount" => $key->tax_amount,
								"trxn_status" => $key->trxn_status,
								"trxn_mode" => $key->trxn_mode,
								"trxn_id" => $key->trxn_id,
							);
						} elseif ($key->booking_type == '4') {
							$booking_modal_name = 'In Person Consultation';
							$video_start = 0;
							$is_chat_or_video_start = $key->is_chat_or_video_start;
							$chat_g_id_list = 0;
							$get_user_name = 0;

							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$start_time = $key->booking_time;
							$endTime = date('h:ia', strtotime("+" . $key->total_minutes . " minutes", strtotime($key->booking_time)));
							$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
							$time_remain = 60 * 60 * 1;
							$before_three_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
							if ($total_appointment_time > $current_date_time) {
								$complete_power = 1;
								$accept_power = 1;
								$cancel_power = 1;
							} else {
								$complete_power = 0;
								$accept_power = 0;
								$cancel_power = 0;
							}

							if ($key->status == 0) {
								$complete_power = 1;
								$booking_status = 'pending';
							} elseif ($key->status == 1) {
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
								$booking_status = 'complete';
							} elseif ($key->status == 2 || $key->status == 3 || $key->status == 4) {
								$booking_status = 'cancel';
								$accept_power = 0;
								$complete_power = 0;
								$cancel_power = 0;
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$user_details_array = $this->user_details_array($key->multiple_members);

							if (!is_null($key->problem)) {
								$problem = $key->problem;
							} else {
								$problem = '';
							}

							if ($cancel_power == 1) {
								if ($is_chat_or_video_start == 1 || $is_chat_or_video_start == 2) {
									$cancel_power = 0;
								}
							}

							$get_event_detail = $this->db->get_where("in_person_events", array("id" => $key->event_id))->row();

							$booking_list[] = array(
								"bookings_flag" => "offline",
								"Booking_Heading" => $booking_modal_name,
								"id" => $key->id,
								"status" => $key->status,
								"event_name" => $get_event_detail->title,
								"event_lat" => $get_event_detail->lat,
								"event_longi" => $get_event_detail->longi,
								"event_lat_long_address" => $get_event_detail->lat_long_address,
								"event_price_per_person" => $get_event_detail->price_per_person,
								"event_start_date" => date('d M Y', strtotime($get_event_detail->start_date)),
								"event_end_date" => date('d M Y', strtotime($get_event_detail->end_date)),
								"user_id" => $key->user_id,
								"booking_for" => $key->booking_for,
								"user_details_array" => $user_details_array,
								"booking_date" => date('d M Y', strtotime($key->booking_date)) . ', ' . date('h:i A', strtotime($key->booking_time)),
								"accept_power" => $accept_power,
								"complete_power" => $complete_power,
								"cancel_power" => $cancel_power,
								"remain_days" => $remain_days,
								"email" => $user_detail->email,
								"mobile" => $user_detail->phone,
								"start_time_end_time" => $start_time . ' TO ' . $endTime,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id" => $chat_g_id_list,
								"get_user_name" => $get_user_name,
								"total_amount" => $key->total_amount,
								"from_payment_gateway" => $key->from_payment_gateway,
								"wallet_amount" => $key->wallet_amount,
								"referral_amount" => $key->referral_amount,
								"discount_amount" => $key->discount_amount,
								"tax_amount" => $key->tax_amount,
								"trxn_status" => $key->trxn_status,
								"trxn_mode" => $key->trxn_mode,
								"trxn_id" => $key->trxn_id,
							);
						}
					}

					if (!empty($booking_list)) {
						$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from);
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from);
					}
				} else {
					$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from);
				}
			}
			echo json_encode($response);
		}
	}

	public function user_details_array($string)
	{
		$booking_for_list = array();
		$l1 = explode('|', $string);
		$count = count($l1);
		if ($count > 1) {
			foreach ($l1 as $l1_1) {
				$l2 = explode(',', $l1_1);
				$u_id = $l2[0];
				$is_mem = $l2[1];
				if ($is_mem == 1) {
					$get_detail = $this->db->get_where("user_member", array("id" => $u_id))->row();
					$u_array = array(
						"id" => $get_detail->id,
						"is_member" => 1,
						"name" => $get_detail->member_name,
						"img" => base_url('uploads/user/default.png')
					);
					array_push($booking_for_list, $u_array);
				} else {
					$get_detail = $this->db->get_where("user", array("id" => $u_id))->row();
					$u_array = array(
						"id" => $get_detail->id,
						"is_member" => 0,
						"name" => $get_detail->name,
						"img" => base_url('uploads/user/' . '/' . $get_detail->image)
					);
					array_push($booking_for_list, $u_array);
				}
			}
		} else {
			$l2 = explode(',', $string);
			$u_id = $l2[0];
			$is_mem = $l2[1];
			$get_detail = $this->db->get_where("user", array("id" => $u_id))->row();
			$u_array = array(
				"id" => $get_detail->id,
				"is_member" => 0,
				"name" => $get_detail->name,
				"img" => base_url('uploads/user/' . '/' . $get_detail->image)
			);
			array_push($booking_for_list, $u_array);
		}


		return $booking_for_list;
	}

	public function cancel_by_expert()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$booking_id = $data['booking_id'];
			$refernece_id = time() . rand(10 * 45, 100 * 98);
			$this->db->query("UPDATE `booking` SET `status` = '3',`refernece_id`='$refernece_id' WHERE `id`='$booking_id'");

			//refund to wallet and refer wallet
			$get_booking_details = $this->db->get_where("booking", array("id" => $booking_id))->row();
			if (count($get_booking_details) > 0) {
				if ($get_booking_details->status == '3' || $get_booking_details->status == 3) {
					//refund to wallet
					if ($get_booking_details->wallet_amount > 0) {
						$get_user_detail_for_wallet = $this->w_m->get_user($get_booking_details->user_id);
						$old_wallet = $get_user_detail_for_wallet->wallet;
						$update_wallet = $old_wallet + $get_booking_details->wallet_amount;
						$this->db->where("id", $get_user_detail_for_wallet->id);
						$this->db->update("user", array("wallet" => $update_wallet));

						$array_in = array(
							"user_id" => $get_user_detail_for_wallet->id,
							"payment_from" => "wallet_added",
							"booking_id" => $get_booking_details->id,
							"update_wallet" => $update_wallet,
							"previous_wallet" => $old_wallet,
							"trxn_status" => 'authorized',
							"trxn_id" => time(),
							"currency" => 'INR',
							"payment_status" => 'authorized',
							"description" => 'refund to user wallet',
							"created_at" => '',
							"method" => '',
							"fee" => '',
							"tax" => '',
							"payment_method_email" => '',
							"payment_method_contact" => '',
							"added_on" => date("Y-m-d H:i:s"),
							"deduct_amount" => 0,
							"do_sum_minus" => 'add',
							"amount" => $get_booking_details->wallet_amount,
							"payment_for" => "booking_cancel_refund"
						);
						$this->db->insert("user_wallet_referral_history", $array_in);
					}

					//refund to referwallet
					if ($get_booking_details->referral_amount > 0) {
						$get_user_detail_for_referwallet = $this->w_m->get_user($get_booking_details->user_id);
						$old_referwallet = $get_user_detail_for_referwallet->refferal_wallet;
						$update_referwallet = $old_referwallet + $get_booking_details->referral_amount;
						$this->db->where("id", $get_user_detail_for_referwallet->id);
						$this->db->update("user", array("refferal_wallet" => $update_referwallet));

						$array_in = array(
							"user_id" => $get_user_detail_for_referwallet->id,
							"payment_from" => "refferal_wallet_added",
							"booking_id" => $get_booking_details->id,
							"update_wallet" => $update_referwallet,
							"previous_wallet" => $old_referwallet,
							"trxn_status" => 'authorized',
							"trxn_id" => time(),
							"currency" => 'INR',
							"payment_status" => 'authorized',
							"description" => 'refund to user refferal wallet',
							"created_at" => '',
							"method" => '',
							"fee" => '',
							"tax" => '',
							"payment_method_email" => '',
							"payment_method_contact" => '',
							"added_on" => date("Y-m-d H:i:s"),
							"deduct_amount" => 0,
							"do_sum_minus" => 'add',
							"amount" => $get_booking_details->referral_amount,
							"payment_for" => "booking_cancel_refund"
						);
						$this->db->insert("user_wallet_referral_history", $array_in);
					}
				}
			}

			$check_follow_up = $this->db->query("SELECT * FROM `booking_follow_up` WHERE `booking_id`='$booking_id' AND `status`='1'")->row();
			if (count($check_follow_up) > 0) {
				$this->db->query("UPDATE `booking_follow_up` SET `status` = '0' WHERE `booking_id`='$booking_id'");
			}

			$response = array('status' => true, 'msg' => 'cancel successfully');
			echo json_encode($response);
		}
	}

	public function cancel_by_user()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$booking_id = $data['booking_id'];
				$refernece_id = time() . rand(10 * 45, 100 * 98);
				$this->db->query("UPDATE `booking` SET `status` = '2',`refernece_id`='$refernece_id' WHERE `id`='$booking_id'");
				$this->common_notification($booking_id, 'to_all_supervisor_cancel_content');
				$this->send_invoice_temp($booking_id, 'Booking cancel!', 'cancel');
				$response = array('status' => true, 'msg' => 'cancel successfully');
				echo json_encode($response);
			}
		}
	}

	public function logout_expert()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = $data['user_id'];
		if (isset($data['device_id'])) {
			$device_id = $data['device_id'];
			$device_token = $data['device_token'];
			$device_type = $data['device_type'];
			$check_device = $this->db->get_where("expert_tokens", array("expert_id" => $user_id, "device_id" => $device_id))->row();
			if (count($check_device) > 0) {
				$this->db->query("DELETE FROM `expert_tokens` WHERE `id`='" . $check_device->id . "'");
			}
		}
		$this->db->query("UPDATE `expert_management` SET `device_id`='',`device_token`='',`device_type`='' WHERE `id`='$user_id'");
		$response = array("status" => true, "msg" => "logout successfully");
		echo json_encode($response);
	}

	public function list_expert_notification()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$r2 = $this->db->order_by('id', 'DESC')->get_where("user_notification", array("user_id" => $data['user_id'], "for_" => 'expert'))->result();
			if (count($r2) > 0) {
				$response = array("status" => true, "list" => $r2,);
			} else {
				$response = array("status" => false, "message" => "not_found");
			}
			echo json_encode($response);
		}
	}

	public function add_expert_vacation()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = $data['user_id'];
		$vacation_for = $data['vacation_for'];
		$start_date = $data['start_date'];
		$end_date = $data['end_date'];
		$string = '[{"startdate":"' . $start_date . '","enddate":"' . $end_date . '"}]';
		$this->db->query("UPDATE `expert_management` SET `vacation_for`='$vacation_for',`vacation_time`='$string' WHERE `id`='$user_id'");
		$response = array("status" => true, "msg" => "update successfully");
		echo json_encode($response);
	}

	public function list_expert_time_slots_by_admin()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$check = $this->db->get_where("expert_management", array("id" => $data['user_id']))->row();
			if (count($check) > 0) {
				$res = array("status" => true, "message" => "success", "online_counsult_time" => json_decode($check->online_counsult_time));
			} else {
				$res = array("status" => false, "message" => "Not found any doctor");
			}

			echo json_encode($res);
		}
	}


	public function update_time_online()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$mon_array = array("0" => array("start" => $data['mon_start_one'], "end" => $data['mon_end_one']), "1" => array("start" => $data['mon_start_two'], "end" => $data['mon_end_two']));

			$tue_array = array("0" => array("start" => $data['tue_start_one'], "end" => $data['tue_end_one']), "1" => array("start" => $data['tue_start_two'], "end" => $data['tue_end_two']));

			$wed_array = array("0" => array("start" => $data['wed_start_one'], "end" => $data['wed_end_one']), "1" => array("start" => $data['wed_start_two'], "end" => $data['wed_end_two']));

			$thu_array = array("0" => array("start" => $data['thu_start_one'], "end" => $data['thu_end_one']), "1" => array("start" => $data['thu_start_two'], "end" => $data['thu_end_two']));

			$fri_array = array("0" => array("start" => $data['fri_start_one'], "end" => $data['fri_end_one']), "1" => array("start" => $data['fri_start_two'], "end" => $data['fri_end_two']));

			$sat_array = array("0" => array("start" => $data['sat_start_one'], "end" => $data['sat_end_one']), "1" => array("start" => $data['sat_start_two'], "end" => $data['sat_end_two']));

			$sun_array = array("0" => array("start" => $data['sun_start_one'], "end" => $data['sun_end_one']), "1" => array("start" => $data['sun_start_two'], "end" => $data['sun_end_two']));

			$timing_in_clinic = '{"mon":' . json_encode($mon_array) . ',' . '"tue":' . json_encode($tue_array) . ',' . '"wed":' . json_encode($wed_array) . ',' . '"thu":' . json_encode($thu_array) . ',' . '"fri":' . json_encode($fri_array) . ',' . '"sat":' . json_encode($sat_array) . ',' . '"sun":' . json_encode($sun_array) . '}';

			$this->db->query("UPDATE `expert_management` SET `online_counsult_time`='$timing_in_clinic' WHERE `id`='$user_id'");
			$response = array("status" => true, "msg" => "update successfully");
			echo json_encode($response);
		}
	}

	public function update__online_time()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$d = array("online_counsult_time" => $data['online_counsult_time']);
			$this->db->where("id", $data['user_id']);
			$this->db->update("expert_management", $d);
			$l = $this->db->get_where("expert_management", array("id" => $data['user_id']))->row();
			echo json_encode(array("status" => true, "message" => "added", "time" => $data['time']));
		}
	}

	public function expert_details()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$expert_details = $this->db->get_where("expert_management", array("id" => $user_id))->row();
			$response = array("status" => true, "msg" => "update successfully", "expert_details" => $expert_details, "path" => base_url('uploads/expert') . '/');
			echo json_encode($response);
		}
	}

	public function update_expert_price()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$update_array = array(
				"min_price_for_chat" => $data['min_price_for_chat'],
				"min_price_for_call" => $data['min_price_for_call'],
				"min_price_for_ask_a_q" => $data['min_price_for_ask_a_q'],
				"min_price_for_video" => $data['min_price_for_video'],
			);
			$this->db->where("id", $user_id);
			$this->db->update('expert_management', $update_array);
			$response = array("status" => true, "msg" => "update successfully", "update_array" => $update_array);
			echo json_encode($response);
		}
	}

	public function update_expert_profile()
	{
		$user_id = $this->input->post('user_id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');
		$flag = $this->input->post('flag');
		$languages = $this->input->post('languages');

		if ($flag == '1') {
			$target_path = "uploads/expert/";
			$target_dir = "uploads/expert/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {

					$this->db->query("UPDATE `expert_management` SET `name`='$name',`email`='$email',`mobile`='$mobile',`image`='$actual_image_name',`languages`='$languages' WHERE `id` = '$user_id'");
					$query = $this->db->get_where("expert_management", array("id" => $user_id))->row();
					if (!empty($query->image)) {
						$img = base_url('/uploads/expert') . '/' . $query->image;
					} else {
						$img = base_url('/uploads/expert') . '/' . 'default.png';
					}

					if (!is_null($query->languages)) {
						$languages = $query->languages;
					} else {
						$languages = '';
					}


					$user_details = array(
						"user_id" => $query->id,
						"email" => $query->email,
						"name" => $query->name,
						"mobile" => $query->mobile,
						"languages" => $query->languages,
						"image" => $img,
					);
					$response = array("status" => true, "msg" => "Update Successfully", "user_detail" => $user_details);
				} else {
					$response = array("status" => false, "msg" => "image upload falied plesae try again latter thanks");
				}
			}
		} elseif ($flag == '0') {
			$this->db->query("UPDATE `expert_management` SET `name`='$name',`email`='$email',`mobile`='$mobile',`languages`='$languages' WHERE `id` = '$user_id'");
			$query = $this->db->get_where("expert_management", array("id" => $user_id))->row();
			if (!empty($query->image)) {
				$img = base_url('/uploads/expert') . '/' . $query->image;
			} else {
				$img = base_url('/uploads/expert') . '/' . 'default.png';
			}


			if (!is_null($query->languages)) {
				$languages = $query->languages;
			} else {
				$languages = '';
			}


			$user_details = array(
				"user_id" => $query->id,
				"email" => $query->email,
				"name" => $query->name,
				"mobile" => $query->mobile,
				"languages" => $query->languages,
				"image" => $img,

			);
			$response = array("status" => true, "msg" => "Update Successfully", "user_detail" => $user_details);
		}
		echo json_encode($response);
	}


	public function transaction_deatils()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];


			//Online Chat,video,audio, ask a question, in person, life prediction, Horoscope matching,Gems Products,Astrology Classes
			$total_amount = $this->db->query("SELECT (SELECT COALESCE(SUM(`total_amount`),0) FROM `class_package_history`) + (SELECT COALESCE(SUM(`order_amount`),0) FROM `booking_gems`) + (SELECT COALESCE(SUM(`total_amount`),0) FROM `horoscope_matching_booking` WHERE `expert_id` = '$user_id') + (SELECT COALESCE(SUM(`total_amount`),0) FROM `booking` WHERE `expert_id` = '$user_id') + (SELECT COALESCE(SUM(amount),0) FROM `user_wallet_referral_history` WHERE `payment_from` = 'wallet' AND `do_sum_minus` = 'add') AS total_amount")->row();


			//Online Chat,video,audio, ask a question, in person, life prediction
			$get_from_online_bookings = $this->db->query("SELECT SUM(`total_amount`) AS A FROM `booking` WHERE `expert_id` = '$user_id'")->row();
			// Horoscope matching,
			$get_from_horoscope_bookings = $this->db->query("SELECT SUM(`total_amount`) AS A FROM `horoscope_matching_booking` WHERE `expert_id` = '$user_id'")->row();
			// Gems Products,
			$get_from_gems_bookings = $this->db->query("SELECT SUM(`order_amount`) AS A FROM `booking_gems`")->row();

			// Astrology Classes
			$get_from_classes_bookings = $this->db->query("SELECT SUM(`total_amount`) AS A FROM `class_package_history`")->row();

			// Add Wallet
			$get_from_addwallet = $this->db->query("SELECT SUM(amount) AS A FROM `user_wallet_referral_history` WHERE `payment_from` = 'wallet' AND `do_sum_minus` = 'add'")->row();

			/*$query = "(SELECT 'class_package_history' AS 'class_package_history',0 AS 'mode_as',`total_amount`,`payment_id`,`added_on` from class_package_history ORDER BY `added_on` DESC)  UNION ALL (SELECT 'horoscope_matching_booking' AS 'horoscope_matching_booking',0 AS 'mode_as',`total_amount`,`trxn_id`,`added_on` from horoscope_matching_booking ORDER BY `added_on` DESC) UNION ALL (SELECT 'booking' AS 'booking',`booking_type` AS 'mode_as',`total_amount`,`trxn_id`,`added_on` from booking ORDER BY `added_on` DESC) UNION ALL (SELECT 'gems' AS 'gems',0 AS 'mode_as',`order_amount`,`trxn_id`,`added_on` from booking_gems ORDER BY `added_on` DESC) UNION ALL (SELECT 'add_wallet' AS 'add_wallet',0 AS 'mode_as',`amount`,`trxn_id`,`added_on` FROM `user_wallet_referral_history` WHERE `payment_for` = 'add_wallet' ORDER BY `added_on` DESC)";
			$all_list = $this->db->query($query)->result();
			$listol = array();
			if (count($all_list) > 0) 
			{
				foreach ($all_list as $key) 
				{
					switch ($key->class_package_history) 
					{
						case 'class_package_history':
							$title = 'Add Classes';
							$subtitle = '(Astrology Classes)';
							break;

						case 'horoscope_matching_booking':
							$title = 'Add Booking';
							$subtitle = '(Horoscope Matching)';
							break;

						case 'booking':
							$title = 'Add Booking';
							if ($key->mode_as == 1) 
							{
								$subtitle = '(Ask for a question)';	
							}
							elseif ($key->mode_as == 2) 
							{
								$subtitle = '(Online Consultation)';	
							}
							elseif ($key->mode_as == 3) 
							{
								$subtitle = '(Life Prediction)';	
							}
							elseif ($key->mode_as == 4) 
							{
								$subtitle = '(In Person Booking)';	
							}
							else
							{
								$subtitle = '(Booking)';	
							}
							break;

						case 'gems':
							$title = 'Add Order';
							$subtitle = '(Gemstone booking)';
							break;

						case 'add_wallet':
							$title = 'Add Wallet';
							$subtitle = '';
							break;
						
						default:
							$title = 'NAN';
							$subtitle = 'NAN';
							break;
					}

					$listol[] = array("title"=>$title
									 ,"subtitle"=>$subtitle,
									  "total_amount"=>$key->total_amount,
									  "payment_id"=>$key->payment_id,
									  "added_on"=>date('d M Y H:ia', strtotime($key->added_on)));
					
				}
			}*/

			$response = array(
				"status" => true,
				"total_amount" => $total_amount->total_amount,
				"get_from_online_bookings" => $get_from_online_bookings->A,
				"get_from_horoscope_bookings" => $get_from_horoscope_bookings->A,
				"get_from_gems_bookings" => $get_from_gems_bookings->A,
				"get_from_classes_bookings" => $get_from_classes_bookings->A,
				"get_from_addwallet" => $get_from_addwallet->A,
			);
			//"list"=>$listol);
			echo json_encode($response);
		}
	}

	public function total_earning_expert()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$user_id = $data['user_id'];
			$limit_count = 3;
			$limit_from = $data['limit_from'];

			//Online Chat,video,audio, ask a question, in person, life prediction, Horoscope matching,Gems Products,Astrology Classes
			$total_amount = $this->db->query("SELECT (SELECT COALESCE(SUM(`total_amount`),0) FROM `class_package_history`) + (SELECT COALESCE(SUM(`order_amount`),0) FROM `booking_gems`) + (SELECT COALESCE(SUM(`total_amount`),0) FROM `horoscope_matching_booking` WHERE `expert_id` = '$user_id') + (SELECT COALESCE(SUM(`total_amount`),0) FROM `booking` WHERE `expert_id` = '$user_id') + (SELECT COALESCE(SUM(amount),0) FROM `user_wallet_referral_history` WHERE `payment_from` = 'wallet' AND `do_sum_minus` = 'add') AS total_amount")->row();


			//Online Chat,video,audio, ask a question, in person, life prediction
			$get_from_online_bookings = $this->db->query("SELECT SUM(`total_amount`) AS A FROM `booking` WHERE `expert_id` = '$user_id'")->row();
			// Horoscope matching,
			$get_from_horoscope_bookings = $this->db->query("SELECT SUM(`total_amount`) AS A FROM `horoscope_matching_booking` WHERE `expert_id` = '$user_id'")->row();
			// Gems Products,
			$get_from_gems_bookings = $this->db->query("SELECT SUM(`order_amount`) AS A FROM `booking_gems`")->row();

			// Astrology Classes
			$get_from_classes_bookings = $this->db->query("SELECT SUM(`total_amount`) AS A FROM `class_package_history`")->row();

			// Add Wallet
			$get_from_addwallet = $this->db->query("SELECT SUM(amount) AS A FROM `user_wallet_referral_history` WHERE `payment_from` = 'wallet' AND `do_sum_minus` = 'add'")->row();


			$query = "(SELECT 'class_package_history' AS 'class_package_history',0 AS 'mode_as',`total_amount`,`payment_id`,`added_on` from class_package_history ORDER BY `added_on` DESC LIMIT $limit_from,$limit_count)  UNION ALL (SELECT 'horoscope_matching_booking' AS 'horoscope_matching_booking',0 AS 'mode_as',`total_amount`,`trxn_id`,`added_on` from horoscope_matching_booking ORDER BY `added_on` DESC LIMIT $limit_from,$limit_count) UNION ALL (SELECT 'booking' AS 'booking',`booking_type` AS 'mode_as',`total_amount`,`trxn_id`,`added_on` from booking ORDER BY `added_on` DESC LIMIT $limit_from,$limit_count) UNION ALL (SELECT 'gems' AS 'gems',0 AS 'mode_as',`order_amount`,`trxn_id`,`added_on` from booking_gems ORDER BY `added_on` DESC LIMIT $limit_from,$limit_count) UNION ALL (SELECT 'add_wallet' AS 'add_wallet',0 AS 'mode_as',`amount`,`trxn_id`,`added_on` FROM `user_wallet_referral_history` WHERE `payment_for` = 'add_wallet' ORDER BY `added_on` DESC LIMIT $limit_from,$limit_count)";
			$all_list = $this->db->query($query)->result();
			$listol = array();
			if (count($all_list) > 0) {
				foreach ($all_list as $key) {
					switch ($key->class_package_history) {
						case 'class_package_history':
							$title = 'Add Classes';
							$subtitle = '(Astrology Classes)';
							break;

						case 'horoscope_matching_booking':
							$title = 'Add Booking';
							$subtitle = '(Horoscope Matching)';
							break;

						case 'booking':
							$title = 'Add Booking';
							if ($key->mode_as == 1) {
								$subtitle = '(Ask for a question)';
							} elseif ($key->mode_as == 2) {
								$subtitle = '(Online Consultation)';
							} elseif ($key->mode_as == 3) {
								$subtitle = '(Life Prediction)';
							} elseif ($key->mode_as == 4) {
								$subtitle = '(In Person Booking)';
							} else {
								$subtitle = '(Booking)';
							}
							break;

						case 'gems':
							$title = 'Add Order';
							$subtitle = '(Gemstone booking)';
							break;

						case 'add_wallet':
							$title = 'Add Wallet';
							$subtitle = '';
							break;

						default:
							$title = 'NAN';
							$subtitle = 'NAN';
							break;
					}

					$listol[] = array(
						"title" => $title, "subtitle" => $subtitle,
						"total_amount" => $key->total_amount,
						"payment_id" => $key->payment_id,
						"added_on" => date('d M Y H:ia', strtotime($key->added_on))
					);
					$response = array(
						"status" => true, "total_amount" => $total_amount->total_amount,
						"get_from_online_bookings" => $get_from_online_bookings->A,
						"get_from_horoscope_bookings" => $get_from_horoscope_bookings->A,
						"get_from_gems_bookings" => $get_from_gems_bookings->A,
						"get_from_classes_bookings" => $get_from_classes_bookings->A,
						"get_from_addwallet" => $get_from_addwallet->A, "listol" => $listol, "limit_from" => $limit_from
					);
				}
			} else {
				$response = array("status" => false, "msg" => "not found", "limit_from" => $limit_from);
			}

			echo json_encode($response);
		}
	}


	public function user_support()
	{

		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {

			$user_id = $data['user_id'];
			$name = $data['name'];
			$email = $data['email'];
			$mobile = $data['mobile'];
			$message = $data['message'];
			$array = array(
				"user_id" => $user_id,
				"name" => $name,
				"email" => $email,
				"mobile" => $mobile,
				"message" => $message,
				"status" => 0,
				"added_on" => date('Y-m-d H:i:s')
			);
			$this->db->insert('user_support', $array);
			$id = $this->db->insert_id();
			$settings = $this->w_m->get_settings();
			$subject = "Ticket Received - Support Requested[#" . $id . "]";
			$mail_message = "Hi,<br><br>Thanks you for contacting Kundali Expert support!

						<br><br>Resolving your issues and answering your questions<br>
						is our top priority. A member of our support team will<br>
						investigate and follow up with you at the earliest.
						<br><br>
						Have a great day!
						<br><br><br>

						Sincerely,
						Kundali Expert Support Team";
			$this->w_m->check_curl($email, $subject, $mail_message, $name, $settings->support_email, 'Enquiry recieved!!');
			$response = array('status' => true, 'msg' => 'support submit succesfully');
			echo json_encode($response);
		}
	}







	public function list_user_notification()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$r2 = $this->db->order_by('id', 'DESC')->get_where("user_notification", array("user_id" => $data['user_id']))->result();
			if (count($r2) > 0) {
				$response = array("status" => true, "list" => $r2,);
			} else {
				$response = array("status" => false, "message" => "not_found");
			}
			echo json_encode($response);
		}
	}

	//coupan_code apply verify
	public function coupan_verify()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$module = $data['module'];
				$coupan_code = $data['coupan_code'];
				$check = $this->db->get_where("coupan", array("code" => $coupan_code, "discount_on" => $module))->row();
				if (count($check) > 0) {
					if ($check->uses_limit > $check->total_used) {
						$response = array("status" => true, "msg" => "coupan verified", "discount_type" => $check->discount_type, "condition" => $check->amount, "coupan_id" => $check->id);
					} else {
						$response = array('status' => false, 'msg' => 'limit crosssed');
					}
				} else {
					$response = array('status' => false, 'msg' => 'not verified');
				}

				echo json_encode($response);
			}
		}
	}

	public function coupan_used_increment($id, $module, $booking_id, $user_id)
	{
		$get  = $this->db->get_where("coupan", array("id" => $id))->row();
		if (count($get) > 0) {
			$used_limit = $get->total_used;
			$now_total = $used_limit + 1;
			$this->db->query("UPDATE `coupan` SET `total_used`='$now_total' WHERE `id`=$id");
			$array = array(
				"user_id" => $user_id,
				"coupan_id" => $id,
				"booking_id" => $booking_id,
				"module" => $module,
				"added_on" => date('Y-m-d H:i:s')
			);
			$this->db->insert("coupan_history", $array);
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function serach_pooja()
	{

		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_id = $data['user_id'];
				$search_keyword = $data['search_keyword'];
				if (strlen($search_keyword) >= 1) {
					// print_r($search_keyword); die;

					$pooja = $this->db->query("SELECT * FROM `puja` WHERE `name` LIKE '%" . $search_keyword . "%'")->result();
					// echo $this->db->last_query(); die;

					if (count($pooja) > 0) {
						foreach ($pooja as $key) {
							$puja[] = array(
								"id" => $key->id,
								"name" => $key->name,
								"image" => base_url('uploads/puja/') . '/' . $key->image,
								"get_locations" => $this->get_multiple_locations($key->id),
							);
						}
						$response = array("result" => true, "list_s" => $puja);
					} else {
						$response = array("result" => false, "msg" => "not found any puja");
					}
				} else {
					$response = array("result" => false, "msg" => "not found any puja");
				}
				echo json_encode($response);
			}
		}
	}

	public function lat_long_address()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
			$lat = $data['latitude'];
			$long = $data['longitude'];
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $long . "&key=AIzaSyCqaIuorjMaU5R9SWxTKdVYT0eFjSg-XqY",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "",
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
			));
			$response = curl_exec($curl);
			if ($response) {
				$r = json_decode($response, TRUE);
				if ($r['status'] == 'OK') {
					$ADDRESS = $r['results'][0]['address_components'][0]['long_name'] . ', ' . $r['results'][0]['address_components'][1]['long_name'];
					$area = $r['results'][0]['address_components'][4]['long_name'];
					$city = $r['results'][0]['address_components'][6]['long_name'];
					$country = $r['results'][0]['address_components'][8]['long_name'];
					$zip = $r['results'][0]['address_components'][9]['long_name'];
					$state = $r['results'][0]['address_components'][7]['long_name'];


					$response1 = array('status' => true, "address" => $r['results'][0]['formatted_address'], "address_2" => $ADDRESS, "area" => $area, "city" => $city, "country" => $country, "zip" => $zip, "state" => $state);
				} else {
					$response1 = array('status' => false, "message" => "Google api not works");
				}
				echo json_encode($response1);
			}
		}
	}

	// Spuperviso
	public function Signin_supervisor()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->form_validation->set_data($data);
				if ($this->form_validation->run('login') !== false) {
					$result = $this->w_m->signin_supervisor($data);
					echo json_encode($result);
				} else {
					$result =  array('status' => false, 'message' => "some inputs not be blank");
					echo json_encode($result);
				}
			}
		}
	}

	public function get_profile_supervisor()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$query  = $this->db->get_where("supervisor", array("id" => $data['user_id']))->row();
				if (count($query) > 0) {
					$user_details = array(
						"status" => $query->status,
						"user_id" => $query->id,
						"email" => $query->email,
						"name" => $query->name,
						"mobile" => $query->mobile,
						"location" => $query->location
					);

					$response = array("status" => true, "user_details" => $user_details);
				} else {
					$response = array("status" => false, "message" => "No user found of this user_id");
				}
				echo json_encode($response);
			}
		}
	}

	public function home_supervisor()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$date = date('Y-m-d');
				$current_date_time = strtotime(date('Y-m-d H:i:s'));
				$limit_count = 50;
				$limit_from = $data['limit_from'];
				$user_id = $data['user_id'];
				$current_address = '';
				$mother_name = '';
				$father_name = '';
				$family_gotra = '';
				$spouse_name = '';
				$attending_family_name = '';
				$members_name = '';
				$yajman = '';
				$get_location = $this->db->get_where("supervisor", array("id" => $user_id))->row();
				if ($data['condition'] == 'all') {
					$query = "SELECT * FROM `booking` WHERE `supervisor_id` IN (0,$user_id) AND  `booking_location` = '$get_location->location' ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
					$all_list = $this->db->query($query)->result();
					if (count($all_list) > 0) {
						foreach ($all_list as $key) {
							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}




							$accept_power = 0;
							$deny_power = 0;
							$assign_power = 0;
							$ressign_power = 0;
							$booking_status = '';
							$status_line = '';

							//Accept and deny power
							if ($key->status == 0) {
								$status_line = "Yet to start";
								if ($key->booking_time == 'ANY TIME') {
									// if (strtotime($date) <= strtotime($apoint_date))
									// {
									if ($key->supervisor_id == 0) {
										$accept_power = 1;
										$deny_power = 1;
										$assign_power = 0;
										$ressign_power = 0;
										$booking_status = 'Pending';
									} else {
										$booking_status = 'Accepted';
										$accept_power = 0;
										$deny_power = 0;
										if ($key->priest_id == 0) {
											$assign_power = 1;
										} else {
											$ressign_power = 1;
										}
									}
									// }
								} else {
									$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
									$time_remain = 60 * 60 * 1;
									$before_four_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
									// if (time() <= $before_four_hours_date) 
									// {
									if ($key->supervisor_id == 0) {
										$booking_status = 'Pending';
										$accept_power = 1;
										$deny_power = 1;
										$assign_power = 0;
										$ressign_power = 0;
									} else {
										$booking_status = 'Accepted';
										$accept_power = 0;
										$deny_power = 0;
										if ($key->priest_id == 0) {
											$assign_power = 1;
										} else {
											$ressign_power = 1;
										}
									}
									// }
								}

								if ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == 2) {
									$status_line = "Ongoing";
								}
							} elseif ($key->status == 2 || $key->status == 3) {
								$status_line = "Cancelled";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							} elseif ($key->status == 1) {
								$status_line = "Completed";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							} elseif ($key->status == 5) {
								$status_line = "Missed";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							}


							if (!is_null($key->remark)) {
								$remark = $key->remark;
							} else {
								$remark = '';
							}


							$priest_name = '';

							if ($key->supervisor_id != 0 && $key->priest_id != 0) {
								$get_priest_detail = $this->db->get_where("priest", array("id" => $key->priest_id))->row();

								$priest_name = $get_priest_detail->name;
							}

							$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row(); //get_where("pooja",array("id"=>$key->puja_id))->row();

							$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();

							$venue_details = '';

							if (count($get_booking_other_detail) > 0) {
								$current_address = $get_booking_other_detail->current_address;
								$mother_name = $get_booking_other_detail->mother_name;
								$father_name = $get_booking_other_detail->father_name;
								$family_gotra = $get_booking_other_detail->family_gotra;
								$spouse_name = $get_booking_other_detail->spouse_name;
								$attending_family_name = $get_booking_other_detail->attending_family_name;
								$members_name = $get_booking_other_detail->members_name;
								$yajman = $get_booking_other_detail->yajman;
								$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
								if (count($get_venue) > 0) {
									$venue_details = $get_venue->venue_name;
								}
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$imaggess = array();
							if (!is_null($key->images) or !empty($key->images)) {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents/') . '/' . $key2);
								}
							}



							$check_deny_by_supervisor = $this->db->get_where("booking_deny_by_supervisor", array("booking_id" => $key->id, "user_id" => $user_id))->row();
							if (count($check_deny_by_supervisor) > 0) {
								$accept_power = 0;
								$deny_power = 0;
								$assign_power = 0;
								$ressign_power = 0;
								$booking_status = 'Deny';
							}

							$booking_list[] = array(
								"id" => $key->id,
								"booking_id" => 'SHAKTIPEETH' . $key->id,
								"puja_detail" => $get_pooja_detail->name,
								"name" => $key->name,
								"mobile" => $user_detail->phone,
								"gender" => $key->gender,
								"dob" => $key->dob,
								"user_id" => $key->user_id,
								"puja_id" => $key->puja_id,
								"booking_time" => $key->booking_time,
								"booking_date" => $key->booking_date,
								"tob" => $key->tob,
								"pob" => $key->pob,
								"pob_lat" => $key->pob_lat,
								"pob_long" => $key->pob_long,
								"pob_lat_long_address" => $key->pob_lat_long_address,
								"country" => $key->country,
								"remark" => $key->remark,
								"current_address" => $current_address,
								"mother_name" => $mother_name,
								"father_name" => $father_name,
								"family_gotra" => $family_gotra,
								"spouse_name" => $spouse_name,
								"attending_family_name" => $attending_family_name,
								"members_name" => $members_name,
								"venue_id" => $venue_details,
								"yajman" => $yajman,
								"images" => $imaggess,
								"booking_status" => $booking_status,
								"status_line" => $status_line,
								"priest_name" => $priest_name,
								"accept_power" => $accept_power,
								"deny_power" => $deny_power,
								"assign_power" => $assign_power,
								"ressign_power" => $ressign_power,
								"booking_location" => $key->booking_location
							);
						}
						if (!empty($booking_list)) {
							$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from, "user_detail" => $get_location);
						} else {
							$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
						}
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
					}
				} elseif ($data['condition'] == 'pending') {
					$query = "SELECT * FROM `booking` WHERE `supervisor_id` = '0' AND `status`='0' AND  `booking_location` = '$get_location->location' ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
					$all_list = $this->db->query($query)->result();
					if (count($all_list) > 0) {
						foreach ($all_list as $key) {
							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}




							$accept_power = 0;
							$deny_power = 0;
							$assign_power = 0;
							$ressign_power = 0;
							$booking_status = '';
							$status_line = '';

							//Accept and deny power
							if ($key->status == 0) {
								$status_line = "Yet to start";
								if ($key->booking_time == 'ANY TIME') {
									// if (strtotime($date) < strtotime($apoint_date))
									// {
									if ($key->supervisor_id == 0) {
										$accept_power = 1;
										$deny_power = 1;
										$assign_power = 0;
										$ressign_power = 0;
										$booking_status = 'Pending';
									} else {
										$booking_status = 'Accepted';
										$accept_power = 0;
										$deny_power = 0;
										if ($key->priest_id == 0) {
											$assign_power = 1;
										} else {
											$ressign_power = 1;
										}
									}
									// }
								} else {
									$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
									$time_remain = 60 * 60 * 1;
									$before_four_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
									// if (time() <= $before_four_hours_date) 
									// {
									if ($key->supervisor_id == 0) {
										$booking_status = 'Pending';
										$accept_power = 1;
										$deny_power = 1;
										$assign_power = 0;
										$ressign_power = 0;
									} else {
										$booking_status = 'Accepted';
										$accept_power = 0;
										$deny_power = 0;
										if ($key->priest_id == 0) {
											$assign_power = 1;
										} else {
											$ressign_power = 1;
										}
									}
									// }
								}

								if ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == 2) {
									$status_line = "Ongoing";
								}
							} elseif ($key->status == 2 || $key->status == 3) {
								$status_line = "Cancelled";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							} elseif ($key->status == 1) {
								$status_line = "Completed";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							} elseif ($key->status == 5) {
								$status_line = "Missed";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							}


							if (!is_null($key->remark)) {
								$remark = $key->remark;
							} else {
								$remark = '';
							}


							$priest_name = '';

							if ($key->supervisor_id != 0 && $key->priest_id != 0) {
								$get_priest_detail = $this->db->get_where("priest", array("id" => $key->priest_id))->row();

								$priest_name = $get_priest_detail->name;
							}

							$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row();

							$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();

							$venue_details = '';

							if (count($get_booking_other_detail) > 0) {
								$current_address = $get_booking_other_detail->current_address;
								$mother_name = $get_booking_other_detail->mother_name;
								$father_name = $get_booking_other_detail->father_name;
								$family_gotra = $get_booking_other_detail->family_gotra;
								$spouse_name = $get_booking_other_detail->spouse_name;
								$attending_family_name = $get_booking_other_detail->attending_family_name;
								$members_name = $get_booking_other_detail->members_name;
								$yajman = $get_booking_other_detail->yajman;
								$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
								if (count($get_venue) > 0) {
									$venue_details = $get_venue->venue_name;
								}
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$imaggess = array();
							if (!is_null($key->images) or !empty($key->images)) {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents/') . '/' . $key2);
								}
							}



							$check_deny_by_supervisor = $this->db->get_where("booking_deny_by_supervisor", array("booking_id" => $key->id, "user_id" => $user_id))->row();
							if (count($check_deny_by_supervisor) > 0) {
								$accept_power = 0;
								$deny_power = 0;
								$assign_power = 0;
								$ressign_power = 0;
								$booking_status = 'Deny';
							}

							$booking_list[] = array(
								"id" => $key->id,
								"booking_id" => 'SHAKTIPEETH' . $key->id,
								"puja_detail" => $get_pooja_detail->name,
								"name" => $key->name,
								"mobile" => $user_detail->phone,
								"gender" => $key->gender,
								"dob" => $key->dob,
								"user_id" => $key->user_id,
								"puja_id" => $key->puja_id,
								"booking_time" => $key->booking_time,
								"booking_date" => $key->booking_date,
								"tob" => $key->tob,
								"pob" => $key->pob,
								"pob_lat" => $key->pob_lat,
								"pob_long" => $key->pob_long,
								"pob_lat_long_address" => $key->pob_lat_long_address,
								"country" => $key->country,
								"remark" => $key->remark,
								"current_address" => $current_address,
								"mother_name" => $mother_name,
								"father_name" => $father_name,
								"family_gotra" => $family_gotra,
								"spouse_name" => $spouse_name,
								"attending_family_name" => $attending_family_name,
								"members_name" => $members_name,
								"venue_id" => $venue_details,
								"yajman" => $yajman,
								"images" => $imaggess,
								"booking_status" => $booking_status,
								"status_line" => $status_line,
								"priest_name" => $priest_name,
								"accept_power" => $accept_power,
								"deny_power" => $deny_power,
								"assign_power" => $assign_power,
								"ressign_power" => $ressign_power,
								"booking_location" => $key->booking_location
							);
						}
						if (!empty($booking_list)) {
							$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from, "user_detail" => $get_location);
						} else {
							$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
						}
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
					}
				} elseif ($data['condition'] == 'accepted') {
					$query = "SELECT * FROM `booking` WHERE `supervisor_id` = '$user_id' AND  `booking_location` = '$get_location->location' ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
					$all_list = $this->db->query($query)->result();
					if (count($all_list) > 0) {
						foreach ($all_list as $key) {
							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}




							$accept_power = 0;
							$deny_power = 0;
							$assign_power = 0;
							$ressign_power = 0;
							$booking_status = '';
							$status_line = '';

							//Accept and deny power
							if ($key->status == 0) {
								$status_line = "Yet to start";
								if ($key->booking_time == 'ANY TIME') {
									// if (strtotime($date) < strtotime($apoint_date))
									// {
									if ($key->supervisor_id == 0) {
										$accept_power = 1;
										$deny_power = 1;
										$assign_power = 0;
										$ressign_power = 0;
										$booking_status = 'Pending';
									} else {
										$booking_status = 'Accepted';
										$accept_power = 0;
										$deny_power = 0;
										if ($key->priest_id == 0) {
											$assign_power = 1;
										} else {
											$ressign_power = 1;
										}
									}
									// }
								} else {
									$total_appointment_time = strtotime($key->booking_date . ' ' . $key->booking_time);
									$time_remain = 60 * 60 * 1;
									$before_four_hours_date = strtotime($key->booking_date . ' ' . $key->booking_time) - $time_remain;
									// if (time() <= $before_four_hours_date) 
									// {
									if ($key->supervisor_id == 0) {
										$booking_status = 'Pending';
										$accept_power = 1;
										$deny_power = 1;
										$assign_power = 0;
										$ressign_power = 0;
									} else {
										$booking_status = 'Accepted';
										$accept_power = 0;
										$deny_power = 0;
										if ($key->priest_id == 0) {
											$assign_power = 1;
										} else {
											$ressign_power = 1;
										}
									}
									// }
								}

								if ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == 2) {
									$status_line = "Ongoing";
								}
							} elseif ($key->status == 2 || $key->status == 3) {
								$status_line = "Cancelled";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							} elseif ($key->status == 1) {
								$status_line = "Completed";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							} elseif ($key->status == 5) {
								$status_line = "Missed";
								$accept_power = 0;
								$deny_power = 0;
								$ressign_power = 0;
								if ($key->supervisor_id == $user_id) {
									$booking_status = 'Accepted';
								}
							}


							if (!is_null($key->remark)) {
								$remark = $key->remark;
							} else {
								$remark = '';
							}


							$priest_name = '';

							if ($key->supervisor_id != 0 && $key->priest_id != 0) {
								$get_priest_detail = $this->db->get_where("priest", array("id" => $key->priest_id))->row();

								$priest_name = $get_priest_detail->name;
							}

							$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row();

							$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();

							$venue_details = '';

							if (count($get_booking_other_detail) > 0) {
								$current_address = $get_booking_other_detail->current_address;
								$mother_name = $get_booking_other_detail->mother_name;
								$father_name = $get_booking_other_detail->father_name;
								$family_gotra = $get_booking_other_detail->family_gotra;
								$spouse_name = $get_booking_other_detail->spouse_name;
								$attending_family_name = $get_booking_other_detail->attending_family_name;
								$members_name = $get_booking_other_detail->members_name;
								$yajman = $get_booking_other_detail->yajman;
								$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
								if (count($get_venue) > 0) {
									$venue_details = $get_venue->venue_name;
								}
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$imaggess = array();
							if (!is_null($key->images) or !empty($key->images)) {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents/') . '/' . $key2);
								}
							}



							$booking_list[] = array(
								"id" => $key->id,
								"booking_id" => 'SHAKTIPEETH' . $key->id,
								"puja_detail" => $get_pooja_detail->name,
								"name" => $key->name,
								"mobile" => $user_detail->phone,
								"gender" => $key->gender,
								"dob" => $key->dob,
								"user_id" => $key->user_id,
								"puja_id" => $key->puja_id,
								"booking_time" => $key->booking_time,
								"booking_date" => $key->booking_date,
								"tob" => $key->tob,
								"pob" => $key->pob,
								"pob_lat" => $key->pob_lat,
								"pob_long" => $key->pob_long,
								"pob_lat_long_address" => $key->pob_lat_long_address,
								"country" => $key->country,
								"remark" => $key->remark,
								"current_address" => $current_address,
								"mother_name" => $mother_name,
								"father_name" => $father_name,
								"family_gotra" => $family_gotra,
								"spouse_name" => $spouse_name,
								"attending_family_name" => $attending_family_name,
								"members_name" => $members_name,
								"venue_id" => $venue_details,
								"yajman" => $yajman,
								"images" => $imaggess,
								"booking_status" => $booking_status,
								"status_line" => $status_line,
								"priest_name" => $priest_name,
								"accept_power" => $accept_power,
								"deny_power" => $deny_power,
								"assign_power" => $assign_power,
								"ressign_power" => $ressign_power,
								"booking_location" => $key->booking_location
							);
						}
						if (!empty($booking_list)) {
							$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from, "user_detail" => $get_location);
						} else {
							$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
						}
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
					}
				} elseif ($data['condition'] == 'denied') {
					$query = "SELECT * FROM `booking_deny_by_supervisor` WHERE `user_id` = '$user_id' ORDER BY `added_on` DESC LIMIT $limit_from,$limit_count";
					$all_list = $this->db->query($query)->result();
					if (count($all_list) > 0) {
						foreach ($all_list as $key2) {
							$key = $this->db->get_where("booking", array("id" => $key2->booking_id))->row();
							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}




							$accept_power = 0;
							$deny_power = 0;
							$assign_power = 0;
							$ressign_power = 0;
							$booking_status = 'denied';
							$status_line = '';

							if (!is_null($key->remark)) {
								$remark = $key->remark;
							} else {
								$remark = '';
							}

							//Accept and deny power
							if ($key->status == 0) {
								$status_line = "Yet to start";
								if ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == 2) {
									$status_line = "Ongoing";
								}
							} elseif ($key->status == 2 || $key->status == 3) {
								$status_line = "Cancelled";
							} elseif ($key->status == 1) {
								$status_line = "Completed";
							} elseif ($key->status == 5) {
								$status_line = "Missed";
							}

							$priest_name = '';

							$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row();

							$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();

							$venue_details = '';

							if (count($get_booking_other_detail) > 0) {
								$current_address = $get_booking_other_detail->current_address;
								$mother_name = $get_booking_other_detail->mother_name;
								$father_name = $get_booking_other_detail->father_name;
								$family_gotra = $get_booking_other_detail->family_gotra;
								$spouse_name = $get_booking_other_detail->spouse_name;
								$attending_family_name = $get_booking_other_detail->attending_family_name;
								$members_name = $get_booking_other_detail->members_name;
								$yajman = $get_booking_other_detail->yajman;
								$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
								if (count($get_venue) > 0) {
									$venue_details = $get_venue->venue_name;
								}
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$imaggess = array();
							if (!is_null($key->images) or !empty($key->images)) {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents/') . '/' . $key2);
								}
							}



							$booking_list[] = array(
								"id" => $key->id,
								"booking_id" => 'SHAKTIPEETH' . $key->id,
								"puja_detail" => $get_pooja_detail->name,
								"name" => $key->name,
								"mobile" => $user_detail->phone,
								"gender" => $key->gender,
								"dob" => $key->dob,
								"user_id" => $key->user_id,
								"puja_id" => $key->puja_id,
								"booking_time" => $key->booking_time,
								"booking_date" => $key->booking_date,
								"tob" => $key->tob,
								"pob" => $key->pob,
								"pob_lat" => $key->pob_lat,
								"pob_long" => $key->pob_long,
								"pob_lat_long_address" => $key->pob_lat_long_address,
								"country" => $key->country,
								"remark" => $key->remark,
								"current_address" => $current_address,
								"mother_name" => $mother_name,
								"father_name" => $father_name,
								"family_gotra" => $family_gotra,
								"spouse_name" => $spouse_name,
								"attending_family_name" => $attending_family_name,
								"members_name" => $members_name,
								"venue_id" => $venue_details,
								"yajman" => $yajman,
								"images" => $imaggess,
								"booking_status" => $booking_status,
								"status_line" => $status_line,
								"priest_name" => $priest_name,
								"accept_power" => $accept_power,
								"deny_power" => $deny_power,
								"assign_power" => $assign_power,
								"ressign_power" => $ressign_power,
							);
						}
						if (!empty($booking_list)) {
							$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from, "user_detail" => $get_location);
						} else {
							$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
						}
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
					}
				}


				echo json_encode($response);
			}
		}
	}

	public function priest_list()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_id = $data['user_id'];
				$booking_id = isset($data['booking_id']) ? $data['booking_id'] : 0;
				$booking = $this->db->get_where('booking', ['id' => $booking_id])->row();
				$exclude_priest_arr = [];
				if (!empty($booking)) {
					$booking_time = $booking->booking_time;
					$total_minutes = $booking->total_minutes;

					if ($booking_time != 'ANY TIME') {
						$booking_date_time = $booking->booking_date . ' ' . $booking_time;
						$start_time = strtotime($booking_date_time);
						//$booking_endTime = date("Y-m-d H:i:s", strtotime('+'.$total_minutes.' minutes', $start_time));
						$current_date = date('Y-m-d');
						$bookings = $this->db->get_where('booking', ['status' => 0, 'priest_id !=' => 0])->result();
						if (!empty($bookings)) {
							foreach ($bookings as $b) {
								$b_time = $b->booking_time;
								$b_date_time = $b->booking_date . ' ' . $b_time;
								$b_start_time = strtotime($b_date_time);
								$b_total_minutes = $b->total_minutes;
								$b_endTime = date("Y-m-d H:i:s", strtotime('+' . $b_total_minutes . ' minutes', $b_start_time));
								if (($start_time >= $b_start_time) && ($start_time <= strtotime($b_endTime))) {
									$exclude_priest_arr[] = $b->priest_id;
								}
							}
						}
					}
				}
				$get_location = $this->db->get_where("supervisor", array("id" => $user_id))->row();
				if (!empty($exclude_priest_arr)) {
					$this->db->where_not_in('id', $exclude_priest_arr);
				}
				$get_priest_list = $this->db->order_by('name', 'ASC')->get_where("priest", array("status" => 1, "location" => $get_location->location))->result();
				if (count($get_priest_list) > 0) {
					$list = array();
					foreach ($get_priest_list as $key) {
						$list[] = array(
							"priest_id" => $key->id,
							"name" => $key->name
						);
					}
					$response = array("status" => true, "list" => $list);
				} else {
					$response = array("status" => false, "message" => "not found any priest");
				}
				echo json_encode($response);
			}
		}
	}

	public function accept_reject_booking()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$check_if_already_accepted = $this->db->get_where("booking", array("id" => $data['id']))->row();
				if (count($check_if_already_accepted) > 0) {
					if ($check_if_already_accepted->supervisor_id != 0) {
						$response = array("status" => false, "message" => "Already accepted by another supervisor");
					} else {
						if ($data['what'] == '1') {
							$this->db->where("id", $data['id']);
							$this->db->update("booking", array("supervisor_id" => $data['user_id'], "accepted_date" => date('Y-m-d H:i:s')));
							$response = array("status" => true, "message" => "accepted succesfully");
							$this->common_notification($data['id'], 'accepted_by_supervisor');
						} elseif ($data['what'] == '2') {
							$insert = array(
								"user_id" => $data['user_id'],
								"booking_id" => $data['id'],
								"added_on" => date("Y-m-d H:i:s")
							);
							$this->db->insert("booking_deny_by_supervisor", $insert);
							$response = array("status" => true, "message" => "deny succesfully");
						} else {
							$response = array("status" => false, "message" => "what status is not matched according to condtion");
						}
					}
				} else {
					$response = array("status" => false, "message" => "no booking found of this id");
				}
				echo json_encode($response);
			}
		}
	}

	public function assign_booking()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$check_if_already_accepted = $this->db->get_where("booking", array("id" => $data['id']))->row();
				if (count($check_if_already_accepted) > 0) {
					if ($check_if_already_accepted->supervisor_id != 0) {
						$this->db->update("booking", array("priest_id" => $data['priest_id'], "assign_date" => date('Y-m-d H:i:s')));
						$response = array("status" => true, "message" => "accepted succesfully");
						$this->common_notification($data['id'], 'assigned_notification');
					} else {
						$response = array("status" => false, "message" => "Supervisor not accepted this booking");
					}
				} else {
					$response = array("status" => false, "message" => "no booking found of this id");
				}
				echo json_encode($response);
			}
		}
	}

	public function resign_priest()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$get_booking = $this->db->get_where("booking", array("id" => $data['id']))->row();
				if (count($get_booking) > 0) {
					$old_insert = array(
						"booking_id" => $data['id'],
						"superwiser_id" => $get_booking->supervisor_id,
						"priest_id" => $get_booking->priest_id,
						"added_on" => date('Y-m-d H:i:s'),
						"assign_date" => $get_booking->assign_date,
						"from_priest_id" => $data['priest_id']
					);
					$this->db->insert("booking_assign_history", $old_insert);
					$this->db->where("id", $data['id']);
					$this->db->update("booking", array("priest_id" => $data['priest_id'], "accepted_date" => date('Y-m-d H:i:s')));
					$this->common_notification($data['id'], 'reassign_notification', $get_booking->priest_id);
					$response = array("status" => true, "message" => "ressign succesfully");
				} else {
					$response = array("status" => false, "message" => "no booking found");
				}
				echo json_encode($response);
			}
		}
	}

	public function resign_priest_list()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$user_id = $data['user_id'];
				$get_location = $this->db->get_where("supervisor", array("id" => $user_id))->row();
				$get_priest_list = $this->db->order_by('name', 'ASC')->get_where("priest", array("status" => 1, "location" => $get_location->location))->result();
				if (count($get_priest_list) > 0) {
					$get_booking = $this->db->get_where("booking", array("id" => $data['id']))->row();
					$list = array();
					foreach ($get_priest_list as $key) {
						if ($get_booking->priest_id == $key->id) {
						} else {
							$list[] = array(
								"priest_id" => $key->id,
								"name" => $key->name
							);
						}
					}
					$response = array("status" => true, "list" => $list);
				} else {
					$response = array("status" => false, "message" => "not found any priest");
				}
				echo json_encode($response);
			}
		}
	}

	public function logout_superwiser()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = $data['user_id'];
		$device_id = $data['device_id'];
		$this->db->query("UPDATE `supervisor` SET `device_id`='',`device_token`='',`device_type`='' WHERE `id`='$user_id'");
		$insert_array = array(
			"user_id" => $user_id,
			"device_id" => $device_id,
			"added_on" => date('Y-m-d H:i:s')
		);
		$this->db->insert("supervisor_logout_track", $insert_array);
		$response = array("status" => true, "msg" => "logout successfully");
		echo json_encode($response);
	}

	// end super-visor

	//priest 
	public function Signin_priest()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$this->form_validation->set_data($data);
				if ($this->form_validation->run('login') !== false) {
					$result = $this->w_m->signin_priest($data);
					echo json_encode($result);
				} else {
					$result =  array('status' => false, 'message' => "some inputs not be blank");
					echo json_encode($result);
				}
			}
		}
	}

	public function get_profile_priest()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$query  = $this->db->get_where("priest", array("id" => $data['user_id']))->row();
				if (count($query) > 0) {
					$user_details = array(
						"status" => $query->status,
						"user_id" => $query->id,
						"email" => $query->email,
						"name" => $query->name,
						"mobile" => $query->mobile,
						"location" => $query->location
					);

					$response = array("status" => true, "user_details" => $user_details);
				} else {
					$response = array("status" => false, "message" => "No user found of this user_id");
				}
				echo json_encode($response);
			}
		}
	}

	public function home_priest()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$date = date('Y-m-d');
				$current_date_time = strtotime(date('Y-m-d H:i:s'));
				$limit_count = 6;
				$limit_from = $data['limit_from'];
				$user_id = $data['user_id'];
				$current_address = '';
				$mother_name = '';
				$father_name = '';
				$family_gotra = '';
				$spouse_name = '';
				$attending_family_name = '';
				$members_name = '';
				$yajman = '';
				$get_location = $this->db->get_where("priest", array("id" => $user_id))->row();
				if ($data['condition'] == 'all') {
					$query = "SELECT * FROM `booking` WHERE `priest_id` = '$user_id' AND  `booking_location` = '$get_location->location' ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
					$all_list = $this->db->query($query)->result();
					if (count($all_list) > 0) {
						foreach ($all_list as $key) {
							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$status_line = '';

							$video_start = 0;
							$is_chat_or_video_start = 0;
							$chat_g_id_list = 0;
							//Accept and deny power
							if ($key->status == 0) {
								// ONLINE CONSULT LOGIC for start
								if ($key->booking_time != 'ANY TIME') {
									$current_time = time();
									$booking_date_time_list = strtotime($key->booking_date_time);
									$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $key->total_minutes . " minutes", $booking_date_time_list)));

									$key->booking_date_time;
									$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("-10 seconds", $booking_date_time_list)));

									if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
										if ($key->bridge_id !== 0) {
											$video_start = 1;
											$is_chat_or_video_start = $key->is_chat_or_video_start;
											$chat_g_id_list = $key->bridge_id;
										}
									}
								} else {
									$video_start = 1;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = $key->bridge_id;
								}
								$status_line = "Yet to start";
								if ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == 2) {
									$status_line = "Ongoing";
								}
							} elseif ($key->status == 2 || $key->status == 3) {
								$status_line = "Cancelled";
							} elseif ($key->status == 1) {
								$status_line = "Completed";
							} elseif ($key->status == 5) {
								$status_line = "Missed";
							}


							if (!is_null($key->remark)) {
								$remark = $key->remark;
							} else {
								$remark = '';
							}


							$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row();

							$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();

							$venue_details = '';

							if (count($get_booking_other_detail) > 0) {
								$current_address = $get_booking_other_detail->current_address;
								$mother_name = $get_booking_other_detail->mother_name;
								$father_name = $get_booking_other_detail->father_name;
								$family_gotra = $get_booking_other_detail->family_gotra;
								$spouse_name = $get_booking_other_detail->spouse_name;
								$attending_family_name = $get_booking_other_detail->attending_family_name;
								$members_name = $get_booking_other_detail->members_name;
								$yajman = $get_booking_other_detail->yajman;
								$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
								if (count($get_venue) > 0) {
									$venue_details = $get_venue->venue_name;
								}
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$imaggess = array();
							if (!is_null($key->images) && $key->images != '') {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents') . '/' . $key2);
								}
							} elseif ($key->images != '') {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents') . '/' . $key2);
								}
							}



							$booking_list[] = array(
								"id" => $key->id,
								"booking_id" => 'SHAKTIPEETH' . $key->id,
								"puja_detail" => $get_pooja_detail->name,
								"name" => $key->name,
								"mobile" => $user_detail->phone,
								"gender" => $key->gender,
								"dob" => $key->dob,
								"user_id" => $key->user_id,
								"puja_id" => $key->puja_id,
								"booking_time" => $key->booking_time,
								"booking_date" => $key->booking_date,
								"tob" => $key->tob,
								"pob" => $key->pob,
								"pob_lat" => $key->pob_lat,
								"pob_long" => $key->pob_long,
								"pob_lat_long_address" => $key->pob_lat_long_address,
								"country" => $key->country,
								"remark" => $key->remark,
								"current_address" => $current_address,
								"mother_name" => $mother_name,
								"father_name" => $father_name,
								"family_gotra" => $family_gotra,
								"spouse_name" => $spouse_name,
								"attending_family_name" => $attending_family_name,
								"members_name" => $members_name,
								"venue_id" => $venue_details,
								"yajman" => $yajman,
								"images" => $imaggess,
								"status_line" => $status_line,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id_list" => $chat_g_id_list,
								"booking_location" => $key->booking_location
							);
						}
						if (!empty($booking_list)) {
							$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from, "user_detail" => $get_location, "user_detail" => $get_location);
						} else {
							$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location, "user_detail" => $get_location);
						}
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
					}
				} elseif ($data['condition'] == 'cancelled') {
					$query = "SELECT * FROM `booking` WHERE `priest_id` = '$user_id' AND  `booking_location` = '$get_location->location' AND `status` IN ('2','3') ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
					$all_list = $this->db->query($query)->result();
					if (count($all_list) > 0) {
						foreach ($all_list as $key) {
							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$status_line = '';

							//Accept and deny power
							if ($key->status == 0) {
								$status_line = "Yet to start";
							} elseif ($key->status == 2 || $key->status == 3) {
								$status_line = "Cancelled";
							} elseif ($key->status == 1) {
								$status_line = "Completed";
							} elseif ($key->status == 5) {
								$status_line = "Missed";
							}


							if (!is_null($key->remark)) {
								$remark = $key->remark;
							} else {
								$remark = '';
							}


							$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row();

							$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();
							$venue_details = '';

							if (count($get_booking_other_detail) > 0) {
								$current_address = $get_booking_other_detail->current_address;
								$mother_name = $get_booking_other_detail->mother_name;
								$father_name = $get_booking_other_detail->father_name;
								$family_gotra = $get_booking_other_detail->family_gotra;
								$spouse_name = $get_booking_other_detail->spouse_name;
								$attending_family_name = $get_booking_other_detail->attending_family_name;
								$members_name = $get_booking_other_detail->members_name;
								$yajman = $get_booking_other_detail->yajman;
								$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
								if (count($get_venue) > 0) {
									$venue_details = $get_venue->venue_name;
								}
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$imaggess = array();
							if (!is_null($key->images) && $key->images != '') {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents') . '/' . $key2);
								}
							} elseif ($key->images != '') {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents') . '/' . $key2);
								}
							}




							$booking_list[] = array(
								"id" => $key->id,
								"booking_id" => 'SHAKTIPEETH' . $key->id,
								"puja_detail" => $get_pooja_detail->name,
								"name" => $key->name,
								"mobile" => $user_detail->phone,
								"gender" => $key->gender,
								"dob" => $key->dob,
								"user_id" => $key->user_id,
								"puja_id" => $key->puja_id,
								"booking_time" => $key->booking_time,
								"booking_date" => $key->booking_date,
								"tob" => $key->tob,
								"pob" => $key->pob,
								"pob_lat" => $key->pob_lat,
								"pob_long" => $key->pob_long,
								"pob_lat_long_address" => $key->pob_lat_long_address,
								"country" => $key->country,
								"remark" => $key->remark,
								"current_address" => $current_address,
								"mother_name" => $mother_name,
								"father_name" => $father_name,
								"family_gotra" => $family_gotra,
								"spouse_name" => $spouse_name,
								"attending_family_name" => $attending_family_name,
								"members_name" => $members_name,
								"venue_id" => $venue_details,
								"yajman" => $yajman,
								"images" => $imaggess,
								"status_line" => $status_line,
								"booking_location" => $key->booking_location
							);
						}
						if (!empty($booking_list)) {
							$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from, "user_detail" => $get_location);
						} else {
							$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
						}
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
					}
				} elseif ($data['condition'] == 'confirm') {
					$query = "SELECT * FROM `booking` WHERE `priest_id` = '$user_id' AND  `booking_location` = '$get_location->location' AND `status` = '0' ORDER BY `booking_date_time` DESC LIMIT $limit_from,$limit_count";
					$all_list = $this->db->query($query)->result();
					if (count($all_list) > 0) {
						foreach ($all_list as $key) {
							$apoint_date = $key->booking_date;
							if (strtotime($date) <= strtotime($apoint_date)) {
								$diff = strtotime($apoint_date) - strtotime($date);
								$remain_days = round($diff / (60 * 60 * 24));
							} else {
								$remain_days = 0;
							}

							$status_line = '';

							$video_start = 0;
							$is_chat_or_video_start = 0;
							$chat_g_id_list = 0;
							//Accept and deny power
							if ($key->status == 0) {
								// ONLINE CONSULT LOGIC for start
								if ($key->booking_time != 'ANY TIME') {
									$current_time = time();
									$booking_date_time_list = strtotime($key->booking_date_time);
									$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $key->total_minutes . " minutes", $booking_date_time_list)));

									$key->booking_date_time;
									$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("-10 seconds", $booking_date_time_list)));

									if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
										if ($key->bridge_id !== 0) {
											$video_start = 1;
											$is_chat_or_video_start = $key->is_chat_or_video_start;
											$chat_g_id_list = $key->bridge_id;
										}
									}
								} else {
									$video_start = 1;
									$is_chat_or_video_start = $key->is_chat_or_video_start;
									$chat_g_id_list = $key->bridge_id;
								}

								$status_line = "Yet to start";
								if ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == 2) {
									$status_line = "Ongoing";
								}
							} elseif ($key->status == 2 || $key->status == 3) {
								$status_line = "Cancelled";
							} elseif ($key->status == 1) {
								$status_line = "Completed";
							} elseif ($key->status == 5) {
								$status_line = "Missed";
							}


							if (!is_null($key->remark)) {
								$remark = $key->remark;
							} else {
								$remark = '';
							}


							$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$key->puja_id'")->row();

							$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $key->id))->row();
							$venue_details = '';

							if (count($get_booking_other_detail) > 0) {
								$current_address = $get_booking_other_detail->current_address;
								$mother_name = $get_booking_other_detail->mother_name;
								$father_name = $get_booking_other_detail->father_name;
								$family_gotra = $get_booking_other_detail->family_gotra;
								$spouse_name = $get_booking_other_detail->spouse_name;
								$attending_family_name = $get_booking_other_detail->attending_family_name;
								$members_name = $get_booking_other_detail->members_name;
								$yajman = $get_booking_other_detail->yajman;
								$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
								if (count($get_venue) > 0) {
									$venue_details = $get_venue->venue_name;
								}
							}

							$user_detail = $this->db->get_where("user", array("id" => $key->user_id))->row();

							$imaggess = array();
							if (!is_null($key->images) && $key->images != '') {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents') . '/' . $key2);
								}
							} elseif ($key->images != '') {
								$img = explode('|', $key->images);
								foreach ($img as $key2) {
									array_push($imaggess, base_url('uploads/puja_documents') . '/' . $key2);
								}
							}






							$booking_list[] = array(
								"id" => $key->id,
								"booking_id" => 'SHAKTIPEETH' . $key->id,
								"puja_detail" => $get_pooja_detail->name,
								"name" => $key->name,
								"mobile" => $user_detail->phone,
								"gender" => $key->gender,
								"dob" => $key->dob,
								"user_id" => $key->user_id,
								"puja_id" => $key->puja_id,
								"booking_time" => $key->booking_time,
								"booking_date" => $key->booking_date,
								"tob" => $key->tob,
								"pob" => $key->pob,
								"pob_lat" => $key->pob_lat,
								"pob_long" => $key->pob_long,
								"pob_lat_long_address" => $key->pob_lat_long_address,
								"country" => $key->country,
								"remark" => $key->remark,
								"current_address" => $current_address,
								"mother_name" => $mother_name,
								"father_name" => $father_name,
								"family_gotra" => $family_gotra,
								"spouse_name" => $spouse_name,
								"attending_family_name" => $attending_family_name,
								"members_name" => $members_name,
								"venue_id" => $venue_details,
								"yajman" => $yajman,
								"images" => $imaggess,
								"status_line" => $status_line,
								"video_start" => $video_start,
								"is_chat_or_video_start" => $is_chat_or_video_start,
								"chat_g_id_list" => $chat_g_id_list,
								"booking_location" => $key->booking_location
							);
						}
						if (!empty($booking_list)) {
							$response = array("status" => true, "lists" => $booking_list, "limit_from" => $limit_from, "user_detail" => $get_location);
						} else {
							$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
						}
					} else {
						$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
					}
				} else {
					$response = array("status" => false, "message" => "no bookings found", "limit_from" => $limit_from, "user_detail" => $get_location);
				}
				echo json_encode($response);
			}
		}
	}

	public function logout_priest()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$user_id = $data['user_id'];
		$device_id = $data['device_id'];
		$this->db->query("UPDATE `priest` SET `device_id`='',`device_token`='',`device_type`='' WHERE `id`='$user_id'");
		$insert_array = array(
			"user_id" => $user_id,
			"device_id" => $device_id,
			"added_on" => date('Y-m-d H:i:s')
		);
		$this->db->insert("priest_logout_track", $insert_array);
		$response = array("status" => true, "msg" => "logout successfully");
		echo json_encode($response);
	}

	public function priest_user_dynamics()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$is_chat_or_video_start = 0;
			$is_booking = 0;
			$booking_id = 0;
			$channel_name = 0;
			$booking_type_o = 'video';
			$priest_id = '';
			$get_priest_name_ = '';
			$today_date = date('Y-m-d');
			$get_booking = $this->db->query("SELECT * FROM `booking` WHERE `priest_id` = '" . $data['priest_id'] . "' AND `id` = '" . $data['booking_id'] . "' AND  `booking_type` = '1' AND `status` = 0 AND (`is_chat_or_video_start` = '1' or `is_chat_or_video_start` = '2') LIMIT 1")->row();
			if (count($get_booking) > 0) {
				$current_time = time();
				$booking_date_time = strtotime($get_booking->booking_date_time);
				$is_booking = 1;
				$booking_id = $get_booking->id;
				if ($get_booking->bridge_id != '0') {
					$is_chat_or_video_start = $get_booking->is_chat_or_video_start;
					$channel_name = $get_booking->bridge_id;
					$priest_id = $get_booking->priest_id;
					$get_priest_name = $this->db->get_where("priest", array("id" => $priest_id))->row();
					$get_priest_name_ = $get_priest_name->name;
				}
			}
			$response = array("status" => true/*"user_detail"=>$user_detail*/, "is_video_start" => $is_chat_or_video_start, "booking_id" => $booking_id, "channel_name" => $channel_name, "is_booking" => $is_booking, "priest_name" => $get_priest_name_, "booking_type" => $booking_type_o, "priest_id" => $priest_id,);
			echo json_encode($response);
		}
	}

	//end priest

	public function home_user_dynamics()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$is_chat_or_video_start = 0;
			$is_booking = 0;
			$booking_id = 0;
			$channel_name = 0;
			$booking_type_o = 'video';
			$priest_id = '';
			$get_priest_name_ = '';
			$today_date = date('Y-m-d');
			$arr = [];
			$get_booking = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$today_date' AND `booking_time` <> 'ANY TIME' AND `user_id` = '" . $data['user_id'] . "' AND  `booking_type` = '1' AND `status` = 0 AND (`is_chat_or_video_start` = '1' or `is_chat_or_video_start` = '2')")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key => $v) {
					$current_time = time();
					$booking_date_time = strtotime($v->booking_date_time);
					$endTime = strtotime(date('Y-m-d H:i:s', strtotime("+" . $v->total_minutes . " minutes", $booking_date_time)));
					if ($endTime > $current_time) {
						$is_booking = 1;
						$booking_id = $v->id;
						if ($v->bridge_id != '0') {
							$is_chat_or_video_start = $v->is_chat_or_video_start;
							$channel_name = $v->bridge_id;
							$priest_id = $v->priest_id;
							$get_priest_name = $this->db->get_where("priest", array("id" => $priest_id))->row();
							$get_priest_name_ = $get_priest_name->name;

							$pooja = $this->db->get_where('puja', ['id' => $v->puja_id])->row();
							$arr[] = [
								"is_video_start" => $is_chat_or_video_start,
								"puja_name" => $pooja->name ? $pooja->name : '',
								"booking_id" => $booking_id,
								"channel_name" => $channel_name,
								"is_booking" => $is_booking,
								"priest_name" => $get_priest_name_,
								"booking_type" => $booking_type_o,
								"priest_id" => $priest_id
							];
						}
					}
				}
			} else {
				$get_booking = $this->db->query("SELECT * FROM `booking` WHERE `booking_date` = '$today_date' AND `booking_time`= 'ANY TIME' AND `user_id` = '" . $data['user_id'] . "' AND  `booking_type` = '1' AND `status` = 0 AND (`is_chat_or_video_start` = '1' or `is_chat_or_video_start` = '2') ")->result();
				if (count($get_booking) > 0) {
					foreach ($get_booking as $key => $v) {
						# code...
						$is_booking = 1;
						$booking_id = $v->id;
						if ($v->bridge_id != '0') {
							$is_chat_or_video_start = $v->is_chat_or_video_start;
							$channel_name = $v->bridge_id;
							$priest_id = $v->priest_id;
							$get_priest_name = $this->db->get_where("priest", array("id" => $priest_id))->row();
							$get_priest_name_ = $get_priest_name->name;
							$pooja = $this->db->get_where('puja', ['id' => $v->puja_id])->row();
							$arr[] = [
								"is_video_start" => $is_chat_or_video_start,
								"puja_name" => $pooja->name ? $pooja->name : '',
								"booking_id" => $booking_id,
								"channel_name" => $channel_name,
								"is_booking" => $is_booking,
								"priest_name" => $get_priest_name_,
								"booking_type" => $booking_type_o,
								"priest_id" => $priest_id
							];
						}
					}
				}
			}
			// $response = array("status"=>true/*"user_detail"=>$user_detail*/,"is_video_start"=>$is_chat_or_video_start,"booking_id"=>$booking_id,"channel_name"=>$channel_name ,"is_booking"=>$is_booking,"priest_name"=>$get_priest_name_,"booking_type"=>$booking_type_o,"priest_id"=>$priest_id,);

			$response = array("status" => true, "live" => $arr, "is_video_start" => $is_chat_or_video_start, "booking_id" => $booking_id, "channel_name" => $channel_name, "is_booking" => $is_booking, "priest_name" => $get_priest_name_, "booking_type" => $booking_type_o, "priest_id" => $priest_id);

			echo json_encode($response);
		}
	}

	public function start_status_online_consult()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$booking_id = $data['booking_id'];
			$what = $data['what'];
			$from = $data['from'];
			$this->db->query("UPDATE `booking` SET `is_chat_or_video_start` = '$what' WHERE `id`='$booking_id'");
			if ($from == 'priest') {
				$key = $this->db->get_where("booking", array("id" => $booking_id))->row();
				$title1 = "PUJA STARTED BY PRIEST"; //"Your ".$key->online_mode." consultation is started";
				$priest_detail = $this->db->get_where("priest", array("id" => $key->priest_id))->row();
				$message1 = "Your Online Video Puja Session with " . $priest_detail->name . " is starting now at " . date('h:ia');
				$user_detail = $this->w_m->get_user($key->user_id);
				$settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
				$selected_android_user1 = array();
				if ($user_detail->device_type == 'android') {
					if ($user_detail->device_token != 'abc') {
						array_push($selected_android_user1, $user_detail->device_token);
					}
				} elseif ($user_detail->device_type == 'ios') {
					//$this->w_m->send_ios_notification($user_detail->device_token,$message1,$key->booking_mode);
				}
				if (count($selected_android_user1)) {
					$notification_type1 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title1 . '","msg":"' . $message1 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message2 = array(
						'body' => $message1,
						'title' => $title1,
						'sound' => 'default'
					);



					$a = $this->w_m->sendMessageThroughFCM($selected_android_user1, $message2, $settings->firebase_key);
				}

				$this->common_notification($booking_id, 'puja_start');
			}

			echo json_encode(array("status" => true));
		}
	}

	public function online_counsult_timer()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$booking_id = $data['booking_id'];
			$get_detail = $this->db->get_where("booking", array("id" => $booking_id))->row();
			$current_time = time();
			$booking_date_time_list = strtotime($get_detail->booking_date_time);
			$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $get_detail->total_minutes . " minutes", $booking_date_time_list)));
			$booking_date_time_list_minus_30_seconds = strtotime(date('Y-m-d H:i:s', strtotime("+1 seconds", $booking_date_time_list)));
			if ($current_time >= $booking_date_time_list_minus_30_seconds && $current_time <= $endTime_list) {
				if ($get_detail->status == 1) {
					$start_or_end = 0;
				} else {
					$start_or_end = 1;
				}
			} else {
				$start_or_end = 0;
			}

			$response = array("status" => true, "start_or_end" => $start_or_end);
			echo json_encode($response);
		}
	}

	public function force_booking_done_complete_online()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$date = date('Y-m-d');
			$key = $this->db->query("SELECT * FROM `booking` WHERE `id`='" . $data['booking_id'] . "' AND `status` = 0")->row();
			if (count($key) > 0) {
				$date_time = date('Y-m-d H:i:s');
				$get_user_name = $this->w_m->get_user($key->user_id);
				$this->db->query("UPDATE `booking` SET `status` = '1',`complete_date`='$date_time',`is_force_close`='1',`forseclose_by`='" . $data['from'] . "' WHERE `id` = '$key->id'");
				// Notification
				$title1 = "Online puja completed!";
				$message1 = "Your online puja completed successfully - " . date('d M Y', strtotime($key->booking_date)) . ' ' . $key->booking_time . ' with ' . $get_user_name->name;
				$selected_android_user1 = array();
				$priest_detail = $this->db->get_where("priest", array("id" => $key->priest_id))->row();
				$settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');

				if ($priest_detail->device_type == 'android') {
					if ($priest_detail->device_token != 'abc') {
						array_push($selected_android_user1, $priest_detail->device_token);
					}
				} elseif ($priest_detail->device_type == 'ios') {
					$this->send_ios_notification($priest_detail->device_token, $message1, $key->booking_mode);
				}
				if (count($selected_android_user1)) {
					$notification_type1 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title1 . '","msg":"' . $message1 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message2 = array(
						'body' => $message1,
						'title' => $title1,
						'sound' => 'default'
					);

					$a = $this->w_m->sendMessageThroughFCM($selected_android_user1, $message2, $settings->priest_firebase_key);
				}


				// send to patient notification
				$title2 = "Your video consultation completed successfully!";
				$message2 = "Your video consultation completed successfully -" . date('d M Y', strtotime($key->booking_date)) . ' ' . $key->booking_time . ' with ' . $priest_detail->name;
				$selected_android_user2 = array();
				if ($get_user_name->device_type == 'android') {
					if ($get_user_name->device_token != 'abc') {
						array_push($selected_android_user2, $get_user_name->device_token);
					}
				} elseif ($get_user_name->device_type == 'ios') {
					$this->send_ios_notification($get_user_name->device_token, $message2, $key->booking_mode);
				}
				if (count($selected_android_user2)) {
					$notification_type2 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type2 . '","title":"' . $title2 . '","msg":"' . $message2 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message3 = array(
						'body' => $message2,
						'title' => $title2,
						'sound' => 'default'
					);

					$a = $this->w_m->sendMessageThroughFCM($selected_android_user2, $message3, $settings->firebase_key);
				}
				$this->send_invoice_temp($data['booking_id'], 'Booking completed!', 'complete');

				$response = array("status" => true, "message" => "done");
			} else {
				$response = array("status" => false, "message" => "no booking found");
			}
			echo json_encode($response);
		}
	}

	// Complete Booking status of online change
	public function booking_done_complete_online()
	{
		$date = date('Y-m-d');
		for ($i = 0; $i < 30; ++$i) {
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_booking = $this->db->query("SELECT * FROM `booking` WHERE booking_date = '$date' AND `booking_time` <> 'ANY TIME' AND `status` = 0")->result();
			if (count($get_booking) > 0) {
				foreach ($get_booking as $key) {
					$current_time = time();
					$booking_date_time_list = strtotime($key->booking_date_time);
					$endTime_list = strtotime(date('Y-m-d H:i:s', strtotime("+" . $key->total_minutes . " minutes", $booking_date_time_list)));
					$endTime_list_5seconds = strtotime(date('Y-m-d H:i:s', strtotime("+1 second", $endTime_list)));
					if ($current_time > $endTime_list) {
						// echo 1;
						$get_user_name = $this->w_m->get_user($key->user_id);
						if ($key->is_chat_or_video_start == 2 || $key->is_chat_or_video_start == '2') {
							$status = 1;
							$method = 'completed_booking';
							$this->send_invoice_temp($key->id, 'Booking completed!', 'complete');
						} elseif ($key->is_chat_or_video_start == 1 || $key->is_chat_or_video_start == '1') {
							$status = 1;
							$method = 'completed_booking';
							$this->send_invoice_temp($key->id, 'Booking completed!', 'complete');
						} else {
							$status = 5;
							$method = 'missed_booking';
						}
						$completed_on = date('Y-m-d H:i:s');
						$this->db->query("UPDATE `booking` SET `complete_on`='" . $completed_on . "', `status` = '" . $status . "' WHERE `id` = '$key->id'");
						$this->common_notification($key->id, $method, $completed_on);
					}
				}
			}
			sleep(1);
		}
	}


	//notification region
	public function common_notification($id, $method, $completed_on = '')
	{
		$url = base_url('notification_to/common_notification');
		$curl = curl_init();
		$post['id'] = $id; // our data todo in received
		$post['method'] = $method; // our data todo in received
		$post['completed_on'] = $completed_on; // our data todo in received
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
		return true;
	}


	//end notification regios


	public function upload_prescription_test()
	{
		$booking_id = 1;
		$get = $this->db->get_where("booking", array("id" => $booking_id))->row();
		if (count($get) > 0) {
			$pdf_data = array();
			$orderNum = 1121212;

			$pdf_data['prescription_dignosis'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //$data['prescription_dignosis'];
			$pdf_data['prescription_genral_advice'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //$data['prescription_genral_advice'];
			$pdf_data['genral_investigation'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //$data['genral_investigation'];
			$pdf_data['special_instruction'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //!empty($data['special_instruction']) ? $data['special_instruction'] : '';
			$pdf_data['medicine'] = '[{"drug_name":"hu","dossage":"10","duration":"5","repeat":"everyday","time_of_day":"morning","to_be_take":"after"},{"drug_name":"hu","dossage":"10","duration":"5","repeat":"everyday","time_of_day":"morning","to_be_take":"after"}]'; //$data['medicine'];//!empty($data['medicine']) ? json_encode($data['medicine']) : '';

			//$pdf_data['medicine'] = !empty($data['medicine']) ? json_encode($data['medicine']) : '';


			$this->load->library('Pdf');
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('EASEMYMED');
			$pdf->SetTitle('Prescription');
			//$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			//$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->SetFont('dejavusans', '', 10);
			$pdf->AddPage();
			$htmlcode = $this->load->view('invoice/pdf3', $pdf_data, TRUE);
			$pdf->writeHTML($htmlcode, true, false, true, false, '');
			$newFile  = FCPATH . "/uploads/invoices/" . $orderNum . '-invoice.pdf';
			//ob_clean();
			$pdf->Output($newFile, 'F');
			$pdffname = $orderNum . '-invoice.pdf';
			// $user_detail = $this->db->get_where("user", array("id" => $get->user_id))->row();
			// $email = $user_detail->email;
			// $settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
			// $bccemail = '';
			// $bccname = '';
			// if ($get->booking_for != 'self') {
			// 	$user_member_detail = $this->db->get_where("user_member", array("id" => $get->member_id))->row();
			// 	$bccemail = $user_member_detail->email;
			// 	$bccname = $user_member->member_name;
			// }
			// $subject = "Appointment with " . $pdf_data['doctor_firstname'] . " for " . $pdf_data['booking_date'] . " at " . $pdf_data['booking_time'] . " uploaded the prescription";
			// $sum_total = 1000; //$detail_s->total_amount + $detail_s->wallet_amount + $detail_s->referral_amount + $detail_s->discount_amount;

			//$sms_message = "Prescription uploaded send to your registered email.[Online Counsult] Appointment ID:EASEMYMED-".$detail_s->id." for ".$booking_date.','.$booking_time." with ".$get_doc_detail->doctor_firstname;
			// $fil_package_deatils = "/uploads/prescription/doctor_prescription/" . $pdffname;
			// if (isset($email)) {
			// 	//$this->w_m->check_curl($email, $subject, $htmlcode, $pdf_data['name'], $bccemail, $bccname, $fil_package_deatils);
			// }

			// $response = array("status" => true, "message" => "added successfully", "pdf_url" => base_url() . $fil_package_deatils);
		}
	}

	public function upload_prescription_tes1t()
	{
		$booking_id = 1;
		$get = $this->db->get_where("booking", array("id" => $booking_id))->row();
		if (count($get) > 0) {
			// $pdf_data = array();
			$orderNum = 1121212;

			$pdf_data['prescription_dignosis'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //$data['prescription_dignosis'];
			$pdf_data['prescription_genral_advice'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //$data['prescription_genral_advice'];
			$pdf_data['genral_investigation'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //$data['genral_investigation'];
			$pdf_data['special_instruction'] = 'LOrem IpsumLOrem IpsumLOrem IpsumLOrem IpsumLOrem Ipsum'; //!empty($data['special_instruction']) ? $data['special_instruction'] : '';
			$pdf_data['medicine'] = '[{"drug_name":"hu","dossage":"10","duration":"5","repeat":"everyday","time_of_day":"morning","to_be_take":"after"},{"drug_name":"hu","dossage":"10","duration":"5","repeat":"everyday","time_of_day":"morning","to_be_take":"after"}]'; //$data['medicine'];//!empty($data['medicine']) ? json_encode($data['medicine']) : '';

			//$pdf_data['medicine'] = !empty($data['medicine']) ? json_encode($data['medicine']) : '';
			$this->load->view('invoice/check', $pdf_data);
		}
	}

	public function send_invoice_temp($booking_id = '', $sub, $condition)
	{
		$get = $this->db->get_where("booking", array("id" => $booking_id))->row();
		if (count($get) > 0) {
			$get_pooja_detail = $this->db->query("SELECT a.`id`,b.`name` FROM `puja_location_table` a JOIN `puja` b ON b.id = a.puja_id WHERE a.`id` = '$get->puja_id'")->row();
			$get_booking_other_detail = $this->db->get_where("booking_other_details", array("booking_id" => $get->id))->row();
			$venue_details = '';
			if (count($get_booking_other_detail) > 0) {
				$get_venue = $this->db->get_where("puja_venue_table", array("id" => $get_booking_other_detail->venue_id))->row();
				if (count($get_venue) > 0) {
					$venue_details = $get_venue->venue_name;
				}
			}
			$pdf_data = array();
			$pdf_data['puja_name'] = $get_pooja_detail->name;
			$pdf_data['location_name'] = $get->booking_location;
			$pdf_data['status'] = $get->status;

			$pdf_data['booking_date'] = date('d/m/Y', strtotime($get->booking_date));
			$pdf_data['booking_time'] = $get->booking_time;
			$pdf_data['end_time'] = '';
			$pdf_data['total_amount'] = $get->total_amount;
			if ($get->booking_time != 'ANY TIME') {
				$pdf_data['end_time'] = '';

				if ($condition == 'cancel') {
					$current_time = time();
					$booking_date_time_list = strtotime($get->booking_date . ' ' . $get->booking_time);
					$twenty_four_hours = strtotime(date('Y-m-d H:i:s', strtotime("-1440 minutes", $booking_date_time_list)));
					$twelve_hours = strtotime(date('Y-m-d H:i:s', strtotime("-720 minutes", $booking_date_time_list)));
					if ($current_time < $twelve_hours && $current_time > $twenty_four_hours) {
						$pdf_data['total_amount'] = 50 / 100 * $pdf_data['total_amount'];
					} elseif ($twenty_four_hours > $current_time) {
						$pdf_data['total_amount'] = 10 / 100 * $pdf_data['total_amount'];
					}
				}
			} else {
				if ($condition == 'cancel') {
					$current_time = time();
					$booking_date_time_list = strtotime($get->booking_date);
					$twenty_four_hours = strtotime(date('Y-m-d H:i:s', strtotime("-1440 minutes", $booking_date_time_list)));
					$twelve_hours = strtotime(date('Y-m-d H:i:s', strtotime("-720 minutes", $booking_date_time_list)));
					if ($twenty_four_hours > $current_time) {
						//10%
						$pdf_data['total_amount'] = 10 / 100 * $pdf_data['total_amount'];
					} elseif ($twenty_four_hours > $current_time) {
						$pdf_data['total_amount'] = 10 / 100 * $pdf_data['total_amount'];
					}
				}
			}
			$pdf_data['total_amount'] = number_format((float)$pdf_data['total_amount'], 2, '.', '');
			$pdf_data['venue_details'] = $venue_details;
			$pdf_data['unit_Price'] = $get->total_amount - $get->tax_amount;
			$pdf_data['qty'] = 1;
			$pdf_data['tax_amount'] = $get->tax_amount;
			$pdf_data['order_number'] = 'KOL' . $get->id;
			$pdf_data['order_date'] = date('d/m/Y', strtotime($get->added_on));
			$pdf_data['time'] = date('h:i:s', strtotime($get->added_on));
			$pdf_data['invoice_order_date'] = date('d/m/Y');
			$pdf_data['invoice_time'] = date('h:i:s');
			$pdf_data['name'] = $get->name;
			$f = explode(',', $get->pob_lat_long_address);
			$pdf_data['word_rs'] = $this->intowords($pdf_data['total_amount']);
			$pdf_data['city'] = '';
			$pdf_data['state'] = '';
			$pdf_data['country'] = '';
			if (count($f) > 0) {
				if (isset($f[0])) {
					$pdf_data['city'] = $f[0];
				}
				if (isset($f[1])) {
					$pdf_data['state'] = $f[1];
				}
				if (isset($f[2])) {
					$pdf_data['country'] = $f[2];
				}
			}


			$this->load->library('Pdf');
			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('SHAKTIPEETH');
			$pdf->SetTitle('Invoice');
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->SetFont('dejavusans', '', 10);
			$pdf->AddPage();
			$htmlcode = $this->load->view('invoice/pdf4', $pdf_data, TRUE);
			$pdf->writeHTML($htmlcode, true, false, true, false, '');
			$pdffname = $pdf_data['order_number'] . date('d-m-y-h-i-s') . '-invoice.pdf';
			$newFile  = FCPATH . "/uploads/invoices/" . $pdffname;
			//ob_clean();
			$pdf->Output($newFile, 'F');

			$user_detail = $this->db->get_where("user", array("id" => $get->user_id))->row();
			$email = $user_detail->email;
			$settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');
			$subject = $sub;
			//$sum_total = 1000; //$detail_s->total_amount + $detail_s->wallet_amount + $detail_s->referral_amount + $detail_s->discount_amount;

			//$sms_message = "Prescription uploaded send to your registered email.[Online Counsult] Appointment ID:EASEMYMED-".$detail_s->id." for ".$booking_date.','.$booking_time." with ".$get_doc_detail->doctor_firstname;
			if ($condition == 'cancel') {
				$array_ = array("cancel_invoice" => $pdffname, "cancel_date" => date('Y-m-d H:i:s'));
				$this->db->where("booking_id", $booking_id);
				$this->db->update("booking_other_details", $array_);
			} else {
				$array_ = array("complete_booking_invoice" => $pdffname, "complete_booking_date" => date('Y-m-d H:i:s'));
				$this->db->where("booking_id", $booking_id);
				$this->db->update("booking_other_details", $array_);
			}

			$fil_package_deatils = "/uploads/invoices/" . $pdffname;
			if (isset($email)) {
				$htmlcode = 'Invoice for Shaktipeeth';
				$this->w_m->check_curl($email, $subject, $htmlcode, $pdf_data['name'], '', '', $fil_package_deatils);
			}
		}
	}

	// public function intowords($number)
	// {
	// 	$no = floor($number);
	//     $point = round($number - $no, 2) * 100;
	//     $hundred = null;
	//     $digits_1 = strlen($no);
	//     $i = 0;
	//     $str = array();
	//     $words = array('0' => '', '1' => 'one', '2' => 'two',
	//     '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
	//     '7' => 'seven', '8' => 'eight', '9' => 'nine',
	//     '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
	//     '13' => 'thirteen', '14' => 'fourteen',
	//     '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
	//     '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
	//     '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
	//     '60' => 'sixty', '70' => 'seventy',
	//     '80' => 'eighty', '90' => 'ninety');
	//     $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
	//     while ($i < $digits_1) {
	//      $divider = ($i == 2) ? 10 : 100;
	//      $number = floor($no % $divider);
	//      $no = floor($no / $divider);
	//      $i += ($divider == 10) ? 1 : 2;
	//      if ($number) {
	//         $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
	//         $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
	//         $str [] = ($number < 21) ? $words[$number] .
	//             " " . $digits[$counter] . $plural . " " . $hundred
	//             :
	//             $words[floor($number / 10) * 10]
	//             . " " . $words[$number % 10] . " "
	//             . $digits[$counter] . $plural . " " . $hundred;
	//      } else $str[] = null;
	//     }
	//     $str = array_reverse($str);
	//     $result = implode('', $str);
	//     $points = ($point) ?
	//     "." . $words[$point / 10] . " " . 
	//           $words[$point = $point % 10] : '';
	//     return $result . "Rupees  and ".$points." Paise";
	// }

	public function intowords($number)
	{
		$no = floor($number);
		$point = round($number - $no, 2) * 100;
		$point = number_format((float)$point, 2, '.', '');
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array(
			'0' => '', '1' => 'one', '2' => 'two',
			'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
			'7' => 'seven', '8' => 'eight', '9' => 'nine',
			'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
			'13' => 'thirteen', '14' => 'fourteen',
			'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
			'18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
			'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
			'60' => 'sixty', '70' => 'seventy',
			'80' => 'eighty', '90' => 'ninety'
		);
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += ($divider == 10) ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str[] = ($number < 21) ? $words[$number] .
					" " . $digits[$counter] . $plural . " " . $hundred
					:
					$words[floor($number / 10) * 10]
					. " " . $words[$number % 10] . " "
					. $digits[$counter] . $plural . " " . $hundred;
			} else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$second_str = '';
		if ($point > 0) {
			$points = ($point) ? "and " . $words[$point / 100] . " " . $words[$point = $point % 100] : '';
			$second_str = $points . " paise";
		}

		return ucfirst($result) . "rupees  " . $second_str;
	}

	public function check_if_priest_have_booking($json, $booking_time)
	{
		if (empty($json)) {
			return true;
		}
		// $current_time = time();
		$obj = json_decode($json);
		$dayname = strtolower(date('D'));
		foreach ($obj as $k => $val) {
			if (strtolower($val->day) == $dayname) {

				foreach ($val->slots as $s) {
					$s->start = strtotime(date('Y-m-d') . " " . $s->start);
					$s->end = strtotime(date('Y-m-d') . " " . $s->end);
					if ($booking_time >= $s->start && $booking_time <= $s->end) {
						return true;
					}
				}
			}
		}
		return false;
	}

	public function reasons()
	{
		$d = $this->db->get("master_complain_reason")->result();
		if (count($d) > 0) {
			$response = array("status" => true, "res" => $d);
		} else {
			$response = array("status" => false);
		}
		echo json_encode($response);
	}

	public function priest_side_complete()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			$date = date('Y-m-d');
			$key = $this->db->query("SELECT * FROM `booking` WHERE `id`='" . $data['booking_id'] . "' AND `status` = 0")->row();
			if (count($key) > 0) {
				$date_time = date('Y-m-d H:i:s');
				$get_user_name = $this->w_m->get_user($key->user_id);
				$this->db->query("UPDATE `booking` SET `status` = '1',`complete_date`='$date_time',`is_force_close`='1',`forseclose_by`='" . $data['from'] . "' , `reason_id`='" . $data['reason_id'] . "' WHERE `id` = '$key->id'");
				// Notification
				$title1 = "Online puja completed!";
				$message1 = "Your online puja completed successfully - " . date('d M Y', strtotime($key->booking_date)) . ' ' . $key->booking_time . ' with ' . $get_user_name->name;
				$selected_android_user1 = array();
				$priest_detail = $this->db->get_where("priest", array("id" => $key->priest_id))->row();
				$settings = $this->w_m->global_multiple_query('settings', array('id' => 1), 'row()');

				if ($priest_detail->device_type == 'android') {
					if ($priest_detail->device_token != 'abc') {
						array_push($selected_android_user1, $priest_detail->device_token);
					}
				} elseif ($priest_detail->device_type == 'ios') {
					$this->send_ios_notification($priest_detail->device_token, $message1, $key->booking_mode);
				}
				if (count($selected_android_user1)) {
					$notification_type1 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type1 . '","title":"' . $title1 . '","msg":"' . $message1 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message2 = array(
						'body' => $message1,
						'title' => $title1,
						'sound' => 'default'
					);

					$a = $this->w_m->sendMessageThroughFCM($selected_android_user1, $message2, $settings->priest_firebase_key);
				}


				// send to patient notification
				$title2 = "Your video consultation completed successfully!";
				$message2 = "Your video consultation completed successfully -" . date('d M Y', strtotime($key->booking_date)) . ' ' . $key->booking_time . ' with ' . $priest_detail->name;
				$selected_android_user2 = array();
				if ($get_user_name->device_type == 'android') {
					if ($get_user_name->device_token != 'abc') {
						array_push($selected_android_user2, $get_user_name->device_token);
					}
				} elseif ($get_user_name->device_type == 'ios') {
					$this->send_ios_notification($get_user_name->device_token, $message2, $key->booking_mode);
				}
				if (count($selected_android_user2)) {
					$notification_type2 = "text";
					$respJson1 = '{"notification_type":"' . $notification_type2 . '","title":"' . $title2 . '","msg":"' . $message2 . '","type":"no"}';
					//$message = array("m" => $respJson, "click_action"=>"SecondActivity");
					$message3 = array(
						'body' => $message2,
						'title' => $title2,
						'sound' => 'default'
					);

					$a = $this->w_m->sendMessageThroughFCM($selected_android_user2, $message3, $settings->firebase_key);
				}
				$this->send_invoice_temp($data['booking_id'], 'Booking completed!', 'complete');

				$response = array("status" => true, "message" => "done");
			} else {
				$response = array("status" => false, "message" => "no booking found");
			}
			echo json_encode($response);
		}
	}

	public function astrology_classes()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		if (isset($data) && !empty($data)) {
			// Live classses module
			$query = "SELECT `is_start`,`id`, `class_name`, `date`, `time`, `channel_name`, `added_on`, `status` FROM `astrology_classes` WHERE `status` = '1' ORDER BY `added_on`";
			$all_list = $this->db->query($query)->result();
			if (count($all_list) > 0) {
				$check_user_have_active_package = $this->db->get_where("class_package_history", array("user_id" => $data['user_id'], "status" => 1))->result();
				if (count($check_user_have_active_package) > 0) {
					$live_ = array();
					$expert_details = $this->db->get_where('expert_management', array("id" => $all_list->expert_id))->row();
					foreach ($all_list as $key) {
						$is_start = 0;
						if ($key->is_start == 1) {
							$is_start = 1;
						}
						$live_[] = array("session_id" => $key->channel_name, "chat_id" => 'g' . $key->id, "date" => $all_list->date, "time" => $all_list->time, "class_name" => $all_list->class_name, "is_start" => $is_start);
					}

					$live_details = array("status" => true, "expert_id" => $all_list->expert_id, "name" => $expert_details->name, "list" => $live_);
				} else {
					$live_details = array("status" => false);
				}
			} else {
				$live_details = array("status" => false);
			}

			echo json_encode($live_details);
		}
	}



	/*Ropeway start*/
	public function Ropeway()
	{
		$AUTH = $this->db->where('key', md5($this->input->get_request_header('HTTP_X_API_KEY')))
			->get('restapi_keys')
			->result_array();
		if (!$AUTH) {
			$this->fail_auth();
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			if (isset($data) && !empty($data)) {
				$puja = array();
				if (isset($data['sort'])) {
					if ($data['sort'] == 'A to Z') {
						$r2 = $this->db->query("SELECT * FROM `puja` WHERE `status` = '1' ORDER BY `name` ASC")->result();
					} elseif ($data['sort'] == 'Z to A') {
						$r2 = $this->db->query("SELECT * FROM `puja` WHERE `status` = '1' ORDER BY `name` DESC")->result();
					} else {
						$r2 = $this->db->order_by('position', 'ASC')->get_where("puja", array("status" => 1))->result();
					}
				} else {
					$r2 = $this->db->order_by('title', 'ASC')->get_where("ropeway", array("status" => 1))->result();
				}
				if (count($r2) > 0) {
					foreach ($r2 as $key4) {
						$ropeway[] = array(
							"id" => $key4->id,
							"name" => $key4->name,
							"image" => base_url('uploads/puja/') . '/' . $key4->image,
						);
					}
				}
				$response = array("status" => true, "ropeway" => $ropeway, "user_detail" => $user_detail, "get_Settings" => $get_Settings); //"live_details"=>$live_details,"tax_details"=>$tax);
				echo json_encode($response);
			}
		}
	}


	public function FunctionName($value = '')
	{
		$data = '2020-11-19 09:36:43';
		$dq = strtotime($data);
		$d1_ = $dq + 5;
		echo date('Y-m-d H:i:s', $d1_);
	}
	/*Ropeway end start*/

	public function image_attchment_upload()
	{
		$target_path = "assets/uploads/chat_file/";
		$target_dir = "assets/uploads/chat_file/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		if (is_array($_FILES)) {
			// echo json_encode($_FILES);
			// die;
			// $type = '';
			// if ($_FILES["image"]["type"] == 'image/png') 
			// {
			// 	$type = 'image';
			// }
			// elseif ($_FILES["image"]["type"] == 'image/jpeg') 
			// {
			// 	$type = 'image';
			// }
			// elseif ($_FILES["image"]["type"] == 'application/pdf') 
			// {
			// 	$type = 'pdf';
			// }
			// elseif ($_FILES["image"]["type"] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') 
			// {
			// 	$type = 'docs';
			// }
			// if ($type != '') 
			// {
			// 	$imagename = basename($_FILES["image"]["name"]);
			// 	$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
			// 	$actual_image_name = time().".".$extension;
			// 	move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
			// 	if(!empty($actual_image_name))
			// 	{
			// 		$res=[
			// 			"status"=>true,
			// 			"path"=>base_url('assets/uploads/chat_file/').'/'.$actual_image_name
			// 		];

			// 		echo json_encode($res);
			// 		return;
			// 	}
			// }


			$imagename = basename($_FILES["image"]["name"]);
			$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
			$actual_image_name = time() . "." . $extension;
			move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
			if (!empty($actual_image_name)) {
				$res = [
					"status" => true,
					"path" => base_url('assets/uploads/chat_file/') . '/' . $actual_image_name
				];

				echo json_encode($res);
				return;
			}
		}
	}



	public function astrologer_chat_history()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$astrologer_id = $data['astrologer_id'];

		$this->db->limit(100);
		$this->db->order_by('id', 'desc');
		$this->db->where('type', 3);
		$this->db->where('assign_id', $astrologer_id);
		$this->db->where_in('status', [0, 1, 2]);
		$results = $this->db->get('bookings')->result();
		$new_arr = [];
		foreach ($results as $r) {
			$this->db->select('id,name,image,email,phone');
			$user = $this->db->get_where('user', ['id' => $r->user_id])->row();
			$user->image_url = base_url('uploads/user/') . '/' . $user->image;
			$r->user_details = $user;

			$this->db->select('id,name,image,email,phone');
			$astrologer = $this->db->get_where('astrologers', ['id' => $r->assign_id])->row();
			$astrologer->image_url = base_url('uploads/astrologers/') . '/' . $astrologer->image;

			$r->astrologer_details = $astrologer;
			$new_arr[] = $r;
		}

		echo json_encode([
			'status' => true,
			'data' => $new_arr
		]);
	}


	public function astrologer_live_history()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$astrologer_id = $data['astrologer_id'];
		$new_arr = [];
		$this->db->where('astrologer_id', $astrologer_id);
		$this->db->order_by('id', 'desc');
		$res = $this->db->get('broadcasts')->result();
		if (!empty($res)) {
			foreach ($res as $r) {
				$earn_data = $this->db->query("SELECT SUM(astrologer_comission_amount) as comission FROM `bookings` WHERE `status` = '2' AND type=5 AND bridge_id='" . $r->bridge_id . "'")->row();
				if ($earn_data) {
					$r->astrologer_comission_amount = $earn_data->comission ? $earn_data->comission : 0;
				} else {
					$r->astrologer_comission_amount = 0;
				}
				$new_arr[] = $r;
			}
		}


		echo json_encode([
			'status' => true,
			'data' => $new_arr
		]);
	}


	public function total_unread_reports()
	{
		# code...
		$data = json_decode(file_get_contents('php://input'), true);
		$astrologer_id = $data['astrologer_id'];
		$this->db->where_in('status', [0, 1]);
		$c = $this->db->get_where('bookings', ['type' => 4, 'assign_id' => $astrologer_id, 'booking_type' => 2])->result();
		$rest = count($c);
		echo json_encode(['status' => true, 'data' => $rest]);
	}
}	// Prescription for Video document uploads by doctor
