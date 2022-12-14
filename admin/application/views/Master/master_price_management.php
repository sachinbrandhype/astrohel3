<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Master Price Management 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add Master Price Management</li>
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
              <ol class="breadcrumb">
            <li><!-- <a href="<?php echo base_url(); ?>Master_ctrl/add_master_minutes"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Master Price Management</b></button></a> -->
        
      </li>
   </ol>
            <!-- general form elements -->
            <div class="boxs">
            
               <!-- /.box-header -->
               <!-- form start -->
             
               <div class="box">
                  <div class="box-header with-border">
                  <!--    <h3 class="box-title">View Master Price Management Details</h3> -->
                  </div>
                  <div class="box-body">
                     <div class="col-md-12">
                        <table id="" class="table table-bordered table-striped datatable">
                           <thead>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th> Time</th>
                                 <th> For</th>
                                 <th> Price</th>
<!--                                  <th> Added On</th>
 -->                                 <th> Status</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 foreach($post as $key) {			 
                                 ?>
                              <tr>
                                 <td class="hidden"><?php echo $key->id; ?>
                                  </td>
                                  <td>
                                   <?php 
                                    $time_id= $key->time_id;
                                    $master_time = $this->db->where('id',$time_id)->get('master_time')->row();
                                     if ($master_time) {
                                       echo $master_time->minute." minute" ;
                                     }
                                     ?>
                                 </td>
                                
                                 <td class="center"><?php echo $key->for_ ; ?></td>
                                 <td class="center"><?php echo $key->price ; ?></td>
                               <!--   <td class="center"><?php echo $key->added_on; ?></td> -->
                                <td><span class="center label  <?php if($key->status == '1'){
                                 echo "label-success";
                                 }
                                 else{ 
                                 echo "label-warning"; 
                                 }
                                 ?>"><?php if($key->status == '1')
                                 {
                                 echo "enable";
                                 }
                                 else{ 
                                 echo "disable"; 
                                 }
                                 ?></span> 
                                 </td>
                                 <td class="center">	
                                  <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>Master_ctrl/edit_master_time/<?php echo $key->id; ?>">
                                Edit</a> 
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th> Time</th>
                                 <th> For</th>
                                 <th> Price</th>
                                 <!-- <th> Added On</th> -->
                                 <th> Status</th>
                                 <th>Action</th>
                              </tr>
                           </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.box -->
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>