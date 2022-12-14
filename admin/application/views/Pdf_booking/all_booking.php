<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        Pdf All Booking 
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active">Pdf All Booking </li>
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
           <!--  <a href="<?php echo base_url()?>Pdf_booking/export_online_doctor/all_booking"> 
                  <button type="button" class="btn add-new float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button></a> -->
                     <form method="post" action="<?=base_url('Pdf_booking/export_online_doctor/all_booking')?>">
                          <input type="hidden" name="user_name_mobile" value="<?php echo $user_name_mobile ;?>">
                        
                          <button type="submit" class="btn btn-primary  float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button>
                          </form>

           
            <br>
            <br>

            <form method="post" action="<?=base_url('Pdf_booking/all_booking/')?>">
                             
                     <div class="col-md-12">           
                            <div class="form-group">
                            <label>User</label>
                            <?php 
                            if ($user_name_mobile) 
                            {
                              ?>
                                <input type="text" class="form-control" placeholder="Name Mobile" id="start" name="user_name_mobile" value="<?php echo $user_name_mobile?>">
                            <?php
                            }
                            else
                            {
                              ?>
                              <input type="text" class="form-control" placeholder="Name Mobile"  id="user_name_mobile" name="user_name_mobile">
                              <?php
                            }
                            ?>
                            <!-- <input type="data" name="doc_date" > -->
                        </div>
                     </div>

                    
                   
              <div class="col-md-12" style="margin-top: 25px;">
              <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Submit">&nbsp;&nbsp;
               <input type="submit" name="reset" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Reset">
              </div>

 <div class="col-md-4">
</div>
                        
                         </form>
         </ol>

            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Pdf All Booking </h3>
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
                           <th>Dob   </th>                                        
                           <th>Time of birth  </th>                                        
                           <th>Place of birth   </th>                                        
                           <th>Booking Status</th>
                           <th>Resoliving Files </th>
                           <th>Added on</th>
                           <th>Trxn Detail</th>

                           <th>Complete  </th> 
                           <th>Cancel  </th> 
                           <th>Refund</th>

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
                             <td class="center"><?php echo "PDF Booking(Varshphal)";?></td>
                             
                             <td class="center"><?= $key->name; ?></td>
                             <td class="center"><?= $key->email; ?></td>
                             <td class="center"><?= $key->mobile ; ?></td>
                             <td class="center"><?php
                               $new_datee = date("d-m-Y", strtotime($key->dob));
                               echo $new_datee;
                              ?></td>
                              <td class="center"><?= date('h:ia', strtotime($key->tob)); ?></td>
                             <td class="center"><?= $key->pob; ?></td>


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
                                echo "<span class='badge bg-light-blue'>Refund done</span>";
                               }
                               


                                ?>
                              </td>

                             <td class="center">
                                        <?php
                                        $file_arr = explode("||",$key->uploads_doc);
                                        $q =1;
                                        if(!empty($key->uploads_doc)){
                                            foreach ($file_arr as $a) {
                                                $im = explode(",",$a);
                                                ?>
                                                <a target="_blank" href="<?=base_url().'uploads/varshhal_pdfs/'.$im[0]?>">File - <?=$q++?></a><br/>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>

                              <td class="center">
                              <?php 
                                $new_dater = date("d-m-Y h:i:s A",  strtotime($key->added_on));
                                echo $new_dater;
                                 ?>
                             </td>
                             

                            <td class="center">
                              <a class="btn btn-sm btn-primary transaction_details" onclick="return ReAssign22('<?php echo $key->id;?>')" data-toggle="modal" data-target="#modal-default" id="<?= $key->id; ?>">
                                Transaction</a>
                                
                               </td>
                             

                          
                             

                                   <td class="center">
                              <?php 
                            
                              if ($key->status == 0) {
                                ?>
                                 <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#confirm_<?= $key->id ?>">
                                                Upload File
                                            </button>
                                            <!-- The Modal -->
                                            <div class="modal fade" id="confirm_<?= $key->id ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Confirm</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <form method="post" action="<?=base_url('Pdf_booking/image_pdf_data')?>" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label for="">File</label>
                                                                    <input type="file" name="image[]" class="form-control" multiple required>
                                                                </div>
                                                                <input type="hidden" name="id" value="<?= $key->id ?>">
                                                                <div class="form-group">
                                                                    <input type="submit" name="confirm" value="Submit" class="btn btn-sm btn-primary">
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                 <?php
                              }else{
                                echo"--";
                              }
                               ?>

                                 <?php
                                        if ($key->status == 0 && !empty($key->uploads_doc)) {
                                        ?>
                                            <a onclick="return confirm('Are you sure?')" class="btn btn-sm btn-primary" href="<?= base_url('Pdf_booking/confirm_booking/' . $key->id) ?>">Confirm</a>
                                        <?php
                                        }
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
                           <th>S.No </th>  
                            <th>Booking Type</th>  
                           <th>Name </th>                                        
                           <th>Email </th>                                        
                           <th>Mobile </th>                                        
                           <th>Dob   </th>                                        
                           <th>Time of birth  </th>                                        
                           <th>Place of birth   </th>                                        
                           <th>Booking Status</th>
                           <th>Resoliving Files </th>
                           <th>Added on</th>
                           <th>Trxn Detail</th>

                           <th>Complete  </th> 
                           <th>Cancel  </th> 
                           <th>Refund</th>
                          
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
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
                <form action="<?=base_url('Pdf_booking/refund_data')?>" role="form" id="newModalForm" method="POST">
 
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
                <p> Are you sure cancel Pdf booking!!<br>
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
              <td> <span id="total_amount" class="total_amount"></span></td>
              
            </tr>
            <tr>
              <td>From Payment Gateway </td>
              <td><span id="from_payment_gateway" class="from_payment_gateway"></span></td>
              
            </tr>
            <tr>
              <td>Wallet Amount</td>
              <td> <span id="wallet_amount" class="wallet_amount"></span></td>
            </tr>
            <tr>
              <td>Referral Amount</td>
              <td> <span id="referral_amount" class="referral_amount"></span></td>
            </tr>
            <tr>
              <td>Discount Amount</td>
              <td> <span id="discount_amount" class="discount_amount"></span></td>
            </tr>
            <tr>
              <td>Tax Amount</td>
              <td> <span id="tax_amount" class="tax_amount"></span></td>
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

          <tr>
              <td>Payment Gateway</td>
              <td> <span id="payment_gateway" class="payment_gateway"></span></td>
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
      function ReAssignrefund(id)
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
           url: "<?php echo base_url('Pdf_booking/cancel_booking_id');?>",
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
url: "<?php echo base_url('Pdf_booking/transaction_details');?>",
method: "POST",
data: {transaction_id:transaction_id},
success: function(data){  

var service = JSON.parse(data);
console.log(service);

$("#total_amount").html(service['total_amount']);
$("#from_payment_gateway").html(service['from_payment_gateway']);
$("#wallet_amount").html(service['wallet_amount']);
$("#referral_amount").html(service['referral_amount']);
$("#discount_amount").html(service['discount_amount']);
$("#tax_amount").html(service['tax_amount']);
$("#trxn_status").html(service['trxn_status']);
$("#method").html(service['method']);
$("#fee").html(service['fee']);
$("#tax").html(service['tax']);
$("#payment_method_email").html(service['payment_method_email']);
$("#payment_method_contact").html(service['payment_method_contact']);
$("#payment_gateway").html(service['payment_gateway']);



$("#trxn_mode").html(service['trxn_mode']);
$("#trxn_id").html(service['trxn_id']);

}
});
}

</script>

