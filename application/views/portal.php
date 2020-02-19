<!doctype html>
<html lang="en">
<head>


	<meta charset="utf-8"/>
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>/assets/img/apple-icon.png"/>
	<link rel="icon" href="<?= base_url(); ?>assets/img/cropped-logo-1-32x32.png" sizes="32x32"/>
	<link rel="icon" href="<?= base_url(); ?>assets/img/cropped-logo-1-192x192.png" sizes="192x192"/>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

	<title>Portal - PT KMWI</title>


	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
	<meta name="viewport" content="width=device-width"/>

	<!-- Bootstrap core CSS     -->
	<link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet"/>

	<!--  Material Dashboard CSS    -->
	<link href="<?= base_url() ?>/assets/css/material-dashboard.css?v=1.3.0" rel="stylesheet"/>

	<!--  CSS for Demo Purpose, don't include it in your project     -->
	<link href="<?= base_url() ?>/assets/css/demo.css" rel="stylesheet"/>


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
</head>

<body class="off-canvas-sidebar">
<div id="load"></div>

<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
	<div class="container">
	</div>
</nav>


<div class="wrapper wrapper-full-page">
	<div class="full-page pricing-page" data-image="<?= base_url() ?>/assets/img/portal.png">

		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center">
						<h2 class="title"><strong>Welcome to KMWI Application</strong></h2>
						<h5 class="description">Choose Your Menu</h5>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="card card-pricing card-raised h-100">
							<div class="card-content" style="min-height:400px">
								<div class="icon icon-rose">
									<img src="<?= base_url('assets/img/portal/order2x.png') ?>"
										 style="transform: scale(1); max-width: 100%;width: auto;max-height:100px;"
										 alt="Responsive image">
								</div>
								<h3 class="card-title">Orderin Parts By PCH</h3>
								<ul class="card-description">
									<li>Frame</li>
									<li>Engine</li>
									<li>TBD</li>
								</ul>
								<a href="#pablo" class="btn btn-default disabled btn-round">Develop Later</a>
							</div>
						</div>
					</div>

					<div class="col-md-4 py-2">
						<div class="card card-pricing card-raised h-100">
							<div class="card-content">
								<div class="icon icon-rose">
									<img src="<?= base_url('assets/img/portal/production_control2x.png') ?>"
										 style="transform: scale(1); max-width: 100%;width: auto;max-height:100px;"
										 alt="Responsive image">
								</div>
								<h3 class="card-title">Production Control by PPC</h3>
								<ul class="card-description">
									<li>Incoming Control</li>
									<li>Scheduling Production</li>
									<li>TBD</li>
								</ul>
								<a href="#pablo" class="btn btn-default disabled btn-round">Develop Later</a>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="card card-pricing card-raised h-100">
							<div class="card-content">
								<div class="icon icon-rose">
									<img src="<?= base_url('assets/img/portal/warehouse2x.png') ?>"
										 style="transform: scale(1); max-width: 100%;width: auto;max-height:100px;"
										 alt="Responsive image">
								</div>
								<h3 class="card-title">Warehouse</h3>
								<ul class="card-description">
									<li>Register Incoming Parts</li>
									<li>Manage Parts Position</li>
									<li>Distribution to Production Line</li>
								</ul>
								<a href="#pablo" class="btn btn-default disabled btn-round">Develop Later</a>

							</div>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="card card-pricing card-raised h-100">
							<div class="card-content">
								<div class="icon icon-rose">
									<img src="<?= base_url('assets/img/portal/production2x.png') ?>"
										 style="transform: scale(1); max-width: 100%;width: auto;max-height:100px;"
										 alt="Responsive image">

								</div>
								<h3 class="card-title">Production</h3>
								<ul class="card-description">
									<li>Assembly Parts</li>
									<li>Record Problem and Solving</li>
									<li>Runtest and FI</li>
								</ul>
								<a href="<?= base_url('production') ?>" class="btn btn-primary btn-round">LET'S DIVE IN</a>

							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card card-pricing card-raised h-100">
							<div class="card-content">
								<div class="icon icon-rose">
									<img src="<?= base_url('assets/img/portal/delivery2x.png') ?>"
										 style="transform: scale(1); max-width: 100%;width: auto;max-height:100px;"
										 alt="Responsive image">
								</div>
								<h3 class="card-title">Delivery</h3>
								<ul class="card-description">
									<li>TBD</li>
									<li>TBD</li>
									<li>TBD</li>
								</ul>
								<a href="#pablo" class="btn btn-default disabled btn-round">Develop Later</a>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="footer">
			<div class="container">
				<!--                <nav class="pull-left">-->
				<!--                    <ul>-->
				<!--                        <li>-->
				<!--                            <a href="#">-->
				<!--                                Home-->
				<!--                            </a>-->
				<!--                        </li>-->
				<!--                        <li>-->
				<!--                            <a href="#">-->
				<!--                                Company-->
				<!--                            </a>-->
				<!--                        </li>-->
				<!--                        <li>-->
				<!--                            <a href="#">-->
				<!--                                Portofolio-->
				<!--                            </a>-->
				<!--                        </li>-->
				<!--                        <li>-->
				<!--                            <a href="#">-->
				<!--                                Blog-->
				<!--                            </a>-->
				<!--                        </li>-->
				<!--                    </ul>-->
				<!--                </nav>-->
				<p class="copyright pull-right">
					&copy;
					<script>document.write(new Date().getFullYear())</script>
					<a href="http://www.creative-tim.com"> KMWI </a> - All Rights Reserved
				</p>
			</div>
		</footer>

	</div>

</div>
</body>
<script type="text/javascript">
	document.onreadystatechange = function () {
		var state = document.readyState
		if (state == 'complete') {
			document.getElementById('interactive');
			document.getElementById('load').style.visibility="hidden";
		}
	}
</script>
<!--   Core JS Files   -->
<script src="<?= base_url() ?>/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/js/material.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>

<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

<!-- Library for adding dinamically elements -->
<script src="<?= base_url() ?>/assets/js/arrive.min.js" type="text/javascript"></script>

<!-- Forms Validations Plugin -->
<script src="<?= base_url() ?>/assets/js/jquery.validate.min.js"></script>

<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>/assets/js/moment.min.js"></script>

<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="<?= base_url() ?>/assets/js/chartist.min.js"></script>

<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?= base_url() ?>/assets/js/jquery.bootstrap-wizard.js"></script>

<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="<?= base_url() ?>/assets/js/bootstrap-notify.js"></script>

<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?= base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>

<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?= base_url() ?>/assets/js/jquery-jvectormap.js"></script>

<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="<?= base_url() ?>/assets/js/nouislider.min.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?= base_url() ?>/assets/js/jquery.select-bootstrap.js"></script>

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?= base_url() ?>/assets/js/jquery.datatables.js"></script>

<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="<?= base_url() ?>/assets/js/sweetalert2.js"></script>

<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?= base_url() ?>/assets/js/jasny-bootstrap.min.js"></script>

<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?= base_url() ?>/assets/js/fullcalendar.min.js"></script>

<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?= base_url() ?>/assets/js/jquery.tagsinput.js"></script>

<!-- Material Dashboard javascript methods -->
<script src="<?= base_url() ?>/assets/js/material-dashboard.js?v=1.3.0"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?= base_url() ?>/assets/js/demo.js"></script>


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
