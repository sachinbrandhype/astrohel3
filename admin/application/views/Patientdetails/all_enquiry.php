<style type="text/css">
   .pagination-sm>li>a, .pagination-sm>li>span {
       padding: 20px 20px;
       font-size: 12px;
       line-height: 1.5;
   }
</style>
<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Enquiry Details
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-male"></i>Home</a></li>
         <li class="active"> Enquiry Details</li>
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
           <?php $id = $this->uri->segment(2);?>
           <?php $hospital_id = $this->input->get('hospital_id');?>
          <div class="col-xs-12">
           
             <div class="box">
               <div class="box-header">
                 <h3 class="box-title">Enquiry Details</h3>
                 <div class="box-tools" style="margin-top: -18px;">
                  
                  <a href="<?=base_url('patient_details/all_enquiry_export/'.$id.'/'.$hospital_id)?>"><button class="btn bg-purple btn-flat margin">Export</button></a>
                 </div>
               </div>
               <!-- /.box-header -->
               <div class="row">
                <form method="">
                  <div class="col-xs-4">
                    <label>Hospital List</label>
                      <select class="form-control" name="hospital_id" required="">
                        <option value="">Select Hospital</option>

                        <?php if(!empty($hospital))
                        {
                          foreach ($hospital as $h) {
                            ?>
                          
                        <option value="<?=$h->id?>" <?php if(!empty($this->input->get('hospital_id')) && ($this->input->get('hospital_id') == $h->id))
                        { echo "selected";} else{ echo "";}?>><?=$h->hospital_name?></option>
                       <?php }
                        } ?>
                      </select>
                  </div>
                  <div class="col-xs-4"> 
                   <br>
                  
                    <input type="submit" name="submit" value="Submit" class="btn btn-info">
                  
                     <a href="<?=base_url('patient_details/'.$id)?>" class="btn btn-success">Reset</a>
                  </div>
                  <div class="col-xs-4"> 
                   <br>
                   <br>
                   
                  </div>
                </form>
                 

               </div>
               <div class="box-body table-responsive no-padding" style="margin-top: 50px;">
                 <table class="table table-hover">
                   <tr>
                     <th>ID</th>
                     <th>Hospital Name</th>
                     <th>Patient</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Mobile</th>
                     <th>City</th>
                     <th>Subject</th>
                     <th>Message</th>
                     <th>Status</th>
                     <th>Added On</th>
                   </tr>
                  <?php
                     $i=1; 
                     if(!empty($all_enquiry))
                      {
                        foreach($all_enquiry as $e) 
                       {         
                       ?>
                        <tr>
                           <td class="center"><?php echo $i; ?></td>
                           <td class="center"><?php $hospital = $this->db->get_where('hospital',array('id' => $e->hospital_id))->row();
                           if(!empty($hospital))
                           {
                            echo $hospital->hospital_name;
                           }
                           else
                           {
                            echo "Medeor Hospital";
                           } ?></td>
                           <td class="center"><?php $patient = $this->db->get_where('patient',array('id' => $e->patient_id))->row();
                            if(!empty($patient))
                           {
                            echo $patient->patient_firstname;
                           }
                           else
                           {
                            echo "Guest";
                           }  ?></td>
                           <td class="center"><?php echo $e->name; ?></td>
                           <td class="center"><?php echo $e->email; ?></td>
                           <td class="center"><?php echo $e->phone; ?></td>
                           <td class="center"><?php echo $e->city; ?></td>
                           <td class="center"><?php echo $e->subject; ?></td>
                           <td class="center"><?php echo $e->yourmessage; ?></td>
                           <td class="center"><?php if($e->status == 0)
                           { 
                            // echo "New Enquiry";
                            ?>
                           
                             <li class="dropdown form-control" style="list-style: none;" >
                              <a href="#" data-toggle="dropdown">Action </a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a onclick="return confirm('Are You Sure this enquiry is Solved?')" href="<?=base_url('patient_details/enquiry_status_solved').'/'.$e->id?>">Solved</a></li>
                                <li><a onclick="return confirm('Are You Sure to Reject this enquiry?')" href="<?=base_url('patient_details/enquiry_status_unsolved/').'/'.$e->id?>">Reject/Unsolved</a></li>
                              </ul>
                            </li>
                         
                            <?php
                           }
                           elseif($e->status == 1)
                           {
                            echo "Completed";
                           }
                           else{
                            echo "Not Resolved";
                           } ?></td>
                           <td class="center"><?php echo date("d-m-Y H:i:s", $e->added_on); ?></td>
                        </tr>
                    <?php
                       $i++;
                      }
                    }
                    ?>
                   
                 </table>
                 <div class="box-tools">
                  <?php if (isset($links)) { ?>
                  <ul class="pagination pagination-sm pull-right" style="margin-top: 35px !important;">
                     <?php echo $links ?> 
                  </ul>
                 <?php } ?>
                  </div>
               </div>
               <!-- /.box-body -->
             </div>
             <!-- /.box -->
           
      </div>
         
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<div class="modal fade modal-wide" id="popup-patientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">View Patient Details</h4>
         </div>
         <div class="modal-patientbody">
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