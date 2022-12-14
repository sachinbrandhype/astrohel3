 <?php
$settings = get_homesettings(); 
$admin_detail = pull_admin();
?>      
	  
	  
	  <header class="main-header">
        <!-- Logo -->
      <a href="#" class="logo">
         <?php if(empty($settings->logo)){?>
                           <img src="<?php echo base_url(); ?>uploads/common/logo.png" class="img-circle" alt="User Image" style="width: 62%; border-radius: inherit;" >
                          <?php }else{?>
                          <img src="<?php echo base_url().'/'.$settings->logo ;?>" class="circle-img" style="width: 62%;" alt="">
                          <?php }?>
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H</b>M</span>
          <!-- logo for regular state and mobile devices -->
  		 <span class="hidden-xs"><?php echo $settings->title; ?>
		 </span>
        </a>
		
<?php
// if (!empty($_SESSION['lab_id'])) 
// {
// $lab_id = $_SESSION['lab_id'];
// $query ="SELECT COUNT(*) AS total FROM booking_test WHERE lab_assign_id  = '".$lab_id."' AND notification_to_lab = 1 ";

// $query2 ="SELECT * FROM booking_test WHERE lab_assign_id  = '".$lab_id."' ";
// $data2 = $this->db->query($query2)->row();
// // print_r($data2->notification_to_lab);die;
// $data = $this->db->query($query)->row();
// }

?>


		
		
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
               <li class="dropdown messages-menu">
           <!--  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php //echo $data->total; ?></span>
            </a> -->
           
          </li>
             
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
               	<a href="#" class="dropdown-toggle" data-toggle="dropdown">				          
                   <?php if($admin_detail[0]->profile_picture != NULL){ ?>
					  <img src="<?php echo base_url().$admin_detail[0]->profile_picture; ?>" class="user-image" alt="User Image">
					<?php }else{ ?>
					  <img src="<?php echo base_url(); ?>assets/images/user_avatar.jpg" class="user-image" alt="User Image">
					<?php } ?>
                  <span class="hidden-xs">
                    <?php $a=$this->session->userdata('logged_in');
					
                    echo $a['username'];?>
                  </span>
                </a>
				
					<?php
			?>
				
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
					<?php if($admin_detail[0]->profile_picture != NULL){ ?>
							<img src="<?php echo base_url().$admin_detail[0]->profile_picture; ?>" class="img-circle" alt="User Image">                    
						  <?php }else{ ?>
							<img src="<?php echo base_url(); ?>assets/images/user_avatar.jpg" class="img-circle" alt="User Image">                    
						  <?php } ?>
                    
                  </li>
                  <!-- Menu Body -->
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
					
					 <?php
					$profile_link = ($this->session->userdata('admin') == 1) ? base_url()."Admin_detailsview/Admin_profile_view" : base_url()."Profile_details/view_profile";
					?>
					
                      <a href="<?php echo base_url(); ?>astrologers_admin/Astrologers_admin/profile_astrologers" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>astrologers_admin/Astrologers_admin/logged" class="btn btn-default btn-flat">Sign out</a>
                    </div>

                 

                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
