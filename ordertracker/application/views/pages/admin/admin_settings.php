<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
error_reporting(E_ERROR | E_PARSE);

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Settings</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/w3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/alert/jquery-confirm.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>css/alert/jquery-confirm.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>css/js/admin/admin_settings.js"></script>
</head>
<body class="w3-light-grey">

	<!-- !PAGE CONTENT! -->
	<div class="w3-main w3-padding-small" style="margin-left:120px;">

		<!-- Header -->
		<header class="w3-container" >
			<h5><b><i class="fa fa-cog"></i> Settings</b></h5>
		</header>
		<div class="w3-row-padding w3-margin-bottom">
			<div class="w3-col l12">
				<div class="col-lg-6 w3-padding-small ">
					<div class="w3-col l12 w3-small w3-margin-bottom">
						<label><i class="fa fa-envelope"></i> SetUp Email-ID</label><br>

						<form id="updateEmail">
							<div class="w3-col l8 w3-padding-right w3-margin-bottom">
								<input type="email" name="admin_email" value="<?php echo $adminDetails['status_message'][0]['admin_email']; ?>" placeholder="Enter Email-ID here..." id="admin_email" class="w3-input" required>
							</div>
							<div class="w3-col l4">
								<button type="submit" class="w3-button w3-red">Update Email-ID</button>
							</div>
						</form>

					</div>
				</div>

				<div class="col-lg-6 w3-padding-small ">
					<div class="w3-col l12 w3-small w3-margin-bottom">
						<hr class="w3-hide-large">
						<label><i class="fa fa-image"></i> SetUp Dashboard Image</label><br>

						<form id="updateDashboardImage">
							<div class="w3-col l8 w3-padding-right w3-margin-bottom">
								<input type="file" name="admin_image" id="admin_image" style="padding-bottom: 2px" class="w3-input" required onchange="readURL(this);">
							</div>
							<div class="w3-col l4">
								<button type="submit" class="w3-button w3-red">Upload Image</button>
							</div>
							<div class="w3-col l12 w3-margin-top">
								<label><i class="fa fa-arrow-down"></i> Uploaded Image</label><br>
								<img src="<?php echo DASBOARDIMAGE_PATH.$dashImage['setting_value']; ?>" onerror="this.src='<?php echo base_url();?>images/default_image.png'" id="adminImagePreview" width="auto" height="250px" alt="User Dashboard Image will be displayed here once chosen." class="img img-thumbnail w3-centerimg ">
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
		<!-- End page content -->
	</div>

	<!--  script to update email id   -->
	<script>
		$(function(){
			$("#updateEmail").submit(function(){
				dataString = $("#updateEmail").serialize();

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>admin/admin_settings/updateEmail",
					data: dataString,
           return: false,  //stop the actual form post !important!

           success: function(data)
           {
           	$.alert(data);                       
           }

       });

         return false;  //stop the actual form post !important!

     });
		});
	</script>
	<!-- script ends here -->

	<!--  script to update user dashboard image   -->
	<script>
		$(function(){
			$("#updateDashboardImage").submit(function(){
				dataString = $("#updateDashboardImage").serialize();

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>admin/admin_settings/updateDashboardImage",
					data:  new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function(data)
					{
						$.alert(data);                       
					}

				});

         return false;  //stop the actual form post !important!

     });
		});
	</script>
	<!-- script ends here -->

	<script>
	// ----function to preview selected image for profile------//
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#adminImagePreview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
// ------------function preview image end------------------//
</script>
</body>
</html>
