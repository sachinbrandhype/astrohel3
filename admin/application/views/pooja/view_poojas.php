<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?=$page_title?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active"><?=$page_title?></li>
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
               <li><a href="<?php echo base_url(); ?>pooja/add_pooja"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Pooja</b></button></a>
            </ol>
         <div class="col-xs-12">

         <div class="row">
   
                  <div class="col-md-2">
                     <form method="get">
                        <input type="search" value="<?=isset($_GET['search']) ? $_GET['search'] : ''?>" name="search" placeholder="Search" class="form-control">
                        <br />
                        <input type="submit" value="Search" class="btn btn-sm btn-danger">
                        <a href="<?=base_url('pooja')?>" class="btn btn-sm btn-warning">Reset</a>

                     </form>

                  </div>

            </div>


            <!-- /.box -->
            <div class="box">
               <div class="box-header">

               </div>

               <!-- /.box-header -->
               <div class="box-body">
                  <table  class="table table-bordered table-striped">
                     <thead>
                        <tr>
                        <th>#</th>
                           <th>Name in English </th>
                           <th>Name in Hindi </th>
                           <th>Name in Gujrati </th>
                           <th>Price </th>
                           <th>Discount Price </th>
                           <th>Booking Type</th>
                           <th>Image </th>
                           <th>Position </th>
                           <th>Status </th>
                           <th>Added On </th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php  $count =(($page_no-1)* $per_page+ 1); ?>

                        <?php
                        foreach ($results as $card) {
                        ?>
                           <tr>
                           <td class="center"><?php echo $count++; ?></td>

                              <td class="center"><?php echo $card->name; ?></td>
                              <td class="center"><?php echo $card->name_in_hindi; ?></td>
                              <td class="center"><?php echo $card->name_in_gujrati; ?></td>
                               <td class="center"><?php echo $card->price; ?></td>
                                <td class="center"><?php echo $card->discount_price; ?></td>
                              <td class="center">
                                 <?php if ($card->pooja_type == 0): ?>
                                    None
                                 <?php elseif ($card->pooja_type == 1): ?>
                                    Online Booking
                                 <?php elseif ($card->pooja_type == 2): ?>
                                    Ground Booking 
                                 <?php elseif ($card->pooja_type == 3): ?>
                                    Online & Ground Booking   
                                 <?php endif ?>

                              </td>


                              <td class="center">
                              <img src="<?=base_url().'uploads/puja/'.$card->image?>" style="width:60px" alt="<?=$card->name?>">   
                              </td>
                              <!-- <td class="center"><?php echo $card->multiple_location; ?></td> -->
                              <!-- <td class="center"><?php echo $card->price; ?></td> -->
                              <td class="center"><?php echo $card->position; ?></td>

                           <td><span class="center label  <?php if($card->status == '1'){
                              echo "label-success";
                              }
                              else{ 
                              echo "label-warning"; 
                              }
                              ?>"><?php if($card->status == '1')
                              {
                              echo "Activated ";
                                      }
                                      else{ 
                                      echo "Deactivated "; 
                              }
                              ?></span> 
                           </td>
                              <td class="center"><?php echo date("d-m-Y h:i:s A",  strtotime($card->added_on)); ?></td>

                              <td>
                                 <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>pooja/edit_pooja/<?php echo $card->id ; ?>">
                                    <i class="fa fa-fw fa-edit"></i>Edit</a>

                                 <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>pooja/clone_pooja/<?php echo $card->id ; ?>">
                                    <i class="fa fa-fw fa-edit"></i>Clone</a>

                                <!-- <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>pooja/puja_gallery/<?php echo $card->id ; ?>">
                                    <i class="fa fa-fw fa-picture-o"></i>Gallery</a>-->

                                 <a class="btn btn-sm btn-warning" href="<?php echo base_url(); ?>pooja/puja_location_link/<?php echo $card->id ; ?>">
                                    <i class="fa fa-fw fa-map-marker"></i>Locations</a>
                              <!--   <a href="<?php echo base_url(); ?>pooja/puja_commission/<?php echo $card->id ; ?>" class="btn btn-sm btn-primary" > 
                                 <i class="fa fa-fw fa-edit"></i>Commission</a>
                                  <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>pooja/datewisetime_list/<?php echo $card->id ; ?>">
                                    <i class="fa fa-fw fa-calendar"></i>DateWise Time</a> -->

                                     <?php if( $card->status){?>
                              <a class="btn btn-sm btn-warning" href="<?php echo base_url();?>pooja/puja_status/<?php echo $card->id; ?>/0"> 
                              <i class="fa fa-folder-open"></i> Deactivate </a>           
                              <?php
                                 }
                                 else
                                 {
                                 ?>
                              <a class="btn btn-sm btn-success" href="<?php echo base_url();?>pooja/puja_status/<?php echo $card->id; ?>/1"> 
                              <i class="fa fa-folder-o"></i> Activated </a>
                              <?php
                                 }
                                 ?>

                                 <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>pooja/delete_pooja/<?php echo $card->id; ?>" onClick="return doconfirm()">
                                    <i class="fa fa-fw fa-trash"></i>Delete</a>
                              </td>
                           </tr>
                        <?php
                        }
                        ?>
                     </tbody>
                     <tfoot>
                        <tr>
                       <th>#</th>
                           <th>Name in English </th>
                           <th>Name in Hindi </th>
                           <th>Name in Gujrati </th>
                           <th>Price </th>
                           <th>Discount Price </th>
                           <th>Booking Type</th>
                           <th>Image </th>
                           <th>Position </th>
                           <th>Status </th>
                           <th>Added On </th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                  </table>
                  <div class="row">
                     <div class="col-md-12">
                        <?php echo $links; ?>
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
<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
</script>