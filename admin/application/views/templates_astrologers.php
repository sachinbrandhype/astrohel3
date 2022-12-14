<!DOCTYPE html>
<html>
  <?php
  $this->load->view('Templates_astrologers/header-script');
  ?>
  <body class="hold-transition <?php echo $this->config->item("theme_color"); ?> sidebar-mini skin-blue">
  	<div class="wrapper">
	  <?php
	  $this->load->view('Templates_astrologers/header-menu');
	  $this->load->view('Templates_astrologers/left-menu-old');
	  $this->load->view($page);

	  $this->load->view('Templates_astrologers/footer');
      ?>    
    </div>
  <?php
  $this->load->view('Templates_astrologers/footer-script');
  ?>
  </body>
</html>
