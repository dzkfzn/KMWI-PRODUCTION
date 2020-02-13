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
										class="label label-primary"><?= print_beauty_date($schedule->pro_name) ?></span>
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
							<h3><?= (int)(($schedule->sch_reject + $schedule->sch_actual) / $schedule->sch_plan * 100) ?>%</h3>
						</div>
						<div class="card-content">
							<div class="progress">
								<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
									 aria-valuemin="0" aria-valuemax="100">25%
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
							<div class="timeline-badge danger">
								<i class="material-icons">card_travel</i>
							</div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<span class="label label-danger"><?= $production->sta_name ?></span>
								</div>
								<div class="timeline-body">
									<div class="row">
										<div class="col-xs-6">
											<label class="label-on-right">Runtime</label>
											<br><span
												class="label label-primary"><?= print_beauty_date($schedule->sch_production_date) ?></span>
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

					<li class="timeline-inverted">
						<div class="timeline-badge success">
							<i class="material-icons">extension</i>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<span class="label label-success">Another One</span>
							</div>
							<div class="timeline-body">
								<p>Thank God for the support of my wife and real friends. I also wanted to point
									out that it’s the first album to go number 1 off of streaming!!! I love you
									Ellen and also my number one design rule of anything I do from shoes to
									music to homes is that Kim has to like it....</p>
							</div>
						</div>
					</li>
					<li class="timeline-inverted">
						<div class="timeline-badge info">
							<i class="material-icons">fingerprint</i>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<span class="label label-info">Another Title</span>
							</div>
							<div class="timeline-body">
								<p>Called I Miss the Old Kanye That’s all it was Kanye And I love you like Kanye
									loves Kanye Famous viewing @ Figueroa and 12th in downtown LA 11:10PM</p>
								<p>What if Kanye made a song about Kanye Royère doesn't make a Polar bear bed
									but the Polar bear couch is my favorite piece of furniture we own It wasn’t
									any Kanyes Set on his goals Kanye</p>
								<hr>
								<div class="dropdown pull-left">
									<button type="button" class="btn btn-round btn-info dropdown-toggle"
											data-toggle="dropdown">
										<i class="material-icons">build</i>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<li><a href="#action">Action</a></li>
										<li><a href="#action">Another action</a></li>
										<li><a href="#here">Something else here</a></li>
										<li class="divider"></li>
										<li><a href="#link">Separated link</a></li>
									</ul>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>


	</div>
</div>

