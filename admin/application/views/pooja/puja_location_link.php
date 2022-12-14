<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url().'pooja';?>" >Lists</a></li>
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
            <li><a data-toggle='modal' data-target='#add_venue'><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add</b></button></a>
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
                           <th>#</th>
                           <th>Location </th>
                           <!-- <th>Price </th>
                           <th>Discount </th> -->
                           <th>Status </th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $i=1;
                           foreach ($results as $card) {
                           ?>
                        <!-- Modal -->
                        <div id="update_venue_<?=$card->id?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Puja Location</h4>
                                 </div>
                                 <div class="modal-body">
                                    <form method="post">
                                       <div class="form-group">
                                          <label>Locations<span style="color: red">*</span></label>
                                          <!-- js-example-basic-multiple -->
                                          <select required class="form-control select2 " name="location_id" placeholder="Locations">
                                             <option value="">Select..</option>
                                             <?php  
                                                foreach ($locations as $key => $v) {
                                                    ?>
                                             <option value="<?=$v->id?>"  <?=$v->id == $card->location_id ? 'selected' : ''?>><?=$v->name?></option>
                                             <?php
                                                }
                                                ?>
                                          </select>
                                       </div>
                                       <!-- <div class="form-group">
                                          <label>Price<span style="color: red">*</span></label>
                                          <input required type="number" min="1" value="<?=$card->prices?>"  name="prices" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Price" required>
                                       </div>
                                       <div class="form-group">
                                          <label>Discount Price</label>
                                          <input required type="number" min="0" value="<?=$card->discount_prices?>"  name="discount_prices" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Discount Price">
                                       </div>
                                       <div class="form-group">
                                          <label>Discount Comment in English</label>
                                          <textarea name="discount_comment" class="form-control"><?=$card->discount_comment?></textarea>
                                       </div> -->
                                       <div class="form-group">
                                          <label for="">Description in English</label>
                                          <textarea name="description" class="form-control"><?=$card->description?></textarea>
                                       </div>
                                       <!-- <div class="form-group">
                                          <label>Discount Comment in Hindi</label>
                                          <textarea name="discount_comment_hindi" class="form-control"><?=$card->discount_comment_hindi?></textarea>
                                       </div> -->
                                       <div class="form-group">
                                          <label for="">Description in Hindi</label>
                                          <textarea name="desc_in_hindi" class="form-control"><?=$card->desc_in_hindi?></textarea>
                                       </div>
                                       <!-- <div class="form-group">
                                          <label>Discount Comment in Gujrati</label>
                                          <textarea name="discount_comment_gujrati" class="form-control"><?=$card->discount_comment_gujrati?></textarea>
                                       </div> -->
                                       <div class="form-group">
                                          <label for="">Description in Gujrati</label>
                                          <textarea name="desc_in_gujrati" class="form-control"><?=$card->desc_in_gujrati?></textarea>
                                       </div>
                                       <div class="form-group">
                                          <label>Booking Cut Off (in minutes)<span style="color: red">*</span></label>
                                          <input required type="number" min="0" value="<?=$card->booking_time?>"  name="booking_time" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Booking Cut Off">
                                       </div>
                                       <div class="form-group">
                                          <label>Reshudule Cut Off (in minutes)<span style="color: red">*</span></label>
                                          <input required type="number" min="0" value="<?=$card->reshudule_time?>"  name="reshudule_time" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Reshudule Cut Off">
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
                                          <input type="hidden" name="category_id" value="<?=$card->id?>">
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
                           <td class="center"><?php echo $i++; ?></td>
                           <td class="center"><?php echo $card->location_name; ?></td>
                           <!-- <td class="center"><?php echo $card->prices; ?></td>
                           <td class="center"><?php echo $card->discount_prices; ?></td> -->
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
                           <td class="center"><?php echo date("d-m-Y h:i:s A",  strtotime($card->added_on)); ?></td>
                           <td>
                              <a class="btn btn-sm btn-primary" data-target="#update_venue_<?=$card->id?>" data-toggle="modal">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                              <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>pooja/puja_gallery_by_location/<?php echo $card->id ; ?>">
                              <i class="fa fa-fw fa-picture-o"></i>Gallery</a>
                             <!-- <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>pooja/puja_venue_link/<?php echo $card->id ; ?>">
                              <i class="fa fa-fw fa-location-arrow"></i>Venue</a>-->
                              <a class="btn btn-sm btn-warning" href="<?php echo base_url(); ?>pooja/time_slots_manage_by_location/<?php echo $card->id ; ?>">
                              <i class="fa fa-fw fa-clock-o"></i>Time Manage</a>
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>pooja/delete_pooja_location_link/<?php echo $card->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a><br><br>
                              <!-- <a href="<?php echo base_url(); ?>pooja/puja_commission/<?php echo $card->id ; ?>" class="btn btn-sm btn-primary" >
                              <i class="fa fa-fw fa-edit"></i>Commission</a>
                              <a href="<?php echo base_url(); ?>pooja/puja_location_priest/<?php echo $card->id ; ?>" class="btn btn-sm btn-primary" >
                              <i class="fa fa-fw fa-user"></i>Priest Manage</a> -->
                           </td>
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>#</th>
                           <th>Location </th>
                           <!-- <th>Price </th>
                           <th>Discount </th> -->
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
<!-- Modal -->
<div id="add_venue" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Puja Location & Other Data</h4>
         </div>
         <div class="modal-body">
            <form method="post">
               <div class="form-group">
                  <label>Puja Location<span style="color: red">*</span></label>
                  <select required class="form-control select2" name="location_id" placeholder="Select Puja Location" onchange="get_venue(this.value);" required>
                     <option value="">Select..</option>
                     <?php  
                        foreach ($locations as $key => $v) {
                           ?>
                     <option value="<?=$v->id?>"><?=$v->name?></option>
                     <?php
                        }
                        ?>
                  </select>
               </div>
			   <div class="form-group">
			   
			   <label for="">Venue<span style="color: red">*</span></label>
			   <select class="select2 js-example-basic-multiple form-control" id="venue" name="venue[]" multiple>
				 
			   </select> 
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   function get_venue(id){
	 $.ajax({ 
         url: "<?=base_url('/')?>pooja/get_venue", 
        
         data: {id:id},
         method: "post",
         success: function(data){
			var obj = JSON.parse(data);
			var option = "";
			for(var i = 0; i< obj.length;i++){
				option += "<option value='"+obj[i].id+"'>'"+obj[i].name+"'</option>"; 
			}
			$("#venue").html(option);
        
         }
   });
}
</script>