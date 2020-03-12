<style>
	#chartdiv {
		width: 100%;
		height: 400px;
	}

	#chartdiv2 {
		width: 100%;
		height: 400px;
	}

	#chartdiv3 {
		width: 100%;
		height: 500px;
	}

	#chartdiv4 {
		width: 100%;
		height: 300px;
	}

	#chartdiv5 {
		width: 100%;
		height: 300px;
	}


</style>
<div class="content">
	<div class="container-fluid">

		<?php if (isset($report_sta)): ?>
			<?php if (!empty_object($report_sta)): ?>
				<div class="row">
					<div class="col-md-8">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">show_chart</i>
							</div>

							<div class="card-content">
								<h4 class="card-title">Rejection Report Per Station</h4>
								<div id="chartdiv"></div>

							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">show_chart</i>
							</div>

							<div class="card-content">
								<h4 class="card-title">Report Total Rejection in Station by Shift</h4>
								<div id="chartdiv2"></div>

							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card card-plain">
							<div class="card-content">
								<div class="places-buttons">
									<div class="row">
										<div style="text-align: center;">
											<img src="<?= base_url('assets/img/undraw/report_nodata.png') ?>"
												 style="transform: scale(1); max-width: 100%;width: auto;max-height:600px;"
												 alt="Responsive image">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 text-center">
											<h2 class="card-title">
												No Data Can Be Shown On Selected Date!
											</h2>
										</div>
									</div>
								</div>
							</div><!-- end content-->
						</div><!--  end card  -->
					</div> <!-- end col-md-12 -->
				</div> <!-- end row -->
			<?php endif; ?>

		<?php elseif (isset($report_range)): ?>
			<?php if (!empty_object($report_range)): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">show_chart</i>
							</div>

							<div class="card-content">
								<h4 class="card-title">All of Rejection Per Station From  <?= print_beauty_date($start_report_date) ?> to  <?= print_beauty_date($end_report_date) ?> Report</h4>
								<div id="chartdiv3"></div>

							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">show_chart</i>
							</div>

							<div class="card-content">
								<h4 class="card-title">All of Rejection Per Station Report</h4>
								<div id="chartdiv4"></div>

							</div>
							<div class="card-footer">
								<div class="price">
									<h4>
										<i class="material-icons">date_range</i> <?= print_beauty_date($start_report_date) ?>
									</h4>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">show_chart</i>
							</div>

							<div class="card-content">
								<h4 class="card-title">All of Rejection Per Station Report</h4>
								<div id="chartdiv5"></div>

							</div>
							<div class="card-footer">
								<div class="price">
									<h4>
										<i class="material-icons">date_range</i> <?= print_beauty_date($start_report_date) ?>
									</h4>
								</div>

							</div>
						</div>
					</div>
				</div>

			<?php else: ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card card-plain">
							<div class="card-content">
								<div class="places-buttons">
									<div class="row">
										<div style="text-align: center;">
											<img src="<?= base_url('assets/img/undraw/report_nodata.png') ?>"
												 style="transform: scale(1); max-width: 100%;width: auto;max-height:600px;"
												 alt="Responsive image">
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 text-center">
											<h2 class="card-title">
												No Data Can Be Shown On Selected Date!
											</h2>
										</div>
									</div>
								</div>
							</div><!-- end content-->
						</div><!--  end card  -->
					</div> <!-- end col-md-12 -->
				</div> <!-- end row -->

			<?php endif; ?>
		<?php else: ?>
			<div class="row">
				<div class="col-md-12">
					<div class="card card-plain">
						<div class="card-content">
							<div class="places-buttons">
								<div class="row">
									<div style="text-align: center;">
										<img src="<?= base_url('assets/img/undraw/report.png') ?>"
											 style="transform: scale(1); max-width: 100%;width: auto;max-height:600px;"
											 alt="Responsive image">
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 text-center">
										<h2 class="card-title">
											Please Choose One of Report Type Shown Below and Fill Date to Show The
											Report!
										</h2>
									</div>
								</div>
							</div>
						</div><!-- end content-->
					</div><!--  end card  -->
				</div> <!-- end col-md-12 -->
			</div> <!-- end row -->
		<?php endif; ?>

		<div class="row">
			<div class="col-md-4">
				<?php echo form_open('production/rejection/daily'); ?>

				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">show_chart</i>
					</div>

					<div class="card-content">
						<h4 class="card-title">Rejection Report Daily</h4>
						<div class="form-group">
							<label class="label-control">Select Date</label>
							<?php echo form_input($pro_date); ?>
						</div>
						<button name="submit" type="submit"
								class="btn btn-fill btn-primary"
								onclick="clickAndDisable(this);">SHOW REPORT
						</button>
					</div>

				</div>
				<?php echo form_close(); ?>

			</div>
			<div class="col-md-4">
				<?php echo form_open('production/rejection/range'); ?>

				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">show_chart</i>
					</div>

					<div class="card-content">
						<h4 class="card-title">Rejection Report Range</h4>
						<div class="form-group">
							<label class="label-control">Select Date</label>
							<div class="input-group input-daterange">
								<?php echo form_input($start_pro_date); ?>
								<div class="input-group-addon">to</div>
								<?php echo form_input($end_pro_date); ?>
							</div>
						</div>
						<button name="submit" type="submit"
								class="btn btn-fill btn-primary"
								onclick="clickAndDisable(this);">SHOW REPORT
						</button>
					</div>

				</div>
				<?php echo form_close(); ?>

			</div>
		</div>
	</div> <!-- end row -->
	<!-- Chart code -->
	<script>
		am4core.ready(function () {
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create("chartdiv", am4charts.XYChart);
			chart.data = [
				<?php
				$json = null;
				foreach ($report_sta as $item) {
					$json .= '{';
					$json .= '"country": ' . '"' . $item->sta_name . '",';
					$json .= '"visits": ' . $item->prd_reject;
					$json .= '},';
				}
				echo substr($json, 0, -1);
				?>
			];
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "country";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function (dy, target) {
				if (target.dataItem && target.dataItem.index & 2 == 2) {
					return dy + 25;
				}
				return dy;
			});

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "visits";
			series.dataFields.categoryX = "country";
			series.name = "Visits";
			series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = .8;
			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;

		}); // end am4core.ready()
	</script>
	<script>
		am4core.ready(function () {
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create("chartdiv2", am4charts.XYChart);
			chart.data = [
				<?php
				$json = null;
				foreach ($report_sif as $item) {
					$json .= '{';
					$json .= '"country": ' . '"' . $item->sif_name . '",';
					$json .= '"visits": ' . $item->prd_reject;
					$json .= '},';
				}
				echo substr($json, 0, -1);
				?>
			];
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "country";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;

			categoryAxis.renderer.labels.template.adapter.add("dy", function (dy, target) {
				if (target.dataItem && target.dataItem.index & 2 == 2) {
					return dy + 25;
				}
				return dy;
			});

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "visits";
			series.dataFields.categoryX = "country";
			series.name = "Visits";
			series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = .8;
			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;

		}); // end am4core.ready()
	</script>
	<script>
		am4core.ready(function () {

// Themes begin
			am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
			var chart = am4core.create("chartdiv3", am4charts.XYChart);

// Add data
			chart.data = [
				<?php
				$json = null;
				foreach ($report_range as $item) {
					$json .= '{';
					$json .= '"date": ' . '"' . $item->sch_production_date . '",';
					$json .= '"value": ' . $item->prd_reject;
					$json .= '},';
				}
				echo substr($json, 0, -1);
				?>
			];

// Set input format for the dates
			chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
			var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
			var series = chart.series.push(new am4charts.LineSeries());
			series.dataFields.valueY = "value";
			series.dataFields.dateX = "date";
			series.tooltipText = "{value}"
			series.strokeWidth = 2;
			series.minBulletDistance = 15;

// Drop-shaped tooltips
			series.tooltip.background.cornerRadius = 20;
			series.tooltip.background.strokeOpacity = 0;
			series.tooltip.pointerOrientation = "vertical";
			series.tooltip.label.minWidth = 40;
			series.tooltip.label.minHeight = 40;
			series.tooltip.label.textAlign = "middle";
			series.tooltip.label.textValign = "middle";

// Make bullets grow on hover
			var bullet = series.bullets.push(new am4charts.CircleBullet());
			bullet.circle.strokeWidth = 2;
			bullet.circle.radius = 4;
			bullet.circle.fill = am4core.color("#fff");

			var bullethover = bullet.states.create("hover");
			bullethover.properties.scale = 1.3;

// Make a panning cursor
			chart.cursor = new am4charts.XYCursor();
			chart.cursor.behavior = "panXY";
			chart.cursor.xAxis = dateAxis;
			chart.cursor.snapToSeries = series;

// Create vertical scrollbar and place it before the value axis
			chart.scrollbarY = new am4core.Scrollbar();
			chart.scrollbarY.parent = chart.leftAxesContainer;
			chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
			chart.scrollbarX = new am4charts.XYChartScrollbar();
			chart.scrollbarX.series.push(series);
			chart.scrollbarX.parent = chart.bottomAxesContainer;

			dateAxis.start = 0.79;
			dateAxis.keepSelection = true;


		}); // end am4core.ready()
	</script>
	<script>
		am4core.ready(function () {

			am4core.useTheme(am4themes_animated);
			var chart = am4core.create("chartdiv4", am4charts.PieChart3D);
			chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

			chart.legend = new am4charts.Legend();

			chart.data = [

				<?php
				$json = null;
				foreach ($report_range_sif as $item) {
					$json .= '{';
					$json .= 'country: ' . '"' . $item->sif_name . '",';
					$json .= 'litres: ' . $item->prd_reject;
					$json .= '},';
				}
				echo substr($json, 0, -1);
				?>
			];

			var series = chart.series.push(new am4charts.PieSeries3D());
			series.dataFields.value = "litres";
			series.dataFields.category = "country";

		}); // end am4core.ready()
	</script>
	<script>
		am4core.ready(function () {

			am4core.useTheme(am4themes_animated);
			var chart = am4core.create("chartdiv5", am4charts.PieChart3D);
			chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

			chart.legend = new am4charts.Legend();

			chart.data = [

				<?php
				$json = null;
				foreach ($report_range_sta as $item) {
					$json .= '{';
					$json .= 'country: ' . '"' . $item->sta_name . '",';
					$json .= 'litres: ' . $item->prd_reject;
					$json .= '},';
				}
				echo substr($json, 0, -1);
				?>
			];

			var series = chart.series.push(new am4charts.PieSeries3D());
			series.dataFields.value = "litres";
			series.dataFields.category = "country";

		}); // end am4core.ready()
	</script>
