<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
<title>Infrastructure Reform Sectore Development Project :: Bappenas</title>
<link rel="shortcut icon" href="<?php echo $this->config->item('img_path');?>irsdp_unity16.png" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>login.css"/>
</head>
<body>

<div id="login_box">
	<h3>Login to System</h3>
	<div id="login_box_left">
		<img src="<?php echo $this->config->item('img_path');?>/logo130.jpg" />
	</div>
	
	<div id="login_box_right">
		<div id="login_box_credential">
		<?php echo form_open('auth/login_verify');?>
		username <br /><input type="text" name="username" maxlength="20" />
		password <br /><input type="password" name="password" maxlength="20" />
		<input type="submit" value="Login" />&nbsp;&nbsp;<input type="reset" value="Reset" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('auth');?>" title="back to home"><img src="<?php echo $this->config->item('icon_path');?>house.png" /></a>
		<?php echo form_close();?>
		</div>
	</div>
	
	<div class="clear"></div>
</div>

<div id="footer"><img src="<?php echo $this->config->item('img_path');?>irsdp_unity16.png" />&nbsp;Copyright &copy; 2010 IRSDP All Right Reserved</div>

</body>
</html>