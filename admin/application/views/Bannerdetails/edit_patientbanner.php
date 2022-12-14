
<?php $id = $this->session->userdata('admin');  ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Main Banner 
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url(); ?>banner_ctrl/view_banner"> Edit Main Banner Details </a></li>
         <li class="active">Edit Main Banner</li>
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
  <form role="form"  method="post" action="<?php echo base_url('banner_ctrl/edit_banner')?>" id="patient banner_reg" data-parsley-validate="" class="validate" enctype="multipart/form-data" >
  
         <div class="col-md-12">
            <!-- general form elements -->             
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">Edit Main Banner </h3>
                  <div class="edituser" tabindex='1'></div>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
                <div class="box-body">                 
                     <div class="col-md-6">


                       <div class="form-group has-feedback">
                          <label for="exampleInputEmail1"> Type <span style="color: red;">*</span></label>
                                <select class="form-control" name="link_type" id="my_select">
                                  <option value="chat_listing" <?php if($data->link_type == "chat_listing") { echo "selected"; }?>>Chat Listing</option>
                                  <option value="audio_listing" <?php if($data->link_type == "audio_listing") { echo "selected"; }?> >Audio Listing</option>
                                  <option value="video_listing" <?php if($data->link_type == "video_listing") { echo "selected"; }?>>Video Listing</option>
                                  <option value="report_listing" <?php if($data->link_type == "report_listing") { echo "selected"; }?>>Report Listing</option>
                                  <option value="broadcast_listing" <?php if($data->link_type == "broadcast_listing") { echo "selected"; }?>>Broadcast Listing</option>
                                  <option value="astrologer_chat" <?php if($data->link_type == "astrologer_chat") { echo "selected"; }?>>Astrologer Chat</option>
                                  <option value="astrologer_audio" <?php if($data->link_type == "astrologer_audio") { echo "selected"; }?>>Astrologer Audio</option>
                                  <option value="astrologer_video" <?php if($data->link_type == "astrologer_video") { echo "selected"; }?>>Astrologer Video</option>
                                  <option value="astrologer_report" <?php if($data->link_type == "astrologer_report") { echo "selected"; }?>>Astrologer Report</option>
                                  <option value="wallet" <?php if($data->link_type == "wallet") { echo "selected"; }?>>Wallet</option>
                               
                               
                              </select>

                        </div>

                         <div class="astrologer_Chat">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Chat <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_chat" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>" <?=$keya->id == $data->link_id ? 'selected' : ''?>><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>

                         <div class="astrologer_Audio">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Audio <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_audio" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>" <?=$keya->id == $data->link_id ? 'selected' : ''?>><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>

                         <div class="astrologer_Video">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Video <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_video" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>" <?=$keya->id == $data->link_id ? 'selected' : ''?>><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>

                         <div class="astrologer_Report">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Report <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_report" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>" <?=$keya->id == $data->link_id ? 'selected' : ''?>><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>

            
            <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Image</label>
                            <input  name="image"  type="file" >
                            <br>
                              <img height="50" width="70" alt="your image" src="<?php echo base_url('/')."uploads/banner/user/";?><?=$data->image?>" name=""/>

                          <input type="hidden" name="image11" value="<?php echo $data->image; ?>" class="form-control">
                          <input type="hidden" name="id" value="<?php echo $data->id; ?>" class="form-control">

                             <span class="glyphicon  form-control-feedback"></span>
                        </div>
                   <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Position <span style="color: red;">*</span></label>
                            <input type="number" class="form-control required" min="1" data-parsley-trigger="change" data-parsley-minlength="1" value="<?=$data->position?>" required name="position"  placeholder="Position">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

              <div class="form-group has-feedback">
                        <label for="complaintinput2">Status:</label>


                          <select name="is_active" class="form-control required">
                              <option value="1" <?=$data->is_active==1 ? "selected" : ""?>>Active</option>
                              <option value="0" <?=$data->is_active==0 ? "selected" : ""?>>Inactive</option>
                          </select>

                        </div>
              <div class="box">
              <div class="box-body">
              <div class="col-md-12">
              <div class="form-group has-feedback">                                       
                        <input type="submit" class="btn btn-primary" value="Submit" id="patient banneradd">
<!--                         <button type="reset" class="btn btn-primary">Reset </button>
 -->                        </div> 
           </div>
          </div> 
            </div>  

         </div>
        </div>
      </div>
    </div>
     </form> 
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
  <script>
  base_url = "<?php echo base_url(); ?>";
  config_url = "<?php echo base_url(); ?>";
  </script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>
$(document).ready(function(){
    $("#my_select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            // alert(optionValue); 
            if(optionValue == "astrologer_chat"){               
                $(".astrologer_Chat").show();
                $(".astrologer_Audio").hide();
                $(".astrologer_Video").hide();
                $(".astrologer_Report").hide();
            } 
            else if (optionValue == "astrologer_audio") {
              // alert("Ssss");
                $(".astrologer_Audio").show();
               $(".astrologer_Chat").hide();
                $(".astrologer_Video").hide();
                $(".astrologer_Report").hide();
            }
            else if (optionValue == "astrologer_video") {
              // alert("Ssss");
                $(".astrologer_Audio").hide();
               $(".astrologer_Chat").hide();
                $(".astrologer_Video").show();
                $(".astrologer_Report").hide();
            }
            else if (optionValue == "astrologer_report") {
              // alert("Ssss");
                $(".astrologer_Audio").hide();
               $(".astrologer_Chat").hide();
                $(".astrologer_Video").hide();
                $(".astrologer_Report").show();
            }
            else{
                $(".astrologer_Chat").hide();
                $(".astrologer_Audio").hide();
                $(".astrologer_Video").hide();
                $(".astrologer_Report").hide();
            }
        });
    }).change();
});
</script>

