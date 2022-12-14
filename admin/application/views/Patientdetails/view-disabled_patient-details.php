<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
       Disabled User Details
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> Disabled User Details</li>
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
                  <h3 class="box-title">Disabled User Details</h3>
                 
               </div>
               <!-- /.box-header  class="table-responsive" -->
               <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="">S.No</th>
                           <th>Customer ID</th> 
                           <th>First Name</th> 
                           <th>Last Name</th>                                             
                           <th>Gender</th>   
                           <th>Mobile</th> 
                           <th>Email</th>
                           <th>Address</th>    
                           <th>Country</th>  
                           <th>State</th>  
                           <th>City</th> 
                           <th>Maritial Status</th> 
                           <th>Occupation</th> 
                           <th>Annual Income</th>   
                           <th>Status</th>                          
                           <th>Action</th>
                        </tr>
                     </thead> 
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
                           <td class="center"><?php echo $patient->last_name; ?></td>
                           <td class="center"><?php echo $patient->gender; ?></td><td class="center"><?php echo $patient->country_code.''.$patient->phone; ?></td>
                           <td class="center"><?php echo $patient->email; ?></td>
                           <td class="center"><?php echo $patient->address; ?></td>
                           <td class="center"><?php echo $patient->country; ?></td>
                           <td class="center"><?php echo $patient->state; ?></td>
                           <td class="center"><?php echo $patient->city; ?></td>
                           <td class="center"><?php echo $patient->marital_status; ?></td>
                           <td class="center"><?php echo $patient->occupation; ?></td>
                           <td class="center"><?php echo $patient->annual_income; ?></td><td><span class="center label  <?php if($patient->status == '1'){
                        echo "label-success";
                        }
                        else{ 
                        echo "label-warning"; 
                        }
                        ?>"><?php if($patient->status == '1')
                        {
                        echo "enable";
                        }
                        else{ 
                        echo "disable"; 
                        }
                        ?></span> 
                        </td>

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
                     <tfoot>
                        <tr>
                          <th class="">S.No</th>
                           <th>Customer ID</th> 
                           <th>First Name</th> 
                           <th>Last Name</th>                                             
                           <th>Gender</th>   
                           <th>Mobile</th> 
                           <th>Email</th>
                           <th>Address</th>    
                           <th>Country</th>  
                           <th>State</th>  
                           <th>City</th> 
                           <th>Maritial Status</th> 
                           <th>Occupation</th> 
                           <th>Annual Income</th>   
                           <th>Status</th>                          
                           <th>Action</th>
                        </tr>
                     </tfoot>
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
