<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        Notification
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active"> Notification Details</li>
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
            
         </ol>

            <!-- /.box -->
              <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>
         <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title"></h3>
               </div>      
             <div class="box-body">    
                <div class="col-md-12">
               <table id="" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name </th>
                            <th>User Number </th>
                           <th>Title</th>
                           <th>Notification</th>
                           <th>Type</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $x= 1;
                           foreach($lab_package as $pack) {   

                           ?>
                          
                        <tr>
                          <td><?php echo $x; ?></td>
                           <td class="center"><?php 
                              $patient_id= $pack->user_id;
                              $patient = $this->db->where('id',$patient_id)->get('user')->row();
                               if ($patient) {
                                 echo $patient->name;
                               }
                               ?>
                             </td>
                             <td class="center">
                              <?php 
                              $patient_id= $pack->user_id;
                              $patient = $this->db->where('id',$patient_id)->get('user')->row();
                               if ($patient) {
                                 echo $patient->phone;
                               }
                               ?></td>
                           <td class="center"><?php echo $pack->title; ?></td>
                           <td class="center"><?php echo $pack->notification; ?></td>
                           <td class="center"><?php echo ucfirst($pack->type);  ?></td>

                           
                        </tr>
                        <?php
                         $x++;
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                            <th>ID </th>
                            <th>User Name </th>
                            <th>User Number </th>
                           <th>Title</th>
                           <th>Notification</th>
                           <th>Type</th>
                        </tr>
                     </tfoot>
                  </table>
                </div>
               </div>

            <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
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

 <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import CSV Lab Test </h4>
              </div>
              <div class="modal-body">

               <form role="form" action="<?=base_url('lab_ctrl/import_lab_test')?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-12">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Lab Test File</label>
                           <input type="file" class="form-control required" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="name"  placeholder="Allergies Name">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
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
<script>
   
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   


    </script>
 