<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?=$page_title?>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
         <li><a href="<?php echo base_url();?>pooja/datewisetime_list/<?=$pooja_id?>">Lists</a></li>
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
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Date*</label>
                           <input type="date" name="date" class="form-control" placeholder="Select date" id="sh-date-selection" required>
                        </div>
                        <div class="form-group">
                           <label for="">Stock*</label>
                           <table>
                              <tr>
                                 <td><input required type="number" min="0" placeholder="Stock" name="stock" class="form-control"></td>
                              </tr>
                           </table>
                        </div>
                        <div class="form-group">
                           <label for="">Slots</label>
                           <table id="time_m">
                              <tr>
                                 <td><input type="time" placeholder="Start Time" name="start[]" class="form-control"></td>
                                 <td><input type="time" placeholder="End Time"  name="end[]" class="form-control"></td>
                                 <td><input type="button" class="btn btn-sm btn-danger" value="Delete" /></td>
                              </tr>
                           </table>
                           <p>
                              <input id="add_time_m" class="btn btn-sm btn-primary" type="button" value="Add">
                           </p>
                        </div>
                        <div class="form-group">
                           <label class="control-label" for="status"> Status</label><br>
                           <input type="radio" name="status" value="1" checked> Active<br>
                           <input type="radio" name="status" value="0"> Inactive<br>
                        </div>
                     </div>
                  </div>
                  <div class="box">
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
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
<script type="text/javascript">
   $('#time_m').on('click', 'input[type="button"]', function () {
        $(this).closest('tr').remove();
    })
    $('#add_time_m').click(function () {
        $('#time_m').append('<tr><td><input type="time" placeholder="Start Time" name="start[]" class="form-control"></td><td><input type="time" placeholder="End Time"  name="end[]" class="form-control"></td><td><input type="button" class="btn btn-sm btn-danger" value="Delete" /></td></tr>')
    });
   
   $(document).ready(function() {
   
      $(":checkbox").on("click", function() {
         if ($('input.checkbox_check').is(':checked')) {
   
            var monday_chat_start1 = $('.monday_chat_start1').val();
            var monday_chat_start2 = $('.monday_chat_start2').val();
            var monday_chat_end1 = $('.monday_chat_end1').val();
            var monday_chat_end2 = $('.monday_chat_end2').val();
            // alert(monday_chat_start1);
            // alert(monday_chat_start2);
            // alert(monday_chat_end1);
            // alert(monday_chat_end2);
   
            var $content82 = $(".tuesday2").hide();
            var $content83 = $(".wednesday2").hide();
            var $content84 = $(".thursday2").hide();
            var $content85 = $(".friday2").hide();
            var $content86 = $(".saturday2").hide();
            var $content87 = $(".sunday2").hide();
            if (monday_chat_start1 != '' && monday_chat_start2 != '') {
               $('.dd11').val(monday_chat_start1);
               $('.dd13').val(monday_chat_start2);
   
               if (monday_chat_end1 != '' && monday_chat_end2 != '') {
                  $(".toggle82").toggleClass("expanded");
                  $content82.slideToggle();
                  $(".toggle83").toggleClass("expanded");
                  $content83.slideToggle();
                  $(".toggle84").toggleClass("expanded");
                  $content84.slideToggle();
                  $(".toggle85").toggleClass("expanded");
                  $content85.slideToggle();
                  $(".toggle86").toggleClass("expanded");
                  $content86.slideToggle();
                  $(".toggle87").toggleClass("expanded");
                  $content87.slideToggle();
   
                  $('.dd12').val(monday_chat_end1);
                  $('.dd14').val(monday_chat_end2);
               }
            } else {
               $(".checkbox_check").prop("checked", false);
               alert('Please select time slots')
            }
         } else {
   
            $('.dd11').val('');
            $('.dd12').val('');
            $('.dd13').val('');
            $('.dd14').val('');
         }
   
         if ($('input.checkbox_check_video').is(':checked')) {
   
            var video_start1 = $('.video_start1').val();
            var video_start2 = $('.video_start2').val();
            var video_end1 = $('.video_end1').val();
            var video_end2 = $('.video_end2').val();
            // alert(video_start1);
            // alert(video_start2);
            // alert(video_end1);
            // alert(video_end2);
   
            var $content92 = $(".tuesday3").hide();
            var $content93 = $(".wednesday3").hide();
            var $content94 = $(".thursday3").hide();
            var $content95 = $(".friday3").hide();
            var $content96 = $(".saturday3").hide();
            var $content97 = $(".sunday3").hide();
            if (video_start1 != '' && video_start2 != '') {
               $('.v11').val(video_start1);
               $('.v13').val(video_start2);
   
               if (video_end1 != '' && video_end2 != '') {
                  $(".toggle92").toggleClass("expanded");
                  $content92.slideToggle();
                  $(".toggle93").toggleClass("expanded");
                  $content93.slideToggle();
                  $(".toggle94").toggleClass("expanded");
                  $content94.slideToggle();
                  $(".toggle95").toggleClass("expanded");
                  $content95.slideToggle();
                  $(".toggle96").toggleClass("expanded");
                  $content96.slideToggle();
                  $(".toggle97").toggleClass("expanded");
                  $content97.slideToggle();
   
                  $('.v12').val(video_end1);
                  $('.v14').val(video_end2);
               }
            } else {
               $(".checkbox_check_video").prop("checked", false);
               alert('Please select time slots')
            }
         } else {
   
            $('.v11').val('');
            $('.v12').val('');
            $('.v13').val('');
            $('.v14').val('');
         }
   
   
         if ($('input.checkbox_check_clinic').is(':checked')) {
   
            var clinic_start1 = $('.clinic_start1').val();
            var clinic_start2 = $('.clinic_start2').val();
            var clinic_end1 = $('.clinic_end1').val();
            var clinic_end2 = $('.clinic_end2').val();
            // alert(clinic_start1);
            // alert(clinic_start2);
            // alert(clinic_end1);
            // alert(clinic_end2);
   
            var $content21 = $(".tuesday1").hide();
            var $content31 = $(".wednesday1").hide();
            var $content41 = $(".thursday1").hide();
            var $content51 = $(".friday1").hide();
            var $content61 = $(".saturday1").hide();
            var $content71 = $(".sunday1").hide();
            if (clinic_start1 != '' && clinic_start2 != '') {
               $('.c11').val(clinic_start1);
               $('.c13').val(clinic_start2);
   
               if (clinic_end1 != '' && clinic_end2 != '') {
                  $(".toggle21").toggleClass("expanded");
                  $content21.slideToggle();
                  $(".toggle31").toggleClass("expanded");
                  $content31.slideToggle();
                  $(".toggle41").toggleClass("expanded");
                  $content41.slideToggle();
                  $(".toggle51").toggleClass("expanded");
                  $content51.slideToggle();
                  $(".toggle61").toggleClass("expanded");
                  $content61.slideToggle();
                  $(".toggle71").toggleClass("expanded");
                  $content71.slideToggle();
   
                  $('.c12').val(clinic_end1);
                  $('.c14').val(clinic_end2);
               }
            } else {
               $(".checkbox_check_clinic").prop("checked", false);
               alert('Please select time slots')
            }
         } else {
   
            $('.c11').val('');
            $('.c12').val('');
            $('.c13').val('');
            $('.c14').val('');
         }
   
      })
   
      $("#divid").hide();
      $('#colorselector').change(function() {
         if (this.value == '1') {
            $("#divid").show();
         } else {
            $("#services").select2("val", "");
            $("#divid").hide();
         }
      });
   });
</script>
<script type="text/javascript">
   var $content1 = $(".monday").hide();
   $(".toggle").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content1.slideToggle();
   });
   var $content2 = $(".tuesday").hide();
   $(".toggle1").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content2.slideToggle();
   });
   
   var $content3 = $(".wednesday").hide();
   $(".toggle2").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content3.slideToggle();
   });
   
   var $content4 = $(".thursday").hide();
   $(".toggle3").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content4.slideToggle();
   });
   
   var $content5 = $(".friday").hide();
   $(".toggle4").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content5.slideToggle();
   });
   
   var $content6 = $(".saturday").hide();
   $(".toggle5").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content6.slideToggle();
   });
   
   var $content7 = $(".sunday").hide();
   $(".toggle6").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content7.slideToggle();
   });
   
   
   
   var $content11 = $(".monday1").hide();
   $(".toggle11").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content11.slideToggle();
   });
   var $content21 = $(".tuesday1").hide();
   $(".toggle21").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content21.slideToggle();
   });
   
   var $content31 = $(".wednesday1").hide();
   $(".toggle31").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content31.slideToggle();
   });
   
   var $content41 = $(".thursday1").hide();
   $(".toggle41").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content41.slideToggle();
   });
   
   var $content51 = $(".friday1").hide();
   $(".toggle51").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content51.slideToggle();
   });
   
   var $content61 = $(".saturday1").hide();
   $(".toggle61").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content61.slideToggle();
   });
   
   var $content71 = $(".sunday1").hide();
   $(".toggle71").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content71.slideToggle();
   });
   
   
   
   var $content81 = $(".monday2").hide();
   $(".toggle81").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content81.slideToggle();
   });
   var $content82 = $(".tuesday2").hide();
   $(".toggle82").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content82.slideToggle();
   });
   
   var $content83 = $(".wednesday2").hide();
   $(".toggle83").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content83.slideToggle();
   });
   
   var $content84 = $(".thursday2").hide();
   $(".toggle84").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content84.slideToggle();
   });
   
   var $content85 = $(".friday2").hide();
   $(".toggle85").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content85.slideToggle();
   });
   
   var $content86 = $(".saturday2").hide();
   $(".toggle86").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content86.slideToggle();
   });
   
   var $content87 = $(".sunday2").hide();
   $(".toggle87").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content87.slideToggle();
   });
   
   
   
   var $content91 = $(".monday3").hide();
   $(".toggle91").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content91.slideToggle();
   });
   var $content92 = $(".tuesday3").hide();
   $(".toggle92").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content92.slideToggle();
   });
   
   var $content93 = $(".wednesday3").hide();
   $(".toggle93").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content93.slideToggle();
   });
   
   var $content94 = $(".thursday3").hide();
   $(".toggle94").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content94.slideToggle();
   });
   
   var $content95 = $(".friday3").hide();
   $(".toggle95").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content95.slideToggle();
   });
   
   var $content96 = $(".saturday3").hide();
   $(".toggle96").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content96.slideToggle();
   });
   
   var $content97 = $(".sunday3").hide();
   $(".toggle97").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content97.slideToggle();
   });
   
   
   var $content911 = $(".monday344").hide();
   $(".toggle911").on("click", function(e) {
      // alert('sadasd');
      $(this).toggleClass("expanded");
      $content911.slideToggle();
   });
   var $content921 = $(".tuesday344").hide();
   $(".toggle921").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content921.slideToggle();
   });
   
   var $content931 = $(".wednesday344").hide();
   $(".toggle931").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content931.slideToggle();
   });
   
   var $content941 = $(".thursday344").hide();
   $(".toggle941").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content941.slideToggle();
   });
   
   var $content951 = $(".friday344").hide();
   $(".toggle951").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content951.slideToggle();
   });
   
   var $content961 = $(".saturday344").hide();
   $(".toggle961").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content961.slideToggle();
   });
   
   var $content971 = $(".sunday344").hide();
   $(".toggle971").on("click", function(e) {
      $(this).toggleClass("expanded");
      $content971.slideToggle();
   });
   
   
   function myFunc_planned_visit() {
      var planned_visit = $('#planned_visit').val();
      if (planned_visit == '1') {
         var showData_planned_visit = '<label>Planned Visit Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="planned_visit_price" class="form-control" placeholder="Price">';
         $("#planned_visit_price").html(showData_planned_visit);
      } else {
         var showData_planned_visit = '<input required type="hidden" value="0" name="planned_visit_price">';
         $("#planned_visit_price").html(showData_planned_visit);
      }
   }
   
   
   function myFunc_emergency_visit() {
      var emergency_visit = $('#emergency_visit').val();
      if (emergency_visit == '1') {
         var showData_emergency_visit = '<label> Emergency Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="emergency_price" class="form-control" placeholder="Price">';
         $("#planned_emergency_visit").html(showData_emergency_visit);
      } else {
         var showData_emergency_visit = '<input required type="hidden" value="0" name="emergency_price">';
         $("#planned_emergency_visit").html(showData_emergency_visit);
      }
   }
   
   
   function myFunc_doorstep_services_visit() {
      var medical_services = $('#medical_services').val();
      if (medical_services == '1') {
         var showData_medical_services = '<label>Select Services<span style="color: red;">*</span></label><select class="form-control" name="services[]" placeholder="Select Services" id="services">' + '<?php foreach ($common_service as $serv) { ?> <option value="<?= $serv->id ?>"> <?= $serv->service_name . '-(&#8377; ' . $serv->price . ')' ?> </option><?php } ?></select>';
         $("#doorstep_services").html(showData_medical_services);
      } else {
         var showData_medical_services = '<input required type="hidden" value="" name="services[]">';
         $("#doorstep_services").html(showData_medical_services);
      }
   }
   
   
   function myFunc_online() {
      var online = $('#online').val();
      if (online == '1') {
         var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_chat_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_video_price"><input required type="hidden" value="0" name="online_consult_audio_price">';
         $("#online_p").html(showData_online_chat_price);
         $("#online_video_p").html('');
         $("#online_audio_p").html('');
      } else if (online == '2') {
         var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_video_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_audio_price">';
         $("#online_video_p").html(showData_online_video_price);
         $("#online_p").html('');
         $("#online_audio_p").html('');
      } else if (online == '3') {
         var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_audio_price" class="form-control" placeholder="Price"><input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_video_price">';
         $("#online_audio_p").html(showData_online_audio_price);
         $("#online_p").html('');
         $("#online_video_p").html('');
      } else if (online == '4') {
         var showData_online_chat_price = '<label>Chat Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_chat_price" class="form-control" placeholder="Price">';
         $("#online_p").html(showData_online_chat_price);
   
         var showData_online_video_price = '<label>Video Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_video_price" class="form-control" placeholder="Price">';
         $("#online_video_p").html(showData_online_video_price);
   
         var showData_online_audio_price = '<label>Audio Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="online_consult_audio_price" class="form-control" placeholder="Price">';
         $("#online_audio_p").html(showData_online_audio_price);
   
      } else {
         var showData_online = '<input required type="hidden" value="0" name="online_consult_chat_price"><input required type="hidden" value="0" name="online_consult_video_price">';
         var showData_online_video_price = '<input required type="hidden" value="0" name="online_consult_video_price">';
         var showData_online_audio_price = '<input required type="hidden" value="0" name="online_consult_audio_price">';
         $("#online_p").html(showData_online);
         $("#online_video_p").html(showData_online_video_price);
         $("#online_audio_p").html(showData_online_audio_price);
      }
   }
   
   
   // Normal Appointment
   function myFunc_normal() {
      var normal = $('#normal').val();
      if (normal == '1') {
         var showData_normal = '<label>Appointment Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="normal_appointment_price" class="form-control" placeholder="Price">';
         $("#normal_appointment").html(showData_normal);
      } else {
         var showData_normal = '<input required type="hidden" value="0" name="normal_appointment_price">';
         $("#normal_appointment").html(showData_normal);
      }
   }
   
   // Normal Appointment
   function myFunc_inhouse() {
      var inhouse = $('#inhouse').val();
      if (inhouse == '1') {
         var showData_inhouse = '<label>In House Price<span style="color: red;">*</span></label><input required type="number" min="1" step="any" name="in_house_doctor_price" class="form-control" placeholder="Price">';
   
         var showData_intop = '<label>In Top<span style="color: red;">*</span></label><select class="form-control" name="in_top" placeholder="in_top" id="in_top" required><option value="1"> Yes  </option><option value="0"> No </option></select>';
   
   
         $("#inhouse_p").html(showData_inhouse);
         $("#intop_p").html(showData_intop);
      } else {
         var showData_inhouse = '<input required type="hidden" value="0" name="in_house_doctor_price">';
         var showData_intop = '<input required type="hidden" value="0" name="in_top">';
         $("#inhouse_p").html(showData_inhouse);
         $("#intop_p").html(showData_intop);
      }
   }
</script>

