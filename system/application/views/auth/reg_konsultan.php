<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
<title>Infrastructure Reform Sectore Development Project :: Bappenas</title>
<link rel="shortcut icon" href="<?php echo $this->config->item('img_path');?>irsdp_unity16.png" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>style.css"/>
</head>
<body>

<div id="container2">
	<div id="header2">
		<div id="header_left">
			<img align="left" src="<?php echo $this->config->item('img_path')?>banner_blue_gradasi.png" />
		</div>	
	</div>
	<?php $this->load->view($menu);?>	
<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>
<?php if($msg_captcha!=""):?>
<br />
	<div class="validation_error">
	<?php echo $msg_captcha;?>
	</div>
<?php endif;?>

<h2>Public Consultant Registration</h2>
<hr />

<?php

$form_dest = 'auth/daftar';
$nama = array(
              'name'        => 'nama',
              'class'   	=> 'long',
              'value'       => set_value('nama')             
            );
            
$jenis = array(
              'name'        => 'jenis',
              'class'   	=> 'small',
              'value'       => set_value('deskripsi')             
            );        
            
$alamat = array(
              'name'        => 'alamat',
              'class'   	=> 'long3',
              'value'       => set_value('alamat')             
            );

$telpon = array(
              'name'        => 'telpon',
              'class'   	=> 'small',
              'value'       => set_value('telpon')             
            );

$fax = array(
              'name'        => 'fax',
              'class'   	=> 'small',
              'value'       => set_value('fax')             
            );

$hp = array(
              'name'        => 'hp',
              'class'   	=> 'small',
              'value'       => set_value('hp')             
            );

$email = array(
              'name'        => 'email',
              'class'   	=> 'medium',
              'value'       => set_value('email')             
            );
			
$website = array(
              'name'        => 'website',
              'class'   	=> 'medium',
              'value'       => set_value('website')
			);                        
?>

<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Nama Konsultan (Perusahaan)</td>
	<td><?php echo form_input($nama);?></td>
</tr>
<tr>
	<td class="label">Tipe Konsultan</td>
	<td>
	<input type="radio" name="jenis" value="Company" />Perusahaan
	<input type="radio" name="jenis" value="Individu" />Individu
	</td>
</tr>
<tr>
	<td class="label">Alamat</td>
	<td><?php echo form_input($alamat);?></td>
</tr>
<tr>
	<td class="label">Nomor Telepon</td>
	<td><?php echo form_input($telpon);?></td>
</tr>
<tr>
	<td class="label">Fax</td>
	<td><?php echo form_input($fax);?></td>
</tr>
<tr>
	<td class="label">Nomor Handphone</td>
	<td><?php echo form_input($hp);?></td>
</tr>
<tr>
	<td class="label">Email</td>
	<td><?php echo form_input($email);?></td>
</tr>
<tr>
	<td class="label">Website</td>
	<td><?php echo form_input($website);?></td>
</tr>
<tr>
	<td class="label">Input teks disamping</td>
	<td><?php echo $image;?><br /><br /><input class="small2" type="text" name="captcha" value="" /></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Daftar" />
	&nbsp;
	<input type="reset" value="Ulangi" />
	</th>
</tr>

</table>

<?php echo form_close();?>

</div>
<div id="footer"><img src="<?php echo $this->config->item('img_path');?>irsdp_unity16.png" />&nbsp;Copyright &copy; 2010 IRSDP All Right Reserved</div>

</body>
</html>