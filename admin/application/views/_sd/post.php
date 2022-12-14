<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Post 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-houzz" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add Post</li>
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
            <!-- general form elements -->
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title"> Add Post </h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="<?=base_url('affiliate_ctrl/add_post')?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                     <div class="col-md-12">
                        <div class="form-group has-feedback">
                           <label for="exampleInputEmail1">Post Name</label>
                           <input type="text" class="form-control required" data-parsley-trigger="change" data-parsley-minlength="2"  required="" name="name"  placeholder="Post Name">
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
                     <h3 class="box-title">View Post Details</h3>
                  </div>
                  <div class="box-body">
                     <div class="col-md-12">
                        <table id="" class="table table-bordered table-striped datatable">
                           <thead>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th>Post Name</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 foreach($post as $key) {			 
                                 ?>
                              <tr>
                                 <td class="hidden"><?php echo $key->id; ?></td>
                                 <td class="center"><?php echo $key->name; ?></td>
                                 <td class="center">	

                                    <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-flat">Action</button>
                                    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                      <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="min-width: 101px;">
                                      <li>
                                    <a class="btn btn-sm" href="<?php echo base_url();?>Affiliate_ctrl/edit_post/<?php echo $key->id; ?>">
                                    <i class="fa fa-fw fa-edit"></i>Edit</a>  
                                      </li>
                                      <li>    <a class="btn btn-sm " href="<?php echo base_url();?>Affiliate_ctrl/delete_post/<?php echo $key->id; ?>" onClick="return doconfirm()">
                                    <i class="fa fa-fw fa-trash"></i>Delete</a>     
                                      </li>
                                    </ul>
                                  </div> 


                                  
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th>Post Name</th>
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