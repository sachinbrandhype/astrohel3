<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Post 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>Affiliate_ctrl/view_post">Post </a></li>
         <li class="active">Edit Post</li>
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
                  <h3 class="box-title">Edit Post </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-6">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Edit Name</label>
                           <input type="text" class="form-control required" value="<?php echo $list->name; ?>" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="name"  placeholder="Edit Name">
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