
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Details 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('Patient_details/view_patientdetails');?>">User</a></li>
        <li class="active">User Details</li>
      </ol>
    </section>
<section class="invoice">
      <!-- title row -->
       <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
           <i class="fas fa-stethoscope"></i>
           <?=$data->name?>
            <small class="pull-right"></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      
      <div class="row invoice-info">
        <div class="col-sm-5 invoice-col">
          <strong> Name </strong><br>
            <?=$data->name?><br><br>
           <strong> Mobile</strong><br>
            <?=$data->phone?><br><br>
           <strong> Email</strong><br>
            <?=$data->email?><br><br>
          <!--  <strong>Gender</strong><br>
            <?=$data->patient_sex?><br><br> -->
             <strong>DOB </strong><br>
           <?=$data->dob?><br><br>  

            <strong>Terms </strong><br>
           <?=$data->terms?><br><br>  

            <strong>Birth Time </strong><br>
          <?php
            $timestamp = strtotime($data->birth_time);
            $new_date = date("d-m-Y", $timestamp);
            echo $new_date; // Outputs: 31-03-2019
          ?>
<br><br>  
            <strong>Place Of Birth </strong><br>
           <?=$data->place_of_birth?><br><br>  

            <strong>Gender </strong><br>
           <?=$data->gender?><br><br>  
            
             <!-- <strong>Languages</strong><br>
            <?=$data->languages?><br><br> -->
           <!-- <strong>Marital Status</strong><br>
            <?=$data->marital_status?><br><br> -->
           <strong>Address</strong><br>
            <?=$data->address?><br><br>
          

        </div>

                <div class="col-sm-5 invoice-col">

           <!-- <strong>Auth   </strong><br>
           <?=$data->auth?><br><br>   -->
             <strong>Ip Address   </strong><br>
           <?=$data->ip_address?><br><br>  
            <strong>Device Type   </strong><br>
           <?=$data->device_type?><br><br>  
            <strong>Login Time   </strong><br>
           <?=$data->loginTime?><br><br>  
            <strong>Model Name   </strong><br>
           <?=$data->model_name?><br><br>  
            <strong>Carrier Name   </strong><br>
           <?=$data->carrier_name?><br><br>  
            <strong>Device Country   </strong><br>
           <?=$data->device_country?><br><br>  
            <strong>Device Memory   </strong><br>
           <?=$data->device_memory?><br><br>  
             <strong>Have Notch   </strong><br>
           <?=$data->have_notch?><br><br>  
             <strong>Manufacture   </strong><br>
           <?=$data->manufacture?><br><br>  
          
             <!-- <strong>Referral Code   </strong><br>
           <?=$data->referral_code?><br><br>     -->
             <!-- <strong>Wallet   </strong><br>
           <?=$data->wallet?><br><br>     -->
             <!-- <strong>Refferal Wallet   </strong><br>
           <?=$data->refferal_wallet?><br><br>     -->
             <strong>Added On   </strong><br>

            


           <?=$data->added_on?><br><br>  
           
            <img height="50" width="70" alt="your image" src="<?php echo base_url('/')."uploads/user/";?><?=$data->image?>" name=""/>
        </div>


        <!-- /.col -->
       

         

        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->

      <div class="row">
        <div class="col-xs-12 table-responsive">
        
        </div>
        <!-- /.col -->
      </div>



      <!-- /.row -->
  
      <!-- /.row -->

      <!-- this row will not appear when printing -->
    </section>
      <div class="clearfix"></div>
  </div>