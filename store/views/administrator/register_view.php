<!DOCTYPE HTML>
<html>
<head>
<title>Register</title>
</head>
<body>
<?php echo form_open('administrator/register'); ?>
<p>Username:</p>
<p><input type="text" name="username"
value="<?php echo set_value('username'); ?>" /></p>
<p><?php echo form_error('username'); ?></p>
<p>Email:</p>
<p><input type="text" name="email"
value="<?php echo set_value('email'); ?>" /></p>
<p><?php echo form_error('email'); ?></p>
<p>Password:</p>
<p><input type="password" name="password"
value="<?php echo set_value('password'); ?>" /></p>
<p><?php echo form_error('password'); ?></p>
<p>Password Confirmation:</p>
<p><input type="password" name="password_conf"
value="<?php echo set_value('password_conf'); ?>" /></p>
<p><?php echo form_error('password_conf'); ?></p>
<p><input type="submit" name="submit"
value="Register Account" /></p>
</body>
</html>
