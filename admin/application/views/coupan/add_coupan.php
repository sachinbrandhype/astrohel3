<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Coupon Details
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>speedhuntson/coupan_list">Coupon Details</a></li>
         <li class="active">Add Coupon Appoinment</li>
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
                  <h3 class="box-title">Add Coupon Details</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                    
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Heading<span style="color: red">*</span></label>
                           <input required type="text" name="heading" class="form-control" placeholder="Today Offers">
                        </div>
                      
                        <div class="form-group">
                           <label>Coupon Code<span style="color: red">*</span></label>
                           <input required type="text" name="code" class="form-control" placeholder="123456">
                        </div>
                        <div class="form-group">
                           <label>Description<span style="color: red">*</span></label>
                           <input value="<?=$list->description?>" required type="text" name="description" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                           <label>Discount Type<span style="color: red">*</span></label>
                           <select required class="form-control select2 js-example-basic-multiple" name="discount_type" placeholder="Discount type">
                              <option value="">Select</option>
                              <option value="percentage">Percentage</option>
                              <option value="flat">Flat</option>
                              
                           </select>
                        </div>

                        <div class="form-group">
                           <label>Discount Amount<span style="color: red">*</span></label>
                           <input required type="number" min="1" step="any" name="amount" class="form-control" placeholder="100">
                        </div>

                         <div class="form-group">
                           <label>Coupon Uses Limit<span style="color: red">*</span></label>
                           <input required type="number" min="1" step="any" name="uses_limit" class="form-control" placeholder="100">
                        </div>

                        <div class="form-group">
                           <label>Coupon For <span style="color: red">*</span></label>
                           <select class="form-control select2 js-example-basic-multiple" name="discount_on" required>
                              <option value="">Select</option>
                            <!--   <option value="1">Puja</option> -->
                              <option value="2">Add Wallet </option>
                              <!-- <option value="3">Horoscope  </option> -->
                              <option value="4">Astrologers   </option>
                          <!--     <option value="5">Astrologers Horoscope     </option>
                              <option value="6">Life Prediction     </option> -->
                           </select>
                        </div>

                        <div class="form-group">
                           <label>Public  <span style="color: red">*</span></label>
                           <select class="form-control select2 js-example-basic-multiple" name="is_public" required>
                              <option value="">Select</option>
                              <option value="1">Yes</option>
                              <option value="2">No </option>
                           </select>
                        </div>

                        <div class="form-group">
                           <label> Start Date </label>
                           <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="form-group">
                           <label> Expiry Date </label>
                           <input type="date" name="expiry_date" class="form-control">
                        </div>

                        <div class="form-group has-feedback">
                           <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <input type="radio" id="compl" name="status" value="1" checked>&nbsp;Active&nbsp;&nbsp;
                           <input type="radio" id="complaintinput2" name="status" value="0">&nbsp;Inactive
                        </div>
                     </div>
                     
                  </div>
                  <div class="box">
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- /.box -->
         </div>
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
