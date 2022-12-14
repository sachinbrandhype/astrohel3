<?php 
   function get_astrologer($id){
       $ci =& get_instance();
       $data = $ci->db->get_where('astrologers',['id'=>$id])->row();
       return $data;
   }
   ?>
<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
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
        
            <!-- /.col -->
        </div>
      <h1>
         <?php $uri = $this->uri->segment(3);
            if ($uri == "all_booking") 
            {
            $status = "All Booking";
            } 
            elseif ($uri == "new_booking") 
            {
             $status = "Upcoming Booking";
            }
            elseif ($uri == "complete_booking") 
            {
            $status = "Complete Booking";
            }
            elseif ($uri == "cancel_booking") 
            {
            $status = "Cancel Booking";
            }
            
            ?>
         Astrologer <?php echo $status ; ?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-dashboard"></i>Home</a></li>
         <li class="active">Astrologer <?php echo $status ; ?> </li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <?php 
            if($astrologer_assets){
              ?>
         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
               <div class="inner">
                  <h3><?=$astrologer_assets->total_records ? $astrologer_assets->total_records : 0?><sup style="font-size: 20px"></sup></h3>
                  <p>Total Bookings</p>
               </div>
               <div class="icon">
                  <i class="ion ion-stats-bars"></i>
               </div>
               <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
         </div>
         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
               <div class="inner">
                  <h3><?=$astrologer_assets->total_amount_bookings ? $astrologer_assets->total_amount_bookings : 0?><sup style="font-size: 20px"></sup></h3>
                  <p>Total Bookings Revenue</p>
               </div>
               <div class="icon">
                  <i class="ion ion-stats-bars"></i>
               </div>
            </div>
         </div>

         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
               <div class="inner">

                  <h3><?=(floatval($astrologer_assets->total_amount_bookings) - floatval($astrologer_assets->total_comission_amount) )?><sup style="font-size: 20px"></sup></h3>
                  <p>Admin Earnings</p>
               </div>
               <div class="icon">
                  <i class="ion ion-stats-bars"></i>
               </div>
            </div>
         </div>

         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
               <div class="inner">
                  <h3><?=$astrologer_assets->total_comission_amount ? $astrologer_assets->total_comission_amount : 0 ?><sup style="font-size: 20px"></sup></h3>
                  <p>Astrologer Earnings</p>
               </div>
               <div class="icon">
                  <i class="ion ion-stats-bars"></i>
               </div>
            </div>
         </div>

         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
               <div class="inner">
                  <h3><?=$payouts->total_pending_payouts ? $payouts->total_pending_payouts  : 0?><sup style="font-size: 20px"></sup></h3>
                  <p>Astrologer Pending Payout</p>
               </div>
               <div class="icon">
                  <i class="ion ion-stats-bars"></i>
               </div>
            </div>
         </div>
         <br>
         <?php if(isset($_GET['astrologer_id']) && !empty($_GET['astrologer_id'])) : ?>
         <div class="col-lg-3 col-xs-6">
            <form  method="post">
                <input type="submit" value="Clear Payouts" class="btn btn-primary" onclick="return confirm('Are you sure to clear payouts')" name="clear_payout">
            </form>
         </div>
         <?php endif; ?>
        
         <?php
            }

            ?>
      </div>
      <div class="row">
      <form method="get">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Booking Date To</label>
                           <input type="date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>"  class="form-control" name="start_date" id="from">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Booking Date From</label>
                           <input type="date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>"  class="form-control" name="end_date" id="to">
                        </div>
                     </div>
                     <input type="hidden" name="astrologer_id" value="<?=isset($_GET['astrologer_id']) ?$_GET['astrologer_id']:0 ?>" >

                     <div class="col-md-4" >
                        <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Submit">&nbsp;&nbsp;
                     </div>
                  </form>
      </div>
      
      <!-- /.row -->
   </section>




   
   
<div class="box">
           <div class="box-header">
              <h3 class="box-title">Payouts List </h3>
           </div>


  <div class="box-body table-responsive">
              <table id="" class="table table-bordered table-striped ">
                 <thead>
                    <tr>
                       <th>S.No </th>  
                       <th>Astrologer Name </th>                                        
                       <th>Amount </th>                                        
                       <th>Date </th>                                        
                      <!--  <th>Invoice </th>   -->                                      
                   
                    </tr>
                 </thead> 
                   <tbody>

                      <?php 
                      $x=1;
                      $astrologer_ide =  $_GET['astrologer_id'];
                      $ss = $this->db->query("select * from astrologer_payouts where astrologer_id = $astrologer_ide")->result();

                      foreach ($ss as $key)
                       {
                          ?>
                      <tr>
                        
                     




                          <td class="center"><?php echo $x;?></td>
                         <td class="center"><?php 
                         $astrologer_id = $key->astrologer_id;
                         $qq = $this->db->query("select * from astrologers where id = $astrologer_id ")->row();
                         if ($qq) {
                           echo  $qq->name;
                         }
                          ?></td>
                         <td class="center"><?= $key->amount; ?></td>
                         <td class="center"> <?php 
                            $new_dater = date("d-m-Y h:i:s A",  strtotime($key->created_at));
                            echo $new_dater;
                             ?></td>
                         <!-- <td class="center">invoice</td> -->
                    
                        

                       </tr>       
                      <?php
                      $x++;
                       } ?>
                  
                 </tbody>
                 <tfoot>
                    <tr>
                       <th>S.No </th>  
                       <th>Astrologer Name </th>                                        
                       <th>Amount </th>                                        
                       <th>Date </th>                                        
                       <!-- <th>Invoice </th>    -->

                    </tr>
                 </tfoot>
              </table>
           </div>
           </div>

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
            <form action="<?=base_url('Booking_management/refund_data')?>" role="form" id="newModalForm" method="POST">
               <p>
                  <input type="hidden" name="booking_id" id="booking_id" class="booking_id">
                  <label> Refund Trxn Id </label>
                  <input  type="text" required name="refund_trxn_id" id="refund_trxn_id" class="form-control refund_trxn_id" placeholder="Refund Trxn Id ">
                  <label>Refund Amount </label>
                  <input  type="text" required name="refund_amount" id="refund_amount" class="form-control refund_amount" placeholder="Refund Amount">
                  <label>Refund Date   </label>
                  <input  type="date" required name="refund_date" id="refund_date" class="form-control refund_date" placeholder="refund_date">
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
               <button type="button" class="btn btn-outline " onclick="mycancelFunction()" >Yes</button>
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
                     <td>Booking Txn Id</td>
                     <td> <span id="booking_txn_id" class="booking_txn_id"></span></td>
                  </tr>
                  <tr>
                     <td>Payment Mode</td>
                     <td> <span id="payment_mode" class="payment_mode"></span></td>
                  </tr>
                  <tr>
                     <td>Type</td>
                     <td> <span id="type" class="type"></span></td>
                  </tr>
                  <tr>
                     <td>Old Wallet</td>
                     <td> <span id="old_wallet" class="old_wallet"></span></td>
                  </tr>
                  <tr>
                     <td>Txn Amount</td>
                     <td> <span id="txn_amount" class="txn_amount"></span></td>
                  </tr>
                  <tr>
                     <td>Txn Amount</td>
                     <td><span id="update_wallet" class="update_wallet"></span></td>
                  </tr>
                  <tr>
                     <td>Status</td>
                     <td><span id="status" class="status"></span></td>
                  </tr>
                  <tr>
                     <td>Txn Mode</td>
                     <td><span id="txn_mode" class="txn_mode"></span></td>
                  </tr>
                  <tr>
                     <td>Bank Name</td>
                     <td><span id="bank_name" class="bank_name"></span></td>
                  </tr>
                  <tr>
                     <td>Bank Txn Id</td>
                     <td><span id="bank_txn_id" class="bank_txn_id"></span></td>
                  </tr>
                  <tr>
                     <td>IFSC</td>
                     <td><span id="ifsc" class="ifsc"></span></td>
                  </tr>
                  <tr>
                     <td>Account</td>
                     <td><span id="account" class="account"></span></td>
                  </tr>
                  <tr>
                     <td>Created At</td>
                     <td><span id="created_at" class="created_at"></span></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modal-default_refund">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Refund details</h4>
         </div>
         <div class="modal-body table-responsive">
            <table id="classTable" class="table table-bordered">
               <thead>
               </thead>
               <tbody>
                  <tr>
                     <td>Refund Txn Id</td>
                     <td> <span id="refund_booking_txn_id" class="refund_booking_txn_id"></span></td>
                  </tr>
                  <tr>
                     <td>Amount</td>
                     <td> <span id="refund_txn_amount" class="refund_txn_amount"></span></td>
                  </tr>
                  <tr>
                     <td>Refund Date</td>
                     <td> <span id="refund_created_at" class="refund_created_at"></span></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   
   
   
    
</script>
<script type="text/javascript">
   function ReAssign(id)
   {
     var id = id;
   //  alert(id);
      $('#booking_id').val(id);
   }
</script>
<script type="text/javascript">
   function ReAssignrefund(id)
   {
     var id = id;
   //  alert(id);
      $('#booking_id').val(id);
   }
</script>
<script type="text/javascript">
   function ReAssigndata(id)
   {
     var id = id;
    // alert(id);
      $('#booking_ide').val(id);
   }
</script>
<script type="text/javascript">
   function ReAssign11(id)
   {
     var id = id;
   // alert(id);
   $('#cancel_id').val(id);
     
   }
</script>
<script>
   function myFunction() {
      var booking_id = $(".booking_id").val();
     var doctor_id = $("#doctor_id").val();
       $.ajax({
              type: "POST",
              url: "<?php echo base_url('doctor_doorstep/assign_docter_booking');?>",
              data: {booking_id: booking_id,doctor_id:doctor_id},
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
              url: "<?php echo base_url('Booking_management/cancel_booking_id');?>",
              data: {cancel_id: cancel_id},
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
              url: "<?php echo base_url('Online_consultation/complete_booking_id');?>",
              data: {booking_ide: booking_ide},
              success: function(data) {
               console.log(data);
              location.reload();
              }
          }); 
   }
</script>
<script type="text/javascript">
   function ReAssign22(id)
         {
   
   var transaction_id  = id;
   //alert(transaction_id);
   $.ajax({
   url: "<?php echo base_url('Booking_management/transaction_details');?>",
   method: "POST",
   data: {transaction_id:transaction_id},
   success: function(data){  
   
   var service = JSON.parse(data);
   console.log(service);
   
   
   $("#booking_txn_id").html(service['booking_txn_id']);
   $("#payment_mode").html(service['payment_mode']);
   $("#type").html(service['type']);
   $("#old_wallet").html(service['old_wallet']);
   $("#txn_amount").html(service['txn_amount']);
   $("#update_wallet").html(service['update_wallet']);
   $("#status").html(service['status']);
   $("#txn_mode").html(service['txn_mode']);
   $("#bank_name").html(service['bank_name']);
   $("#bank_txn_id").html(service['bank_txn_id']);
   $("#ifsc").html(service['ifsc']);
   $("#account").html(service['account']);
   $("#created_at").html(service['created_at']);
   
   
   }
   });
   }
   
</script>
<script type="text/javascript">
   function ReAssign_refund(id)
         {
   
   var transaction_id  = id;
   // alert(transaction_id);
   $.ajax({
   url: "<?php echo base_url('Booking_management/refund_transaction_details');?>",
   method: "POST",
   data: {transaction_id:transaction_id},
   success: function(data){  
   
   var service1 = JSON.parse(data);
   console.log(service1);
   
   
   $("#refund_booking_txn_id").html(service1['booking_txn_id']);
   
   $("#refund_txn_amount").html(service1['txn_amount']);
   
   $("#refund_created_at").html(service1['created_at']);
   
   
   }
   });
   }
   
</script>
<script type="text/javascript">
   function ReAssign221(id)
         {
   
   var booking_id  = id;
   //alert(booking_id);
   $.ajax({
   url: "<?php echo base_url('online_consultation/image_details');?>",
   method: "POST",
   data: {booking_id:booking_id},
   success: function(data){  
    
   // var service = JSON.parse(data);
   console.log(data);
   
   
   
   
   $("