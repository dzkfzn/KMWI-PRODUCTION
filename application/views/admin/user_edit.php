<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">


				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">edit</i>
					</div>
					<?php echo form_open(uri_string(), $form_attribute); ?>
					<div class="card-content">
						<h4 class="card-title"><?= $gCardTitle ?></h4>
						<div class="row">
							<div class="col-sm-2 label-on-left">

							</div>
							<div class="col-sm-7">
								<a href="<?= base_url('production/user') ?>"
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
							<label class="col-sm-2 label-on-left">First Name*</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($first_name); ?>
									<span
										class="help-block">name can't contain numerical and some special character.</span>
								</div>
							</div>
						</div>


						<div class="row">
							<label class="col-sm-2 label-on-left">Last Name</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($last_name); ?>
									<span
										class="help-block">name can't contain numerical and some special character.</span>
								</div>
							</div>
						</div>
						<?php if ($identity_column !== 'email'): ?>
							<div class="row">
								<label class="col-sm-2 label-on-left">Username</label>
								<div class="col-sm-7">
									<div class="form-group label-floating">
										<label class="control-label"></label>
										<?php echo form_input($identity); ?>
										<span class="help-block">username can't contain space and some special character.</span>

									</div>
								</div>
							</div>
						<?php endif; ?>
						<div class="row">
							<label class="col-sm-2 label-on-left">Company</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($company); ?>
								</div>
							</div>
						</div>

						<div class="row">
							<label class="col-sm-2 label-on-left">Email</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($email); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 label-on-left">Phone Number*</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($phone); ?>
									<span class="help-block">format accept only 08XX | +62XXX | 62XXX</span>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 label-on-left">Password (Optional)</label>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($password); ?>
									<span class="help-block">minimal 8 length and can contain any character but whitespaces.</span>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 label-on-left">Confirm Password</label>
							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($password_confirm); ?>
									<span class="help-block">confirm you password.</span>

								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 label-on-left">Role*</label>
							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?= form_dropdown('group', $option_group, $group_selected, $group_extra); ?>
									<span class="help-block">confirm you password.</span>

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
								<button name="submit" type="submit" class="btn btn-primary btn-round btn-block"  onclick="clickAndDisable(this);">
									Update
								</button>
							</div>
						</div>


						</div><!-- end content-->
					<div class="card-footer text-center">

					</div>
					<?php echo form_hidden('id', $user->id);?>
					<?php echo form_hidden($csrf); ?>
					<?php echo form_close(); ?>
				</div><!--  end card  -->
			</div> <!-- end col-md-12 -->
		</div> <!-- end row -->
	</div>
</div>

