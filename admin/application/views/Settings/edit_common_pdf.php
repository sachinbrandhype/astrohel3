<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
             Pdf
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>Home</a></li>
            <li><a href="#">Edit Pdf</a></li>
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
               <!--    <h3 class="box-title">Edit Pdf </h3> -->
                </div><!-- /.box-header -->
                <!-- form start -->

 <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
         <div class="box-body">
         <div class="col-md-6">
         
                        
                  <input type="hidden" name="pdf" value="<?=$result->common_pdf?>">
                  <div class="form-group has-feedback">
                     <label for="exampleInputEmail1">PDF</label>
                     <input  type="file" name="userfile" class="form-control" accept="application/pdf">
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

	  