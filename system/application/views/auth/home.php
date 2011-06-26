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
	<?php $this->load->view('auth/menu'); ?>
	
	<div id="welcome">	
	<h3><img src="<?php echo $this->config->item('img_path');?>/irsdp_unity16s.png" />&nbsp;<?php echo $header; ?></h3>
	<p class="tandain2">
		<strong>Infrastructure Reform Sectore Development Project</strong> (IRSDP) adalah bagian dari Badan Perencanaan Pembangunan Nasional (Bappenas) Republik Indonesia yang secara khusus
		melayani administrasi proyek-proyek pembangunan pemerintah. Sasaran yang ingin didapatkan adalah adanya proses pembangunan nasional yang terpadu, dengan memeperkokoh kerjasama semua pihak 
		baik pemerintah mauapun swasta sehingga tercipta lapangan kerja bagi masayrakat umum, dan terciptanya pelayanan infrastruktur.<br /><br />
		
		Sedangkan tujuannya adalah membantu departemen teknis terkait dan pemerintah daerah dalam 
		menyiapkan proyek-proyek infrastruktur, khususnya untuk proyek yang mampu memberikan pemulihan biaya (cost recovery) 
		dan dapat dibiayai oleh bank (bankable) untuk dibangun melalui kerjasama dengan swasta (KPS).
	</p>
	<p>
		<img src="<?php echo $this->config->item('icon_path');?>/information.png" />&nbsp;Silahkan daftarkan diri Anda secara pribadi, atau perusahaan Anda untuk menjadi salah satu calon konsultan kami.<br />
		Klik link menuju form pendaftaran di bawah ini, atau silahkan login untuk mengecek status project Anda.<br />
	</p>
	
	<p class="tandain">
		<a href="<?php echo site_url()."/auth/daftar"; ?>"><img src="<?php echo $this->config->item('icon_path');?>/page_white_get.png" />&nbsp;Form Pendaftaran Online</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo site_url()."/auth/login"; ?>"><img src="<?php echo $this->config->item('icon_path');?>/key.png" />&nbsp;Login</a>
	</p>
	</div>
	
	<div id="sidepost">
	<h3><img src="<?php echo $this->config->item('icon_path');?>/brick.png" />&nbsp;<?php echo $headerside; ?></h3>
	<p>
		<?php
		$this->db->orderby('idtender_data','desc');
		$query = $this->db->get('tender_data',3);
		if($query->num_rows() > 0)
		{
		foreach($query->result() as $row)
		{
			echo "<div class='listing'>";
			echo "<strong><a href='".site_url('auth/open_project/'.$row->idproj)."'><img src='".$this->config->item('icon_path')."/new.png' />&nbsp;".$this->irsdp_model->get_nama_proyek_for_welcome($row->idproj)."</strong></a><br />".$row->deskripsi;
			echo "</div>";
		}
		echo "<br /><a href='".site_url('auth/open_project/all')."'><img src='".$this->config->item('icon_path')."/package_go.png' />&nbsp;proyek lainnya...</a>";
		}
		else
			echo "belum ada tender proyek yang dibuka.";
		?>
		
	</p>
	</div>
</div>

<div id="footer"><img src="<?php echo $this->config->item('img_path');?>irsdp_unity16.png" />&nbsp;Copyright &copy; 2010 IRSDP All Right Reserved</div>

</body>
</html>