<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        <?=$page_title?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active"><?=$page_title?> </li>
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
         <li><a data-toggle='modal' data-target='#add_plan'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add <?= $page_title ?></b></button></a>

            <!-- <li><a href="<?php echo base_url(); ?>sup$support_ctrl/add_website_sup$support"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Website sup$support</b></button></a> -->
         </ol>

            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title"><?=$page_title?></h3>
               </div>

               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Recharge Amount </th>  
                           <th>Benefit Amount </th>                                            
                           <th>For New User </th>                                            
                           <th>Position </th>                                           
                           <th>Date </th>                                           
                           <th>Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                        $i=1;
                           foreach($plans as $support) {        
                           ?>

                           
                        <div id="edit_plan_<?=$support->id?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit <?= $page_title ?></h4>
                                 </div>
                                 <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data">

                                       <input type="hidden" name="id" value="<?=$support->id?>">

                                       <div class="form-group">
                                          <label for="">Recharge Amount<span style="color: red">*</span></label>
                                          <input type="number" name="recharge" value="<?=$support->recharge?>" class="form-control" min="1" placeholder="Recharge Amount" required>
                                       </div>

                                       <div class="form-group">
                                          <label for="">Benefit Amount<span style="color: red">*</span></label>
                                          <input type="number" min="1" value="<?=$support->benefit?>" name="benefit" class="form-control" placeholder="Benefit Amount" required>
                                       </div>

                                       <div class="form-group">
                                          <label for="">Is for new user ?<span style="color: red">*</span></label>
                                          <select name="for_new_user" class="form-control">
                                             <option value="0"  <?=$support->for_new_user==0?'selected':''?>>No</option>
                                             <option value="1" <?=$support->for_new_user==1?'selected':''?>>Yes</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="">Position<span style="color: red">*</span></label>
                                          <input type="number" min="1" name="position" value="<?=$support->position?>" class="form-control" placeholder="Position" required>
                                       </div>
                                       <div class="form-group">
                                          <button type="submit" name="edit_plan" class="btn btn-primary">Save</button>
                                       </div>
                                    </form>
                                 </div>
                                 <div class="modal-footer">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <tr>
                           <td class="center"><?=$i++?></td>
                           <td class="center"><?=$support->recharge?></td>

                             <td class="center"><?= $support->benefit; ?></td>
                             <td class="center"><?= $support->for_new_user == 1 ? 'Yes' : 'No'; ?></td>
                             <td class="center"><?= $support->position; ?></td>

                             <td class="center"><?= date('Y-m-d g:ia',strtotime($support->created_at)); ?></td>

                           <td>
                           <a class="btn btn-primary" data-toggle='modal' data-target='#edit_plan_<?=$support->id?>'>
                           Edit</a> 
                           <a class="btn btn-danger" onclick="return confirm('are you sure?')" href="<?php echo base_url();?>walletPlan/delete_plan/<?php echo $support->id; ?>">
                           Delete</a> 
                             
                           </td>                                                
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     
                  </table>
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


<div id="add_plan" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add <?= $page_title ?></h4>
         </div>
         <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
               <div class="form-group">
                  <label for="">Recharge Amount<span style="color: red">*</span></label>
                  <input type="number" name="recharge" class="form-control" min="1" placeholder="Recharge Amount" required>
               </div>

               <div class="form-group">
                  <label for="">Benefit Amount<span style="color: red">*</span></label>
                  <input type="number" min="1" name="benefit" class="form-control" placeholder="Benefit Amount" required>
               </div>

               <div class="form-group">
                  <label for="">Is for new user ?<span style="color: red">*</span></label>
                  <select name="for_new_user" class="form-control">
                     <option value="0">No</option>
                     <option value="1">Yes</option>
                  </select>
               </div>

               
               <div class="form-group">
                  <label for="">Position<span style="color: red">*</span></label>
                  <input type="number" min="1" name="position" class="form-control" placeholder="Position" required>
               </div>
              
               <div class="form-group">
                  <button type="submit" name="add_plan" class="btn btn-primary">Add</button>
               </div>
            </form>
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>
<script>
  

    </script>
 