<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Edit User News
      </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
            <li><a href="<?php echo base_url();?>user_news_ctrl/user_news">User News</a></li>
            <li class="active">Edit User News</li>
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
                        <h3 class="box-title"></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">

                        <div class="box-body">
                            <div class="col-md-6">

                                <div class="form-group has-feedback">
                                    <label for="exampleInputEmail1">Title <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control required" value="<?php echo $data->title; ?>" data-parsley-trigger="change"  required="" name="title">
                                    <span class="glyphicon  form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputEmail1">Url <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control required" value="<?php echo $data->url; ?>" data-parsley-trigger="change"  required="" name="url">
                                    <span class="glyphicon  form-control-feedback"></span>
                                </div>

                         <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Description <span style="color: red;">*</span></label>
                           <textarea  class="form-control" required name="description" ><?php echo $data->description; ?></textarea>
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

                   
                      <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Date<span style="color: red;">*</span></label>
                            <input type="date" class="form-control required" data-parsley-trigger="change"  required name="date"   value="<?php echo $data->date; ?>"  placeholder="Date">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>
                    

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Position<span style="color: red;">*</span></label>
                            <input type="number" class="form-control required" data-parsley-trigger="change"  required name="position" value="<?php echo $data->position; ?>" placeholder="Position">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>


                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Status <span style="color: red;">*</span></label>
                           <select name="status" class="form-control required">
                               <option value="">Select</option>
                             <?php if ($data->status == 1): ?>
                                  <option value="0" >Inactive</option>
                                  <option value="1" selected>Active</option>
                              <?php else: ?>
                                  <option value="0" selected>Inactive</option>
                                  <option value="1" >Active</option>
                              <?php endif ?>
                           </select>
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                       <div class="form-group has-feedback">
                     <label for="exampleInputEmail1"> Image</label>
                     <div class="row">
                        <div class="col-md-6">
                           <input type="file" class="form-control" name="image">
                        </div>
                        <div class="col-md-6">
                           <img height="50" width="70" alt="your image" src="<?php echo base_url('/')."uploads/news/";?><?=$data->image?>" name=""/>
                           <input type="hidden" name="image11" value="<?php echo $data->image; ?>" class="form-control">
                        </div>
                     </div>
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                      

                             <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Update</button>
                  </div>


                                
            </div>

             <div class="col-md-6">

                   
                  


                    
                   

                  </div>
           
        </div>
        </form>
</div>
<!-- /.box -->
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script type="text/javascript">
    //   $('#add_advance').on('click', function() { 
    //     $('#advance_exer').append('<div class="exer form-group has-feedback" ><input type="text" name="advance[profile][]" class="form-control required" placeholder="Profile"><span class="remove fa fa-minus-circle"></span></div>');
    //     return false; //prevent form submission
    // });

    // if ($("#testtype").prop('checked') == true) {
    //     $("#type_test").show();
    // }

    if ($("#testtype11").prop('checked') == true) {
        $("#type_test11").show();
    }
    $(function() {
        // $("#testtype").click(function() {
        //     if ($(this).is(":checked")) {
        //         $("#type_test").show();
        //         $("#type_test").val('basic');

        //     } else {
        //         $("#type_test").hide();
        //         $("#basicid").val('');

        //     }
        // });
        $("#testtype11").click(function() {
            if ($(this).is(":checked")) {
                $("#type_test11").show();
                $("#type_test11").val('advance');
                 $('#baseid_adv').attr('required',true);  
                $('#discountid_adv').attr('required',true);  

            } else {
                $("#type_test11").hide();
                $("#advanceid").val('');
            }
        });
    });
</script>

 <!-- <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'address1' );
CKEDITOR.replace( 'address2' );
</script> -->