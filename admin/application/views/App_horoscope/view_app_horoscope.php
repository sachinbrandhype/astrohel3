<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        View App Horoscope
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
        
         <li class="active">View App Horoscope</li>
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

            <li></li>
             <li>
         </ol>
        

            <!-- /.box -->
            <div class="box">
               <div class="box-header">
                  
               </div>

               <!-- /.box-header -->
               <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped datatable">
                     <thead>
                        <tr>
                           <th>S No.</th>                                           
                           <th>For </th>                                           
                           <th>Title </th>                                           
                           <th>Zodiac Name </th>                                           
                           <th>Start Date </th>                                           
                           <th>End Date </th>                                           
                           <th>Month </th>                                           
                           <th>Year </th>                                           
                           <th>Video Url </th>                                           
                           <th>Status </th> 
                            <th>Added On </th>                                                        
                           <th>Action</th>                                           
                        </tr>
                     </thead> 
                     <tbody>
                        <?php
                           foreach($data as $card) {        
                           ?>
                        <tr>
                                                          
                           <td class="center"><?php echo $card->id; ?></td>                                   
                           <td class="center"><?php echo $card->for_; ?></td>                                   
                           <td class="center"><?php echo $card->title;?></td>                                                                      
                           <td class="center"><?php echo $card->zodiacName; ?></td>                                   
                           <td class="center"><?php  
                           if (empty($card->start_date)) 
                           {
                            echo "--";
                           } else {
                             echo  date("d-m-Y", strtotime($card->start_date)) ;
                           }
                          ?></td>  
                           <td class="center"><?php  
                           if (empty($card->end_date)) 
                           {
                            echo "--";
                           } else {
                             echo  date("d-m-Y", strtotime($card->end_date)) ;
                           }
                          ?></td>                                                                      
                                                                                          
                           <td class="center"><?php echo $card->month;?></td>
                           <td class="center"><?php echo $card->year;?></td>


                           <td class="center"> <a class="btn btn-sm btn-primary" target=”_blank” href="<?=$card->video_url?>">
                            Url Link</a></td>

                            <td><span class="center label  <?php if($card->status == '1'){
                              echo "label-success";
                              }
                              else{ 
                              echo "label-warning"; 
                              }
                              ?>"><?php if($card->status == '1')
                              {
                              echo "enable";
                              }
                              else{ 
                              echo "disable"; 
                              }
                              ?></span> 
                                      </td>

                                       <td class="center"><?php echo date("d-m-Y h:i:s A",  strtotime($card->added_on));?></td>

                           <td>
                           <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>App_horoscope_ctrl/edit_app_horoscope/<?php echo $card->id."/".$card->for_; ?>">
                              <i class="fa fa-fw fa-edit"></i>Edit</a>
                       
                           <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>App_horoscope_ctrl/delete_app_horoscope/<?php echo $card->id; ?>" onClick="return doconfirm()">
                           <i class="fa fa-fw fa-trash"></i>Delete</a> 
                           </td>                                                
                        </tr>
                        <?php
                           }
                           ?>
                     </tbody>
                     <tfoot>
                        <tr>
                          <th>S No.</th>                                           
                           <th>For </th>                                           
                           <th>Title </th>  
                           <th>Zodiac Name </th>                                           
                           <th>Start Date </th>                                           
                           <th>End Date </th>                                           
                           <th>Month </th>                                           
                           <th>Year </th>                                           
                           <th>Video Url </th>                                           
                           <th>Status </th>                                           
                           <th>Added On </th>                                           
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
<script>
   
   base_url = "<?php echo base_url(); ?>";
   config_url = "<?php echo base_url(); ?>";
   


    </script>
 