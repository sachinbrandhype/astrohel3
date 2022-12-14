<?php

function get_icon(){
	$CI = & get_instance();
	$CI->db->select('*');
	$CI->db->where("id", 1);
	$CI->db->from('settings');
	$result = $CI->db->get()->row();
	return $result;
}



// Medical Module 

		function total_medical()
		{
			$CI = & get_instance();	
			// $CI->db->where('status','1');
   			$CI->db->where_in('booking_type',array(5));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}


		function total_new_medical()
		{
			$CI = & get_instance();	
			$CI->db->where('status','0');
   	        $CI->db->where_in('booking_type',array(5));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}


		function total_completed_medical()
		{
			$CI = & get_instance();	
			$CI->db->where('status','1');
			$CI->db->where_in('booking_type',array(5));
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}




		function total_cancel_medical()
		{
			$CI = & get_instance();	

			$CI->db->where_in('status',array(2, 3,4,5));
			$CI->db->where_in('booking_type',array(5));
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
			
		}


//Financial_module


	function total_financial()
	{
	$CI = & get_instance();	
	// $CI->db->where('status','1');
	$CI->db->where_in('booking_type',array(6));		
	$query = $CI->db->get('booking');
	$car=$query->num_rows();
	return $car;	
	}


		function total_new_financial()
		{
			$CI = & get_instance();	
			$CI->db->where('status','0');
   	$CI->db->where_in('booking_type',array(6));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}


		function total_completed_financial()
		{
			$CI = & get_instance();	
			$CI->db->where('status','1');
				$CI->db->where_in('booking_type',array(6));
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}




		function total_cancel_financial()
		{
			$CI = & get_instance();	

			$CI->db->where_in('status',array(2, 3,4,5));
			$CI->db->where_in('booking_type',array(6));
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
			
		}


		






		function total_life_prediction()
		{
			$CI = & get_instance();	
			// $CI->db->where('status','1');
   			$CI->db->where_in('booking_type',array(3));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}


		function total_new_life_prediction()
		{
			$CI = & get_instance();	
			$CI->db->where('status','0');
   	$CI->db->where_in('booking_type',array(3));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}


		function total_completed_life_prediction()
		{
			$CI = & get_instance();	
			$CI->db->where('status','1');
				$CI->db->where_in('booking_type',array(3));
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}




		function total_cancel_life_prediction()
		{
			$CI = & get_instance();	

			$CI->db->where_in('status',array(2, 3,4,5));
			$CI->db->where_in('booking_type',array(3));
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
			
		}

		

		function total_active_users()
		{
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$query = $CI->db->get('user');
			$car=$query->num_rows();
			return $car;	
		}


		function total_inactive_users()
		{
			$CI = & get_instance();	
			$CI->db->where('status','0');			
			$query = $CI->db->get('user');
			$car=$query->num_rows();
			return $car;	
		}


		function total_users()
		{
			$CI = & get_instance();	
			$query = $CI->db->get('user');
			$car=$query->num_rows();
			return $car;	
		}

		function total_gems_category()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');			
			// $query = $CI->db->get('gems_category');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}


		function total_gems_products()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');			
			// $query = $CI->db->get('gems_products');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}


		function total_gems_bookings()
		{
// 			$CI = & get_instance();	
// 			// $CI->db->where('status','1');
//    //     		$CI->db->or_where('status',3);			
// 			$query = $CI->db->get('booking_gems');
// 			$car=$query->num_rows();
// 			return $car;	
return [];
		}


		function new_gems_bookings()
		{
// 			$CI = & get_instance();	
// 			$CI->db->where('status','0');
//    //     		$CI->db->or_where('status',3);			
// 			$query = $CI->db->get('booking_gems');
// 			$car=$query->num_rows();
// 			return $car;	
return [];
		}


		function completed_gems_bookings()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');
			// $query = $CI->db->get('booking_gems');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}




		function cancel_gems_bookings()
		{
		// 	$CI = & get_instance();	
		// 	$CI->db->where_in('status',array(2, 3,4,5));
		// 	$query = $CI->db->get('booking_gems');
		// 	$car=$query->num_rows();
		// 	return $car;
		return [];	
			
		}

		function total_banner()
		{
			$CI = & get_instance();	
			$CI->db->where('is_active','1');
			$query = $CI->db->get('banner');
			$car=$query->num_rows();
			return $car;	
		}

		function total_gallery()
		{
			$CI = & get_instance();	
			$CI->db->where('status<>','2');
			$query = $CI->db->get('gallery');
			$car=$query->num_rows();
			return $car;	
		}

		function total_testi()
		{
			$CI = & get_instance();	
			$CI->db->where('status<>','2');
			$query = $CI->db->get('testimonials');
			$car=$query->num_rows();
			return $car;	
		}



		function total_posts()
		{
			$CI = & get_instance();	
			$CI->db->where('status<>','2');
			$query = $CI->db->get('posts');
			$car=$query->num_rows();
			return $car;	
		}





		function total_ropeway()
		{
			$CI = & get_instance();	
			$CI->db->where('status<>','2');
			$query = $CI->db->get('ropeway');
			$car=$query->num_rows();
			return $car;	
		}

		function total_kumbh()
		{
			$CI = & get_instance();	
			$CI->db->where('status<>','2');
			$query = $CI->db->get('kumbh');
			$car=$query->num_rows();
			return $car;	
		}

		function total_active_astrologer()
		{
			$CI = & get_instance();	
			$CI->db->where('status','1');
			$CI->db->where('approved','1');
			$query = $CI->db->get('astrologers');
			$car=$query->num_rows();
			return $car;	
		}

		function total_inactive_astrologer()
		{
			$CI = & get_instance();	
			$CI->db->where('status','0');
			$CI->db->where('approved','1');
			$query = $CI->db->get('astrologers');
			$car=$query->num_rows();
			return $car;	
		}

		function total_pending_astrologer()
		{
			$CI = & get_instance();	
			$CI->db->where('status<>','2');
			$CI->db->where('approved','0');
			$query = $CI->db->get('astrologers');
			$car=$query->num_rows();
			return $car;	
		}

		function total_puja()
		{
			$CI = & get_instance();	
			$CI->db->where('status<>','2');
			$query = $CI->db->get('puja');
			$car=$query->num_rows();
			return $car;	
		}

		function total_news()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');
			// $query = $CI->db->get('user_news');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}

		function total_video()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');
			// $query = $CI->db->get('user_video');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}



		function total_online_bookings()
		{
			$CI = & get_instance();	
			$CI->db->where_in('booking_type',array(1, 2));			
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}



		function total_new_online_bookings()
		{
			$CI = & get_instance();	
			$CI->db->where('status','0');
			$CI->db->where_in('booking_type',array(1, 2));			
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}

		function total_completed_online_bookings()
		{
			$CI = & get_instance();	
			$CI->db->where('status','1');
			$CI->db->where_in('booking_type',array(1, 2));			
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}

		function total_cancel_online_bookings()
		{
			$CI = & get_instance();	
			$CI->db->where_in('status',array(2, 3,4,5));
			$CI->db->where_in('booking_type',array(1, 2));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}


		function total_pdf_booking()
		{
			// $CI = & get_instance();	
			// // $CI->db->where_in('status',array(2, 3,4,5));
			// $query = $CI->db->get('pdf_booking');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}


		function total_new_pdf_booking()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','0');
			// $query = $CI->db->get('pdf_booking');
			// $car=$query->num_rows();
			// return $car;
			return [];	
		}


		function total_completed_pdf_booking()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');
			// $query = $CI->db->get('pdf_booking');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}

		function total_cancel_pdf_booking()
		{
			// $CI = & get_instance();	
			// $CI->db->where_in('status',array(2, 3,4,5));
			// $query = $CI->db->get('pdf_booking');
			// $car=$query->num_rows();
			// return $car;
			return [];	
		}


		function in_person_events()
		{
			// $CI = & get_instance();	
			// $CI->db->where_in('status',array(1));		
			// $query = $CI->db->get('in_person_events');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}


		function total_in_person_bookings()
		{
			// $CI = & get_instance();	
			// $CI->db->where_in('booking_type',array(4));		
			// $query = $CI->db->get('booking');
			// $car=$query->num_rows();
			// return $car;
			return [];	
		}



		function total_new_in_person_bookings()
		{
			$CI = & get_instance();	
			$CI->db->where('status','0');
			$CI->db->where_in('booking_type',array(4));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}

		function total_completed_in_person_bookings()
		{
			$CI = & get_instance();	
			$CI->db->where('status','1');
			$CI->db->where_in('booking_type',array(4));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}

		function total_cancel_in_person_bookings()
		{
			$CI = & get_instance();	
			$CI->db->where_in('status',array(2, 3,4,5));
			$CI->db->where_in('booking_type',array(4));		
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}




		function total_classes_total()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');
			// $query = $CI->db->get('class_package');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}



		function total_purchases_total()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');
			// $query = $CI->db->get('class_package_history');
			// $car=$query->num_rows();
			// return $car;
			return [];	
		}


		function total_horscope_bookings()
		{
			// $CI = & get_instance();	
			// $query = $CI->db->get('horoscope_matching_booking');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}



		function total_new_horscope_bookings()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','0');
			// $query = $CI->db->get('horoscope_matching_booking');
			// $car=$query->num_rows();
			// return $car;
			return [];	
		}

		function total_completed_horscope_bookings()
		{
			// $CI = & get_instance();	
			// $CI->db->where('status','1');
			// $query = $CI->db->get('horoscope_matching_booking');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}

		function total_cancel_horscope_bookings()
		{
			// $CI = & get_instance();	
			// $CI->db->where_in('status',array(2, 3,4,5));
			// $query = $CI->db->get('horoscope_matching_booking');
			// $car=$query->num_rows();
			// return $car;	
			return [];
		}







	function get_picture($id){
		$CI = & get_instance();
		$query = $CI->db->get_where('admin',array('id' => $id));		
		$result = $query->row();
		return $result;		
	}
	/* ===Get Admin=== */
		function pull_admin(){
		$CI = & get_instance();
		$query = $CI->db->get('admin');		
		$result = $query->result();
		return $result;		
	}
	
		function get_homesettings(){
		$CI = & get_instance();
		$query = $CI->db->get_where('settings',array('id' => 1));		
		$result = $query->row();
		return $result;		
	}
	function upload_patient_image($path) {   
		$config = array();
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;
		return $config;
  }
	function upload_doctor_image($path) {   
		$config = array();
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;
		return $config;
	}
	function upload_hospital_image($path) {   
		$config = array();
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;
		return $config;
	}
	function upload_medical_image($path) {   
		$config = array();
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;
		return $config;
	}
	function upload_clinic_image($path) {   
		$config = array();
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;
		return $config;
	}
		/* === Get Total Patients Count === */
		function pull_total_patients(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$query = $CI->db->get('patient');
			$car=$query->num_rows();
			return $car;	
		}
		/* === Get Total Appointment Count === */
		function pull_total_appoinment(){
			$CI = & get_instance();	
			$CI->db->where('final_status','1');			
			$query = $CI->db->get('appointment');
			$car=$query->num_rows();
			return $car;	
		}
		/* === Get Total Doctor Count === */
		function pull_total_doctor(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$query = $CI->db->get('doctor');
			$car=$query->num_rows();
			return $car;	
		}
		/* === Get Total Clinic Count === */
		function pull_total_clinic(){
			$CI = & get_instance();	
			$CI->db->where('is_active','1');			
			$query = $CI->db->get('chemist');
			$car=$query->num_rows();
			return $car;	
		}

		/* === Get Total Nurse Count === */
		function pull_total_nurse(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$query = $CI->db->get('nurse');
			$car=$query->num_rows();
			return $car;	
		}




		
		function pull_total_plan_doctor(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$CI->db->where('planned_visit','1');			
			$query = $CI->db->get('doctor');
			$car=$query->num_rows();
			return $car;	
		}

		function pull_total_emergency_doctor(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$CI->db->where('emergency','1');			
			$query = $CI->db->get('doctor');
			$car=$query->num_rows();
			return $car;	
		}



		function pull_total_medical_services_doctor(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$CI->db->where('doorstep','1');			
			$query = $CI->db->get('doctor');
			$car=$query->num_rows();
			return $car;	
		}


		function pull_total_advertisment_mange_image(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$CI->db->where('type','image');			
			$query = $CI->db->get('articles');
			$car=$query->num_rows();
			return $car;	
		}

		function pull_total_advertisment_mange_url(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$CI->db->where('type','url');			
			$query = $CI->db->get('articles');
			$car=$query->num_rows();
			return $car;	
		}

		function pull_total_advertisment_mange_video(){
			$CI = & get_instance();	
			$CI->db->where('status','1');			
			$CI->db->where('type','video');			
			$query = $CI->db->get('articles');
			$car=$query->num_rows();
			return $car;	
		}

		function online_consultation(){
			$CI = & get_instance();	
			$CI->db->where('booking_type',4);			
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}

		function offline_consultation(){
			$CI = & get_instance();	
			$CI->db->where('booking_type',5);			
			$query = $CI->db->get('booking');
			$car=$query->num_rows();
			return $car;	
		}


		function pull_total_booking_lab(){
			$lab_id  = $_SESSION['lab_id'];
			//print_r($lab_id);die;
			$CI = & get_instance();	
			//$CI->db->where('status',1);			
			$CI->db->where('lab_assign_id',$lab_id);			
			$query = $CI->db->get('booking_test');

			$car=$query->num_rows();
			return $car;	
		}


		function pull_new_booking_lab(){
			$lab_id  = $_SESSION['lab_id'];
			//print_r($lab_id);die;
			$CI = & get_instance();	
			$CI->db->where('status',0);			
			$CI->db->where('lab_assign_id',$lab_id);			
			$query = $CI->db->get('booking_test');

			$car=$query->num_rows();
			return $car;	
		}

		function pull_complete_booking_lab(){
			$lab_id  = $_SESSION['lab_id'];
			//print_r($lab_id);die;
			$CI = & get_instance();	
			$CI->db->where('status',1);			
			$CI->db->where('lab_assign_id',$lab_id);			
			$query = $CI->db->get('booking_test');

			$car=$query->num_rows();
			return $car;	
		}


		function pull_cancel_booking_lab(){
			$lab_id  = $_SESSION['lab_id'];
			//print_r($lab_id);die;
			$CI = & get_instance();	
			$CI->db->where('status',2);	
			$CI->db->or_where('status',3);;	

			$CI->db->where('lab_assign_id',$lab_id);			
			$query = $CI->db->get('booking_test');

			$car=$query->num_rows();
			return $car;	
		}




?>
