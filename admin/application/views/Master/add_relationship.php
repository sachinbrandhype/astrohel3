<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Relationship 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add Relationship</li>
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
                  <h3 class="box-title"> Add Relationship </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="<?=base_url('Master_ctrl/add_relationship')?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-12">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Relationship Name</label>
                           <input type="text" class="form-control required" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="name"  placeholder="Relationship Name">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
              
            </div>
         </div>
      </div>
      <!-- /.box -->
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>