<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <?php
         $uri = $this->uri->segment(4);
              if ($uri == "approved") 
               {
                 $aaa = "Approved";
               } 
               elseif ($uri == "pending") 
               {
                  $aaa = "Pending";
               }
               elseif ($uri == "disable") 
               {
                   $aaa = "Disable";
               }
         ?>
        <?php echo $aaa ; 

  //   $uri = $this->uri->segment(4);

  ?> Astrologer's 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-user-md"></i>Home</a></li>
         <li class="active"><?php echo $aaa ; ?> Astrologer's</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
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
         <div class="col-xs-12">
            <ol class="breadcrumb">
               <li>
                <!--   <a href="<?php echo base_url(); ?>sd/astrologers/add_astrologers"><button class="btn add-new" style="float: right;" type="button"><b><i class="fa fa-fw fa-plus" ></i> Add Astrologer</b></button></a> -->
                  <form method="get">

                    <!--   <div class="col-md-12" style="margin-bottom: 10px;">
                        <span>  <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success">
                        </span>
                    </div> -->


                    <div class="col-md-4">           
                        <div class="form-group">
                          <label> Date To</label>
                          <input type="date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>"  class="form-control" name="start_date" id="from">
                        </div>
                     </div>

                     <div class="col-md-4">           
                        <div class="form-group">
                            <label> Date From</label>
                          <input type="date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>"  class="form-control" name="end_date" id="to">
                                    
                        </div>
                     </div>


                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Astrologer Name</label>

                             <input type="text" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>"  class="form-control" name="name" id="from">

                        </div>
                     </div>

                      <div class="col-md-4">           
                        <div class="form-group">
                          <label>Email</label>
                           <input type="text" value="<?= isset($_GET['email']) ? $_GET['email'] : '' ?>"  class="form-control" name="email" id="from">
                        </div>
                     </div>


                     <div class="col-md-4">           
                        <div class="form-group">
                          <label>Mobile</label>
                           <input type="text" value="<?= isset($_GET['phone']) ? $_GET['phone'] : '' ?>"  class="form-control" name="phone" id="from">
                        </div>
                     </div>


                     <div class="col-md-4" style="margin-top: 25px;">
                        <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Submit">&nbsp;&nbsp;

                        <!--   <a class="btn btn-fill btn-warning"  href="<?php echo base_url('sd/astrologers/astologers_list/');?>">
                              </i> Reset </a> -->


                  
                     </div>
                     <div class="col-md-4"></div>
                  </form>
            </ol>
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  <!--   <h3 class="box-title"> View Doctor Details</h3> -->
               </div>
               <!-- /.box-header -->
               <div class="box-body table-responsive text-nowrap">
                  <table id="" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Mobile Number</th>
                           
                           <th>Live Status</th>
                           <th>Position</th>
                           <th>Status</th>
                        
                           <th width="">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           if ($data) 
                           {
                             $x=1;
                              foreach($data as $a) {			 
                              ?>
                        <tr>
                           <td class="center"><?php echo $x; ?></td>
                           <td class="center"><?php echo $a->name; ?></td>
                           <td class="center"><?php echo $a->phone; ?></td>
                    
                           <td class="center">
                              <center>
                                 <?php 
                                    if($a->online_status == 0)
                                      {
                                       ?>
                                 <img src="<?php echo base_url(); ?>uploads/Oval.png" class="img-circle" alt="User Image" style=" border-radius: inherit;height: 10px;" >
                                 <?php
                                    }
                                    elseif($a->online_status == 1)
                                    {
                                     ?>
                                 <img src="<?php echo base_url(); ?>uploads/Oval_copy.png" class="img-circle" alt="User Image" style="border-radius: inherit;height: 10px;" >
                                 <?php
                                    }
                                    ?>   
                              </center>
                           </td>

                            <td class="center"><?php
                            $uri = $this->uri->segment(4);
                         if ( $uri == "chat") {
                             echo $a->chat_position;
                            }elseif( $type == "video"){
                               echo $a->video_position;
                            }
                            else{
                                echo $a->audio_position;
                            }
                             ?></td>


                        
                           <td><span class="center label  <?php if($a->status == '1'){
                              echo "label-success";
                              }
                              else{ 
                              echo "label-warning"; 
                              }
                              ?>"><?php if($a->status == '1')
                              {
                              echo "Activated ";
                                      }
                                      else{ 
                                      echo "Deactivated "; 
                              }
                              ?></span> 
                           </td>

                             <td class="center">
                               <a data-toggle="modal" data-target="#modal-info_rm" data-backdrop="static"  data-keyboard="false" onclick="return ReAssignrefund_rm('<?php echo $a->id;?>')" class="btn btn-sm btn-primary">Position</a> 
                             </td>


                           

                        </tr>
                        <?php
                           $x++;
                            }
                             } 
                           
                            ?>
                     </tbody>
                     <tfoot>
                        <tr>
                            <th>ID</th>
                           <th>Name</th>
                           <th>Mobile Number</th>
                           
                           <th>Live Status</th>
                           <th>Position</th>
                           <th>Status</th>
                          
                           <th width="">Action</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <?php echo $links; ?>
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


<div class="modal modal-info fade" id="modal-info_rm">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header md-large">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Position Assgin</h4>
               
              </div>
              <div class="modal-body">
                <form action="<?=base_url('sd/astrologers/astrologers_position')?>" role="form" id="newModalForm" method="POST">
 
                <p>
              
                  <?php 
                   $types = $this->uri->segment(4);
                       
                             ?>
                    <input type="hidden" name="type" value="<?php echo $types; ?>">
                    <input type="hidden" name="booking_ide" id="booking_ide" class="booking_ide">
                    <label>Position</label> 
                    <input type="number" name="position" id="Position" class="form-control" min="1">
                        <br>
                        <br>
                  <button type="submit" class="btn btn-outline">Save changes</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>



<div class="modal fade modal-wide" id="popup-doctorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">View Doctor Details</h4>
         </div>
         <div class="modal-doctorbody">
         </div>
         <div class="business_info">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal modal-info fade" id="modal-danger">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Approve Expert </h4>
            <span id="spinner" class="myspinner" >
            <img id="loading-image"  src="<?=base_url('uploads/loader.gif')?>" style='width: 50px;height: 50px; display: none;margin-left: 50%;' ></span>
            <span id = "transp" style="display: none;"></span>
         </div>
         <div class="modal-body">
            <p> Do you want to approvae the expert!<br><br>
               <input type="hidden" name="approval_id" id="approval_id" class="approval_id">
               <button type="button" class="btn btn-outline " onclick="myapprovalFunction()" >Yes</button>
               <button type="button" class="btn btn-outline" data-dismiss="modal">No</button>
            </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>


<script>
   
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   


    </script>
<script type="text/javascript">
      function ReAssignrefund_rm(id)
      {
        var id = id;
       // alert(id);
         $('#booking_ide').val(id);
      }
</script>

<script type="text/javascript">
   function ReAssign11(id)
   {
     var id = id;
   // alert(id);
   $('#approval_id').val(id);
     
   }
</script>
<script>
   function myapprovalFunction() {
      var approval_id = $(".approval_id").val();
   
       $.ajax({
              type: "POST",
              url: "<?php echo base_url('sd/astrologers/approval_astrologers/');?>",
              data: {approval_id: approval_id},
               method: "post",
             beforeSend: function(){
             $("#loading-image").show();
             },
             complete: function(){
             $("#loading-image").hide();
             },
              success: function(data) {
               console.log(data);
              location.reload();
               // $("#content").load("<?php echo base_url();?>Doctordetail_ctrl/view_approval_doctordetails");
              }
          }); 
   }
</script>

