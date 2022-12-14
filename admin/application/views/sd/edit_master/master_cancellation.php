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
                           <th>For </th>
                           <th> < 12 hours </th>
                           <th> >12 hours and < 24 hours  </th>
                           <th> > 24 hours</th>
                           <th> Action</th>
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
                                    <form method="post">
                                       <div class="form-group">
                                          <label for="">< 12 hours<span style="color: red">*</span></label>
                                          <input type="number" min="0" name="less_than_12_hours" value="<?=$card->less_than_12_hours?>" class="form-control" placeholder="< 12 hours" required>
                                          <input type="hidden" name="id" value="<?=$card->id?>">
                                       </div>
                                       <div class="form-group">
                                          <label for="">>12 hours and < 24 hours<span style="color: red">*</span></label>
                                          <input type="number" min="0" name="between_12_to_24_hours" value="<?=$card->between_12_to_24_hours?>" class="form-control" placeholder=">12 hours and < 24 hours" required>
                                       </div>

                                       <div class="form-group">
                                          <label for="">> 24 hours<span style="color: red">*</span></label>
                                          <input type="number" min="0" name="before_24_hours" value="<?=$card->before_24_hours?>" class="form-control" placeholder="> 24 hours" required>
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
                           <td class="center"><?php echo ucfirst($card->type); ?></td>
                           <td class="center"><?php echo $card->less_than_12_hours; ?></td>
                           <td class="center"><?php echo $card->between_12_to_24_hours; ?></td>
                           <td class="center"><?php echo $card->before_24_hours; ?></td>
                           <td>
                              <a class="btn btn-sm btn-primary" data-target="#update_category_<?=$card->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>For </th>
                           <th> < 12 hours </th>
                           <th> >12 hours and < 24 hours  </th>
                           <th> > 24 hours</th>
                           <th> Action</th>
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
            <form method="post">
               <div class="form-group">
                  <label for="">Name<span style="color: red">*</span></label>
                  <input type="text" name="name" class="form-control" placeholder="Name" required>
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