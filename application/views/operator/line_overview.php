<div class="content">
	<div class="container-fluid">

		<?php if (!empty_object($schedule)): ?>

			<?php
			$is_production_date_today = is_now_date_same($schedule->sch_production_date);
			$is_time_between_shift = is_now_time_between($schedule->sif_start_date, $schedule->sif_end_date);
			$is_pass_night = is_shift_pass_midnight($schedule->sif_start_date, $schedule->sif_end_date);
			$is_time_before_shift = is_time_before($schedule->sif_start_date);

			?>

			<div class="row">
				<div class="col-md-12">
					<div class="col-sm-4 col-xs-12">
						<div class="card card-pricing card-raised">
							<div class="content">
								<h3 class="card-title">
									<?= ($schedule->sif_name) . ' (' . print_beauty_time($schedule->sif_start_date) . '-' . print_beauty_time($schedule->sif_end_date) . ')' ?>
								</h3>
							</div>
							<div class="card-footer ">
								<div class="text-center">
									<h4><b>SHIFT</b></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6">
						<div class="card card-pricing card-raised">
							<div class="content">
								<h3 class="card-title"><?= ($schedule->sch_actual) ? $schedule->sch_actual : 0 ?></h3>
							</div>
							<div class="card-footer ">
								<div class="text-center">
									<h4><b>PLAN</b></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6">
						<div class="card card-pricing card-raised">
							<div class="content">
								<h3 class="card-title"><?= ($schedule->sch_reject) ? $schedule->sch_reject : 0 ?></h3>
							</div>
							<div class="card-footer ">
								<div class="text-center">
									<h4><b>ACTUAL</b></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<?php usort($productions, function ($a, $b) {
						return strcmp($a->sta_name, $b->sta_name);
					});
					$i=0;
					?>
					<?php foreach ($productions as $production): ?>
						<?php if($i==4): ?>
							<div class="row">
								<div class="col-md-12">
									<div class="card">
										<div class="card-content">
											<div class="places-buttons">
												<div class="row">
													<div class="col-md-12 text-center">
														<h2 class="card-title">
															Production Line Map
														</h2>
													</div>
												</div>
												<div class="row">
													<div style="text-align: center;">
														<img src="<?= base_url('assets/img/LINE.png') ?>"
															 style="transform: scale(1); max-width: 100%;width: auto;max-height:600px;"
															 alt="Responsive image">
													</div>
												</div>
											</div>
										</div><!-- end content-->
									</div><!--  end card  -->
								</div> <!-- end col-md-12 -->
							</div> <!-- end row -->
						<?php endif; ?>
						<?php $i++; ?>

						<div class="col-sm-3 col-xs-6">
							<div class="card card-pricing card-raised">
								<div class="content">
									<h3 class="card-title"><?= $production->sta_name ?></h3>
									<small><?= '(' . $production->sta_type . ')' ?></small>
								</div>
								<div class="card-footer ">
									<div class="text-center">
										<h4>
											<b><?= (!$production->prd_counting_cycle) ? '00:00:00' : gmdate("H:i:s", $production->prd_counting_cycle); ?></b>
										</h4>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>


		<?php else: ?>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-content">
							<div class="places-buttons">
								<div class="row">
									<div class="col-md-12 text-center">
										<h2 class="card-title">
											There is no schedule working at this time!
										</h2>
									</div>
								</div>
								<div class="row">
									<div style="text-align: center;">
										<img src="<?= base_url('assets/img/undraw/warning2x.png') ?>"
											 style="transform: scale(0.8); max-width: 100%;width: auto;max-height:600px;"
											 alt="Responsive image">
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-md-offset-3">
										<div style="text-align: center;">
											<a href="<?= base_url('production/schedule/add/1') ?>"
											   class="btn btn-primary btn-round btn-block">
												<i class="material-icons">update</i>
												<b>Add Schedule</b>
											</a>
										</div>
									</div>
								</div>

							</div>
						</div><!-- end content-->
					</div><!--  end card  -->
				</div> <!-- end col-md-12 -->
			</div> <!-- end row -->
		<?php endif; ?>
	</div> <!-- end row -->
</div>



