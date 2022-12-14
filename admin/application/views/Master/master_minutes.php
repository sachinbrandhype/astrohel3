<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Master Minutes 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add Master Minutes</li>
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
            <li><a href="<?php echo base_url(); ?>Master_ctrl/add_master_minutes"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Master Minutes</b></button></a>
        
      </li>
   </ol>
            <!-- general form elements -->
            <div class="boxs">
            
               <!-- /.box-header -->
               <!-- form start -->
             
               <div class="box">
                  <div class="box-header with-border">
                     <h3 class="box-title">View Master Minutes Details</h3>
                  </div>
                  <div class="box-body">
                     <div class="col-md-12">
                        <table id="" class="table table-bordered table-striped datatable">
                           <thead>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th> Minutes</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 foreach($post as $key) {			 
                                 ?>
                              <tr>
                                 <td class="hidden"><?php echo $key->id; ?></td>
                                 <td class="center"><?php echo $key->minute; ?></td>
                                 <td class="center">	
                                    
                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>Master_ctrl/delete_master_minutes/<?php echo $key->id; ?>" onClick="return doconfirm()">
                                    <i class="fa fa-fw fa-trash"></i>Delete</a> 
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th>Minutes</th>
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