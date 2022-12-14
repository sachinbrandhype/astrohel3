<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy extends CI_Controller {

	public function index()
	{
	 	$template['data'] = $this->db->get_where("settings",array("id"=>1))->row();
		$this->load->view('privacy-policy',$template);
	}
}	