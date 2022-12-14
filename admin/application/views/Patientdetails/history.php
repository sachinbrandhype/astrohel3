<?php $id = $this->uri->segment(3);?>
<input type="hidden" name="user_id" class="user_id" id="user_id" value="<?php echo $id;?>">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        History Details 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('Patient_details/view_patientdetails');?>">User</a></li>
        <li class="active">History Details</li>
      </ol>
    </section>

      <section class="content">
         <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="complete_booking" class="complete_booking"></h3>

              <p>Complete Booking</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="new_booking" class="new_booking"></h3>

              <p>New Booking</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>


         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="cancel_booking" class="cancel_booking"></h3>

              <p>Cancel Booking</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="total_booking" class="total_booking"></h3>

              <p>Total Booking</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="total_rentals" class="total_rentals"></h3>

              <p>Total Equipment Rentals</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="total_purchase" class="total_purchase"></h3>

              <p>Total Equipment Purchase</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="total_equipment" class="total_equipment"></h3>

              <p>Total Equipment</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="complete_equipment" class="complete_equipment"></h3>

              <p>Complete Equipment</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="new_equipment" class="new_equipment"></h3>

              <p>New Equipment</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="cancel_equipment" class="cancel_equipment"></h3>

              <p>Cancel Equipment</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="refund_equipment" class="refund_equipment"></h3>

              <p>Refund Equipment</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="total_ambulence_booking" class="total_ambulence_booking"></h3>

              <p>Total Ambulence Booking</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="total_surgery_enquiry" class="total_surgery_enquiry"></h3>

              <p>Total Surgery Enquiry</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="lab_complete_test" class="lab_complete_test"></h3>

              <p>Lab Complete Test</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="lab_new_test" class="lab_new_test"></h3>

              <p>Lab New Test</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="lab_cancel_test" class="lab_cancel_test"></h3>

              <p>Lab Cancel Test</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="lab_total_test" class="lab_total_test"></h3>

              <p>Lab Total Test</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="lab_refund_test" class="lab_refund_test"></h3>

              <p>Lab Refund Test</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           
          </div>
        </div>


      </div>
    </section>


     <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Online Consultation History</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="" class="table table-bordered table-striped datatable">
                     
                     <thead>
                     
                        <tr>
                           <th>id</th>      
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           <th>Image</th>
                        </tr>
                     </thead> 
                     <tbody>
                       <?php
                           foreach($online_data as $appoin) {       
                            $image = explode('|', $appoin->images);
                             
                           ?>
                        
                        <tr>
                           <td class="center"><?php echo $appoin->id; ?></td>  
                           <td class="center"><?php echo $appoin->booking_date; ?></td>
                           <td class="center"><?php echo $appoin->booking_time; ?></td>
                           <td class="center">
                            <?php 
                            foreach ($image as $key)
                            {
                              ?>
                              <a href="<?php echo base_url('uploads/video_attachment_by_patient/').'/'.$key;?> " download> <img height="50" width="60" src="<?php echo base_url("uploads/video_attachment_by_patient")."/".$key;?>"></a>
                              <?php
                            }
                            ?></td>

                  </tr>
                  <?php
                           }
                           ?>
               
                     </tbody>
                     <tfoot>
                       
                        <tr>
                         <th>id</th>      
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           <th>Image</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>


          

          <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Lab History</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="" class="table table-bordered table-striped datatable">
                     
                     <thead>
                     
                        <tr>
                           <th>id</th>      
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           <th>Image</th>
                        </tr>
                     </thead> 
                     <tbody>
                       <?php
                           foreach($lab_data as $lab) {       
                            $image = explode('|', $lab->images);
                             
                           ?>
                        
                        <tr>
                           <td class="center"><?php echo $lab->id; ?></td>  
                           <td class="center"><?php echo $lab->booking_date; ?></td>
                           <td class="center"><?php echo $lab->booking_time; ?></td>
                           <td class="center">
                            <?php 
                            foreach ($image as $key)
                            {
                              ?>
                              <a href="<?php echo base_url('uploads/booking_lab_test/').'/'.$key;?> " download> <img height="50" width="60" src="<?php echo base_url("uploads/booking_lab_test")."/".$key;?>"></a>
                              <?php
                            }
                            ?></td>

                  </tr>
<?php
                           }
                           ?>
               
                     </tbody>
                     <tfoot>
                       
                        <tr>
                         <th>id</th>      
                           <th>Booking Date</th>
                           <th>Booking Time</th>
                           <th>Image</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>


          <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Pharmacy  History</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="" class="table table-bordered table-striped datatable">
                     
                     <thead>
                     
                        <tr>
                           <th>id</th>      
                           <th>Pharmacy Detail</th>
                           <th>Amount</th>
                           <th>Image</th>
                        </tr>
                     </thead> 
                     <tbody>
                         <?php
                           foreach($pharmacy_data as $pharmacy) {       
                            $image = explode('|', $pharmacy->images);
                             
                           ?>
                        <tr>
                           <td class="center"><?php echo $pharmacy->id; ?></td>  
                           <td class="center"><?php echo $pharmacy->pharmacy_detail; ?></td>
                           <td class="center"><?php echo "Rs. ".$pharmacy->amount; ?></td>
                           <td class="center">
                            <?php 
                            if (!empty($image)) {
                             
                           
                            foreach ($image as $key)
                            {
                              ?>
                              <a href="<?php echo base_url('uploads/pharmacy_attachment_by_patient/').'/'.$key;?> " download> <img height="50" width="60" src="<?php echo base_url("uploads/pharmacy_attachment_by_patient")."/".$key;?>"></a>
                              <?php
                            }
                             }
                            ?></td>

                  </tr>

                <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                      
                        <tr>
                        <th>id</th>      
                           <th>Pharmacy Detail</th>
                           <th>Amount</th>
                           <th>Image</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>

           <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Quotation  History</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="" class="table table-bordered table-striped datatable">
                     
                      <thead>
                     
                        <tr>
                           <th>id</th>      
                           <th>Problem</th>
                           <th>Image</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                           foreach($quotation_data as $quotation) {       
                            $image = explode('|', $quotation->image);
                             
                           ?>
                        <tr>
                           <td class="center"><?php echo $quotation->id; ?></td>  
                           <td class="center"><?php echo $quotation->problem; ?></td>
                           <td class="center">
                            <?php 
                            if (!empty($image)) {
                             
                           
                            foreach ($image as $key)
                            {
                              ?>
                              <a href="<?php echo base_url('uploads/quotation_attachment_by_patient/').'/'.$key;?> " download> <img height="50" width="60" src="<?php echo base_url("uploads/quotation_attachment_by_patient")."/".$key;?>"></a>
                              <?php
                            }
                             }
                            ?></td>

                  </tr>
                   <?php
                           }
                           ?>
               
                     </tbody>
                     <tfoot>
                      
                        <tr>
                        <th>id</th>      
                           <th>Problem</th>
                           <th>Image</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>



 

      <div class="clearfix"></div>
  </div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
   
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   


    </script>


  <script language="javascript" type="text/javascript">
$(document).ready(function (){
     var user_id = $(".user_id").val();
// alert(user_id);
          $.ajax({
url: "<?php echo base_url('patient_details/history_details');?>",
method: "POST",
data: {user_id:user_id},
success: function(data){  

 var service = JSON.parse(data);
console.log(service);




var new_booking = $("#new_booking").html(service['new_booking']);
var cancel_booking = $("#cancel_booking").html(service['cancel_booking']);
var cancel_equipment = $("#cancel_equipment").html(service['cancel_equipment']);
var complete_booking = $("#complete_booking").html(service['complete_booking']);
var complete_equipment = $("#complete_equipment").html(service['complete_equipment']);
var lab_cancel_test = $("#lab_cancel_test").html(service['lab_cancel_test']);
var lab_complete_test = $("#lab_complete_test").html(service['lab_complete_test']);
var lab_new_test = $("#lab_new_test").html(service['lab_new_test']);
var lab_refund_test = $("#lab_refund_test").html(service['lab_refund_test']);
var lab_total_test = $("#lab_total_test").html(service['lab_total_test']);
var refund_equipment = $("#refund_equipment").html(service['refund_equipment']);
var total_ambulence_booking = $("#total_ambulence_booking").html(service['total_ambulence_booking']);
var total_booking = $("#total_booking").html(service['total_booking']);
var total_equipment = $("#total_equipment").html(service['total_equipment']);
var total_purchase = $("#total_purchase").html(service['total_purchase']);
var total_rentals = $("#total_rentals").html(service['total_rentals']);
var total_surgery_enquiry = $("#total_surgery_enquiry").html(service['total_surgery_enquiry']);
var new_equipment = $("#new_equipment").html(service['new_equipment']);
// $("#total_amount").html(service[0]['total_amount']);


// alert(new_booking);
// var discount = service[0]['discount_type'];




}
});
        })
</script>

