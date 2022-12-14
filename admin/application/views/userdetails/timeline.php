<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         User Timeline 
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo base_url('User_details/view_userdetails');?>">User's</a></li>
         <li class="active">User Timeline</li>
      </ol>
   </section>
   <section class="invoice">
      <!-- title row -->
      <div class="row">
         <div class="col-xs-12">
            <h2 class="page-header">
               <i class="fa fa-user"></i>
               <?=$u_data->name?>
               <small class="pull-right"></small>
            </h2>
         </div>
         <!-- /.col -->
      </div>

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>&#8377; <?=$u_data->wallet?></h3>

              <p>Wallet</p>
            </div>
            <div class="icon">
              <i class="fa fa-google-wallet"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
                 <?php 
                  $q = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `booking_type` = '1' AND `user_id`='".$u_data->id."'")->row();
                  echo $q->A;
                 ?>
              </h3>

              <p>Total Puja Bookings</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
                 <?php 
                  $q = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `booking_type` = '1' AND `user_id`='".$u_data->id."' AND status=1")->row();
                  echo $q->A;
                 ?>
              </h3>

              <p>Complete Puja Bookings</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
                 <?php 
                  $q = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `booking_type` = '1' AND `user_id`='".$u_data->id."' AND status IN (2,3,4,5)")->row();
                  echo $q->A;
                 ?>
              </h3>

              <p>Cancel Puja Bookings</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                 <?php 
                  $q = $this->db->query("SELECT COUNT(*) AS A FROM `booking` WHERE `booking_type` = '1' AND `user_id`='".$u_data->id."' AND status =0")->row();
                  echo $q->A;
                 ?>
              </h3>

              <p>Pending Puja Bookings</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                 <?php 
                  $q = $this->db->query("SELECT COUNT(*) AS A FROM `puja_temp_cart` WHERE `main_user_id` = '".$u_data->id."'")->row();
                  echo $q->A;
                 ?>
              </h3>

              <p>Items in cart</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>
        
      </div>
      
   </section>

   <div class="clearfix"></div>
</div>