<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Banner_ctrl extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Banner_model');
		$this->load->helper('directory');
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
	}

	// website_banner

	public function website_banner()
	{
		// print_r("expression"); die;
		$template['page'] = "Bannerdetails/view_website_banner";
		$template['page_title'] = "View Website Banner";
		$template['data'] = $this->db->query("select * from website_banner")->result();
		$this->load->view('template', $template);
	}


	public function add_website_banner()
	{
		$template['page'] = "Bannerdetails/add_website_banner";
		$template['page_title'] = "Add Website banner";
		$this->load->view('template', $template);
	}

	public function edit_website_banner()
	{
		if ($_POST) {
			$id = $this->input->post("id");
			// print_r($id); die;
			$old_img = $this->input->post('image11');
			if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
				$config['upload_path'] = 'uploads/banner/website/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				$imageUpload = '';
				if (!$this->upload->do_upload('image')) {
					$display_image = $old_img;
					$error = array(
						'error' => $this->upload->display_errors()
					);
				} else {
					$imageUpload = $this->upload->data();
					$display_image = $imageUpload['file_name'];
				}
			} else {
				$display_image = $old_img;
			}


			$data1 = array(
				"image" => $display_image,
				"position" => $this->input->post("position"),
				"status" => $this->input->post("status"),
				"name" => $this->input->post("name"),

			);
			//print_r($data1); die;
			$s = $this->update_website_banner_status('website_banner', $id, $data1);

			redirect(base_url('Banner_ctrl/website_banner/'));
		} else {
			$id = htmlentities(trim($this->uri->segment(3)));
			$template['data'] = $this->db->query("select * from website_banner where id = $id")->row();
			// print_r($template['data']); die;
			$template['page'] = "Bannerdetails/edit_website_banner";
			$template['page_title'] = "Add Patient banner";
			$this->load->view('template', $template);
		}
	}
	public function insert_website_banner()
	{
		//print_r($_FILES);
		if ($_POST) {
			$target_path = "uploads/banner/website/";
			$target_dir = "uploads/banner/website/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$data['image'] = $actual_image_name;
					$data['position'] = $this->input->post("position");
					$data['status'] = $this->input->post("status");
					$data['name'] = $this->input->post("name");
					$result =  $this->db->insert('website_banner', $data);
					$this->session->set_flashdata('message', array('message' => 'Add Website Banner Details successfully', 'class' => 'success'));
					redirect(base_url('Banner_ctrl/website_banner/'));
				} else {
					$template['page'] = "Bannerdetails/add_website_banner";
					$template['page_title'] = "Add Website_banner";
					$this->load->view('template', $template);
				}
			} else {
				$template['page'] = "Bannerdetails/add_website_banner";
				$template['page_title'] = "Add website banner";
				$this->load->view('template', $template);
			}
		}
	}
	public function delete_website_banner()
	{

		$id = $this->uri->segment(3);
		$image_url = $this->Banner_model->get_row('website_banner', array('id' => $id));

		if ($image_url) {
			$img = $image_url->image;
		}

		$result = $this->website_banner_delete($id, $img);

		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/website_banner');
	}

	public function website_banner_status()
	{

		$data1 = array(
			"status" => '0'
		);
		$id = $this->uri->segment(3);
		$s = $this->update_website_banner_status('website_banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Disabled', 'class' => 'warning'));
		redirect(base_url() . 'banner_ctrl/website_banner');
	}
	public function website_banner_active()
	{

		$data1 = array(
			"status" => '1'
		);
		$id = $this->uri->segment(3);
		$s = $this->update_website_banner_status('website_banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Enabled', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/website_banner');
	}


	public function update_website_banner_status($table, $data, $data1)
	{
		$this->db->where('id', $data);
		$result = $this->db->update($table, $data1);
		return $result;
	}


	public function website_banner_delete($id, $img)
	{


		$this->db->where('id', $id);
		$result = $this->db->delete('website_banner');
		if ($result) {
			unlink('./uploads/banner/website' . '/' . $img);
			return "success";
		} else {
			return "error";
		}
	}



	//end WEbsite

	// website_advertisment

	public function website_advertisment()
	{
		// print_r("expression"); die;
		$template['page'] = "advertisment/view_website_advertisment";
		$template['page_title'] = "View Website Banner";
		$template['data'] = $this->db->query("select * from advertisment")->result();
		$this->load->view('template', $template);
	}


	public function add_website_advertisment()
	{
		$template['page'] = "advertisment/add_website_advertisment";
		$template['page_title'] = "Add Website banner";
		$this->load->view('template', $template);
	}

	public function edit_website_advertisment()
	{
		if ($_POST) {
			$id = $this->input->post("id");
			// print_r($id); die;
			$old_img = $this->input->post('image11');
			if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
				$config['upload_path'] = 'uploads/advertisment/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				$imageUpload = '';
				if (!$this->upload->do_upload('image')) {
					$display_image = $old_img;
					$error = array(
						'error' => $this->upload->display_errors()
					);
				} else {
					$imageUpload = $this->upload->data();
					$display_image = $imageUpload['file_name'];
				}
			} else {
				$display_image = $old_img;
			}


			$data1 = array(
				"image" => $display_image,
				"position" => $this->input->post("position"),
				"status" => $this->input->post("status"),
				"title" => $this->input->post("title"),
				"sub_title" => $this->input->post("sub_title"),
				"desc" => $this->input->post("desc"),

			);
			// print_r($data1); die;
			$s = $this->update_website_advertisment_status('advertisment', $id, $data1);

			redirect(base_url('Banner_ctrl/website_advertisment/'));
		} else {
			$id = htmlentities(trim($this->uri->segment(3)));
			$template['data'] = $this->db->query("select * from advertisment where id = $id")->row();
			// print_r($template['data']); die;
			$template['page'] = "advertisment/edit_website_advertisment";
			$template['page_title'] = "Add Patient banner";
			$this->load->view('template', $template);
		}
	}
	public function insert_website_advertisment()
	{
		//print_r($_FILES);
		if ($_POST) {
			$target_path = "uploads/advertisment/";
			$target_dir = "uploads/advertisment/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$data['image'] = $actual_image_name;
					$data['position'] = $this->input->post("position");
					$data['status'] = $this->input->post("status");

					$data['title'] = $this->input->post("title");
					$data['sub_title'] = $this->input->post("sub_title");
					$data['desc'] = $this->input->post("desc");

					$result =  $this->db->insert('advertisment', $data);
					$this->session->set_flashdata('message', array('message' => 'Add Website Banner Details successfully', 'class' => 'success'));
					redirect(base_url('Banner_ctrl/website_advertisment/'));
				} else {
					$template['page'] = "advertisment/add_website_advertisment";
					$template['page_title'] = "Add website_advertisment";
					$this->load->view('template', $template);
				}
			} else {
				$template['page'] = "advertisment/add_website_advertisment";
				$template['page_title'] = "Add website banner";
				$this->load->view('template', $template);
			}
		}
	}
	public function delete_website_advertisment()
	{

		$id = $this->uri->segment(3);
		$image_url = $this->Banner_model->get_row('advertisment', array('id' => $id));

		if ($image_url) {
			$img = $image_url->image;
		}

		$result = $this->website_advertisment_delete($id, $img);

		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/website_advertisment');
	}

	public function website_advertisment_status()
	{

		$data1 = array(
			"status" => '0'
		);
		$id = $this->uri->segment(3);
		$s = $this->update_website_advertisment_status('advertisment', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Disabled', 'class' => 'warning'));
		redirect(base_url() . 'banner_ctrl/website_advertisment');
	}
	public function website_advertisment_active()
	{

		$data1 = array(
			"status" => '1'
		);
		$id = $this->uri->segment(3);
		$s = $this->update_website_advertisment_status('advertisment', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Enabled', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/website_advertisment');
	}


	public function update_website_advertisment_status($table, $data, $data1)
	{
		$this->db->where('id', $data);
		$result = $this->db->update($table, $data1);
		return $result;
	}


	public function website_advertisment_delete($id, $img)
	{


		$this->db->where('id', $id);
		$result = $this->db->delete('advertisment');
		if ($result) {
			unlink('./uploads/advertisment' . '/' . $img);
			return "success";
		} else {
			return "error";
		}
	}



	//end WEbsite


	// website_blog

	public function website_blog()
	{
		// print_r("expression"); die;
		$template['page'] = "blog/view_website_blog";
		$template['page_title'] = "View Website Banner";
		$template['data'] = $this->db->query("select * from blog")->result();
		$this->load->view('template', $template);
	}


	public function add_website_blog()
	{
		$template['page'] = "blog/add_website_blog";
		$template['page_title'] = "Add Website banner";
		$template['astro_data'] = $this->db->query("select id,name from astrologers where status = 1")->result();
		// print_r( $template['astro_data']);die;
		$this->load->view('template', $template);
	}

	public function edit_website_blog()
	{
		if ($_POST) {
			$id = $this->input->post("id");
			// print_r($id); die;
			$old_img = $this->input->post('image11');
			if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
				$config['upload_path'] = 'uploads/blog/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				$imageUpload = '';
				if (!$this->upload->do_upload('image')) {
					$display_image = $old_img;
					$error = array(
						'error' => $this->upload->display_errors()
					);
				} else {
					$imageUpload = $this->upload->data();
					$display_image = $imageUpload['file_name'];
				}
			} else {
				$display_image = $old_img;
			}


			$data1 = array(
				"image" => $display_image,
				"position" => $this->input->post("position"),
				"status" => $this->input->post("status"),
				"title" => $this->input->post("title"),
				"author_name" => $this->input->post("author_name"),
				"show_date" => $this->input->post("show_date"),
				"desc" => $this->input->post("desc"),

				"blog_type" => $this->input->post("blog_type"),
				"video_url" => $this->input->post("video_url"),
			);
			// print_r($data1); die;
			$s = $this->update_website_blog_status('blog', $id, $data1);

			redirect(base_url('Banner_ctrl/website_blog/'));
		} else {
			$id = htmlentities(trim($this->uri->segment(3)));
			$template['data'] = $this->db->query("select * from blog where id = $id")->row();
			// print_r($template['data']); die;
			$template['page'] = "blog/edit_website_blog";
			$template['page_title'] = "Add Patient banner";
			$this->load->view('template', $template);
		}
	}
	public function insert_website_blog()
	{
		//print_r($_FILES);
		if ($_POST) {
			$target_path = "uploads/blog/";
			$target_dir = "uploads/blog/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$data['image'] = $actual_image_name;
					$data['position'] = $this->input->post("position");
					$data['status'] = $this->input->post("status");
					$data['title'] = $this->input->post("title");
					$data['show_date'] = $this->input->post("show_date");
					$data['author_name'] = $this->input->post("author_name");
					$data['desc'] = $this->input->post("desc");
					$data['blog_type'] = $this->input->post("blog_type");
					$data['video_url'] = $this->input->post("video_url");

					$result =  $this->db->insert('blog', $data);
					$this->session->set_flashdata('message', array('message' => 'Add Website Blog Details successfully', 'class' => 'success'));
					redirect(base_url('Banner_ctrl/website_blog/'));
				} else {
					$template['page'] = "blog/add_website_blog";
					$template['page_title'] = "Add website_blog";
					$this->load->view('template', $template);
				}
			} else {
				$template['page'] = "blog/add_website_blog";
				$template['page_title'] = "Add website banner";
				$this->load->view('template', $template);
			}
		}
	}
	public function delete_website_blog()
	{

		$id = $this->uri->segment(3);
		$image_url = $this->Banner_model->get_row('blog', array('id' => $id));

		if ($image_url) {
			$img = $image_url->image;
		}

		$result = $this->website_blog_delete($id, $img);

		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/website_blog');
	}

	public function website_blog_status()
	{

		$data1 = array(
			"status" => '0'
		);
		$id = $this->uri->segment(3);
		$s = $this->update_website_blog_status('blog', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Disabled', 'class' => 'warning'));
		redirect(base_url() . 'banner_ctrl/website_blog');
	}
	public function website_blog_active()
	{

		$data1 = array(
			"status" => '1'
		);
		$id = $this->uri->segment(3);
		$s = $this->update_website_blog_status('blog', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Enabled', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/website_blog');
	}


	public function update_website_blog_status($table, $data, $data1)
	{
		$this->db->where('id', $data);
		$result = $this->db->update($table, $data1);
		return $result;
	}


	public function website_blog_delete($id, $img)
	{


		$this->db->where('id', $id);
		$result = $this->db->delete('blog');
		if ($result) {
			unlink('./uploads/blog' . '/' . $img);
			return "success";
		} else {
			return "error";
		}
	}



	//end website_blog



	public function view_banner()
	{
		$template['page'] = "Bannerdetails/view-patientbanner";
		$template['page_title'] = "View banner";
		$template['data'] = $this->Banner_model->get_banner('banner');
		$this->load->view('template', $template);
	}

	public function add_banner()
	{
		$template['page'] = "Bannerdetails/add_patientbanner";
		$template['page_title'] = "Add Patient banner";
		$template['astrologers'] = $this->db->query("select * from astrologers where status = 1")->result();
		$this->load->view('template', $template);
	}
	public function edit_banner()
	{
		if ($_POST) {
			$id = $this->input->post("id");
			// print_r($id); die;
			$old_img = $this->input->post('image11');
			if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
				$config['upload_path'] = 'uploads/banner/user/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				$imageUpload = '';
				if (!$this->upload->do_upload('image')) {
					$display_image = $old_img;
					$error = array(
						'error' => $this->upload->display_errors()
					);
				} else {
					$imageUpload = $this->upload->data();
					$display_image = $imageUpload['file_name'];
				}
			} else {
				$display_image = $old_img;
			}


			$link_type = $this->input->post("link_type");

			if ($link_type == "chat_listing") {
				$link_id = 0;
			} elseif ($link_type == "audio_listing") {
				$link_id = 0;
			} elseif ($link_type == "video_listing") {
				$link_id = 0;
			} elseif ($link_type == "report_listing") {
				$link_id = 0;
			} elseif ($link_type == "broadcast_listing") {
				$link_id = 0;
			} elseif ($link_type == "astrologer_chat") {
				$link_id = $this->input->post("link_id_chat");
			} elseif ($link_type == "astrologer_audio") {
				$link_id = $this->input->post("link_id_audio");
			} elseif ($link_type == "astrologer_video") {
				$link_id = $this->input->post("link_id_video");
			} elseif ($link_type == "astrologer_report") {
				$link_id = $this->input->post("link_id_report");
			}



			$data1 = array(
				"image" => $display_image,
				"link_id" => $link_id,
				"link_type" => $link_type,
				"position" => $this->input->post("position"),
				"is_active" => $this->input->post("is_active"),
				"type" => "main",

			);
			// print_r($data1); die;
			$s = $this->Banner_model->update_patient_status('banner', $id, $data1);

			redirect(base_url('Banner_ctrl/view_banner/'));
		} else {
			$id = htmlentities(trim($this->uri->segment(3)));
			$template['data'] = $this->Banner_model->get_single_banner($id);
			$template['astrologers'] = $this->db->query("select * from astrologers where status = 1")->result();

			// print_r($template['data']); die;
			$template['page'] = "Bannerdetails/edit_patientbanner";
			$template['page_title'] = "Add Patient banner";
			$this->load->view('template', $template);
		}
	}
	public function insert_patientbanner()
	{
		// print_r($_POST);die;
		if ($_POST) {
			$target_path = "uploads/banner/user/";
			$target_dir = "uploads/banner/user/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$data['image'] = $actual_image_name;
					$data['position'] = $this->input->post("position");
					$data['is_active'] = $this->input->post("is_active");
					$link_id = $this->input->post("link_id");
					$link_type = $this->input->post("link_type");

					if ($link_type == "chat_listing") {
						$data['link_id'] = 0;
					} elseif ($link_type == "audio_listing") {
						$data['link_id'] = 0;
					} elseif ($link_type == "video_listing") {
						$data['link_id'] = 0;
					} elseif ($link_type == "report_listing") {
						$data['link_id'] = 0;
					} elseif ($link_type == "broadcast_listing") {
						$data['link_id'] = 0;
					} elseif ($link_type == "astrologer_chat") {
						$data['link_id'] = $this->input->post("link_id_chat");
					} elseif ($link_type == "astrologer_audio") {
						$data['link_id'] = $this->input->post("link_id_audio");
					} elseif ($link_type == "astrologer_video") {
						$data['link_id'] = $this->input->post("link_id_video");
					} elseif ($link_type == "astrologer_report") {
						$data['link_id'] = $this->input->post("link_id_report");
					}

					$data['link_type'] = $this->input->post("link_type");


					$data['type'] = "main";
					$result = $this->Banner_model->add_bannerdetails('banner', $data);
					// echo $this->db->last_query();die;
					$this->session->set_flashdata('message', array('message' => 'Add banner Details successfully', 'class' => 'success'));
					$template['data'] = $this->Banner_model->get_bannerdetails('banner');
					$template['page'] = "Bannerdetails/view-patientbanner";
					$template['page_title'] = "View Patient Banner";
					$this->load->view('template', $template);
				} else {
					$template['page'] = "Bannerdetails/add_patientbanner";
					$template['page_title'] = "Add Patient banner";
					$this->load->view('template', $template);
				}
			} else {
				$template['page'] = "Bannerdetails/add_patientbanner";
				$template['page_title'] = "Add Patient banner";
				$this->load->view('template', $template);
			}
		}
	}
	public function delete_patientbanner()
	{

		$id = $this->uri->segment(3);
		$image_url = $this->Banner_model->get_row('banner', array('id' => $id));

		if ($image_url) {
			$img = $image_url->image;
		}

		$result = $this->Banner_model->patientbanner_delete($id, $img);

		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_banner');
	}

	public function patient_status()
	{

		$data1 = array(
			"is_active" => '0'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Disabled', 'class' => 'warning'));
		redirect(base_url() . 'banner_ctrl/view_banner');
	}
	public function patient_active()
	{

		$data1 = array(
			"is_active" => '1'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Enabled', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_banner');
	}

	//banner offer

	public function view_banner_coupan()
	{
		$template['page'] = "Bannerdetails/view-banner_coupan";
		$template['page_title'] = "View banner_coupan";
		$template['data'] = $this->Banner_model->get_banner_coupan('banner_coupan');
		$this->load->view('template', $template);
	}

	public function add_banner_coupan()
	{
		$template['page'] = "Bannerdetails/add_banner_coupan";
		$template['coupan_data'] = $this->db->query("select * from coupan where status = 1")->result();
		$template['banner_data'] = $this->db->query("select * from banner where is_active = 1")->result();
		// print_r($template['banner_data']); die;
		$template['page_title'] = "Add banner_coupan";
		$this->load->view('template', $template);
	}
	public function edit_banner_coupan()
	{
		if ($_POST) {
			$id = $this->input->post("id");
			// print_r($id); die;
			$old_img = $this->input->post('image11');
			if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
				$config['upload_path'] = 'uploads/banner/user/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				$imageUpload = '';
				if (!$this->upload->do_upload('image')) {
					$display_image = $old_img;
					$error = array(
						'error' => $this->upload->display_errors()
					);
				} else {
					$imageUpload = $this->upload->data();
					$display_image = $imageUpload['file_name'];
				}
			} else {
				$display_image = $old_img;
			}


			$data1 = array(
				"image" => $display_image,
				"position" => $this->input->post("position"),
				"is_active" => $this->input->post("is_active"),
				"type" => "main",

			);
			// print_r($data1); die;
			$s = $this->Banner_model->update_patient_status('banner_coupan', $id, $data1);

			redirect(base_url('Banner_ctrl/view_banner_coupan/'));
		} else {
			$id = htmlentities(trim($this->uri->segment(3)));
			$template['data'] = $this->Banner_model->get_single_banner_coupan($id);
			// print_r($template['data']); die;
			$template['page'] = "Bannerdetails/edit_banner_coupan";
			$template['page_title'] = "Add banner_coupan";
			$this->load->view('template', $template);
		}
	}
	public function insert_banner_coupan()
	{
		//print_r($_FILES);
		if ($_POST) {
			$target_path = "uploads/banner/user/";
			$target_dir = "uploads/banner/user/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$data['image'] = $actual_image_name;
					$data['position'] = $this->input->post("position");
					$data['is_active'] = $this->input->post("is_active");
					$data['type'] = "main";
					$result = $this->Banner_model->add_bannerdetails('banner_coupan', $data);
					$this->session->set_flashdata('message', array('message' => 'Add banner Details successfully', 'class' => 'success'));
					$template['data'] = $this->Banner_model->get_bannerdetails('banner_coupan');
					$template['page'] = "Bannerdetails/view-banner_coupan";
					$template['page_title'] = "View Patient Banner";
					$this->load->view('template', $template);
				} else {
					$template['page'] = "Bannerdetails/add_banner_coupan";
					$template['page_title'] = "Add banner_coupan";
					$this->load->view('template', $template);
				}
			} else {
				$template['page'] = "Bannerdetails/add_banner_coupan";
				$template['page_title'] = "Add banner_coupan";
				$this->load->view('template', $template);
			}
		}
	}
	public function delete_banner_coupan()
	{

		$id = $this->uri->segment(3);
		$image_url = $this->Banner_model->get_row('banner_coupan', array('id' => $id));

		if ($image_url) {
			$img = $image_url->image;
		}

		$result = $this->Banner_model->banner_coupan_delete($id, $img);

		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_banner_coupan');
	}

	public function banner_coupan_status()
	{

		$data1 = array(
			"is_active" => '0'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('banner_coupan', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Disabled', 'class' => 'warning'));
		redirect(base_url() . 'banner_ctrl/view_banner');
	}
	public function banner_coupan_active()
	{

		$data1 = array(
			"is_active" => '1'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('banner_coupan', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Enabled', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_banner_coupan');
	}






	//_mid
	public function view_banner_mid()
	{
		$template['page'] = "Bannerdetails/view-patientbanner_mid";
		$template['page_title'] = "View banner";
		$template['data'] = $this->Banner_model->get_banner_mid('banner');
		$this->load->view('template', $template);
	}

	public function add_banner_mid()
	{
		$template['page'] = "Bannerdetails/add_patientbanner_mid";
		$template['page_title'] = "Add Patient banner";
		$this->load->view('template', $template);
	}
	public function edit_banner_mid()
	{
		if ($_POST) {
			$id = $this->input->post("id");
			// print_r($id); die;
			$old_img = $this->input->post('image11');
			if (!empty($_FILES['image']) && !empty(trim($_FILES['image']['name']))) {
				$config['upload_path'] = 'uploads/banner/user/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '';
				$config['max_width'] = '';
				$config['max_height'] = '';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				$imageUpload = '';
				if (!$this->upload->do_upload('image')) {
					$display_image = $old_img;
					$error = array(
						'error' => $this->upload->display_errors()
					);
				} else {
					$imageUpload = $this->upload->data();
					$display_image = $imageUpload['file_name'];
				}
			} else {
				$display_image = $old_img;
			}


			$data1 = array(
				"image" => $display_image,
				"position" => $this->input->post("position"),
				"is_active" => $this->input->post("is_active"),
				"type" => "mid",

			);
			// print_r($data1); die;
			$s = $this->Banner_model->update_patient_status('banner', $id, $data1);

			redirect(base_url('Banner_ctrl/view_banner_mid/'));
		} else {
			$id = htmlentities(trim($this->uri->segment(3)));
			$template['data'] = $this->Banner_model->get_single_banner($id);
			// print_r($template['data']); die;
			$template['page'] = "Bannerdetails/edit_patientbanner_mid";
			$template['page_title'] = "Add Patient banner";
			$this->load->view('template', $template);
		}
	}
	public function insert_patientbanner_mid()
	{
		//print_r($_FILES);
		if ($_POST) {
			$target_path = "uploads/banner/user/";
			$target_dir = "uploads/banner/user/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			if (is_array($_FILES)) {
				$imagename = basename($_FILES["image"]["name"]);
				$extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
				$actual_image_name = time() . "." . $extension;
				move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
				if (!empty($actual_image_name) && !empty($extension)) {
					$data['image'] = $actual_image_name;
					$data['position'] = $this->input->post("position");
					$data['is_active'] = $this->input->post("is_active");
					$data['type'] = "mid";
					$result = $this->Banner_model->add_bannerdetails('banner', $data);
					$this->session->set_flashdata('message', array('message' => 'Add banner Details successfully', 'class' => 'success'));
					$template['data'] = $this->Banner_model->get_bannerdetails_mid('banner');
					$template['page'] = "Bannerdetails/view-patientbanner_mid";
					$template['page_title'] = "View Patient Banner";
					$this->load->view('template', $template);
				} else {
					$template['page'] = "Bannerdetails/add_patientbanner_mid";
					$template['page_title'] = "Add Patient banner";
					$this->load->view('template', $template);
				}
			} else {
				$template['page'] = "Bannerdetails/add_patientbanner_mid";
				$template['page_title'] = "Add Patient banner";
				$this->load->view('template', $template);
			}
		}
	}
	public function delete_patientbanner_mid()
	{

		$id = $this->uri->segment(3);
		$image_url = $this->Banner_model->get_row('banner', array('id' => $id));

		if ($image_url) {
			$img = $image_url->image;
		}

		$result = $this->Banner_model->patientbanner_delete($id, $img);

		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_banner_mid');
	}

	public function patient_status_mid()
	{

		$data1 = array(
			"is_active" => '0'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Disabled', 'class' => 'warning'));
		redirect(base_url() . 'banner_ctrl/view_banner_mid');
	}
	public function patient_active_mid()
	{

		$data1 = array(
			"is_active" => '1'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Enabled', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_banner_mid');
	}





	public function view_doctorbanner()
	{
		$template['page'] = "Bannerdetails/view-doctorbanner";
		$template['page_title'] = "View banner";
		$template['data'] = $this->Banner_model->get_banner('doctor_banner');
		$this->load->view('template', $template);
	}









	public function add_doctorbanner()
	{
		$template['page'] = "Bannerdetails/add_doctorbanner";
		$template['page_title'] = "Add doctor banner";
		$this->load->view('template', $template);
	}
	public function insert_doctorbanner()
	{
		//print_r($_FILES);
		if ($_POST) {
			$data = $_POST;
			if (!empty($_FILES['image'])) {
				$config['upload_path']          = 'uploads/banner/doctor_banner';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$config['max_size']             = '';
				$config['max_width']            = '';
				$config['max_height']           = '';
				$config['encrypt_name'] 		= TRUE;
				$this->load->library('upload', $config);
				$imageUpload = '';

				if (!$this->upload->do_upload('image')) {
					$error = array('error' => $this->upload->display_errors());
				} else {
					$imageUpload =  $this->upload->data();
				}

				$data['image'] = $imageUpload['file_name'];
			} else {
				$data['image'] = '';
			}

			$result = $this->Banner_model->add_bannerdetails('doctor_banner', $data);
			//echo $this->db->last_query();die;
			if ($result) {
				$this->session->set_flashdata('message', array('message' => 'Add banner Details successfully', 'class' => 'success'));
			}
		}
		redirect(base_url() . 'banner_ctrl/view_doctorbanner');
	}
	public function delete_doctorbanner()
	{

		$id = $this->uri->segment(3);
		$image_url = $this->Banner_model->get_row('doctor_banner', array('id' => $id));

		if ($image_url) {
			$img = $image_url->image;
		}

		$result = $this->Banner_model->doctorbanner_delete($id, $img);

		$this->session->set_flashdata('message', array('message' => 'Deleted Successfully', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_doctorbanner');
	}

	public function doctor_status()
	{

		$data1 = array(
			"status" => '0'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('doctor_banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Disabled', 'class' => 'warning'));
		redirect(base_url() . 'banner_ctrl/view_doctorbanner');
	}
	public function doctor_active()
	{

		$data1 = array(
			"status" => '1'
		);
		$id = $this->uri->segment(3);
		$s = $this->Banner_model->update_patient_status('doctor_banner', $id, $data1);

		$this->session->set_flashdata('message', array('message' => 'Successfully Enabled', 'class' => 'success'));
		redirect(base_url() . 'banner_ctrl/view_doctorbanner');
	}
}
