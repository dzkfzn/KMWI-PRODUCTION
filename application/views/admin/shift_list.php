<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">access_time</i></i>
					</div>

					<div class="card-content">
						<?php if (!empty_object($shifts)): ?>

							<h4 class="card-title"><?= $gCardTitle ?></h4>
							<div class="toolbar">
								<div class="places-buttons">
									<div class="row">
										<div class="col-md-12">
											<a href="<?= base_url('production/shift/add') ?>"
											   class="btn btn-primary btn-round" onclick="clickAndDisable(this);">
												<i class="material-icons">add</i>
												<b>Add Data</b>
											</a>
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
										<th>Name</th>
										<th>Time</th>
										<th>Last Modified By</th>
										<th>Last Modified Date</th>
										<th>Status</th>
										<th class="disabled-sorting text-right"><?php echo lang('index_action_th'); ?></th>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($shifts as $shift): ?>
										<tr>
											<td><?php echo htmlspecialchars($shift->no, ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo htmlspecialchars($shift->sif_name, ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo htmlspecialchars(print_beauty_time($shift->sif_start_date) . ' - ' . print_beauty_time($shift->sif_end_date), ENT_QUOTES, 'UTF-8'); ?></td>

											<td><?= '<i>' . htmlspecialchars(is_null_modiby($shift->sif_modiby), ENT_QUOTES, 'UTF-8') . '<i>'; ?></td>
											<td><?= '<i>' . htmlspecialchars(is_null_modiby($shift->sif_modidate, TRUE), ENT_QUOTES, 'UTF-8') . '</i>'; ?></td>
											<td>
												<?= print_beauty_status($shift->sif_is_deleted) ?>
											</td>
											<td class="text-right">
												<?= anchor("production/shift/detail/" . $shift->sif_id, '<i class="material-icons">remove_red_eye</i>', 'class="btn btn-simple btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Detail" onclick="clickAndDisable(this);"') ?>
												<?= anchor("production/shift/edit/" . $shift->sif_id, '<i class="material-icons">edit</i>', 'class="btn btn-simple btn-primary btn-icon edit" data-toggle="tooltip" data-placement="top" title="Edit" onclick="clickAndDisable(this);"') ?>
												<!--0 => active => show toogle on, action => inactive-->
												<!--1 => active => show toogle off, action => active-->
												<?php if ($shift->sif_is_deleted == 0)
													echo anchor("production/shift/inactive/" . $shift->sif_id, '<i class="material-icons">toggle_on</i>', 'class="btn btn-simple btn-primary  btn-icon edit removealert" data-toggle="tooltip" data-placement="top" title="Set to Inactive" onclick="clickAndDisable(this);"');
												else if ($shift->sif_is_deleted == 1)
													echo anchor("production/shift/active/" . $shift->sif_id, '<i class="material-icons">toggle_off</i>', 'class="btn btn-simple  btn-icon edit" data-toggle="tooltip" data-placement="top" title="Set to Active" onclick="clickAndDisable(this);"');
												?>


											</td>


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
											No Data Found Sir!
										</h2>
									</div>
								</div>
								<div class="row">
									<div style="text-align: center;">
										<img src="<?= base_url('assets/img/undraw/empty_ver2x.png') ?>"
											 style="transform: scale(0.8); max-width: 100%;width: auto;max-height:600px;"
											 alt="Responsive image">
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-md-offset-3">
										<div style="text-align: center;">
											<a href="<?= base_url('production/shift/add') ?>"
											   class="btn btn-primary btn-round btn-block">
												<i class="material-icons">add</i>
												<b>Add Data</b>
											</a>
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

