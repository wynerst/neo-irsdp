<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
<title>Infrastructure Reform Sector Development Project :: Bappenas</title>
<link rel="shortcut icon" href="<?php echo $this->config->item('img_path');?>irsdp_unity16.png" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>style.css"/>

</head>
<body>

<div id="container">
	<div id="header">
		<div id="header_left">
			<img align="left" src="<?php echo $this->config->item('img_path');?>banner_blue_gradasi.png" />
		</div>		
		<div id="header_right">
			Welcome <strong><img src="<?php echo $this->config->item('icon_path')."status_online.png";?>" />&nbsp;<?php echo $this->session->userdata('username');?></strong>&nbsp;(<?php if($this->session->userdata('group')=='admin')
																																																																											echo $this->session->userdata('group');
																																																																									else
																																																																											echo $this->session->userdata('sub_group');?>)&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo site_url('auth/logout');?>"><img src="<?php echo $this->config->item('icon_path')."door_in.png";?>" />&nbsp;Logout</a>
		</div>		
	</div>
	
	<?php $this->load->view($sub_layout);?>
</div>

<div id="footer"><img src="<?php echo $this->config->item('img_path');?>irsdp_unity16.png" />&nbsp;Copyright &copy; 2010 IRSDP All Right Reserved</div>

</body>
</html>