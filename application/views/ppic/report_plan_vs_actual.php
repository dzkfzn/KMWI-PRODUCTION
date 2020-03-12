<style>
	#chartdiv {
		width: 100%;
		height: 500px;
	}


</style>
<div class="content">
	<div class="container-fluid">

		<?php if (isset($report_sta)): ?>
			<?php if (!empty_object($report_sta)): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">show_chart</i>
							</div>

							<div class="card-content">
								<h4 class="card-title">Plan vs Actual Report By Station</h4>
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
				<?php echo form_open('production/plan_vs_actual'); ?>

				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">show_chart</i>
					</div>

					<div class="card-content">
						<h4 class="card-title">Plan vs Actual Report Daily</h4>
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
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create('chartdiv', am4charts.XYChart)
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

				<?php
				$json = null;
				foreach ($report_sta as $item) {
					$json .= '{';
					$json .= 'category: ' . '"' . $item->sta_name . '",';
					$json .= 'first: ' . $item->sch_plan. ',';
					$json .= 'second: ' . ($item->prd_actual) ;
					$json .= '},';
				}

				echo substr($json, 0, -1);
				?>
			]


			createSeries('first', 'Plan');
			createSeries('second', 'Actual');

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

