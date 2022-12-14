<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
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
            <li><!-- <a href="<?php echo base_url(); ?>speedhuntson/add_ambulance"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Ambulance</b></button></a>-->
            <span> <!--  <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success"> -->
            </span>


              <form method="get">
               <!--  <div class="col-md-12" style="margin-bottom: 10px;">
            <span>  <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success">
            </span>
        </div>
              -->
                    <div class="col-md-4">           
                        <div class="form-group">
                          <label>Booking Date To</label>
                          <input type="date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>"  class="form-control" name="start_date" id="from">
                        </div>
                     </div>

                     <div class="col-md-4">           
                        <div class="form-group">
                            <label>Booking Date From</label>
                          <input type="date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>"  class="form-control" name="end_date" id="to">
                                    
                        </div>
                     </div>



                     <div class="col-md-4">           
                        <div class="form-group">
                          <label>Name</label>
                           <input type="text" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>"  class="form-control" name="name" id="from">
                        </div>
                     </div>


                     <div class="col-md-4">           
                        <div class="form-group">
                          <label>Email</label>
                           <input type="text" value="<?= isset($_GET['email']) ? $_GET['email'] : '' ?>"  class="form-control" name="email" id="from">
                        </div>
                     </div>


                     <div class="col-md-4">           
                        <div class="form-group">
                          <label>Mobile</label>
                           <input type="text" value="<?= isset($_GET['mobile']) ? $_GET['mobile'] : '' ?>"  class="form-control" name="mobile" id="from">
                        </div>
                     </div>

  <!-- 
                       <div class="col-md-4">           
                          <div class="form-group">
                            <label>Gender</label>
                             <select name="gender" class="form-control">
                               <option value="">Select Gender</option>
                            
                                  <option value="male"   <?=isset($_GET['gender']) ? $_GET['gender'] == 'male' ? 'selected':'' : ''?> >Male</option>
                                  <option value="female"   <?=isset($_GET['gender']) ? $_GET['gender'] == 'female' ? 'selected':'' : ''?> >Female</option>
                                 
                             </select>

                            
                          </div>
                       </div> -->

                  
                      
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
              <!--     <h3 class="box-title">Online Consultation <?php echo $status ; ?> </h3> -->
               </div>

               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table id="" class="table table-bordered table-striped ">
                     <thead>
                        <tr>
                              <th>S.No </th>  
                                                                
                           <th>Booking Type</th>  
                           <th>Name </th>                                        
                           <th>Email </th>                                        
                           <th>Mobile </th>                                        
                           <th>Gender </th>                                        
                           <th>Dob   </th>                                        
                           <th>Time of birth  </th>                                        
                           <th>Problem by User </th>                                        
                           <th>User Father Name   </th> 
                           <th>User Mother Name   </th> 
                           <th>Gotro   </th> 
                           <th>Spouse   </th> 
                           <th>Language   </th> 
                           <th>Message   </th> 
                           <th>Start Time   </th> 
                           <th>End Time   </th> 
                           <th>Total Minutes   </th> 
                       

                           <th>Booking Status</th>
                           <th>Trxn Detail</th>
                           <th>Added on</th>
                           <th>Cancel  </th> 
                           <th>Cancel By</th>
                           <th>Refund</th>


                        </tr>
                     </thead> 
                       <tbody>
                       <?php if ($list): ?>
                          <?php 
                          $x=1;
                          foreach ($list as $key): ?>
                          <tr>
                            
                             <td class="center"><?php echo $x;?></td>

                                 <td class="center">
                              <?php
                               if ($key->booking_type  == "2" )
                              {
                                echo "Astrologer Booking";
                              }
                              
                              else
                              {
                                 echo "--";
                              }

                              ?></td>




                             <td class="center"><?= $key->user_name; ?></td>
                             <td class="center"><?= $key->user_email; ?></td>
                             <td class="center"><?= $key->user_phone; ?></td>
                             <td class="center"><?= $key->user_gender; ?></td>
                        
                           <!--   <td class="center"><?php 
                              $user_id= $key->user_id;
                              $patient = $this->db->where('id',$user_id)->get('user')->row();
                               if ($patient) {
                                 echo $patient->phone;
                               }
                               ?></td>
 -->
                           
                           
                             <td class="center"><?php
                               $new_date = date("d/m/Y", strtotime($key->user_dob));
                               echo $new_date;
                              ?></td>
                             <td class="center"><?=  date('h:ia', strtotime($key->user_tob)); ?></td>
                             <td class="center"><?= $key->user_pob  ; ?></td>
                             <td class="center"><?= $key->user_fathername  ; ?></td>
                             <td class="center"><?= $key->user_mothername  ; ?></td>
                             <td class="center"><?= $key->user_gotro  ; ?></td>
                             <td class="center"><?= $key->user_spouse  ; ?></td>
                             <td class="center"><?= $key->language  ; ?></td>
                             <td class="center"><?= $key->message  ; ?></td>
                             <td class="center"><?= $key->start_time  ; ?></td>
                             <td class="center"><?= $key->end_time  ; ?></td>
                             <td class="center"><?= $key->total_minutes  ; ?></td>
                          

                              <td><?php
                               if($key->status == 0)
                               {
                                echo "<span class='badge bg-yellow'>New</span>";
                               }
                               elseif($key->status == 1)
                               {
                                echo "<span class='badge bg-green'>Complete</span>";

                              
                               }
                               elseif($key->status == 3)
                               {
                                echo "<span class='badge bg-red'>Canceled</span>";
                                  
                               }

                               elseif($key->status == 4)
                               {
                                echo "<span class='badge bg-light-blue'>Refund</span>";
                               }
                             


                                ?>
                              </td>





                               <td class="center">
                              <a class="btn btn-sm btn-primary transaction_details" onclick="return ReAssign22('<?php echo $key->id;?>')" data-toggle="modal" data-target="#modal-default" id="<?= $key->id; ?>">
                                Transaction</a>
                                
                               </td>

                             <td class="center">
                              <?php 
                                $new_dater = date("d-m-Y h:i:s A",  strtotime($key->created_at));
                                echo $new_dater;
                                 ?>
                             </td>


                         
                               <td class="center">
                              <?php 
                             
                              if ($key->status == 0) {
                                ?>
                                 <a class="btn btn-sm btn-danger" onclick="return ReAssign11('<?php echo $key->id;?>')" data-toggle="modal" data-target="#modal-danger"></i>Cancel</a> 
                                 <?php
                              }else{
                                echo"--";
                              }
                               ?>
                               </td>
                          
                           

                               <td class="center">
                              <?php 

                              if ($key->cancel_by_id = 1) 
                              {
                                $cancel_by_id= $key->cancel_by_id;
                                $admin_data = $this->db->where('id',$cancel_by_id)->get('admin')->row();
                                 if ($admin_data) {
                                   echo $admin_data->username;
                                 }
                              }
                              else{
                               echo "User";
                              }
                              
                              
                               ?></td>

                               

                            <td>
                               <?php
                                 if($key->status == 3 )
                                 {
                                
                                  ?>
                                  <a data-toggle="modal" data-target="#modal-info_refund" data-backdrop="static"  data-keyboard="false" onclick="return ReAssignrefund('<?php echo $key->id;?>')" class="btn btn-sm btn-primary">Refund</a> 
                                  <?php 
                                  }   
                                  else
                                  {
                                    ?>
          <a class="btn btn-sm btn-primary transaction_details" onclick="return ReAssign_refund('<?php echo $key->id;?>')"
           data-toggle="modal" data-target="#modal-default_refund" id="<?= $key->id; ?>">
          Refund Data</a>
                                    <?php
                                
                                  }
                                
                                ?>
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
                                                                
                           <th>Booking Type</th>  
                           <th>Name </th>                                        
                           <th>Email </th>                                        
                           <th>Mobile </th>                                        
                           <th>Gender </th>                                        
                           <th>Dob   </th>                                        
                           <th>Time of birth  </th>                                        
                           <th>Problem by User </th>                                        
                           <th>User Father Name   </th> 
                           <th>User Mother Name   </th> 
                           <th>Gotro   </th> 
                           <th>Spouse   </th> 
                           <th>Language   </th> 
                           <th>Message   </th> 
                           <th>Start Time   </th> 
                           <th>End Time   </th> 
                           <th>Total Minutes   </th> 
                       

                           <th>Booking Status</th>
                           <th>Trxn Detail</th>
                           <th>Added on</th>
                           <th>Cancel  </th> 
                           <th>Cancel By</th>
                           <th>Refund</th>

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
                <button type="button" class="btn btn-outline" data-dismiss="modal">No</button></p>
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




$("#images").html(data);



}
});
}

</script> 
 