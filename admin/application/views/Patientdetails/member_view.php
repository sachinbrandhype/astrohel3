
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Member Details 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('Patient_details/view_patientdetails');?>">User</a></li>
        <li class="active">Member Details</li>
      </ol>
    </section>


    <div>
       <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Patient_details/exportCSV_member/<?php echo $patientID;?>/"><button class="btn add-new" type="button"><b> Export Member List</b></button></a>
         </ol>

    </div>
<section class="invoice">
      <!-- title row -->
       <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
           <i class="fas fa-stethoscope"></i>
           <?php $p_id = $this->db->where('id',$patientID)->get('user')->row();
           echo $p_id->name;?>
           
            <small class="pull-right"></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->

       <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Member  View</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                          
                           <th>Member ID</th>
                           <th>Member Name</th> 
                           <th>DOB</th>   
                           <th>Gender</th>   
                           <th>Place Of Birth</th>   
                           <th>Relation</th>   
                       
                           
                          
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                        if(!empty($data))
                        {
                           foreach($data as $mm) {         
                           ?>
                        <tr>
                         
                           <td class="center"> <?=$mm->id?></td>
                           <td class="center"> <?=$mm->member_name?></td>
                           <td class="center"><?=$mm->member_dob ?></td>
                           <td class="center"> <?=$mm->member_gender?></td>
                           <td class="center"> <?=$mm->place_of_birth?></td>
                           <td class="center"><?=$mm->relation?></td>
                           
                         
                        </tr>
                        <?php
                           }}
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                        <th>Member ID</th>
                           <th>Member Name</th> 
                           <th>DOB</th>   
                           <th>Gender</th>   
                           <th>Place Of Birth</th>   
                           <th>Relation</th>     
                       
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
     
      <!-- /.row -->

      <!-- Table row -->

      <div class="row">
        <div class="col-xs-12 table-responsive">
        
        </div>
        <!-- /.col -->
      </div>



      <!-- /.row -->
  
      <!-- /.row -->

      <!-- this row will not appear when printing -->
    </section>
      <div class="clearfix"></div>
  </div>