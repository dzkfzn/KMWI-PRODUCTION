<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<link rel="icon" href="<?= base_url(); ?>assets/img/cropped-logo-1-32x32.png" sizes="32x32"/>
	<link rel="icon" href="<?= base_url(); ?>assets/img/cropped-logo-1-192x192.png" sizes="192x192"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

	<title>Reset Password | Production - PT KMWI</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
	<meta name="viewport" content="width=device-width"/>

	<!-- Bootstrap core CSS     -->
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet"/>


	<!--  Material Dashboard CSS    -->
	<link href="<?= base_url(); ?>assets/css/material-dashboard.css?v=1.3.0" rel="stylesheet"/>

	<!--  CSS for Demo Purpose, don't include it in your project     -->
	<link href="<?= base_url(); ?>assets/css/demo.css" rel="stylesheet"/>


	<!--     Fonts and icons     -->
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css"
		  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
		  rel="stylesheet">
	<style type="text/css">
		#load {
			width: 100%;
			height: 100%;
			position: fixed;
			z-index: 9999;
			background: url("<?= base_url('assets/img/loading4.gif') ?>") no-repeat center center rgba(0, 0, 0, 0.25)
		}

	</style>
	<!--	captcha-->
</head>

<body class="off-canvas-sidebar">

<div id="load"></div>
<div class="wrapper wrapper-full-page">
	<div class="full-page register-page" filter-color="black" data-image="<?= base_url(); ?>assets/img/login.jpg">
		<div class="container">
			<?= form_open('auth/reset_password/'.$code); ?>

			<div class="row">
				<div
					class="col-lg-4 col-md-6 col-sm-6 col-xs-8 col-lg-offset-4 col-md-offset-3 col-sm-offset-3 col-xs-offset-2">
					<div class="card card-signup">
						<h2 class="card-title text-center">Production</h2>
						<h4 class="card-title text-center">Reset Password</h4>
						<div class="row">
							<div class="col-md-12">
								<div class="card-content">

									<?= $message; ?>
									<div class="row">
										<div class="col-md-12">
										</div>
									</div>

									<div class="input-group">
										<span class="input-group-addon"><i
												class="material-icons">lock_outline</i></span>
										<?php echo form_input($new_password); ?>
									</div>
									<div class="input-group">
										<span class="input-group-addon"><i
												class="material-icons">lock_outline</i></span>
										<?php echo form_input($new_password_confirm); ?>
									</div>
									<?php echo form_input($user_id);?>
									<?php echo form_hidden($csrf); ?>
								</div>
								<div class="card-footer">

									<?php echo form_submit('submit', lang('reset_password_submit_btn'), "class='btn btn-primary btn-round btn-block'"); ?>
								</div>



							</div>
						</div>
					</div>
				</div>
			</div>

			<?php echo form_close(); ?>

		</div>


	</div>

</div>


</body>
<script type="text/javascript">
	document.onreadystatechange = function () {
		var state = document.readyState
		if (state == 'complete') {
			document.getElementById('interactive');
			document.getElementById('load').style.visibility = "hidden";
		}
	}
</script>
<!--   Core JS Files   -->
<script src="<?= base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/material.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>

<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

<!-- Library for adding dinamically elements -->
<script src="<?= base_url(); ?>assets/js/arrive.min.js" type="text/javascript"></script>

<!-- Forms Validations Plugin -->
<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>

<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url(); ?>assets/js/moment.min.js"></script>

<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="<?= base_url(); ?>assets/js/chartist.min.js"></script>

<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?= base_url(); ?>assets/js/jquery.bootstrap-wizard.js"></script>

<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="<?= base_url(); ?>assets/js/bootstrap-notify.js"></script>

<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?= base_url(); ?>assets/js/bootstrap-datetimepicker.js"></script>

<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?= base_url(); ?>assets/js/jquery-jvectormap.js"></script>

<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="<?= base_url(); ?>assets/js/nouislider.min.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?= base_url(); ?>assets/js/jquery.select-bootstrap.js"></script>

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?= base_url(); ?>assets/js/jquery.datatables.js"></script>

<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="<?= base_url(); ?>assets/js/sweetalert2.js"></script>

<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?= base_url(); ?>assets/js/jasny-bootstrap.min.js"></script>

<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?= base_url(); ?>assets/js/fullcalendar.min.js"></script>

<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?= base_url(); ?>assets/js/jquery.tagsinput.js"></script>

<!-- Material Dashboard javascript methods -->
<script src="<?= base_url(); ?>assets/js/material-dashboard.js?v=1.3.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?= base_url(); ?>assets/js/demo.js"></script>


<script type="text/javascript">
	$().ready(function () {
		demo.checkFullPageBackgroundImage();

		setTimeout(function () {
			// after 1000 ms we add the class animated to the login/register card
			$('.card').removeClass('card-hidden');
		}, 700)
	});
</script>


</html>
