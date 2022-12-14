<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        View User Video 
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active">View User Video  Details</li>
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
            <li><a href="<?php echo base_url(); ?>User_video_ctrl/add_user_video"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add User Video </b></button></a>
           <span><a href="<?php echo base_url()?>User_video_ctrl/export_user_video">
            <button type="button" class="btn add-new float-right" style="float: right; margin-right: 10px; margin-left: 10px;">Export</button></a>

            <form method="post" action="<?=base_url('User_video_ctrl/user_video/')?>">
                           

                             <div class="col-md-4">           
                            <div class="form-group">
                            <label>Title</label>
                            <?php 
                            if ($title_data) 
                            {
                              ?>
                                <input type="text" id="title_data" name="title_data" value="<?php echo $title_data?>">
                            <?php
                            }
                            else
                            {
                              ?>
                              <input type="text" id="title_data" name="title_data">
                              <?php
                            }
                            ?>
                            <!-- <input type="data" name="doc_date" > -->
                        </div>
                     </div>

                        <div class="col-md-4">           
                            <div class="form-group">
                            <label>Date</label>
                            <?php 
                            if ($start_date) 
                            {
                              ?>
                                <input type="date" id="start" name="start_date" value="<?php echo $start_date?>">
                            <?php
                            }
                            else
                            {
                              ?>
                              <input type="date" id="start_date" name="start_date">
                              <?php
                            }
                            ?>
                            <!-- <input type="data" name="doc_date" > -->
                        </div>
                     </div>
                    
                      <div class="col-md-4">

                        <label>Date To</label>

                         <?php 
                            if ($end_date) 
                            {
                              ?>
                                <input type="date" id="start" name="end_date" value="<?php echo $end_date?>">
                            <?php
                            }
                            else
                            {
                              ?>
                              <input type="date" id="start" name="end_date">
                              <?php
                            }
                            ?>

                           

                     </div>
 <div class="col-md-4" style="margin-top: 25px;">
  <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Submit">&nbsp;&nbsp;

                         <input type="submit" name="reset" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Reset">
</div>

 <div class="col-md-4">
</div>
                        
                         </form>


            <!--  <a data-toggle="modal" data-target="#modal-info" data-backdrop="static"  data-keyboard="false"  class="btn btn-sm btn-primary">Import Lab Test</a>  -->
         </ol>

            <!-- /.box -->
            
         <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title"></h3>
               </div>      
             <div class="box-body">    
                <div class="col-md-12">
               <table id="" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th class="hidden">ID</th>
                           <th> Title</th>
                           <th> Thumbnail Image</th>
                           <th>Youtube Url</th>
                           
                           <th>Position</th>
                           <th>In App</th>
                            <th>Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        if ($lab_package) 
                        {
                        
                       
                           foreach($lab_package as $pack) {   

                           ?>
                          
                        <tr>
                           <td class="hidden"><?php echo $pack->id; ?></td>
                           <td class="center"><?php echo $pack->title; ?></td>

                            <td class="center"><img height="50" width="60" src="<?php echo base_url("uploads/video")."/".$pack->thumbnail_image;?>"></td>


                         <!--   <td class="center"><?php echo $pack->youtube_url; ?></td> -->
                            <td class="center"> <a class="btn btn-sm btn-primary" target=”_blank” href="<?=$pack->youtube_url?>">
                            Url Link</a></td>
                           <td class="center"><?php echo $pack->position; ?></td>
                           <td class="center"><?php if ($pack->in_app == 1) 
                           {
                             echo "Yes";
                           } 
                           else {
                            echo "No";
                           } ?></td>

                           <td class="center"><?php echo $pack->added_on ; ?></td>
                           <td class="center">

                               <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-flat">Action</button>
                                    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                      <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                      <li>   <a class="btn btn-sm" href="<?php echo base_url();?>User_video_ctrl/edit_user_video/<?php echo $pack->id; ?>">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                                      </li>
                                      <li>  <a class="btn btn-sm" href="<?php echo base_url();?>User_video_ctrl/delete_user_video/<?php echo $pack->id; ?>" onClick="return doconfirm()">
                               <i class="fa fa-fw fa-trash"></i>Delete</a> 
                                      </li>
                                    </ul>
                                  </div>



                      
                           </td>
                        </tr>
                        <?php
                           }
                            }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                     <th class="hidden">ID</th>
                           <th> Title</th>
                            <th> Thumbnail Image</th>
                           <th>Youtube Url</th>
                           
                           <th>Position</th>
                           <th>In App</th>
                              <th>Date</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                  </table>
                </div>
               </div>

                 <div class="row">
   <div class="col-md-8 col-md-offset-2">
      <!--  <?php echo $links; ?> -->
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <!--   <?php echo $links; ?> -->
            <div class="row">
               <div class="col-md-8 col-md-offset-2">
                  <?php echo $links; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
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

 <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import CSV Lab Test </h4>
              </div>
              <div class="modal-body">

               <form role="form" action="<?=base_url('lab_ctrl/import_lab_test')?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-12">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Lab Test File</label>
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
<script>
   
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   


    </script>
 