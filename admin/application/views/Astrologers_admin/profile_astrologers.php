<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         Astrologers Profile 
      </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-language" aria-hidden="true"></i>Home</a></li>
            <li class="active"> Astrologers Profile </li>
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
                        <h3 class="box-title"></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post" data-parsley-validate="" class="validate" enctype="multipart/form-data">

                        <div class="box-body">
                            <div class="col-md-6">

                      <div class="form-group has-feedback">
                          <label for="exampleInputEmail1">Name <span style="color: red;">*</span></label>
                          <input type="text" class="form-control" value="<?php echo $data->name; ?>" data-parsley-trigger="change" data-parsley-minlength="2" required="" name="name">
                          <span class="glyphicon  form-control-feedback"></span>
                      </div>

                     
                      <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Mobile<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" data-parsley-trigger="change" data-parsley-minlength="2" required name="phone" value="<?php echo $data->phone; ?>"  placeholder="Mobile">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>
               

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Email <span style="color: red;">*</span></label>
                            <input type="text" class="form-control"  data-parsley-trigger="change" data-parsley-minlength="2"  required name="email" value="<?php echo $data->email; ?>"  placeholder="Email ">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                  

                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Languages <span style="color: red;">*</span></label>
                            <input type="text" class="form-control"  data-parsley-trigger="change" data-parsley-minlength="2"  required name="languages" value="<?php echo $data->languages; ?>"  placeholder="Languages ">
                            <span class="glyphicon  form-control-feedback" ></span>
                    </div>

                  


                     <div class="form-group has-feedback">
                            <label for="exampleInputEmail1">Gender <span style="color: red;">*</span></label>
                            <select name="gender" class="form-control" required>
                               <option value="">Select</option>
                               <option value="male" <?=$data->gender == "male" ? 'selected' : ''?>>Male</option>
                               <option value="female" <?=$data->gender ==  "female" ? 'selected' : ''?>>Female</option>
                            </select>
                    </div>

                  

                     <div class="form-group has-feedback">
                     <label for="exampleInputEmail1"> Image</label>
                     <div class="row">
                        <div class="col-md-6">
                           <input type="file" class="form-control" name="image">
                        </div>
                        <div class="col-md-6">
                           <img height="50" width="70" alt="your image" src="<?php echo base_url('/')."uploads/astrologers/";?><?=$data->image?>" name=""/>
                           <input type="hidden" name="old_image" value="<?php echo $data->image; ?>" class="form-control">
                        </div>
                     </div>
                     <span class="glyphicon  form-control-feedback"></span>
                  </div>

                 
                       
                   

                             <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Update</button>
                  </div>


                                
            </div>

             <div class="col-md-6">

                   

                  </div>
           
        </div>
        </form>
</div>
<!-- /.box -->
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
