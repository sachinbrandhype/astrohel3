<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        View Website Advertisment
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active">View Website advertisment Details</li>
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
            <li><a href="<?php echo base_url(); ?>banner_ctrl/add_website_advertisment"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add advertisment </b></button></a>
         </ol>

            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">View Website advertisment Details</h3>
               </div>

               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th>Image </th>  
                           <th>Title </th>                                            
                           <th>Sub Title </th>                                            
                           <th>Desc </th>                                            
                           <th>Position </th>                                            
                           <th>Status </th>                                           
                           <th>Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                           foreach($data as $banner) {        
                           ?>
                        <tr>
                           <td class="center"><img height="50" width="60" src="<?php echo base_url("uploads/advertisment")."/".$banner->image;?>"></td>

                             <td class="center"><?= $banner->title; ?></td>
                             <td class="center"><?= $banner->sub_title; ?></td>
                             <td class="center"><?= $banner->desc; ?></td>
                             <td class="center"><?= $banner->position; ?></td>

                           <td class="center">
                           <?php if( $banner->status==1){?>
                              <a class="btn btn-sm label-success" href="<?php echo base_url();?>Banner_ctrl/website_advertisment_status/<?php echo $banner->id; ?>"> 
                              <i class="fa fa-folder-open"></i> Active </a>           
                              <?php
                                 }
                                 else
                                 {
                                 ?>
                              <a class="btn btn-sm label-warning" href="<?php echo base_url();?>Banner_ctrl/website_advertisment_active/<?php echo $banner->id; ?>"> 
                              <i class="fa fa-folder-o"></i> Inactive </a>
                              <?php
                                 }
                                 ?>
                           </td>
                           <td>
                              <a class="btn btn-primary" href="<?php echo base_url();?>banner_ctrl/edit_website_advertisment/<?php echo $banner->id; ?>">
                               Edit</a> 
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>banner_ctrl/delete_website_advertisment/<?php echo $banner->id; ?>" onClick="return doconfirm()">
                               <i class="fa fa-fw fa-trash"></i>Delete</a> 
                           </td>                                                
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                            <th>Image </th>  
                           <th>Title </th>                                            
                           <th>Sub Title </th>                                            
                           <th>Desc </th>                                            
                           <th>Position </th>                                            
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
<script>
   
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   


    </script>
 