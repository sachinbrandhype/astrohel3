 <style type="text/css">
   .dropdown-menu>li>a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: normal;
}
.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a>h4 {
    padding: 0;
    margin: 0 0 0 45px;
    color: #444444;
    font-size: 15px;
    font-weight: 600;
    position: relative;
}
.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a>p {
    margin: 0 0 0 45px;
    font-size: 14px;
    color: #888888;
}
.noti{
      background-color: #f00;
    color: #fff;
    border-radius: 4px;
    padding: 5px;
    margin-right: 15px;
}
.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a, .navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a, .navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a {
    display: block;
    white-space: normal;
    border-bottom: 1px solid #f4f4f4;
}

.navbar-nav>.notifications-menu>.dropdown-menu>li .menu, .navbar-nav>.messages-menu>.dropdown-menu>li .menu, .navbar-nav>.tasks-menu>.dropdown-menu>li .menu {
    max-height: 500px;
    margin: 0;
    padding: 0;
    list-style: none;
    overflow-x: hidden;
}

 </style>

 <?php
 //error_reporting(0);
$settings = get_homesettings(); 
$admin_detail = pull_admin();
?>      
	  
	  
	  <header class="main-header">
        <!-- Logo -->
      <a href="<?php echo base_url(); ?>" class="logo">
         <?php if(empty($settings->logo)){?>
                           <img src="<?php echo base_url(); ?>uploads/common/logo.png" class="img-circle" alt="User Image" style="width: 62%; border-radius: inherit;" >
                          <?php }else{?>
                          <img src="<?php echo base_url().'/'.$settings->logo ;?>" class="circle-img" style="width: 62%;" alt="">
                          <?php }?>
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H</b>M</span>
          <!-- logo for regular state and mobile devices -->
  		 <span class="hidden-xs"><?php echo @$settings->title; ?>
		 </span>
        </a>
		
<?php //print_r($_SESSION['lab_id']);
// $query ="SELECT COUNT(*) AS total FROM booking_test WHERE notification_to_admin = 1 ";
// $data = $this->db->query($query)->row();



// $user_notification= "SELECT COUNT(*) AS total  FROM user_notification";
// // $notification_data = $this->db->query($user_notification)->result();
// $notification_data = $this->db->query($user_notification)->row();
 // print_r($notification_data);die;

 ?>
		
		
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" rol e="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
               <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o" onclick="return notification()"></i>
              <span class="label label-warning" id="count_data"></span>
              <span class="label label-success"></span>
            </a>
            <ul class="dropdown-menu" id="links" style="width: 990px;">
               <li>
                <ul class="menu show_data" id="show_notification_data">

              
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
        </ul>
          <li class="">
           
            <ul class="dropdown-menu">

            
                <ul class="menu">
                  <li>
                   
                  </li>
                  
                  
                </ul>
              </li>
              
            </ul>
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
          
                       <a href="<?php echo $profile_link; ?>" class="btn btn-default btn-flat">Profile</a>
                    </div>
					
					 
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
