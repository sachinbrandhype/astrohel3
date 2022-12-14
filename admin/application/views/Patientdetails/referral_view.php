<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Referral View
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> Referral View</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
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
         <div class="col-xs-12">

           <ol class="breadcrumb">
            <li>
            <span><a href="<?php echo base_url()?>User_details/export_referral/<?php echo $patientID ;?>">
                  <button type="button" class="btn add-new float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button></a>
            </span>
         </ol>
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Referral View</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="">S.no</th>
                           <th>Refer Code</th>
                           <th>Referral User Name</th> 
                           <th>Lastname</th>   
                           <th>Email</th>   
                           <th>Mobile </th>   
                           <th>Is Done </th>   
                           <th>Added On</th>   
                           
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                        if(!empty($data))
                        {
                          $x=1;
                           foreach($data as $patient) {         
                           ?>
                        <tr>
                           <td class=""><?php echo  $x; ?></td>
                            <td class="center"><?php echo $patient->code; ?></td>
                           <td class="center">
                              <?php 
                                $user_id = $patient->referral_from ; 
                                $user = $this->db->where('id',$user_id)->get('user')->row();
                                if ($user) {
                                  ?>
                                   <a href="<?php echo base_url();?>User_details/patient_view/<?php echo $user->id; ?>" target="_blank"></i>
                                    <?php echo $user->name; ?>
                                  </a>
                                  <?php
                                
                                }
                                ?> 
                           </td>   
                           <td class="center">
                              <?php 
                                $user_id = $patient->referral_from;; 
                                $user = $this->db->where('id',$user_id)->get('user')->row();
                                if ($user) {
                                  echo $user->lastname;;
                                }
                              ?>
                           </td> 
                            <td class="center">
                              <?php 
                                $user_id = $patient->referral_from;; 
                                $user = $this->db->where('id',$user_id)->get('user')->row();
                                if ($user) {
                                  echo $user->email;
                                }
                              ?>
                           </td> 
                           
                            <td class="center">
                              <?php 
                                $user_id = $patient->referral_from;; 
                                $user = $this->db->where('id',$user_id)->get('user')->row();
                                if ($user) {
                                  echo $user->mobile ;
                                }
                              ?>
                           </td>                         
                          
                           <td class="center">
                           <?php 
                              if ($patient->first_order == 0) 
                              {
                                 echo "Not Yet";
                              }
                              else 
                              {
                                 echo "-";
                              }
                           ?></td>
                           <td class="center"><?php echo date("d-m-Y h:i:s A",  strtotime($patient->added_on)); ?></td>
                          
                           
                        </tr>
                        <?php
                           }
                         $x++;
                       }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                          <th class="">S.no</th>
                           <th>Refer Code</th>
                           <th>Referral User Name</th> 
                           <th>Lastname</th>   
                           <th>Email</th>   
                           <th>Mobile </th>   
                           <th>Is Done </th>   
                           <th>Added On</th>  
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>

          <div class="row">
   <div class="col-md-8 col-md-offset-2">
      <!--  <?php echo $links; ?> -->
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <!--   <?php echo $links; ?> -->
            <div class="row">
               <div class="col-md-8 col-md-offset-2">
                  <?php echo $links; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<div class="modal fade modal-wide" id="popup-patientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">View Patient Details</h4>
         </div>
         <div class="modal-patientbody">
         </div>
         <div class="business_info">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>