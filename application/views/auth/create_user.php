<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message ?></div>

<?php echo form_open("auth/create_user");?>

	<p>
		Username<br />
		<?php echo form_input($username) ?>
	</p>

	
	<p>
		Password<br />
		<?php echo form_input($password) ?>
	</p>

	<p>
		<?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
		<?php echo form_input($password_confirm);?>
	</p>


	<p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

<?php echo form_close() ?>
