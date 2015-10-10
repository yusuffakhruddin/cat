<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  	<noscript>
  		<meta http-equiv="refresh" content="0; url=<?php echo base_url(); ?>adm/noscript">
  	</noscript>
    
    <title>Computer Based Test (CBT) </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>___/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>___/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>___/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <!-- js -->
    <script src="<?php echo base_url(); ?>___/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>___/js/app.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>___/js/jquery.countdown.min.js" type="text/javascript"></script>
		
    <script type="text/javascript">
    var _base = "<?php echo base_url(); ?>";
    </script>

    <script src="<?php echo base_url(); ?>___/js/aplikasi.js"></script>
  
  
	</head>
  
  <body class="skin-blue">

    <?php $this->load->view($p); ?> 
	
  </body>


</html>