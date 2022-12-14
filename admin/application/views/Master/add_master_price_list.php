<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Master Price 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add Master Price </li>
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
                  <h3 class="box-title"> Add Master Price  </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="<?=base_url('Master_ctrl/add_master_price_list')?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-12">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Match Making Price</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" name="match_making_price"  placeholder="Match Making Price">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                         <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Life Prediction Price</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" name="life_prediction_price"  placeholder="Life Prediction Price">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
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