<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Admin Role
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> Admin Role</li>
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
		  <ol class="breadcrumb">
            <li><a data-toggle='modal' data-target='#add_venue'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Role</b></button></a>
         </ol>
         <div class="col-xs-12">
           

              <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>

            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"> Role Details</h3>
                 
               </div>
               <!-- /.box-header  class="table-responsive" -->
               <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="">S.No</th>
                           <th> Role Name</th>                       
                           <th>Date</th>                                             
                          
                         
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                         $x=$counter_for_index;
                         if ($result) 
                         {
                         
                           foreach($result as $value) {         
                           ?>
                        <tr>
                           <td><?php echo $x+1; ?></td>
                           <td class="center"><?php echo $value->name; ?></td>
                           
						   <td class="center"><?php echo ($value->created_at)?date('d-m-Y',strtotime($value->created_at)):""; ?></td>
                          
                        
                        </tr>
                        <?php
                         $x++;
                           }
                         }
                           ?>
                     </tbody>
                     
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

