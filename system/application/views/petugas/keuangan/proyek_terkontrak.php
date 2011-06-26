<h2>Project Finance</h2>
<hr />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>No.</th>
	<th>PIN</th>
	<th>Sector</th>
	<th>Project Name</th>
	<th>Location</th>
	<th>Contract Step</th>
	<th>Payment Step</th>
	<th>Total Disbursement (Rupiah)</th>
	<th>Total Disbursement (Dollar)</th>	
	<th>Grand Total (Dollar)</th>
	<th colspan="2"></th>
</tr>

<?php if($proyek->num_rows()>0):?>
<?php foreach($proyek->result() as $tmp): 
$grand_total = $this->irsdp_model->get_contract_value_grand_total($tmp->idproj_flow, 'project');
if($grand_total!="") $grand_total = number_format($grand_total, 0);
else $grand_total = "0";
?>
<tr valign="top">
	<td align="center"><?php echo ++$no;?></td>
	<td><?php echo $tmp->pin;?></td>
	<td><?php echo $tmp->subsectorname;?></td>
	<td><?php echo $tmp->nama;?></td>
	<td><?php echo $tmp->lokasi;?></td>
	<td align="center"><?php echo $this->irsdp_model->get_contract_step_count($tmp->idproj_flow, 'project');?></td>
	<td align="center"><?php echo $this->irsdp_model->get_payment_step_count($tmp->idproj_flow, 'project');?></td>
	<td align="center"><?php echo number_format($this->irsdp_model->get_contract_value_total($tmp->idproj_flow, 'project', 'rupiah'));?></td>	
	<td align="center"><?php echo number_format($this->irsdp_model->get_contract_value_total($tmp->idproj_flow, 'project', 'dollar'));?></td>
	<td align="center"><?php echo $grand_total;?></td>	
	<td align="center">
		<a href="<?php echo site_url('petugas/detil_keuangan/'.$tmp->idproject_profile);?>">
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
	<th colspan="15"><?php echo $this->pagination->create_links();?></th>
</tr>
</table>