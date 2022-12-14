<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'test_get' =>array(
		array('field'=>'id', 'label'=>'required', 'rules'=>'trim | required ')
	),
	
	'signup' =>array(
		// array('field'=>'name', 'label'=>'mobile', 'rules'=>'trim|required'),
		array('field'=>'mobile', 'label'=>'mobile', 'rules'=>'trim|required'),
		array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|valid_email'),
		array('field'=>'password', 'label'=>'Password', 'rules'=>'trim|required|min_length[6]|max_length[32]'),
		array('field'=>'deviceID', 'label'=>'deviceID', 'rules'=>'trim|required'),
		array('field'=>'deviceType', 'label'=>'deviceType', 'rules'=>'trim|required'),
		array('field'=>'deviceToken', 'label'=>'deviceToken', 'rules'=>'trim|required'),
	),
	
	'signIn' =>array(
		array('field'=>'user_id', 'label'=>'Username/Email/mobile', 'rules'=>'trim|required'),
		// array('field'=>'password', 'label'=>'Password', 'rules'=>'trim|required'),
	),
	
	'joinSalons' =>array(
		array('field'=>'email_id', 'label'=>'Email', 'rules'=>'trim|required|valid_email'),
		array('field'=>'phone_no', 'label'=>'Phone number', 'rules'=>'trim|numeric|required'),
	),

	'otp' =>array(
		array('field'=>'email_id', 'label'=>'Email', 'rules'=>'trim|required|valid_email'),
		array('field'=>'phone_no', 'label'=>'Phone number', 'rules'=>'trim|numeric|required'),
		array('field'=>'otp', 'label'=>'OTP', 'rules'=>'trim|numeric|required'),
	),


	'on_appointment' =>array(
		array('field'=>'user_id', 'label'=>'Email', 'rules'=>'trim|numeric|required'),
		array('field'=>'for', 'label'=>'for which', 'rules'=>'trim|required'),
		array('field'=>'module', 'label'=>'module', 'rules'=>'trim|required'),
	),

	'on_planned' =>array(
		array('field'=>'address', 'label'=>'address', 'rules'=>'trim|required'),
		array('field'=>'area', 'label'=>'area', 'rules'=>'trim|required'),
		array('field'=>'pincode', 'label'=>'pincode', 'rules'=>'trim|required'),
		array('field'=>'date', 'label'=>'date', 'rules'=>'trim|numeric|required'),
		array('field'=>'time', 'label'=>'time', 'rules'=>'trim|required'),
		array('field'=>'total_amount', 'label'=>'total_amount', 'rules'=>'trim|required'),
	),


	'login' =>array(
		array('field'=>'phone', 'label'=>'Phone/Email', 'rules'=>'trim|required'),
		array('field'=>'password', 'label'=>'password', 'rules'=>'trim|required'),
		array('field'=>'deviceID', 'label'=>'deviceID', 'rules'=>'trim|required'),
		array('field'=>'deviceType', 'label'=>'deviceType', 'rules'=>'trim|required'),
		array('field'=>'deviceToken', 'label'=>'deviceToken', 'rules'=>'trim|required'),
	),
	
	
);
