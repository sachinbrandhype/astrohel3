<?php 
   $id = $this->session->userdata('logged_in')['id'];   
   $admin_detail = pull_admin();
  $uri1 =$this->uri->segment(1);
  $uri2 =$this->uri->segment(2);
  $uri3 =$this->uri->segment(3);
   ?>
<!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="pull-left image">
            <?php if($admin_detail[0]->profile_picture != NULL){ ?>
            <img src="<?php echo base_url().$admin_detail[0]->profile_picture; ?>" class="img-circle" alt="User Image">
            <?php }else{ ?>
            <img src="<?php echo base_url(); ?>assets/images/user_avatar.jpg" class="img-circle" alt="User Image">
            <?php } ?>           
         </div>
         <div class="pull-left info">
            <p><?php $a=$this->session->userdata('logged_in'); echo $a['username'];?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
         </div>
      </div>
      <!-- search form -->
      <!-- <form method="post" class="sidebar-form">
         <div class="input-group">
           <input type="text" name="q" class="form-control" placeholder="Search...">
           <span class="input-group-btn">
             <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
           </span>
         </div>
         </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
         <li class="header">MAIN NAVIGATION</li>
         <li class="<?php if($uri1 == 'welcome') {?>active<?php }?>">
            <a href="<?php echo base_url(); ?>welcome">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
            </a>
         </li>
         <li class="<?php if($uri2 == 'view_patientdetails' || $uri2 == 'member_view' || $uri2 == 'transaction_view' || $uri2=='patient_view') {?>active<?php }?>">
            <a href="<?php echo base_url();?>Patient_details/view_patientdetails">
            <i class="fa fa-male"></i>
            <span>User Details</span>
            </a>
         </li>


         <li class="<?php if($uri3 =='all_pharmacy'|| $uri3 =='new_pharmacy'|| $uri3 =='cancel_pharmacy'|| $uri3 =='complete_pharmacy') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span>Pharmacy Enquiry</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
      
               <li><a href="<?php echo base_url();?>speedhuntson/all_pharmacy/all_pharmacy"><i class="fa fa-circle-o text-aqua"></i>All Pharmacy Enquiry</a></li>

              <li><a href="<?php echo base_url();?>speedhuntson/all_pharmacy/new_pharmacy"><i class="fa fa-circle-o text-aqua"></i>New Pharmacy Enquiry</a></li>

               <li><a href="<?php echo base_url();?>speedhuntson/all_pharmacy/cancel_pharmacy"><i class="fa fa-circle-o text-aqua"></i>Cancel Pharmacy Enquiry</a></li>

               <li><a href="<?php echo base_url();?>speedhuntson/all_pharmacy/complete_pharmacy"><i class="fa fa-circle-o text-aqua"></i>Complete Pharmacy Enquiry</a></li>
            </ul>
         </li>
         

         
         <li class="<?php if($uri2 == 'ambulance' || $uri2 =='ambulance_category'|| $uri2 =='add_ambulance'|| $uri2 =='edit_ambulance'|| $uri2 =='add_ambulance_category'|| $uri2 =='edit_ambulance_category' || $uri2 =='add_medical_equipment'|| $uri2 =='medical_equipment_gallery'|| $uri2 =='edit_medical_equipment'|| $uri3 =='all_booking'|| $uri3 =='new_booking'|| $uri3 =='cancel_booking'|| $uri3 =='complete_booking') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span>Ambulance Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>speedhuntson/ambulance"><i class="fa fa-circle-o text-aqua"></i>List Ambulance</a></li>

               <li><a href="<?php echo base_url();?>speedhuntson/ambulance_category"><i class="fa fa-circle-o text-aqua"></i>Category</a></li>

               <li><a href="<?php echo base_url();?>speedhuntson/all_booking_ambulance/all_booking"><i class="fa fa-circle-o text-aqua"></i>All Booking ambulance</a></li>

              <li><a href="<?php echo base_url();?>speedhuntson/all_booking_ambulance/new_booking"><i class="fa fa-circle-o text-aqua"></i>New Booking</a></li>

               <li><a href="<?php echo base_url();?>speedhuntson/all_booking_ambulance/cancel_booking"><i class="fa fa-circle-o text-aqua"></i>Cancel Booking</a></li>

               <li><a href="<?php echo base_url();?>speedhuntson/all_booking_ambulance/complete_booking"><i class="fa fa-circle-o text-aqua"></i>Complete Booking</a></li>
            </ul>
         </li>

         <li class="<?php if($uri1 == 'online_consultation' || $uri1 == 'Online_consultation') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span >Online Consultation Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
            <!--    <li><a href="<?php echo base_url();?>online_consultation/plan_doctor_list"><i class="fa fa-circle-o text-aqua"></i>Planned Doctor List</a></li>-->

               <li><a href="<?php echo base_url();?>online_consultation/all_booking"><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
               <li><a href="<?php echo base_url();?>online_consultation/new_booking"><i class="fa fa-circle-o text-aqua"></i> New Booking</a></li>

               <li><a href="<?php echo base_url();?>online_consultation/complete_booking"><i class="fa fa-circle-o text-aqua"></i> Complete Booking</a></li>

               <li><a href="<?php echo base_url();?>online_consultation/cancel_booking"><i class="fa fa-circle-o text-aqua"></i> Cancel Booking</a></li>

              

              
            </ul>
         </li>


         <li class="<?php if($uri1 == 'offline_consultation') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span >Clinic Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>offline_consultation/all_booking"><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
               <li><a href="<?php echo base_url();?>offline_consultation/new_booking"><i class="fa fa-circle-o text-aqua"></i> New Booking</a></li>

               <li><a href="<?php echo base_url();?>offline_consultation/complete_booking"><i class="fa fa-circle-o text-aqua"></i> Complete Booking</a></li>

               <li><a href="<?php echo base_url();?>offline_consultation/cancel_booking"><i class="fa fa-circle-o text-aqua"></i> Cancel Booking</a></li>
            </ul>
         </li>

          <li class="<?php if($uri2 == 'medical_equipment' || $uri2 == 'medical_equipment_gallery' || $uri2 == 'edit_medical_equipment' || $uri2 == 'add_medical_equipment' || $uri2 == 'medical_equipment_rental' || $uri2 == 'add_medical_equipment' || $uri2 == 'edit_medical_equipment'|| $uri2 == 'medical_equipment_sell'|| $uri2 == 'add_medical_equipment'|| $uri2 == 'edit_medical_equipment'|| $uri2 == 'orders_for_equipment') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span>Medical Equipment Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
            
               <li><a href="<?php echo base_url();?>speedhuntson/medical_equipment"><i class="fa fa-circle-o text-aqua"></i>Medical Equipment</a></li>
               <li><a href="<?php echo base_url();?>speedhuntson/medical_equipment_rental"><i class="fa fa-circle-o text-aqua"></i>Rental Equipment</a></li>
               <li><a href="<?php echo base_url();?>speedhuntson/medical_equipment_sell"><i class="fa fa-circle-o text-aqua"></i>Sell Equipment</a></li>
                <li><a href="<?php echo base_url();?>speedhuntson/orders_for_equipment/orders_for_rentals"><i class="fa fa-circle-o text-aqua"></i>Orders For Rentals</a></li>
               <li><a href="<?php echo base_url();?>speedhuntson/orders_for_equipment/orders_for_purchase"><i class="fa fa-circle-o text-aqua"></i>Orders For Purchase</a></li>
               <li><a href="<?php echo base_url();?>speedhuntson/orders_for_equipment/orders_for_complete"><i class="fa fa-circle-o text-aqua"></i>Orders For Complete</a></li>
               <li><a href="<?php echo base_url();?>speedhuntson/orders_for_equipment/orders_for_cancel"><i class="fa fa-circle-o text-aqua"></i>Orders For Cancel</a></li>
            </ul>
         </li>




         
         <li class="<?php if($uri1 == 'doctor_doorstep' || $uri1 == 'Doctor_doorstep' || $uri2 == 'doctor_view') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span >Doctor Doorstep Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>doctor_doorstep/plan_doctor_list"><i class="fa fa-circle-o text-aqua"></i>Planned Doctor List</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/plan_all_booking"><i class="fa fa-circle-o text-aqua"></i>Planned All Booking</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/plan_complete_booking"><i class="fa fa-circle-o text-aqua"></i>Planned Complete Booking</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/plan_cancel_booking"><i class="fa fa-circle-o text-aqua"></i>Planned Cancel Booking</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/plan_new_booking"><i class="fa fa-circle-o text-aqua"></i>Planned New Booking</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/emergency_doctor_list"><i class="fa fa-circle-o text-aqua"></i>Emergency Doctor List</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/emergency_all_booking"><i class="fa fa-circle-o text-aqua"></i>Emergency All Booking</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/emergency_complete_booking"><i class="fa fa-circle-o text-aqua"></i>Emergency Complete Booking</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/emergency_cancel_booking"><i class="fa fa-circle-o text-aqua"></i>Emergency Cancel Booking</a></li>

               <li><a href="<?php echo base_url();?>doctor_doorstep/emergency_new_booking"><i class="fa fa-circle-o text-aqua"></i>Emergency New Booking</a></li>
            </ul>
         </li>

         <li class="<?php if($uri1 == 'medical_doorstep' || $uri1 == 'Medical_doorstep' || $uri2 == 'common_medical_service') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span>Medical Services Doorstep </span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>medical_doorstep/medical_doctor_list"><i class="fa fa-circle-o text-aqua"></i>Doctor List</a></li>

               <li><a href="<?php echo base_url();?>medical_doorstep/medical_all_booking"><i class="fa fa-circle-o text-aqua"></i>All Bookings</a></li>

               <li><a href="<?php echo base_url();?>medical_doorstep/medical_cancel_booking"><i class="fa fa-circle-o text-aqua"></i>Cancel Booking</a></li>

               <li><a href="<?php echo base_url();?>medical_doorstep/medical_complete_booking"><i class="fa fa-circle-o text-aqua"></i>Complete Booking</a></li>

               <li><a href="<?php echo base_url();?>medical_doorstep/medical_new_booking"><i class="fa fa-circle-o text-aqua"></i>New Booking</a></li>

               <li class=""><a href="<?php echo base_url();?>Affiliate_ctrl/common_medical_service"><i class="fa fa-circle-o text-aqua"></i> Common Medical Service </a></li>

            </ul>
         </li>

         <li class="<?php if($uri1  == 'Advertisment' || $uri1 == 'advertisment') {?>active<?php }?>">
            <a href="<?php echo base_url();?>Advertisment/advertisment_mange">
            <i class="fa fa-user-md"></i>
            <span>Advertisment Management </span>
            </a>
         </li>

         <li class="<?php if($uri1  == 'Doctordetail_ctrl' || $uri1 == 'doctordetail_ctrl') {?>active<?php }?>">
            <a href="<?php echo base_url();?>Doctordetail_ctrl/view_doctordetails">
            <i class="fa fa-user-md"></i>
            <span>Doctor Management</span>
            </a>
         </li>


          <li class="<?php if($uri1 == 'Surgery_ctrl' || $uri1 == 'surgery_ctrl') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-heartbeat"></i> <span>Surgery Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Surgery_ctrl/view_surgery"><i class="fa fa-circle-o text-aqua"></i>Surgery Details</a></li>
               <li><a href="<?php echo base_url();?>Surgery_ctrl/view_surgery_enquiry_quotation/new"><i class="fa fa-circle-o text-aqua"></i>New Surgery Enquiry Quotation</a></li>
                <li><a href="<?php echo base_url();?>Surgery_ctrl/view_surgery_enquiry_quotation/complete"><i class="fa fa-circle-o text-aqua"></i>Complete Surgery Enquiry Quotation</a></li>
                 <li><a href="<?php echo base_url();?>Surgery_ctrl/view_surgery_enquiry_quotation/reject"><i class="fa fa-circle-o text-aqua"></i>Reject Surgery Enquiry Quotation</a></li>
            </ul>
         </li>
         
          <li class="<?php if($uri1 == 'Nurse' || $uri1 == 'nurse' || $uri2 == 'common_service' || $uri2 == 'add_common_service') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span>Nurse</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Nurse/view_nursedetails"><i class="fa fa-circle-o text-aqua"></i>Nurse Details</a></li>
               <li><a href="<?php echo base_url();?>Nurse/nurse_all_booking"><i class="fa fa-circle-o text-aqua"></i>All Booking</a></li>
               <li><a href="<?php echo base_url();?>Nurse/nurse_new_booking"><i class="fa fa-circle-o text-aqua"></i>New Booking</a></li>
               <li><a href="<?php echo base_url();?>Nurse/nurse_cancel_booking"><i class="fa fa-circle-o text-aqua"></i>Cancel Booking</a></li>
               <li><a href="<?php echo base_url();?>Nurse/nurse_complete_booking"><i class="fa fa-circle-o text-aqua"></i>Complete Booking</a></li>

                <li class=""><a href="<?php echo base_url();?>Affiliate_ctrl/common_service"><i class="fa fa-circle-o text-aqua" aria-hidden="true"></i> Common Service </a></li>

            </ul>
         </li>

        <!--  <li class="treeview">
            <a href="#"><i class="fa fa-hospital-o"></i> <span>Clinic Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Clinic_ctrl/view_clinicdetails"><i class="fa fa-circle-o text-aqua"></i>Clinic Details</a></li>
               <li><a href="<?php echo base_url();?>Clinic_ctrl/add_clinicgallery"><i class="fa fa-circle-o text-aqua"></i>Clinic Gallery</a></li>
            </ul>
         </li> -->
         <!-- <li class="treeview"><a href="#"><i class="fa fa-heartbeat"></i> <span>Medical Center Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
            
            <li><a href="<?php echo base_url();?>Medical_ctrl/view_medicaldetails"><i class="fa fa-circle-o text-aqua"></i>Medical Center Details</a></li>  
            <li><a href="<?php echo base_url();?>Medical_ctrl/add_medicalgallery"><i class="fa fa-circle-o text-aqua"></i>Medical Center Gallery</a></li>
            </ul>
                         </li> -->
         <li class="<?php if($uri1 == 'Hospital_ctrl' || $uri1 == 'hospital_ctrl') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-h-square"></i> <span>Hospital Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Hospital_ctrl/view_hospitals"><i class="fa fa-circle-o text-aqua"></i>Hospital Details</a></li>
               <li class="treeview"><a href="<?php echo base_url();?>Insurance_ctrl/add_insurancedetail"><i class="fa fa-indent" aria-hidden="true"></i> <span>Add Insurance </span><i class="fa fa-angle-left pull-right"></i></a></li>
               <!-- <li><a href="<?php echo base_url();?>Hospital_ctrl/add_hospitalgallery"><i class="fa fa-circle-o text-aqua"></i>Hospital Gallery</a></li> -->
            </ul>
         </li>
        <!--  <li class="<?php if($uri1 == 'Appoinment_ctrl' || $uri1 == 'appoinment_ctrl') {?>active<?php }?>"><a href="<?php echo base_url();?>Appoinment_ctrl/view_appoinmentdetails"><i class=" fa fa-credit-card"></i>  <span>Booking Details</span><i class="fa fa-angle-left pull-right"></i></a>
         </li> -->
         <li class="<?php if($uri1 == 'Country_ctrl' || $uri1 == 'country_ctrl') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-globe" aria-hidden="true"></i> <span>Manage Location</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <!--  <li><a href="<?php echo base_url();?>Country_ctrl/add_countryname"><i class="fa fa-circle-o text-aqua"></i>Add Country </a></li>  -->
               <li><a href="<?php echo base_url();?>Country_ctrl/add_statename"><i class="fa fa-circle-o text-aqua"></i>Add State </a></li>
               <li><a href="<?php echo base_url();?>Country_ctrl/add_cityname"><i class="fa fa-circle-o text-aqua"></i>Add City </a></li>
            </ul>
         </li>
         <!-- <li class="treeview"><a href=""><i class="fa fa-star-o" aria-hidden="true"></i> <span>Manage Package </span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">                
            <li><a href="<?php echo base_url();?>Package_ctrl/add_package"><i class="fa fa-circle-o text-aqua"></i>Add Doctor Package</a></li>                 
            <li><a href="<?php echo base_url();?>Package_ctrl/hospital_package"><i class="fa fa-circle-o text-aqua"></i>Add Hospital Package</a></li>                   
            </ul>
                         </li> -->
         <!-- <li class="treeview">
            <a href="#"><i class="fa fa-shopping-cart"></i> <span>Chemist Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Chemist_ctrl/view_chemistdetails"><i class="fa fa-circle-o text-aqua"></i>Chemist Details</a></li>
            </ul>
         </li> -->
         <li class="<?php if($uri1 == 'Package_ctrl' || $uri1 == 'package_ctrl') {?>treeview active<?php }?>">
            <a href=""><i class="fa fa-globe" aria-hidden="true"></i> <span>OPD Manage Package</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <!-- <li><a href="<?php echo base_url();?>Package_ctrl/add_package"><i class="fa fa-circle-o text-aqua"></i>Add Doctor Package</a></li>                  
                  <li><a href="<?php echo base_url();?>Package_ctrl/hospital_package"><i class="fa fa-circle-o text-aqua"></i>Add Hospital Package</a></li>  -->
               <li><a href="<?php echo base_url();?>Package_ctrl/view_patientpackage"><i class="fa fa-circle-o text-aqua"></i>Patient Package</a></li>

                <li><a href="<?php echo base_url();?>Package_ctrl/package_history"><i class="fa fa-circle-o text-aqua"></i>Package History</a></li>
            </ul>
         </li>
         <li class="<?php if($uri2 == 'view_department' || $uri2 == 'edit_departments' || $uri2 == 'add_degreedetail' || $uri2 == 'add_speciality' || $uri2 == 'view_post' || $uri2 == 'view_allergies' || $uri2 == 'view_illnesses' || $uri2 == 'view_surgeries' || $uri2 == 'edit_degreesval' || $uri2 == 'view_complain_reason' || $uri2 == 'view_time_limit') {?>treeview active<?php }?>">
            <a href=""><i class="fa fa-globe" aria-hidden="true"></i> <span>Manage Additional Details</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

              

               <!-- <li class="treeview"><a href="<?php echo base_url();?>Language_ctrl/add_languages"><i class="fa fa-language" aria-hidden="true"></i> <span>Add Language </span><i class="fa fa-angle-left pull-right"></i></a></li>
                  <li class="treeview"><a href="<?php echo base_url();?>Currency_ctrl/add_currencies"><i class="fa fa-globe" aria-hidden="true"></i> <span>Add Currency </span><i class="fa fa-angle-left pull-right"></i></a></li> -->
               <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_department"><i class="fa fa-houzz" aria-hidden="true"></i> <span>Add Department  </span></a></li>
               <!--  <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/add_affiliatedetails"><i class="fa fa-houzz" aria-hidden="true"></i> <span>Add Affiliated  </span></a></li> -->
               <!-- <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_department"><i class="fa fa-houzz" aria-hidden="true"></i> <span>Add Department  </span></a></li> -->
               <!-- <li class="treeview"><a href="<?php echo base_url();?>Amenities_ctrl/add_amenitiesdetails"><i class="fa fa-futbol-o" aria-hidden="true"></i> <span>Add Amenities </span></a></li> -->
               <!-- <li class="treeview"><a href="<?php echo base_url();?>Visitation_ctrl/add_visitations"><i class="fa fa-crosshairs"></i> <span>Add Visitation</span></a></li> -->
               <li class="treeview"><a href="<?php echo base_url();?>Doctordegree_ctrl/add_degreedetail"><i class="fa fa-deviantart"></i> <span>Add Doctor Degree </span></a></li>
               
               <li class="treeview"><a href="<?php echo base_url();?>Speciality_ctrl/add_speciality"><i class="fa fa-eye" aria-hidden="true"></i> <span>Add  Specialty</span></a></li>
               <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_post"><i class="fa fa-eye" aria-hidden="true"></i> <span>Add  Post</span></a></li>

                <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_allergies"><i class="fa fa-eye" aria-hidden="true"></i> <span>Add Allergies</span></a></li>

               <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_illnesses"><i class="fa fa-eye" aria-hidden="true"></i> <span>Add Illnesses</span></a></li>

               <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_surgeries"><i class="fa fa-eye" aria-hidden="true"></i> <span>Add Surgeries</span></a></li>

                 <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_complain_reason"><i class="fa fa-eye" aria-hidden="true"></i> <span>Master Complain Reason</span></a></li>


                 <li class="treeview"><a href="<?php echo base_url();?>Affiliate_ctrl/view_time_limit"><i class="fa fa-eye" aria-hidden="true"></i> <span>Master Time Limit</span></a></li>
               
               <!-- <li class="treeview"><a href="<?php echo base_url();?>Cities/add_cities"><i class="fa fa-eye" aria-hidden="true"></i> <span>Add  Cities</span><i class="fa fa-angle-left pull-right"></i></a></li> -->
               <!-- <li class="treeview"><a href="<?php echo base_url();?>Services/add_services"><i class="fa fa-eye" aria-hidden="true"></i> <span>Add Services</span><i class="fa fa-angle-left pull-right"></i></a></li> -->
            </ul>
         </li>
         <li class="<?php if($uri1 == 'Lab_ctrl' || $uri1 == 'lab_ctrl') {?>treeview active<?php }?>">
            <a href=""><i class="fa fa-hospital-o"></i> <span>Test Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url();?>Lab_ctrl/view_labdetails"><i class="fa fa-circle-o text-aqua"></i>Test Details</a></li>

               <li><a href="<?php echo base_url();?>Lab_ctrl/view_packagedetails"><i class="fa fa-circle-o text-aqua"></i>Test Package</a></li>

               <li><a href="<?php echo base_url();?>Lab_ctrl/labdetails"><i class="fa fa-circle-o text-aqua"></i>Lab</a></li>
                <li><a href="<?php echo base_url();?>Lab_ctrl/booking_test/all_booking"><i class="fa fa-circle-o text-aqua"></i>All Booking Test</a></li>
               <li><a href="<?php echo base_url();?>Lab_ctrl/booking_test/new_booking"><i class="fa fa-circle-o text-aqua"></i>New Booking Test</a></li>
               <li><a href="<?php echo base_url();?>Lab_ctrl/booking_test/complete_booking"><i class="fa fa-circle-o text-aqua"></i>Complete Booking Test</a></li>
               <li><a href="<?php echo base_url();?>Lab_ctrl/booking_test/cancel_booking"><i class="fa fa-circle-o text-aqua"></i>Cancel Booking Test</a></li>
            </ul>
         </li>
        <!--  <li class="treeview">
            <a href=""><i class="fa fa-hospital-o"></i> <span>Card Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Card_ctrl/view_carddetails"><i class="fa fa-circle-o text-aqua"></i>Card Details</a></li>
            </ul>
         </li> -->
         <!-- <li class="treeview"><a href=""><i class="fa fa-globe" aria-hidden="true"></i> <span>Manage Rating</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu"> -->
         <!-- <li><a href="<?php echo base_url();?>Rating_ctrl/view_ratingdetails"><i class="fa fa-circle-o text-aqua"></i>Clinic Rating </a></li> -->   
         <!-- <li><a href="<?php echo base_url();?>Rating_ctrl/view_doctorpopup"><i class="fa fa-circle-o text-aqua"></i>Doctor Rating </a></li> -->
         <!-- <li><a href="<?php echo base_url();?>Rating_ctrl/view_hospitalpopup"><i class="fa fa-circle-o text-aqua"></i>Hospital Rating </a></li>
            <li><a href="<?php echo base_url();?>Rating_ctrl/view_medicalpopup"><i class="fa fa-circle-o text-aqua"></i>Medical Rating </a></li> -->
         <!-- </ul>
            </li> -->
         <li class="<?php if($uri1 == 'Banner_ctrl' || $uri1 == 'banner_ctrl' || $uri2 == 'add_patientbanner') {?>treeview active<?php }?>"><a href=""><i class="fa fa-file-image-o" aria-hidden="true"></i> <span>Banner Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>Banner_ctrl/view_patientbanner"><i class="fa fa-circle-o text-aqua"></i>Patient Appointment Banners</a></li>  
            <!-- <li><a href="<?php echo base_url();?>Banner_ctrl/view_doctorbanner"><i class="fa fa-circle-o text-aqua"></i>Doctor Appointment Banners </a></li>
             --></ul>
                         </li>
        <!--  <li class="treeview">
            <a href="#"><i class="fa fa-user-md"></i> <span>Enquiry Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Patient_details/new_enquiry"><i class="fa fa-circle-o text-aqua"></i>New Enquiry</a></li>
               <li><a href="<?php echo base_url();?>Patient_details/complete_enquiry"><i class="fa fa-circle-o text-aqua"></i>Completed Enquiry</a></li>
               <li><a href="<?php echo base_url();?>Patient_details/unsolved_enquiry"><i class="fa fa-circle-o text-aqua"></i>Unsolved Enquiry</a></li>
            </ul>
         </li> -->

       <!--   <li class="treeview">
            <a href="#"><i class="fa fa-user-md"></i> <span>Contact Us Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Patient_details/new_contact"><i class="fa fa-circle-o text-aqua"></i>New Contact</a></li>
               <li><a href="<?php echo base_url();?>Patient_details/complete_contact"><i class="fa fa-circle-o text-aqua"></i>Completed Contact</a></li>
               <li><a href="<?php echo base_url();?>Patient_details/unsolved_contact"><i class="fa fa-circle-o text-aqua"></i>Unsolved Contact</a></li>
            </ul>
         </li> -->
         <li class="<?php if($uri2 == 'coupan_list' || $uri2 == 'add_coupan' || $uri2 == 'edit_coupan') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-fw fa-tags"></i> <span>Coupon Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>speedhuntson/coupan_list"><i class="fa fa-fw fa-tags"></i>Coupon List</a></li>
               <!-- <li><a href="<?php echo base_url();?>Patient_details/complete_contact"><i class="fa fa-circle-o text-aqua"></i>Completed Contact</a></li>
               <li><a href="<?php echo base_url();?>Patient_details/unsolved_contact"><i class="fa fa-circle-o text-aqua"></i>Unsolved Contact</a></li> -->
            </ul>
         </li>
         <!-- <li class="treeview"><a href=""><i class="fa fa-star-o" aria-hidden="true"></i> <span>Language Translation</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu"> -->
         <!--<li><a href="<?php //echo base_url();?>Language_translation/add_language"><i class="fa fa-circle-o text-aqua"></i>Add Language Translation</a></li>
            <li><a href="<?php //echo base_url();?>Language_translation/view_language"><i class="fa fa-circle-o text-aqua"></i>View Language Translation</a></li> -->
         <!-- <li><a href="<?php echo base_url();?>Home_Translation/view_home"><i class="fa fa-circle-o text-aqua"></i>Home Translation</a></li>
            <li><a href="<?php echo base_url();?>Search_Translation/view_search"><i class="fa fa-circle-o text-aqua"></i>Search Translation</a></li>
            <li><a href="<?php echo base_url();?>Login_Translation/view_login"><i class="fa fa-circle-o text-aqua"></i>Login Translation</a></li>
            <li><a href="<?php echo base_url();?>Doctorfilter_Translation/view_doctorfilter"><i class="fa fa-circle-o text-aqua"></i>Doctor Filter Translation</a></li>
            <li><a href="<?php echo base_url();?>Clinicfilter_Translation/view_clinicfilter"><i class="fa fa-circle-o text-aqua"></i>Clinic Filter Translation</a></li>
            <li><a href="<?php echo base_url();?>Medicalfilter_Translation/view_medicalfilter"><i class="fa fa-circle-o text-aqua"></i>Medical  Filter Translation</a></li>
            <li><a href="<?php echo base_url();?>Hospitalfilter_Translation/view_hospitalfilter"><i class="fa fa-circle-o text-aqua"></i>Hospital  Filter Translation</a></li>
            <li><a href="<?php echo base_url();?>Doctorprofile_Translation/view_doctorprofile"><i class="fa fa-circle-o text-aqua"></i>  Doctor Profile Translation</a></li>
            <li><a href="<?php echo base_url();?>Hospitalprofile_Translation/view_hospitalprofile"><i class="fa fa-circle-o text-aqua"></i>  Hospital Profile Translation</a></li>
            <li><a href="<?php echo base_url();?>Clinicprofile_Translation/view_clinicprofile"><i class="fa fa-circle-o text-aqua"></i>  Clinic Profile Translation</a></li>
            <li><a href="<?php echo base_url();?>Medicalprofile_Translation/view_medicalprofile"><i class="fa fa-circle-o text-aqua"></i>  Medical Profile Translation</a></li>
            <li><a href="<?php echo base_url();?>Doctor_Translation/view_doctor"><i class="fa fa-circle-o text-aqua"></i> Doctor Translation</a></li>
            <li><a href="<?php echo base_url();?>Hospital_Translation/view_hospital"><i class="fa fa-circle-o text-aqua"></i>Hospital Translation</a></li>
            <li><a href="<?php echo base_url();?>Patient_Translation/view_patient"><i class="fa fa-circle-o text-aqua"></i>  Patient Translation</a></li>
            <li><a href="<?php echo base_url();?>About_Translation/view_about"><i class="fa fa-circle-o text-aqua"></i>  About Translation</a></li>
            <li><a href="<?php echo base_url();?>Terms_Translation/view_terms"><i class="fa fa-circle-o text-aqua"></i>  Terms Translation</a></li>
            <li class="treeview"><a href="#"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span>Banner Management</span><i class="fa fa-angle-left pull-right"></i></a>
            
                          </li> -->
         <!-- <li><a href="<?php echo base_url();?>Booking_Translation/view_booking"><i class="fa fa-circle-o text-aqua"></i>  Booking Translation</a></li> -->
      </ul>
      </ul>
      </li>

      <li class="<?php if($uri2 == 'send_single_notification' || $uri1 == 'send_to_all_notification') {?>treeview active<?php }?>">
            <a href=""><i class="fa fa-globe" aria-hidden="true"></i> <span>Send Notification</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>Patient_details/send_single_notification/"><i class="fa fa-circle-o text-aqua"></i>Single User</a></li>
               <li><a href="<?php echo base_url();?>Patient_details/send_to_all_notification"><i class="fa fa-circle-o text-aqua"></i>All User</a></li>
            </ul>
         </li>


      <li>
         <a href="<?php echo base_url(); ?>Settings_ctrl/view_settings"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span></a>
      </li>
      </ul>
   </section>
   <!-- /.sidebar -->
</aside>