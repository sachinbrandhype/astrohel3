<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Service
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>Services/add_services">Services </a></li>
         <li class="active">Edit Services</li>
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
                  <h3 class="box-title">Edit Services Details</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                 <div class="box-body">                 
                     <div class="col-md-6">
                
                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Service Name</label>
                            <input type="text" class="form-control required" value="<?php echo $data->service_name; ?>" required name="service_name"  placeholder="Service Name">
                            <span class="glyphicon  form-control-feedback"></span>
                          </div> 

                          <div class="form-group has-feedback">
                             <input type="hidden" name="status" value="<?=$data->status?>" class="form-control">
                              <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="radio" id="complaintinput2" name="status" value="1" <?php echo ($data->status == '1')?'checked':'' ?>> Active
                              <input type="radio" id="complaintinput2" name="status" value="0"
                              <?php echo ($data->status == '0')?'checked':'' ?>> Inactive 

                          </div>
                 </div>
              </div>
				   <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Update</button>
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
<body onload="initialize()">