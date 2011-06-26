<?php
if($this->session->userdata('sub_group')!='konsultan')
{
?>
<div class="sub_menu_container">
<ul id="nav">
	<li><a href="<?php echo site_url()."/petugas";?>">Dashboard</a></li>
	<li><a href="<?php echo site_url()."/petugas/daftar_proyek";?>">PDF Project Monitoring</a>
		<ul>
			<li><a href="<?php echo site_url()."/petugas/input_usulan_proyek_baru";?>"><img src="<?php echo $this->config->item('icon_path')."script_add.png";?>" />&nbsp;&nbsp;New Proposed Project</a></li>
			<li><a href="<?php echo site_url()."/petugas/daftar_proyek";?>"><img src="<?php echo $this->config->item('icon_path')."table.png";?>" />&nbsp;&nbsp;List of Project</a></li>
			<li><a href="<?php echo site_url()."/petugas/proyek_terkontrak";?>"><img src="<?php echo $this->config->item('icon_path')."ruby.png";?>" />&nbsp;&nbsp;Consultant Progress</a></li>
			<li><a href="<?php echo site_url()."/petugas/adb_list_project/id_asc";?>"><img src="<?php echo $this->config->item('icon_path')."chart_bar.png";?>" />&nbsp;&nbsp;ADB Project Report</a></li>
		</ul>
	</li>
	<li><a href="<?php echo site_url()."/petugas/laporan_keuangan"?>">Project Finance Monitoring</a>
		<ul>
			<li><a href="<?php echo site_url()."/petugas/keuangan";?>"><img src="<?php echo $this->config->item('icon_path')."coins.png";?>" />&nbsp;&nbsp;Project Finance</a></li>
			<li><a href="<?php echo site_url()."/petugas/laporan_keuangan/table_05";?>" target="_blank"><img src="<?php echo $this->config->item('icon_path')."money.png";?>" />&nbsp;&nbsp;Contract Financial List</a></li>
			<li><a href="<?php echo site_url()."/petugas/laporan_keuangan";?>"><img src="<?php echo $this->config->item('icon_path')."script_lightning.png";?>" />&nbsp;&nbsp;Finance Reports&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;</a>
				<ul>
					<li><a href="<?php echo site_url()."/petugas/laporan_keuangan/table_02";?>"><img src="<?php echo $this->config->item('icon_path')."report.png";?>" />&nbsp;&nbsp;<strong>(Table 2)</strong> IRSDP Fund Disbursement Progress Status Per Contract</a></li>
					<li><a href="<?php echo site_url()."/petugas/laporan_keuangan/table_03";?>"><img src="<?php echo $this->config->item('icon_path')."report.png";?>" />&nbsp;&nbsp;<strong>(Table 3)</strong> Recapitulation of Disbursment Progress of IRSDP per Fund Source</a></li>
					<li><a href="<?php echo site_url()."/petugas/laporan_keuangan/table_04";?>"><img src="<?php echo $this->config->item('icon_path')."report.png";?>" />&nbsp;&nbsp;<strong>(Table 4)</strong> Status of Realization DIPA IRSDP</a></li>
					<li><a href="<?php echo site_url()."/petugas/laporan_keuangan/table_09";?>" target="_blank"><img src="<?php echo $this->config->item('icon_path')."report.png";?>" />&nbsp;&nbsp;<strong>(Format D)</strong> Progress Report Of PDF - IRSDP Disbursement</a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li><a href="<?php echo site_url()."/petugas/list_kontraktor"?>">Contract Monitoring</a></li>
	<li><a href="<?php echo site_url()."/petugas/list_tender"?>">Tender Monitoring</a>
		<ul>
			<li><a href="<?php echo site_url()."/petugas/add_tender";?>"><img src="<?php echo $this->config->item('icon_path')."table_go.png";?>" />&nbsp;&nbsp;Submit New Tender</a></li>
			<li><a href="<?php echo site_url()."/petugas/add_kontraktor";?>"><img src="<?php echo $this->config->item('icon_path')."user_red.png";?>" />&nbsp;&nbsp;Choose Contractor</a></li>
		</ul>
	</li>
</ul>
</div>

<?php } 
else
{
?>

<div class="sub_menu_container">
<ul id="nav">
	<li><a href="<?php echo site_url()."/petugas";?>">Dashboard</a></li>
	<li><a href="<?php echo site_url()."/petugas/daftar_proyek";?>">List of Projects</a></li>
	<li><a href="<?php echo site_url()."/petugas/proyek_terkontrak";?>">Consultant Progress</a></li>
	<li><a href="<?php echo site_url()."/petugas/"?>">Tender Monitoring</a></li> <!-- FIX THIS... WILL YOU? -->
</ul>
</div>

<?php } ?>

<?php if(isset($notif)): ?>
	<div class="notification <?php echo $notif['type'];?>">
	<?php echo $notif['message'];?>
</div>
<?php endif;?>
	
<?php $this->load->view($main);?>