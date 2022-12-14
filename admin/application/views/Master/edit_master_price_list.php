<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Master Price 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>Master_ctrl/master_price_list">Master Price </a></li>
         <li class="active">Edit Master Price</li>
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
                  <h3 class="box-title">Edit Master Price </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">

                     <div class="col-md-6">
                     	  <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Match Making Price</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="1"   required="" step="any" name="match_making_price"  value="<?php echo $list->match_making_price; ?>" placeholder="Match Making Price">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                         <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Life Prediction Price</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="1"   required="" step="any" value="<?php echo $list->life_prediction_price; ?>" name="life_prediction_price"  placeholder="Life Prediction Price">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div> 
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Varshphal Pdf</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="1"   required="" step="any" value="<?php echo $list->varshphal_pdf; ?>" name="varshphal_pdf"  placeholder="Life Prediction Price">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Medical Price</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="1"   required="" step="any" value="<?php echo $list->medical_price; ?>" name="medical_price"  placeholder="medical_price">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Financial Price</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="1"   required="" step="any" value="<?php echo $list->financial_price; ?>" name="financial_price"  placeholder="financial_price">
                           <span class="glyphicon  form-control-feedback"></span>
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