<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
      <?=$page_title?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>pooja/">Lists</a></li>
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
               <button class="close" data-dismiss="alert" type="button">x</button>
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
                  <h3 class="box-title"><?=$page_title?></h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               
               <br>
               

                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default" >
                                Day wise timg</a>

            </div>
            <!-- /.box -->
         </div>
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>


<div class="modal fade bd-example-modal-lg" id="modal-default">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Day wise timg</h4>
              </div>
              <div class="modal-body table-responsive">
              <!--  <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">


                     <div class="col-md-12">
                        <?php   
                           $monday = json_decode($pooja->booking_time)->mon;
                           $tuesday = json_decode($pooja->booking_time)->tue;
                           $wednesday = json_decode($pooja->booking_time)->wed;
                           $thursday = json_decode($pooja->booking_time)->thu;
                           $friday = json_decode($pooja->booking_time)->fri;
                           $saturday = json_decode($pooja->booking_time)->sat;
                           $sunday = json_decode($pooja->booking_time)->sun;
                                
                                 ?>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Booking Time</label>
                              <div class="box-body no-padding">
                                 <table class="table table-striped">
                                    <tr>
                                       <th>#</th>
                                       <th>Days</th>
                                       <th>Starting Time</th>
                                       <th>Ending Time</th>
                                       <th>Stock </th>
                                       <th><input type="checkbox" class="checkbox_check_clinic" name="test_timing" value="1"  ></th>
                                    </tr>
                                    <tr>
                                       <td>1.</td>
                                       <td>Monday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday[0][start]" class="form-control timepicker clinic_start1" value="<?php if(isset($monday[0]->start) && !empty($monday[0]->start)){ echo $monday[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker" >
                                             <div class="form-group <?php if(!(isset($monday[1]->start) && !empty($monday[1]->start))){ ?> monday <?php } ?>"  >
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday[1][start]" class="form-control timepicker clinic_end1" value="<?php if(isset($monday[1]->start) && !empty($monday[1]->start)){ echo $monday[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday[0][end]" class="form-control timepicker clinic_start2" value="<?php if(isset($monday[0]->end) && !empty($monday[0]->end)){ echo $monday[0]->end; } ?>">
                                                   <div class="input-group-addon" >
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($monday[1]->end) && !empty($monday[1]->end))){ ?> monday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="monday[1][end]" class="form-control timepicker clinic_end2" value="<?php if(isset($monday[1]->end) && !empty($monday[1]->end)){ echo $monday[1]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><input type="number" class="form-control" name="stock" value="1"  >
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle"></span></td>
                                    </tr>
                                    <tr>
                                       <td>2.</td>
                                       <td>Tuesday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group ">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday[0][start]" class="form-control timepicker c11" value="<?php if(isset($tuesday[0]->start) && !empty($tuesday[0]->start)){ echo $tuesday[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($tuesday[1]->start) && !empty($tuesday[1]->start))){ ?> tuesday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday[1][start]" class="form-control timepicker c12" value="<?php if(isset($tuesday[1]->start) && !empty($tuesday[1]->start)){ echo $tuesday[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday[0][end]" class="form-control timepicker c13" value="<?php if(isset($tuesday[0]->end) && !empty($tuesday[0]->end)){ echo $tuesday[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($tuesday[1]->end) && !empty($tuesday[1]->end))){ ?> tuesday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="tuesday[1][end]" class="form-control timepicker c14" value="<?php if(isset($tuesday[1]->end) && !empty($tuesday[1]->end)){ echo $tuesday[1]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle1"></span></td>
                                    </tr>
                                    <tr>
                                       <td>3.</td>
                                       <td>Wednesday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday[0][start]" class="form-control timepicker c11" value="<?php if(isset($wednesday[0]->start) && !empty($wednesday[0]->start)){ echo $wednesday[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($wednesday[1]->start) && !empty($wednesday[1]->start))){ ?> wednesday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday[1][start]" class="form-control timepicker c12" value="<?php if(isset($wednesday[1]->start) && !empty($wednesday[1]->start)){ echo $wednesday[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday[0][end]" class="form-control timepicker c13" value="<?php if(isset($wednesday[0]->end) && !empty($wednesday[0]->end)){ echo $wednesday[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($wednesday[1]->end) && !empty($wednesday[1]->end))){ ?> wednesday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="wednesday[1][end]" class="form-control timepicker c14" value="<?php if(isset($wednesday[1]->end) && !empty($wednesday[1]->end)){ echo $wednesday[1]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle2"></span></td>
                                    <tr>
                                       <td>4.</td>
                                       <td>Thursday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday[0][start]" class="form-control timepicker c11" value="<?php if(isset($thursday[0]->start) && !empty($thursday[0]->start)){ echo $thursday[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($thursday[1]->start) && !empty($thursday[1]->start))){ ?> thursday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday[1][start]" class="form-control timepicker c12" value="<?php if(isset($thursday[1]->start) && !empty($thursday[1]->start)){ echo $thursday[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday[0][end]" class="form-control timepicker c13" value="<?php if(isset($thursday[0]->end) && !empty($thursday[0]->end)){ echo $thursday[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($thursday[1]->end) && !empty($thursday[1]->end))){ ?> thursday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="thursday[1][end]" class="form-control timepicker c14" value="<?php if(isset($thursday[1]->end) && !empty($thursday[1]->end)){ echo $thursday[1]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle3"></span></td>
                                    </tr>
                                    <tr>
                                       <td>5.</td>
                                       <td>Friday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday[0][start]" class="form-control timepicker c11" value="<?php if(isset($friday[0]->start) && !empty($friday[0]->start)){ echo $friday[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($friday[1]->start) && !empty($friday[1]->start))){ ?> friday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday[1][start]" class="form-control timepicker c12" value="<?php if(isset($friday[1]->start) && !empty($friday[1]->start)){ echo $friday[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday[0][end]" class="form-control timepicker c13" value="<?php if(isset($friday[0]->end) && !empty($friday[0]->end)){ echo $friday[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($friday[1]->end) && !empty($friday[1]->end))){ ?> friday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="friday[1][end]" class="form-control timepicker c14" value="<?php if(isset($friday[1]->end) && !empty($friday[1]->end)){ echo $friday[1]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle4"></span></td>
                                    </tr>
                                    <tr>
                                       <td>6.</td>
                                       <td>Saturday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday[0][start]" class="form-control timepicker c11" value="<?php if(isset($saturday[0]->start) && !empty($saturday[0]->start)){ echo $saturday[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($saturday[1]->start) && !empty($saturday[1]->start))){ ?> saturday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday[1][start]" class="form-control timepicker c12" value="<?php if(isset($saturday[1]->start) && !empty($saturday[1]->start)){ echo $saturday[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday[0][end]" class="form-control timepicker c13" value="<?php if(isset($saturday[0]->end) && !empty($saturday[0]->end)){ echo $saturday[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($saturday[1]->end) && !empty($saturday[1]->end))){ ?> saturday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="saturday[1][end]" class="form-control timepicker c14" value="<?php if(isset($saturday[1]->end) && !empty($saturday[1]->end)){ echo $saturday[1]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle5"></span></td>
                                    </tr>
                                    <tr>
                                       <td>7.</td>
                                       <td>Sunday</td>
                                       <td>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group">
                                                <div class="input-group">
                                                   <input type="text"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]"  name="sunday[0][start]" class="form-control timepicker c11" value="<?php if(isset($sunday[0]->start) && !empty($sunday[0]->start)){ echo $sunday[0]->start; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($sunday[1]->start) && !empty($sunday[1]->start))){ ?> sunday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text"  pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="sunday[1][start]" class="form-control timepicker c12" value="<?php if(isset($sunday[1]->start) && !empty($sunday[1]->start)){ echo $sunday[1]->start; } ?>">
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
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="sunday[0][end]" class="form-control timepicker c13" value="<?php if(isset($sunday[0]->end) && !empty($sunday[0]->end)){ echo $sunday[0]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="bootstrap-timepicker">
                                             <div class="form-group <?php if(!(isset($sunday[1]->end) && !empty($sunday[1]->end))){ ?> sunday <?php } ?>">
                                                <div class="input-group">
                                                   <input type="text" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9][a-z][a-z]" name="sunday[1][end]" class="form-control timepicker c14" value="<?php if(isset($sunday[1]->end) && !empty($sunday[1]->end)){ echo $sunday[1]->end; } ?>">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-clock-o"></i>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                       <td><span id="monbutton" class="remove fa fa-plus-circle toggle6"></span></td>
                                    </tr>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="box">
                    
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                     </div>
                  </div>
               </form> -->

                <form class="form-horizontal" name="doctor_break_time"  id="doctor_break_time"  method="post" action="">
                          <div class="box-body">
                           <?php $break_time = (!empty($pooja->booking_time)) ? json_decode($pooja->booking_time,true) : array('mon'=>array(array('start'=>'','end'=>'','stock'=>'')),'tue'=>array(array('start'=>'','end'=>'','stock'=>'')),'wed'=>array(array('start'=>'','end'=>'','stock'=>'')),'thu'=>array(array('start'=>'','end'=>'','stock'=>'')),'fri'=>array(array('start'=>'','end'=>'','stock'=>'')),'sat'=>array(array('start'=>'','end'=>'','stock'=>'')),'sun'=>array(array('start'=>'','end'=>'','stock'=>'')));?>
                            <?php foreach ($days as $key => $value) { ?>
                            <?php foreach ($break_time[$days[$key]] as $br_key => $breaktime) { ?>
                               <div class="form-group break_group <?php echo $value;?>">
                                 <label class="col-sm-2 control-label" for="inputEmail3"><?php echo $value;?></label>

                                 <div class="col-sm-3">
                                   <input type="text"  placeholder="Start Time" id="<?php echo $value.'_break_start';?>" <?php echo  (empty($pooja->booking_time)) ? 'disabled' :'';?> value="<?php echo (!empty($pooja->booking_time) && !empty($pooja->booking_time)) ? isset($breaktime['start']) ? $breaktime['start'] :'' : '';?>"  name="break[<?php echo $days[$key];?>][start][]" class="form-control timepicker start <?php echo $days[$key].'_break';?>">
                                 </div>

                                 <div class="col-sm-3">
                                   <input type="text"  placeholder="End Time" id="<?php echo $value.'_break_end';?>" <?php echo  (empty($pooja->booking_time)) ? 'disabled' :'';?> value="<?php echo (!empty($pooja->booking_time) && !empty($pooja->booking_time)) ? isset($breaktime['end']) ? $breaktime['end'] :'' : '';?>" name="break[<?php echo $days[$key];?>][end][]" class="form-control timepicker end <?php echo $days[$key].'_break';?>">
                                 </div>
                                 <div class="col-sm-2">
                                   <input type="number" min="1" placeholder="Stock" id="<?php echo $value.'_break_stock';?>" <?php echo  (empty($pooja->booking_time)) ? 'disabled' :'';?> value="<?php echo (!empty($pooja->booking_time) && !empty($pooja->booking_time)) ? isset($breaktime['stock']) ? $breaktime['stock'] :'' : '';?>" name="break[<?php echo $days[$key];?>][stock][]" class="form-control stock <?php echo $days[$key].'_break';?>">
                                 </div>
                                <!--  <label class="col-sm-1 control-label" for="inputEmail3">
                                    <input type="checkbox" name="<?php echo $value;?>" class="check_break_day">
                                 </label> -->
                                 <label class="col-sm-2 control-label" for="inputEmail3">
                                    <div class="btn-group">
                                     <button class="btn btn-info clone_break" target=".<?php echo $value;?>" title="Add Row" type="button"><i class="fa fa-plus"></i></button>
                                     <button class="btn btn-info remove_break" target=".<?php echo $value;?>" title="Remove Row" type="button"><i class="fa fa-times"></i></button>
                                   </div>
                                 </label>
                               </div>
                            <?php } ?>
                            <?php }?>
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer">
                            <button class="btn btn-info pull-right " type="submit" target="doctor_break_time">Submit</button>
                          </div>
                          <!-- /.box-footer -->
                        </form>
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {

      $(":checkbox").on("click", function() {
         if ($('input.checkbox_check').is(':checked')) {

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
            if (monday_chat_start1 != '' && monday_chat_start2 != '') {
               $('.dd11').val(monday_chat_start1);
               $('.dd13').val(monday_chat_start2);

               if (monday_chat_end1 != '' && monday_chat_end2 != '') {
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
            } else {
               $(".checkbox_check").prop("checked", false);
               alert('Please select time slots')
            }
         } else {

            $('.dd11').val('');
            $('.dd12').val('');
            $('.dd13').val('');
            $('.dd14').val('');
         }

         if ($('input.checkbox_check_video').is(':checked')) {

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
            if (video_start1 != '' && video_start2 != '') {
               $('.v11').val(video_start1);
               $('.v13').val(video_start2);

               if (video_end1 != '' && video_end2 != '') {
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
            } else {
               $(".checkbox_check_video").prop("checked", false);
               alert('Please select time slots')
            }
         } else {

            $('.v11').val('');
            $('.v12').val('');
            $('.v13').val('');
            $('.v14').val('');
         }


         if ($('input.checkbox_check_clinic').is(':checked')) {

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
            if (clinic_start1 != '' && clinic_start2 != '') {
               $('.c11').val(clinic_start1);
               $('.c13').val(clinic_start2);

               if (clinic_end1 != '' && clinic_end2 != '') {
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
            } else {
               $(".checkbox_check_clinic").prop("checked", false);
               alert('Please select time slots')
            }
         } else {

            $('.c11').val('');
            $('.c12').val('');
            $('.c13').val('');
            $('.c14').val('');
         }

      })

      $("#divid").hide();
      $('#colorselector').change(function() {
         if (this.value == '1') {
            $("#divid").show();
         } else {
            $("#services").select2("val", "");
            $("#divid").hide();
         }
      });
   });
</script>
<script type="text/javascript">
   var $content1 = $(".monday").hide();
   $(".toggle").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content1.slideToggle();
   });
   var $content2 = $(".tuesday").hide();
   $(".toggle1").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content2.slideToggle();
   });

   var $content3 = $(".wednesday").hide();
   $(".toggle2").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content3.slideToggle();
   });

   var $content4 = $(".thursday").hide();
   $(".toggle3").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content4.slideToggle();
   });

   var $content5 = $(".friday").hide();
   $(".toggle4").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content5.slideToggle();
   });

   var $content6 = $(".saturday").hide();
   $(".toggle5").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content6.slideToggle();
   });

   var $content7 = $(".sunday").hide();
   $(".toggle6").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content7.slideToggle();
   });



   var $content11 = $(".monday1").hide();
   $(".toggle11").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content11.slideToggle();
   });
   var $content21 = $(".tuesday1").hide();
   $(".toggle21").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content21.slideToggle();
   });

   var $content31 = $(".wednesday1").hide();
   $(".toggle31").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content31.slideToggle();
   });

   var $content41 = $(".thursday1").hide();
   $(".toggle41").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content41.slideToggle();
   });

   var $content51 = $(".friday1").hide();
   $(".toggle51").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content51.slideToggle();
   });

   var $content61 = $(".saturday1").hide();
   $(".toggle61").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content61.slideToggle();
   });

   var $content71 = $(".sunday1").hide();
   $(".toggle71").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content71.slideToggle();
   });



   var $content81 = $(".monday2").hide();
   $(".toggle81").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content81.slideToggle();
   });
   var $content82 = $(".tuesday2").hide();
   $(".toggle82").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content82.slideToggle();
   });

   var $content83 = $(".wednesday2").hide();
   $(".toggle83").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content83.slideToggle();
   });

   var $content84 = $(".thursday2").hide();
   $(".toggle84").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content84.slideToggle();
   });

   var $content85 = $(".friday2").hide();
   $(".toggle85").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content85.slideToggle();
   });

   var $content86 = $(".saturday2").hide();
   $(".toggle86").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content86.slideToggle();
   });

   var $content87 = $(".sunday2").hide();
   $(".toggle87").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content87.slideToggle();
   });



   var $content91 = $(".monday3").hide();
   $(".toggle91").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content91.slideToggle();
   });
   var $content92 = $(".tuesday3").hide();
   $(".toggle92").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content92.slideToggle();
   });

   var $content93 = $(".wednesday3").hide();
   $(".toggle93").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content93.slideToggle();
   });

   var $content94 = $(".thursday3").hide();
   $(".toggle94").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content94.slideToggle();
   });

   var $content95 = $(".friday3").hide();
   $(".toggle95").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content95.slideToggle();
   });

   var $content96 = $(".saturday3").hide();
   $(".toggle96").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content96.slideToggle();
   });

   var $content97 = $(".sunday3").hide();
   $(".toggle97").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content97.slideToggle();
   });


   var $content911 = $(".monday344").hide();
   $(".toggle911").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content911.slideToggle();
   });
   var $content921 = $(".tuesday344").hide();
   $(".toggle921").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content921.slideToggle();
   });

   var $content931 = $(".wednesday344").hide();
   $(".toggle931").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content931.slideToggle();
   });

   var $content941 = $(".thursday344").hide();
   $(".toggle941").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content941.slideToggle();
   });

   var $content951 = $(".friday344").hide();
   $(".toggle951").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content951.slideToggle();
   });

   var $content961 = $(".saturday344").hide();
   $(".toggle961").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content961.slideToggle();
   });

   var $content971 = $(".sunday344").hide();
   $(".toggle971").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content971.slideToggle();
   });


   function myFunc_planned_visit() {
      var planned_visit = $('#planned_visit').val();
      if (planned_visit == '1') {
         var showData_planned_visit = '<label>Planned Visit Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="planned_visit_price" class="form-control" placeholder="Price">';
         $("#planned_visit_price").html(showData_planned_visit);
      } else {
         var showData_planned_visit = '<input required type="hidden" value="0" name="planned_visit_price">';
         $("#planned_visit_price").html(showData_planned_visit);
      }
   }


   function myFunc_emergency_visit() {
      var emergency_visit = $('#emergency_visit').val();
      if (emergency_visit == '1') {
         var showData_emergency_visit = '<label> Emergency Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="emergency_price" class="form-control" placeholder="Price">';
         $("#planned_emergency_visit").html(showData_emergency_visit);
      } else {
         var showData_emergency_visit = '<input required type="hidden" value="0" name="emergency_price">';
         $("#planned_emergency_visit").html(showData_emergency_visit);
      }
   }


   function myFunc_doorstep_services_visit() {
      var medical_services = $('#medical_services').val();
      if (medical_services == '1') {
         var showData_medical_services = '<label>Select Services<span style="color: red;">*</span></label><select class="form-control" name="services[]" placeholder="Select Services" id="services">' + '<?php foreach ($common_service as $serv) { ?> <option value="<?= $serv->id ?>"> <?= $serv->service_name . '-(&#8377; ' . $serv->price . ')' ?> </option><?php } ?></select>';
         $("#doorstep_services").html(showData_medical_services);
      } else {
         var showData_medical_services = '<input required type="hidden" value="" name="services[]">';
         $("#doorstep_services").html(showData_medical_services);
      }
   }


   function myFunc_online() {
      var online = $('#online').val();
      if (online == '1') {
         var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_chat_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_video_price"><input required type="hidden" value="0" name="online_consult_audio_price">';
         $("#online_p").html(showData_online_chat_price);
         $("#online_video_p").html('');
         $("#online_audio_p").html('');
      } else if (online == '2') {
         var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_video_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_audio_price">';
         $("#online_video_p").html(showData_online_video_price);
         $("#online_p").html('');
         $("#online_audio_p").html('');
      } else if (online == '3') {
         var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_audio_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_video_price">';
         $("#online_audio_p").html(showData_online_audio_price);
         $("#online_p").html('');
         $("#online_video_p").html('');
      } else if (online == '4') {
         var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_chat_price" class="form-control" placeholder="Price">';
         $("#online_p").html(showData_online_chat_price);

         var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_video_price" class="form-control" placeholder="Price">';
         $("#online_video_p").html(showData_online_video_price);

         var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_audio_price" class="form-control" placeholder="Price">';
         $("#online_audio_p").html(showData_online_audio_price);

      } else {
         var showData_online = '<input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_video_price">';
         var showData_online_video_price = '<input required type="hidden" value="0" name="online_consult_video_price">';
         var showData_online_audio_price = '<input required type="hidden" value="0" name="online_consult_audio_price">';
         $("#online_p").html(showData_online);
         $("#online_video_p").html(showData_online_video_price);
         $("#online_audio_p").html(showData_online_audio_price);
      }
   }


   // Normal Appointment
   function myFunc_normal() {
      var normal = $('#normal').val();
      if (normal == '1') {
         var showData_normal = '<label>Appointment Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="normal_appointment_price" class="form-control" placeholder="Price">';
         $("#normal_appointment").html(showData_normal);
      } else {
         var showData_normal = '<input required type="hidden" value="0" name="normal_appointment_price">';
         $("#normal_appointment").html(showData_normal);
      }
   }

   // Normal Appointment
   function myFunc_inhouse() {
      var inhouse = $('#inhouse').val();
      if (inhouse == '1') {
         var showData_inhouse = '<label>In House Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="in_house_doctor_price" class="form-control" placeholder="Price">';

         var showData_intop = '<label>In Top<span style="color: red;">*</span></label><select class="form-control" name="in_top" placeholder="in_top" id="in_top" required><option value="1"> Yes  </option><option value="0"> No </option></select>';


         $("#inhouse_p").html(showData_inhouse);
         $("#intop_p").html(showData_intop);
      } else {
         var showData_inhouse = '<input required type="hidden" value="0" name="in_house_doctor_price">';
         var showData_intop = '<input required type="hidden" value="0" name="in_top">';
         $("#inhouse_p").html(showData_inhouse);
         $("#intop_p").html(showData_intop);
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
   //        url: "<?= base_url('/') ?>Doctordetail_ctrl/getSpeciality", 
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
         center: {
            lat: 28.68627,
            lng: 77.22178
         },
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
            map.setZoom(17); // Why 17? Because it looks good.
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
            autocomplete.setOptions({
               strictBounds: this.checked
            });
         });
   }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCJVEWTfTM7V9n5Qn2csaCyi7dvZopdKU&libraries=places&callback=initMap" async defer></script>