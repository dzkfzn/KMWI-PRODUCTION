<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">


				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">remove_red_eye</i>
					</div>
					<div class="form-horizontal">

						<?php echo form_hidden('id', $shift->sif_id); ?>

						<div class="card-content">
							<h4 class="card-title"><?= $gCardTitle ?></h4>
							<div class="row">
								<div class="col-sm-2 label-on-left">
								</div>
								<div class="col-sm-7">
									<a href="<?= base_url('production/shift') ?>"
									   class="btn btn-primary btn-round btn-fab btn-fab-mini">
										<i class="material-icons">arrow_back</i>
									</a>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2 label-on-left"></div>
								<div class="col-sm-7">
									<?= $message; ?>

								</div>
							</div>


							<div class="row">
								<label class="col-sm-2 label-on-left">Name</label>

								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<?php echo form_input($name); ?>
									</div>
								</div>
							</div>

							<div class="row">
								<label class="col-sm-2 label-on-left">Start and End Time*</label>

								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<div class="input-group input-daterange">
											<?php echo form_input($start); ?>
											<div class="input-group-addon">s/d</div>
											<?php echo form_input($end); ?>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-2 label-on-left"></div>
								<div class="col-sm-7">
									<a href="<?= base_url() . 'production/shift/edit/' . $shift->sif_id ?>"
									   class="btn btn-primary btn-round btn-block" onclick="clickAndDisable(this);">
										<i class="material-icons">edit</i>
										Edit
									</a>
								</div>
							</div>

						</div><!-- end content-->
						<div class="card-footer ">

						</div>
					</div>
				</div><!--  end card  -->
			</div> <!-- end col-md-12 -->
			<div class="col-md-4">
				<div class="card ">
					<div class="card-content">
						<div class="form-horizontal">

							<h4 class="card-title"><?= $gCardTitle ?></h4>
							<div class="row">
								<label class="col-sm-4 label-on-left">Created By</label>

								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<?php echo form_input($creaby); ?>

									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-4 label-on-left">Created Date</label>

								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<?php echo form_input($creadate); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-4 label-on-left">Last Modified By</label>

								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<?php echo form_input($modiby); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-4 label-on-left">Last Modified Date</label>

								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<?php echo form_input($modidate); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-4 label-on-left">Status</label>

								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<?php echo form_input($status); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- end row -->
	</div>
</div>

