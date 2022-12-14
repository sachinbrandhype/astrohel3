<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
            Add Policy Details
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>Home</a></li>
            <li><a href="#">Policy</a></li>
            <li class="active">Add Policy</li>
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
              <!--     <h3 class="box-title">Add Policy Details</h3> -->
                </div><!-- /.box-header -->
                <!-- form start -->
                 <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
				 <div class="box-body">
				 <div class="col-md-12">
				 
                         <div class="form-group">
                          <label for="">About Us<span style="color: red">*</span></label>
                          <textarea name="about_us" class="form-control" required=""><?=$result->about_us?></textarea>
                         
                         </div>


                         <div class="form-group">
                          <label for="">Our Vision<span style="color: red">*</span></label>
                          <textarea name="our_vision" class="form-control" required=""><?=$result->our_vision?></textarea>
                         
                         </div>

                        <div class="form-group">
                          <label for="">Privacy<span style="color: red">*</span></label>
                          <textarea name="privacy" class="form-control" required=""><?=$result->privacy?></textarea>
                         
                         </div>


                        <div class="form-group">
                          <label for="">Terms Condition<span style="color: red">*</span></label>
                          <textarea name="terms_condition" class="form-control" required=""><?=$result->terms_condition?></textarea>
                         
                         </div>


                              
                        <div class="form-group">
                          <label for="">Contact Us<span style="color: red">*</span></label>
                          <textarea name="contact_us" class="form-control" required=""><?=$result->contact_us?></textarea>
                         
                         </div>


                                
									
								   



								   
                     <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Save" id="taxiadd">                      
                     </div>
                  </div>
				  
				        <div class="col-md-6">
						          
						       
                               



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
   CKEDITOR.replace( 'about_us' );
   CKEDITOR.replace( 'terms_condition' );
   CKEDITOR.replace( 'privacy' );
   CKEDITOR.replace( 'our_vision' );
   CKEDITOR.replace( 'contact_us' );
</script>