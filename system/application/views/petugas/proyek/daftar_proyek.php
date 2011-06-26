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


<h2>Project List</h2>
<hr />

<?php echo form_open('petugas/daftar_proyek');?>
<div style="padding: 5px;">
	<div style="float: left">
	Search <input type="search_all" name="search_text" /><input type="submit" name="submit_text" value="GO"/>
	</div>
<?php echo form_close();?>	

<?php echo form_open('petugas/daftar_proyek');?>
	<div style="float: right">
	Search from <input type="text" name="search_start" id="tgl_awal" /> until <input type="text" name="search_end" id="tgl_akhir" /> <input type="submit" name="submit_date" value="GO"/>
	</div>
</div>
<?php echo form_close();?>

<div class="clear">&nbsp;</div>

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>No.</th>
	<th>PIN</th>
	<th>Sector</th>
	<th>Project Name</th>
	<th>Location</th>
	<th>Milestone</th>
	<th>Status</th>	
	<th>Proposing Agency</th>
	<th>Adminstrative Aspect</th>
	<th>Technical Aspect</th>
	<?php
	if($this->session->userdata('sub_group')=='pas' OR $this->session->userdata('sub_group')=='tas' OR $this->session->userdata('group')=='admin')
		echo "<th>ADB Visibility</th>";

	if($this->session->userdata('sub_group')!='konsultan')
	{
	?>
	<th colspan="2"></th>
	<?php } ?>
</tr>

<?php if($proyek->num_rows()>0):?>
<?php foreach($proyek->result() as $tmp): ?>
<tr valign="top">
	<td align="center"><?php echo ++$no;?></td>
	<td width="80px"><?php echo $tmp->pin;?></td>
	<td width="80px"><?php echo $tmp->subsectorname;?></td>
	<td width="150px"><?php echo $tmp->nama;?></td>
	<td><?php echo $tmp->lokasi;?></td>
	<td><?php echo $tmp->detil_status;?></td>
	<td align="center"><?php echo $tmp->kode_status;?></td>
	<td><?php echo $tmp->usulan_lpd;?></td>
	<td align="center"><?php echo humanize($this->irsdp_model->get_status_single($tmp->idproj_flow, 'pas'));?></td>
	<td align="center"><?php echo humanize($this->irsdp_model->get_status_single($tmp->idproj_flow, 'tas'));?></td>

	
	<?php
	if($tmp->view==2)
		$viewthis="Visible";
	else		
		$viewthis="Hidden";
	
	if($this->session->userdata('sub_group')=='pas' OR $this->session->userdata('sub_group')=='tas' OR $this->session->userdata('group')=='admin')
		echo "<td align=\"center\"><a href=".site_url('petugas/toggle_view/'.$tmp->idproject_profile."/".$viewthis).">".$viewthis."</a></td>";
	?>

	
	<?php 
	if($this->session->userdata('sub_group')!='konsultan')
	{
	?>
	
	<td align="center">
		<a href="<?php echo site_url('petugas/detil_proyek_ringkas/'.$tmp->idproject_profile);?>">
		<img src="<?php echo $this->config->item('icon_path');?>/zoom.png" title="Detail"/>
		</a>
	</td>
	<td align="center">
		<a href="<?php echo site_url('petugas/edit_proyek/'.$tmp->idproject_profile)?>">
		<img src="<?php echo $this->config->item('icon_path');?>/pencil_go.png" title="Edit Project"/>
		</a>
	</td>
	
	<?php } ?>
	
</tr>	
<?php endforeach;?>
<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
<tr>
	<td colspan="15" align="center" ><?php if(isset($pagination_mode)) echo $this->pagination->create_links();?></td>
</tr>
<tr>
	<th colspan="15" align="center" >&nbsp;</th>
</tr>
</table>