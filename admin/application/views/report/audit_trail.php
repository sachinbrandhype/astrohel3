<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Audit Trail Report
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li class="active"> Audit Trail Report</li>
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
            <div class="boxs">
            
               <!-- /.box-header -->
               <!-- form start -->
             
               <div class="box">
                  <div class="box-header with-border">
                     <h3 class="box-title">Audit Trail Report</h3>
                  </div>
                  <div class="box-body">
                     <div class="col-md-12">
                        <div class="col-md-4">
							<select name="role" class="form-control">
								<option value="">--Select--</option>
							</select> 
						</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 
		 <div class="col-md-12">
              
            <!-- general form elements -->
            <div class="boxs">
            
               <!-- /.box-header -->
               <!-- form start -->
             
               <div class="box">
                  <div class="box-header with-border">
                     <h3 class="box-title">Audit Trail Report</h3>
                  </div>
                  <div class="box-body">
                     <div class="col-md-12">
                        <table id="" class="table table-bordered table-striped datatable">
                           <thead>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th> Match Making Price</th>
                                 <th> Life Prediction Price</th>
                                 <th> Varshphal Pdf</th>
                                 <th> Medical Price</th>
                                 <th> Financial Price</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 foreach($post as $key) {			 
                                 ?>
                              <tr>
                                 <td class="hidden"><?php echo $key->id; ?></td>
                                 <td class="center"><?php echo $key->match_making_price; ?></td>
                                 <td class="center"><?php echo $key->life_prediction_price; ?></td>
                                 <td class="center"><?php echo $key->varshphal_pdf; ?></td>
                                 <td class="center"><?php echo $key->medical_price; ?></td>
                                 <td class="center"><?php echo $key->financial_price; ?></td>
                                 <td class="center">	
                                    
                                    <a class="btn btn-sm btn-success" href="<?php echo base_url();?>Master_ctrl/edit_master_price_list/<?php echo $key->id; ?>" >
                                    <i class="fa fa-fw fa-trash"></i>Edit</a> 

                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>Master_ctrl/delete_master_price_list/<?php echo $key->id; ?>" onClick="return doconfirm()">
                                    <i class="fa fa-fw fa-trash"></i>Delete</a> 
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                           
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