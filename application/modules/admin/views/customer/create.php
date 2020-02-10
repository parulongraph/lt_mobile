<?php echo $form->messages(); ?>

<div class="row">

	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Services Info</h3>
			</div>
			<div class="box-body">
				<?php echo $form->open(); ?>

					<?php echo $form->bs3_text('Name', 'name'); ?>
					<?php echo $form->bs3_text('Mobile No.', 'mobile_no'); ?>
					<?php echo $form->bs3_text('Service id', 'services_id'); ?>
					<?php echo $form->bs3_text('Reminder Period', 'reminder_period'); ?>
					<?php echo $form->bs3_text('Created User_id', 'created_user_id'); ?>

					<?php echo $form->bs3_submit(); ?>
					
				<?php echo $form->close(); ?>
			</div>
		</div>
	</div>
	
</div>