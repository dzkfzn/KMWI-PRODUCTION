<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">remove_red_eye</i>
					</div>
					<div class="form-horizontal">

						<?php echo form_hidden('id', $schedule->sch_id); ?>

						<div class="card-content">
							<h4 class="card-title"><?= $gCardTitle ?></h4>

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

						</div><!-- end content-->
						<div class="card-footer ">

						</div>
					</div>
				</div><!--  end card  -->
			</div> <!-- end col-md-12 -->
		</div> <!-- end row -->

		<div class="row">
			<div class="col-md-6">
				<div class="col-xs-6 ">
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
				<div class="col-xs-6">
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
				<div class="col-xs-6">
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
				<div class="col-xs-6">
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
			<div class="col-md-6">
				<ul class="timeline timeline-simple">

					<?php foreach ($productions as $production): ?>
						<li class="timeline-inverted">
							<div
								class="timeline-badge <?= ($production->sta_type == 'Production') ? 'danger' : (($production->sta_type == 'Verification') ? 'success' : 'info') ?>">
								<i class="fa fa-gears"></i>

							</div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<span
										class="label label-<?= ($production->sta_type == 'Production') ? 'danger' : (($production->sta_type == 'Verification') ? 'success' : 'info') ?>"><?= $production->sta_name . ' | ' . $production->sta_type ?></span>
								</div>
								<div class="timeline-body">
									<div class="row">
										<div class="col-xs-6">
											<label class="label-on-right">Runtime</label>
											<br><span
												class="label label-primary"><?= (!$production->prd_counting_cycle) ? 'Zero' : secondsToTime($production->prd_counting_cycle) ?></span>
										</div>
										<div class="col-xs-6">
											<label class="label-on-right">Cycle Time</label>
											<br><span
												class="label label-primary"><?= secondsToTime(timeToSeconds($production->prd_cycle_time)); ?></span>
										</div>
									</div>

								</div>

							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>


	</div>

