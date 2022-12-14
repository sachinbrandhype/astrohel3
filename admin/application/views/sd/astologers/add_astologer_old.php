<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?=$page_title?>Details
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>sd/astrologers/astologers_list_pending">Astrologer's List</a></li>
         <li class="active"><?=$page_title?></li>
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
                  <h3 class="box-title">Add Astrologer Details</h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="<?=base_url('sd/astrologers/insert');?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Name<span style="color: red;">*</span></label>
                           <input required type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                           <label>Is Home  <span style="color: red;">*</span></label>
                           <select name="is_home" id="is_home" class="form-control" required >
                              <option value="">Select</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Astrologer Experience<span style="color: red;">*</span></label>
                           <input required type="number" step="0.1" name="experience" class="form-control" placeholder="Astrologer Experience" min="0">
                        </div>
                        <div class="form-group">
                           <label>Share Percentage<span style="color: red;">*</span></label>
                           <input required type="number" name="share_percentage" class="form-control" placeholder="Share Percentage" min="1" max="100">
                        </div>
                        <div class="form-group">
                           <label>Languages</label>
                           <select class="form-control select2 js-example-basic-multiple" name="languages[]" placeholder="Select Languages" multiple>
                              <option value=""></option>
                              <?php foreach ($language as $key): ?>
                              <option value="<?=$key->language_name?>"><?=$key->language_name?></option>
                              <?php endforeach ?>
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Address</label>
                           <textarea class="form-control" name="location"></textarea>
                        </div>
                        <div class="form-group">
                           <label>Contact Number<span style="color: red;">*</span></label>
                           <input required type="text" name="mobile" id="phone" class="form-control" placeholder="Contact Number">
                        </div>
                        <div id="msg"></div>
                        <div class="form-group">
                           <label>Email<span style="color: red;">*</span></label>
                           <input required type="text" name="email" id="email" class="form-control" required placeholder="Email" onkeyup="myFunction()" >
                        </div>
                        <div class="form-group">
                           <label>Password<span style="color: red;">*</span></label>
                           <input required type="text" name="random_password" class="form-control" placeholder="password">
                        </div>

                        <div class="form-group">
                           <label>Booking Type <span style="color: red;">*</span></label>
                           <select name="is_approval" id="is_approval" class="form-control" required onChange="booking_take();">
                              <option value="">Select</option>
                              <option value="0">No</option>
                              <option value="1">Can take Schedule Booking's</option>
                              <option value="2">Can take Live booking's</option>
                              <option value="3">Both types of Booking's</option>
                           </select>
                        </div>
                        
                        
                        <div id="online_zone" class="form-group" style="display: none;">
                           <label>Online Consult <span style="color: red;">*</span></label>
                           <select name="online_consult" id="online" class="form-control"  onChange="myFunc_online();">
                              <option value="0" selected>Select</option>
                              <option value="0">No</option>
                              <option value="1">Chat</option>
                              <option value="2">Video</option>
                              <option value="3">Audio</option>
                              <option value="4">Triple</option>
                              <option value="5">Chat And Video</option>
                              <option value="6">Chat And Audio</option>
                              <option value="7">Video And Audio</option>
                           </select>
                        </div>

                        <div id="online_p" class="form-group">
                        </div>
                        <div id="online_video_p" class="form-group">
                        </div>
                        <div id="online_audio_p" class="form-group">
                        </div>
                        <div id="per_mint" class="form-group" style="display: none;">
                           <label>Per Minute Charge<span style="color: red;">*</span></label>
                           <input  value="0" value="0" type="number" min="0" step="any"  name="price_per_mint" class="form-control" placeholder="Price per Minute">
                        </div>

                        <div class="form-group">
                           <label>In House Astrologers <span style="color: red;">*</span></label>
                           <select name="in_house_astrologers" id="inhouse" class="form-control" required onChange="myFunc_inhouse();">
                              <option value="">Select</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Is Premium Astrologer  <span style="color: red;">*</span></label>
                           <select name="is_premium" id="is_home" class="form-control" required >
                              <option value="">Select</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                           </select>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Aadhar Number</label>
                           <input data-type="adhaar-number" maxLength="19" class="form-control   regcom sample" placeholder="Aadhar Number" name="aadhar_number"  type="text" >
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Pan Number</label>
                           <input class="form-control   regcom sample" placeholder="Pan Number" name="pan_number"  type="text"   >
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Bank Name</label>
                           <input class="form-control   regcom sample" placeholder="Bank Name " name="bankName"  type="text"   >
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Bank Account Number</label>
                           <input class="form-control   regcom sample" placeholder="Bank Account Number" name="bank_account_no"  type="text"   >
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">IFSC Code</label>
                           <input class="form-control   regcom sample" placeholder="IFSC Code" name="ifsc_code"  type="text"   >
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Image</label>
                           <input  name="image"  type="file" id="files">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                           <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <input type="radio" id="compl" name="status" value="1" checked>&nbsp;Active&nbsp;&nbsp;
                           <input type="radio" id="complaintinput2" name="status" value="0">&nbsp;Inactive
                        </div>
                     </div>
                     <!-- Second Start -->
                     <div class="col-md-6">
                        <div class="form-group">
                              <label>Area of Expertise</label>
                              <textarea id="" name="expertise" class="form-control"  rows="5" cols="86">
                              </textarea>
                           </div>
                           <div class="form-group">
                              <label>Biography</label>
                              <textarea id="" name="bio" rows="5" class="form-control" cols="86">
                              </textarea>
                           </div>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Online Consultation Time</label>
                              <div class="box-body no-padding">
                                 <table class="table table-striped">
                                    <tr>
                                       <th>#</th>
                                       <th>Days</th>
                                       <th>Starting Time</th>
                                       <th>Ending Time</th>
                                       <th><input type="checkbox" class="checkbox_check_video" name="test1" value=""></th>
                                    </tr>
                                    <tr>
                                       <td>1.</td>
                                       <td>Monday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="monday_video[0][start]" class="form-control timepicker video_start1"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group monday3">
                                                <div class="input-group">
                                                   <input type="text" name="monday_video[1][start]" class="form-control timepicker video_end1"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="monday_video[0][end]" class="form-control timepicker video_start2"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group monday3">
                                                <div class="input-group">
                                                   <input type="text" name="monday_video[1][end]" class="form-control timepicker video_end2"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle91"></span></td>
                                    </tr>
                                    <tr>
                                       <td>2.</td>
                                       <td>Tuesday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group ">
                                                <div class="input-group">
                                                   <input type="text" name="tuesday_video[0][start]" class="form-control timepicker v11"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group tuesday3">
                                                <div class="input-group">
                                                   <input type="text" name="tuesday_video[1][start]" class="form-control timepicker v12"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="tuesday_video[0][end]" class="form-control timepicker v13"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group tuesday3">
                                                <div class="input-group">
                                                   <input type="text" name="tuesday_video[1][end]" class="form-control timepicker v14"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle92"></span></td>
                                    </tr>
                                    <tr>
                                       <td>3.</td>
                                       <td>Wednesday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="wednesday_video[0][start]" class="form-control timepicker v11"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group wednesday3">
                                                <div class="input-group">
                                                   <input type="text" name="wednesday_video[1][start]" class="form-control timepicker v12"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="wednesday_video[0][end]" class="form-control timepicker v13"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group wednesday3">
                                                <div class="input-group">
                                                   <input type="text" name="wednesday_video[1][end]" class="form-control timepicker v14"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle93"></span></td>
                                    <tr>
                                       <td>4.</td>
                                       <td>Thursday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="thursday_video[0][start]" class="form-control timepicker v11"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group thursday3">
                                                <div class="input-group">
                                                   <input type="text" name="thursday_video[1][start]" class="form-control timepicker v12"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="thursday_video[0][end]" class="form-control timepicker v13"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group thursday3">
                                                <div class="input-group">
                                                   <input type="text" name="thursday_video[1][end]" class="form-control timepicker v14"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle94"></span></td>
                                    </tr>
                                    <tr>
                                       <td>5.</td>
                                       <td>Friday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="friday_video[0][start]" class="form-control timepicker v11"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group friday3">
                                                <div class="input-group">
                                                   <input type="text" name="friday_video[1][start]" class="form-control timepicker v12"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="friday_video[0][end]" class="form-control timepicker v13"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group friday3">
                                                <div class="input-group">
                                                   <input type="text" name="friday_video[1][end]" class="form-control timepicker v14"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle95"></span></td>
                                    </tr>
                                    <tr>
                                       <td>6.</td>
                                       <td>Saturday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="saturday_video[0][start]" class="form-control timepicker v11"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group saturday3">
                                                <div class="input-group">
                                                   <input type="text" name="saturday_video[1][start]" class="form-control timepicker v12"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="saturday_video[0][end]" class="form-control timepicker v13"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group saturday3">
                                                <div class="input-group">
                                                   <input type="text" name="saturday_video[1][end]" class="form-control timepicker v14"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle96"></span></td>
                                    </tr>
                                    <tr>
                                       <td>7.</td>
                                       <td>Sunday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" name="sunday_video[0][start]" class="form-control timepicker v11"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group sunday3">
                                                <div class="input-group">
                                                   <input type="text" name="sunday_video[1][start]" class="form-control timepicker v12"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group ">
                                                <div class="input-group">
                                                   <input type="text" name="sunday_video[0][end]" class="form-control timepicker v13"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group sunday3">
                                                <div class="input-group">
                                                   <input type="text" name="sunday_video[1][end]" class="form-control timepicker v14"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle97"></span></td>
                                    </tr>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="box">
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script> 
   function myFunction() {
   var email = $('#email').val();    
   $.ajax({ 
         url: "<?=base_url('/')?>sd/astrologers/check_email_phone", 
        
         data: {email:email},
   
         method: "post",
         success: function(data){
         console.log(data);
         var service = JSON.parse(data);
         if(service['status'])
           {  
             $('#msg').html('<span style="color: red;">already exist</span>');
             $('#email').val("");
   
           } 
   
            else {
              // alert("Value not already exist")
                $('#msg').html('<span style="color:red;"></span>');
           }
         }
   });
   
   
   }
</script> 
<script type="text/javascript">
   $(document).ready(function(){
   
   $(":checkbox").on("click", function(){
     if ($('input.checkbox_check').is(':checked')) 
     {
   
        var monday_chat_start1 = $('.monday_chat_start1').val();
        var monday_chat_start2 = $('.monday_chat_start2').val();
        var monday_chat_end1 = $('.monday_chat_end1').val();
        var monday_chat_end2 = $('.monday_chat_end2').val();
         // alert(monday_chat_start1);
         // alert(monday_chat_start2);
         // alert(monday_chat_end1);
         // alert(monday_chat_end2);
           
        var $content82 = $(".tuesday2").hide();
        var $content83 = $(".wednesday2").hide();
        var $content84 = $(".thursday2").hide();
        var $content85 = $(".friday2").hide();
        var $content86 = $(".saturday2").hide();
        var $content87 = $(".sunday2").hide();
         if(monday_chat_start1 != '' && monday_chat_start2 != '')
         {
           $('.dd11').val(monday_chat_start1);
           $('.dd13').val(monday_chat_start2);
           
           if (monday_chat_end1 != '' && monday_chat_end2 != '') 
           {
             $(".toggle82").toggleClass("expanded");
             $content82.slideToggle();
             $(".toggle83").toggleClass("expanded");
             $content83.slideToggle();
             $(".toggle84").toggleClass("expanded");
             $content84.slideToggle();
             $(".toggle85").toggleClass("expanded");
             $content85.slideToggle();
             $(".toggle86").toggleClass("expanded");
             $content86.slideToggle();
             $(".toggle87").toggleClass("expanded");
             $content87.slideToggle();
            
             $('.dd12').val(monday_chat_end1);
             $('.dd14').val(monday_chat_end2);
           }
         }
         else
         {
           $(".checkbox_check").prop("checked", false);
           alert('Please select time slots')
         }
     }
     else
     {
   
         $('.dd11').val('');
         $('.dd12').val('');
         $('.dd13').val('');
         $('.dd14').val('');
     }
   
     if ($('input.checkbox_check_video').is(':checked')) 
     {
   
        var video_start1 = $('.video_start1').val();
        var video_start2 = $('.video_start2').val();
        var video_end1 = $('.video_end1').val();
        var video_end2 = $('.video_end2').val();
         // alert(video_start1);
         // alert(video_start2);
         // alert(video_end1);
         // alert(video_end2);
           
        var $content92 = $(".tuesday3").hide();
        var $content93 = $(".wednesday3").hide();
        var $content94 = $(".thursday3").hide();
        var $content95 = $(".friday3").hide();
        var $content96 = $(".saturday3").hide();
        var $content97 = $(".sunday3").hide();
         if(video_start1 != '' && video_start2 != '')
         {
           $('.v11').val(video_start1);
           $('.v13').val(video_start2);
           
           if (video_end1 != '' && video_end2 != '') 
           {
             $(".toggle92").toggleClass("expanded");
             $content92.slideToggle();
             $(".toggle93").toggleClass("expanded");
             $content93.slideToggle();
             $(".toggle94").toggleClass("expanded");
             $content94.slideToggle();
             $(".toggle95").toggleClass("expanded");
             $content95.slideToggle();
             $(".toggle96").toggleClass("expanded");
             $content96.slideToggle();
             $(".toggle97").toggleClass("expanded");
             $content97.slideToggle();
            
             $('.v12').val(video_end1);
             $('.v14').val(video_end2);
           }
         }
         else
         {
           $(".checkbox_check_video").prop("checked", false);
           alert('Please select time slots')
         }
     }
     else
     {
   
         $('.v11').val('');
         $('.v12').val('');
         $('.v13').val('');
         $('.v14').val('');
     }
   
   
     if ($('input.checkbox_check_clinic').is(':checked')) 
     {
   
        var clinic_start1 = $('.clinic_start1').val();
        var clinic_start2 = $('.clinic_start2').val();
        var clinic_end1 = $('.clinic_end1').val();
        var clinic_end2 = $('.clinic_end2').val();
         // alert(clinic_start1);
         // alert(clinic_start2);
         // alert(clinic_end1);
         // alert(clinic_end2);
           
        var $content21 = $(".tuesday1").hide();
        var $content31 = $(".wednesday1").hide();
        var $content41 = $(".thursday1").hide();
        var $content51 = $(".friday1").hide();
        var $content61 = $(".saturday1").hide();
        var $content71 = $(".sunday1").hide();
         if(clinic_start1 != '' && clinic_start2 != '')
         {
           $('.c11').val(clinic_start1);
           $('.c13').val(clinic_start2);
           
           if (clinic_end1 != '' && clinic_end2 != '') 
           {
             $(".toggle21").toggleClass("expanded");
             $content21.slideToggle();
             $(".toggle31").toggleClass("expanded");
             $content31.slideToggle();
             $(".toggle41").toggleClass("expanded");
             $content41.slideToggle();
             $(".toggle51").toggleClass("expanded");
             $content51.slideToggle();
             $(".toggle61").toggleClass("expanded");
             $content61.slideToggle();
             $(".toggle71").toggleClass("expanded");
             $content71.slideToggle();
            
             $('.c12').val(clinic_end1);
             $('.c14').val(clinic_end2);
           }
         }
         else
         {
           $(".checkbox_check_clinic").prop("checked", false);
           alert('Please select time slots')
         }
     }
     else
     {
   
         $('.c11').val('');
         $('.c12').val('');
         $('.c13').val('');
         $('.c14').val('');
     }
   
   })
   
      $("#divid").hide();
     $('#colorselector').change(function(){
       if ( this.value == '1')
       {
         $("#divid").show();
       }
       
       else
       {
         $("#services").select2("val", "");
         $("#divid").hide();
       }
     });
   });
</script>
<script type="text/javascript">
   var $content1 = $(".monday").hide();
   $(".toggle").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content1.slideToggle();
   });
   var $content2 = $(".tuesday").hide();
   $(".toggle1").on("click", function(e){
    $(this).toggleClass("expanded");
    $content2.slideToggle();
   });
   
   var $content3 = $(".wednesday").hide();
   $(".toggle2").on("click", function(e){
    $(this).toggleClass("expanded");
    $content3.slideToggle();
   });
   
   var $content4 = $(".thursday").hide();
   $(".toggle3").on("click", function(e){
    $(this).toggleClass("expanded");
    $content4.slideToggle();
   });
   
   var $content5 = $(".friday").hide();
   $(".toggle4").on("click", function(e){
    $(this).toggleClass("expanded");
    $content5.slideToggle();
   });
   
   var $content6 = $(".saturday").hide();
   $(".toggle5").on("click", function(e){
    $(this).toggleClass("expanded");
    $content6.slideToggle();
   });
   
   var $content7 = $(".sunday").hide();
   $(".toggle6").on("click", function(e){
    $(this).toggleClass("expanded");
    $content7.slideToggle();
   });
   
   
   
   var $content11 = $(".monday1").hide();
   $(".toggle11").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content11.slideToggle();
   });
   var $content21 = $(".tuesday1").hide();
   $(".toggle21").on("click", function(e){
    $(this).toggleClass("expanded");
    $content21.slideToggle();
   });
   
   var $content31 = $(".wednesday1").hide();
   $(".toggle31").on("click", function(e){
    $(this).toggleClass("expanded");
    $content31.slideToggle();
   });
   
   var $content41 = $(".thursday1").hide();
   $(".toggle41").on("click", function(e){
    $(this).toggleClass("expanded");
    $content41.slideToggle();
   });
   
   var $content51 = $(".friday1").hide();
   $(".toggle51").on("click", function(e){
    $(this).toggleClass("expanded");
    $content51.slideToggle();
   });
   
   var $content61 = $(".saturday1").hide();
   $(".toggle61").on("click", function(e){
    $(this).toggleClass("expanded");
    $content61.slideToggle();
   });
   
   var $content71 = $(".sunday1").hide();
   $(".toggle71").on("click", function(e){
    $(this).toggleClass("expanded");
    $content71.slideToggle();
   });
   
   
   
   var $content81 = $(".monday2").hide();
   $(".toggle81").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content81.slideToggle();
   });
   var $content82 = $(".tuesday2").hide();
   $(".toggle82").on("click", function(e){
    $(this).toggleClass("expanded");
    $content82.slideToggle();
   });
   
   var $content83 = $(".wednesday2").hide();
   $(".toggle83").on("click", function(e){
    $(this).toggleClass("expanded");
    $content83.slideToggle();
   });
   
   var $content84 = $(".thursday2").hide();
   $(".toggle84").on("click", function(e){
    $(this).toggleClass("expanded");
    $content84.slideToggle();
   });
   
   var $content85 = $(".friday2").hide();
   $(".toggle85").on("click", function(e){
    $(this).toggleClass("expanded");
    $content85.slideToggle();
   });
   
   var $content86 = $(".saturday2").hide();
   $(".toggle86").on("click", function(e){
    $(this).toggleClass("expanded");
    $content86.slideToggle();
   });
   
   var $content87 = $(".sunday2").hide();
   $(".toggle87").on("click", function(e){
    $(this).toggleClass("expanded");
    $content87.slideToggle();
   });
   
   
   
   var $content91 = $(".monday3").hide();
   $(".toggle91").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content91.slideToggle();
   });
   var $content92 = $(".tuesday3").hide();
   $(".toggle92").on("click", function(e){
    $(this).toggleClass("expanded");
    $content92.slideToggle();
   });
   
   var $content93 = $(".wednesday3").hide();
   $(".toggle93").on("click", function(e){
    $(this).toggleClass("expanded");
    $content93.slideToggle();
   });
   
   var $content94 = $(".thursday3").hide();
   $(".toggle94").on("click", function(e){
    $(this).toggleClass("expanded");
    $content94.slideToggle();
   });
   
   var $content95 = $(".friday3").hide();
   $(".toggle95").on("click", function(e){
    $(this).toggleClass("expanded");
    $content95.slideToggle();
   });
   
   var $content96 = $(".saturday3").hide();
   $(".toggle96").on("click", function(e){
    $(this).toggleClass("expanded");
    $content96.slideToggle();
   });
   
   var $content97 = $(".sunday3").hide();
   $(".toggle97").on("click", function(e){
    $(this).toggleClass("expanded");
    $content97.slideToggle();
   });
   
   
   var $content911 = $(".monday344").hide();
   $(".toggle911").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content911.slideToggle();
   });
   var $content921 = $(".tuesday344").hide();
   $(".toggle921").on("click", function(e){
    $(this).toggleClass("expanded");
    $content921.slideToggle();
   });
   
   var $content931 = $(".wednesday344").hide();
   $(".toggle931").on("click", function(e){
    $(this).toggleClass("expanded");
    $content931.slideToggle();
   });
   
   var $content941 = $(".thursday344").hide();
   $(".toggle941").on("click", function(e){
    $(this).toggleClass("expanded");
    $content941.slideToggle();
   });
   
   var $content951 = $(".friday344").hide();
   $(".toggle951").on("click", function(e){
    $(this).toggleClass("expanded");
    $content951.slideToggle();
   });
   
   var $content961 = $(".saturday344").hide();
   $(".toggle961").on("click", function(e){
    $(this).toggleClass("expanded");
    $content961.slideToggle();
   });
   
   var $content971 = $(".sunday344").hide();
   $(".toggle971").on("click", function(e){
    $(this).toggleClass("expanded");
    $content971.slideToggle();
   });
   
   
   
   function myFunc_online() 
   {
    var online = $('#online').val();
    // alert(online);
    if(online == '1')
    {
      var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_chat" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="price_for_video"><input required type="hidden" value="0" name="price_for_audio">';
      $("#online_p").html(showData_online_chat_price);  
      $("#online_video_p").html('');
      $("#online_audio_p").html('');
     
    }
    else if(online == '2')
    {
      var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_video" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="price_for_chat"><input required type="hidden" value="0" name="price_for_audio">';
      $("#online_video_p").html(showData_online_video_price);  
      $("#online_p").html('');
      $("#online_audio_p").html('');
    
    }
   
    else if(online == '3')
    {
      var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_audio" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="price_for_chat"><input required type="hidden" value="0" name="price_for_video">';
      $("#online_audio_p").html(showData_online_audio_price);  
      $("#online_p").html('');
      $("#online_video_p").html('');
     
    }
   
   else if(online == '5')
    {
      var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_chat" class="form-control" placeholder="Price"><label>';
      $("#online_p").html(showData_online_chat_price);  
      
      var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_video" class="form-control" placeholder="Price">';
      $("#online_video_p").html(showData_online_video_price);  
       $("#online_audio_p").html('');
   
    }
   
    else if(online == '6')
    {
      var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_chat" class="form-control" placeholder="Price"><label>';
      $("#online_p").html(showData_online_chat_price);  
      
    var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_audio" class="form-control" placeholder="Price">';
      $("#online_audio_p").html(showData_online_audio_price); 
      $("#online_video_p").html('');
   
    }
   
    else if(online == '7')
    {
        var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_video" class="form-control" placeholder="Price">';
      $("#online_video_p").html(showData_online_video_price);  
   
      
    var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_audio" class="form-control" placeholder="Price">';
      $("#online_audio_p").html(showData_online_audio_price); 
       $("#online_p").html(''); 
   
    }
   
   
   
    else if(online == '4')
    {
      var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_chat" class="form-control" placeholder="Price">';
      $("#online_p").html(showData_online_chat_price);  
      
      var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_video" class="form-control" placeholder="Price"><label>';
      $("#online_video_p").html(showData_online_video_price);  
   
      var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="price_for_audio" class="form-control" placeholder="Price"><label>';
      $("#online_audio_p").html(showData_online_audio_price); 
   
   
    }
   
   
    else
    {
      var showData_online = '<input required type="hidden" value="0" name="price_for_chat"><input required type="hidden" value="0" name="price_for_video">';
      var showData_online_video_price = '<input required type="hidden" value="0" name="price_for_video">';
      var showData_online_audio_price = '<input required type="hidden" value="0" name="price_for_audio">';
      $("#online_p").html(showData_online); 
       $("#online_video_p").html(showData_online_video_price);  
       $("#online_audio_p").html(showData_online_audio_price);  
    }
   }
   
   
   // Normal Appointment
   function myFunc_normal() 
   {
    var normal = $('#normal').val();
    if(normal == '1')
    {
      var showData_normal = '<label>Appointment Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="normal_appointment_price" class="form-control" placeholder="Price">';
      $("#normal_appointment").html(showData_normal);  
    }
    else
    {
      var showData_normal = '<input required type="hidden" value="0" name="normal_appointment_price">';
      $("#normal_appointment").html(showData_normal); 
    }
   }
   
   // Normal Appointment
   function myFunc_inhouse() 
   {
    var inhouse = $('#inhouse').val();
    if(inhouse == '1')
    {
      var showData_inhouse = '<label>In House Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="in_house_doctor_price" class="form-control" placeholder="Price">';
      $("#inhouse_p").html(showData_inhouse);  
    }
    else
    {
      var showData_inhouse = '<input required type="hidden" value="0" name="in_house_doctor_price">';
      $("#inhouse_p").html(showData_inhouse); 
    }
   }
   
   
   
</script>
<!-- <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1JSr_xKc5wk_CHxvs9g3Wm3B7WQ55Kxw&callback=initMap">
   </script>
   <script>
    
   var map;
           
           function initMap() {  
                             
               var latitude =  28.70916678358291; // YOUR LATITUDE VALUE
               var longitude = 77.12325467135906; // YOUR LONGITUDE VALUE
               
               var myLatLng = {lat: latitude, lng: longitude};
               
                var myOptions = {
                     zoom: 8,
                     center: myLatLng,
                     mapTypeId: google.maps.MapTypeId.ROADMAP
                 };
                 map = new google.maps.Map(document.getElementById("map"), myOptions);
   
                 var marker = new google.maps.Marker({
                     draggable: true,
                     position: myLatLng,
                     map: map,
                     title: "Your location"
                 });
   
   
                  google.maps.event.addListener(marker, 'dragend', function (event) {
                     document.getElementById("input_lat").value = event.latLng.lat();
                     document.getElementById("input_long").value = event.latLng.lng();
                     infoWindow.open(map, marker);
                 });
   
               google.maps.event.addDomListener(window, "load", initialize());
           }
         
   </script>
    -->
<!--  <script type="text/javascript">
   $(document).ready(function() {
      $('.js-example-basic-multiple').select2();
      $('.js-example-basic-single').select2();
   });
   
   </script> -->
<script>
   // function myHospital(hospital_id)
   // {
   //   $.ajax({ 
   //        url: "<?=base_url('/')?>Doctordetail_ctrl/getSpeciality", 
   //        data: "hospital_id="+hospital_id,
   //        method: "post",
   //        success: function(result){
           
   //          $("#specialityID").html(result);
   //        }
   //      });
   // }
   // This example requires the Places library. Include the libraries=places
   // parameter when you first load the API. For example:
   // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
   
   function initMap() {
   
     var map = new google.maps.Map(document.getElementById('map'), {
       center: {lat: 28.68627, lng: 77.22178},
       zoom: 6
     });
     var card = document.getElementById('pac-card');
     var input = document.getElementById('pac-input');
     var types = document.getElementById('type-selector');
     var strictBounds = document.getElementById('strict-bounds-selector');
   
     map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
   
     var autocomplete = new google.maps.places.Autocomplete(input);
   
     // Bind the map's bounds (viewport) property to the autocomplete object,
     // so that the autocomplete requests use the current map bounds for the
     // bounds option in the request.
     autocomplete.bindTo('bounds', map);
   
     // Set the data fields to return when the user selects a place.
     autocomplete.setFields(
         ['address_components', 'geometry', 'icon', 'name']);
   
     var infowindow = new google.maps.InfoWindow();
     var infowindowContent = document.getElementById('infowindow-content');
     infowindow.setContent(infowindowContent);
     var marker = new google.maps.Marker({
       map: map,
       anchorPoint: new google.maps.Point(0, -29)
     });
   
   
     autocomplete.addListener('place_changed', function() {
       infowindow.close();
       marker.setVisible(false);
       var place = autocomplete.getPlace();
       console.log(place.geometry);
   
       if (!place.geometry) {
         // User entered the name of a Place that was not suggested and
         // pressed the Enter key, or the Place Details request failed.
         window.alert("No details available for input: '" + place.name + "'");
         return;
       }
   
       // If the place has a geometry, then present it on a map.
       if (place.geometry.viewport) {
         map.fitBounds(place.geometry.viewport);
       } else {
         map.setCenter(place.geometry.location);
         map.setZoom(17);  // Why 17? Because it looks good.
       }
       marker.setPosition(place.geometry.location);
       marker.setVisible(true);
       $("#input_lat").val(place.geometry.location.lat());
       $("#input_long").val(place.geometry.location.lng());
   
       var address = '';
       if (place.address_components) {
         address = [
           (place.address_components[0] && place.address_components[0].short_name || ''),
           (place.address_components[1] && place.address_components[1].short_name || ''),
           (place.address_components[2] && place.address_components[2].short_name || '')
         ].join(' ');
       }
   
       infowindowContent.children['place-icon'].src = place.icon;
       infowindowContent.children['place-name'].textContent = place.name;
       infowindowContent.children['place-address'].textContent = address;
       infowindow.open(map, marker);
       console.log(address);
     });
   
     // Sets a listener on a radio button to change the filter type on Places
     // Autocomplete.
     function setupClickListener(id, types) {
       var radioButton = document.getElementById(id);
       radioButton.addEventListener('click', function() {
         autocomplete.setTypes(types);
       });
     }
   
     setupClickListener('changetype-all', []);
     setupClickListener('changetype-address', ['address']);
     setupClickListener('changetype-establishment', ['establishment']);
     setupClickListener('changetype-geocode', ['geocode']);
   
     document.getElementById('use-strict-bounds')
         .addEventListener('click', function() {
           console.log('Checkbox clicked! New state=' + this.checked);
           autocomplete.setOptions({strictBounds: this.checked});
         });
   }


$('[data-type="adhaar-number"]').keyup(function() {
  var value = $(this).val();
  value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
  $(this).val(value);
});

$('[data-type="adhaar-number"]').on("change, blur", function() {
  var value = $(this).val();
  var maxLength = $(this).attr("maxLength");
  if (value.length != maxLength) {
    $(this).addClass("highlight-error");
  } else {
    $(this).removeClass("highlight-error");
  }
});

if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      console.log(e.target.files);
      var files = e.target.files,
        filesLength = files.length;
        if (files[0].type == 'image/png' || files[0].type == 'image/jpeg') {
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
              var file = e.target;
              $("<span class=\"pip\">" +
                "<img width=\"100\" height=\"100\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<br/><span class=\"remove\">Remove image</span>" +
                "</span>").insertAfter("#files");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
              
              // Old code here
              /*$("<img></img>", {
                class: "imageThumb",
                src: e.target.result,
                title: file.name + " | Click to remove"
              }).insertAfter("#files").click(function(){$(this).remove();});*/
              
            });
            fileReader.readAsDataURL(f);
          }
        }
        else
        {
          alert('Only png,jpeg and jpg files allowed');
        }
      
    });
  }

function booking_take() 
  {
    var online = $('#is_approval').val();
    // alert(online);
    if(online == '0')
    {
      $('#online_zone').hide(); 
      $('#per_mint').hide();
      
     
    }
    else if(online == '1')
    {
      $('#online_zone').show(); 
      $('#per_mint').hide();
      
     
    }
    else if(online == '2')
    {
      $('#online_zone').hide(); 
      $('#per_mint').show();
      
    
    }
    else if(online == '3')
    {
       $('#online_zone').show(); 
       $('#per_mint').show();
      
    
    }
    else
    {
      $('#online_zone').hide(); 
      $('#per_mint').hide();
    }
  }
</script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
   // CKEDITOR.replace( 'education' );
   // CKEDITOR.replace( 'area_of_expertise' );
   // CKEDITOR.replace( 'biography' );
</script>