<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url().$breadcrumb;?>" >Lists</a></li>
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
            <li><a data-toggle='modal' data-target='#add_venue'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add</b></button></a>
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
                           <th>#</th>
                           <th>Role </th>
                           <th>Commisssion type </th>
                           <th>Commisssion value </th>
                           <th>Added On</th>
                           <th>Status </th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $i=1;
                           foreach ($results as $card) {
                           ?>
                        <!-- Modal -->
                        <div id="update_venue_<?=$card->id?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit</h4>
                                 </div>
                                 <div class="modal-body">
                                    <form method="post">
                                       <div class="form-group">
                                          <label for="">Role<span style="color: red">*</span></label>
                                          <select name="role" class="form-control" required>
                                          <option value="">Select</option>
                                          <option value="1" <?=$card->role == 1 ? 'selected' : ''?>>Agent</option>
                                          <option value="2" <?=$card->role == 2 ? 'selected' : ''?>>Enterprise Agent</option>
                                          <option value="3" <?=$card->role == 3 ? 'selected' : ''?>>Priest</option>
                                          <option value="4" <?=$card->role == 4 ? 'selected' : ''?>>Supervisor</option>
                                          </select>
                                          <input type="hidden" name="location_id" value="<?=$location_id?>">
                                       </div>
                                       <div class="form-group">
                                          <label for="">Type<span style="color: red">*</span></label>
                                          <select name="type" class="form-control" required>
                                          <option value="">Select</option>
                                          <option value="percentage" <?=$card->type == 'percentage' ? 'selected' : ''?>>Percentage</option>
                                          <option value="flat" <?=$card->type == 'flat' ? 'selected' : ''?>>Flat</option>
                                          <option value="later" <?=$card->type == 'later' ? 'selected' : ''?>>Later</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label>Commission Value<span style="color: red">*</span></label>
                                          <input required type="number" min="1" value="<?=$card->value?>"  name="value" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Commission Value" required>
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
                                          <input type="hidden" name="category_id" value="<?=$card->id?>">
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
                           <td class="center"><?php echo $i++; ?></td>
                           <td class="center">
                               <?php if ($card->role == 1): ?>
                                   Agent
                               <?php elseif ($card->role == 2): ?>
                                    Enterprise Agent
                                <?php elseif ($card->role == 3): ?>
                                    Priest
                                <?php elseif ($card->role == 4): ?>
                                    Supervisor
                               <?php endif ?>
                           </td>
                           <td class="center"><?php echo ucfirst($card->type); ?></td>
                           <td class="center"><?php echo $card->value; ?></td>
                           <td class="center"><?php echo $card->added_on; ?></td>
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
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>pooja/delete_pooja_commission_link/<?php echo $card->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a> 
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>#</th>
                           <th>Role </th>
                           <th>Commisssion type </th>
                           <th>Commisssion value </th>
                           <th>Added On</th>
                           <th>Status </th>
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
            <h4 class="modal-title">Add</h4>
         </div>
         <div class="modal-body">
            <form method="post">
               <div class="form-group">
                  <label for="">Role<span style="color: red">*</span></label>
                  <select name="role" class="form-control" required>
                  <option value="">Select</option>
                  <option value="1">Agent</option>
                  <option value="2">Enterprise Agent</option>
                  <option value="3">Priest</option>
                  <option value="4">Supervisor</option>
                  </select>
                  <input type="hidden" name="puja_location_id" value="<?=$location_id?>">
               </div>
               <div class="form-group">
                  <label for="">Type<span style="color: red">*</span></label>
                  <select name="type" class="form-control" required>
                  <option value="">Select</option>
                  <option value="percentage">Percentage</option>
                  <option value="flat">Flat</option>
                  <option value="later">Later</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Commisssion value<span style="color: red">*</span></label>
                  <input value="0" required type="number" min="0"  name="value" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Commisssion value">
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