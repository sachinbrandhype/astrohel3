<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Admin List
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> Admin List</li>
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
            <li><a data-toggle='modal' data-target='#add_category'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add <?= $page_title ?></b></button></a>
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
                  <h3 class="box-title"> User Details</h3>
                 
               </div>
               <!-- /.box-header  class="table-responsive" -->
               <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="">S.No</th>
                           <th> Name</th>                               
                           <th>Email</th>                                             
                           <th>Mobile</th>                                             
                           <th>Role</th>                                             
                           <th>Date</th>                                             
                           <th>Action</th>                                             
                          
                         
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                         $x=$counter_for_index;
                         if ($result) 
                         {
                         
                           foreach($result as $value) {         
                           ?>

                             <div id="update_category_<?=$value->id?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit <?= $page_title ?></h4>
                                 </div>
                                 <div class="modal-body">
                                    <form method="post">
                   
               
                                      <div class="form-group">
                                       <label for="">Role<span style="color: red">*</span></label>
                                       <select name="user_type" class="form-control" required >
                                           <option value="">Select Role</option>
                                           <?php foreach($role as $value1) { ?>
                                        <option value="<?=$value1->id?>" <?=$value->user_type == $value1->id ? "selected" : ""?>><?php echo $value1->name;?></option>
                                           <?php } ?>
                                      </select>
                                    </div>
                                      <div class="form-group">
                                       <label for="">Username<span style="color: red">*</span></label>
                                       <input type="text"  name="username" value="<?=$value->username ?>"  class="form-control" placeholder="Username" required>
                                         <input type="hidden" name="id" value="<?=$value->id?>">
                                    </div>
                                      <div class="form-group">
                                       <label for="">Email<span style="color: red">*</span></label>
                                       <input type="email"  name="email" value="<?=$value->email ?>"  class="form-control" placeholder="Email" required>
                                    </div>
                                    
                                      <div class="form-group">
                                       <label for="">Mobile<span style="color: red">*</span></label>
                                       <input type="number"  name="mobile" value="<?=$value->mobile ?>"  class="form-control" placeholder="Mobile" required>
                                    </div>



                                       <div class="form-group">
                                          <label for="">Status<span style="color: red">*</span></label>
                                          <select name="status" class="form-control" required>
                                             <option value="">Select</option>
                                             <option value="1" <?=$value->status == 1 ? 'selected' : ''?>>Active</option>
                                             <option value="0" <?=$value->status == 0 ? 'selected' : ''?>>Disable</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <button type="submit" name="update_category" class="btn btn-primary">Update</button>
                                       </div>
                                    </form>
                                 </div>
                                 <div class="modal-footer">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <tr>
                           <td><?php echo $x+1; ?></td>
                           <td class="center"><?php echo $value->username; ?></td>
                           <td class="center"><?php echo $value->email; ?></td>
                           <td class="center"><?php echo $value->mobile; ?></td>
                           <td class="center"><?php echo $value->name; ?></td>
						   <td class="center"><?php echo ($value->added_on)?date('d-m-Y',strtotime($value->added_on)):""; ?></td>
                             <td>
                              <a class="btn btn-sm btn-primary" data-target="#update_category_<?=$value->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>Admin_detailsview/delete_admin/<?php echo $value->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>
                           </td>
                        
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
<div id="add_category" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add <?= $page_title ?></h4>
         </div>
         <div class="modal-body">
            <form method="post">
             

           
                <div class="form-group">
                  <label for="">Role<span style="color: red">*</span></label>
                  <select name="user_type" class="form-control" required >
                      <option value="">Select Role</option>
                      <?php foreach($role as $value1) { ?>
                   <option value="<?=$value1->id?>"><?php echo $value1->name;?></option>
                      <?php } ?>
                 </select>
               </div>
                 <div class="form-group">
                  <label for="">Username<span style="color: red">*</span></label>
                  <input type="text"  name="username" class="form-control" placeholder="Username" required>
               </div>
                 <div class="form-group">
                  <label for="">Email<span style="color: red">*</span></label>
                  <input type="email"  name="email" class="form-control" placeholder="Email" required>
               </div>
                 <div class="form-group">
                  <label for="">Password<span style="color: red">*</span></label>
                  <input type="password"  name="password" class="form-control" placeholder="Username" required>
               </div>
                 <div class="form-group">
                  <label for="">Mobile<span style="color: red">*</span></label>
                  <input type="number"  name="mobile" class="form-control" placeholder="Mobile" required>
               </div>

               <div class="form-group">
                  <label for="">Status<span style="color: red">*</span></label>
                  <select name="status" class="form-control" required>
                     <option value="">Select</option>
                     <option value="1">Active</option>
                     <option value="0">Disable</option>
                  </select>
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


