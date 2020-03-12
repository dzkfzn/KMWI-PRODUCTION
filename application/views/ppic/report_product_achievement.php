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

		<?php if (isset($report_sch)): ?>
			<?php if (!empty_object($report_sch)): ?>
				<div class="row">
					<div class="col-md-8">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">show_chart</i>
							</div>

							<div class="card-content">
								<h4 class="card-title">Rejection Report By Station</h4>
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
								<h4 class="card-title">Rejection Report By Shift</h4>
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
				<?php echo form_open('production/product_achievement'); ?>

				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">show_chart</i>
					</div>

					<div class="card-content">
						<h4 class="card-title">Rejection Report Monthly</h4>
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
		</div>
	</div> <!-- end row -->
	<!-- Chart code -->
	<script>
		am4core.ready(function () {

// Themes begin
			am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
			var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
			chart.data = [
				<?php
				$json = null;
				foreach ($report_sch as $item) {
					$json .= '{';
					$json .= '"date": ' . '"' . $item->sch_production_date . '",';
					$json .= '"value": ' . $item->sch_actual;
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
			var chart = am4core.create('chartdiv2', am4charts.XYChart)
			chart.colors.step = 2;

			chart.legend = new am4charts.Legend()
			chart.legend.position = 'top'
			chart.legend.paddingBottom = 20
			chart.legend.labels.template.maxWidth = 95

			var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
			xAxis.dataFields.category = 'category'
			xAxis.renderer.cellStartLocation = 0.1
			xAxis.renderer.cellEndLocation = 0.9
			xAxis.renderer.grid.template.location = 0;

			var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
			yAxis.min = 0;

			function createSeries(value, name) {
				var series = chart.series.push(new am4charts.ColumnSeries())
				series.dataFields.valueY = value
				series.dataFields.categoryX = 'category'
				series.name = name

				series.events.on("hidden", arrangeColumns);
				series.events.on("shown", arrangeColumns);

				var bullet = series.bullets.push(new am4charts.LabelBullet())
				bullet.interactionsEnabled = false
				bullet.dy = 30;
				bullet.label.text = '{valueY}'
				bullet.label.fill = am4core.color('#ffffff')

				return series;
			}

			chart.data = [
				{
					category: 'Place #1',
					first: 40,
					second: 55,
					third: 60
				},
				{
					category: 'Place #2',
					first: 30,
					second: 78,
					third: 69
				},
				{
					category: 'Place #3',
					first: 27,
					second: 40,
					third: 45
				},
				{
					category: 'Place #4',
					first: 50,
					second: 33,
					third: 22
				}
			]


			createSeries('first', 'The Thirst');
			createSeries('second', 'The Second');
			createSeries('third', 'The Third');

			function arrangeColumns() {

				var series = chart.series.getIndex(0);

				var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
				if (series.dataItems.length > 1) {
					var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
					var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
					var delta = ((x1 - x0) / chart.series.length) * w;
					if (am4core.isNumber(delta)) {
						var middle = chart.series.length / 2;

						var newIndex = 0;
						chart.series.each(function (series) {
							if (!series.isHidden && !series.isHiding) {
								series.dummyData = newIndex;
								newIndex++;
							} else {
								series.dummyData = chart.series.indexOf(series);
							}
						})
						var visibleCount = newIndex;
						var newMiddle = visibleCount / 2;

						chart.series.each(function (series) {
							var trueIndex = chart.series.indexOf(series);
							var newIndex = series.dummyData;

							var dx = (newIndex - trueIndex + middle - newMiddle) * delta

							series.animate({
								property: "dx",
								to: dx
							}, series.interpolationDuration, series.interpolationEasing);
							series.bulletsContainer.animate({
								property: "dx",
								to: dx
							}, series.interpolationDuration, series.interpolationEasing);
						})
					}
				}
			}

		}); // end am4core.ready()
	</script>

