<?php 
   $id = $this->session->userdata('logged_in')['id'];	  
   $admin_detail = pull_admin();
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
         <li class="treeview">
            <a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/astrologersdashboard">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
            </a>
         </li>
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/performance"><i class="fa fa-circle-o text-aqua"></i> <span>Performance</span><i class="fa fa-angle-left pull-right"></i></a>
         </li>
   
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/reviews_list"><i class="fa fa-circle-o text-aqua"></i> <span>Customer Reviews</span><i class="fa fa-angle-left pull-right"></i></a>
         </li>
   <!-- 
         <li class="treeview"><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Offer For You</span><i class="fa fa-angle-left pull-right"></i></a>
         </li> -->
   
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/schedule_vacation"><i class="fa fa-circle-o text-aqua"></i> <span>Schedule Vacation</span><i class="fa fa-angle-left pull-right"></i></a>
         </li>
   
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/earnings_list"><i class="fa fa-circle-o text-aqua"></i> <span>Consultation Earnings</span><i class="fa fa-angle-left pull-right"></i></a>
         </li>
   
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/chat_history"><i class="fa fa-circle-o text-aqua"></i> <span>Chat History </span><i class="fa fa-angle-left pull-right"></i></a>
         </li>
   
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/posts"><i class="fa fa-circle-o text-aqua"></i> <span>Post History </span><i class="fa fa-angle-left pull-right"></i></a>
         </li>
   
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/bank_details"><i class="fa fa-circle-o text-aqua"></i> <span>Bank Details</span><i class="fa fa-angle-left pull-right"></i></a>
         </li>
   
       <!--   <li class="treeview"><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>My TDS</span><i class="fa fa-angle-left pull-right"></i></a>
         </li> -->
   
         <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/change_password"><i class="fa fa-circle-o text-aqua"></i> <span>Settings</span><i class="fa fa-angle-left pull-right"></i></a>
         </li>

          <li class="treeview"><a href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/support"><i class="fa fa-circle-o text-aqua"></i> <span>Support</span><i class="fa fa-angle-left pull-right"></i></a>
               </li>
   
        
       <!--   <li class="treeview"><a href="<?php echo base_url();?>Lab_ctrl/report"><i class="fa fa-male"></i> <span>Report</span><i class="fa fa-angle-left pull-right"></i></a>
         </li> -->


       

      </ul>
     
   </section>
   <!-- /.sidebar -->
</aside>