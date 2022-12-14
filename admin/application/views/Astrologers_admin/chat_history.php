<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>astrologers_admin/Astrologers_admin/astrologersdashboard/"><i class="fa fa-user-md"></i>Home</a></li>
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
           <!--  <li><a data-toggle='modal' data-target='#add_category'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add <?= $page_title ?></b></button></a> -->
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
                           <th>S.No </th>
                           <th>Type</th>
                           <th>User Name</th>
                           <th>Date & Time</th>
                           <th>Chat Duration(MM:SS)</th>

                           <th>Amount Charged</th>
                           <th>Chat details</th>
                        </tr>
                     </thead>
                     <tbody>

                        <tr>
                           <td class="center">1  </td>
                           <td class="center">Chat   </td>
                           <td class="center">Shubham   </td>
                           <td class="center">18-02-2021 07:19:32 AM   </td>
                              <td class="center">10:00:00    </td>
                                <td class="center">200   </td>
                           <td class="center">Chat details   </td>
                        </tr>

                        <tr>
                           <td class="center">2  </td>
                           <td class="center">Video   </td>
                           <td class="center">Rahul   </td>
                           <td class="center">19-02-202D1 07:19:32 AM   </td>
                           <td class="center">20:00:00    </td>
                           <td class="center">100   </td>
                           <td class="center">Video Link   </td>
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>S.No</th>
                            <th>Type</th>
                           <th>User Name</th>
                           <th>Date & Time</th>
                           <th>Chat Duration(MM:SS)</th>
                           <th>Amount Charged</th>
                           <th>Chat details</th>
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

<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
</script>