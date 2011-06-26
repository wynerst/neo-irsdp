<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.2.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<script>
$(function() {
	$("#tgl_awal").datepicker({
		dateFormat: 'yy-mm-dd',
	});
	$("#tgl_akhir").datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
</script>


<h2>Project List for ADB Report Execution</h2>
<hr />

<?php echo form_open('petugas/adb_list_project');?>
<div style="padding: 5px;">
	<div style="float: left">
	Search Project&nbsp;<input type="search_all2" name="keyword" /><input type="submit" name="submit" value="Search"/>
	</div>
<?php echo form_close();?>	

<div class="clear">&nbsp;</div>

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="30px">No.</th>
	<th width="60px">PIN</th>
	<th width="70px">Sector</th>
	<th width="200px">Project Name</th>
	<th width="100px">Location</th>
	<th width="50px">Status</th>	
	<th width="150px"></th>
</tr>

<tr>
	<td>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/id_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/id_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
	</td>
	<td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/pin_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/pin_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
	</td>
	<td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/sector_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/sector_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
	</td>
	<td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/proj_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/proj_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
	</td>
	<td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/location_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/location_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
	</td>
	<td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/status_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/')."/status_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
	</td>
	<td>&nbsp;</td>
</tr>

<?php if($proyek->num_rows()>0):
$no=0;?>
<?php foreach($proyek->result() as $tmp): ?>
<tr valign="top">
	<td align="center"><?php echo ++$no+$this->uri->segment(4);?></td>
	<td><?php echo $tmp->pin;?></td>
	<td><?php echo $this->irsdp_model->get_namakategori($tmp->id_kategori);?></td>
	<td><?php echo $tmp->nama;?></td>
	<td><?php echo $tmp->lokasi;?></td>
	<td><?php echo $this->irsdp_model->get_kodestatus_adb($tmp->last_idref_status);?></td>	
	<td align="center"><a href="<?php echo site_url('petugas/adb_report_pac/'.$tmp->idproject_profile.'/1_asc');?>"><img src="<?php echo $this->config->item('icon_path')."page_red.png";?>" />&nbsp;&nbsp;CRAM PPC</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo site_url('petugas/adb_report_tac/'.$tmp->idproject_profile.'/1_asc');?>"><img src="<?php echo $this->config->item('icon_path')."page.png";?>" />&nbsp;&nbsp;CRAM TAC</a></td>	
</tr>	
<?php endforeach;?>
<tr>
	<td colspan="7" align="center"><?php echo $paging; ?></td>
</tr>
<?php else: ?>
<tr>
	<td align="center" colspan="7"><em>No data available</em></td>
</tr>
<?php endif;?>
<tr>
	<th colspan="7"></th>
</tr>
</table>