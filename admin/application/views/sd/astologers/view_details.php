
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        Astrologer Details
         <small></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo $_SERVER['HTTP_REFERER'];?>">Astrologer List</a></li>
         <li class="active">Astrologer Details</li>
      </ol>
   </section>
   <section class="invoice">
      <!-- title row -->
      <div class="row">
         <div class="col-xs-12">
            <h1 class="page-header" style="font-weight: bold;">
               <i class="fa fa-user"></i>
               <?=$data->name?>
               <small class="pull-right"></small>
            </h1>
         </div>
         <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
         <div class="col-sm-5 invoice-col">
            <?php //print_r($data);die; ?>
            <strong>Name </strong><br>
            <?=$data->name?><br><br>  
            <strong>Contact Number </strong><br>
            <?=$data->phone?><br><br>
            <strong>Email </strong><br>
            <?=$data->email?><br><br>
            <strong>Experience </strong><br>
            <?=$data->experience?><br><br>
            <strong>Address </strong><br>
            <?=$data->location?><br><br>
            <strong>Languages</strong><br>
            <?php 
               $spec = $data->languages;?>
            <p>
            <ul>
               <li>
                  <?php  echo str_replace('|', '</li><li>', $spec);?>
               </li>
            </ul>
            </p> 
            <br><br> 
            <strong>Speciality</strong><br>
            <?php 

             $user_id = $data->id;
              $service_d = $this->db->query("select * from skills where user_id = $user_id  AND type = 2")->result(); 
              // print_r( $service_d); die;
              foreach ($service_d as $key11) 
              {
                   $s_id = $key11->speciality_id;
                   $speciality_id = $this->db->query("select * from master_specialization where id = $s_id  AND type = 2 AND status = 1 ")->row(); 
                 ?> 
            <p>
            <ul>
               <li>
                <?php
                  echo $speciality_id->name ."<br>";
            
                ?>
               </li>
            </ul>
            </p> 
            <?php
             }
            ?>
            <br><br> 
            <strong>Service</strong><br>
            <?php 

             $user_id = $data->id;
              $service_d = $this->db->query("select * from skills where user_id = $user_id  AND type = 1")->result(); 
              // print_r( $service_d); die;
              foreach ($service_d as $key11) 
              {
                   $s_id = $key11->speciality_id;
                   $speciality_id = $this->db->query("select * from master_specialization where id = $s_id  AND type = 1 AND status = 1 ")->row(); 
                 ?> 
            <p>
            <ul>
               <li>
                <?php
                  echo $speciality_id->name ."<br>";
            
                ?>
               </li>
            </ul>
            </p> 
            <?php
             }
            ?>
            <br><br> 
           <!--  <strong>Booking Type </strong><br>
            <?php if ($data->is_approval == 0): ?>
                None
            <?php elseif ($data->is_approval == 1): ?>
              Can take Schedule Booking's
            <?php elseif ($data->is_approval == 2): ?>
              Can take Live booking's
            <?php elseif ($data->is_approval == 3): ?>
              Both types of Booking's
            <?php else: ?>
              none
            <?php endif ?>
            <br><br> -->
            <strong>Online Consult </strong><br>
            <?php if ($data->online_consult == 0): ?>
                None
            <?php elseif ($data->online_consult == 1): ?>
              Chat Booking's<br>
              <strong>Chat Booking's Price</strong>: INR <?=$data->price_for_chat?><br><br>
            <?php elseif ($data->online_consult == 2): ?>
              Video Booking's<br>
              <strong>Video Booking's Price</strong>: INR <?=$data->price_for_video?><br><br>
            <?php elseif ($data->online_consult == 3): ?>
              Audio Booking's<br>
              <strong>Audo Booking's Price</strong>: INR <?=$data->price_for_audio?><br><br>
            <?php elseif ($data->online_consult == 4): ?>
              Chat, Video and Audio Booking's<br>
              <strong>Chat Booking's Price</strong>: INR <?=$data->price_per_mint_chat?><br><br>
              <strong>Video Booking's Price</strong>: INR <?=$data->price_per_mint_video?><br><br>
              <strong>Audio Booking's Price</strong>: INR <?=$data->price_per_mint_audio?><br><br>
            <?php elseif ($data->online_consult == 5): ?>
              Chat and Video Booking's<br>
              <strong>Chat Booking's Price</strong>: INR <?=$data->price_for_chat?><br><br>
              <strong>video Booking's Price</strong>: INR <?=$data->price_for_video?><br><br>
              
            <?php elseif ($data->online_consult == 6): ?>
              Chat and Audio Booking's<br>
              <strong>Chat Booking's Price</strong>: INR <?=$data->price_for_chat?><br><br>
              <strong>Audio Booking's Price</strong>: INR <?=$data->price_for_audio?><br><br>
            <?php elseif ($data->online_consult == 7): ?>
              Video and Audio Booking's<br>
              <strong>Video Booking's Price</strong>: INR <?=$data->price_for_video?><br><br>
              <strong>Audio Booking's Price</strong>: INR <?=$data->price_for_audio?><br><br> 
            <?php else: ?>
              none
            <?php endif ?>


            <strong>Can Take Broadcast </strong><br>
              <?php
                if ($data->can_take_broadcast == 1) {
                  echo "Yes";
                }
                else{
                  echo "No";
                }
              ?>
            <br><br> 

 <strong>In Broadcast Price</strong><br>
            <strong>Price</strong>: INR <?=$data->price_per_mint_broadcast?><br><br> 



            <strong>Can Take Horoscope </strong><br>
              <?php
                if ($data->can_take_horoscope == 1) {
                  echo "Yes";
                }
                else{
                  echo "No";
                }
              ?>
            <br><br> 

 <strong>In Broadcast Price</strong><br>
            <strong>Price</strong>: INR <?=$data->horoscope_price?><br><br> 




            <strong>Share Percentage </strong><br>
            <?=$data->share_percentage ?>%<br><br> 
         </div>
         <?php  //$council = $this->db->where(array('id'=>$data->registration_council))->get('registration_council')->row();
            ?>
         <!-- /.col -->
         <div class="col-sm-5 invoice-col">
            <strong>Status</strong><br>
            <?php 
               if ($data->status == 1) {
                 echo "Active";
                 }
                 else {
                    echo "Inactive";
                 }
               
               ?><br><br>
           <!--  <strong>Mobile Number</strong><br>
            <?=$data->mobile?><br><br> -->
            <strong>Aadhar Number</strong><br>
            <?=$data->aadhar_number?><br><br>
            <strong>Pan Number</strong><br>
            <?=$data->pan_number?><br><br>
            <strong>Bank Name</strong><br>
            <?=$data->bankName?><br><br>
            <strong>Bank Account Number</strong><br>
            <?=$data->bank_account_no?><br><br>
            <strong>IFSC Code</strong><br>
            <?=$data->ifsc_code?><br><br>

         </div>
         <div class="col-sm-2 invoice-col">
            <strong>Image</strong><br>
            <?php if(!empty($data->image)){ ?>
            <img src="<?php echo base_url('/')."/uploads/astrologers/";?><?=$data->image?>" width="100px" height="100px" alt="Picture Not Found" />
            <?php }
               else{
               ?>
            <img src="<?php echo base_url();?>/uploads/astrologers/default.png" width="100px" height="100px" alt="Picture Not Found" />
            <?php } ?>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row invoice-info">
         <div class="col-sm-12 invoice-col" style="border: 2px solid green">
            <strong>Expertise</strong><br>
            <?= $data->expertise; ?>
            <br><br>
         </div>
      </div>
      <div class="row invoice-info">
         <div class="col-sm-12 invoice-col" style="border: 2px solid green">
            <strong>Bio</strong><br>
            <?= $data->bio; ?>
            <br><br>
         </div>
      </div>
      <div class="row">
        <!--  <div class="col-xs-12 table-responsive">
            <strong>Video Time</strong><br>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>Day</th>
                     <th>Start Time</th>
                     <th>End Time</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>Monday</td>
                     <td><?php  @$monday = json_decode($data->online_counsult_time)->mon;
                        if ($monday) 
                        {
                          foreach ($monday as $mndy) {
                            echo $mndy->start."<br>";
                          }
                        }
                          ?></td>
                     <td><?php  @$monday = json_decode($data->online_counsult_time)->mon;
                        if ($monday) 
                        {
                          foreach ($monday as $mndy) {
                            echo $mndy->end."<br>";
                          }
                        }
                          ?></td>
                  </tr>
                  <tr>
                     <td>Tuesday</td>
                     <td><?php  @$tuesday = json_decode($data->online_counsult_time)->tue;
                        if ($tuesday) 
                        {
                          foreach ($tuesday as $tues) {
                            echo $tues->start."<br>";
                          }
                        }
                          ?></td>
                     <td><?php  @$tuesday = json_decode($data->online_counsult_time)->tue;
                        if ($tuesday) 
                        {
                          foreach ($tuesday as $tues) {
                            echo $tues->end."<br>";
                          }
                        }
                          ?></td>
                  </tr>
                  <tr>
                     <td>Wednesday</td>
                     <td><?php  @$wednesday = json_decode($data->online_counsult_time)->wed;
                        if ($wednesday) 
                        {
                          foreach ($wednesday as $wedn) {
                            echo $wedn->start."<br>";
                          }
                        }
                          ?></td>
                     <td><?php  @$wednesday = json_decode($data->online_counsult_time)->wed;
                        if ($wednesday) 
                        {
                          foreach ($wednesday as $wedn) {
                            echo $wedn->end."<br>";
                          }
                        }
                          ?></td>
                  </tr>
                  <tr>
                     <td>Thursday</td>
                     <td><?php  @$thursday = json_decode($data->online_counsult_time)->thu;
                        if ($thursday) 
                        {
                          foreach ($thursday as $thurs) {
                            echo $thurs->start."<br>";
                          }
                        }
                          ?></td>
                     <td><?php  @$thursday = json_decode($data->online_counsult_time)->thu;
                        if ($thursday) 
                        {
                          foreach ($thursday as $thurs) {
                            echo $thurs->end."<br>";
                          }
                        }
                          ?></td>
                  </tr>
                  <tr>
                     <td>Friday</td>
                     <td><?php  @$friday = json_decode($data->online_counsult_time)->fri;
                        if ($friday) 
                        {
                          foreach ($friday as $fridy) {
                            echo $fridy->start."<br>";
                          }
                        }
                          ?></td>
                     <td><?php  @$friday = json_decode($data->online_counsult_time)->fri;
                        if ($friday) 
                        {
                          foreach ($friday as $fridy) {
                            echo $fridy->end."<br>";
                          }
                        }
                          ?></td>
                  </tr>
                  <tr>
                     <td>Saturday</td>
                     <td><?php  @$saturday = json_decode($data->online_counsult_time)->sat;
                        if ($saturday) 
                        {
                          foreach ($saturday as $satr) {
                            echo $satr->start."<br>";
                          }
                        }
                          ?></td>
                     <td><?php  @$saturday = json_decode($data->online_counsult_time)->sat;
                        if ($saturday) 
                        {
                          foreach ($saturday as $satr) {
                            echo $satr->end."<br>";
                          }
                        }
                          ?></td>
                  </tr>
                  <tr>
                     <td>Sunday</td>
                     <td><?php  @$sunday = json_decode($data->online_counsult_time)->sun;
                        if ($sunday) 
                        {
                          foreach ($sunday as $sundy) {
                            echo $sundy->start."<br>";
                          }
                        }
                          ?></td>
                     <td><?php  @$sunday = json_decode($data->online_counsult_time)->sun;
                        if ($sunday) 
                        {
                          foreach ($sunday as $sundy) {
                            echo $sundy->end."<br>";
                          }
                        }
                          ?></td>
                  </tr>
               </tbody>
            </table>
         </div> -->
         <!--   <div class="col-xs-12 table-responsive">
            <strong>Chat Time</strong><br>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>Day</th>
                     <th>Start Time</th>
                     <th>End Time</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>Monday</td>
                     <td><?php  @$monday = json_decode($data->chat_time)->mon;
               if ($monday) 
               {
                 foreach ($monday as $mndy) {
                   echo $mndy->start."<br>";
                 }
               }
                 ?></td>
                     <td><?php  @$monday = json_decode($data->chat_time)->mon;
               if ($monday) 
               {
                 foreach ($monday as $mndy) {
                   echo $mndy->end."<br>";
                 }
               }
                 ?></td>
                  </tr>
                  <tr>
                     <td>Tuesday</td>
                     <td><?php  @$tuesday = json_decode($data->chat_time)->tue;
               if ($tuesday) 
               {
                 foreach ($tuesday as $tues) {
                   echo $tues->start."<br>";
                 }
               }
                 ?></td>
                     <td><?php  @$tuesday = json_decode($data->chat_time)->tue;
               if ($tuesday) 
               {
                 foreach ($tuesday as $tues) {
                   echo $tues->end."<br>";
                 }
               }
                 ?></td>
                  </tr>
                  <tr>
                     <td>Wednesday</td>
                     <td><?php  @$wednesday = json_decode($data->chat_time)->wed;
               if ($wednesday) 
               {
                 foreach ($wednesday as $wedn) {
                   echo $wedn->start."<br>";
                 }
               }
                 ?></td>
                     <td><?php  @$wednesday = json_decode($data->chat_time)->wed;
               if ($wednesday) 
               {
                 foreach ($wednesday as $wedn) {
                   echo $wedn->end."<br>";
                 }
               }
                 ?></td>
                  </tr>
                  <tr>
                     <td>Thursday</td>
                     <td><?php  @$thursday = json_decode($data->chat_time)->thu;
               if ($thursday) 
               {
                 foreach ($thursday as $thurs) {
                   echo $thurs->start."<br>";
                 }
               }
                 ?></td>
                     <td><?php  @$thursday = json_decode($data->chat_time)->thu;
               if ($thursday) 
               {
                 foreach ($thursday as $thurs) {
                   echo $thurs->end."<br>";
                 }
               }
                 ?></td>
                  </tr>
                  <tr>
                     <td>Friday</td>
                     <td><?php  @$friday = json_decode($data->chat_time)->fri;
               if ($friday) 
               {
                 foreach ($friday as $fridy) {
                   echo $fridy->start."<br>";
                 }
               }
                 ?></td>
                     <td><?php  @$friday = json_decode($data->chat_time)->fri;
               if ($friday) 
               {
                 foreach ($friday as $fridy) {
                   echo $fridy->end."<br>";
                 }
               }
                 ?></td>
                  </tr>
                  <tr>
                     <td>Saturday</td>
                     <td><?php  @$saturday = json_decode($data->chat_time)->sat;
               if ($saturday) 
               {
                 foreach ($saturday as $satr) {
                   echo $satr->start."<br>";
                 }
               }
                 ?></td>
                     <td><?php  @$saturday = json_decode($data->chat_time)->sat;
               if ($saturday) 
               {
                 foreach ($saturday as $satr) {
                   echo $satr->end."<br>";
                 }
               }
                 ?></td>
                  </tr>
                  <tr>
                     <td>Sunday</td>
                     <td><?php  @$sunday = json_decode($data->chat_time)->sun;
               if ($sunday) 
               {
                 foreach ($sunday as $sundy) {
                   echo $sundy->start."<br>";
                 }
               }
                 ?></td>
                     <td><?php  @$sunday = json_decode($data->chat_time)->sun;
               if ($sunday) 
               {
                 foreach ($sunday as $sundy) {
                   echo $sundy->end."<br>";
                 }
               }
                 ?></td>
                  </tr>
               </tbody>
            </table>
            </div> -->
         <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /.row -->
      <!-- this row will not appear when printing -->
   </section>
   <div class="clearfix"></div>
</div>