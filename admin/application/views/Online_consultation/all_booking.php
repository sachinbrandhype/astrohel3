<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <?php  
      $CI =& get_instance();
      ?>
   <section class="content-header">
      <h1>
         <?php $uri = $this->uri->segment(3);
            if ($uri == "all_booking") {
              $status = "All Booking";
            } elseif ($uri == "new_booking") {
              $status = "New Booking";
            } elseif ($uri == "complete_booking") {
              $status = "Complete Booking";
            } elseif ($uri == "cancel_booking") {
              $status = "Cancel Booking";
            }
            else {
              $status = "Cancel Booking";
            }
            
            ?>
         Puja's <?php echo $status; ?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-dashboard"></i>Home</a></li>
         <li class="active">Online Consultation <?php echo $status; ?> </li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <?php
               if ($this->session->flashdata('message')) {
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
         <div class="col-xs-12">
            <ol class="breadcrumb">
               <li>
                  <!-- <a href="<?php echo base_url(); ?>speedhuntson/add_ambulance"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Ambulance</b></button></a>-->
                  <span>
                     <!--  <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success"> -->
                  </span>
                  <form method="get">
                     <div class="col-md-12" style="margin-bottom: 10px;">
                        <span> <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success">
                        </span>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Booking Date To</label>
                           <input type="date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>" class="form-control" name="start_date" id="from">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Booking Date From</label>
                           <input type="date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>" class="form-control" name="end_date" id="to">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Dob</label>
                           <input type="date" value="<?= isset($_GET['dob']) ? $_GET['dob'] : '' ?>" class="form-control" name="dob" id="from">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Name</label>
                           <input type="text" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>" class="form-control" name="name" id="from">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Gender</label>
                           <select name="gender" class="form-control">
                              <option value="">Select Gender</option>
                              <option value="male" <?= isset($_GET['gender']) ? $_GET['gender'] == 'male' ? 'selected' : '' : '' ?>>Male</option>
                              <option value="female" <?= isset($_GET['gender']) ? $_GET['gender'] == 'female' ? 'selected' : '' : '' ?>>Female</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-4" style="margin-top: 25px;">
                        <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Submit">&nbsp;&nbsp;
                        <!--     <input type="submit" name="reset" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Reset"> -->
                     </div>
                     <div class="col-md-4">
                     </div>
                  </form>
            </ol>
            <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <!--     <h3 class="box-title">Online Consultation <?php echo $status; ?> </h3> -->
               </div>
               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table id="" class="table table-bordered table-striped ">
                     <thead>
                        <tr>
                           <th>S.No </th>
                           <th>BookingID </th>
                           <th>Name </th>
                           <th>Puja Name & Location </th>
                           <th>Booking Mode </th>
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           <th>Total Minutes </th>
                           <th>added_on</th>
                           <th>Status</th>
                           <th>Complete </th>
                           <th>Cancel </th>
                           <th>Cancel By</th>
                           <th>Detail</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if ($list) : ?>
                        <?php
                            $x = 1;
                           foreach ($list as $key) : 
                            $img = 0;
                           if ($key->images != '') 
                           {
                              $imga = explode('|', $key->images);
                              if (count($imga) > 0) 
                              {
                                  
                              }
                           }
                           

                            ?>
                        <div class="modal fade" id="other_details_<?=$key->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Other Details : #<?=$key->id?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <?php  
                                       $puja_location = $CI->db->get_where('puja_location_table',['id'=>$key->puja_id])->row();
                                       $puja_details = $CI->db->get_where('puja',['id'=>$puja_location->puja_id])->row();
                                       $location_details = $CI->db->get_where('puja_location',['id'=>$puja_location->location_id])->row();
                                       $get_other_details = $CI->db->get_where('booking_other_details',['booking_id'=>$key->id])->row();
                                       $host_name = '';
                                       $dob = '';
                                       $tob = '';
                                       $pob = '';
                                       $gender = '';
                                       $country = '';
                                       $remarks = '';
                                       $current_address = '';
                                       $mother_name = '';
                                       $father_name = '';
                                       $family_gotra = '';
                                       $spouse_name = '';
                                       $attending_family_name = '';
                                       $members_name = '';
                                       $venue_id = '';
                                       $certificatate_flag = 0;
                                       $certificatate_url = '';
                                       if (count($get_other_details) > 0) 
                                       {
                                           $host_name = $get_other_details->host_name;
                                           $dob = $get_other_details->dob;
                                           $tob = $get_other_details->tob;
                                           $pob = $get_other_details->pob;
                                           $gender = $get_other_details->gender;
                                           $country = $get_other_details->country;
                                           $remarks = $get_other_details->remarks;
                                           $current_address = $get_other_details->current_address;
                                           $mother_name = $get_other_details->mother_name;
                                           $father_name = $get_other_details->father_name;
                                           $family_gotra = $get_other_details->family_gotra;
                                           $spouse_name = $get_other_details->spouse_name;
                                           $attending_family_name = $get_other_details->attending_family_name;
                                           $members_name = $get_other_details->members_name;
                                           $venue_id = $get_other_details->venue_id;
                                           if ($key->status == 1) 
                                           {
                                              if ($get_other_details->complete_booking_invoice != 0 || $get_other_details->complete_booking_invoice != '0') 
                                              {
                                                $certificatate_flag = 1;
                                                $certificatate_url = base_url('uploads/invoices').'/'.$get_other_details->complete_booking_invoice;
                                              }
                                           }
                                           elseif ($key->status == 2 || $key->status == 3 || $key->status == 5) 
                                           {
                                              if ($get_other_details->cancel_invoice != 0 || $get_other_details->cancel_invoice != '0') 
                                              {
                                                $certificatate_flag = 2;
                                                $certificatate_url = base_url('uploads/invoices').'/'.$get_other_details->cancel_invoice;
                                              }
                                           }
                                       }
                                       $puja = $CI->db->get_where('puja',['id'=>$puja_location->puja_id])->row();
                                       
                                       ?>

                                    <dt>Host Name</dt>
                                    <dd><?=$host_name?></dd>
                                    <br/>
                                    <dt>Date of birth</dt>
                                    <dd><?=$dob?></dd>
                                    <br/>
                                    <dt>Time of birth</dt>
                                    <dd><?=$tob?></dd>
                                    <br/>
                                    <dt>Place of birth</dt>
                                    <dd><?=$pob?></dd>
                                    <br/>
                                    <dt>Gender</dt>
                                    <dd><?=$gender?></dd>
                                    <br/>
                                    <dt>Country</dt>
                                    <dd><?=$country?></dd>
                                    <br/>
                                    <dt>Rmarks</dt>
                                    <dd><?=$remarks?></dd>
                                    <br/>
                                    <dt>Current Address</dt>
                                    <dd><?=$current_address?></dd>
                                    <br/>
                                    <dt>Mother Name</dt>
                                    <dd><?=$mother_name?></dd>
                                    <br/>
                                    <dt>Father Name</dt>
                                    <dd><?=$father_name?></dd>
                                    <br/>
                                    <dt>Family Gotra</dt>
                                    <dd><?=$family_gotra?></dd>
                                    <br/>
                                    <dt>Spouse Name</dt>
                                    <dd><?=$spouse_name?></dd>
                                    <br/>
                                    <dt>Attending family name</dt>
                                    <dd><?=$attending_family_name?></dd>
                                    <br/>
                                    <dt>Member Name</dt>
                                    <dd><?=$members_name?></dd>
                                    <br/>
                                    
                                    <?php 
                                       if(!empty($venue_id)){
                                         $venue = $CI->db->get_where('puja_venue_table',['id'=>$other_det->venue_id])->row();
                                         ?>
                                    <dt>Venue</dt>
                                    <dd><?=$venue->venue_name?></dd>
                                    <?php
                                       }
                                       ?>
                                    <br/>
                                    <?php 
                                       if(!empty($key->supervisor_id)){
                                         $supervisor = $CI->db->get_where('supervisor',['id'=>$key->supervisor_id])->row();
                                         ?>
                                    <br/>
                                    <dt>Supervisor</dt>
                                    <dd><?=$supervisor->name?></dd>
                                    <?php
                                       }
                                       ?>
                                    <?php 
                                       if(!empty($key->priest_id)){
                                         $priest = $CI->db->get_where('priest',['id'=>$key->priest_id])->row();
                                         ?>
                                    <br/>
                                    <dt>Priest</dt>
                                    <dd><?=$priest->name?></dd>
                                    <?php
                                       }
                                       ?>
                                    <?php 
                                       if(!empty($key->assign_date)){
                                         ?>
                                    <br/>
                                    <dt>Assign Date</dt>
                                    <dd><?=date('d-M-Y g:i A',strtotime($key->assign_date))?></dd>
                                    <?php
                                       }
                                       ?>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>

                         <div class="modal fade" id="Documents_<?=$key->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Documents Details : #<?=$key->id?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <?php if ($key->images != ''): $imga = explode('|', $key->images);?>
                                    <?php if (count($imga) > 0): ?>
                                      <?php for ($imgi=0; $imgi < count($imga); $imgi++) 
                                      { 
                                        $imgii = $imgi + 1;
                                    ?>
                                    <dt>Document <?=$imgii?></dt>
                                    <dd><a target="_blank" href="<?=base_url('uploads/puja_documents').'/'.$imga[$imgi]?>"><img class="img-responsive pad" src="<?=base_url('uploads/puja_documents').'/'.$imga[$imgi]?>" alt="Photo"></a></dd> 
                                    <?php    
                                      } 
                                    ?>
                                    <?php endif ?>
                                    <?php endif ?>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="modal fade" id="certificatate_<?=$key->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Certificate Details : #<?=$key->id?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <?php if ($certificatate_flag == 1): ?>
                                      <dt>Invoice</dt>
                                      <dd><a target="_blank" href="<?=$certificatate_url?>"><button type="button" class="btn btn-primary btn-xs">Certificate</button></a></dd>
                                    <?php elseif ($certificatate_flag == 2): ?>
                                      <dt>Invoice</dt>
                                      <dd><a target="_blank" href="<?=$certificatate_url?>"><button type="button" class="btn btn-primary btn-xs">Certificate</button></a></dd>
                                    <?php else: ?>
                                    <?php endif ?>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="modal fade" id="other_details_refund<?=$key->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Refund Details : #<?=$key->id?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                  <?php 
                                    echo "Trxn Id - " . $key->refund_trxn_id . "<br>";
                                    echo "Refund Date - " . $key->refund_date . "<br>";
                                    echo "Refund Amount - " . $key->refund_amount . "<br>";
                                  ?>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <tr>
                           <td class="center"><?php echo $x; ?></td>
                           <td class="center"><?="SHAKTIPEETH-".$key->id?> </td>
                           <td class="center"><?= $key->name; ?></td>
                           <td class="center"><?= $puja_details->name; ?> (<?=$location_details->name?>)</td>
                           <td class="center"><?= $key->puja_mode; ?></td>
                           
                           <td class="center"><?php
                              $new_date = date("d-m-Y", strtotime($key->booking_date));
                              echo $new_date;
                              ?></td>
                           <td class="center"><?= $key->booking_time; ?></td>
                           <td class="center"><?= $key->total_minutes; ?></td>
                           <!-- 
                              <td class="center"><?php
                                 $user_id = $key->user_id;
                                 $patient = $this->db->where('id', $user_id)->get('user')->row();
                                 if ($patient) {
                                   echo $patient->name;
                                 }
                                 ?>
                              </td>
                              <td class="center">
                              <?php
                                 $user_id = $key->user_id;
                                 $patient = $this->db->where('id', $user_id)->get('user')->row();
                                 if ($patient) {
                                   echo $patient->phone;
                                 }
                                 ?></td>
                              <td class="center"><?php
                                 $user_id = $key->user_id;
                                 $patient = $this->db->where('id', $user_id)->get('user')->row();
                                 if ($patient) {
                                   echo $patient->email;
                                 }
                                 ?></td>
                              
                               <td class="center"><?php
                                 $member_id = $key->member_id;
                                 $member = $this->db->where('id', $member_id)->get('user_member')->row();
                                 if ($member) {
                                   echo $member->member_name;
                                 }
                                 ?>
                              </td>
                              
                              <td class="center"><?php
                                 $member_id = $key->member_id;
                                 $member = $this->db->where('id', $member_id)->get('user_member')->row();
                                 if ($member) {
                                   echo $member->member_gender;
                                 }
                                 ?>
                              </td> -->
                           <td class="center">
                              <?php
                                 $new_dater = date("d-m-Y h:i:s A",  strtotime($key->added_on));
                                 echo $new_dater;
                                 ?>
                           </td>
                           <td><?php
                              if ($key->status == 0 && $key->is_chat_or_video_start == 1) {
                                echo "<span class='badge bg-yellow'>Ongoing</span>";
                              } elseif ($key->status == 0) {
                                echo "<span class='badge bg-primary'>Yet to Start</span>";
                              }
                              elseif ($key->status == 1) {
                                echo "<span class='badge bg-green'>Complete</span>";
                              } elseif ($key->status == 2 || $key->status == 3) {
                                echo "<span class='badge bg-red'>Canceled</span>";
                              }
                              
                              
                              ?>
                           </td>
                           <td>
                              <?php
                                 if ($key->status == 0) {
                                 ?>
                              <a data-toggle="modal" data-target="#modal-complete" data-backdrop="static" data-keyboard="false" onclick="return ReAssigndata('<?php echo $key->id; ?>')" class="btn btn-sm btn-primary">Complete</a>
                              <?php
                                 } else {
                                   echo "--";
                                 }
                                 ?>
                           </td>
                           <td class="center">
                              <?php
                                 // if ($key->status) {
                                 //   # code...
                                 // }
                                 if ($key->status == 0) {
                                 ?>
                              <a class="btn btn-sm btn-danger" onclick="return ReAssign11('<?php echo $key->id; ?>')" data-toggle="modal" data-target="#modal-danger"></i>Cancel</a>
                              <?php
                                 } else {
                                   echo "--";
                                 }
                                 ?>
                           </td>
                           <td class="center"><?php
                              $cancel_by_id = $key->cancel_by_id;
                              $docter = $this->db->where('id', $cancel_by_id)->get('admin')->row();
                              if ($docter) {
                                echo $docter->username;
                              } else {
                                echo "--";
                              }
                              ?></td>
                           <!-- <td>
                              <?php
                                 if ($key->status == 2 || $key->status == 3 || $key->status == 5) {
                                   if ($key->refund_status == 0) {
                                 ?>
                              <a data-toggle="modal" data-target="#modal-info_refund" data-backdrop="static" data-keyboard="false" onclick="return ReAssignrefund('<?php echo $key->id; ?>')" class="btn btn-sm btn-primary">Refund</a>
                              <?php
                                 } else {
                                   echo "Trxn Id - " . $key->refund_trxn_id . "<br>";
                                   echo "Refund Date - " . $key->refund_date . "<br>";
                                   echo "Refund Amount - " . $key->refund_amount . "<br>";
                                 }
                                 }
                                 ?>
                           </td> -->
                           <td>
                              <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#other_details_<?=$key->id?>" >Details</button>
                              <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#Documents_<?=$key->id?>" >Documents Uploaded</button>
                              <button onclick="return ReAssign22('<?php echo $key->id; ?>')" data-toggle="modal" data-target="#modal-default" id="<?= $key->id; ?>" type="button" class="btn btn-primary btn-xs">Trxn Details</button>
                              <?php if ($key->status == 2 || $key->status == 3 || $key->status == 5): ?>
                              <?php if ($key->refund_status == 0): ?>
                                <button data-toggle="modal" data-target="#modal-info_refund" data-backdrop="static" data-keyboard="false" onclick="return ReAssignrefund('<?php echo $key->id; ?>')" type="button" class="btn btn-primary btn-xs">Refund Intiate</button>
                              <?php else: ?>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#other_details_refund<?=$key->id?>" >Refund Details</button>
                              <?php endif ?>
                              <?php endif ?>


                              <?php if ($key->status == 0): ?>
                              <?php if ($key->supervisor_id == 0): ?>
                                <button data-toggle="modal" data-target="#modal-info_as" onclick="return supervisorassign('<?php echo $key->id; ?>')" type="button" class="btn btn-primary btn-xs">Assign Supervisor</button>
                              <?php elseif ($key->supervisor_id != 0 && $key->priest_id == 0): ?>
                                <button data-toggle="modal" data-target="#modal-info_ars" onclick="return resupervisorassign('<?php echo $key->id; ?>')" type="button" class="btn btn-primary btn-xs">Reassign Supervisor</button>
                                <button data-toggle="modal" data-target="#modal-info_ps" onclick="return priestassign('<?php echo $key->id; ?>')" type="button" class="btn btn-primary btn-xs">Assign Priest</button>
                              <?php elseif ($key->supervisor_id != 0 && $key->priest_id != 0): ?>
                                <button data-toggle="modal" data-target="#modal-info_ars" onclick="return resupervisorassign('<?php echo $key->id; ?>')" type="button" class="btn btn-primary btn-xs">Reassign Supervisor</button>
                                <button data-toggle="modal" data-target="#modal-info_prs" onclick="return priestreassign('<?php echo $key->id; ?>')" type="button" class="btn btn-primary btn-xs">Reassign Priest</button>
                              <?php endif ?>
                              <?php endif ?>
                              <?php if ($key->status == 1 || $key->status == 2 || $key->status == 3 || $key->status == 5): ?>
                                <button type="button" class="btn btn-primary btn-xs btn-warning" data-toggle="modal" data-target="#certificatate_<?=$key->id?>" >Certificate</button>
                              <?php endif ?>
                              <!-- <button type="button" class="btn btn-primary btn-xs">Details</button>
                              <button type="button" class="btn btn-primary btn-xs">Details</button>
                              <button type="button" class="btn btn-primary btn-xs">Details</button> -->
                           </td>
                        </tr>
                        <?php
                           $x++;
                           endforeach ?>
                        <?php endif ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>S.No </th>
                           <th>BookingID </th>
                           <th>Name </th>
                           <th>Puja Name & Location </th>
                           <th>Booking Mode </th>
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           <th>Total Minutes </th>
                           <th>added_on</th>
                           <th>Status</th>
                           <th>Complete </th>
                           <th>Cancel </th>
                           <th>Cancel By</th>
                           <th>Detail</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<div class="modal modal-info fade" id="modal-info_refund">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header md-large">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Refund</h4>
         </div>
         <div class="modal-body">
            <form action="<?= base_url('online_consultation/refund_data') ?>" role="form" id="newModalForm" method="POST">
               <p>
                  <input type="hidden" name="booking_id" id="booking_id" class="booking_id">
                  <label> Refund Trxn Id </label>
                  <input type="text" required name="refund_trxn_id" id="refund_trxn_id" class="form-control refund_trxn_id" placeholder="Refund Trxn Id ">
                  <label>Refund Amount </label>
                  <input type="text" required name="refund_amount" id="refund_amount" class="form-control refund_amount" placeholder="Refund Amount">
                  <label>Refund Date </label>
                  <input type="date" required name="refund_date" id="refund_date" class="form-control refund_date" placeholder="refund_date">
               </p>
               <button type="submit" class="btn btn-outline">Save changes</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- assign supervisor -->
<div class="modal modal-info fade" id="modal-info_as">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header md-large">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Assign Supervisor</h4>
         </div>
         <div class="modal-body" style="background: #36a7d0;">
            <form action="<?= base_url('online_consultation/assign_supervisor') ?>" role="form" id="newModalForm" method="POST">
                
                <div class="form-group row">
                  <label for="input-1" class="col-sm-2 col-form-label">Supervisor's</label>
                  <div class="col-sm-10">
                     <input type="hidden" name="booking_id" id="booking_id_sup" class="booking_id">
                      <select class="form-control" name="supervisor_id" id="supervisorlist">
                        
                      </select>
                  </div>
               </div>

              <button type="submit" class="btn btn-outline">Assign</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- Reassign supervisor -->
<div class="modal modal-info fade" id="modal-info_ars">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header md-large">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Re-Assign Supervisor</h4>
         </div>
         <div class="modal-body" style="background: #36a7d0;">
            <form action="<?= base_url('online_consultation/reassign_supervisor') ?>" role="form" id="newModalForm" method="POST">
                
                <div class="form-group row">
                  <label for="input-1" class="col-sm-2 col-form-label">Supervisor's</label>
                  <div class="col-sm-10">
                     <input type="hidden" name="booking_id" id="booking_id_resup" class="booking_id">
                      <select class="form-control" name="supervisor_id" id="resupervisorlist">
                        
                      </select>
                  </div>
               </div>

              <button type="submit" class="btn btn-outline">Assign</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- assign priest -->
<div class="modal modal-info fade" id="modal-info_ps">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header md-large">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Assign Priest</h4>
         </div>
         <div class="modal-body" style="background: #36a7d0;">
            <form action="<?= base_url('online_consultation/assign_priest') ?>" role="form" id="newModalForm" method="POST">
                
                <div class="form-group row">
                  <label for="input-1" class="col-sm-2 col-form-label">Priest's</label>
                  <div class="col-sm-10">
                     <input type="hidden" name="booking_id" id="booking_id_pri" class="booking_id">
                      <select class="form-control" name="priest_id" id="priestlist">
                        
                      </select>
                  </div>
               </div>

              <button type="submit" class="btn btn-outline">Assign</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- Reassign priest -->
<div class="modal modal-info fade" id="modal-info_prs">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header md-large">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Assign Priest</h4>
         </div>
         <div class="modal-body" style="background: #36a7d0;">
            <form action="<?= base_url('online_consultation/reassign_priest') ?>" role="form" id="newModalForm" method="POST">
                
                <div class="form-group row">
                  <label for="input-1" class="col-sm-2 col-form-label">Priest's</label>
                  <div class="col-sm-10">
                     <input type="hidden" name="booking_id" id="booking_id_prirs" class="booking_id">
                      <select class="form-control" name="priest_id" id="priestralist">
                        
                      </select>
                  </div>
               </div>

              <button type="submit" class="btn btn-outline">Assign</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<div class="modal modal-info fade" id="modal-info">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"> Images</h4>
         </div>
         <div class="modal-body ">
            <p>
            <div class="row">
               <div class="col-md-6">
                  <span id="images" class="images"></span>
               </div>
            </div>
            </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <!--  <button type="button" class="btn btn-outline" onclick="myFunction()">Save changes</button> -->
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal modal-info fade" id="modal-complete">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Complete Booking</h4>
         </div>
         <div class="modal-body" style="background-color: green !important;">
            <p> Are you sure complete booking!!<br>
               <input type="hidden" name="booking_ide" id="booking_ide" class="booking_ide">
               <button type="button" class="btn btn-outline " onclick="mycompleteFunction()">Yes</button>
               <button type="button" class="btn btn-outline" data-dismiss="modal">No</button>
            </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal modal-danger fade" id="modal-danger">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Cancel Booking</h4>
         </div>
         <div class="modal-body">
            <p> Are you sure cancel booking!!<br>
               <input type="hidden" name="cancel_id" id="cancel_id" class="cancel_id">
               <button type="button" class="btn btn-outline " onclick="mycancelFunction()">Yes</button>
               <button type="button" class="btn btn-outline" data-dismiss="modal">No</button>
            </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-default">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Transaction details</h4>
         </div>
         <div class="modal-body table-responsive">
            <table id="classTable" class="table table-bordered">
               <thead>
               </thead>
               <tbody>
                  <tr>
                     <td>Total Amount</td>
                     <td> ₹ <span id="total" class="total"></span></td>
                  </tr>
                  <tr>
                     <td>Payment Gateway Amount</td>
                     <td> ₹ <span id="total_amount" class="total_amount"></span></td>
                  </tr>
                  <tr>
                     <td>Discount Amount</td>
                     <td>₹ <span id="discount_amount" class="discount_amount"></span></td>
                  </tr>
                  <!-- 
                     <tr>
                       <td>Wallet Amount</td>
                       <td> ₹ <span id="wallet_amount" class="wallet_amount"></span></td>
                     
                     </tr>
                     
                     <tr>
                       <td>Referral Amount</td>
                       <td>₹ <span id="referral_amount" class="referral_amount"></span></td>
                     
                     </tr>
                     <tr>
                       <td>Tax Amount</td>
                       <td>₹ <span id="tax_amount" class="tax_amount"></span></td>
                     </tr> -->
                  <!-- <tr>
                     <td>Base Amount</td>
                     <td> <span id="base_amount" class="base_amount"></span></td>
                     </tr> -->
                  <tr>
                     <td>Trxn Status</td>
                     <td> <span id="trxn_status" class="trxn_status"></span></td>
                  </tr>
                  <tr>
                     <td>Trxn Mode</td>
                     <td> <span id="trxn_mode" class="trxn_mode"></span></td>
                  </tr>
                  <tr>
                     <td>Trxn Id</td>
                     <td> <span id="trxn_id" class="trxn_id"></span></td>
                  </tr>
                  <!--    <tr>
                     <td>Amount/Percentage</td>
                     <td> <span id="amount" class="amount"></span></td>
                     </tr>
                     -->
                  <tr>
                     <td>Payment Gateway</td>
                     <td> <span id="payment_gateway" class="payment_gateway"></span></td>
                  </tr>
                  <tr>
                     <td>Currency</td>
                     <td> <span id="currency" class="currency"></span></td>
                  </tr>
                  <tr>
                     <td>Payment Status</td>
                     <td> <span id="payment_status" class="payment_status"></span></td>
                  </tr>
                  <tr>
                     <td>Description</td>
                     <td> <span id="description" class="description"></span></td>
                  </tr>
                  <!-- 
                     <tr>
                      <td>Created At</td>
                      <td> <span id="created_at" class="created_at"></span></td>
                     </tr>
                     -->
                  <tr>
                     <td>Method</td>
                     <td> <span id="method" class="method"></span></td>
                  </tr>
                  <tr>
                     <td>Fee</td>
                     <td> <span id="fee" class="fee"></span></td>
                  </tr>
                  <tr>
                     <td>Tax</td>
                     <td> <span id="tax" class="tax"></span></td>
                  </tr>
                  <tr>
                     <td>Payment Method Email</td>
                     <td> <span id="payment_method_email" class="payment_method_email"></span></td>
                  </tr>
                  <tr>
                     <td>Payment Method Contact</td>
                     <td> <span id="payment_method_contact" class="payment_method_contact"></span></td>
                  </tr>
                  <!-- <tr>
                     <td>Discount Type</td>
                     <td> <span id="discount_type" class="discount_type"></span></td>
                     </tr> -->
               </tbody>
            </table>
            <!--   <p id="coupan_code_id" class="coupan_code_id"></p>
               <p id="base_amount" class="base_amount"></p>
               <p id="discount_type" class="discount_type"></p>
               <p id="amount" class="amount"></p> -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <!--                 <button type="button" class="btn btn-primary">Save changes</button>
               -->
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript">
   function ReAssign(id) {
     var id = id;
     //  alert(id);
     $('#booking_id').val(id);
   }
</script>
<script type="text/javascript">
   function ReAssignrefund(id) {
     var id = id;
     //  alert(id);
     $('#booking_id').val(id);
   }
</script>
<script type="text/javascript">
   function ReAssigndata(id) {
     var id = id;
     // alert(id);
     $('#booking_ide').val(id);
   }
</script>
<script type="text/javascript">
   function ReAssign11(id) {
     var id = id;
     //alert(id);
     $('#cancel_id').val(id);
   
   }
</script>
<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
<script>
function supervisorassign(id)
{
  var booking_id  = id;
  $('#booking_id_sup').val(id);
  $.ajax
  ({
      url: "<?=base_url('online_consultation/get_supervisor')?>",
      method: "POST",
      data: {booking_id:booking_id},
      success: function(data)
      {  
         if (data != 0) 
         {
              var json = JSON.parse(data);
              var lengthofObject = json.length;
              var i;
              var showData = [];
              for (i = 0; i < lengthofObject; ++i) {
                var sn = i + 1;
                showData[i] = '<option value="'+json[i].id+'">'+json[i].name+'( '+json[i].email+', '+json[i].mobile+')</option>';
              }
              $( "#supervisorlist" ).html(showData);
         }
         else
         {
           $( "#supervisorlist" ).html();
         } 
      }
  });
}

function resupervisorassign(id)
{
  var booking_id  = id;
  $('#booking_id_resup').val(id);
  $.ajax
  ({
      url: "<?=base_url('online_consultation/get_supervisor')?>",
      method: "POST",
      data: {booking_id:booking_id},
      success: function(data)
      {  
         if (data != 0) 
         {
              var json = JSON.parse(data);
              var lengthofObject = json.length;
              var i;
              var showData = [];
              for (i = 0; i < lengthofObject; ++i) {
                var sn = i + 1;
                showData[i] = '<option value="'+json[i].id+'">'+json[i].name+'( '+json[i].email+', '+json[i].mobile+')</option>';
              }
              $( "#resupervisorlist" ).html(showData);
         }
         else
         {
           $( "#resupervisorlist" ).html();
         } 
      }
  });
}

function priestassign(id)
{
  var booking_id  = id;
  $('#booking_id_pri').val(id);
  $.ajax
  ({
      url: "<?=base_url('online_consultation/get_priest')?>",
      method: "POST",
      data: {booking_id:booking_id},
      success: function(data)
      {  
         if (data != 0) 
         {
              var json = JSON.parse(data);
              var lengthofObject = json.length;
              var i;
              var showData = [];
              for (i = 0; i < lengthofObject; ++i) {
                var sn = i + 1;
                showData[i] = '<option value="'+json[i].id+'">'+json[i].name+'( '+json[i].email+', '+json[i].mobile+')</option>';
              }
              $( "#priestlist" ).html(showData);
         }
         else
         {
           $( "#priestlist" ).html();
         } 
      }
  });
}

function priestreassign(id)
{
  var booking_id  = id;
  $('#booking_id_prirs').val(id);
  $.ajax
  ({
      url: "<?=base_url('online_consultation/get_priest')?>",
      method: "POST",
      data: {booking_id:booking_id},
      success: function(data)
      {  
         if (data != 0) 
         {
              var json = JSON.parse(data);
              var lengthofObject = json.length;
              var i;
              var showData = [];
              for (i = 0; i < lengthofObject; ++i) {
                var sn = i + 1;
                showData[i] = '<option value="'+json[i].id+'">'+json[i].name+'( '+json[i].email+', '+json[i].mobile+')</option>';
              }
              $( "#priestralist" ).html(showData);
         }
         else
         {
           $( "#priestralist" ).html();
         } 
      }
  });
}

</script>
<script>
   function myFunction() {
     var booking_id = $(".booking_id").val();
     var doctor_id = $("#doctor_id").val();
     $.ajax({
       type: "POST",
       url: "<?php echo base_url('doctor_doorstep/assign_docter_booking'); ?>",
       data: {
         booking_id: booking_id,
         doctor_id: doctor_id
       },
       success: function(data) {
         console.log(data);
         // $('#customer_ids').html(data);
         location.reload();
       }
     });
   }
</script>
<script>
   function mycancelFunction() {
     var cancel_id = $(".cancel_id").val();
   
     $.ajax({
       type: "POST",
       url: "<?php echo base_url('Online_consultation/cancel_booking_id'); ?>",
       data: {
         cancel_id: cancel_id
       },
       success: function(data) {
         console.log(data);
         location.reload();
       }
     });
   }
</script>
<script>
   function mycompleteFunction() {
     var booking_ide = $(".booking_ide").val();
   
     $.ajax({
       type: "POST",
       url: "<?php echo base_url('Online_consultation/complete_booking_id'); ?>",
       data: {
         booking_ide: booking_ide
       },
       success: function(data) {
         console.log(data);
         location.reload();
       }
     });
   }
</script>
<script type="text/javascript">
   function ReAssign22(id) {
   
     var transaction_id = id;
     //alert(transaction_id);
     $.ajax({
       url: "<?php echo base_url('speedhuntson/transaction_details'); ?>",
       method: "POST",
       data: {
         transaction_id: transaction_id
       },
       success: function(data) {
   
         var service = JSON.parse(data);
         console.log(service);
   
         var coupan_id = service[0]['coupan_code_id'];
         var discount = service[0]['discount_type'];
         $("#created_at").html(service[0]['created_at']);
   
   
   
         // var created_at = service[0]['created_at'];
   
         // var dateString = created_at.substr(6);
         // var currentTime = new Date(parseInt(dateString ));
         // var month = currentTime.getMonth() + 1;
         // var day = currentTime.getDate();
         // var year = currentTime.getFullYear();
         // var date = day + "/" + month + "/" + year;
   
         // alert(date);
   
         if (coupan_id == 0) {
           var discount_type = '';
           var amount = '';
         } else if (discount == "percentage") {
           var discount_type = service[0]['discount_type'];
           var amount = service[0]['amount'] + "%";
   
         } else if (discount == 'flat') {
           var discount_type = service[0]['discount_type'];
           var amount = service[0]['amount'] + "₹";
   
         }
   
         // $("#base_amount").html(service[0]['base_amount']);
         $("#discount_type").html(discount_type);
         $("#amount").html(amount);
         var total_amount = service[0]['total_amount'];
         var discount_amount = service[0]['discount_amount'];
         var referral_amount = service[0]['referral_amount'];
         var wallet_amount = service[0]['wallet_amount'];
         var total = Number(total_amount) + Number(discount_amount) + Number(referral_amount) + Number(wallet_amount);
         $("#referral_amount").html(service[0]['referral_amount']);
         $("#wallet_amount").html(service[0]['wallet_amount']);
         $("#total").html(total);
   
         //$("#discount_type").append(discount_type);
         // $("#amount").append(amount);
   
         $("#total_amount").html(service[0]['total_amount']);
         $("#discount_amount").html(service[0]['discount_amount']);
         $("#tax_amount").html(service[0]['tax_amount']);
         $("#base_amount").html(service[0]['base_amount']);
         $("#trxn_status").html(service[0]['trxn_status']);
         $("#trxn_mode").html(service[0]['trxn_mode']);
         $("#trxn_id").html(service[0]['trxn_id']);
   
   
         $("#payment_gateway").html(service[0]['payment_gateway']);
         $("#currency").html(service[0]['currency']);
         $("#payment_status").html(service[0]['payment_status']);
         $("#description").html(service[0]['description']);
         $("#method").html(service[0]['method']);
         $("#fee").html(service[0]['fee']);
         $("#tax").html(service[0]['tax']);
         $("#payment_method_email").html(service[0]['payment_method_email']);
         $("#payment_method_contact").html(service[0]['payment_method_contact']);
   
   
       }
     });
   }
</script>

<script type="text/javascript">
   function ReAssign221(id) {
   
     var booking_id = id;
     //alert(booking_id);
     $.ajax({
       url: "<?php echo base_url('online_consultation/image_details'); ?>",
       method: "POST",
       data: {
         booking_id: booking_id
       },
       success: function(data) {
   
         // var service = JSON.parse(data);
         console.log(data);
   
   
   
   
         $("#images").html(data);
   
   
   
       }
     });
   }

</script>