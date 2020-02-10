<?php echo $form->messages(); ?>

<div class="row">

	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Template Info</h3>
			</div>
			<div class="box-body">
				<?php echo $form->open(); ?>

					<?php echo $form->bs3_text('Name', 'name'); ?>
					<?php echo $form->bs3_text('Type(0 for Promotional and 1 for Reminder)', 'type'); ?>
					<?php echo $form->bs3_text('Message', 'message'); ?>

					<?php echo $form->bs3_submit(); ?>
					
				<?php echo $form->close(); ?>
			</div>
		</div>
	</div>
	
</div>