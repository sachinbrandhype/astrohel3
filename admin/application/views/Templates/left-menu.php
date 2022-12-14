<?php
   $id = $this->session->userdata('logged_in')['id'];
   $role_id = $this->session->userdata('logged_in')['user_type'];
   $admin_detail = pull_admin();
   $uri1 = $this->uri->segment(1);
   $uri2 = $this->uri->segment(2);
   $uri3 = $this->uri->segment(3);
   $uri5 = $this->uri->segment(5);
   $access_data = $this->db->query("select * from permissions left join menu_list on menu_list.id=permissions.menu_id where role_id = ".$role_id)->result();
  // echo "<pre>";
   //print_r($access_data);die;
     $this->session->set_userdata('User-Details',"");
     $this->session->set_userdata('Supervisor-Management',"");
     $this->session->set_userdata('Priest-Management',"");
     $this->session->set_userdata('Agent-Management',"");
     $this->session->set_userdata('Pooja-Management',"");
     $this->session->set_userdata('Life-prediction',"");
     $this->session->set_userdata('Astrologers-Management',"");
     $this->session->set_userdata('App-Management',"");
     $this->session->set_userdata('Kumbh-Management',"");
     $this->session->set_userdata('Yoga-Management',"");
     $this->session->set_userdata('Master',"");
     $this->session->set_userdata('Order-Management',"");
     $this->session->set_userdata('Offers-Management',"");
	 $this->session->set_userdata('Admin-Management',"");
	 $this->session->set_userdata('report',"");
   foreach($access_data as $value){
	    if($value->sidebar_name == "User-Details") {
	      $this->session->set_userdata('User-Details',"User-Details");
		}
		if($value->sidebar_name == "Supervisor-Management") {
			
	      $this->session->set_userdata('Supervisor-Management',"Supervisor-Management");
		}
		if($value->sidebar_name == "Priest-Management") {
	      $this->session->set_userdata('Priest-Management',"Priest-Management");
		}
		if($value->sidebar_name == "Agent-Management") {
	      $this->session->set_userdata('Agent-Management',"Agent-Management");
		}
		if($value->sidebar_name == "Pooja-Management") {
	      $this->session->set_userdata('Pooja-Management',"Pooja-Management");
		}
		if($value->sidebar_name == "Life-prediction") {
	      $this->session->set_userdata('Life-prediction',"Life-prediction");
		}
		if($value->sidebar_name == "Astrologers-Management") {
	      $this->session->set_userdata('Astrologers-Management',"Astrologers-Management");
		}
		if($value->sidebar_name == "App-Management") {
	      $this->session->set_userdata('App-Management',"App-Management");
		}
		if($value->sidebar_name == "Kumbh-Management") {
	      $this->session->set_userdata('Kumbh-Management',"Kumbh-Management");
		}
		if($value->sidebar_name == "Yoga-Management") {
	      $this->session->set_userdata('Yoga-Management',"Yoga-Management");
		}
		if($value->sidebar_name == "Master") {
	      $this->session->set_userdata('Master',"Master");
		}
		if($value->sidebar_name == "Order-Management") {
	      $this->session->set_userdata('Order-Management',"Order-Management");
		}
		if($value->sidebar_name == "Offers-Management") {
	      $this->session->set_userdata('Offers-Management',"Offers-Management");
		}
		if($value->sidebar_name == "Admin-Management") {
	      $this->session->set_userdata('Admin-Management',"Admin-Management");
		}
		if($value->sidebar_name == "Report") {
	      $this->session->set_userdata('report',"report");
		}
		
		
		
   }
  
   ?>

<!-- 
<li class="active treeview">
   <a href="#">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
      </span>
   </a>
   <ul class="treeview-menu">
      <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
      <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
   </ul>
</li> -->

<?php
            function sidebar_element($name,$icon='fa-tachometer-alt',$dropdown =[],$single_route='')
            {

                $id = str_replace(' ', '', $name);
               //  $current_url = url()->current();
               $currentURL = current_url(); //http://myhost/main

               $params   = $_SERVER['QUERY_STRING'] == '' ? '' : '?'.$_SERVER['QUERY_STRING'];  //my_id=1,3
               $current_url = trim($currentURL) .  $params; 
                $elements = '';
                $urls=[];
                $show='';
                $area_expanded = '';
                if(!empty($dropdown)){
                    foreach ($dropdown as $k => $v) {
                        $urls[] = $v['url'];
                        $active='';
                        if(trim($current_url) == trim($v['url'])){
                            $active ="active";
                            $area_expanded="active";
                        }
                        $elements .= '
                        <li class="'.$active.'">
                            <a href="'.$v['url'].'" >
                              <i class="fa fa-circle-o"></i>
                                '.$v['name'].'
                            </a>
                        </li>
                                    ';
                    }
                }else{
                    if (trim($current_url) == trim($single_route))
                    {
                        $show='show';
                        $area_expanded = 'active';
                    }
                    return  $html = '<li class=" '.$area_expanded.' ">
                                       <a href="'.$single_route.'" >
                                             <i class="fa '.$icon.'"></i>
                                             <span>
                                                '.$name.'
                                             </span>
                                       </a>
                                    </li>';
                }

             
                $html = '<li class="treeview '.$area_expanded.'">
                    <a href="#" >
                        <i class="fa '.$icon.'"></i>
                        <span>
                            '.$name.'
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                       '.$elements.'
                    </ul>
                </li>';

                return $html;
            }
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
         <?php echo sidebar_element('Dashboard','fa-dashboard',
                    [],base_url('index.php/welcome'));  ?>

		 <?php if($this->session->userdata('Admin-Management') == "Admin-Management") { ?>

         <?php 
         echo sidebar_element('Admin Management','fa-male',
            [
               ['name'=>'Admin List','url'=>base_url('index.php/admin_detailsview')],
               ['name'=>'Role','url'=>base_url('index.php/admin_detailsview/role')],
               ['name'=>'Access Management','url'=>base_url('index.php/admin_detailsview/access')]
            ]);
         ?>
		 <?php } ?>

       <?php 
         echo sidebar_element('Order Management','fa-reorder',
            [
               ['name'=>'All','url'=>base_url('index.php/consultation/fetchConsultations')],
               ['name'=>'Upcoming','url'=>base_url('index.php/booking_management/astrologer_booking/new_booking')],
               ['name'=>'Completed','url'=>base_url('index.php/consultation/fetchConsultations?booking_status=completed')],
               ['name'=>'Cancelled','url'=>base_url('index.php/booking_management/astrologer_booking/cancel_booking')],
               ['name'=>'Refund Requests','url'=>base_url('index.php/consultation/fetchConsultations?refund_bookings=true')],
            ]);
      ?>
        <?php if($this->session->userdata('User-Details') == "User-Details") { ?>


         <?php 
         echo sidebar_element('User Details','fa-user',
            [
               ['name'=>'Active User','url'=>base_url('index.php/User_details/view_userdetails')],
               ['name'=>'Disabled User','url'=>base_url('index.php/User_details/view_disabled_userdetails')],
            ]);
         ?>

		 <?php } ?>
       

		  <?php if($this->session->userdata('Life-prediction') == "	Life-prediction") { ?>

          <li class="<?php if($uri1 == 'life_prediction' || $uri1 == 'Life_prediction') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-user-md"></i> <span > Life prediction</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
           
               <li><a href="<?php echo base_url();?>life_prediction/prediction/all_booking" <?php if($uri2 == 'all_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> All Booking</a></li> 
               <li><a href="<?php echo base_url();?>life_prediction/prediction/new_booking" <?php if($uri2 == 'new_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> New Booking</a></li>

               <li><a href="<?php echo base_url();?>life_prediction/prediction/complete_booking" <?php if($uri2 == 'complete_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua" ></i> Completed Booking</a></li>

               <li><a href="<?php echo base_url();?>life_prediction/prediction/cancel_booking" <?php if($uri2 == 'cancel_booking' && $uri1 == 'life_prediction'){?> style="color:#fff" <?php }?>><i class="fa fa-circle-o text-aqua"></i> Cancelled Booking</a></li>

              

              
            </ul>
         </li>
		<?php } ?>
		  <?php if($this->session->userdata('Astrologers-Management') == "Astrologers-Management") { ?>	
         
         <?php 
         echo sidebar_element('Astrologer Management','fa-table',
            [
               ['name'=>'Add Astrologers','url'=>base_url('index.php/sd/astrologers/add_astrologers')],
               ['name'=>'Verified Astrologers','url'=>base_url('index.php/sd/astrologers/astologers_list/approved')],
               ['name'=>'Pending Astrologers','url'=>base_url('index.php/sd/astrologers/astologers_list/pending')],
               ['name'=>'Disabled Astrologers','url'=>base_url('index.php/sd/astrologers/astologers_list/disable')],
               ['name'=>'Reviews Astrologers','url'=>base_url('index.php/reviews/reviews_list')],
            ]);
         ?>



          <?php 
         echo sidebar_element('Astrologer Position','fa-table',
            [
               ['name'=>'Chat Astrologers','url'=>base_url('index.php/sd/astrologers/astologers_position/chat')],
               ['name'=>'Video Astrologers','url'=>base_url('index.php/sd/astrologers/astologers_position/video')],
               ['name'=>'Audio Astrologers','url'=>base_url('index.php/sd/astrologers/astologers_position/audio')],
             
            ]);
         ?>


        

		 <?php } ?>

       <?php echo sidebar_element('Wallet Recharge Plans','fa-book',
               [],base_url('index.php/walletPlan/getdata'));  ?>

       <?php echo sidebar_element('User Support','fa-book',
               [],base_url('index.php/enquiries/supports'));  ?>
		  <?php if($this->session->userdata('App-Management') == "App-Management") { ?>

         <?php echo sidebar_element('Banners Management','fa-laptop',
                    [],base_url('index.php/Banner_ctrl/view_banner'));  ?>
         <?php echo sidebar_element('Blog Management','fa-edit',
                  [],base_url('index.php/Banner_ctrl/website_blog'));  ?>

         <?php echo sidebar_element('Enquiries Management','fa-book',
               [],base_url('index.php/enquiries/enquirie_list'));  ?>

		 <?php } ?>

      
		
		  <?php if($this->session->userdata('Master') == "Master") { ?>	

         <?php 
         echo sidebar_element('Master','fa-diamond',
            [
             
               ['name'=>'Add Language','url'=>base_url('index.php/Language_ctrl/add_languages')],
               ['name'=>'Gifts','url'=>base_url('index.php/sd/edit_master/gifts')],
               ['name'=>'Service Offered','url'=>base_url('index.php/sd/edit_master/master_service_offered')],
               ['name'=>'Specializations','url'=>base_url('index.php/sd/edit_master/master_specialization')],
            ]);
         ?>

         <?php 
         echo sidebar_element('Settings','fa-wrench',
            [
               ['name'=>'General','url'=>base_url('index.php/Settings_ctrl/view_settings')],
               ['name'=>'Policy','url'=>base_url('index.php/Settings_ctrl/view_policy')],
              
            ]);
         ?>

		 <?php } ?>
		  <?php if($this->session->userdata('Order-Management') == "Order-Management") { ?>	

         <?php 
         echo sidebar_element('Broadcast Management','fa-tv',
            [
               ['name'=>'View','url'=>base_url('index.php/Broadcasts_management/broadcasts')],
              
            ]);
         ?>

        

       

         
     


		 <?php } ?>
    
		  <?php if($this->session->userdata('Offers-Management') == "Offers-Management") { ?>	
         
         <?php 
         echo sidebar_element('Send Notification','fa-globe',
            [
               ['name'=>'Single User','url'=>base_url('index.php/Notification_send/send_single')],
               ['name'=>'All User','url'=>base_url('index.php/Notification_send/send_to_all')],
               ['name'=>'Single Astrologer','url'=>base_url('index.php/Notification_send/send_single_astrologer')],
               ['name'=>'All Astrologer','url'=>base_url('index.php/Notification_send/send_to_all_astrologer')],
            ]);
         ?>





        <?php 
         echo sidebar_element('Coupon Management','fa-star-o',
            [
               ['name'=>'View','url'=>base_url('index.php/speedhuntson/coupan_list')],
            ]);
         ?>


          <?php 
         echo sidebar_element('Website Services','fa-globe',
            [
               ['name'=>'Career Report','url'=>base_url('index.php/Settings_ctrl/report/1')],
               ['name'=>'Education Report','url'=>base_url('index.php/Settings_ctrl/report/2')],
               ['name'=>'Marriage Report','url'=>base_url('index.php/Settings_ctrl/report/3')],
               ['name'=>'Love Report','url'=>base_url('index.php/Settings_ctrl/report/4')],
               ['name'=>'Child Report','url'=>base_url('index.php/Settings_ctrl/report/5')],
               ['name'=>'Business Report','url'=>base_url('index.php/Settings_ctrl/report/6')],
               ['name'=>'Foreign Report','url'=>base_url('index.php/Settings_ctrl/report/7')],
               ['name'=>'Property Report','url'=>base_url('index.php/Settings_ctrl/report/8')],
               ['name'=>'Astrology Course','url'=>base_url('index.php/Settings_ctrl/report/9')],
               ['name'=>'Tarot Course','url'=>base_url('index.php/Settings_ctrl/report/10')],
               ['name'=>'Vastu Course','url'=>base_url('index.php/Settings_ctrl/report/11')],
               ['name'=>'Palmistry Course','url'=>base_url('index.php/Settings_ctrl/report/12')],
               ['name'=>'Office Vastu','url'=>base_url('index.php/Settings_ctrl/report/13')],
               ['name'=>'Industrial Vastu','url'=>base_url('index.php/Settings_ctrl/report/14')],
               ['name'=>'Website Banners','url'=>base_url('index.php/Banner_ctrl/website_banner')],
            ]);
         ?>




		  <?php } ?>  
		  <?php if($this->session->userdata('report') == "report") { ?>
		 <!--  <li class="<?php if($uri2 == 'report' || $uri2 == 'report' || $uri2 == 'report') {?>treeview active<?php }?>">
            <a href="#"><i class="fa fa-fw fa-tags"></i> <span>SPDL Report</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Puja Booking Report</a></li>
			   <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Astrologer Booking Report</a></li>
			   <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Service Wise Report</a></li>
			   <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Partner Commission Report</a></li>
			   <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Priest Commission Report</a></li>
			   <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Enterprise/Agent Commission Report</a></li>
			   <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Supervisor Commission Report</a></li>
			   <li><a href="<?php echo base_url();?>" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Astrologer Commission Report</a></li>
			   <li><a href="<?php echo base_url();?>report" <?php if($uri2 == 'report' || $uri2 == 'edit_coupan'){?> style="color:#fff" <?php }?>><i class="fa fa-fw fa-tags"></i>Audit Trail Report</a></li>

            </ul>
         </li> -->
        <?php } ?> 
        <!-- <li>
            <a href="<?php echo base_url(); ?>Settings_ctrl/view_settings" <?php if ($uri2 == 'view_settings') { ?> style="color:#fff" <?php } ?>><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span></a>
         </li>-->
      </ul>
   </section>
   <!-- /.sidebar -->
</aside>