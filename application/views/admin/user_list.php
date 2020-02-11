<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">
							<i class="fa fa-users"></i>
						</i>
					</div>

					<div class="card-content">
						<h4 class="card-title"><?= $gCardTitle ?></h4>
						<div class="toolbar">
							<div class="places-buttons">
								<div class="row">
									<div class="col-md-12">
										<a href="<?= base_url('production/user/add') ?>"
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
									<th><?php echo lang('index_fname_th'); ?></th>
									<th><?php echo lang('index_lname_th'); ?></th>
									<th><?php echo lang('index_email_th'); ?></th>
									<th><?php echo lang('index_groups_th'); ?></th>
									<th><?php echo lang('index_status_th'); ?></th>
									<th class="disabled-sorting text-right"><?php echo lang('index_action_th'); ?></th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th><?php echo lang('index_fname_th'); ?></th>
									<th><?php echo lang('index_lname_th'); ?></th>
									<th><?php echo lang('index_email_th'); ?></th>
									<th><?php echo lang('index_groups_th'); ?></th>
									<th><?php echo lang('index_status_th'); ?></th>
									<th class="text-right"><?php echo lang('index_status_th'); ?></th>
								</tr>
								</tfoot>
								<tbody>
								<?php foreach ($users as $user): ?>
									<tr>
										<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
										<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
										<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
										<td>
											<?php foreach ($user->groups as $group): ?>
												<div class="bootstrap-tagsinput">
													<span class="label label-primary">
														<?php echo anchor("edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'), 'style="color:white;"'); ?>
													</span>
												</div>
											<?php endforeach ?>
										</td>
										<td>
											<?= print_beauty_status($user->active, TRUE) ?>

										</td>
										<td class="text-right">
											<?= anchor("production/user/detail/" . $user->id, '<i class="material-icons">remove_red_eye</i>', 'class="btn btn-simple btn-primary btn-icon" data-toggle="tooltip" data-placement="top" title="Detail" onclick="clickAndDisable(this);"') ?>
											<?= anchor("production/user/edit/" . $user->id, '<i class="material-icons">edit</i>', 'class="btn btn-simple btn-primary btn-icon edit" data-toggle="tooltip" data-placement="top" title="Edit" onclick="clickAndDisable(this);"') ?>
											<!--0 => active => show toogle on, action => inactive-->
											<!--1 => active => show toogle off, action => active-->
											<?php if ($user->active == 1)
												echo anchor("production/user/inactive/" . $user->id, '<i class="material-icons">toggle_on</i>', 'class="btn btn-simple btn-primary  btn-icon edit" data-toggle="tooltip" data-placement="top" title="Set to Inactive" onclick="clickAndDisable(this);"');
											else if ($user->active == 0)
												echo anchor("production/user/active/" . $user->id, '<i class="material-icons">toggle_off</i>', 'class="btn btn-simple  btn-icon edit" data-toggle="tooltip" data-placement="top" title="Set to Active" onclick="clickAndDisable(this);"');
											?>

										</td>

									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div><!-- end content-->
				</div><!--  end card  -->
			</div> <!-- end col-md-12 -->
		</div> <!-- end row -->
	</div>
</div>

