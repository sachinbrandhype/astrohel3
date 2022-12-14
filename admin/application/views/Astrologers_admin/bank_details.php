<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Astrologers Bank Details 
      </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
            <li class="active"> Astrologers Bank Details </li>
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
                          <label for="exampleInputEmail1">Beneficiary Name <span style="color: red;">*</span></label>
                          <input type="text" class="form-control" value="<?php echo $data->beneficiary_name; ?>" data-parsley-trigger="change" data-parsley-minlength="2" required="" name="beneficiary_name">
                          <span class="glyphicon  form-control-feedback"></span>
                      </div>

                     
                      <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Bank Name<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" data-parsley-trigger="change" data-parsley-minlength="2" required name="bankName" value="<?php echo $data->bankName; ?>"  placeholder="Bank Name">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>
               

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Account Type <span style="color: red;">*</span></label>
                            <select name="account_type" class="form-control" required>
                               <option value="">Select</option>
                               <option value="1" <?=$data->account_type == "1" ? 'selected' : ''?>>Savings Account</option>
                               <option value="2" <?=$data->account_type ==  "2" ? 'selected' : ''?>>current account</option>
                            </select>
                    </div>

                  

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Account Number <span style="color: red;">*</span></label>
                            <input type="text" class="form-control"  data-parsley-trigger="change" data-parsley-minlength="2"  required name="bank_account_no" value="<?php echo $data->bank_account_no; ?>"  placeholder="Account Number ">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                  


                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">IFSC Code<span style="color: red;">*</span></label>
                            <input type="text" class="form-control"  data-parsley-trigger="change" data-parsley-minlength="2"  required name="ifsc_code" value="<?php echo $data->ifsc_code; ?>"  placeholder="IFSC Code ">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                  


                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Branch Name<span style="color: red;">*</span></label>
                            <input type="text" class="form-control"  data-parsley-trigger="change" data-parsley-minlength="2"  required name="branch_name" value="<?php echo $data->branch_name; ?>"  placeholder="Branch Name ">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>


                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Gst Number<span style="color: red;">*</span></label>
                            <input type="text" class="form-control"  data-parsley-trigger="change" data-parsley-minlength="2"  required name="gst_number" value="<?php echo $data->gst_number; ?>"  placeholder="gst_number ">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>


                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Pan Card Number<span style="color: red;">*</span></label>
                            <input type="text" class="form-control"  data-parsley-trigger="change" data-parsley-minlength="2"  required name="pan_number" value="<?php echo $data->pan_number; ?>"  placeholder="pan_number ">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Bank Address<span style="color: red;">*</span></label>
                         <textarea class="form-control" name="bank_address"><?php echo $data->bank_address; ?></textarea>
                            <span class="glyphicon  form-control-feedback" ></span>
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
