<div class="content-wrapper" >
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        
       View Ratings List
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>Welcome/"><i class="fa fa-dashboard"></i>Home</a></li>
         <li class="active">View Ratings List </li>
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
            <li><!-- <a href="<?php echo base_url(); ?>speedhuntson/add_ambulance"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add Ambulance</b></button></a>-->
            <span> <!--  <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success"> -->
            </span>


              <form method="get">
                <div class="col-md-12" style="margin-bottom: 10px;">
            <span>  <input type="submit" name="get_export_data" value="Export" class="btn btn-sm btn-success">
            </span>
        </div>
             
                    

  
                       <div class="col-md-8">           
                          <div class="form-group">
                            <label>Rating</label>
                             <select name="rating" class="form-control">
                               <option value="">Select Rating</option>
                            
                                  <option value="1"   <?=isset($_GET['rating']) ? $_GET['rating'] == '1' ? 'selected':'' : ''?> >1</option>
                                  <option value="2"   <?=isset($_GET['rating']) ? $_GET['rating'] == '2' ? 'selected':'' : ''?> >2</option>
                                  <option value="3"   <?=isset($_GET['rating']) ? $_GET['rating'] == '3' ? 'selected':'' : ''?> >3</option>
                                  <option value="4"   <?=isset($_GET['rating']) ? $_GET['rating'] == '4' ? 'selected':'' : ''?> >4</option>
                                  <option value="5"   <?=isset($_GET['rating']) ? $_GET['rating'] == '5' ? 'selected':'' : ''?> >5</option>
                                 
                             </select>

                            
                          </div>
                       </div> 

                  
                      
 <div class="col-md-4" style="margin-top: 25px;">
  <input type="submit" name="submit" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Submit">&nbsp;&nbsp;

 

                     <!--     <input type="submit" name="reset" class="btn btn-fill btn-warning" style="padding: 5px 5px 5px 5px;" value="Reset"> -->
</div>

 <div class="col-md-4">
</div>
                        
                         </form>


         </ol>
           <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>
            <!-- /.box -->
            <div class="box">
               <div class="box-header">
              <!--     <h3 class="box-title">Online Consultation <?php echo $status ; ?> </h3> -->
               </div>

               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table id="" class="table table-bordered table-striped ">
                     <thead>
                        <tr>
                            <th>S.No </th>  
                            <th>User Name</th>  
                           <th>Email </th>                                        
                           <th>Mobile  </th>                                        
                           <th>Rating </th>                                        
                           <th>Review   </th>                                        
                           <th>Module </th>                                        
                           <th>Show to user   </th>                                        
                           <th>Added On</th>
                           <th>Action</th>    


                        </tr>
                     </thead> 
                       <tbody>
                       <?php if ($list): ?>
                          <?php 
                          $x=1;
                          foreach ($list as $key): ?>
                          <tr>
                            
                             <td class="center"><?php echo $x;?></td>
                           <td class="center">
                            <?php 
                               if ($key->booking_for == 0)
                               {
                                 echo $key->name ;
                               } 
                               else 
                               {
                                 $user_id= $key->user_id;
                                  $user = $this->db->where('id',$user_id)->get('user')->row();
                                   if ($user) {
                                     echo $user->name;
                                   }
                               }
                            ?>
                             </td>  
                             <td class="center">
                            <?php 
                               if ($key->booking_for == 0)
                               {
                                 echo "-";
                               } 
                               else 
                               {
                                 $user_id= $key->user_id;
                                  $user = $this->db->where('id',$user_id)->get('user')->row();
                                   if ($user) {
                                     echo $user->email;
                                   }
                               }
                            ?>
                             </td> 
                              <td class="center">
                            <?php 
                               if ($key->booking_for == 0)
                               {
                                   echo "-";
                               } 
                               else 
                               {
                                 $user_id= $key->user_id;
                                  $user = $this->db->where('id',$user_id)->get('user')->row();
                                   if ($user) {
                                     echo $user->phone ;
                                   }
                               }
                            ?>
                             </td>
                             <td class="center"><?= $key->rating  ; ?></td>
                             <td class="center"><?= $key->review  ; ?></td>
                             <td class="center">

                             
                            <?php
                               if($key->booking_for  == 1)
                               {
                                echo "Ask For Question";
                               }
                               elseif($key->booking_for  == 2)
                               {
                                echo "For Online Counsult";

                              
                               }
                               elseif($key->booking_for  == 3)
                               {
                                echo "For Life Prediction";

                              
                               }elseif($key->booking_for  == 4)
                               {
                                echo "Inperson Booking";

                              
                               }elseif($key->booking_for  == 5)
                               {
                                echo "Match Making";

                              
                               }
                             else
                               {
                                echo "By Admin";

                              
                               }

                                ?>

                             </td>
                           
                              <td><?php
                               if($key->is_shown_to_user  == 0)
                               {
                                echo "<span class='badge bg-yellow'>No</span>";
                               }
                               elseif($key->is_shown_to_user  == 1)
                               {
                                echo "<span class='badge bg-green'>Yes</span>";
                               }

                                ?>
                              </td>

                                <td class="center"><?= date("d-m-Y h:i:s A", strtotime($key->added_on )) ; ?></td>
                                                 
                           
                          <td class="center">  

                            <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-flat">Action</button>
                                    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                      <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="min-width: 101px;">
                                    
                                      <li>  <a class="btn btn-sm " href="<?php echo base_url();?>Ratings_management_ctrl/ratings_delete/<?php echo $key->id; ?>" onClick="return doconfirm()">
                              <i class="fa fa-fw fa-trash"></i>Delete</a>       
                                      </li>
                                       <li> <?php if( $key->is_shown_to_user){?>
                              <a class="btn btn-sm " href="<?php echo base_url();?>Ratings_management_ctrl/rating_status/<?php echo $key->id; ?>"> 
                              <i class="fa fa-folder-open"></i> Disable </a>           
                              <?php
                                 }
                                 else
                                 {
                                 ?>
                              <a class="btn btn-sm" href="<?php echo base_url();?>Ratings_management_ctrl/rating_active/<?php echo $key->id; ?>"> 
                              <i class="fa fa-folder-o"></i> Enable </a>
                              <?php
                                 }
                                 ?>      
                                      </li>

                                    </ul>
                                  </div>  


                              <!-- <a class="btn btn-sm bg-olive show-doctordetails"  href="javascript:void(0);"  data-id="<?php echo $doctors->id; ?>">
                              <i class="fa fa-fw fa-eye"></i> View </a> -->
                             
                             
               
                           </td>
                           

                           </tr>       
                          <?php
                          $x++;
                           endforeach ?>
                       <?php endif ?>
                     </tbody>
                     <tfoot>
                        <tr>
                                <th>S.No </th>  
                            <th>User Name</th>  
                           <th>Email </th>                                        
                           <th>Mobile  </th>                                        
                           <th>Rating </th>                                        
                           <th>Review   </th>                                        
                           <th>Module </th>                                        
                           <th>Show to user   </th>                                        
                           <th>Added On</th>
                           <th>Action</th>    
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
                <div class="row">
               <div class="col-md-12">
                  <?php echo $links; ?>
               </div>
            </div>
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

 