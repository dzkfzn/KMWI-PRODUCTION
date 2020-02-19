<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">


				<div class="card">
					<div class="card-header card-header-icon" data-background-color="purple">
						<i class="material-icons">lock_outline</i>
					</div>
					<?php echo form_open('auth/change_password', $form_attribute); ?>
					<?php echo form_input($user_id);?>

					<div class="card-content">
						<h4 class="card-title"><?= $gCardTitle ?></h4>
					
						<div class="row">
							<div class="col-sm-2 label-on-left"></div>
							<div class="col-sm-7">
								<?= $message; ?>

							</div>
						</div>


						<div class="row">
							<?php echo lang('change_password_old_password_label', 'old_password', 'class="col-sm-2 label-on-left"');?>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($old_password); ?>

								</div>
							</div>
						</div>

						<div class="row">
							<label class="col-sm-2 label-on-left">New Password</label>


							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($new_password); ?>
									<span class="help-block">minimal 8 length and can contain any character but whitespaces.</span>


								</div>
							</div>
						</div>	<div class="row">
							<?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm', 'class="col-sm-2 label-on-left"');?>

							<div class="col-sm-7">
								<div class="form-group label-floating">
									<label class="control-label"></label>
									<?php echo form_input($new_password_confirm); ?>
									<span class="help-block">confirm you password.</span>

								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2 label-on-left">
								<div class="category form-category">
									<b>All fields are required</b>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2 label-on-left"></div>
							<div class="col-sm-7">
								<button name="submit" type="submit" class="btn btn-primary btn-round btn-block" disabled onclick="clickAndDisable(this);">
									<?= lang('change_password_submit_btn') ?>
								</button>
							</div>
						</div>

					</div><!-- end content-->
					<div class="card-footer ">

					</div>
					<?php echo form_close(); ?>
				</div><!--  end card  -->
			</div> <!-- end col-md-12 -->
		</div> <!-- end row -->
	</div>

