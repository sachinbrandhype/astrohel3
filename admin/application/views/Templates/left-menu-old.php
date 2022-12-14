<?php
   $id = $this->session->userdata('logged_in')['id'];
   $admin_detail = pull_admin();
   $uri1 = $this->uri->segment(1);
   $uri2 = $this->uri->segment(2);
   $uri3 = $this->uri->segment(3);
   $uri5 = $this->uri->segment(5);
  
   ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
         <div class="pull-left image">
            <?php if ($admin_detail[0]->profile_picture != NULL) { ?>
            <img src="<?php echo base_url() . $admin_detail[0]->profile_picture; ?>" class="img-circle" alt="User Image">
            <?php } else { ?>
            <img src="<?php echo base_url(); ?>assets/images/user_avatar.jpg" class="img-circle" alt="User Image">
            <?php } ?>
         </div>
         <div class="pull-left info">
            <p><?php $a = $this->session->userdata('logged_in');
               echo $a['username']; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
         </div>
      </div>
      <ul class="sidebar-menu">
         <li class="header">MAIN NAVIGATION</li>
         <li class="<?php if ($uri1 == 'welcome') { ?>active<?php } ?>">
            <a href="<?php echo base_url(); ?>welcome">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
            </a>
         </li>
        <!--  <li class="<?php if ($uri2 == 'view_userdetails' || $uri2 == 'member_view' || $uri2 == 'transaction_view' || $uri2 == 'patient_view') { ?>active<?php } ?>">
            <a href="<?php echo base_url(); ?>User_details/view_userdetails">
            <i class="fa fa-male"></i>
            <span>User Details</span>
            </a>
         </li> -->


         <li class="<?php if ($uri1 == 'User_details' || $uri2 == 'view_userdetails'|| $uri2 == 'view_disabled_userdetails' ) { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-male"></i> <span>User Details</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class="<?php if ($uri2 == 'view_userdetails') { ?>active<?php } ?>">
                <a href="<?php echo base_url(); ?>User_details/view_userdetails">
                  <i class="fa fa-male"></i><span>Active User </span></a>
              </li>
              <li class="<?php if ($uri2 == 'view_disabled_userdetails') { ?>active<?php } ?>"> <a href="<?php echo base_url(); ?>User_details/view_disabled_userdetails">
                  <i class="fa fa-male"></i><span>Disabled User </span></a>
              </li>
              <li> <a href="<?php echo base_url(); ?>User_details/view_userdelete_details">
                  <i class="fa fa-male"></i><span>Archived Users</span></a>
              </li>
            </ul>
         </li>


         <li class="<?php if ($uri2 == 'notification') { ?>active<?php } ?>">
            <a href="<?php echo base_url(); ?>User_details/notification">
            <i class="fa fa-bell"></i>
            <span>Notification</span>
            </a>
         </li>
         <!--  <li class="<?php if ($uri2 == 'price') { ?>active<?php } ?>">
            <a href="<?php echo base_url(); ?>Settings_ctrl/price"><i class="fa fa-rupee" aria-hidden="true"></i><span>Price</span></a>
            </li> -->
         <!-- 
            <li class="<?php if($uri2 == 'sold_enquiry') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-envelope-o"></i> <span >Enquiry</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url();?>speedhuntson/sold_enquiry/sold" <?php if($uri2 == 'sold_enquiry' && $uri3 == 'sold'){?> style="color:#000" <?php }?>><i class="fa fa-circle-o"></i> Solve </a></li> 
              <li><a href="<?php echo base_url();?>speedhuntson/sold_enquiry/unsold" <?php if($uri2 == 'sold_enquiry'  && $uri3 == 'unsold'){?> style="color:#000" <?php }?>><i class="fa fa-circle-o"></i> Unsolve</a></li>
            
            </ul>
            </li> -->
         <li class="<?php if ($uri1 == 'supervisor' || $uri1 == 'index' ) { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-male"></i> <span>Supervisor Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>supervisor" <?php if ($uri2 == 'supervisor' || $uri2 =='index') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>View</a></li>
            </ul>
         </li>
         <li class="<?php if ($uri1 == 'priest' || $uri1 == 'index' ) { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-male"></i> <span>Priest Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>priest" <?php if ($uri2 == 'priest' || $uri2 =='index') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>View</a></li>
            </ul>
         </li>
         <li class="<?php if ($uri1 == 'agent' || $uri1 == 'index' ) { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-male"></i> <span>Agent Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>agent/enterprise" <?php if ($uri1 == 'agent' && $uri2 =='enterprise') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Enterprise Agent</a></li>
               <li><a href="<?php echo base_url(); ?>agent" <?php if ($uri1 == 'agent' && $uri2 =='') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Agent</a></li>
            </ul>
         </li>
         <li class="<?php if ($uri1 == 'pooja' || $uri1 == 'pooja' ) { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-file-image-o" aria-hidden="true"></i> <span>Puja Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>pooja/" <?php if ($uri2 == 'index' || $uri2 =='') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Puja Lists</a></li>
               <li><a href="<?php echo base_url(); ?>pooja/add_pooja" <?php if ($uri2 == 'add_pooja') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Add Puja</a></li>
                <li><a href="<?php echo base_url(); ?>pooja/pooja_categories" <?php if ($uri2 == 'pooja_categories') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Puja Categories</a></li> 
               <!-- <li><a href="<?php echo base_url(); ?>pooja/pooja_venues" <?php if ($uri2 == 'pooja_venues') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Puja Venues</a></li> -->
               <!-- <li><a href="<?php echo base_url(); ?>pooja/pooja_yajmans" <?php if ($uri2 == 'pooja_yajmans') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Puja Yajmans</a></li> -->
               <li><a href="<?php echo base_url(); ?>pooja/pooja_locations" <?php if ($uri2 == 'pooja_locations') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Puja Locations</a></li>
            </ul>
         </li>  


          <li class="<?php if($uri1 == 'life_prediction' || $uri1 == 'Life_prediction') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span > Life prediction</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
           
               <li><a href="<?php echo base_url();?>life_prediction/prediction/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
               <li><a href="<?php echo base_url();?>life_prediction/prediction/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>

               <li><a href="<?php echo base_url();?>life_prediction/prediction/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>

               <li><a href="<?php echo base_url();?>life_prediction/prediction/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>

              

              
            </ul>
         </li>

         
         <li class="<?php if ($uri1.'/'.$uri2 == 'sd/astrologers' ) { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-user" aria-hidden="true"></i> <span>Astrologers  Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>sd/astrologers/astologers_list_verified" <?php if ($uri3 =='astologers_list_verified') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Verified Astrologers</a></li>
               <li><a href="<?php echo base_url(); ?>sd/astrologers/astologers_list_pending" <?php if ($uri3 =='astologers_list_pending') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Pending Astrologers</a></li>
               <li><a href="<?php echo base_url(); ?>sd/astrologers/astologers_list_disabled" <?php if ($uri3 == 'astologers_list_disabled') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Disabled Atrologers</a></li>

               <li><a href="<?php echo base_url(); ?>sd/astrologers/add_astrologers" <?php if ($uri3 == 'add_astrologers') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Add Atrologers</a></li>
            </ul>
         </li>
         
         <li class="<?php if ($uri1 == 'Broadcasts_management' ) { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-user" aria-hidden="true"></i> <span>Broadcasts  Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>Broadcasts_management/broadcasts" <?php if ($uri2 =='broadcasts') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>List</a></li>
              
            </ul>
         </li>
         <li class="<?php if ($uri1.'/'.$uri2 == 'sd/app_management' || $uri2 == 'view_banner' || $uri2 == 'view_banner_mid'|| $uri2 == 'view_banner_coupan') { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-file-image-o" aria-hidden="true"></i> <span>App Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

               <li><a href="<?php echo base_url(); ?>Banner_ctrl/view_banner" <?php if ($uri2 == 'view_banner' || $uri2 == 'add_patientbanner') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Main Banners</a></li>


               <li><a href="<?php echo base_url(); ?>Banner_ctrl/view_banner_mid" <?php if ($uri2 == 'view_banner_mid' || $uri2 == 'add_patientbanner_mid') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Mid Banners</a></li>


               <li><a href="<?php echo base_url(); ?>Banner_ctrl/view_banner_coupan" <?php if ($uri2 == 'view_banner_coupan' || $uri2 == 'add_patientbanner_mid') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Banner Offers</a></li>



               <!-- <li><a href="<?php echo base_url(); ?>user_news_ctrl/user_news" <?php if ($uri2 == 'user_news' || $uri2 == 'add_user_news') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>News</a></li> -->
               <!-- <li><a href="<?php echo base_url(); ?>user_video_ctrl/user_video" <?php if ($uri2 == 'user_video' || $uri2 == 'add_user_video') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i> Video</a></li> -->
               <li><a href="<?php echo base_url(); ?>sd/app_management/gallery" <?php if ($uri3 == 'gallery') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Gallery</a></li>
               <li><a href="<?php echo base_url(); ?>sd/app_management/testimonials" <?php if ($uri3 == 'testimonials') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Testimonials</a></li>
            </ul>
         </li>




         <li class="<?php if ($uri1.'/'.$uri2 == 'sd/ropeway_management') { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-arrows-h" aria-hidden="true"></i> <span>Ropeway Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>sd/ropeway_management/ropeway" <?php if ($uri3 == 'ropeway') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Ropeway</a></li>
            </ul>
         </li>

         <li class="<?php if ($uri1.'/'.$uri2 == 'sd/kumbh_management') { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-home" aria-hidden="true"></i> <span>Kumbh Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>sd/kumbh_management/kumbh" <?php if ($uri3 == 'kumbh') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Kumbh</a></li>
            </ul>
         </li>


         <li class="<?php if ($uri1 == 'Master_ctrl' || $uri1 == 'Language_ctrl' || $uri1 == 'Master_ctrl' || $uri2 == 'add_gems_products'|| $uri2 == 'zodiac'|| $uri2 == 'master_minutes'|| $uri2 == 'marital_status' || $uri1.'/'.$uri2 == 'sd/edit_master') { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-diamond" aria-hidden="true"></i> <span>Master</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>pooja/pooja_locations" <?php if ($uri2 == 'pooja_locations') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Puja zzzzzLocations</a></li>

               <li><a href="<?php echo base_url(); ?>sd/edit_master/master_occupation" <?php if ($uri3 == 'master_occupation') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Occupation</a></li>
               <li><a href="<?php echo base_url(); ?>sd/edit_master/master_cities" <?php if ($uri3 == 'master_cities') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Cities</a></li>
               
               <!-- <li class="treeview"><a href="<?php echo base_url();?>Language_ctrl/add_languages" <?php if ($uri3 == 'add_languages') { ?> style="color:#fff" <?php } ?>><i class="fa fa-language" aria-hidden="true"></i> <span>Add Language </span><i class="fa fa-angle-left pull-right"></i></a></li> -->

                <li><a href="<?php echo base_url(); ?>sd/edit_master/marital_status" <?php if ($uri3 == 'marital_status') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Marital Status</a></li>


                <li><a href="<?php echo base_url(); ?>sd/edit_master/master_problems" <?php if ($uri3 == 'master_problems') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Master Problems</a></li>
               
                <li><a href="<?php echo base_url(); ?>sd/edit_master/master_god" <?php if ($uri3 == 'master_god') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Master God</a></li>


                <li><a href="<?php echo base_url(); ?>sd/edit_master/master_temple" <?php if ($uri3 == 'master_temple') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Master Temple</a></li>
               

                <li><a href="<?php echo base_url(); ?>sd/edit_master/zodiac" <?php if ($uri3 == 'zodiac') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Zodiac</a></li>
               
                 <li><a href="<?php echo base_url(); ?>sd/edit_master/master_cancellation" <?php if ($uri3 == 'master_occupation') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Cancellation Policy</a></li>

             
            </ul>
         </li>

         <li class="<?php if($uri1 == 'online_consultation' || $uri1 == 'Online_consultation') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-reorder"></i> <span >Order Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li class="<?php if($uri1 == 'online_consultation' || $uri1 == 'Online_consultation') {?>treeview active<?php }?>">
                <a href="#"><i class="fa fa-steam"></i> Puja Management
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php 

                   ?>
                  <li><a href="<?php echo base_url();?>online_consultation/online_booking/all_booking" <?php if($uri3 == 'all_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li>
                  <li><a href="<?php echo base_url();?>online_consultation/online_booking/new_booking" <?php if($uri3 == 'new_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
                  <li><a href="<?php echo base_url();?>online_consultation/online_booking/complete_booking" <?php if($uri3 == 'complete_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
                  <li><a href="<?php echo base_url();?>online_consultation/online_booking/cancel_booking" <?php if($uri3 == 'cancel_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>      
                </ul>
              </li>
            </ul>
         </li>

         <!-- <li class="<?php if($uri1 == 'online_consultation' || $uri1 == 'Online_consultation') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span >Puja Booking</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>online_consultation/online_booking/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li>
               <li><a href="<?php echo base_url();?>online_consultation/online_booking/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
               <li><a href="<?php echo base_url();?>online_consultation/online_booking/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
               <li><a href="<?php echo base_url();?>online_consultation/online_booking/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>
            </ul>
         </li> -->
         <!-- 
            <li class="<?php if($uri1 == 'medical_module' || $uri1 == 'Medical_module') {?>treeview active<?php }?>">
              <a href="#"><i class="fa fa-user-md"></i> <span >Medical Module</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
             
                 <li><a href="<?php echo base_url();?>medical_module/medical/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'medical_module'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
                 <li><a href="<?php echo base_url();?>medical_module/medical/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'medical_module'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
            
                 <li><a href="<?php echo base_url();?>medical_module/medical/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'medical_module'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
            
                 <li><a href="<?php echo base_url();?>medical_module/medical/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'medical_module'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>
            
                
            
                
              </ul>
            </li> -->
         <!--          
            <li class="<?php if($uri1 == 'life_prediction' || $uri1 == 'Life_prediction') {?>treeview active<?php }?>">
                       <a href="#"><i class="fa fa-user-md"></i> <span > Life prediction</span><i class="fa fa-angle-left pull-right"></i></a>
                       <ul class="treeview-menu">
                      
                          <li><a href="<?php echo base_url();?>life_prediction/prediction/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
                          <li><a href="<?php echo base_url();?>life_prediction/prediction/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
            
                          <li><a href="<?php echo base_url();?>life_prediction/prediction/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
            
                          <li><a href="<?php echo base_url();?>life_prediction/prediction/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>
            
                         
            
                         
                       </ul>
                    </li> -->
         <!-- 
            <li class="<?php if($uri1 == 'Horoscope_matching' || $uri1 == 'horoscope_matching') {?>treeview active<?php }?>">
               <a href="#"><i class="fa fa-user-md"></i> <span >  Match Making </span><i class="fa fa-angle-left pull-right"></i></a>
               <ul class="treeview-menu">
              
                  <li><a href="<?php echo base_url();?>Horoscope_matching/matching/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'Horoscope_matching'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
                  <li><a href="<?php echo base_url();?>Horoscope_matching/matching/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'Horoscope_matching'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
            
                  <li><a href="<?php echo base_url();?>Horoscope_matching/matching/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'Horoscope_matching'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
            
                  <li><a href="<?php echo base_url();?>Horoscope_matching/matching/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'Horoscope_matching'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>
            
                 
            
                 
               </ul>
            </li> -->
         <!-- 
            <li class="<?php if($uri1 == 'pdf_booking' || $uri1 == 'Online_consultation') {?>treeview active<?php }?>">
              <a href="#"><i class="fa fa-user-md"></i> <span >Pdf Booking</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
             
                 <li><a href="<?php echo base_url();?>pdf_booking/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'pdf_booking'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
                 <li><a href="<?php echo base_url();?>pdf_booking/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'pdf_booking'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
            
                 <li><a href="<?php echo base_url();?>pdf_booking/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'pdf_booking'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
            
                 <li><a href="<?php echo base_url();?>pdf_booking/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'pdf_booking'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>
                
              </ul>
            </li> -->
         <!-- 
            <li class="<?php if($uri1 == 'inperson_ctrl' || $uri1 == 'inperson_ctrl' || $uri2 == 'in_person_events') {?>treeview active<?php }?>">
               <a href="#"><i class="fa fa-user-md"></i> <span >In Person Management</span><i class="fa fa-angle-left pull-right"></i></a>
               <ul class="treeview-menu">
            
                     <li><a href="<?php echo base_url();?>class_package/in_person_events" <?php if($uri2 == 'in_person_events' ){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> In Person Events</a></li> 
            
              
                  <li><a href="<?php echo base_url();?>inperson_ctrl/inperson/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'inperson_ctrl'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
                  <li><a href="<?php echo base_url();?>inperson_ctrl/inperson/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'inperson_ctrl'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
            
                  <li><a href="<?php echo base_url();?>inperson_ctrl/inperson/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'inperson_ctrl'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
            
                  <li><a href="<?php echo base_url();?>inperson_ctrl/inperson/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'inperson_ctrl'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>
            
               </ul>
            </li> -->
         <!-- 
            <li>
              <a href="<?php echo base_url(); ?>Master_ctrl/expert_management" <?php if ($uri3 == 'expert_management') { ?> style="color:#fff" <?php } ?>><i class="fa fa-wrench" aria-hidden="true"></i><span>Expert Management</span></a>
            </li> -->
         <!-- <li class="<?php if($uri1 == 'class_package' || $uri1 == 'Class_package') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span >Class Package</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
            
               <li><a href="<?php echo base_url();?>class_package/list_package" <?php if($uri2 == 'list_package' && $uri1 == 'class_package'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> List Package</a></li> 
            
            
               <li><a href="<?php echo base_url();?>class_package/purchase_history" <?php if($uri2 == 'purchase_history' && $uri1 == 'class_package'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Package Purchase History</a></li> 
            
            
                
            
              
            
            </ul>
            </li> -->
         <!--  <li class="treeview">
            <a href="#"><i class="fa fa-user-md"></i> <span>Enquiry Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>Patient_details/new_enquiry"><i class="fa fa-circle-o text-aqua"></i>New Enquiry</a></li>
               <li><a href="<?php echo base_url(); ?>Patient_details/complete_enquiry"><i class="fa fa-circle-o text-aqua"></i>Completed Enquiry</a></li>
               <li><a href="<?php echo base_url(); ?>Patient_details/unsolved_enquiry"><i class="fa fa-circle-o text-aqua"></i>Unsolved Enquiry</a></li>
            </ul>
            </li> -->
         <!--   <li class="treeview">
            <a href="#"><i class="fa fa-user-md"></i> <span>Contact Us Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>Patient_details/new_contact"><i class="fa fa-circle-o text-aqua"></i>New Contact</a></li>
               <li><a href="<?php echo base_url(); ?>Patient_details/complete_contact"><i class="fa fa-circle-o text-aqua"></i>Completed Contact</a></li>
               <li><a href="<?php echo base_url(); ?>Patient_details/unsolved_contact"><i class="fa fa-circle-o text-aqua"></i>Unsolved Contact</a></li>
            </ul>
            </li> -->
         <!--   <li class="<?php if ($uri2 == 'coupan_list' || $uri2 == 'add_coupan' || $uri2 == 'edit_coupan') { ?>treeview active<?php } ?>">
            <a href="#"><i class="fa fa-fw fa-tags"></i> <span>Coupon Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>speedhuntson/coupan_list" <?php if ($uri2 == 'coupan_list' || $uri2 == 'edit_coupan') { ?> style="color:#fff" <?php } ?>><i class="fa fa-fw fa-tags"></i>Coupon List</a></li> -->
         <!-- <li><a href="<?php echo base_url(); ?>Patient_details/complete_contact"><i class="fa fa-circle-o text-aqua"></i>Completed Contact</a></li>
            <li><a href="<?php echo base_url(); ?>Patient_details/unsolved_contact"><i class="fa fa-circle-o text-aqua"></i>Unsolved Contact</a></li> -->
         <!--    </ul>
            </li> -->
         <!-- <li class="treeview"><a href=""><i class="fa fa-star-o" aria-hidden="true"></i> <span>Language Translation</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu"> -->
         <!--<li><a href="<?php //echo base_url();
            ?>Language_translation/add_language"><i class="fa fa-circle-o text-aqua"></i>Add Language Translation</a></li>
            <li><a href="<?php //echo base_url();
               ?>Language_translation/view_language"><i class="fa fa-circle-o text-aqua"></i>View Language Translation</a></li> -->
         <!-- <li><a href="<?php echo base_url(); ?>Home_Translation/view_home"><i class="fa fa-circle-o text-aqua"></i>Home Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Search_Translation/view_search"><i class="fa fa-circle-o text-aqua"></i>Search Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Login_Translation/view_login"><i class="fa fa-circle-o text-aqua"></i>Login Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Doctorfilter_Translation/view_doctorfilter"><i class="fa fa-circle-o text-aqua"></i>Doctor Filter Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Clinicfilter_Translation/view_clinicfilter"><i class="fa fa-circle-o text-aqua"></i>Clinic Filter Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Medicalfilter_Translation/view_medicalfilter"><i class="fa fa-circle-o text-aqua"></i>Medical  Filter Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Hospitalfilter_Translation/view_hospitalfilter"><i class="fa fa-circle-o text-aqua"></i>Hospital  Filter Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Doctorprofile_Translation/view_doctorprofile"><i class="fa fa-circle-o text-aqua"></i>  Doctor Profile Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Hospitalprofile_Translation/view_hospitalprofile"><i class="fa fa-circle-o text-aqua"></i>  Hospital Profile Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Clinicprofile_Translation/view_clinicprofile"><i class="fa fa-circle-o text-aqua"></i>  Clinic Profile Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Medicalprofile_Translation/view_medicalprofile"><i class="fa fa-circle-o text-aqua"></i>  Medical Profile Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Doctor_Translation/view_doctor"><i class="fa fa-circle-o text-aqua"></i> Doctor Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Hospital_Translation/view_hospital"><i class="fa fa-circle-o text-aqua"></i>Hospital Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Patient_Translation/view_patient"><i class="fa fa-circle-o text-aqua"></i>  Patient Translation</a></li>
            <li><a href="<?php echo base_url(); ?>About_Translation/view_about"><i class="fa fa-circle-o text-aqua"></i>  About Translation</a></li>
            <li><a href="<?php echo base_url(); ?>Terms_Translation/view_terms"><i class="fa fa-circle-o text-aqua"></i>  Terms Translation</a></li>
            <li class="treeview"><a href="#"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span>Banner Management</span><i class="fa fa-angle-left pull-right"></i></a>
            
                          </li> -->
         <!-- <li><a href="<?php echo base_url(); ?>Booking_Translation/view_booking"><i class="fa fa-circle-o text-aqua"></i>  Booking Translation</a></li> -->
         <li class="<?php if ($uri2 == 'send_single' || $uri2 == 'send_to_all') { ?>treeview active<?php } ?>">
            <a href=""><i class="fa fa-globe" aria-hidden="true"></i> <span>Send Notification</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url(); ?>User_details/send_single/" <?php if ($uri2 == 'send_single') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>Single User</a></li>
               <li><a href="<?php echo base_url(); ?>User_details/send_to_all" <?php if ($uri2 == 'send_to_all') { ?> style="color:#fff" <?php } ?>><i class="fa fa-circle-o text-aqua"></i>All User</a></li>
            </ul>
         </li>
         <li class="<?php if($uri2 == 'coupan_list' || $uri2 == 'add_coupan' || $uri2 == 'edit_coupan') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-fw fa-tags"></i> <span>Offers Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>speedhuntson/coupan_list" <?php if($uri2 == 'coupan_list' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Coupon List</a></li>

               <li><a href="<?php echo base_url();?>speedhuntson/wallet_conf_list" <?php if($uri2 == 'wallet_conf_list' || $uri2 == 'wallet_conf_list'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-pagelines"></i>Wallet Configuration</a></li>
            </ul>
         </li>
         <!--  <li class="<?php if ($uri5 == 1 || $uri5 == 2|| $uri5 == 0|| $uri5 == 3) { ?>treeview active<?php } ?>">
            <a href="<?php echo base_url(); ?>horoscope_matching/bookings" ><i class="fa fa-wrench" aria-hidden="true"></i><span>Horoscope Matching</span></a> 
            
            <ul class="treeview-menu">
            
             <li><a href="<?php echo base_url(); ?>horoscope_matching/bookings/0/0/3/" <?php if($uri2 == 'all_booking' && $uri5 == 3){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
            
             <li><a href="<?php echo base_url(); ?>horoscope_matching/bookings/0/0/0" <?php if($uri2 == 'new_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>
            
             <li><a href="<?php echo base_url(); ?>horoscope_matching/bookings/0/0/1" <?php if($uri2 == 'complete_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>
            
             <li><a href="<?php echo base_url(); ?>horoscope_matching/bookings/0/0/2" <?php if($uri2 == 'cancel_booking' && $uri1 == 'online_consultation'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>
            
            
            
            
            </ul>
            </li> -->
         <li>
            <a href="<?php echo base_url(); ?>Settings_ctrl/view_settings" <?php if ($uri2 == 'view_settings') { ?> style="color:#fff" <?php } ?>><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span></a>
         </li>
      </ul>
   </section>
   <!-- /.sidebar -->
</aside>