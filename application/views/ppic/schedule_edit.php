<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">


				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">edit</i>
					</div>
					<?php echo form_open('production/schedule/add/1', $form_attribute); ?>
					<div class="card-content">
						<h4 class="card-title"><?= $gCardTitle ?></h4>
						<div class="row">
							<div class="col-sm-2 label-on-left">

							</div>
							<div class="col-sm-7">
								<a href="<?= base_url('production/schedule') ?>"
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
							<label class="col-sm-2 label-on-left">Production Date*</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($pro_date); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 label-on-left">Plan*</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($plan); ?>
								</div>
							</div>
						</div>


						<div class="row">
							<label class="col-sm-2 label-on-left">Shift*</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?= form_dropdown('shift', $option_shift, '', $dropdown_extra); ?>
								</div>
							</div>
						</div>

						<div class="row">
							<label class="col-sm-2 label-on-left">Product*</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?= form_dropdown('product', $option_product, '', $dropdown_extra); ?>
								</div>
							</div>
						</div>

						<div class="row">
							<label class="col-sm-2 label-on-left">Schema*</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?= form_dropdown('scheme', $option_scheme, '', $dropdown_extra); ?>
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
													onclick="clickAndDisable(this);">Next
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
</div>

