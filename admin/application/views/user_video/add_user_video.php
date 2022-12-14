<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add User Video 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>user_video_ctrl/user_video">User Video</a></li>
         <li class="active">Add User Video</li>
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
                  <h3 class="box-title"> Add User Video</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">                 
                     <div class="col-md-6">
                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1"> Title <span style="color: red;">*</span></label>
                            <input type="text" class="form-control required" data-parsley-trigger="change"  required name="title"  placeholder="Title">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

                       

                      <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Youtube Url<span style="color: red;">*</span></label>
                            <input type="text" class="form-control required" data-parsley-trigger="change"  required name="youtube_url"     placeholder="Youtube Url">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>
                   

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Position<span style="color: red;">*</span></label>
                            <input type="number" class="form-control required" data-parsley-trigger="change"  required name="position"  placeholder="Position">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                      <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">In App <span style="color: red;">*</span></label>
                           <select name="in_app" class="form-control required">
                              <option value="">Select</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                           </select>
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Status <span style="color: red;">*</span></label>
                           <select name="status" class="form-control required">
                               <option value="">Select</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                           </select>
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                    <div class="form-group has-feedback">
                            <label for="exampleInputEmail1"> Image</label>
                            <input  name="image"  type="file" >
                             <span class="glyphicon  form-control-feedback"></span>
                        </div>
                    
                


               <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                  </div>

               
            </div>

               <!-- /.box-body -->
                  
                </form>
   </section>
   <!-- /.content -->
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script type="text/javascript">
    // $(function () {
    //     $("#testtype").click(function () {
    //         if ($(this).is(":checked")) {
    //             $("#type_test").show();
    //             $('#testtype').val('basic');
                  
    //         } else {
    //             $("#type_test").hide();
    //             $('#baseid').val('');
    //             $('#advanceid').val('');

    //         }
    //     });
    // });
</script>
<script type="text/javascript">
    $(function () {
        $("#testtype11").click(function () {
            if ($(this).is(":checked")) {
                $("#type_test11").show();
                $('#testtype11').val('advance');  
                $('#baseid_adv').attr('required',true);  
                $('#discountid_adv').attr('required',true);  

            } else {
                $("#type_test11").hide();
                $('#discountid_adv').val('');
                $('#baseid_adv').val('');
            }
        });
    });
</script>

<!--    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'address1' );
CKEDITOR.replace( 'address2' );
</script>
 -->
