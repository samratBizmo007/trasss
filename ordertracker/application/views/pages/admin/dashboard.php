<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
error_reporting(E_ERROR | E_PARSE);

?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/w3.css">
  <!-- <link rel="stylesheet" href="assets/css/alert/jquery-confirm.css"> -->
  <script type="text/javascript" src="<?php echo base_url(); ?>css/bootstrap/jquery-3.1.1.js"></script>
  <!-- <script type="text/javascript" src="assets/css/alert/jquery-confirm.js"></script> -->
</head>
<body class="w3-light-grey">

  <!-- !PAGE CONTENT! -->
  <div class="w3-main w3-padding-small" style="margin-left:120px;">

    <!-- Header -->
    <header class="w3-container" >
      <h5><b><i class="fa fa-user-secret"></i> Dashboard</b></h5>
    </header>
    <div class="w3-row-padding w3-margin-bottom">
      <div class="w3-third">
        <div class="w3-container w3-blue w3-padding-16">
          <div class="w3-left"><i class="fa fa-check-square w3-jumbo"></i></div>
          <div class="w3-right">
            <span class="w3-xxlarge"><?php echo $orderCount['activeOrders']; ?></span>
          </div>
          <div class="w3-clear"></div>
          <h4>Active Orders</h4>
        </div>
      </div>
      <div class="w3-third">
        <div class="w3-container w3-green w3-padding-16">
          <div class="w3-left"><i class="fa fa-info-circle w3-jumbo"></i></div>
          <div class="w3-right">
            <span class="w3-xxlarge"><?php echo $orderCount['openOrders']; ?></span>
          </div>
          <div class="w3-clear"></div>
          <h4>Open Orders</h4>
        </div>
      </div>
      <div class="w3-third">
        <div class="w3-container w3-red w3-padding-16">
          <div class="w3-left"><i class="fa fa-history w3-jumbo"></i></div>
          <div class="w3-right">
            <span class="w3-xxlarge"><?php echo $orderCount['closeOrders']; ?></span>
          </div>
          <div class="w3-clear"></div>
          <h4>Closed Orders</h4>
        </div>
      </div>      
    </div>
    <!-- End page content -->
  </div>

</body>
</html>
