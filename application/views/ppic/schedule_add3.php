<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">


				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">add</i>
					</div>
					<?php echo form_open(uri_string() . '/true', $form_attribute); ?>
					<div class="card-content">
						<h4 class="card-title"><?= $gCardTitle ?></h4>

						<div class="row">
							<div class="col-sm-2 label-on-left"></div>
							<div class="col-sm-7">
								<?= $message; ?>

							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="row">
									<label class="col-sm-3 label-on-left">Production Date</label>

									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label class="control-label"></label>
											<?php echo form_input($pro_date); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<label class="col-sm-3 label-on-left">Plan</label>

									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label class="control-label"></label>
											<?php echo form_input($plan); ?>
										</div>
									</div>
								</div>


								<div class="row">
									<label class="col-sm-3 label-on-left">Shift</label>

									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label class="control-label"></label>
											<?php echo form_input($shift); ?>

										</div>
									</div>
								</div>

								<div class="row">
									<label class="col-sm-3 label-on-left">Product</label>

									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label class="control-label"></label>
											<?php echo form_input($product); ?>
										</div>
									</div>
								</div>

								<div class="row">
									<label class="col-sm-3 label-on-left">Schema</label>

									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label class="control-label"></label>
											<?php echo form_input($scheme); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">

								<?php foreach ($productions as $production): ?>

									<div class="row">
										<label
											class="col-sm-3 label-on-left"><?php echo htmlspecialchars($production->sta_name . ' | ' . $production->sta_type, ENT_QUOTES, 'UTF-8'); ?>
										</label>

										<div class="col-sm-5">
											<div class="form-group label-floating">
												<label class="control-label"></label>
												<?php echo form_input($cycle_time, secondsToTime(timeToSeconds($production->prd_cycle_time))); ?>
											</div>
										</div>
									</div>

								<?php endforeach; ?>
							</div>
						</div>


						<div class="row">
							<div class="col-sm-2 label-on-left"></div>
							<div class="col-sm-7">
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 col-xs-6">
											<a class="btn btn-primary btn-fill btn-round btn-block" href="<?= base_url('production/schedule') ?>">Cancel</a>
										</div>
										<div class="col-md-6 col-xs-6">
											<button name="submit" type="submit"
													class="btn btn-primary btn-fill btn-block btn-round"
													onclick="clickAndDisable(this);">Confirm
											</button>
										</div>
									</div>
								</div>

							</div>
						</div>

					</div><!-- end content-->
					<div class="card-footer text-center">

					</div>
					<?php echo form_close(); ?>
				</div><!--  end card  -->
			</div> <!-- end col-md-12 -->
		</div> <!-- end row -->
	</div>

