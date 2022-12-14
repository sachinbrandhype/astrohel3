<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Send Mail to All Astrologer
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
      <!-- <li><a href="<?php echo base_url();?>Nurse/view_nursedetails">Nurse Details</a></li> -->
      <li class="active">Send Mail to All</li>
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
            <h3 class="box-title">Send Mail to All Astrologer</h3>
         </div>
         <!-- /.box-header -->
         <!-- form start -->
         <form role="form" action="<?=base_url('Test_ctrl/send_mail/');?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
            <div class="box-body">
               <div class="col-md-6">
                 
                  <div class="form-group">
                    <label>Title</label>
                     <input type="text" required name="title" class="form-control" placeholder="Title" >
                     <input type="hidden" required name="type" class="form-control" value="2" >
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
 
      </div>
      <!-- /.row -->
</section>
<!-- /.content -->
</div> 
