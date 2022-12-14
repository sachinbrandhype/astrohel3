<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Send Notification to All
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
      <!-- <li><a href="<?php echo base_url();?>Nurse/view_nursedetails">Nurse Details</a></li> -->
      <li class="active">Send Notification to All</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
   <!-- left column -->
   <div class="col-md-12">
      <?php
         if($this->session->flashdata('message')) {
         $message = $this->session->flashdata('message');
         ?>
      <div class="alert alert-<?php echo $message['class']; ?>">
         <button class="close" data-dismiss="alert" type="button">×</button>
         <?php echo $message['message']; ?>
      </div>
      <?php
         }
         ?>
   </div>
   <div class="col-md-12">
      <!-- general form elements -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Send Notification to All</h3>
         </div>
         <!-- /.box-header -->
         <!-- form start -->
         <form role="form" action="<?=base_url('Test_ctrl/send/');?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
            <div class="box-body">
               <div class="col-md-6">
                 
                  <div class="form-group">
                    <label>Title</label>
                     <input type="text" required name="title" class="form-control" placeholder="Title" >
                  </div>

                  <div class="form-group">
                    <label>Message</label>
                     <textarea class="form-control" name="message" required=""></textarea>
                  </div>
                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1"> Image</label>
                            <input  name="image"  type="file" >
                             <span class="glyphicon  form-control-feedback"></span>
                        </div>

                  
                  
                  <div class="box">
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </div>
                  

                 
         </form>
         </div>
         <!-- /.box -->
         </div>
      </div>
    <div class="row">
   <!-- left column -->
   <div class="col-md-12">
      <?php
         if($this->session->flashdata('message')) {
         $message = $this->session->flashdata('message');
         ?>
      <div class="alert alert-<?php echo $message['class']; ?>">
         <button class="close" data-dismiss="alert" type="button">×</button>
         <?php echo $message['message']; ?>
      </div>
      <?php
         }
         ?>
   </div>
 <!--   <div class="col-md-12">
    
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Notifications</h3>
         </div>


         <div class="box-body table-responsive">

          <a href="<?php echo base_url()?>user_details/export_notification/send_all" class="btn btn-success float-right">Export</a>
                 <table class="table table-hover">
                   <tr>
                     <th>userID</th>
                     <th>Title</th>
                     <th>Message</th>
                     <th>Added On</th>
                     
                   </tr>
                  <?php
                     $i=1; 
                     if(!empty($notification))
                      {
                        foreach($notification as $e) 
                       {         
                       ?>
                        <tr>
                           <td class="center"><?php echo $e->user_id; ?></td>
                           <td class="center"><?php echo $e->title;?></td>
                           <td class="center"><?php echo $e->notification;?></td>
                           <td class="center"><?php echo $e->added_on; ?></td>
                        </tr>
                    <?php
                       $i++;
                      }
                    }
                    ?>
                   
                 </table>
                 <div class="box-tools">
                  <?php if (isset($links)) { ?>
                  <ul class="pagination pagination-sm pull-right" style="margin-top: 35px !important;">
                     <?php echo $links ?> 
                  </ul>
                 <?php } ?>
                  </div>
               </div>



        
         </div>
        
         </div> -->
      </div>
      <!-- /.row -->
</section>
<!-- /.content -->
</div> 
