<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
            Expert Managements Details
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>Home</a></li>
            <li><a href="#">Expert Management</a></li>
            <li class="active">Edit Expert Management</li>
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
                  <h3 class="box-title">Expert Management Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                 <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">
				 <div class="box-body">
				 <div class="col-md-12">
				 
                        
                                    <div class="form-group">
                                    <label class="intrate">name</label>
                                    <input class="form-control required regcom" type="text" name="name" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $result->name ; ?>">
                                    </div>


                                    <div class="form-group">
                                    <label class="intrate">Email</label>
                                    <input class="form-control required regcom" type="text" name="email" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $result->email ; ?>">
                                    </div>



                                    <div class="form-group">
                                    <label class="intrate">Mobile</label>
                                    <input class="form-control required regcom" type="text" name="mobile" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $result->mobile ; ?>">
                                    </div>



                                    <div class="form-group">
                                    <label class="intrate">Password</label>
                                    <input class="form-control required regcom" type="text" name="password" data-parsley-trigger="keyup" required="" id="smtp_username" value="<?php echo $result->password ; ?>">
                                    </div>


                                    <div class="form-group">
                                    <label class="intrate">Experience</label>
                                    <input class="form-control required regcom" type="number" name="experience" data-parsley-trigger="keyup" min="0" step="any" required="" id="smtp_username" value="<?php echo $result->experience ; ?>">
                                    </div>


                         <div id='expertise'>
                        <div class='row'>
                         
                              <?php
                                 $expertise = $result->expertise ;
                                 $str_expertise = rtrim($expertise, ',');
                                        // print_r($str_expertise); die;
                                 $array = explode(',', $str_expertise);
                                      foreach ($array as $key => $value1) {
                                        ?>
                              <div class=form-group>
                                 <label>Expertise</label>
                                 <div class="exer form-group has-feedback">
                                 <input type="text" name="expertise[]" class="form-control" placeholder="Expertise " value="<?=$value1?>">
                              </div>
                                 </div>
                              <?php
                                 }
                                 ?>
                           <br>
                        </div>
                     </div>
                     <?php
                        echo "<span id='add_expertise' class='remove fa fa-plus-circle'></span>"
                        ?>
                         

                                      <div class="form-group has-feedback">
                                         <label for="exampleInputEmail1"> Image</label>
                                         <div class="row">
                                            <div class="col-md-6">
                                               <input type="file" class="form-control" name="image">
                                            </div>
                                            <div class="col-md-6">
                                               <img height="50" width="70" alt="your image" src="<?php echo base_url('/')."uploads/expert/";?><?=$result->image?>" name=""/>
                                               <input type="hidden" name="image11" value="<?php echo $result->image; ?>" class="form-control">
                                            </div>
                                         </div>
                                         <span class="glyphicon  form-control-feedback"></span>
                                      </div>


                                      <div class="form-group">
                                        <label>Bio</label>
                                        <textarea class="form-control" name="bio"><?=$result->bio?></textarea>
                                     </div>



                       <div>
        <div>
      <div class="pac-card" id="pac-card">
      <div id="pac-container" style="width: 411px;">
        <input id="pac-input" type="text" name="location" class="form-control" placeholder="Enter a location" value="<?=$result->location?>">
      </div>
    </div>
  </div>
</div>

<div class="form-group has-feedback" style="height: 330px;">
              <div id="map" style="width: 100%; height: 300px; position: absolute; overflow: initial;  "></div>
              <div id="infowindow-content">
                <img src="" width="16" height="16" id="place-icon">
                <span id="place-name"  class="title"></span><br>
                <span id="place-address"></span>
              </div>
          </div>
                   <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Latitude & Longitude</label><br>
                            <input type="text" class="lat1" name="latitude" id="input_lat" readonly value="<?php echo $result->latitude?>">
                            <input type="text" class="lat1" name="longitude" id="input_long" value="<?php echo $result->longitude?>" readonly>
                            
                        </div>



                                      <?php   
                           @$monday_chat = json_decode($result->online_counsult_time)->mon;
                           @$tuesday_chat = json_decode($result->online_counsult_time)->tue;
                           @$wednesday_chat = json_decode($result->online_counsult_time)->wed;
                           @$thursday_chat = json_decode($result->online_counsult_time)->thu;
                           @$friday_chat = json_decode($result->online_counsult_time)->fri;
                           @$saturday_chat = json_decode($result->online_counsult_time)->sat;
                           @$sunday_chat = json_decode($result->online_counsult_time)->sun;
                                 ?>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Chat Time</label>
                              <div class="box-body no-padding">
                                 <table class="table table-striped">
                                    <tr>
                                       <th>#</th>
                                       <th>Days</th>
                                       <th>Starting Time</th>
                                       <th>Ending Time</th>
                                       <th></th>
                                    </tr>
                                    <tr>
                                       <td>1.</td>
                                       <td>Monday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday_chat[0][start]" class="form-control timepicker monday_chat_start1" value="<?php if(isset($monday_chat[0]->start) && !empty($monday_chat[0]->start)){ echo $monday_chat[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker" >
                                             <div class="form-group <?php if(!(isset($monday_chat[1]->start) && !empty($monday_chat[1]->start))){ ?> monday_chat <?php } ?>"  >
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday_chat[1][start]" class="form-control timepicker monday_chat_end1" value="<?php if(isset($monday_chat[1]->start) && !empty($monday_chat[1]->start)){ echo $monday_chat[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday_chat[0][end]" class="form-control timepicker monday_chat_start2" value="<?php if(isset($monday_chat[0]->end) && !empty($monday_chat[0]->end)){ echo $monday_chat[0]->end; } ?>">
                                                   <div class="input-group-addon" >
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($monday_chat[1]->end) && !empty($monday_chat[1]->end))){ ?> monday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday_chat[1][end]" class="form-control timepicker monday_chat_end2" value="<?php if(isset($monday_chat[1]->end) && !empty($monday_chat[1]->end)){ echo $monday_chat[1]->end; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday_chat[0][start]" class="form-control timepicker dd11" value="<?php if(isset($tuesday_chat[0]->start) && !empty($tuesday_chat[0]->start)){ echo $tuesday_chat[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($tuesday_chat[1]->start) && !empty($tuesday_chat[1]->start))){ ?> tuesday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday_chat[1][start]" class="form-control timepicker dd12" value="<?php if(isset($tuesday_chat[1]->start) && !empty($tuesday_chat[1]->start)){ echo $tuesday_chat[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday_chat[0][end]" class="form-control timepicker dd13" value="<?php if(isset($tuesday_chat[0]->end) && !empty($tuesday_chat[0]->end)){ echo $tuesday_chat[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($tuesday_chat[1]->end) && !empty($tuesday_chat[1]->end))){ ?> tuesday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday_chat[1][end]" class="form-control timepicker dd14" value="<?php if(isset($tuesday_chat[1]->end) && !empty($tuesday_chat[1]->end)){ echo $tuesday_chat[1]->end; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday_chat[0][start]" class="form-control timepicker dd11" value="<?php if(isset($wednesday_chat[0]->start) && !empty($wednesday_chat[0]->start)){ echo $wednesday_chat[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($wednesday_chat[1]->start) && !empty($wednesday_chat[1]->start))){ ?> wednesday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday_chat[1][start]" class="form-control timepicker dd12" value="<?php if(isset($wednesday_chat[1]->start) && !empty($wednesday_chat[1]->start)){ echo $wednesday_chat[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday_chat[0][end]" class="form-control timepicker dd13" value="<?php if(isset($wednesday_chat[0]->end) && !empty($wednesday_chat[0]->end)){ echo $wednesday_chat[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($wednesday_chat[1]->end) && !empty($wednesday_chat[1]->end))){ ?> wednesday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday_chat[1][end]" class="form-control timepicker dd14" value="<?php if(isset($wednesday_chat[1]->end) && !empty($wednesday_chat[1]->end)){ echo $wednesday_chat[1]->end; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday_chat[0][start]" class="form-control timepicker dd11" value="<?php if(isset($thursday_chat[0]->start) && !empty($thursday_chat[0]->start)){ echo $thursday_chat[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($thursday_chat[1]->start) && !empty($thursday_chat[1]->start))){ ?> thursday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday_chat[1][start]" class="form-control timepicker dd12" value="<?php if(isset($thursday_chat[1]->start) && !empty($thursday_chat[1]->start)){ echo $thursday_chat[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday_chat[0][end]" class="form-control timepicker dd13" value="<?php if(isset($thursday_chat[0]->end) && !empty($thursday_chat[0]->end)){ echo $thursday_chat[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($thursday_chat[1]->end) && !empty($thursday_chat[1]->end))){ ?> thursday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday_chat[1][end]" class="form-control timepicker dd14" value="<?php if(isset($thursday_chat[1]->end) && !empty($thursday_chat[1]->end)){ echo $thursday_chat[1]->end; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday_chat[0][start]" class="form-control timepicker dd11" value="<?php if(isset($friday_chat[0]->start) && !empty($friday_chat[0]->start)){ echo $friday_chat[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($friday_chat[1]->start) && !empty($friday_chat[1]->start))){ ?> friday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday_chat[1][start]" class="form-control timepicker dd12" value="<?php if(isset($friday_chat[1]->start) && !empty($friday_chat[1]->start)){ echo $friday_chat[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday_chat[0][end]" class="form-control timepicker dd13" value="<?php if(isset($friday_chat[0]->end) && !empty($friday_chat[0]->end)){ echo $friday_chat[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($friday_chat[1]->end) && !empty($friday_chat[1]->end))){ ?> friday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday_chat[1][end]" class="form-control timepicker dd14" value="<?php if(isset($friday_chat[1]->end) && !empty($friday_chat[1]->end)){ echo $friday_chat[1]->end; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday_chat[0][start]" class="form-control timepicker dd11" value="<?php if(isset($saturday_chat[0]->start) && !empty($saturday_chat[0]->start)){ echo $saturday_chat[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($saturday_chat[1]->start) && !empty($saturday_chat[1]->start))){ ?> saturday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday_chat[1][start]" class="form-control timepicker dd12" value="<?php if(isset($saturday_chat[1]->start) && !empty($saturday_chat[1]->start)){ echo $saturday_chat[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday_chat[0][end]" class="form-control timepicker dd13" value="<?php if(isset($saturday_chat[0]->end) && !empty($saturday_chat[0]->end)){ echo $saturday_chat[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($saturday_chat[1]->end) && !empty($saturday_chat[1]->end))){ ?> saturday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday_chat[1][end]" class="form-control timepicker dd14" value="<?php if(isset($saturday_chat[1]->end) && !empty($saturday_chat[1]->end)){ echo $saturday_chat[1]->end; } ?>">
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
                                                   <input type="text"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]"  name="sunday_chat[0][start]" class="form-control timepicker dd11" value="<?php if(isset($sunday_chat[0]->start) && !empty($sunday_chat[0]->start)){ echo $sunday_chat[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($sunday_chat[1]->start) && !empty($sunday_chat[1]->start))){ ?> sunday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="sunday_chat[1][start]" class="form-control timepicker dd12" value="<?php if(isset($sunday_chat[1]->start) && !empty($sunday_chat[1]->start)){ echo $sunday_chat[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="sunday_chat[0][end]" class="form-control timepicker dd13" value="<?php if(isset($sunday_chat[0]->end) && !empty($sunday_chat[0]->end)){ echo $sunday_chat[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($sunday_chat[1]->end) && !empty($sunday_chat[1]->end))){ ?> sunday_chat <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="sunday_chat[1][end]" class="form-control timepicker dd14" value="<?php if(isset($sunday_chat[1]->end) && !empty($sunday_chat[1]->end)){ echo $sunday_chat[1]->end; } ?>">
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

	  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){


        $(":checkbox").on("click", function(){
          if ($('input.checkbox_check').is(':checked')) 
          {
            console.log("1");

             var monday_chat_start1 = $('.monday_chat_start1').val();
             var monday_chat_start2 = $('.monday_chat_start2').val();
             var monday_chat_end1 = $('.monday_chat_end1').val();
             var monday_chat_end2 = $('.monday_chat_end2').val();
              // alert(monday_chat_start1);
              // alert(monday_chat_start2);
              // alert(monday_chat_end1);
              // alert(monday_chat_end2);
                
             var $content92 = $(".tuesday_chat").hide();
             var $content93 = $(".wednesday_chat").hide();
             var $content94 = $(".thursday_chat").hide();
             var $content95 = $(".friday_chat").hide();
             var $content96 = $(".saturday_chat").hide();
             var $content97 = $(".sunday_chat").hide();
              if(monday_chat_start1 != '' && monday_chat_start2 != '')
              {
                $('.dd11').val(monday_chat_start1);
                $('.dd13').val(monday_chat_start2);
                
                if (monday_chat_end1 != '' && monday_chat_end2 != '') 
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
             console.log("2");

             var video_start1 = $('.video_start1').val();
             var video_start2 = $('.video_start2').val();
             var video_end1 = $('.video_end1').val();
             var video_end2 = $('.video_end2').val();
              // alert(video_start1);
              // alert(video_start2);
              // alert(video_end1);
              // alert(video_end2);
                
             var $content82 = $(".tuesday_video").hide();
             var $content83 = $(".wednesday_video").hide();
             var $content84 = $(".thursday_video").hide();
             var $content85 = $(".friday_video").hide();
             var $content86 = $(".saturday_video").hide();
             var $content87 = $(".sunday_video").hide();
              if(video_start1 != '' && video_start2 != '')
              {
                $('.v11').val(video_start1);
                $('.v13').val(video_start2);
                
                if (video_end1 != '' && video_end2 != '') 
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

            console.log("3");
             var clinic_start1 = $('.clinic_start1').val();
             var clinic_start2 = $('.clinic_start2').val();
             var clinic_end1 = $('.clinic_end1').val();
             var clinic_end2 = $('.clinic_end2').val();
              // alert(clinic_start1);
              // alert(clinic_start2);
              // alert(clinic_end1);
              // alert(clinic_end2);
                
             var $content21 = $(".tuesday").hide();
             var $content31 = $(".wednesday").hide();
             var $content41 = $(".thursday").hide();
             var $content51 = $(".friday").hide();
             var $content61 = $(".saturday").hide();
             var $content71 = $(".sunday").hide();
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
     var services123 = $('#colorselector').val();
      if (services123 == '0') 
    {
      $("#divid").hide();
    }
    $('#colorselector').change(function(){
      if ( this.value == '1')
      {
        $("#divid").show();
      }
      
      else
      {
        $("#services123").select2("val", "");
        $("#divid").hide();
      }
    });
});
</script>

<script type="text/javascript">


  var $content1 = $(".monday").hide();
  $(".toggle111").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content1.slideToggle();
  });
  var $content2 = $(".tuesday").hide();
  $(".toggle10").on("click", function(e){
    $(this).toggleClass("expanded");
    $content2.slideToggle();
  });

  var $content3 = $(".wednesday").hide();
  $(".toggle20").on("click", function(e){
    $(this).toggleClass("expanded");
    $content3.slideToggle();
  });

  var $content4 = $(".thursday").hide();
  $(".toggle30").on("click", function(e){
    $(this).toggleClass("expanded");
    $content4.slideToggle();
  });

  var $content5 = $(".friday").hide();
  $(".toggle40").on("click", function(e){
    $(this).toggleClass("expanded");
    $content5.slideToggle();
  });

  var $content6 = $(".saturday").hide();
  $(".toggle50").on("click", function(e){
    $(this).toggleClass("expanded");
    $content6.slideToggle();
  });

  var $content7 = $(".sunday").hide();
  $(".toggle60").on("click", function(e){
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

  var $content4 = $(".thursday1").hide();
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



  var $content81 = $(".monday_video").hide();
  $(".toggle81").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content81.slideToggle();
  });
   var $content82 = $(".tuesday_video").hide();
  $(".toggle82").on("click", function(e){
    $(this).toggleClass("expanded");
    $content82.slideToggle();
  });

  var $content83 = $(".wednesday_video").hide();
  $(".toggle83").on("click", function(e){
    $(this).toggleClass("expanded");
    $content83.slideToggle();
  });

  var $content84 = $(".thursday_video").hide();
  $(".toggle84").on("click", function(e){
    $(this).toggleClass("expanded");
    $content84.slideToggle();
  });

  var $content85 = $(".friday_video").hide();
  $(".toggle85").on("click", function(e){
    $(this).toggleClass("expanded");
    $content85.slideToggle();
  });

  var $content86 = $(".saturday_video").hide();
  $(".toggle86").on("click", function(e){
    $(this).toggleClass("expanded");
    $content86.slideToggle();
  });

  var $content87 = $(".sunday_video").hide();
  $(".toggle87").on("click", function(e){
    $(this).toggleClass("expanded");
    $content87.slideToggle();
  });



  var $content91 = $(".monday_chat").hide();
  $(".toggle91").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content91.slideToggle();
  });
   var $content92 = $(".tuesday_chat").hide();
  $(".toggle92").on("click", function(e){
    $(this).toggleClass("expanded");
    $content92.slideToggle();
  });

  var $content93 = $(".wednesday_chat").hide();
  $(".toggle93").on("click", function(e){
    $(this).toggleClass("expanded");
    $content93.slideToggle();
  });

  var $content94 = $(".thursday_chat").hide();
  $(".toggle94").on("click", function(e){
    $(this).toggleClass("expanded");
    $content94.slideToggle();
  });

  var $content95 = $(".friday_chat").hide();
  $(".toggle95").on("click", function(e){
    $(this).toggleClass("expanded");
    $content95.slideToggle();
  });

  var $content96 = $(".saturday_chat").hide();
  $(".toggle96").on("click", function(e){
    $(this).toggleClass("expanded");
    $content96.slideToggle();
  });

  var $content97 = $(".sunday_chat").hide();
  $(".toggle97").on("click", function(e){
    $(this).toggleClass("expanded");
    $content97.slideToggle();
  });


   var $content911 = $(".monday_audio").hide();
  $(".toggle911").on("click", function(e){
    // alert('sadasd');
    $(this).toggleClass("expanded");
    $content911.slideToggle();
  });
   var $content921 = $(".tuesday_audio").hide();
  $(".toggle921").on("click", function(e){
    $(this).toggleClass("expanded");
    $content921.slideToggle();
  });

  var $content931 = $(".wednesday_audio").hide();
  $(".toggle931").on("click", function(e){
    $(this).toggleClass("expanded");
    $content931.slideToggle();
  });

  var $content941 = $(".thursday_audio").hide();
  $(".toggle941").on("click", function(e){
    $(this).toggleClass("expanded");
    $content941.slideToggle();
  });

  var $content951 = $(".friday_audio").hide();
  $(".toggle951").on("click", function(e){
    $(this).toggleClass("expanded");
    $content951.slideToggle();
  });

  var $content961 = $(".saturday_audio").hide();
  $(".toggle961").on("click", function(e){
    $(this).toggleClass("expanded");
    $content961.slideToggle();
  });

  var $content971 = $(".sunday_audio").hide();
  $(".toggle971").on("click", function(e){
    $(this).toggleClass("expanded");
    $content971.slideToggle();
  });


  </script>



<script>
   function myHospital(hospital_id)
   {
    $.ajax({ 
         url: "<?=base_url('/')?>Doctordetail_ctrl/getSpeciality", 
         data: "hospital_id="+hospital_id,
         method: "post",
         success: function(result){
           $("#specialityID").html(result);
         }
       });
   }

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
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCJVEWTfTM7V9n5Qn2csaCyi7dvZopdKU&libraries=places&callback=initMap"
   async defer></script>
   
</script>
<!-- <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'bio' );

</script> -->

