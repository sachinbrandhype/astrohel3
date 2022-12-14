<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit App Horoscope 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
         <li class="active">Edit App Horoscope</li>
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
          
           <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php $page_for =  $this->uri->segment(4); 
              // print_r($page_for) ; die; 
              
              if ($page_for == "week") {
                 ?>
                 <li  class="active"><a href="#week" data-toggle="tab">Week</a></li>

                 <?php
              } elseif ($page_for == "month") {
                 ?>
                 <li class="active"><a href="#settings" data-toggle="tab">Month</a></li>
                 <?php
              } elseif ($page_for == "year") {
                 ?>
                 <li class="active"><a href="#settings11" data-toggle="tab">Year</a></li>
                 <?php
              }
              
              ?>
             
              <!-- <li><a href="#week" data-toggle="tab">Week</a></li>
              <li><a href="#settings" data-toggle="tab">Month</a></li>
              <li><a href="#settings11" data-toggle="tab">Year</a></li> -->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="day">
             
            <form role="form"  method="post" action="" id="doctor banner_reg" data-parsley-validate="" class="form-horizontal" enctype="multipart/form-data" >

                <?php $page_for =  $this->uri->segment(4); 

                if ($page_for == "month" || $page_for == "year") {
                 ?>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Zodiac Name </label>

                    <div class="col-sm-10">


                         <select class="form-control" name="zodiacName" disabled >
                           <option value="aries" <?php echo ($data->zodiacName == 'aries')?'selected':'' ?>>Aries</option>
                           <option value="taurus" <?php echo ($data->zodiacName == 'taurus')?'selected':'' ?>>Taurus</option>
                           <option value="gemini" <?php echo ($data->zodiacName == 'gemini')?'selected':'' ?>>Gemini</option>
                           <option value="cancer" <?php echo ($data->zodiacName == 'cancer')?'selected':'' ?>>Cancer</option>
                           <option value="leo" <?php echo ($data->zodiacName == 'leo')?'selected':'' ?>>Leo</option>
                           <option value="virgo" <?php echo ($data->zodiacName == 'virgo')?'selected':'' ?>>Virgo</option>
                           <option value="libra" <?php echo ($data->zodiacName == 'libra')?'selected':'' ?>>Libra</option>
                           <option value="scorpio" <?php echo ($data->zodiacName == 'scorpio')?'selected':'' ?>>Scorpio</option>
                           <option value="sagittarius" <?php echo ($data->zodiacName == 'sagittarius')?'selected':'' ?>>Sagittarius</option>
                           <option value="capricorn" <?php echo ($data->zodiacName == 'capricorn')?'selected':'' ?>>Capricorn</option>
                           <option value="aquarius" <?php echo ($data->zodiacName == 'aquarius')?'selected':'' ?>>Aquarius</option>
                           <option value="pisces" <?php echo ($data->zodiacName == 'pisces')?'selected':'' ?>>Pisces</option>
                      </select>


                    
                  </div>
                </div>
                <?php
                }
                 ?>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Title</label>

                    <div class="col-sm-10">
                      <input type="text" name="title" class="form-control" value="<?php echo $data->title; ?>" id="title" placeholder="title">
                 
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Video Url</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control"  value="<?php echo $data->video_url; ?>"  name="video_url" id="video_url" placeholder="Video Url">
                    </div>
                  </div> 
                 
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" name="description" placeholder="Description"><?php echo $data->description; ?></textarea>
                    </div>
                  </div>


                 
                   <?php
               $page_for =  $this->uri->segment(4); 
              if ($page_for == "day" ) 
              {
                ?>
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Start Date</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" value="<?php echo $data->start_date; ?>"   name="start_date" id="start_date" placeholder="start_date">
                    </div>
                  </div>
                 <?php
              } elseif ($page_for == "week") {
                 ?>

                 <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Start Date</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" value="<?php echo $data->start_date; ?>"   name="start_date" id="start_date" placeholder="start_date" readonly>
                    </div>
                  </div>

                   <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">End Date</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" value="<?php echo $data->end_date; ?>"   name="end_date" id="end_date" placeholder="video_url" readonly>
                    </div>
                  </div>
                 <?php
              } elseif ($page_for == "month") {
                 ?>
                 <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Month</label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="month" disabled>
                          <?php
                              for ($i=1; $i<=12; $i++)
                              {
                                  ?>

                                     <option value="<?php echo  $i; ?>"  <?php echo ($i==$data->month)?"selected":""?> ><?php echo $i; ?></option>

<!-- 
                                      <option value="<?php echo $i;?>"><?php echo $i;?></option> -->
                                  <?php
                              }
                          ?>
                          </select>


                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Year</label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="year" disabled>
                          <?php
                              $currentYear = date('Y');
                                          foreach (range(2010 , 2040) as $value) 
                                       {
                                  ?>
                                      <option value="<?php echo  $value; ?>"  <?php echo ($value==$data->year)?"selected":""?> ><?php echo $value; ?></option>
                                     <!--  <option value="<?php echo $value;?>"><?php echo $value;?></option> -->
                                  <?php
                              }

                              ?>
                          </select>


                    </div>
                  </div>
                 <?php
              } elseif ($page_for == "year") {
                 ?>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Year</label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="year" disabled>
                          <?php
                              $currentYear = date('Y');
                                          foreach (range(1990 , 2080) as $value) 
                                       {
                                  ?>
                                      <option value="<?php echo  $value; ?>"  <?php echo ($value==$data->year)?"selected":""?> ><?php echo $value; ?></option>
                                     <!--  <option value="<?php echo $value;?>"><?php echo $value;?></option> -->
                                  <?php
                              }

                              ?>
                          </select>


                    </div>
                  </div>
                 <?php
              }
              
              ?>



                    <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-10">
                      <input type="radio" id="complaintinput2" name="status" value="1" <?php echo ($data->status == '1')?'checked':'' ?>> Active
                        <input type="radio" id="complaintinput2" name="status" value="0"
                           <?php echo ($data->status == '0')?'checked':'' ?>> Inactive 
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
               
               
                <!-- /.post -->
              </div>
              
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>









           </div>
         </div>
   </section>
   <!-- /.content -->
</div>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'description' );
</script>
