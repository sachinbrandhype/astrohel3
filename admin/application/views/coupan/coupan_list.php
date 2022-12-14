<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View Coupon
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active">View Coupon List</li>
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
        <!-- <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-body">
                <form role="form" action="" method="post">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Coupon Code</label>
                      <input type="text" name="code" class="form-control" placeholder="Enter ...">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                        <label>Coupon For</label>
                        <select name="for" class="form-control select2 js-example-basic-multiple">
                          <option value="">Select</option>
                          <option value="2">Doctor Doorstep Planned Visit Booking</option>
                          <option value="3">Doctor Doorstep Emergency Booking</option>
                          <option value="4">Nurse Booking</option>
                          <option value="5">Medical Services Doorstep Booking</option>
                          <option value="6">Online Counsult (Chat) Booking</option>
                          <option value="7">Online Counsult (Video) Booking</option>
                          <option value="8">Appointment at clinic</option>
                          <option value="9">Ambulance Booking</option>
                          <option value="10">Lab Test Booking</option>
                          <option value="11">Medical Equipment Booking</option>
                          <option value="12">OPD Health Plans</option>
                          <option value="13">Health Packages</option>
                          <option value="14">Surgical Package</option>
                        </select>
                    </div>

                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2 js-example-basic-multiple">
                          <option value="">Select</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <br>                       
                      <input type="submit" value="Filter" class="btn btn-block btn-primary" type="button">
                    </div>
                  </div>
                </form>
            </div>
          </div>
           
        </div> -->
            <ol class="breadcrumb">
               <li><a href="<?php echo base_url(); ?>speedhuntson/add_coupan"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Coupon</b></button></a>
                  <!-- <span><a href="<?php echo base_url()?>speedhuntson/export_ambulance">
                  <button type="button" class="btn add-new float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button></a>
                  </span> -->
            </ol>
            <div class="row">
   <div class="col-md-12">
      <?php echo $links; ?>
   </div>
</div>
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">View Coupon List</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="" class="table table-bordered table-striped ">
                     <thead>
                        <tr>
                           <th>ID </th>
                           <th>Name </th>
                           <th>Code </th>
                           <th>Offer On </th>
                           <th>Public </th>
                           <th>Validity </th>
                           <th>Discount type</th>
                           <th>Discount Amount</th>
                           <th>Limit Uses </th>
                           <th>Total Used </th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if ($list): ?>
                        <?php
                         $x = 1;
                          foreach ($list as $key): ?>
                        <tr>
                           <td class="center"><?php echo $x; ?></td>
                           <td class="center"><?= $key->heading; ?></td>
                           <td class="center"><?= $key->code; ?></td>
                           <td class="center">
                           <?php switch ($key->discount_on) {
                             case '1':
                                echo 'Puja';
                               break;
                             case '2':
                                echo 'Add Wallet';
                               break;
                             case '3':
                                echo 'Horoscope';
                               break;
                             case '4':
                                echo 'Astrologers';
                               break;
                             case '5':
                                echo 'Astrologers Horoscope';
                               break;
                             case '6':
                                echo 'Life Prediction';
                               break;
                           
                            
                             
                             default:
                               
                               break;
                           } ?>  
                           </td> 

                           <td class="center">
                           <?php switch ($key->is_public) {
                             case '1':
                                echo 'Yes';
                               break;
                             case '2':
                                echo 'No';
                               break;
                            
                             
                             default:
                               
                               break;
                           } ?>  
                           </td>
                           <td class="center"><?= $key->expiry_date?></td>
                           <td class="center"><?= $key->discount_type; ?></td>
                           <td class="center"><?= $key->amount; ?></td>
                           <td class="center"><?= $key->uses_limit; ?></td>
                           <td class="center"><?= $key->total_used; ?></td>
                           <td class="center">
                              <?php if ($key->status == 1): ?>
                              
                              <span class='badge bg-green'>Active</span>
                                <?php else: ?>
                                   <span class='badge bg-red'>Inactive</span>
                                    <?php endif ?>
                           </td>
                           <td class="center">  

                            <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-flat">Action</button>
                                    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                      <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="min-width: 101px;">
                                      <li> <a class="btn btn-sm" href="<?php echo base_url();?>speedhuntson/edit_coupan/<?php echo $key->id; ?>">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                                      </li>
                                      <li>      <a class="btn btn-sm" href="<?php echo base_url();?>speedhuntson/delete_coupan/<?php echo $key->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>   
                                      </li>
                                    </ul>
                                  </div> 


                             
                          
                           </td>
                        </tr>
                        <?php  $x++;
                      endforeach ?>
                        <?php endif ?>
                     </tbody>
                     <tfoot>
                        <tr>
                         <th>ID </th>
                           <th>Name </th>
                           <th>Code </th>
                           <th>Offer On </th>
                           <th>Public </th>
                           <th>Validity </th>
                           <th>Discount type</th>
                           <th>Discount Amount</th>
                           <th>Limit Uses </th>
                           <th>Total Used </th>
                           <th>Status</th>
                           <th>Action</th>
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
<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   
   
   
    
</script>