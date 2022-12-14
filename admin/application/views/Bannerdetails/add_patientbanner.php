
<?php $id = $this->session->userdata('admin');  ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Main Banner 
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
         <li><a href="<?php echo base_url(); ?>banner_ctrl/view_banner">Main Banner Details </a></li>
         <li class="active">Add Main Banner</li>
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
  <form role="form"  method="post" action="<?php echo base_url('banner_ctrl/insert_patientbanner')?>" id="patient banner_reg" data-parsley-validate="" class="validate" enctype="multipart/form-data" >
  
         <div class="col-md-12">
            <!-- general form elements -->             
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">Add  Banner </h3>
                  <div class="edituser" tabindex='1'></div>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
                <div class="box-body">                 
                     <div class="col-md-6">


                       <div class="form-group has-feedback">
                          <label for="exampleInputEmail1"> Type <span style="color: red;">*</span></label>
                                <select class="form-control" name="link_type" id="my_select">
                                  <option value="chat_listing">Chat Listing</option>
                                  <option value="audio_listing">Audio Listing</option>
                                  <option value="video_listing">Video Listing</option>
                                  <option value="report_listing">Report Listing</option>
                                  <option value="broadcast_listing">Broadcast Listing</option>
                                  <option value="astrologer_chat">Astrologer Chat</option>
                                  <option value="astrologer_audio">Astrologer Audio</option>
                                  <option value="astrologer_video">Astrologer Video</option>
                                  <option value="astrologer_report">Astrologer Report</option>
                                  <option value="wallet" >Wallet</option>
                               
                              </select>

                        </div>

                         <div class="astrologer_Chat">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Chat <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_chat" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>"><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>

                         <div class="astrologer_Audio">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Audio <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_audio" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>"><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>

                         <div class="astrologer_Video">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Video <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_video" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>"><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>

                         <div class="astrologer_Report">
                           <div class="form-group has-feedback">
                              <label for="exampleInputEmail1">Astrologers Report <span style="color: red;">*</span></label>
                                 <select class="form-control" name="link_id_report" placeholder="Select astrologers" >
                                    <?php foreach ($astrologers as $keya): ?>
                                    <option value="<?=$keya->id?>"><?=$keya->name?></option>
                                    <?php endforeach ?>
                                 </select>
                           </div>
                        </div>



            
            <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Image</label>
                            <input  name="image"  type="file"   required="">
                             <span class="glyphicon  form-control-feedback"></span>
                        </div>
                   <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Position <span style="color: red;">*</span></label>
                            <input type="number" class="form-control required" min="1" data-parsley-trigger="change" data-parsley-minlength="1" required name="position"  placeholder="Position">
                            <span class="glyphicon  form-control-feedback"></span>
                    </div>

              <div class="form-group has-feedback">
                        <label for="complaintinput2">Status:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="is_active" value="1" checked>Active&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="is_active" value="0"> Inactive</div>
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