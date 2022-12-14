<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Time Limit 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add Time Limit </li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
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
         <div class="col-md-12">
            <ol class="breadcrumb">
            <li>
              <!--  <a data-toggle="modal" data-target="#modal-info" data-backdrop="static"  data-keyboard="false"  class="btn btn-sm btn-primary">Import Surgeries</a> 
               <a href="<?php echo base_url(); ?>Affiliate_ctrl/import_surgeries"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Import Surgeries</b></button></a>
            <span><a href="<?php echo base_url()?>Affiliate_ctrl/export_surgeries">
                  <button type="button" class="btn add-new float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button></a> -->
            </span>
         </ol>
            <!-- general form elements -->
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title"> Add Time Limit </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="<?=base_url('affiliate_ctrl/add_time_limit')?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-6">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Video Time</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="video_time"  placeholder="Video Time">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                         <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Chat Time</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="chat_time"  placeholder="Chat Time">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                         <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Audio Time</label>
                           <input type="number" class="form-control required" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="audio_time"  placeholder="Audio Time">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
               <div class="box">
                  <div class="box-header with-border">
                     <h3 class="box-title">View Complain Reason  Details</h3>
                  </div>
                  <div class="box-body">
                     <div class="col-md-12">
                      <table id="" class="table table-bordered table-striped datatable">
                           <thead>
                              <tr>
                                
                                 <th>Video Time</th>
                                 <th>Chat Time  </th>
                                 <th>Audio Time</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 foreach($time_limit as $key) {			 
                                 ?>
                              <tr>
                                
                                 <td class="center"><?php echo $key->video_time." Minute"; ?></td>
                                 <td class="center"><?php echo $key->chat_time." Minute"; ?></td>
                                 <td class="center"><?php echo $key->audio_time." Minute"; ?></td>
                                 <td class="center">	
                                    <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>Affiliate_ctrl/edit_time_limit/<?php echo $key->id; ?>">
                                    <i class="fa fa-fw fa-edit"></i>Edit</a>
                                    <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>Affiliate_ctrl/delete_time_limit/<?php echo $key->id; ?>" onClick="return doconfirm()">
                                    <i class="fa fa-fw fa-trash"></i>Delete</a> 
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <th>Video Time</th>
                                 <th>Chat Time  </th>
                                 <th>Audio Time</th>
                                 <th>Action</th>
                              </tr>
                           </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.box -->
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>

 <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import CSV Surgeries </h4>
              </div>
              <div class="modal-body">

               <form role="form" action="<?=base_url('affiliate_ctrl/import_surgeries')?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-12">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Surgeries File</label>
                           <input type="file" class="form-control required" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="name"  placeholder="Allergies Name">
                           <span class="glyphicon  form-control-feedback"></span>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>