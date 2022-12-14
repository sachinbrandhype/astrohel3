<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Astrologers Bank Details 
      </h1>
        <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
            <li class="active"> Astrologers Bank Details </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <table class="table">
                      
                        <tr>
                          <th scope="col">Beneficiary Name</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                       <tr>
                          <th scope="col">Bank Name</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                         
                          <tr>
                          <th scope="col">Account Type</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                       <tr>
                          <th scope="col">Account Number</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                       <tr>
                          <th scope="col">IFSC Code</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                       <tr>
                          <th scope="col">Branch Name</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                       <tr>
                          <th scope="col">Gst Number</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                       <tr>
                          <th scope="col">Pan Card Number</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>
                       <tr>
                          <th scope="col">Bank Address</th>
                           <td><?php echo $list->beneficiary_name; ?></td>
                       </tr>

                         
                     
                    </table>
             
</div>
<!-- /.box -->
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
