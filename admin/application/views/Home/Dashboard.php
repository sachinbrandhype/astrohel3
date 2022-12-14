<?php 
$total_active_users = total_active_users();
$total_inactive_users = total_inactive_users();
$total_users = total_users();
$total_banner = total_banner();
$total_gallery = total_gallery();
$total_testi = total_testi();
$total_posts = total_posts();
$total_ropeway= total_ropeway();
$total_kumbh = total_kumbh();
$total_active_astrologer = total_active_astrologer();
$total_inactive_astrologer = total_inactive_astrologer();
$total_pending_astrologer = total_pending_astrologer();
$total_puja = total_puja();





$query10 ="SELECT COUNT(*) AS New_user FROM user WHERE status <> 2 AND DATE(created_at) = CURDATE();";
$new_users = $this->db->query($query10)->row();

// echo $this->db->last_query(); die;
?>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
           <?php if($this->session->userdata('User-Details') == "User-Details") { ?>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_active_users;?> </h3>
                <p>Active Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
               <a href="<?php echo base_url(); ?>User_details/view_userdetails" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_inactive_users;?> </h3>
                <p>Inactive Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
               <a href="<?php echo base_url(); ?>User_details/view_userdetails" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow md">
              <div class="inner">
                 <h3><?php echo date('d-m-Y'); ?> </h3>
              <p><b><?php echo $new_users->New_user;?></b> New Users </p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url(); ?>User_details/view_userdetails" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
           <?php } ?>

          <?php if($this->session->userdata('App-Management') == "App-Management") { ?> 


          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_banner;?> </h3>
                <p>Baners</p>
              </div>
              <div class="icon">
                <i class="fa fa-caret-square-o-right"></i>
              </div>
               <a href="<?php echo base_url(); ?>Banner_ctrl/view_banner" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

         <!--  <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_gallery;?> </h3>
                <p>Gallery</p>
              </div>
              <div class="icon">
                <i class="fa fa-caret-square-o-right"></i>
              </div>
               <a href="<?php echo base_url(); ?>sd/app_management/gallery" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
 -->
           <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_posts;?> </h3>
                <p>Post</p>
              </div>
              <div class="icon">
                <i class="fa fa-caret-square-o-right"></i>
              </div>
               <a href="<?php echo base_url(); ?>sd/posts_management/posts" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> 

            <?php } ?>

        <!--   <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_ropeway;?> </h3>
                <p>Ropeway</p>
              </div>
              <div class="icon">
                <i class="fa fa-arrows-h"></i>
              </div>
               <a href="<?php echo base_url(); ?>sd/ropeway_management/ropeway" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_kumbh;?> </h3>
                <p>Kumbh</p>
              </div>
              <div class="icon">
                <i class="fa fa-home"></i>
              </div>
               <a href="<?php echo base_url(); ?>sd/kumbh_management/kumbh" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
    <?php if($this->session->userdata('Astrologers-Management') == "Astrologers-Management") { ?> 
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_active_astrologer;?> </h3>
                <p>Active Astrologers</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
               <a href="<?php echo base_url(); ?>sd/astrologers/astologers_list_verified" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_inactive_astrologer;?> </h3>
                <p>Deactive Astrologers</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
               <a href="<?php echo base_url(); ?>sd/astrologers/astologers_list_disabled" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_pending_astrologer;?> </h3>
                <p>Pending Astrologers</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
               <a href="<?php echo base_url(); ?>sd/astrologers/astologers_list_pending" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
 <?php } ?>

 <?php if($this->session->userdata('Pooja-Management') == "Pooja-Management") { ?>
 <!-- 
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua md">
              <div class="inner">
                <h3><?php echo $total_puja;?> </h3>
                <p>Total Puja's</p>
              </div>
              <div class="icon">
                <i class="fa fa-fire"></i>
              </div>
               <a href="<?php echo base_url(); ?>pooja/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          
 <?php } ?>
      </div>
    </section>
</div>