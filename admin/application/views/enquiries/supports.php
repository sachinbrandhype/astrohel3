<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        User Support
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active">User Support</li>
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
            <!-- <li><a href="<?php echo base_url(); ?>sup$support_ctrl/add_website_sup$support"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Website sup$support</b></button></a> -->
         </ol>

            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">User Support</h3>
               </div>

               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th>Name </th>  
                           <th>Mobile </th>                                            
                           <th>Email </th>                                            
                           <th>Message </th>                                           
                           <th>Date </th>                                           
                           <th>Status </th>                                           
                           <th>Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                           foreach($data as $support) {        
                           ?>
                        <tr>
                           <td class="center"><?=$support->name?></td>

                             <td class="center"><?= $support->mobile; ?></td>
                             <td class="center"><?= $support->email; ?></td>
                             <td class="center"><?= $support->message; ?></td>
                             <td class="center"><?= date('Y-m-d g:ia',strtotime($support->added_on)); ?></td>

                           <td class="center">
                           <?php if( $support->status==0){?>
                              Pending           
                              <?php
                                 }
                                 else
                                 {
                                 ?>
                             Solved
                              <?php
                                 }
                                 ?>
                           </td>
                           <td>
                               <?php if($support->status==0) : ?>
                                <a class="btn btn-primary" onclick="return confirm('are you sure?')" href="<?php echo base_url();?>enquiries/solve_enquiry/<?php echo $support->id; ?>">
                               Is Solved ?</a>

                                <?php endif; ?>
                              <!-- <a class="btn btn-primary" href="<?php echo base_url();?>sup$support_ctrl/edit_website_sup$support/<?php echo $support->id; ?>">
                               Edit</a> 
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>sup$support_ctrl/delete_website_sup$support/<?php echo $support->id; ?>" onClick="return doconfirm()">
                               <i class="fa fa-fw fa-trash"></i>Delete</a>  -->
                           </td>                                                
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                        <th>Name </th>  
                           <th>Mobile </th>                                            
                           <th>Email </th>                                            
                           <th>Message </th>                                           
                           <th>Date </th>                                           
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
  

    </script>
 