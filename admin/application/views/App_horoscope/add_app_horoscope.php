<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add App Horoscope 
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
         <li class="active">Add App Horoscope</li>
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
             <!--  <li class="active"><a href="#day" data-toggle="tab">Day</a></li> -->
              <li class="active"><a href="#week" data-toggle="tab">Week</a></li>
              <li><a href="#settings" data-toggle="tab">Month</a></li>
              <li><a href="#settings11" data-toggle="tab">Year</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="day">
             
           <!--  <form role="form"  method="post" action="<?php echo base_url('App_horoscope_ctrl/add_app_horoscope')?>" id="doctor banner_reg" data-parsley-validate="" class="form-horizontal" enctype="multipart/form-data" >
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Title<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" name="title" class="form-control" id="title" placeholder="Title">
                      <input type="hidden" name="for_" class="form-control" value="day" id="title" placeholder="Title">
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Video Url<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" class="form-control" name="video_url" id="video_url" placeholder="Video Url">
                    </div>
                  </div> 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Start Date</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="start_date" id="start_date" placeholder="video_url">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" name="description" placeholder="Description"></textarea>
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-10">
                    <input type="radio" id="complaintinput2" name="status" value="1" checked>Active&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="0"> Inactive
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
                -->
               
      
              </div>
              <!-- /.tab-pane -->
              <div class="active tab-pane" id="week">
                <!-- The week -->
                     <form role="form"  method="post" action="<?php echo base_url('App_horoscope_ctrl/add_app_horoscope')?>" id="doctor banner_reg" data-parsley-validate="" class="form-horizontal" enctype="multipart/form-data" >
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Title<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" name="title" class="form-control" id="title" placeholder="Title">
                      <input type="hidden" name="for_" class="form-control" value="week" id="title" placeholder="Title">
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Video Url<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" class="form-control" name="video_url" id="video_url" placeholder="Video Url">
                    </div>
                  </div> 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Start Date</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="start_date" id="start_date" placeholder="video_url">
                    </div>
                  </div>  

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">End Date</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="end_date" id="end_date" placeholder="end_date">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" name="description" placeholder="Description"></textarea>
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-10">
                    <input type="radio" id="complaintinput2" name="status" value="1" checked>Active&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="0"> Inactive
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              
              <div class="tab-pane" id="settings">
                     <form role="form"  method="post" action="<?php echo base_url('App_horoscope_ctrl/add_app_horoscope')?>" id="doctor banner_reg" data-parsley-validate="" class="form-horizontal" enctype="multipart/form-data" >

                 <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Zodiac Name <span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="zodiacName" required="">
                           <option value="aries">Aries</option>
                           <option value="taurus">Ttaurus</option>
                           <option value="gemini">Gemini</option>
                           <option value="cancer">Cancer</option>
                           <option value="leo">Leo</option>
                           <option value="virgo">Virgo</option>
                           <option value="libra">Libra</option>
                           <option value="scorpio">Scorpio</option>
                           <option value="sagittarius">Sagittarius</option>
                           <option value="capricorn">Capricorn</option>
                           <option value="aquarius">Aquarius</option>
                           <option value="pisces">Pisces</option>
                      </select>


                    </div>
                  </div>


                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Title<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" name="title" class="form-control" id="title" placeholder="Title">
                      <input type="hidden" name="for_" class="form-control" value="month" id="title" placeholder="Title">
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Video Url<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" class="form-control" name="video_url" id="video_url" placeholder="Video Url">
                    </div>
                  </div> 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Month</label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="month">
                          <?php
                              for ($i=1; $i<=12; $i++)
                              {
                                  ?>
                                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                  <?php
                              }
                          ?>
                          </select>


                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Year</label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="year">
                          <?php
                              $currentYear = date('Y');
                                          foreach (range(1990 , 2080) as $value) 
                                       {
                                  ?>
                                      <option value="<?php echo $value;?>"><?php echo $value;?></option>
                                  <?php
                              }

                              ?>
                          </select>


                    </div>
                  </div>


                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" name="description" placeholder="Description"></textarea>
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-10">
                    <input type="radio" id="complaintinput2" name="status" value="1" checked>Active&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="0"> Inactive
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>


              <div class="tab-pane" id="settings11">
                     <form role="form"  method="post" action="<?php echo base_url('App_horoscope_ctrl/add_app_horoscope')?>" id="doctor banner_reg" data-parsley-validate="" class="form-horizontal" enctype="multipart/form-data" >

                        <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Zodiac Name<span style="color: red;">*</span> </label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="zodiacName" required="">
                           <option value="aries">Aries</option>
                           <option value="taurus">Taurus</option>
                           <option value="gemini">Gemini</option>
                           <option value="cancer">Cancer</option>
                           <option value="leo">Leo</option>
                           <option value="virgo">Virgo</option>
                           <option value="libra">Libra</option>
                           <option value="scorpio">Scorpio</option>
                           <option value="sagittarius">Sagittarius</option>
                           <option value="capricorn">Capricorn</option>
                           <option value="aquarius">Aquarius</option>
                           <option value="pisces">Pisces</option>
                      </select>


                    </div>
                  </div>



                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Title<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" name="title" class="form-control" id="title" placeholder="title">
                      <input type="hidden" name="for_" class="form-control" value="year" id="title" placeholder="Title">
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <label for="inputName"  class="col-sm-2 control-label">Video Url<span style="color: red;">*</span></label>

                    <div class="col-sm-10">
                      <input type="text" required="" class="form-control" name="video_url" id="video_url" placeholder="Video Url">
                    </div>
                  </div> 
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Year</label>

                    <div class="col-sm-10">
                  

                      <select class="form-control" name="year">
                          <?php
                              $currentYear = date('Y');
                                      foreach (range(2010 , 2040) as $value) 
                                       {
                                  ?>
                                      <option value="<?php echo $value;?>"><?php echo $value;?></option>
                                  <?php
                              }

                              ?>
                          </select>


                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" name="description" placeholder="Description"></textarea>
                    </div>
                  </div>

                    <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-10">
                    <input type="radio" id="complaintinput2" name="status" value="1" checked>Active&nbsp;&nbsp;
                        <input type="radio" id="complaintinput2" name="status" value="0"> Inactive
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>

              <!-- /.tab-pane -->
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
