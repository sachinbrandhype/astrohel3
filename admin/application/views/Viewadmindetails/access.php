<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Access Management
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> Access</li>
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
		
         <div class="col-xs-6">
           

              <div class="row">
               <div class="col-md-6">
                  <?php echo $links; ?>
               </div>
            </div>

            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Access Details</h3>
                 
               </div>
               <!-- /.box-header  class="table-responsive" -->
               <div class="box-body table-responsive">
			    <form role="form" method="post" class="validate" enctype="multipart/form-data">
                  <select name="role" class="form-control" onchange="this.form.submit()">
					<option value="">Select Role</option>
					<?php foreach($result as $value) {  ?>
					<option value="<?php echo $value->id;?>" <?php echo ($role_id == $value->id) ? "selected" : ""?>><?php echo $value->name;?></option>
					<?php } ?>
				  </select><br> 
				  </form>
				  <form role="form" method="post" class="validate" enctype="multipart/form-data">
						<div class="form-group">
						<input type="hidden" name="role_id" value="<?php echo $role_id; ?>">
                                <?php foreach($side_bar_list as $per)  {
									$mid= $per->id;
                                    $patient =$this->db->get_where('permissions',array('role_id'=>@$role_id,'menu_id'=>$mid))->row();
									$c = "";
									if($patient) {
										$c = "checked";
									}
                                    ?>
                                <div >
								<input type="hidden" class="form-control" name="menu_id[]" value="<?php echo $per->id; ?>">
                                  <input type="checkbox" name="menu<?php echo $per->id; ?>" id="sidebar_name" value="<?php echo $per->id; ?>" <?php echo $c; ?> >
                               
                               <?php echo $per->sidebar_name; ?> 
								<br> 
								
                                  </div><br>
                                  <?php } ?>
                                
                            </div>
                            
							<button type="submit" name="submit" value="submit" class="btn btn-success"> Save</button>
                           
                    </div>
                    </form>
				  
				  
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

<div id="add_venue" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Role</h4>
         </div>
         <div class="modal-body">
            <form method="post">
               <div class="form-group">
                  <label for="">Name<span style="color: red">*</span></label>
                  <input type="text" name="name" class="form-control" placeholder="Name" required>
               </div>
               
               
               <div class="form-group">
                  <button type="submit" name="save_category" class="btn btn-primary">Add</button>
               </div>
            </form>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>

