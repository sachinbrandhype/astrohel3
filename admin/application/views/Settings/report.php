<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
            <?php echo $page_title;  ?>
            
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>Home</a></li>
       
            <li class="active"><?php echo $page_title;  ?></li>
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
               <!--    <h3 class="box-title">Price Details</h3> -->
                </div><!-- /.box-header -->
                <!-- form start -->
                 <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
				 <div class="box-body">
				 <div class="col-md-12">
				 
                        
                          <div class="form-group">
                          <label class="intrate">Heading</label>
                          <input class="form-control required regcom" type="text" name="heading" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $result->heading; ?>">

                            <input class="form-control required regcom" type="hidden" name="type" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $type; ?>">


                          </div>

                          <div class="form-group">
                          <label for="">Desc<span style="color: red">*</span></label>
                          <textarea name="desc" class="form-control" required=""><?=$result->desc?></textarea>
                         
                         </div>


                    <div class="form-group has-feedback">
                       <label for="exampleInputEmail1">Image</label>
                       <input name="image" class="" accept="image/*" type="file" value="<?php echo $result->image; ?>">
                       <img src="<?php echo base_url("uploads/common").'/'.$result->image; ?>" width="100px" height="100px" alt="Picture Not Found"/>
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
  

   CKEDITOR.replace('desc', {
    startupFocus: true,
   
    filebrowserUploadUrl: '<?php echo base_url('Settings_ctrl/report_upload') ?>',
     filebrowserUploadMethod: 'form'
});

  
</script>