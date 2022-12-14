<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
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
                  <table id="" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                          <th>Subject </th>
                          <th>Message </th>
                          <th>Added On </th>
                          <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach ($list as $card) {
                           ?>
                      
                        <tr>
                           <td class="center"><?php echo $card->subject; ?></td>
                           <td class="center"><?php echo $card->message; ?></td>
                          
                           
                           <td class="center"><?php echo date("d-m-Y h:i:s A",  strtotime($card->created_at)); ?></td>
                           <td>

                             <!--   <?php if( $card->status){?>
                              <a class="btn btn-sm btn-warning" href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/schedule_vacation_status/<?php echo $card->id; ?>/0"> 
                              <i class="fa fa-folder-open"></i> Deactivate </a>           
                              <?php
                                 }
                                 else
                                 {
                                 ?>
                              <a class="btn btn-sm btn-success" href="<?php echo base_url();?>astrologers_admin/Astrologers_admin/schedule_vacation_status/<?php echo $card->id; ?>/1"> 
                              <i class="fa fa-folder-o"></i> Activated </a>
                              <?php
                                 }
                                 ?>  -->

                              <!-- <a class="btn btn-sm btn-primary" data-target="#update_category_<?=$card->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Edit</a> -->
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>astrologers_admin/Astrologers_admin/delete_schedule_vacation/<?php echo $card->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                          <th>Subject </th>
                          <th>Message </th>
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
            <form enctype="multipart/form-data" method="post">
             

              <div class="form-group">
                <label for="">Subject<span style="color: red">*</span></label>
                                <textarea class="form-control" name="subject" required></textarea>

             </div>


              <div class="form-group">
                <label for="">Message<span style="color: red">*</span></label>
                <textarea class="form-control" name="message" required></textarea>
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
