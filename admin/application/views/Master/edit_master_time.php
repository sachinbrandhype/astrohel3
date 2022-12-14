<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Master Minute Price Management 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>Master_ctrl/master_price_management">Master Minute Price Management  </a></li>
         <li class="active">Edit Master Minute Price Management</li>
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
                 <!--  <h3 class="box-title">Edit Master Price </h3> -->
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">

                     <div class="col-md-6">
                     	<div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Price</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="1"   required="" step="any" name="price"  value="<?php echo $list->price; ?>" placeholder="Match Making Price">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                         <div class="form-group has-feedback">
                            <label for="exampleInputEmail1"></label>
                              <input type="hidden" name="status" value="<?=$list->status?>" class="form-control">
                              <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="radio" id="complaintinput2" name="status" value="1" <?php echo ($list->status == '1')?'checked':'' ?>> Active
                              <input type="radio" id="complaintinput2" name="status" value="0"
                              <?php echo ($list->status == '0')?'checked':'' ?>> Inactive 
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