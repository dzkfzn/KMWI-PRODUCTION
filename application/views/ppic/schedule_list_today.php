<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">update</i>

					</div>

					<div class="card-content">
						<?php if (!empty_object($schedule_today)): ?>

							<h4 class="card-title"><?= $gCardTitle ?></h4>
							<div class="toolbar">
								<div class="places-buttons">
									<div class="row">
										<div class="col-md-12">
											<a href="<?= base_url('production/schedule/add/1') ?>"
											   class="btn btn-primary btn-round" onclick="clickAndDisable(this);">
												<i class="material-icons">add</i>
												<b>Add Data</b>

											</a>

											<?php if ($this->uri->segment(3) == 'history'): ?>
												<a href="<?= base_url('production/schedule/') ?>" 
												   class="btn btn-primary btn-round" onclick="clickAndDisable(this);">
													<i class="material-icons">access_time</i>
													<b>Today View</b>
												</a>
											<?php else: ?>
												<a href="<?= base_url('production/schedule/history') ?>"
												   class="btn btn-primary btn-round" onclick="clickAndDisable(this);">
													<i class="material-icons">update</i>
													<b>History View</b>
												</a>
											<?php endif; ?>
											<!--											<button class="btn btn-rose btn-fill" type="button" value="asdasd"  onclick="this.disabled=true; this.value='Please Wait...';" />-->

										</div>
									</div>

								</div>
							</div>
							<div class="material-datatables">
								<div id="infoMessage"><?php echo $message; ?></div>

								<table id="datatables" class="table table-striped table-no-bordered table-hover"
									   cellspacing="0" width="100%" style="width:100%">
									<thead>
									<tr>
										<th>No</th>
										<th>Date</th>
										<th>Shift</th>
										<th>Schema</th>
										<th>Product</th>
										<th>Plan (Unit)</th>
										<th>Status</th>
										<th class="disabled-sorting text-right"><?php echo lang('index_action_th'); ?></th>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($schedule_today as $schedule): ?>
										<tr>
											<td><?php echo htmlspecialchars($schedule->no, ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo time_future_string(htmlspecialchars($schedule->sch_production_date, ENT_QUOTES, 'UTF-8')); ?></td>
											<td><?php echo htmlspecialchars($schedule->sif_name, ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo htmlspecialchars($schedule->sce_name, ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo htmlspecialchars($schedule->pro_name, ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo htmlspecialchars($schedule->sch_plan, ENT_QUOTES, 'UTF-8'); ?></td>

											<!--if true then compare with start date else end date-->
											<?php
											$is_production_date_today = is_now_date_same($schedule->sch_production_date);
											$is_production_date_pass_night = is_now_date_same_night_shift($schedule->sch_production_date);
											$is_time_between_shift = is_now_time_between($schedule->sif_start_date, $schedule->sif_end_date, $is_production_date_pass_night);
											$is_pass_night = is_shift_pass_midnight($schedule->sif_start_date, $schedule->sif_end_date);
											$is_time_before_shift = is_time_before($schedule->sif_start_date);

											?>
											<?php if ($is_production_date_today): ?>
												<?php if ($is_time_between_shift): ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_end_date, FALSE, FALSE, $is_pass_night); ?>
													<td><?= print_beauty_statusv2('currently working ' . $time . ' Left', 'success') ?></td>
													<td class="text-right">
														<?= anchor("production/schedule/detail/" . $schedule->sch_id, '<i class="material-icons">remove_red_eye</i>', 'class="btn btn-simple btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Detail" onclick="clickAndDisable(this);"') ?>
													</td>
												<?php elseif ($is_time_before_shift): ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_start_date, FALSE, FALSE); ?>
													<td><?= print_beauty_statusv2('to be worked ' . $time, 'primary') ?></td>
													<td class="text-right">
														<?= anchor("production/schedule/detail/" . $schedule->sch_id, '<i class="material-icons">remove_red_eye</i>', 'class="btn btn-simple btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Detail" onclick="clickAndDisable(this);"') ?>
														<?= anchor("production/schedule/inactive/" . $schedule->sch_id, '<i class="material-icons ">delete</i>', 'class="btn btn-simple btn-primary btn-icon edit removealert" data-toggle="tooltip" data-placement="top" title="Remove" ') ?>
													</td>
												<?php else : ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_end_date, FALSE, FALSE, $is_pass_night); ?>
													<td><?= print_beauty_statusv2('finished ' . $time, 'default') ?></td>
													<td class="text-right">
														<?= anchor("production/schedule/detail/" . $schedule->sch_id, '<i class="material-icons">remove_red_eye</i>', 'class="btn btn-simple btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Detail" onclick="clickAndDisable(this);"') ?>
													</td>
												<?php endif; ?>

											<?php else: ?>
												<td class="text-right">
													<?= anchor("production/schedule/detail/" . $schedule->sch_id, '<i class="material-icons">remove_red_eye</i>', 'class="btn btn-simple btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Detail" onclick="clickAndDisable(this);"') ?>
												</td>
												<?php if ($is_time_between_shift && $is_pass_night && $is_production_date_pass_night): ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_end_date, FALSE, FALSE, $is_pass_night); ?>
													<td><?= print_beauty_statusv2('currently working ' . $time . ' Left', 'success') ?></td>
													<?php $this->session->set_userdata('dashboard_schedule', $schedule->sch_id); ?>
												<?php elseif (!is_now_date_history($schedule->sch_production_date)): ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_start_date); ?>
													<td><?= print_beauty_statusv2('to be worked ' . $time, 'primary') ?></td>
													<?= anchor("production/schedule/inactive/" . $schedule->sch_id, '<i class="material-icons ">delete</i>', 'class="btn btn-simple btn-primary btn-icon edit removealert" data-toggle="tooltip" data-placement="top" title="Remove" ') ?>

												<?php else: ?>
													<?php $time = ago($schedule->sch_production_date, $schedule->sif_end_date, FALSE, FALSE, $is_pass_night); ?>
													<td><?= print_beauty_statusv2('finished ' . $time, 'default') ?></td>
												<?php endif; ?>

											<?php endif; ?>


										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<div class="places-buttons">
								<div class="row">
									<div class="col-md-12 text-center">
										<h2 class="card-title">
											you haven't make a schedule for today sir!
										</h2>
									</div>
								</div>
								<div class="row">
									<div style="text-align: center;">
										<img src="<?= base_url('assets/img/undraw/empty_shcedule2x.png') ?>"
											 style="transform: scale(0.8); max-width: 100%;width: auto;max-height:600px;"
											 alt="Responsive image">
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-md-offset-3">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-6">
												<a href="<?= base_url('production/schedule/add/1') ?>"
												   class="btn btn-primary btn-round btn-block">
													<i class="material-icons">add</i>
													<b>Add a Schedule</b>
												</a>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6">
												<a href="<?= base_url('production/schedule/history') ?>"
												   class="btn btn-primary btn-round btn-block">
													<i class="material-icons">update</i>
													<b>History View</b>
												</a>
											</div>
										</div>

									</div>
								</div>

							</div>
						<?php endif; ?>
					</div><!-- end content-->
				</div><!--  end card  -->
			</div> <!-- end col-md-12 -->
		</div> <!-- end row -->
	</div>

