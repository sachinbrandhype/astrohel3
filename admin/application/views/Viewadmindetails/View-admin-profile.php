<?php 
$admin_detail = pull_admin();
 ?>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Profile Details
            <small></small>
          </h1>
    
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
                   
				   
	<div class="col-md-7">
              <!-- general form elements -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">View Profile Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                 
				 <div class="box-body box-profile">
				 
				 
					  <div class="user-profile-pic">
					  <?php if($admin_detail[0]->profile_picture != NULL){ ?>
						 <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().$admin_detail[0]->profile_picture;?>" alt="User profile picture">					
					  <?php }else{ ?>
						 <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/images/user_avatar.jpg" alt="User profile picture">					
					  <?php } ?>
						  <div class="change-profile-pic">  
							<div class="uploadFile">
								<form method="post" action="" id="profilepic-form-img" enctype="multipart/form-data">
								<input type="file" name="profile_picture" id="profileimg-form" class="custom-file-input">
								<input type="hidden" name="picturechecker" value="picturechecker">
								</form>
							</div>
						  </div>
					  </div></br>
		
				   
				   <div class="form-group has-feedback">
                     <li class="list-group-item">
                      <b>Username</b> <a class="pull-right"><?php echo $admin_detail[0]->username; ?></a>
                    </li>
				   </div>
                </div><!-- /.box-body -->
				
				
				
				
         
              </div><!-- /.box -->
            </div> 
			
			
			   <div class="col-md-5">
              <!-- general form elements -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Reset Password</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo base_url(); ?>Admin_detailsview/Admin_change_password" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
                 
				 <div class="box-body">
				 <div class="col-md-6">
                 <div class="form-group col-md-12">
	
                      <label>Old Password1</label>
                      <div class="input-group">
                      <input type="password" name="password" class="form-control input_size required" data-parsley-trigger="change"	
                      data-parsley-minlength="2" data-parsley-maxlength="25" required="" placeholder="Enter Old Password">
                      <span class="input-group-btn">
							<button class="btn btn-flat show-pwd-btn" type="button">
								<i class="fa fa-eye"></i>
							</button>
					  </span>
                      </div>
                      </div>

                      <div class="form-group col-md-12">
                      <label>New Password</label>
                      <div class="input-group">
                      <input type="password" name="n_password" class="form-control input_size required" data-parsley-trigger="change"	
                   data-parsley-minlength="6" data-parsley-maxlength="25" required=""placeholder="Enter New Password">
                      <span class="input-group-btn">
							<button class="btn btn-flat show-pwd-btn" type="button">
								<i class="fa fa-eye"></i>
							</button>
					  </span>
                      </div>
                      </div>

                      <div class="form-group col-md-12">
                      <label>Confirm Password</label>
                      <div class="input-group">
                      <input type="password" name="c_password" class="form-control input_size required" data-parsley-trigger="change"	
                   data-parsley-minlength="6" data-parsley-maxlength="25"  required="" placeholder="Enter Password Again">
                      <span class="input-group-btn">
							<button class="btn btn-flat show-pwd-btn" type="button">
								<i class="fa fa-eye"></i>
							</button>
					  </span>
                      </div>
                      </div>				  
						  <div class="box-footer">
							<button type="submit" class="btn btn-primary" name="reset_pwd">Update</button>
						  </div>				  

		              </div>
					   
                   </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
            </div> 
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div>