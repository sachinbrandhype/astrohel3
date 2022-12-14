<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
            View Setting Details
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>Home</a></li>
            <li><a href="#">Settings</a></li>
            <li class="active">Add Settings</li>
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
                  <h3 class="box-title">Add Setting Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                 <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
				 <div class="box-body">
				 <div class="col-md-6">
				 
                        
                                 <!--    <div class="form-group">
                                    <label class="intrate">Title</label>
                                    <input class="form-control required regcom" type="text" name="title" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $result->title; ?>">
                                    </div>
										 -->
								<!-- 	<div class="form-group">
                                    <label class="intrate">Language</label>
									 <select class="form-control " style="width: 100%;" id="languages" name="languages"   >																								
									<?php foreach($language as $languagedetails){ ?>
									<option value="<?php echo $languagedetails->id;?>" <?php if ($languagedetails->id == $result->languages){ ?>
									selected = "selected" <?php } ?> > <?php echo $languagedetails->languages; ?> </option>
								   <?php }  ?>	 								  
									</select></div> -->
								  <!--   <div class="form-group">
                                    <label class="intrate">Smtp Username</label>
                                    <input class="form-control required regcom" type="text" name="smtp_username" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $result->smtp_username; ?>">
                                    </div>	
                                    
									<div class="form-group">
                                    <label  class="intrate">Smtp Host</label>
                                    <input 	class="form-control regcom required" type="text" name="smtp_host" data-parsley-trigger="keyup" required="" id="smtp_host" value="<?php echo $result->smtp_host; ?>" >
                                    </div>
									
									<div class="form-group">
                                    <label  class="intrate">Smtp Password</label>
                                    <input 	class="form-control regcom required" type="text" name="smtp_password" data-parsley-trigger="keyup" required="" id="smtp_password" value="<?php echo $result->smtp_password; ?>" >
                                    </div>
									
									<div class="form-group">
                                    <label  class="intrate">Sender Id</label>
                                    <input 	class="form-control regcom required" type="text" name="sender_id" data-parsley-trigger="keyup" required="" id="sender_id" value="<?php echo $result->sender_id; ?>" >
                                    </div>
									
									<div class="form-group">
                                    <label  class="intrate">Sms username</label>
                                    <input 	class="form-control regcom required" type="text" name="sms_username" data-parsley-trigger="keyup" required="" id="sms_username" value="<?php echo $result->sms_username; ?>" >
                                    </div> -->
									
								   <div class="form-group">
                                    <label  class="intrate">Admin Email</label>
                                    <input 	class="form-control regcom required" type="text" name="admin_email" data-parsley-trigger="keyup" required="" id="admin_email" value="<?php echo $result->admin_email; ?>" >
                                    </div>

                                    <div class="form-group">
                                    <label  class="intrate">Support Email </label>
                                    <input  class="form-control regcom required" type="text" name="support_email" data-parsley-trigger="keyup" required="" id="support_email" value="<?php echo $result->support_email; ?>" >
                                    </div>




                                    <div class="form-group">
                                    <label  class="intrate">Emergency Number</label>
                                    <input 	class="form-control regcom required" type="number" name="emergency_number" data-parsley-trigger="keyup" required="" id="emergency_number" value="<?php echo $result->emergency_number; ?>" >
                                    </div>

                                    <div class="form-group">
                                    <label  class="intrate">Helpline Number</label>
                                    <input 	class="form-control regcom required" type="number" name="helpline_number" data-parsley-trigger="keyup" required="" id="helpline_number" value="<?php echo $result->helpline_number; ?>" >
                                    </div>

                                    
								   
									<!-- <div class="form-group">
                                    <label  class="intrate">Paypal Id</label>
                                    <input 	class="form-control regcom required" type="text" name="paypalid" data-parsley-trigger="keyup" required="" id="paypalid" value="<?php echo $result->paypalid; ?>" >
                                    </div>
									<div class="form-group">
                                    <label  class="intrate">Select Currency</label>
									<select name="currency" class="form-control required" id="" >
									<?php foreach($currencies as $singleamount) { ?>
									<option value="<?php echo $singleamount->id_countries;?>" <?php if ($singleamount->id_countries == $result->currency){ ?>
									selected = "selected" <?php } ?>><?php echo $singleamount->name .'('. $singleamount->iso_alpha3 .'-'. $singleamount->currrency_symbol . ')';  ?></option>
									<?php } ?>
									</select>                                    
                                    </div> -->

                                     <div class="form-group">
                                    <label  class="intrate">Website Link</label>
                                    <input  class="form-control regcom" type="text" name="website_link" data-parsley-trigger="keyup"  id="website_link" value="<?php echo $result->website_link; ?>" >
                                    </div>


                                    <div class="form-group">
                                    <label  class="intrate">Company Name</label>
                                    <input  class="form-control regcom" type="text" name="company_name" data-parsley-trigger="keyup"  id="company_name" value="<?php echo $result->company_name; ?>" >
                                    </div>



								   
                     <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Save" id="taxiadd">                      
                     </div>
                  </div>
				  
				        <div class="col-md-6">
						          
						            								          
								 <!--  <div class="form-group">
                                    <label  class="intrate">Sms Password</label>
                                    <input 	class="form-control regcom required" type="text" name="sms_password" data-parsley-trigger="keyup" required="" id="sms_password" value="<?php echo $result->sms_password; ?>" >
                                    </div> 	
								   
								   	 	<div class="form-group">
                                    <label  class="intrate">API Key</label>
                                    <input 	class="form-control regcom required" type="text" name="api_key" data-parsley-trigger="keyup" required=""  value="<?php echo $result->api_key; ?>" >
                                    </div>
						           <div class="form-group has-feedback">
								   <label for="exampleInputEmail1">Logo</label>
								   <input name="logo" class="" accept="image/*" type="file" value="<?php echo $result->logo; ?>">
								   <img src="<?php echo base_url().$result->logo; ?>" width="100px" height="100px" alt="Picture Not Found"/>
								   </div>							   
								   
								   <div class="form-group has-feedback">
								   <label for="exampleInputEmail1">Favicon</label>
								   <input name="favicon"  type="file" class="" value="<?php echo $result->favicon; ?>">
								   <img src="<?php echo base_url().$result->favicon; ?>" width="25px" height="25px" alt="Picture Not Found"/>
								   </div>
 -->

                                   <div class="form-group">
                                    <label  class="intrate">Google Play App Link</label>
                                    <input  class="form-control regcom" type="text" name="google_play_app_link" data-parsley-trigger="keyup"  id="google_play_app_link" value="<?php echo $result->google_play_app_link; ?>" >
                                    </div>

                                   

                                    <div class="form-group">
                                    <label  class="intrate">iOS App Link</label>
                                    <input  class="form-control regcom" type="text" name="ios_app_link" data-parsley-trigger="keyup"  id="ios_app_link" value="<?php echo $result->ios_app_link; ?>" >
                                    </div>

                                    <div class="form-group">
                                    <label  class="intrate">Facebook Link</label>
                                    <input  class="form-control regcom" type="text" name="facebook_link" data-parsley-trigger="keyup"  id="facebook_link" value="<?php echo $result->facebook_link; ?>" >
                                    </div>

                                    <div class="form-group">
                                    <label  class="intrate">Instagram Link</label>
                                    <input  class="form-control regcom" type="text" name="instagram_link" data-parsley-trigger="keyup"  id="instagram_link" value="<?php echo $result->instagram_link; ?>" >
                                    </div>

                                    <div class="form-group">
                                    <label  class="intrate">Twitter Link</label>
                                    <input  class="form-control regcom" type="text" name="twitter_link" data-parsley-trigger="keyup"  id="twitter_link" value="<?php echo $result->twitter_link ; ?>" >
                                    </div>

                                     <div class="form-group">
                                    <label  class="intrate">Linkedin Link</label>
                                    <input  class="form-control regcom" type="text" name="linkedin_link" data-parsley-trigger="keyup"  id="linkedin_link" value="<?php echo $result->linkedin_link; ?>" >
                                    </div>

                                     <div class="form-group">
                                    <label  class="intrate">Youtube Link</label>
                                    <input  class="form-control regcom" type="text" name="youtube_link" data-parsley-trigger="keyup"  id="youtube_link" value="<?php echo $result->youtube_link; ?>" >
                                    </div>

                                          <!-- <div class="form-group">
                                    <label  class="intrate">Refferal Wallet</label>
                                    <input  class="form-control regcom" type="number" name="refferal_wallet" step="any" min="0" data-parsley-trigger="keyup"  id="refferal_wallet" value="<?php echo $result->refferal_wallet; ?>" >
                                    </div> -->



		                </div>
				  
				  
		         
		           
				   
				   
		
             </div><!-- /.box-body -->
  
                </form>
              </div><!-- /.box -->
            </div>
            
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div>

	  