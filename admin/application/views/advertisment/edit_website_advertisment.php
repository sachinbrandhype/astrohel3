
<?php $id = $this->session->userdata('admin');  ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Website advertisment 
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url(); ?>banner_ctrl/view_banner"> Edit Website advertisment Details </a></li>
         <li class="active">Edit Website advertisment</li>
      </ol>
   </section>
   <!-- Website content -->
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
  <form role="form"  method="post" action="<?php echo base_url('banner_ctrl/edit_website_advertisment')?>" id="patient banner_reg" data-parsley-validate="" class="validate" enctype="multipart/form-data" >
  
         <div class="col-md-12">
            <!-- general form elements -->             
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">Edit Website advertisment </h3>
                  <div class="edituser" tabindex='1'></div>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
                <div class="box-body">                 
                     <div class="col-md-6">
            
            <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Image</label>
                            <input  name="image"  type="file" >
                            <br>
                              <img height="50" width="70" alt="your image" src="<?php echo base_url('/')."uploads/advertisment/";?><?=$data->image?>" name=""/>

                          <input type="hidden" name="image11" value="<?php echo $data->image; ?>" class="form-control">
                          <input type="hidden" name="id" value="<?php echo $data->id; ?>" class="form-control">

                             <span class="glyphicon  form-control-feedback"></span>
                        </div>

                            <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Title </label>
                            <input type="text" class="form-control required"  name="title"  value="<?=$data->title?>"   placeholder="Title">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

                         <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Sub Title </label>
                            <input type="text" class="form-control required"  name="sub_title"   value="<?=$data->sub_title?>"  placeholder="Sub Title">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

                         <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">desc </label>
                            <textarea class="form-control required"  name="desc">
                              <?=$data->desc?>
                            </textarea>
                        
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>


                  
 <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Position <span style="color: red;">*</span></label>
                            <input type="number" class="form-control required" min="1" data-parsley-trigger="change" data-parsley-minlength="1" value="<?=$data->position?>" required name="position"  placeholder="Position">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

              <div class="form-group has-feedback">
                        <label for="complaintinput2">Status:</label>


                          <select name="is_active" class="form-control required">
                              <option value="1" <?=$data->is_active==1 ? "selected" : ""?>>Active</option>
                              <option value="0" <?=$data->is_active==0 ? "selected" : ""?>>Inactive</option>
                          </select>

                        </div>
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

