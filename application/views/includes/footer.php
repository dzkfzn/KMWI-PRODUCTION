<footer class="footer">
	<div class="container-fluid">
		<p class="copyright pull-right">
			&copy;
			<script>document.write(new Date().getFullYear())</script>
			<a href="https://www.kmwi-astra.com/"> PT Kreasi Mandiri Wintor Indonesia. All Rights Reserved. </a>
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
<script src="<?= base_url(); ?>assets/js/core.js"></script>

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
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->

<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?= base_url(); ?>assets/js/jquery.select-bootstrap.js"></script>

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?= base_url(); ?>assets/js/jquery.datatables.js"></script>

<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="<?= base_url(); ?>assets/js/sweetalert.js"></script>

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
	$('.removealert').on("click", function (e) {
		e.preventDefault();
		var url = $(this).attr('href');
		swal({
				title: "Are you sure?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Yes, Remove!',
				cancelButtonText: "No, Cancel!",
				confirmButtonClass: "btn-danger",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function (isConfirm) {
				if (isConfirm) {
					swal("Deleted!", "Schedule has been deleted!", "success");
					// setTimeout(function(){ window.location.replace = url; }, 2000);
					window.setTimeout(function () {
						window.location.replace(url);
					}, 1000);
					// window.location.replace(url);
				} else {
					swal("Cancelled", "", "error");
				}
			});
	});
</script>

<script type="text/javascript">
	$(document).ready(function () {
		var interval = setInterval(function () {
			var momentNow = moment();
			$('#date-part').html(momentNow.format('YYYY MMMM DD') + ' '
				+ momentNow.format('dddd')
					.substring(0, 3).toUpperCase());
			$('#time-part').html(momentNow.format('A hh:mm:ss'));
		}, 100);

		$('#stop-interval').on('click', function () {
			clearInterval(interval);
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function () {

		demo.initFormExtendedDatetimepickers();
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})

		$('#datatables').DataTable({
			"pagingType": "full_numbers",
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
			responsive: true,
			language: {
				search: "_INPUT_",
				searchPlaceholder: "Search",
			}

		});

		var table = $('#datatables').DataTable();
		$('.card .material-datatables label').addClass('form-group');
	});

</script>
<script>
	function clickAndDisable(link) {
		// disable subsequent clicks
		link.onclick = function (event) {
			event.preventDefault();
		}
	}
</script>
<script type="text/javascript">
	$(document).ready(function () {

		$('#FormValidation input').on('keyup blur', function () {
			if ($('#FormValidation').valid()) {
				$('button.btn').prop('disabled', false);
			} else {
				$('button.btn').prop('disabled', 'disabled');
			}
		});

	});
</script>

<script type="text/javascript">
	var timestamp = '<?=date("F j, Y, g:i a");?>';

	function updateTime() {
		$('#time').html(Date(timestamp));
		timestamp++;
	}

	$(function () {
		setInterval(updateTime, 1000);
	});
</script>

</html>
