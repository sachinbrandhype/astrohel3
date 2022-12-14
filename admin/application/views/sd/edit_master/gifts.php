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
            <li><a data-toggle='modal' data-target='#add_category'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add <?= $page_title ?></b></button></a>
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
                           <th>Name </th>
                           <th>Image </th>
                           <th>Price </th>
                           <th>Position  </th>
                           <th>Status </th>
                           <th>Added On </th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach ($list as $card) {
                           ?>
                        <!-- Modal -->
                        <div id="update_category_<?=$card->id?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit <?= $page_title ?></h4>
                                 </div>
                                 <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data">
                                       <div class="form-group">
                                          <label for="">Name<span style="color: red">*</span></label>
                                          <input type="text" name="name" value="<?=$card->name?>" class="form-control" placeholder="Name" required>
                                          <input type="hidden" name="id" value="<?=$card->id?>">
                                       </div>
                                       <div class="form-group">
                                          <label for="">Position <span style="color: red">*</span></label>
                                          <input type="number" name="position" value="<?=$card->position?>"  min ="0" class="form-control" placeholder="Position" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="">Price<span style="color: red">*</span></label>
                                         <input type="number" name="price" value="<?=$card->price?>"  min ="0" class="form-control" placeholder="price" required>
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
                                          <label for="">Image<span style="color: red">*</span></label>
                                          <input type="file" id="files" name="image" class="form-control" placeholder="Name">
                                          <input type="hidden" name="old_image" value="<?=$card->image?>">
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
                           <td class="center"><?php echo $card->name; ?></td>
                            <td class="center"><img src="<?=base_url('uploads/gift/'.$card->image)?>" height="100" width="100"></td>
                        
                          
                              <td class="center"><?php echo $card->price; ?></td>   
                              <td class="center"><?php echo $card->position; ?></td>   
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
                              <a class="btn btn-sm btn-primary" data-target="#update_category_<?=$card->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>sd/edit_master/delete_gifts/<?php echo $card->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>Name </th>
                             <th>Image </th>
                           <th>Price </th>
                           <th>Position  </th>
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
<div id="add_category" class="modal fade" role="dialog">
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
                  <label for="">Name<span style="color: red">*</span></label>
                  <input type="text" name="name" class="form-control" placeholder="Name" required>
               </div>

                    <div class="form-group">
                  <label for="">Image<span style="color: red">*</span></label>
                  <input type="file" id="files" name="image" class="form-control" placeholder="Name" required>
               </div>
               <div class="form-group">
                  <label for="">Position<span style="color: red">*</span></label>
                  <input type="number" min="1" name="position" class="form-control" placeholder="Name" required>
               </div>
               <div class="form-group">
                  <label for="">Price<span style="color: red">*</span></label>
                  <input type="number" min="1" name="price" class="form-control" placeholder="price" required>
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