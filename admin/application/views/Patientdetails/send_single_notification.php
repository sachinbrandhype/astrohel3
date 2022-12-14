<style>
/*body{width:610px;}*/
/*.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}*/
#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:390px;position: absolute;z-index: 1;}
#country-list li{padding: 2px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#country-list li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Send Notification
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
      <!-- <li><a href="<?php echo base_url();?>Nurse/view_nursedetails">Nurse Details</a></li> -->
      <li class="active">Send Notification</li>
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
            <h3 class="box-title">Send Notification</h3>
         </div>
         <!-- /.box-header -->
         <!-- form start -->
         <form role="form" action="<?=base_url('user_details/send_single_notification/');?>" method="post"  data-parsley-validate="" class="validate" enctype="multipart/form-data">
            <div class="box-body">
               <div class="col-md-12">
                
               <!-- </div>    -->
                  <!-- <div class="form-group">
                     <label>Name</label>
                        <div class="frmSearch">
                           <input type="text" id="search-box" name="name" placeholder="User Name" style="width: 100%;" />
                           <div id="suggesstion-box"></div>
                        </div>
                  </div> -->
                  <div class="form-group">
                     <label for="">User</label>
                     <select name="user_id" class='form-control' required>
                        <option value="">Select..</option>
                        <?php foreach ($users as $v) {
                           ?>
                           <option value="<?=$v->id?>"><?=$v->name?>(<?=$v->phone?>)</option>
                           <?php
                        } ?>
                     </select>
                     
                  </div>
            <div class="form-group">
                    <label>Title</label>
                     <input type="text" required name="title" class="form-control" placeholder="Title" >
                  </div>

                  <div class="form-group">
                    <label>Message</label>
                     <textarea class="form-control" name="message" required=""></textarea>
                  </div>

                    <div class="form-group has-feedback">
                            <label for="exampleInputEmail1"> Image</label>
                            <input  name="image"  type="file" >
                             <span class="glyphicon  form-control-feedback"></span>
                        </div>

                        
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  
                  
                  <div class="box">
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </div>
                  

                 
         </form>




         </div>
         <!-- /.box -->
         </div>
      </div>
      <!-- /.row -->

      <!-- /.row -->
</section>
<!-- /.content -->
</div> 

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
  $("#search-box").keyup(function(){
    $.ajax({
    type: "POST",
    url: "<?php echo base_url('User_details/userList');?>",
    data:'keyword='+$(this).val(),
    beforeSend: function(){

      $("#search-box").css("background","#FFF url(<?=base_url('uploads/LoaderIcon.gif')?>) no-repeat 165px");
    },
    success: function(data){
       console. log(data);
      $("#suggesstion-box").show();
      $("#suggesstion-box").html(data);
      $("#search-box").css("background","#FFF");
    }
    });
  });
});
//To select country name
function selectCountry(val) {
   console. log(val);
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>