<div class="row">

	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/box_open', 'Shortcuts'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-user', 'Account', 'panel/account'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-sign-out', 'Logout', 'panel/logout'); ?>
		<?php echo modules::run('adminlte/widget/box_close'); ?>
	</div>

	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $count['users'], 'Users', 'fa fa-users', 'user'); ?>
	</div>
	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $count['users'], 'Active Users', 'fa fa-users', 'user'); ?>
	</div>
	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $trades['trades'], 'No. of Trade', 'fa fa-users', 'trade'); ?>
	</div>
	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $services['services'], 'No. of Services', 'fa fa-users', 'service'); ?>
	</div>
	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $packages['packages'], 'No. of Packages', 'fa fa-users', 'package'); ?>
	</div>
	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $count['users'], 'Revenue', 'fa fa-users', ''); ?>
	</div>
</div>
