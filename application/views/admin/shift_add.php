<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">


				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">add</i>
					</div>
					<?php echo form_open(current_url(), $form_attribute); ?>
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
							<label class="col-sm-2 label-on-left">Name*</label>

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
										<div class="input-group-addon">to</div>
										<?php echo form_input($end); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2 label-on-left">
								<div class="category form-category">
									<star>*</star>
									<b>Required fields</b>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2 label-on-left"></div>
							<div class="col-sm-7">
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 col-xs-6">
											<input type="reset" class="btn btn-primary btn-fill btn-round btn-block"
												   value="Clean Form"/>

										</div>
										<div class="col-md-6 col-xs-6">
											<button name="submit" type="submit"
													class="btn btn-primary btn-fill btn-block btn-round"
													disabled="disabled"
													onclick="clickAndDisable(this);">add
												shift
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

