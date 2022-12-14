<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
       Clinic Management  New Booking 
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active">  Clinic Management New Booking </li>
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
            <span><a href="<?php echo base_url()?>offline_consultation/export_offline_doctor/new_booking"> 
                  <button type="button" class="btn add-new float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button></a>
            </span>
         </ol>
  <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Clinic Management New Booking </h3>
               </div>

               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table id="" class="table table-bordered table-striped ">
                     <thead>
                        <tr>
                            <th>ID </th>                                           
                           <th>Name </th>                                           
                           <th>Mobile </th>                                           
                           <th>Email </th>                                           
                           <th>Problem</th>
                           <th>Address</th>                                            
                           <th>Area</th>                                            
                           <th>Pin Code</th>                                            
                           <th>City State</th>                                            
                                                                  
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           
                           <th>Assign Doctor</th>
                           <th>Cancel Doctor </th> 
                           <th>Trxn Detail</th>
                           <th>Status</th>  <th>Refund</th>
                          <!--  <th>Cancel By</th> -->
                           <!-- <th>Complete On</th> -->

                        </tr>
                     </thead> 
                       <tbody>
                       <?php if ($list): ?>
                          <?php 
                          $x=1;
                          foreach ($list as $key): ?>
                          <tr>
                             <td class="center"><?php echo $x;?></td>
                              <td class="center"><?php 
                              $patient_id= $key->patient_id;
                              $patient = $this->db->where('id',$patient_id)->get('patient')->row();
                               if ($patient) {
                                 echo $patient->name;
                               }
                               ?>
                             </td>
                             <td class="center">
                              <?php 
                              $patient_id= $key->patient_id;
                              $patient = $this->db->where('id',$patient_id)->get('patient')->row();
                               if ($patient) {
                                 echo $patient->phone;
                               }
                               ?></td>
                             <td class="center"><?php 
                              $patient_id= $key->patient_id;
                              $patient = $this->db->where('id',$patient_id)->get('patient')->row();
                               if ($patient) {
                                 echo $patient->email;
                               }
                               ?></td>
                             <td class="center"><?= $key->problem; ?></td>
                             <td class="center"><?= $key->address; ?></td>
                             <td class="center"><?= $key->area; ?></td>
                             <td class="center"><?= $key->pincode; ?></td>
                             <td class="center"><?= $key->city_state; ?></td>
                            

                             <td class="center"><?= $key->booking_date; ?></td>
                             <td class="center"><?= $key->booking_time; ?></td>
                               
                             <td class="center"><?php 
                              $doctor_id= $key->doctor_id;
                              $doctor = $this->db->where('id',$doctor_id)->get('doctor')->row();
                               if ($doctor) {
                                ?>
                                 
                                   <a href="<?php echo base_url();?>Doctordetail_ctrl/doctor_view/<?php echo $key->doctor_id; ?>" target="_blank">  
                                <?php echo $doctor->doctor_firstname; ?>
                              </a>

                               
                                 
                               <?php
                                }
                               ?>
                                </td>

                          
                               <td class="center">
                              <?php if ($key->status == 0) {
                                ?>
                                 <a class="btn btn-sm btn-danger" onclick="return ReAssign11('<?php echo $key->id;?>')" data-toggle="modal" data-target="#modal-danger"></i>Cancel</a> 
                                 <?php
                              }else{
                                echo"--";
                              }
                               ?>
                               </td>
                          
                             <td class="center">
                              <a class="btn btn-sm btn-primary transaction_details" onclick="return ReAssign22('<?php echo $key->id;?>')" data-toggle="modal" data-target="#modal-default" id="<?= $key->id; ?>">
                                Transaction</a>
                                
                               </td>

                              <td><?php
                               if($key->status == 0)
                               {
                                echo "<span class='badge bg-yellow'>New</span>";
                               }
                               elseif($key->status == 1)
                               {
                                echo "<span class='badge bg-green'>Complete</span>";

                              
                               }
                               elseif($key->status == 2 || $key->status == 3)
                               {
                                echo "<span class='badge bg-red'>Canceled</span>";
                                  
                               }

                               elseif($key->status == 4)
                               {
                                echo "<span class='badge bg-light-blue'>On Going</span>";
                               }

                                elseif($key->status == 5)
                               {
                                echo "<span class='badge bg-red'>Canceled By Doctor</span>";
                               }

                                ?>
                              </td>
                              <td>
                               <?php
                             
                               if($key->status == 2 || $key->status == 3 || $key->status == 5)
                               {
                                
                                if ($key->refund_status == 0) 
                                {
                                  ?>
                                  <a data-toggle="modal" data-target="#modal-info_refund" data-backdrop="static"  data-keyboard="false" onclick="return ReAssignrefund('<?php echo $key->id;?>')" class="btn btn-sm btn-primary">Refund</a> 
                                <?php 
                                }   
                                else
                                {
                                 echo "Trxn Id - " .$key->refund_trxn_id."<br>" ;
                                 echo "Refund Date - " .$key->refund_date."<br>" ;
                                 echo "Refund Amount - " .$key->refund_amount."<br>" ;
                                
                                }
                                
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
                          <th>ID </th>                                           
                           <th>Name </th>                                           
                           <th>Mobile </th>                                           
                           <th>Email </th>                                           
                           <th>Problem</th>
                           <th>Address</th>                                            
                           <th>Area</th>                                            
                           <th>Pin Code</th>                                            
                           <th>City State</th>
                                                                     
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           
                           <th>Assign Doctor</th>
                           <th>Cancel Doctor </th> 
                           <th>Trxn Detail</th>
                            <th>Status</th>  <th>Refund</th>
<!--                            <th>Cancel By</th>
 -->                          <!--  <th>Complete On</th> -->
                          
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
                <form action="<?=base_url('medical_doorstep/refund_data')?>" role="form" id="newModalForm" method="POST">
 
                <p>
                  <?php $docter = $this->db->where(array('doorstep' => 1,'status'=>1 ))->get('doctor')->result();?>

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
              <td> <span id="tax_amount" class="tax_amount"></span></td>
            </tr>
            <tr>
              <td>Base Amount</td>
              <td> <span id="base_amount" class="base_amount"></span></td>
            </tr>
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

             <tr>
              <td>Amount/Percentage</td>
              <td> <span id="amount" class="amount"></span></td>
            </tr>

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

             <tr>
              <td>Created At</td>
              <td> <span id="created_at" class="created_at"></span></td>
            </tr>

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
 -->              </div>
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
      function ReAssign(id)
      {
        var id = id;
      //  alert(id);
         $('#booking_id').val(id);
      }
</script>

<script type="text/javascript">
      function ReAssign11(id)
      {
        var id = id;
      //alert(id);
      $('#cancel_id').val(id);
        
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
           url: "<?php echo base_url('doctor_doorstep/cancel_booking_id');?>",
           data: {cancel_id: cancel_id},
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
url: "<?php echo base_url('speedhuntson/transaction_details');?>",
method: "POST",
data: {transaction_id:transaction_id},
success: function(data){  

var service = JSON.parse(data);
console.log(service);

var coupan_id = service[0]['coupan_code_id'];
var discount = service[0]['discount_type'];

if(coupan_id == 0 ){
  var  discount_type = '';
   var amount = '';
}
else if(discount == "percentage")
{
var  discount_type =  service[0]['discount_type'];
var amount =  service[0]['amount']+"%";

}
else if(discount == 'flat')
{
  var  discount_type =  service[0]['discount_type'];
  var amount =  service[0]['amount']+"₹";

}

// $("#base_amount").html(service[0]['base_amount']);
  $("#discount_type").html(discount_type);
  $("#amount").html(amount);
var  total_amount =  service[0]['total_amount'];
var  discount_amount =  service[0]['discount_amount'];
var  referral_amount =  service[0]['referral_amount'];
var  wallet_amount =  service[0]['wallet_amount'];
var total = Number(total_amount) + Number(discount_amount)+ Number(referral_amount)+ Number(wallet_amount);
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
$("#created_at").html(service[0]['created_at']);
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
function ReAssign221(id)
      {

var booking_id  = id;
//alert(booking_id);
$.ajax({
url: "<?php echo base_url('offline_consultation/image_details');?>",
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
 