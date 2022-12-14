<?php $id = $this->session->userdata('admin');  ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Website blog
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url(); ?>banner_ctrl/view_banner"> Edit Website blog Details </a></li>
         <li class="active">Edit Website blog</li>
      </ol>
   </section>
   <!-- Website content -->
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
         <form role="form" method="post" action="<?php echo base_url('banner_ctrl/edit_website_blog') ?>" id="patient banner_reg" data-parsley-validate="" class="validate" enctype="multipart/form-data">

            <div class="col-md-12">
               <!-- general form elements -->
               <div class="box">
                  <div class="box-header with-border">
                     <h3 class="box-title">Edit Website blog </h3>
                     <div class="edituser" tabindex='1'></div>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                     <div class="col-md-6">

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Image</label>
                           <input name="image" type="file">
                           <br>
                           <img height="50" width="70" alt="your image" src="<?php echo base_url('/') . "uploads/blog/"; ?><?= $data->image ?>" name="" />

                           <input type="hidden" name="image11" value="<?php echo $data->image; ?>" class="form-control">
                           <input type="hidden" name="id" value="<?php echo $data->id; ?>" class="form-control">

                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Title </label>
                           <input type="text" class="form-control required" name="title" value="<?= $data->title ?>" placeholder="Title">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>


                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Author Name </label>
                           <select class="form-control" name="author_name">
                              <?php
                              $cat = $this->db->query("select id,name from astrologers where status = 1")->result();
                              foreach ($cat as $cat_key) {
                              ?>
                                 <option value="<?php echo $cat_key->id; ?>" <?= $data->author_name == $cat_key->id ? 'selected' : '' ?>><?php echo $cat_key->name; ?></option>
                              <?php
                              }
                              ?>

                           </select>

                        </div>




                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Date</label>
                           <input type="date" class="form-control required" name="show_date" value="<?= $data->show_date ?>" placeholder="Author Name">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">desc </label>
                           <textarea class="form-control required" name="desc">
                              <?= $data->desc ?>
                            </textarea>

                           <span class="glyphicon  form-control-feedback"></span>
                        </div>



                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Position <span style="color: red;">*</span></label>
                           <input type="number" class="form-control required" min="1" data-parsley-trigger="change" data-parsley-minlength="1" value="<?= $data->position ?>" required name="position" placeholder="Position">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="complaintinput2">Blog Type:</label>


                           <select name="blog_type" class="form-control">
                              <option value="1" <?= $data->blog_type == 1 ? "selected" : "" ?>>Video Link</option>
                              <option value="0" <?= $data->blog_type == 0 ? "selected" : "" ?>>Blog Url</option>
                           </select>

                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Video Url: </label>
                           <input type="text" class="form-control" name="video_url" value="<?= $data->video_url ?>" placeholder="Video Url">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="complaintinput2">Status:</label>


                           <select name="status" class="form-control required">
                              <option value="1" <?= $data->status == 1 ? "selected" : "" ?>>Active</option>
                              <option value="0" <?= $data->status == 0 ? "selected" : "" ?>>Inactive</option>
                           </select>

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
   CKEDITOR.replace('desc');
</script>