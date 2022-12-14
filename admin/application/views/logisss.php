<?php $settings = get_icon();

// print_r($settings);die; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Log in</title>
     <?php if(empty($settings->favicon)){?>

      <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png"/>
<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png"/>

     <!--   <img src="<?php echo base_url(); ?>assets/images/favicon.png" class="img-circle" alt="User Image" style="height: 65px; border-radius: inherit;" > -->
      <?php }else{?>
         <link rel="icon" href="<?php echo base_url().'/'.$settings->favicon ;?>" type="image/png" sizes="16x16">

      <?php }?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page" style="background-image: url(<?=base_url('assets/images').'/wp2741754.jpg'?>); background-size: cover;background-position: 10%;">
    <div class="login-box">
      <div class="login-logo">
        <a  href="<?php echo base_url(); ?>">
            <?php //if(empty($settings->logo)){?>
                           <img src="<?php echo base_url(); ?>uploads/common/logo.png" class="img-circle" alt="User Image" style=" width: 50%; border-radius: inherit;" >
                        

      
        </a><br>
        <!-- <a href="<?php echo base_url(); ?>"><b><?php echo $settings->title; ?></b>Admin</a> -->
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php if(validation_errors()) { ?>
            <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
            </div>
            <?php } ?>
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-xs-12 right">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

  </body>
</html>
