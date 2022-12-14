<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
       Package History
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> Package History</li>
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
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Package History</h3>
               </div>
               <div class="row">
   <div class="col-md-12">
      <?php echo $links; ?>
   </div>
</div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                         
                           <th>Package Name</th>                                                                             
                           <th>Package Duration Type</th> 
                           <th>Package Description</th> 
                           <th>Patient Name</th>   
                           <th>Patient Email</th>   
                           <th>Patient mobile</th>   
                           <th>Trxn Detail</th>   
                           <th>Validity</th>   
                           <th>Status</th>   

                           <th>Total Renew</th>                         
                           <th>View Renew</th>                         
                                              
                           <th>Package Add On</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                           foreach($list as $details) {   
                           $pack = $this->db->get_where('patient_package',array('id' => $details->package_id,'type' => 'package'))->row();  
                           if(!empty($pack))
                           {
                           ?>
                        <tr>
                        
                           <td class="center"><?php 
                           $package_id= $details->package_id;
                           $patient_package = $this->db->where('id',$package_id)->get('patient_package')->row();
                            if ($patient_package) {
                              echo $patient_package->package_name;
                            }
                            ?>
                          </td>
                           <td class="center"><?php 
                           $package_id= $details->package_id;
                           $patient_package = $this->db->where('id',$package_id)->get('patient_package')->row();
                            if ($patient_package) {
                              echo $patient_package->duration_type;
                            }
                            ?>
                          </td>
                           <td class="center"><?php 
                           $package_id= $details->package_id;
                           $patient_package = $this->db->where('id',$package_id)->get('patient_package')->row();
                            if ($patient_package) {
                              echo $patient_package->description;
                            }
                            ?>
                          </td>

                          <td class="center"><?php 
                           $patient_id= $details->patient_id;
                           $patient = $this->db->where('id',$patient_id)->get('patient')->row();
                            if ($patient) {
                              echo $patient->name;
                            }
                            ?>
                          </td>

                           <td class="center"><?php 
                           $patient_id= $details->patient_id;
                           $patient = $this->db->where('id',$patient_id)->get('patient')->row();
                            if ($patient) {
                              echo $patient->email;
                            }
                            ?>
                          </td>

                           <td class="center"><?php 
                           $patient_id= $details->patient_id;
                           $patient = $this->db->where('id',$patient_id)->get('patient')->row();
                            if ($patient) {
                              echo $patient->phone;
                            }
                            ?>
                          </td>

                          <td class="center">
                           <a class="btn btn-sm btn-primary transaction_details" onclick="return ReAssign22('<?php echo $details->id;?>')" data-toggle="modal" data-target="#modal-default" id="<?= $details->id; ?>">
                             Transaction</a>
                         </td>

                         <td class="center"><?= $details->start_date." To ".$details->valid_till; ?></td>
                         <td class="center">
                              <?php
                              if ($details->status == 1)
                              {
                                 echo "Active";
                              }
                              else 
                              {
                                 echo "Expire";
                              }
                               ?>

                         </td>
                         <td><?= $details->renew_times;?></td>
                        <td class="center">
                           <a class="btn btn-sm btn-primary transaction_details" onclick="return ReAssign('<?php echo $details->id;?>')" data-toggle="modal" data-target="#modal-default_<?=$details->id?>" id="<?= $details->id; ?>">
                            View Renew</a>
                            <?php $history = $this->db->get_where('package_renew_history',array('user_id'=> $details->id))->row();?>
                              <div class="modal fade" id="modal-default_<?=$details->id?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Renew details</h4>
                                      </div>
                                      <div class="modal-body table-responsive">
                                        <table id="classTable" class="table table-bordered">
                                  <thead>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Package Name</td>
                                      <td> <span id="package_name" class="package_name"></span></td>
                                      
                                    </tr>
                                    <tr>
                                      <td>Name</td>
                                      <td><span id="name" class="name"></span></td>
                                      
                                    </tr>
                                    <tr>
                                      <td>Payment Id</td>
                                      <td> <span id="payment_id" class="payment_id"></span></td>
                                    </tr>
                                    <tr>
                                      <td>Start Date</td>
                                      <td> <span id="start_date" class="start_date"></span></td>
                                    </tr>
                                    <tr>
                                      <td>Valid Date</td>
                                      <td> <span id="valid_date" class="valid_date"></span></td>
                                    </tr>
                                    <tr>
                                      <td>Added On</td>
                                      <td> <span id="added_on" class="added_on"></span></td>
                                    </tr>
                                    

                                    <tr>
                                      <td>Type</td>
                                      <td> <span id="type" class="type"></span></td>
                                    </tr>

                                     <tr>
                                      <td>Upgrade Package Name</td>
                                      <td> <span><?php 
                                      if(!empty($history->upgrade_package_id))
                                      { 
                                        $package_id= $history->upgrade_package_id;
                                          $patient_package = $this->db->where('id',$package_id)->get('patient_package')->row();
                                           if ($patient_package) {
                                             echo $patient_package->package_name;
                                           }

                                      // echo $history->upgrade_package_id;
                                       }
                                       ?></span></td>
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

                        </td>
                        <td class="center"><?php 
                           $package_id= $details->add_on_id;
                           $patient_package = $this->db->where('id',$package_id)->get('patient_package')->row();
                            if ($patient_package) {
                              echo $patient_package->package_name;
                            }
                            ?>
                          </td>

                           
                       

                         
                        </tr>
                        <?php
                           }
                        }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                         <th>Package Name</th>                                                                             
                           <th>Package Duration Type</th> 
                           <th>Package Description</th> 
                           <th>Patient Name</th>   
                           <th>Patient Email</th>   
                           <th>Patient mobile</th>   
                           <th>Trxn Detail</th>   
                           <th>Validity</th>   
                           <th>Status</th>      
                           <th>Total Renew</th>                         
                           <th>View Renew</th>                                                      
                           <th>Package Add On</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>

               <div class="row">
   <div class="col-md-12">
      <?php echo $links; ?>
   </div>
</div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
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
              <td>Buyer Email</td>
              <td> <span id="buyer_email" class="buyer_email"></span></td>
              
            </tr>
            <tr>
              <td>Buyer Phone</td>
              <td><span id="buyer_phone" class="buyer_phone"></span></td>
              
            </tr>
            <tr>
              <td>Currency</td>
              <td> <span id="currency" class="currency"></span></td>
            </tr>
            <tr>
              <td>Fees</td>
              <td> <span id="fees" class="fees"></span></td>
            </tr>
            <tr>
              <td>Tax</td>
              <td> <span id="tax" class="tax"></span></td>
            </tr>
            <tr>
              <td>Payment Id</td>
              <td> <span id="transaction_payment_id" class="transaction_payment_id"></span></td>
            </tr>
            

           
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
var renew_id  = id;
//alert(renew_id);
$.ajax({
url: "<?php echo base_url('Package_ctrl/renew_details');?>",
method: "POST",
data: {renew_id:renew_id},
success: function(data){  
var service = JSON.parse(data);
console.log(service);

$("#package_name").html(service['package_name']);
$("#name").html(service['name']);
$("#payment_id").html(service['payment_id']);
$("#start_date").html(service['start_date']);
$("#valid_date").html(service['valid_date']);
$("#added_on").html(service['added_on']);
$("#type").html(service['type']);
$("#upgrade_package_id").html(service['upgrade_package_id']);
$("#is_addon").html(service['is_addon']);

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
url: "<?php echo base_url('Package_ctrl/transaction_details');?>",
method: "POST",
data: {transaction_id:transaction_id},
success: function(data){  
var service = JSON.parse(data);
console.log(service);
$("#buyer_email").html(service['buyer_email']);
$("#buyer_phone").html(service['buyer_phone']);
$("#currency").html(service['currency']);
$("#fees").html(service['fees']);
$("#tax").html(service['tax']);
$("#transaction_payment_id").html(service['payment_id']);

}
});
}

</script>