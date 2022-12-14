<script>
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js></script>
<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pace.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/DateTimePicker.js"></script>
<script>
   $(document).ready(function() {
       $('#table_pagination').DataTable();
   } );
   
   
   
   
   $("#sh-date-selection").datepicker({
       dateFormat : 'yy-mm-dd',
   
       numberOfMonths: 1
   
   });
</script>
<!-- FastClick 
   <script src="../../plugins/fastclick/fastclick.min.js"></script>-->
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom-script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/backend-script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.colorbox-min.js"></script>
<!-- CK Editor -->
<script src="<?php echo base_url(); ?>assets/js/charisma.js"></script>
<script src="<?php echo base_url(); ?>assets/js/config.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>assets/js/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/js/input-mask/jquery.inputmask.extensions.js"></script>
<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<!--[validation js]-->
<!--  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAPkwBOzGBH1V1sRBzmCWQS-7XoTgPghT0&libraries=places"></script>
   -->    <!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/parsley.min.js"></script>
<script type="text/javascript">
   //Date picker
      $('.datepickera1').datepicker({
        autoclose: true
      });
</script>
<script language="javascript" type="text/javascript">
   $(document).ready(function notification(){
               $.ajax({
                   type  : 'ajax',
                 url: "<?php echo base_url('speedhuntson/notifiction_details');?>",
                   async : true,
                   success : function(data){
                      // console.log(data);
                       $('#show_notification_data').html(data);
                        var noti = $('#notifycount').val();
                        // var noti_data = $('#count_data').val($('#notifycount').val());
                        $("#count_data").text(noti);
                        // alert(noti_data)
                  setTimeout(function(){
   
                                 notification(); //this will send request again and again;
                             }, 10000);
                   }
               });
           })
</script>
<!-- <script language="javascript" type="text/javascript">
   $(document).ready(function lab_notification(){
               $.ajax({
                   type  : 'ajax',
                 url: "<?php //echo base_url('speedhuntson/lab_notifiction_details');?>",
                   async : true,
                   success : function(data){
                       console.log(data);
                        var lab_noti = $('#lab_ycount').val();
                        $("#count_lab").text(lab_noti);
                  setTimeout(function(){
                                 notification(); //this will send request again and again;
                             }, 5000);
                   }
               });
           })
   </script> -->
<script>
   function update_notifiction_id(id) 
   {
     // alert(id);
    var id = id;
   
       $.ajax({
              type: "POST",
              url: "<?php echo base_url('speedhuntson/update_notifiction_details');?>",
              data: {id: id},
               method: "post",
              success: function(data) {
               console.log(data);
                // $('#customer_ids').html(data);
                 // location.reload();
              }
          }); 
   }
</script>
<script type="text/javascript">
   $(function() {
     
       $('input[name="check_type"]').on('click', function() {
           if ($(this).val() == 'url') {
               $('#textboxes').show();
   
           }
           else {
               $('#textboxes').hide();
           }
           if ($(this).val() == 'video') {
               $('#file').show();
               
           }
           else {
               $('#file').hide();
           }
       });
   });
</script>
<script>
   // function validateNumber()
   // {
   //   // alert('dsfdsf');
   // var first = $('.first').val();
   // var second = $('.second').val();
   // var third = $('.third').val();
   
   //   if(first < second){
   //   alert(first);
   //   alert(second);
   //   // $('#sub').prop('disabled', false);
   //   }
   
   
   // }
   
   $(".first,.second,.third").bind("keyup change", function(e) {
      var first = $('.first').val();
      var second = $('.second').val();
      var third = $('.third').val();
   
      if(parseInt(first) < parseInt(second)) {
       alert("Please enter MRP > selling Price");
           $('.second').val(' ');
      }
      if(parseInt(second) < parseInt(third))
      {
           alert('please enter selling Price > Cost Price');
       $('.third').val(' ');
      }
   // var third = $('.third').val();
       // do stuff!
   })
   
     $(function () {
       $('#example1').DataTable()
       $('#example2').DataTable({
         'paging'      : true,
         'lengthChange': true,
         'searching'   : true,
         'ordering'    : true,
         'info'        : true,
         'autoWidth'   : false
         
       })
     })
</script>
<script>
   $(document).on('click', '#add_basic', function() { 
     // alert($('#basic_exer').attr('name'));
   $('#basic_exer').append('<div class="exer form-group has-feedback" ><input type="text" name="basic[profile][]" class="form-control required" placeholder="Profile"><span class="remove fa fa-minus-circle"></span></div>');
   return false; //prevent form submission
   });
   
   $('#basic_exer').on('click', '.remove', function() {
   $(this).prev().remove();
   $(this).next().remove();
   $(this).remove();
   return false; //prevent form submission
   });
   
   $('#add_advance').on('click', function() { 
   //alert($('#advance_exer').attr('name'));
   $('#advance_exer').append('<div class="exer form-group has-feedback" ><input type="text" name="advance[profile][]" class="form-control required" placeholder="Profile"><span class="remove fa fa-minus-circle"></span></div>');
   return false; //prevent form submission
   });
   
   $('#advance_exer').on('click', '.remove', function() {
   $(this).prev().remove();
   $(this).next().remove();
   $(this).remove();
   return false; //prevent form submission
   });
   
   
   $('#add_expertise').on('click', function() { 
   // alert('fdfg');
   $('#expertise').append('<div class="exer form-group has-feedback" ><input type="text" name="expertise[]" class="form-control required" placeholder="Expertise"><span class="remove fa fa-minus-circle"></span></div>');
   return false; //prevent form submission
   });
   
   $('#expertise').on('click', '.remove', function() {
   $(this).prev().remove();
   $(this).next().remove();
   $(this).remove();
   return false; //prevent form submission
   });
</script>
<script type="text/javascript">
   //Clone and Remove Form Fields
   
   $('#add_exercise').on('click', function() { 
     $('#exercises').append('<div class="exercise form-group has-feedback" ><input type="text" name="package_include[]" class="form-control required" placeholder="Package Include"><span class="remove fa fa-minus-circle"></span></div>');
     return false; //prevent form submission
   });
   
   $('#add_exer').on('click', function() { 
     $('#exercises').append('<div class="exer form-group has-feedback" ><input type="text" name="profile[]" class="form-control required" placeholder="Profile"><span class="remove fa fa-minus-circle"></span></div>');
     return false; //prevent form submission
   });
   
   $('#exercises').on('click', '.remove', function() {
     $(this).parent().remove();
     return false; //prevent form submission
   });
   
   $('#add_degree').on('click', function() { 
      // alert('fdfg');
       $('#degree').append("<div class='row'><div class='col-md-6'><div class='form-group'><label for='complaintinput2'>Doctor Degree :</label><select name='doctor_degree[]' class='form-control' required=''><option value=''>Select Degree</option><?php if (!empty($doctordegree)) { foreach($doctordegree as $degree) { ?><option value='<?=$degree->id?>'> <?=$degree->degree_name?> </option><?php } }?></select></div></div><div class='col-md-6'> <div class='form-group'><label>Degree From</label> <input type='text' name='degree_from[]' class='form-control' placeholder='Degree From'></div> </div></div><span class='remove btn fa fa-minus-circle'></span>");
     return false; //prevent form submission
   });
   
   $('#degree').on('click', '.remove', function() {
     $(this).parent().remove();
     return false; //prevent form submission
   });
   
   
   $('#add_practices').on('click', function() { 
     $('#practices').append(' <div class="row"><div class="col-md-6"><div class="form-group"><label for="complaintinput2">Other Practices:</label><input type="text" name="hospital_name[]" placeholder="Workplace Name" class="form-control" ></div></div><div class="col-md-6"><div class="form-group"><label>Address</label><input type="text" name="address[]" class="form-control" placeholder="Address"></div></div><span class="remove btn fa fa-minus-circle"></span>');
     return false; //prevent form submission
   });
   
   $('#practices').on('click', '.remove', function() {
     $(this).parent().remove();
     return false; //prevent form submission
   });
   
   var include = document.getElementById('include').value; 
   $(document).on('click','.del', function(){
   $(this).prev().prev().remove();
   $(this).prev().remove();
   $(this).remove();
    
   });
   
   $(document).on('click', '#img_del', function(){  
     //alert('dsd');
            if(confirm("Are you sure you want to remove this image?"))  
            {  
                 var img_btn = $(this).data('value');  
                 //alert(img_btn);
                 var xr = $(this);
                 $.ajax({  
                      url:"<?php echo  base_url('doctordetail_ctrl/delete_image/')?>",  
                      type:"POST",  
                      data:{img_btn:img_btn},  
                      success:function(data){  
                      // alert(data);
                           if(data)  
                           {  
                             xr.next().hide();
                             xr.hide();
                                //alert($('.img_btn').val(data));
                             location.href="<?php current_url();?>"
                           }  
                      }  
                 });  
            }  
            else  
            {  
                 return false;  
            }  
       });  
   
   
   $(function() {
   $('#datepicker').datepicker({
     autoclose: true,
     format: 'dd-mm-yyyy'
         
     });
   });
   
   
   var nowTemp = new Date();
   var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
   
   var checkin = $('#dpd1').datepicker({
   onRender: function(date) {
     return date.valueOf() < now.valueOf() ? 'disabled' : '';
   }
   })
   
   
   var checkin = $('.dpd1').datepicker({
   onRender: function(date) {
     //return date.valueOf() < now.valueOf() ? 'disabled' : '';
   }
   })
   $(function () {
         //Initialize Select2 Elements
        // $(".select2").select2();
     
     $('.datatable').DataTable({
       "ordering" : $(this).data("ordering"),
       "order": [[ 0, "desc" ]]
         });
     
     });
    $(function () {
     $(".datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
     $("[data-mask]").inputmask();
     });
     
</script>
<script>
   $(function () {
        $(".timepicker").timepicker({
          'minTime': '00:00am',
        'maxTime': '24:00pm',
        showInputs: false
      });
        
    
    });
   
   function doconfirm()
   {
    job=confirm("Are you sure to delete permanently?");
     if(job!=true)
    {
        return false;
    }
   }
</script>
<script>
   $(document).ready(function(){

     
     var take_horoscope = $('#take_horoscope').val();
       if(take_horoscope == '1')
       {
         var showData_horoscope = '<label>In Horoscope Price Price<span style="color: red;">*</span></label><input required value="<?=$data->horoscope_price?>" type="number" min="1" step="any" name="horoscope_price" class="form-control" placeholder="Price">';
         $("#horoscope_price_p").html(showData_horoscope);  
       }
       else
       {
         var showData_horoscope = '<input required type="hidden" value="0" name="horoscope_price">';
         $("#horoscope_price_p").html(showData_horoscope); 
       }


       var take_broadcast = $('#take_broadcast').val();
       if(take_broadcast == '1')
       {
         var showData_broadcast = '<label>In Broadcast Price Price<span style="color: red;">*</span></label><input required value="<?=$data->price_per_mint_broadcast?>" type="number" min="1" step="any" name="broadcast_price" class="form-control" placeholder="Price">';
         $("#broadcast_price_p").html(showData_broadcast);  
       }
       else
       {
         var showData_broadcast = '<input required type="hidden" value="0" name="broadcast_price">';
         $("#broadcast_price_p").html(showData_broadcast); 
       }
   
   
   
   
     <?php 
      if ($page_title == 'Edit Medical Equipment'){
        //print_r("shubham");die;
      ?>
   
     var for_data = $('#for').val();
     // alert(for_data);
     if(for_data == 'Rental')
     {
      // alert("shuhbham");
       // var showData_rent_price = '<label>Rent Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="rent_price" class="form-control" placeholder="Price" value="<?=$lists->rent_price?>"><input required type="hidden" value="0" name="purchase_price">';
   
       //   var showData_rent_dis = '<label>Rent Discount Price<span style="color: red;"></span></label><input  type="number" min="1" step="any" name="rent_discount" class="form-control" placeholder="Price" value="<?=$lists->rent_discount?>"><input  type="hidden" value="0" name="purchase_discount">';
   
          var showfor_month_week = '<label>For Month Week<span style="color: red;"></span></label><select name="for_month_week" id="week" class="form-control" onChange="myFunc_for_week();" ><option value="0" >Select</option><option <?php if ($lists->for_month_week == 1 ) echo 'selected' ; ?>  value="1">Week</option><option <?php if ($lists->for_month_week == 2 ) echo 'selected' ; ?> value="2">Month </option><option  <?php if ($lists->for_month_week == 3 ) echo 'selected' ; ?> value="3">Both</option></select>';
   
   
         // $("#for_rent_price").html(showData_rent_price);  
         // $("#for_rent_dis").html(showData_rent_dis);  
         $("#for_month_week").html(showfor_month_week);   
         $("#for_pur_price").html('');
         $("#for_pur_dis").html('');
     }
     else if(for_data == 'Purchase')
     {
   
       // alert("shuhbhasssssm");
       var showData_pur_price = '<label>Purchase Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="purchase_price" class="form-control" placeholder="Price" value="<?=$lists->purchase_price?>"><input required type="hidden" value="0" name="rent_price">';
   
         var showData_pur_dis = '<label>Purchase Discount Price<span style="color: red;"></span></label><input  type="number" min="1" step="any" name="purchase_discount" class="form-control" placeholder="Price" value="<?=$lists->purchase_discount?>"><input  type="hidden" value="0" name="rent_discount">';
   
         $("#for_pur_price").html(showData_pur_price);  
         $("#for_pur_dis").html(showData_pur_dis); 
          // $("#for_rent_price").html('');
          // $("#for_rent_price").html('');
         $("#for_rent_dis").html('');
   
     }
    
     else
     {
       var showData_rent_price = '<input required type="hidden" value="0" name="rent_price">';
         $("#for_rent_price").html(showData_rent_price); 
         var showData_rent_dis = '<input required type="hidden" value="0" name="rent_discount">';
         $("#for_rent_dis").html(showData_rent_dis); 
          var showData_pur_price = '<input required type="hidden" value="0" name="purchase_price">';
         $("#for_pur_price").html(showData_pur_price); 
          var showData_pur_dis = '<input required type="hidden" value="0" name="purchase_discount">';
         $("#for_pur_dis").html(showData_pur_dis); 
          var showfor_month_week = '<input required type="hidden" value="0" name="for_month_week">';
         $("#for_pur_dis").html(showfor_month_week); 
     }
   
     var week_type = $('#week').val();
       if(week_type == 1)
       {
        // alert("shubham"); 
       
   
         var showData_rent_week_price = '<label>Rent Week Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="rent_price"  value="<?=$lists->rent_price?>" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="rent_month_price">';
   
         var showData_rent_week_dis = '<label>Rent Week Discount Price<span style="color: red;"></span></label><input  type="number" min="0" step="any" name="rent_discount"  value="<?=$lists->rent_discount?>"  class="form-control" placeholder="Price"><input  type="hidden" value="0" name="rent_month_discount_price">';
   
         $("#for_rent_price_week").html(showData_rent_week_price);  
         $("#for_rent_dis_week").html(showData_rent_week_dis);  
         $("#for_rent_price_month").html('');
         $("#for_rent_dis_month").html('');
       }
       else if (week_type == 2)
       {
         //alert("shubham");
             var showData_rent_price_month = '<label>Rent Month Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="rent_month_price"  value="<?=$lists->rent_month_price?>"  class="form-control" placeholder="Price"><input required type="hidden" value="0" name="rent_price">';
   
         var showData_rent_dis_month = '<label>Rent Month Discount Price<span style="color: red;"></span></label><input  type="number" min="0" step="any" name="rent_month_discount_price" value="<?=$lists->rent_month_discount_price?>"  class="form-control" placeholder="Price"><input  type="hidden" value="0" name="rent_discount">';
   
          $("#for_rent_price_week").html('');
         $("#for_rent_dis_week").html('');
        $("#for_rent_price_month").html(showData_rent_price_month);  
         $("#for_rent_dis_month").html(showData_rent_dis_month);  
       }
   
       else if (week_type == 3)
       {
         //alert("shubham");
          var showData_rent_week_price = '<label>Rent Week Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="rent_price"  value="<?=$lists->rent_price?>"   class="form-control" placeholder="Price">';
   
         var showData_rent_week_dis = '<label>Rent Week Discount Price<span style="color: red;"></span></label><input  type="number" min="0" step="any" name="rent_discount"  value="<?=$lists->rent_discount?>"  class="form-control" placeholder="Price">';
   
            var showData_rent_price_month = '<label>Rent Month Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="rent_month_price"  value="<?=$lists->rent_month_price?>"  class="form-control" placeholder="Price">';
   
         var showData_rent_dis_month = '<label>Rent Month Discount Price<span style="color: red;"></span></label><input  type="number" min="0" step="any" name="rent_month_discount_price"  value="<?=$lists->rent_month_discount_price?>"  class="form-control" placeholder="Price">';
   
        $("#for_rent_price_month").html(showData_rent_price_month);  
         $("#for_rent_dis_month").html(showData_rent_dis_month);  
          $("#for_rent_price_week").html(showData_rent_week_price);  
         $("#for_rent_dis_week").html(showData_rent_week_dis);  
       }
   
       else
       {
         var showData_rent_price_month = '<input required type="hidden" value="0" name="rent_price">';
         $("#for_rent_price_month").html(showData_rent_price_month); 
   
         var showData_rent_dis_month = '<input required type="hidden" value="0" name="rent_discount">';
         $("#for_rent_dis_month").html(showData_rent_dis_month); 
          var showData_rent_week_price = '<input required type="hidden" value="0" name="rent_month_price">';
         $("#for_rent_price_week").html(showData_rent_week_price); 
          var showData_rent_week_dis = '<input required type="hidden" value="0" name="rent_month_discount_price">';
         $("#for_rent_dis_week").html(showData_rent_week_dis); 
         
         
       }
   
   
   
   <?php } ?>
   
   
   // For add doctor page
     <?php 
      if ($page_title == 'Edit Doctor Details'){
      ?>
       var planned_visit = $('#planned_visit').val();
       if (planned_visit == 1) 
       {
         var showData_planned_visit = '<label>Planned Visit Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="planned_visit_price" value="<?=$data->planned_visit_price?>" class="form-control" placeholder="Price">';
           $("#planned_visit_price").html(showData_planned_visit);
       }
       else
       {
         var showData_planned_visit = '<input required type="hidden" value="0" name="planned_visit_price">';
         $("#planned_visit_price").html(showData_planned_visit); 
       }
   
       var emergency_visit = $('#emergency_visit').val();
       if (emergency_visit == 1) 
       {
         var showData_emergency_visit = '<label> Emergency Price<span style="color: red;">*</span></label><input value="<?=$data->emergency_price?>" required type="number" min="1" step="any" name="emergency_price" class="form-control" placeholder="Price">';
         $("#planned_emergency_visit").html(showData_emergency_visit);  
       }
       else
       {
         var showData_emergency_visit = '<input required type="hidden" value="0" name="emergency_price">';
         $("#planned_emergency_visit").html(showData_emergency_visit);  
       }
   
       var medical_services = $('#medical_services').val();
       if (medical_services == 1) 
       {
         <?php 
      if ($data->services != '')
      {
      
        $selected_services = array();
        $r = explode(',', $data->services);
        foreach ($r as $key)
        {
          array_push($selected_services, $key);
        }
      ?>
         var showData_medical_services = '<label>Select Services<span style="color: red;">*</span></label><select class="js-example-basic-multiple form-control" name="services[]" multiple="multiple" placeholder="Select Services" id="services">'+'<?php foreach($common_service as $serv) { if (in_array($serv->id, $selected_services)) { ?> <option selected value="<?=$serv->id?>"> <?=$serv->service_name.'-(&#8377; '.$serv->price.')'?> </option><?php } else { ?><option value="<?=$serv->id?>"> <?=$serv->service_name.'-(&#8377; '.$serv->price.')'?> </option><?php } }?></select>';
         $("#doorstep_services").html(showData_medical_services); 
         <?php 
      }
      else{
      ?>
         var showData_medical_services = '<label>Select Services<span style="color: red;">*</span></label><select class="js-example-basic-multiple form-control" name="services[]" multiple="multiple" placeholder="Select Services" id="services">'+'<?php foreach($common_service as $serv) { ?> <option value="<?=$serv->id?>"> <?=$serv->service_name.'-(&#8377; '.$serv->price.')'?> </option><?php }?></select>';
         $("#doorstep_services").html(showData_medical_services); 
       <?php } ?>
       }
       else
       {
         var showData_medical_services = '<input required type="hidden" value="" name="services[]">';
         $("#doorstep_services").html(showData_medical_services); 
       }
   
   
   
    var online = $('#online').val();
    
     if(online == '1')
     {
       var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input value="<?=$data->online_consult_chat_price?>" required type="number" min="1" step="any" name="online_consult_chat_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_video_price"><input required type="hidden" value="0" name="online_consult_audio_price">';
       $("#online_p").html(showData_online_chat_price);  
       $("#online_video_p").html('');
        $("#online_audio_p").html('');
     }
     else if(online == '2')
     {
       var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input value="<?=$data->online_consult_video_price?>" required type="number" min="1" step="any" name="online_consult_video_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_audio_price">';
       $("#online_video_p").html(showData_online_video_price);  
       $("#online_p").html('');
        $("#online_audio_p").html('');
     }
   
      else if(online == '3')
       {
         var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_audio_price" value="<?=$data->audio_price?>" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_video_price">';
         $("#online_audio_p").html(showData_online_audio_price);  
         $("#online_p").html('');
         $("#online_video_p").html('');
       }
   
     else if(online == '4')
       {
         var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input value="<?=$data->online_consult_chat_price?>"  required type="number" min="1" step="any" name="online_consult_chat_price" class="form-control" placeholder="Price">';
         $("#online_p").html(showData_online_chat_price);  
         
         var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input value="<?=$data->online_consult_video_price?>" required type="number" min="1" step="any" name="online_consult_video_price" class="form-control" placeholder="Price">';
         $("#online_video_p").html(showData_online_video_price);  
   
          var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_audio_price" value="<?=$data->audio_price?>" class="form-control" placeholder="Price">';
         $("#online_audio_p").html(showData_online_audio_price); 
   
   
       }
     else
     {
       var showData_online = '<input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_video_price"><input required type="hidden" value="0" name="online_consult_audio_price">';
       var showData_online_audio_price = '<input required type="hidden" value="0" name="online_consult_audio_price">';
       $("#online_p").html(showData_online); 
       $("#online_audio_p").html('');
       
     }
   
  

     var normal = $('#normal').val();
       if(normal == '1')
       {
         var showData_normal = '<label>Appointment Price<span style="color: red;">*</span></label><input required value="<?=$data->normal_appointment_price?>" type="number" min="1" step="any" name="normal_appointment_price" class="form-control" placeholder="Price">';
         $("#normal_appointment").html(showData_normal);  
       }
       else
       {
         var showData_normal = '<input required type="hidden" value="0" name="normal_appointment_price">';
         $("#normal_appointment").html(showData_normal); 
       }



   
     var inhouse = $('#inhouse').val();
       if(inhouse == '1')
       {
         var showData_inhouse = '<label>In House Price<span style="color: red;">*</span></label><input required value="<?=$data->in_house_doctor_price?>" type="number" min="1" step="any" name="in_house_doctor_price" class="form-control" placeholder="Price">';
          var showData_intop = '<label>In Top<span style="color: red;">*</span></label><select class="form-control" name="in_top" placeholder="in_top" id="in_top" required>  <?php if($data->in_top == 1): ?>
   <option value="1" selected> Yes  </option><option value="0"> No </option><?php else: ?><option value="1" > Yes  </option><option value="0" selected> No </option><?php endif ?></select>';
         $("#inhouse_p").html(showData_inhouse);  
          $("#intop_p").html(showData_intop);  
       }
       else
       {
         var showData_inhouse = '<input required type="hidden" value="0" name="in_house_doctor_price">';
          var showData_intop = '<input required type="hidden" value="0" name="in_top">';
         $("#inhouse_p").html(showData_inhouse); 
           $("#intop_p").html(showData_intop);  
       }
   
         <?php } ?>
       // $('#reservation').daterangepicker()
       
     <?php if(isset($list)): ?>
      <?php  if (!empty($list->hospital_country)) {?>
       var hospital_country = '<?=$list->hospital_country?>';
       var url = "<?php echo base_url('Hospital_ctrl/get_related_state2'); ?>";
       if(hospital_country != ''){
           $.ajax({
               url: url,
               type: "POST",
               data: 'hospital_country='+hospital_country,
               success: function (data) {
                   //alert(data);
                   if(data.length != ''){
                       var json = JSON.parse(data);
                       var lengthofObject = json.length;
                       var i;
                       var showData = [];
                       var prev_state = "<?=$list->hospital_state?>";
                       for (i = 0; i < lengthofObject; ++i) {
                           if (prev_state == json[i].state_name) 
                           {
                             showData[i] = "<option selected value='"+json[i].id+'|'+json[i].state_name+"'>"+json[i].state_name+"</option>";
                           }
                           else
                           {
                             showData[i] = "<option value='"+json[i].id+'|'+json[i].state_name+"'>"+json[i].state_name+"</option>";
                           }
                       }
                       $("#state").html(showData);
                   }else{
                       $("#state").html("<option value=''>Please Select</option>");
                   }
               },
           });
       }
     <?php   }
      if (!empty($list->hospital_city)) {?>
       var hospital_city = '<?=$list->hospital_city?>';
       var url = "<?php echo base_url('Hospital_ctrl/get_related_city2'); ?>";
       if(hospital_country != ''){
           $.ajax({
               url: url,
               type: "POST",
               data: 'hospital_city='+hospital_city,
               success: function (data) {
                   //alert(data);
                   if(data.length != ''){
                       var json = JSON.parse(data);
                       var lengthofObject = json.length;
                       var i;
                       var showData = [];
                       var prev_city = "<?=$list->hospital_city?>";
                       for (i = 0; i < lengthofObject; ++i) {
                           if (prev_city == json[i].city_name) 
                           {
                             showData[i] = "<option selected value='"+json[i].id+'|'+json[i].city_name+"'>"+json[i].city_name+"</option>";
                           }
                           else
                           {
                             showData[i] = "<option value='"+json[i].id+'|'+json[i].city_name+"'>"+json[i].city_name+"</option>";
                           }
                       }
                       $("#city").html(showData);
                   }else{
                       $("#city").html("<option value=''>Please Select</option>");
                   }
               },
           });
       }
         <?php } endif; ?>
     
   
     var $content1 = $(".monday").hide();
     $(".toggle").on("click", function(e){
       $(this).toggleClass("expanded");
       $content1.slideToggle();
     });
   
     var $content2 = $(".tuesday").hide();
     $(".toggle1").on("click", function(e){
       $(this).toggleClass("expanded");
       $content2.slideToggle();
     });
   
     var $content3 = $(".wednesday").hide();
     $(".toggle2").on("click", function(e){
       $(this).toggleClass("expanded");
       $content3.slideToggle();
     });
   
     var $content4 = $(".thursday").hide();
     $(".toggle3").on("click", function(e){
       $(this).toggleClass("expanded");
       $content4.slideToggle();
     });
   
     var $content5 = $(".friday").hide();
     $(".toggle4").on("click", function(e){
       $(this).toggleClass("expanded");
       $content5.slideToggle();
     });
   
     var $content6 = $(".saturday").hide();
     $(".toggle5").on("click", function(e){
       $(this).toggleClass("expanded");
       $content6.slideToggle();
     });
   
     var $content7 = $(".sunday").hide();
     $(".toggle6").on("click", function(e){
       $(this).toggleClass("expanded");
       $content7.slideToggle();
     });
   });
   
   
    
</script>
<script>
   $(function () {
     // CKEDITOR.replace('expertise')
     // CKEDITOR.replace('bio')
 
     
     $('.textarea').wysihtml5()
   })
</script>