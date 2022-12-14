<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
      <?=$page_title?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>pooja/">Lists</a></li>
         <li class="active"><?=$page_title?></li>
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
               <button class="close" data-dismiss="alert" type="button">x</button>
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
                  <h3 class="box-title"><?=$page_title?></h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <form role="form" action="" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
                  <div class="box-body">
                    
                     <div class="col-md-12">
					 <div class="col-md-6">
                        <div class="form-group">
                           <label>Name in English<span style="color: red">*</span></label>
                           <input required type="text" name="name" class="form-control" placeholder="Name in English" required>
                        </div>
                     </div>
					 <div class="col-md-6">
                        <div class="form-group">
                           <label>Name in Hindi<span style="color: red">*</span></label>
                           <input required type="text" name="name_in_hindi" class="form-control" placeholder="Name in Hindi" required>
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                           <label>Name in Gujrati<span style="color: red">*</span></label>
                           <input required type="text" name="name_in_gujrati" class="form-control" placeholder="Name in Gujrati" required>
                        </div>
                    </div>

                      <div class="col-md-6">
                         <div class="form-group">
                           <label>Category<span style="color: red">*</span></label>
                           <select required class="form-control" name="category_id" placeholder="Category" required>
                              <option value="">Select..</option>
                              <?php
                              if(!empty($pooja_category)){
                                 foreach ($pooja_category as $key => $value) {
                                    ?>
                                    <option value="<?=$value->id?>"><?=$value->name?></option>
                                    <?php
                                 }
                              }
                              ?>
                           </select>
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                           <label>God</label>
                           <select class="form-control select2 js-example-basic-multiple" name="gods[]" placeholder="Select Languages" multiple>
                              <?php foreach ($master_god as $keyg): ?>
                              <option value="<?=$keyg->id?>"><?=$keyg->name?></option>
                              <?php endforeach ?>
                           </select>
                        </div>
                  </div>
					<div class="col-md-6">
                        <div class="form-group">
                           <label>Temples</label>
                           <select class="form-control select2 js-example-basic-multiple" name="temples[]" placeholder="Select Languages" multiple>
                              <?php foreach ($master_temple as $keyt): ?>
                              <option value="<?=$keyt->id?>"><?=$keyt->name?></option>
                              <?php endforeach ?>
                           </select>
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                           <label>Price<span style="color: red">*</span></label>
                           <input required type="number" min="1"  name="price" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Price" required>
                        </div>
                    </div>
					
					<div class="col-md-6">
                        <div class="form-group">
                           <label>Can Book Puja</label>
                           <select name="can_book_puja" class="form-control">
								<option value="1">Yes</option>
								<option value="2">No</option>
							</select>
                        </div>
                    </div>
					<div class="col-md-6">
					<div class="form-group">
                           <label>Discount Type</label>
							<select name="discount_type" class="form-control">
								<option value="">Select Type</option>
								<option value="1">Fix</option>
								<option value="2">Percentage</option>
							</select>
                        </div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
                           <label>Discount Price</label>
                           <input required type="number" min="0" value="0" name="discount_price" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Discount Price">
                        </div>
					</div>
					<div class="col-md-6">
					<div class="form-group">
                           <label>Booking Cut Off Hour<span style="color: red">*</span></label>
                           <input required type="number" min="0"  name="booking_cut_of_hour" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Booking Cut Off Hour">
                        </div>
					</div> 
					<div class="col-md-6">
					<div class="form-group">
                           <label>Reschedule Cut Off Hour<span style="color: red">*</span></label>
                           <input required type="number" min="0"  name="reschedule_cut_of_hour" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Reschedule Cut Off Hour">
                        </div>
					</div> 
					<div class="col-md-6">
					<div class="form-group">
                           <label>Position<span style="color: red">*</span></label>
                           <input required type="number" min="0"  name="position" class="form-control" onkeyup="if(parseInt(this.value)<0){ this.value =0; return false; }" placeholder="Position">
                        </div>
					</div> 
					<div class="col-md-6">
						<div class="form-group">
                              <label for="">Status<span style="color: red">*</span></label>
                              <select name="status" class="form-control" required>
                                 <option value="">Select</option>
                                 <option value="1">Active</option>
                                 <option value="0">Disable</option>
                              </select>
                           </div>
						</div>
					
                        
						
						<div class="col-md-6">
							<div class="form-group">
                              <label for="">Image<span style="color: red">*</span></label>
                              <input type="file" name="image" onchange="selected_file_show(this);"  class="form-control" required>
                              <img style="display:none" id="blah" src="#" alt="your image" />
                           </div>
						</div>
						<div class="col-md-6">
							 <div class="form-group">
                              <label for="">Pooja Booking types<span style="color: red">*</span></label>
                              <select name="pooja_type" class="form-control" required>
                                 <option value="">Select</option>
                                 <option value="0">None</option>
                                 <option value="1">Online Booking</option>
                                 <option value="2">Ground Booking</option>
                                 <option value="3">Online & Ground Booking</option>

                              </select>
                           </div>
						</div>
                        <!--<div class="form-group">
                           <label for="">Discount Comment in English</label>
                           <textarea name="discount_comment" class="form-control"></textarea>
                        </div>

                         <div class="form-group">
                           <label for="">Discount Comment in Hindi</label>
                           <textarea name="discount_comment_hindi" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                           <label for="">Discount Comment in Gujrati</label>
                           <textarea name="discount_comment_gujrati" class="form-control"></textarea>
                        </div>--->
						<div class="container">
						<div class="row">
						<div class="col-md-3">
						<label for=""> Commission Role<span style="color: red">
							<select name="commission_role[]" class="form-control" required>
                                 <option value="">Select</option>
                                
                                 <option value="1">Priest</option>
                                 <option value="2">Enterprise</option>
                                 <option value="3">Agent</option>

                              </select>
						</div>
						
						<div class="col-md-3">
						<label for=""> Commission Type<span style="color: red">
							<select name="commission_type[]" class="form-control" required>
                                 <option value="">Select</option>
                                 <option value="1">Flat</option>
                                 <option value="2">Percentage</option>
                                 <option value="3">Later</option>

                              </select>  
						</div>
						<div class="col-md-3">
						<label for=""> Rate<span style="color: red">
							<input type="text" name="commission_rate[]" class="form-control" placeholder="Rate"> 
						</div>
						<div class="col-md-3">
								<br>
								<button type="button" name="add" id="add" class="btn btn-success">+ </button>
						</div>
						</div>
						</div>
						<div id="dynamic_field_a">
						</div>
						
						<!---<div class="col-md-6">
						<div class="form-group">
                           <label>Locations</label>
                           <select required class="form-control select2 js-example-basic-multiple" onchange="get_venue(this.value);" name="multiple_location" placeholder="Locations">
                              <option value="">Select..</option>
                             <?php  
                             foreach ($pooja_locations as $key => $v) {
                                ?>
                                <option value="<?=$v->id?>"><?=$v->name?></option>
                                <?php
                             }
                             ?>
                           </select>
                        </div>
                        </div>
						<div class="col-md-6">
						<div class="form-group">
                           <label>Venue</label>
                           <select class="form-control select2 js-example-basic-multiple" id="venue" name="venue[]" placeholder="Select Venue" multiple>
                             
                           </select>
                        </div>
                        </div>--> 

                        <div class="form-group">
                           <label for="">Description in English</label>
                           <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                           <label for="">Description in Hindi</label>
                           <textarea name="desc_in_hindi" id="desc_in_hindi" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                           <label for="">Description in Gujrati</label>
                           <textarea name="desc_in_gujrati" class="form-control"></textarea>
                        </div>
						
                     </div>
                     

                  </div>
                  <div class="box">
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- /.box -->
         </div>
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'description' );
    CKEDITOR.replace( 'desc_in_hindi' );
    CKEDITOR.replace( 'desc_in_gujrati' );
	
	var ii =1;
$("#add").click(function(){
	
	ii++;
	$("#dynamic_field_a").append('<div class="row" id="row'+ii+'" ><div class="col-md-3"><label for=""> Commission Role<span style="color: red"><select name="commission_role[]" class="form-control" required> <option value="">Select</option> <option value="1">Priest</option> <option value="2">Enterprise</option> <option value="3">Agent</option> </select></div><div class="col-md-3"><label for=""> Commission Type<span style="color: red"><select name="commission_type[]" class="form-control" required> <option value="">Select</option> <option value="1">Flat</option> <option value="2">Percentage</option> <option value="3">Later</option> </select> </div><div class="col-md-3"><label for=""> Rate<span style="color: red"><input type="text" name="commission_rate[]" class="form-control" placeholder="Rate"> </div><div class="col-md-3"><button type="button" name="remove" id="'+ii+'" class="btn btn-danger btn_remove">-</button></div></div>');
	
	
});

$(document).on('click','.btn_remove', function(){
	
	var button_id = $(this).attr("id");
	//alert(button_id);
	$('#row'+button_id+'').remove();
});

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
