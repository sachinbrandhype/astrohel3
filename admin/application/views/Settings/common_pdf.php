<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
             Pdf
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>Home</a></li>
            <li><a href="#">Pdf</a></li>
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
                <!--   <h3 class="box-title">Pdf Details</h3> -->
                </div><!-- /.box-header -->
                <!-- form start -->


                <div class="">
                  
                  <div class="box-body">
                     <div class="col-md-12">
                        <table id="" class="table table-bordered table-striped datatable">
                           <thead>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th>Pdf </th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              
                              <tr>
                                 <td class="center">

                                   <?php
                  if ($result->common_pdf) 
                  {
                  ?>
<div class="form-group has-feedback">
                   
                      <a target="_blank" href="<?=base_url('/').'uploads/common_pdf/'.$result->common_pdf?>">Click</a>
                  </div>
                  <?php
                  }
                  ?>

                  </td>
                                 <td class="center">  
                                    <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>Settings_ctrl/edit_common_pdf/<?php echo $result->id; ?>">
                                    <i class="fa fa-fw fa-edit"></i>Edit</a>
                                    
                                 </td>
                              </tr>
                              
                           </tbody>
                           <tfoot>
                              <tr>
                                 <th class="hidden">ID</th>
                                 <th>Pdf </th>
                                 <th>Action</th>
                              </tr>
                           </tfoot>
                        </table>
                     </div>
                  </div>
               </div>


              </div><!-- /.box -->
            </div>
            
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div>

	  