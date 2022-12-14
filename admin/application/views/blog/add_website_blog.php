<?php $id = $this->session->userdata('admin');  ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Website blog
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url(); ?>banner_ctrl/view_banner">Website blog Details </a></li>
         <li class="active">Add Website blog</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <?php
            if ($this->session->flashdata('message')) {
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
         <form role="form" method="post" action="<?php echo base_url('banner_ctrl/insert_website_blog') ?>" id="patient banner_reg" data-parsley-validate="" class="validate" enctype="multipart/form-data">

            <div class="col-md-12">
               <!-- general form elements -->
               <div class="box">
                  <div class="box-header with-border">
                     <h3 class="box-title">Add Website blog </h3>
                     <div class="edituser" tabindex='1'></div>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                     <div class="col-md-6">

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Image</label>
                           <input name="image" type="file" required="">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Title </label>
                           <input type="text" class="form-control required" name="title" placeholder="Title">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>


                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Author Name </label>
                           <select class="form-control" name="author_name">
                              <?php

                              foreach ($astro_data as $cat_key) {
                              ?>
                                 <option value="<?php echo $cat_key->id; ?>"><?php echo $cat_key->name; ?></option>
                              <?php
                              }
                              ?>

                           </select>

                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Author Name</label>
                           <input type="text" class="form-control required" name="author_name" placeholder="Author Name">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Date</label>
                           <input type="date" class="form-control required" name="show_date" placeholder="Author Name">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Desc </label>
                           <textarea class="form-control" name="desc">

                            </textarea>

                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Position <span style="color: red;">*</span></label>
                           <input type="number" class="form-control required" min="1" data-parsley-trigger="change" data-parsley-minlength="1" required name="position" placeholder="Position">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="complaintinput2">Blog Type:</label>


                           <select name="blog_type" class="form-control">
                              <option value="1" >Video Link</option>
                              <option value="0" >Blog Url</option>
                           </select>

                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Video Url: </label>
                           <input type="text" class="form-control" name="video_url" placeholder="Video Url">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <input type="radio" id="complaintinput2" name="status" value="1" checked>Active&nbsp;&nbsp;
                           <input type="radio" id="complaintinput2" name="status" value="0"> Inactive
                        </div>
                        <div class="box">
                           <div class="box-body">
                              <div class="col-md-12">
                                 <div class="form-group has-feedback">
                                    <input type="submit" class="btn btn-primary" value="Submit" id="patient banneradd">
                                    <!--                         <button type="reset" class="btn btn-primary">Reset </button>
 -->
                                 </div>
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

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   CKEDITOR.replace('desc', {
      startupFocus: true,

      filebrowserUploadUrl: '<?php echo base_url('Settings_ctrl/report_upload') ?>',
      filebrowserUploadMethod: 'form'
   });


   CKEDITOR.editorConfig = function(config) {
      // Define changes to default configuration here.
      // For complete reference see:
      // http://docs.ckeditor.com/#!/api/CKEDITOR.config

      // The toolbar groups arrangement, optimized for two toolbar rows.
      config.toolbar = [
         ['SpecialChar', 'Bold', 'Italic', 'Strike', 'Underline', {
            name: 'colors',
            items: ['TextColor', 'BGColor']
         }]
      ];

      config.removePlugins = 'elementspath';
      config.resize_enabled = false;

      config.extraPlugins = 'colordialog';



   };
</script>