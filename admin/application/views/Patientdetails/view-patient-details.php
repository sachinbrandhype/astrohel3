<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         User Details
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> User Details</li>
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
               
              <form method="get">
                <div class="col-md-12" style="margin-bottom: 10px;">
            <span>  <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success">
            </span>
        </div>
             
                    <div class="col-md-4">           
                        <div class="form-group">
                          <label> Date To</label>
                          <input type="date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>"  class="form-control" name="start_date" id="from">
                        </div>
                     </div>

                     <div class="col-md-4">           
                        <div class="form-group">
                            <label> Date From</label>
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
                                            
                       <div class="col-md-4" style="margin-top: 25px;">
                        <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Submit">&nbsp;&nbsp;

                               <a class="btn btn-fill btn-warning" href="<?php echo base_url();?>User_details/view_userdetails/"> 
                               Reset </a> 

                            <!--     <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Reset">&nbsp;&nbsp; -->

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
                  <h3 class="box-title"> User Details</h3>
                 
               </div>
               <!-- /.box-header  class="table-responsive" -->
               <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="">S.No</th>
                           <th>Customer ID</th> 
                           <th>Name</th> 
                           <th>Gender</th>   
                           <th>Mobile</th> 
                           <th>Email</th>
                           <th>Referral Code</th> 
                           <th>Wallet</th> 
                            <th>Add Wallet  </th>   
                            <th>Nill Wallet  </th>   
                           <th>Added On</th>   
                           <th>Status</th>  
                            <th>Wallet History</th>                             
                           <th>Referral History</th>                          
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th class="">S.No</th>
                           <th>Customer ID</th> 
                           <th>Name</th> 
                           <th>Gender</th>   
                           <th>Mobile</th> 
                           <th>Email</th>
                           <th>Referral Code</th> 
                           <th>Wallet</th> 
                            <th>Add Wallet  </th>   
                           <th>Nill Wallet  </th>   
                           <th>Added On</th>   
                           <th>Status</th>     
                            <th>Wallet History</th>                          
                           <th>Referral History</th>                          
                           <th>Action</th>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php
                         $x=$counter_for_index;
                         if ($data) 
                         {
                         
                           foreach($data as $patient) {         
                           ?>
                        <tr>
                           <td><?php echo $x+1; ?></td>
                           <td class="center"><?php echo $patient->id; ?></td>
                           <td class="center"><?php echo $patient->name; ?></td>
                           <td class="center"><?php echo $patient->gender; ?></td><td class="center"><?php echo $patient->country_code.''.$patient->phone; ?></td>
                           <td class="center"><?php echo $patient->email; ?></td>
                           <td class="center"><?php echo $patient->referral_code ? $patient->referral_code  : 'RF'.$patient->id ; ?></td>
                           <td class="center"><?php echo $patient->wallet; ?></td>

                              <td class="center">  
                            <a data-toggle="modal" data-target="#modal-info" data-backdrop="static"  data-keyboard="false" onclick="return ReAssign('<?php echo $patient->id;?>')" class="btn btn-sm btn-primary">Add </a> 
                           </td>                    
                              
                                 <td class="center">  
                            <a data-toggle="modal" data-target="#modal-info1" data-backdrop="static"  data-keyboard="false" onclick="return ReAssign('<?php echo $patient->id;?>')" class="btn btn-sm btn-primary">Deduct </a> 
                           </td>   
                           <td class="center"><?php echo date("d M y g:ia",  strtotime($patient->created_at)); ?></td>
                           <td>
                              <?php 
                              if($patient->status==1){
                                 echo "<span class='label label-success'>Active</span>";
                              }else{
                                 echo "<span class='label label-warning'>Disable</span>";

                              }
                              ?>
                           </td>
                              <td class="center"><a class="btn btn-sm btn-primary"  href="<?php echo base_url();?>User_details/wallet_view/<?php echo $patient->id; ?>">
                                           Wallet History </a>   </td>
                        <td class="center"><a class="btn btn-sm btn-primary"  href="<?php echo base_url();?>User_details/referral_view/<?php echo $patient->id; ?>">
                                           Referral History </a>   </td>
                         <td class="center"> 
                                <a class="btn btn-sm bg-info"  href="<?php echo base_url();?>User_details/patient_view/<?php echo $patient->id; ?>">
                                           <i class="fa fa-fw fa-eye"></i> View </a>   
                                      <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>User_details/delete_Patient/<?php echo $patient->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>      
                                    

                                      <?php if( $patient->status){?>
                              <a class="btn btn-sm btn-warning " href="<?php echo base_url();?>User_details/patient_status/<?php echo $patient->id; ?>"> 
                              <i class="fa fa-folder-open"></i> Disable </a>           
                              <?php
                                 }
                                 else
                                 {
                                 ?>
                              <a class="btn btn-sm btn-success" href="<?php echo base_url();?>User_details/patient_active/<?php echo $patient->id; ?>"> 
                              <i class="fa fa-folder-o"></i> Enable </a>
                              <?php
                                 }
                                 ?> 

    
                           </td>
                        </tr>
                        <?php
                         $x++;
                           }
                         }
                           ?>
                     </tbody>
                     
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
             <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>
            <!-- /.box -->
         </div>


         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>



<div class="modal fade" id="modal-info1" >
          <div class="modal-dialog  modal-lg" style="width: 50%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deduct wallet</h4>
                <span id="spinner" class="myspinner" >
                  <img id="loading-image"  src="<?=base_url('uploads/loader.gif')?>" style='width: 50px;height: 50px;margin-left: 50%;display: none;' ></span>
                <span id = "transp" style="display: none;"></span>
              </div>
              <div class="modal-body">
                <p style="font-size: 20px;">

                   
                     <label>Name -</label>
                      <span id="name" class="name"></span>
                    
                      <br>
                    <label>Phone -</label>
                      <span id="phone" class="phone"></span>

                      <br>
                    <label>Wallet Amount -</label>
                    ₹ <span id="wallet" class="wallet"></span>
                  
                    <br>
                     <label> Amount </label>  <input type="number"  class="form-control amount" name="amount" id="amount"  style="width: 20%;">
                         <br>

                    <label> Message </label>
                             <input type="text"  class="form-control message" required="" name="message" id="message" >
                         <br>

                     <button type="button" class="btn btn-warning" onclick="myFunction_null()" style="margin: 0px 0px 0px 0px;">Deduct Balance</button>

                      <input type="hidden" name="user_id" id="user_id" class="user_id">
                    
                  </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>




<div class="modal fade" id="modal-info" >
          <div class="modal-dialog  modal-lg" style="width: 50%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add wallet</h4>
                <span id="spinner" class="myspinner" >
                  <img id="loading-image"  src="<?=base_url('uploads/loader.gif')?>" style='width: 50px;height: 50px;margin-left: 50%;display: none;' ></span>
                <span id = "transp" style="display: none;"></span>
              </div>
              <div class="modal-body">
                <p style="font-size: 20px;">

                   <!--  <button type="button" class="btn btn-warning" onclick="myFunction_null()" style="float: right;margin: 0px 5px 7px 0px;">O Balance</button> -->
                     <label>Name -</label>
                      <span id="name" class="name"></span>
                    
                      <br>
                    <label>Phone -</label>
                      <span id="phone" class="phone"></span>

                      <br>
                    <label>Wallet Amount -</label>
                    ₹ <span id="wallet" class="wallet"></span>
                  
                    <br>
                    

                      <input type="hidden" name="user_id" id="user_id" class="user_id">
                         
                         <label> Amount</label>  <input type="number"  class="form-control amount1" name="amount" id="amount1"  style="width: 20%;">
                         <br>

                             <label> Message </label>
                             <input type="text"  required="" class="form-control message1" name="message" id="message1" >
                         <br>

                         <br>
                         <button type="button" class="btn btn-success" onclick="myFunction()" style="margin: 0px 0px 0px 0px;">Add Balance</button>
                  </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<div class="modal fade modal-wide" id="popup-patientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">View User Details</h4>
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


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


 

<script>
$(document).ready(function() {

  $.ajax({
  url: "<?php echo base_url('user_details/user_details');?>",
  method: "POST",
  success: function(data){  
  console.log(data);
  $("#images").html(data);
  }
  });
} );
</script>


<script type="text/javascript">
      function ReAssign(id)
      {
        var id = id;
      //  alert(id);
         $('#user_id').val(id);

         $.ajax({
          url: "<?php echo base_url('User_details/user_details');?>",
          method: "POST",
          data: {id:id},
          success: function(data){  

          var service = JSON.parse(data);
          console.log(service);

          $(".name").html(service[0]['name']);
          $(".phone").html(service[0]['phone']);
          $(".wallet").html(service[0]['wallet']);

          }
          });
      }
</script>



<script>
function myFunction() {

  var x = $("#amount1").val();
   var message = $("#message1").val();
  // alert(message);
  if (x < 0)  {
    alert("Please input positive value.");
    return false;
  }
  else if(x)
  {
     var user_id = $(".user_id").val();
      var amount = $("#amount1").val();
     
    $.ajax({
           type: "POST",
           url: "<?php echo base_url('User_details/update_user_amount');?>",
           data: {user_id: user_id,amount:amount,message:message},
            method: "post",
            beforeSend: function(){
            $("#loading-image").show();
            },
            complete: function(){
            $("#loading-image").hide();
            },
           success: function(data) {
            console.log(data);
             // $('#customer_ids').html(data);
               location.reload();
           }
       });

  }
    else  {
    alert("Please input positive value.");
    return false;
  }


   
}
</script>

<script>
function myFunction_null() {
  var result = confirm("Want to Deduct?");
if (result) {
   var user_id = $(".user_id").val();
    var amount = $("#amount").val();
    var message = $("#message").val();
    $.ajax({
           type: "POST",
           url: "<?php echo base_url('User_details/update_user_amount_null');?>",
           data: {user_id: user_id,amount:amount,message:message},
            method: "post",
            beforeSend: function(){
            $("#loading-image").show();
            },
            complete: function(){
            $("#loading-image").hide();
            },
           success: function(data) {
            console.log(data);
             // $('#customer_ids').html(data);
               location.reload();
           }
       }); 
  }
}
</script>

