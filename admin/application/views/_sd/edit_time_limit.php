<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Time Limit 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>Affiliate_ctrl/view_time_limit">Time Limit </a></li>
         <li class="active">Edit Time Limit</li>
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
                  <h3 class="box-title">Edit Time Limit </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-6">
                       

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Video Time</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change" value="<?php echo $list->video_time; ?>"data-parsley-minlength="2"  required="" name="video_time"  placeholder="Video Time">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                         <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Chat Time</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change" value="<?php echo $list->chat_time; ?>"data-parsley-minlength="2"  required="" name="chat_time"  placeholder="Chat Time">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                         <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Audio Time</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change" value="<?php echo $list->audio_time; ?>" data-parsley-minlength="2"  required="" name="audio_time"  placeholder="Audio Time">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>


                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
            </div>
         </div>
         </form>
      </div>
      <!-- /.box -->
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>