<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active"><?= $page_title ?></li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <?php
               if ($this->session->flashdata('message')) {
                   $message = $this->session->flashdata('message');
               ?>
            <div class="alert alert-<?php echo $message['class']; ?>">
               <button class="close" data-dismiss="alert" type="button">x</button>
               <?php echo $message['message']; ?>
            </div>
            <?php
               }
               ?>
         </div>
         <ol class="breadcrumb">
            <li><a data-toggle='modal' data-target='#add_venue'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add <?=$Main?></b></button></a>
         </ol>
         <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th>S.no# </th>
                           <th>Name </th>
                           <th>Email </th>
                           <th>Mobile </th>
                           <th>Status </th>
                           <th>Added On </th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $i=1;foreach ($results as $card) {
                           ?>
                        <!-- Modal -->
                        <div id="update_venue_<?=$card->id?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit <?=$Main?></h4>
                                 </div>
                                 <div class="modal-body">
                                    <form method="post">
                                       <div class="form-group">
                                          <label for="">Name<span style="color: red">*</span></label>
                                          <input type="text" name="username" value="<?=$card->username?>" class="form-control" placeholder="Name" required>
                                          <input type="hidden" name="category_id" value="<?=$card->id?>">
                                       </div>
                                       <div class="form-group">
                                          <label for="">Email<span style="color: red">*</span></label>
                                          <input type="email" name="email" value="<?=$card->email?>" class="form-control" placeholder="Email" required>
                                       </div>
                                       <input type="hidden" name="id" value="<?=$card->id?>">
                                       <div class="form-group">
                                          <label for="">Mobile<span style="color: red">*</span></label>
                                          <input type="number" name="mobile" value="<?=$card->mobile?>" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" class="form-control" placeholder="Mobile Number" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="">Status<span style="color: red">*</span></label>
                                          <select name="status" class="form-control" required>
                                             <option value="">Select</option>
                                             <option value="1" <?=$card->status == 1 ? 'selected' : ''?>>Active</option>
                                             <option value="0" <?=$card->status == 0 ? 'selected' : ''?>>Disable</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <button type="submit" name="update_agent" class="btn btn-primary">Update</button>
                                       </div>
                                    </form>
                                 </div>
                                 <div class="modal-footer">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div id="update_venue_change_pwd<?=$card->id?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Password Update</h4>
                                 </div>
                                 <div class="modal-body">
                                    <form method="post">
                                       <div class="form-group">
                                          <label for="">Password<span style="color: red">*</span></label>
                                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                                          <input type="hidden" name="id" value="<?=$card->id?>">
                                       </div>
                                       <div class="form-group">
                                          <button type="submit" name="update_password" class="btn btn-primary">Update</button>
                                       </div>
                                    </form>
                                 </div>
                                 <div class="modal-footer">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <tr>
                           <td class="center"><?=$i?></td>
                           <td class="center"><?php echo $card->username; ?></td>
                           <td class="center"><?php echo $card->email; ?></td>
                           <td class="center"><?php echo $card->mobile; ?></td>
                           <td><span class="center label  <?php if ($card->status == '1') {
                              echo "label-success";
                              } else {
                              echo "label-warning";
                              }
                              ?>"><?php if ($card->status == '1') {
                              echo "Active";
                              } else {
                              echo "disable";
                              }
                              ?></span>
                           </td>
                           <td class="center"><?php echo date("d-m-Y h:i:s A",  strtotime($card->added_on)); ?></td>
                           <td>
                              <a class="btn btn-sm btn-primary" data-target="#update_venue_<?=$card->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                              <a class="btn btn-sm btn-primary" data-target="#update_venue_change_pwd<?=$card->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Change Password</a>
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>agent/delete_agent/<?php echo $card->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>
                           </td>
                        </tr>
                        <?php
                          $i++; }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>S.no# </th>
                           <th>Name </th>
                           <th>Email </th>
                           <th>Mobile </th>
                           <th>Status </th>
                           <th>Added On </th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
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
<!-- Modal -->
<div id="add_venue" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add <?=$Main?></h4>
         </div>
         <div class="modal-body">
            <form method="post">
               <div class="form-group">
                  <label for="">Name<span style="color: red">*</span></label>
                  <input type="text" name="username" class="form-control" placeholder="Name" required>
               </div>
               <div class="form-group">
                  <label for="">Email<span style="color: red">*</span></label>
                  <input type="email" name="email" class="form-control" placeholder="Email" required>
               </div>
               <div class="form-group">
                  <label for="">Mobile<span style="color: red">*</span></label>
                  <input type="number" name="mobile" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" class="form-control" placeholder="Mobile Number" required>
               </div>
               <div class="form-group">
                  <label for="">Password<span style="color: red">*</span></label>
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
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
<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
</script>