<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
     Add Ratings List
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add Ratings List</li>
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
                  <h3 class="box-title"> Add Ratings List</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">                 
                     <div class="col-md-12">
                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1"> Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control required" data-parsley-trigger="change"  required name="name"  placeholder=" Name">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

                  <div class="form-group has-feedback">
                            <label for="exampleInputEmail1"> Rate <span style="color: red;">*</span></label>
                           <select class="form-control" name="rate">
                          <?php
                              for ($i=1; $i<=5; $i++)
                              {
                                  ?>
                                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                  <?php
                              }
                          ?>
                          </select>
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>


                 


                 
                    <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Reviews <span style="color: red;">*</span></label>
                        
   <input type="text" class="form-control required" data-parsley-trigger="change"  required name="reviews"  placeholder="Reviews">
                          <!--  <textarea  class="form-control" required name="reviews" ></textarea> -->
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

                   

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Is Shown To User  <span style="color: red;">*</span></label>
                           <select name="is_shown_to_user" class="form-control required">
                               <option value="">Select</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                           </select>
                            <span class="glyphicon  form-control-feedback" ></span>
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

