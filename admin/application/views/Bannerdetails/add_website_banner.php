
<?php $id = $this->session->userdata('admin');  ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Website Banner 
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url(); ?>banner_ctrl/view_banner">Website Banner Details </a></li>
         <li class="active">Add Website Banner</li>
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
  <form role="form"  method="post" action="<?php echo base_url('banner_ctrl/insert_website_banner')?>" id="patient banner_reg" data-parsley-validate="" class="validate" enctype="multipart/form-data" >
  
         <div class="col-md-12">
            <!-- general form elements -->             
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">Add Website Banner </h3>
                  <div class="edituser" tabindex='1'></div>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
                <div class="box-body">                 
                     <div class="col-md-6">
            
            <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Image</label>
                            <input  name="image"  type="file"   required="">
                             <span class="glyphicon  form-control-feedback"></span>
                        </div>

                         <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Name </label>
                            <input type="text" class="form-control required"  name="name"  placeholder="Name">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

                   <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Position <span style="color: red;">*</span></label>
                            <input type="number" class="form-control required" min="1" data-parsley-trigger="change" data-parsley-minlength="1" required name="position"  placeholder="Position">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

              <div class="form-group has-feedback">
                        <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="1" checked>Active&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="0"> Inactive</div>
              <div class="box">
              <div class="box-body">
              <div class="col-md-12">
              <div class="form-group has-feedback">                                       
                        <input type="submit" class="btn btn-primary" value="Submit" id="patient banneradd">
<!--                         <button type="reset" class="btn btn-primary">Reset </button>
 -->                        </div> 
           </div>
          </div> 
            </div>  

         </div>
        </div>
      </div>
    </div>
     </form> 
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
  <script>
  base_url = "<?php echo base_url(); ?>";
  config_url = "<?php echo base_url(); ?>";
  </script>

