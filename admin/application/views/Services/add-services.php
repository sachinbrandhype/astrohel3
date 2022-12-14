<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Services
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
         <li class="active"> Services</li>
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
                  <h3 class="box-title"> Add Services </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                 <div class="box-body">                 
                     <div class="col-md-12">
                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Service Name</label>
                            <input type="text" class="form-control required" required name="service_name"  placeholder="Services Name">
                            <span class="glyphicon  form-control-feedback"></span>
                          </div> 
                   <div class="form-group has-feedback">
                        <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="1" checked>Active&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="0"> Inactive</div>
               </div> 
            </div>


				  <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Add</button>
                  </div>
				</form>
			</div>
			<div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">View Services Details</h3>
               </div>	   
				 <div class="box-body">    
				    <div class="col-md-12">
					<table id="" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="hidden">ID</th>
                           <th>Service Name</th>
						         <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach($data as $services) {			 
                           ?>
                        <tr>
                           <td class="hidden"><?php echo $services->id; ?></td>
                           <td class="center"><?php echo $services->service_name; ?></td>
                           <td class="center"><?=($services->status == 1)?'<button class="btn btn-sm btn-success">Active</button>':'<button class="btn btn-sm btn-danger">Inactive</button>'?></td>
                           <td class="center">	
							       <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>Services/edit_services/<?php echo $services->id; ?>">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
							       <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>Services/delete_services/<?php echo $services->id; ?>" onClick="return doconfirm()">
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
                           <th>Service Name</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                  </table>
				    </div>
				   </div>
				   </div>
				  </div>
               </form>
            </div>
            <!-- /.box -->
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>  
<body onload="initialize()">