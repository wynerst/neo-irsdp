<h2>Contracted Project</h2>
<hr />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>No.</th>
	<th>PIN</th>
	<th>Sector</th>
	<th>Project Name</th>
	<th>Location</th>
	<th>Status</th>
	<th>Proposing Agency</th>
	<th>Administrative</th>
	<th>Technical</th>
	<th>Status Consultant</th>
	<th></th>
	<th></th>
</tr>

<?php if($proyek->num_rows()>0):?>
<?php foreach($proyek->result() as $tmp): ?>
<tr valign="top">
	<td align="center"><?php echo ++$no;?></td>
	<td><?php echo $tmp->pin;?></td>
	<td><?php echo $tmp->subsectorname;?></td>
	<td><?php echo $tmp->nama;?></td>
	<td><?php echo $tmp->lokasi;?></td>
	<td><?php echo $tmp->detil_status;?></td>
	<td><?php echo $tmp->usulan_lpd;?></td>
	<td align="center"><?php if($this->irsdp_model->get_kontrak_status_single($tmp->idproj_flow, 'pas')) echo humanize($this->irsdp_model->get_kontrak_status_single($tmp->idproj_flow, 'pas'));
												else echo "-";?></td>
	<td align="center"><?php if($this->irsdp_model->get_kontrak_status_single($tmp->idproj_flow, 'tas')) echo humanize($this->irsdp_model->get_kontrak_status_single($tmp->idproj_flow, 'tas'));
												else echo "-";?></td>
	<td align="center"><?php if($this->irsdp_model->get_kontrak_status_single($tmp->idproj_flow, 'consultant')) echo humanize($this->irsdp_model->get_kontrak_status_single($tmp->idproj_flow, 'consultant'));
												else echo "-";?></td>
	<td align="center">
		<a href="<?php echo site_url('petugas/detil_proyek_terkontrak/'.$tmp->idproject_profile);?>">
		<img src="<?php echo $this->config->item('img_path');?>/view.png" width="20" height="20" title="Detail"/>
		</a>
	</td>
	<td align="center">
		<a href="<?php echo site_url('petugas/edit_proyek/'.$tmp->idproject_profile)?>">
		<img src="<?php echo $this->config->item('img_path');?>/edit.png" width="20" height="20" title="Edit Project"/>
		</a>
	</td>
</tr>	
<?php endforeach;?>
<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
<tr>
	<td colspan="15" align="center"><?php echo $this->pagination->create_links();?></td>
</tr>
<tr>
	<th colspan="15">&nbsp;</th>
</tr>
</table>