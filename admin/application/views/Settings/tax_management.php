<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
             Tax Management
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>Home</a></li>
            <li><a href="#">Tax Management</a></li>
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
                <!--   <h3 class="box-title">Gandmool</h3> -->
                </div><!-- /.box-header -->
                <!-- form start -->
                 <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
				 <div class="box-body">
				 <div class="col-md-12">
				 
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Online Consultation</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="online_consultation"  value="<?php echo $list->online_consultation; ?>" placeholder="online_consultation">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">In Person</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="in_person"  value="<?php echo $list->in_person; ?>" placeholder="in_person">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Match Making</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="match_making"  value="<?php echo $list->match_making; ?>" placeholder="match_making">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Life Prediction</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="life_prediction"  value="<?php echo $list->life_prediction; ?>" placeholder="life_prediction">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Class Package</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="class_package"  value="<?php echo $list->class_package; ?>" placeholder="class_package">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Gems Booking</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="gems_booking"  value="<?php echo $list->gems_booking; ?>" placeholder="gems_booking">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Pdf Booking</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="pdf_booking"  value="<?php echo $list->pdf_booking; ?>" placeholder="pdf_booking">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Medical Booking</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="medical_booking"  value="<?php echo $list->medical_booking; ?>" placeholder="medical_booking">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>

                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">Financial Booking</label>
                     <input type="number" class="form-control required" data-parsley-trigger="change"  min="0"   required="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'white'
" name="financial_booking"  value="<?php echo $list->financial_booking; ?>" placeholder="financial_booking">
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>


								   
                     <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Save" id="taxiadd">                      
                     </div>
                  </div>
				  
				        
				  
		         
		           
				   
				   
		
             </div><!-- /.box-body -->
  
                </form>
              </div><!-- /.box -->
            </div>
            
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div>

	       <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'gandmool' );


</script>

    