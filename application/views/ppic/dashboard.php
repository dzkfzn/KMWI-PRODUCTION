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
					<div class="card">
						<div class="form-horizontal">

							<?php echo form_hidden('id', $schedule->sch_id); ?>

							<div class="card-content">
								<h4 class="card-title"><b><?= $gCardTitle ?></b></h4>
								<div class="row">
									<div class="md-12">
										<div class='time-frame pull-right'>
											<div id='date-part'></div>
											<div id='time-part'></div>
										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Production Date</label>
										<br><span
											class="label label-primary"><?= print_beauty_date($schedule->sch_production_date) ?></span>
									</div>
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Schema</label>
										<br><span
											class="label label-primary"><?= ($schedule->sce_name) ?></span>
									</div>
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Shift</label>
										<br><span
											class="label label-primary"><?= ($schedule->sif_name) . ' (' . print_beauty_time($schedule->sif_start_date) . '-' . print_beauty_time($schedule->sif_end_date) . ')' ?></span>
									</div>
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Product</label>
										<br><span
											class="label label-primary"><?= ($schedule->pro_name) ?></span>
									</div>
									<!--							</div>-->
									<!--							<br>-->
									<!--							<div class="row">-->
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Created By</label>
										<br><span
											class="label label-primary"><?= ($schedule->sch_creaby) ?></span>
									</div>
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Created Date</label>
										<br><span
											class="label label-primary"><?= time_elapsed_string($schedule->sch_creadate) . ' (' . print_beauty_date($schedule->sch_creadate) . ')' ?></span>
									</div>
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Last Modified By</label>
										<br><span
											class="label label-primary"><?= is_null_modiby($schedule->sch_modiby) ?></span>
									</div>
									<div class="col-lg-3 col-md-4 col-sm-6">
										<label class="col-sm-12 label-on-right">Last Modified Date</label>
										<br><span
											class="label label-primary"><?= is_null_modiby($schedule->sch_modidate, TRUE) . ' (' . print_beauty_date($schedule->sch_modidate) . ')' ?></span>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<h4 class="btn btn-primary btn-block btn-round">
											<?php if ($is_production_date_today): ?>
												<?php if ($is_time_between_shift): ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_end_date, FALSE, FALSE, $is_pass_night); ?>
													<?= ('currently working ' . $time . ' Left') ?>
												<?php elseif ($is_time_before_shift): ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_start_date, FALSE, FALSE); ?>
													<?= ('to be worked ' . $time) ?>
												<?php else : ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_end_date, FALSE, FALSE, $is_pass_night); ?>
													<?= ('finished ' . $time) ?>
												<?php endif; ?>
											<?php else: ?>
												<?php $time = ago($schedule->sch_production_date, $schedule->sif_start_date); ?>
												<td><?= ('to be worked ' . $time) ?></td>
											<?php endif; ?>
										</h4>
									</div>
								</div>

							</div><!-- end content-->
						</div>
					</div><!--  end card  -->
				</div> <!-- end col-md-12 -->
			</div> <!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="col-sm-3 col-xs-6">
						<div class="card card-pricing card-raised">
							<div class="content">
								<h3 class="card-title"><?= $schedule->sch_plan ?></h3>
							</div>
							<div class="card-footer ">
								<div class="text-center">
									<h4><b>PLAN</b></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
						<div class="card card-pricing card-raised">
							<div class="content">
								<h3 class="card-title"><?= ($schedule->sch_actual) ? $schedule->sch_actual : 0 ?></h3>
							</div>
							<div class="card-footer ">
								<div class="text-center">
									<h4><b>ACTUAL</b></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
						<div class="card card-pricing card-raised">
							<div class="content">
								<h3 class="card-title"><?= ($schedule->sch_reject) ? $schedule->sch_reject : 0 ?></h3>
							</div>
							<div class="card-footer ">
								<div class="text-center">
									<h4><b>REJECT</b></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
						<div class="card card-pricing card-raised">
							<div class="content">
								<h3 class="card-title"><?= $schedule->sch_plan - ($schedule->sch_reject + $schedule->sch_actual) ?></h3>
							</div>
							<div class="card-footer ">
								<div class="text-center">
									<h4><b>LEFT</b></h4>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="card card-testimonial">
							<div class="card-header">
								<h3><?= $percent = (int)(($schedule->sch_reject + $schedule->sch_actual) / $schedule->sch_plan * 100) ?>
									%</h3>
							</div>
							<div class="card-content">
								<div class="progress progress-line-primary">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?= $percent ?>"
										 aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent ?>%;">
										<span class="sr-only"><?= $percent ?>% Complete</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
										<img src="<?= base_url('assets/img/kmwi_assi_line.png') ?>"
											 style="transform: scale(1); max-width: 100%;width: auto;max-height:600px;"
											 alt="Responsive image">
									</div>
								</div>
							</div>
						</div><!-- end content-->
					</div><!--  end card  -->
				</div> <!-- end col-md-12 -->
			</div> <!-- end row -->

			<div class="row">
				<div class="col-md-12">
					<?php usort($productions, function ($a, $b) {
						return strcmp($a->sta_name, $b->sta_name);
					}); ?>
					<?php foreach ($productions as $production): ?>

						<div class="col-sm-3 col-xs-6">
							<div class="card card-pricing card-raised">
								<div class="content">
									<h3 class="card-title"><?= $production->sta_name  ?></h3><small><?= '(' . $production->sta_type . ')' ?></small>
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



