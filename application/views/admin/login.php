<?php $this->load->helper('form'); ?>
<html>
	<head>
		
	</head>
	<body>
		<h1>Login</h1>
                
                <?= form_open('admin/auth/do_login') ?>
                    <?= form_hidden('redirect', $_SERVER['HTTP_REFERER']) ?>
                    <?= form_input('email') ?>
                    <?= form_password('password') ?>
                    <?= form_submit('submit', 'Login') ?>
                <?= form_close() ?>
	</body>
</html>