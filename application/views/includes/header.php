<!doctype html>
<html lang="en">
<head>

	<meta charset="utf-8"/>
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>assets/img/apple-icon.png"/>
	<link rel="icon" href="<?= base_url(); ?>assets/img/cropped-logo-1-32x32.png" sizes="32x32"/>
	<link rel="icon" href="<?= base_url(); ?>assets/img/cropped-logo-1-192x192.png" sizes="192x192"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

	<title><?= $gPageTitle; ?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
	<meta name="viewport" content="width=device-width"/>

	<!-- Bootstrap core CSS     -->
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet"/>


	<!--  Material Dashboard CSS    -->
	<link href="<?= base_url(); ?>assets/css/material-dashboard.css?v=1.3.0" rel="stylesheet"/>

	<!--  CSS for Demo Purpose, don't include it in your project     -->
	<link href="<?= base_url(); ?>assets/css/demo.css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/sweetalert.css" />

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
		.time-frame {
			width: 300px;
		}

		.time-frame > div {
			width: 100%;
			text-align: center;
		}

		#date-part {
			font-size: 1.2em;
		}
		#time-part {
			font-size: 2em;
		}
	</style>
	<script type="text/javascript">
		function display_c(){
			var refresh=1000; // Refresh rate in milli seconds
			mytime=setTimeout('display_ct()',refresh)
		}

		function display_ct() {
			var x = new Date()
			var x1=x.toUTCString();// changing the display to UTC string
			document.getElementById('ct').innerHTML = x1;
			tt=display_c();
		}
	</script>
</head>


<body onload="display_ct()">
<noscript>
	<style type="text/css">
		.wrapper {
			display: none;
		}
	</style>
	<div class="noscriptmsg">
		You have to enabled javascript sir.
	</div>
</noscript>
<div id="load"></div>
<div class="wrapper">

	<div class="sidebar" data-active-color="purple" data-background-color="white"
		 data-image="<?= base_url(); ?>assets/img/sidebar.jpg">
		<!--
			Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
			Tip 2: you can also add an image using data-image tag
			Tip 3: you can change the color of the sidebar with data-background-color="white | black"
		-->

		<div class="logo">
			<a href="<?= base_url('production') ?>" class="simple-text logo-mini">
				<img src="<?= base_url(); ?>assets/img/cropped-logo-1-32x32.png">
			</a>

			<a href="<?= base_url('production') ?>" class="simple-text logo-normal">
				Production
			</a>
		</div>

		<div class="sidebar-wrapper">
			<div class="user">
				<div class="photo">
					<img src="<?= base_url(); ?>assets/img/placeholder.jpg"/>
				</div>
				<div class="info">
					<a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                         <?= $this->session->userdata('name'); ?>
                        <b class="caret"></b>
                    </span>
					</a>
					<div class="clearfix"></div>
					<div class="collapse" id="collapseExample">
						<ul class="nav">
<!--							<li>-->
<!--								<a href="#">-->
<!--									<span class="sidebar-mini"> <i class="material-icons">child_care</i>  </span>-->
<!--									<span class="sidebar-normal"> My Profile </span>-->
<!--								</a>-->
<!--							</li>-->
							<li>
								<a href="<?= base_url('production/change_password') ?>">
									<span class="sidebar-mini">
										<i class="material-icons">lock_outline</i>
									</span>
									<span class="sidebar-normal"> Change Password </span>
								</a>
							</li>
							<li>
								<a href="<?= base_url('production/logout') ?>">
									<span class="sidebar-mini"> <i class="material-icons">power_settings_new</i> </span>
									<span class=" sidebar-normal"> Sign Out </span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<ul class="nav">

				<?php $menu_master = array('user', 'station', 'scheme', 'product', 'shift'); ?>
				<?php $menu_ppic = array('schedule'); ?>
				<?php $uri = $this->uri->segment(2); ?>

				<!--				Begin of If Admin -->
				<?php if ($this->ion_auth->is_admin()): ?>
					<li <?php if ($uri === "dashboard" || $uri == "") echo 'class="active"'; ?> >
						<a href="<?= base_url('production/dashboard') ?>">
							<i class="material-icons">dashboard</i>
							<p> Dashboard </p>
						</a>
					</li>

					<li <?= is_active_navigation($uri, $menu_master) ?>>
						<a data-toggle="collapse" href="#adminMenu" <?= is_expanded_navigation($uri, $menu_master); ?>>
							<i class="fa fa-database"></i>
							<p> Manage Master Data
								<b class="caret"></b>
							</p>
						</a>

						<?php
						?>
						<div class="<?= is_collapse_navigation($this->uri->segment(2), $menu_master) ?>" id="adminMenu">
							<ul class="nav">
								<li <?php if ($uri == "user") echo 'class="active"'; ?>>
									<a href="<?= base_url('production/user') ?>"">
									<span class="sidebar-mini"> <i class="fa fa-users"></i> </span>
									<span class="sidebar-normal"> User </span>
									</a>
								</li>
								<li <?php if ($uri == "station") echo 'class="active"'; ?>>
									<a href="<?= base_url('production/station') ?>"">
									<span class="sidebar-mini"> <i class="fa fa-gears"></i> </span>
									<span class="sidebar-normal"> Station </span>
									</a>
								</li>
								<li <?php if ($uri == "scheme") echo 'class="active"'; ?>>
									<a href="<?= base_url('production/scheme') ?>"">
									<span class="sidebar-mini"><i class="material-icons">category</i></span>
									<span class="sidebar-normal"> Scheme </span>
									</a>
								</li>
								<li <?php if ($uri == "product") echo 'class="active"'; ?>>
									<a href="<?= base_url('production/product') ?>">
										<span class="sidebar-mini"> <i class="fa fa-truck"></i> </span>
										<span class="sidebar-normal"> Product </span>
									</a>
								</li>
								<li <?php if ($uri == "shift") echo 'class="active"'; ?>>
									<a href="<?= base_url('production/shift') ?>">
										<span class="sidebar-mini"><i class="material-icons">access_time</i></i> </span>
										<span class="sidebar-normal"> Shift </span>
									</a>
								</li>
							</ul>
						</div>
					</li>
				<?php endif ?>
				<!--				End of if Admin-->

				<!--				Begin of If PPIC -->
				<?php if ($this->ion_auth->is_ppic()): ?>
					<li <?php if ($uri === "dashboard" || $uri == "") echo 'class="active"'; ?> >
						<a href="<?= base_url('production/dashboard') ?>">
							<i class="material-icons">dashboard</i>
							<p> Dashboard </p>
						</a>
					</li>
					<li <?=  (strtolower($uri) === "schedule") ? 'class="active"' : '' ?> >
						<a href="<?= base_url('production/schedule') ?>">
							<i class="material-icons">update</i>
							<p> Schedule </p>
						</a>
					</li>
				<?php endif ?>
				<!--				End of if PPIC-->

			</ul>
		</div>
	</div>


	<div class="main-panel" id="contents">


		<nav class="navbar navbar-transparent navbar-absolute">
			<div class="container-fluid">
				<div class="navbar-minimize">
					<button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
						<i class="material-icons visible-on-sidebar-regular">more_vert</i>
						<i class="material-icons visible-on-sidebar-mini">view_list</i>
					</button>
				</div>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"> <?= $gContentTitle ?> </a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<div class="card" >
								<div class="card-content">
									<?= $this->session->userdata('name'); ?> |
									<?php if ($this->ion_auth->is_admin()) echo 'Administrator |'; ?>
									<?php if ($this->ion_auth->is_ppic()) echo 'PPIC |'; ?>
									<?php if ($this->ion_auth->is_operator()) echo 'Operator |'; ?>
									Last
									Login: <?= $this->session->userdata('old_last_login') ? time_elapsed_string(date("Y-m-d H:i:s", $this->session->userdata('old_last_login'))) : 'Never Login Before' ?>
								</div>
							</div>
						</li>
						<li class="separator hidden-lg hidden-md"></li>
					</ul>

				</div>
			</div>
		</nav>



