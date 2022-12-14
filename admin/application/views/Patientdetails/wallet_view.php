<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        Wallet View
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active">Wallet View</li>
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
            <span><a href="<?php echo base_url()?>User_details/export_wallet/<?php echo $patientID ;?>">
                  <button type="button" class="btn add-new float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button></a>
            </span>
         </ol>
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Wallet View</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="hidden">ID</th>
                           <th>User Name</th>
                           <th>Transactions Name</th> 
                           <th>Booking Id</th>   
                           <th>Payment Mode</th>   
                           <th>Transactions For</th>   
                           <th>Type</th>   
                           <th>Old Wallet</th>   
                           <th>Transaction Amount</th>   
                           <th>Update Wallet</th>   
                           <th>Gst Perct</th>   
                           <th>Gst Amount</th>   
                         
                           <th>Added On</th>   
                          
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                        if(!empty($data))
                        {
                           foreach($data as $patient) {         
                           ?>
                        <tr>
                           <td class="hidden"><?php echo $patient->id; ?></td>
                           <td class="center">
                              <?php 
                                $user_id = $patient->user_id;; 
                                $user = $this->db->where('id',$user_id)->get('user')->row();
                                if ($user) {
                                  echo $user->name;;
                                }
                                ?> 
                           </td>   
                           
                           <td class="center"><?php echo $patient->txn_name; ?></td>
                           <td class="center"><?php echo $patient->booking_txn_id; ?></td>
                           <td class="center"><?php echo $patient->payment_mode; ?></td>
                           <td class="center"><?php echo $patient->txn_for ; ?></td>
                           <td class="center"><?php echo $patient->type; ?></td>
                           <td class="center"><?php echo $patient->old_wallet; ?></td>
                           <td class="center"><?php echo $patient->txn_amount; ?></td>
                           <td class="center"><?php echo $patient->update_wallet; ?></td>
                           <td class="center"><?php echo $patient->gst_perct; ?></td>
                           <td class="center"><?php echo $patient->gst_amount; ?></td>
                        
                              <td class="center"><?php echo date("d M y g:ia",  strtotime($patient->created_at)); ?></td>
                         
                        </tr>
                        <?php
                           }}
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                         <th class="hidden">ID</th>
                         <th>User Name</th>
                           <th>Transactions Name</th> 
                           <th>Booking Id</th>   
                           <th>Payment Mode</th>   
                           <th>Transactions For</th>   
                           <th>Type</th>   
                           <th>Old Wallet</th>   
                           <th>txn Amount</th>   
                           <th>Update Wallet</th>   
                           <th>Gst Perct</th>   
                           <th>Gst Amount</th>   
                         
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