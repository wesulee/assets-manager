<html>
<head>
	<title><?php echo $title ?></title>
</head>
<body>
	<div id="header">
		<?php echo $this->session->userdata('username') ?>
		<?php echo anchor('asset/index', 'Assets') ?> | <?php echo anchor('category/index', 'Categories') ?> | <?php echo anchor('room/index', 'Rooms') ?>
		 | <?php echo anchor('auth/logout', 'Logout') ?>
	</div>