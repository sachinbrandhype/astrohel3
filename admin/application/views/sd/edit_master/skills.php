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
                           <th>Astrologer Name</th>
                           <th>Specialities </th>
                           <th>Experience </th>
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
                                    <form method="post">
                                     

                                        <div class="form-group">
                  <label for="">Astrologers Name<span style="color: red">*</span></label>
                  <select name="user_id" class="form-control" required >
                      <option value="">Select Astrologer</option>
                      <?php foreach($astrologers as $value) { ?>
                   <option value="<?=$value->id?>" <?=$card->user_id == $value->id ? "selected" : ""?>><?php echo $value->name;?></option>
                      <?php } ?>
                 </select>
               </div>
                <div class="form-group">
                  <label for="">Specialities<span style="color: red">*</span></label>
                  <select name="speciality_id" class="form-control" required >
                      <option value="">Select Specialitie</option>
                      <?php foreach($specialities as $value) { ?>
                   <option value="<?=$value->id?>" <?=$card->speciality_id == $value->id ? "selected" : ""?>><?php echo $value->name;?></option>
                      <?php } ?>
                 </select>
               </div>
                 <div class="form-group">
                  <label for="">Experience<span style="color: red">*</span></label>
                  <input type="number"  name="experience"  value="<?=$card->experience ?>" class="form-control" placeholder="experience" required>
                <input type="hidden" name="id" value="<?=$card->id?>">
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
                          
                           <td class="center"><?php 
                           $user_id = $card->user_id;
                           $ci = $this->db->query("select * from astrologers where id =  $user_id")->row();
                         //  echo $card->city_id ; 
                           if ($ci) 
                           {
                              echo $ci->name ; 
                           }

                           ?></td> <td class="center"><?php 
                           $speciality_id = $card->speciality_id;
                           $sp = $this->db->query("select * from specialities where id =  $speciality_id")->row();
                         //  echo $card->city_id ; 
                           if ($sp) 
                           {
                              echo $sp->name ; 
                           }

                           ?></td>
                            <td class="center"><?php echo $card->experience; ?></td>
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
                           <td class="center"><?php echo date("d-m-Y h:i:s A",  strtotime($card->created_at )); ?></td>
                           <td>
                              <a class="btn btn-sm btn-primary" data-target="#update_category_<?=$card->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>sd/edit_master/delete_skills/<?php echo $card->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>Astrologer Name</th>
                           <th>Specialities </th>
                           <th>Experience </th>
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
            <form method="post">
             

                <div class="form-group">
                  <label for="">Astrologers Name<span style="color: red">*</span></label>
                  <select name="user_id" class="form-control" required >
                      <option value="">Select Astrologer</option>
                      <?php foreach($astrologers as $value) { ?>
                   <option value="<?=$value->id?>"><?php echo $value->name;?></option>
                      <?php } ?>
                 </select>
               </div>
                <div class="form-group">
                  <label for="">Specialities<span style="color: red">*</span></label>
                  <select name="speciality_id" class="form-control" required >
                      <option value="">Select Specialitie</option>
                      <?php foreach($specialities as $value) { ?>
                   <option value="<?=$value->id?>"><?php echo $value->name;?></option>
                      <?php } ?>
                 </select>
               </div>
                 <div class="form-group">
                  <label for="">Experience<span style="color: red">*</span></label>
                  <input type="number"  name="experience" class="form-control" placeholder="experience" required>
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