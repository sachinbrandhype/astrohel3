
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <h1>
        Transaction History 
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('Patient_details/view_patientdetails');?>">Patient</a></li>
        <li class="active">Transaction History</li>
      </ol>
    </section>


 

    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
           <i class="fas fa-stethoscope"></i>
           <?php $p_id = $this->db->where('id',$patientID)->get('patient')->row();
           echo $p_id->name;?>
            <small class="pull-right"></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
       <?php if(!empty($data))
      {
        foreach ($data as $data_transact) {
         ?>
      
      <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
          <strong>Card ID</strong><br>
            <?=$data->card_id?><br><br>
           <strong>Package ID</strong><br>
            <?=$data->package_id?><br><br>
           <strong>Payment Request ID</strong><br>
            <?=$data->paymnet_request_id?><br><br>
           <strong>Payment ID</strong><br>
            <?=$data->payment_id?><br><br>
             <strong>Currency </strong><br>
             <?=$data->currency?>
          <br><br>

          <strong>Amount</strong><br>
            <?=$data->amount?><br><br>

          <strong>Mac</strong><br>
           <?=$data->mac?><br><br>
         
           
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
           <strong>Buyer</strong><br>
            <?php echo $data->buyer; ?></br><br>
        <strong>Fees</strong><br>
            <?=$data->fees?><br><br>
         <strong>Long Url</strong><br>
            <?=$data->longurl?><br><br>
           <strong>Purpose</strong><br>
            <?=$data->purpose?><br><br>
          <strong>Short URL</strong><br>
           <?=$data->shorturl?>
            <br><br>

           <strong>Buyer Name</strong><br>
            <?=$data->buyer_name?><br><br>
           <strong>Buyer Phone</strong><br>
            <?=$data->buyer_phone?><br><br>
          
        </div>
 <?php   }
      }
      ?>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
    </section>

      <div class="clearfix"></div>
  </div>