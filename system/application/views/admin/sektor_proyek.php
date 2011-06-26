<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>Sector Code</th>
	<th>Name</th>
	<th>Sub-Sector Name</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php if($sektor->num_rows()>0):?>
<?php foreach($sektor->result() as $tmp): ?>
<tr>
	<td align="center"><?php echo $tmp->sectorCode;?></td>
	<td><?php echo $tmp->sectorName;?></td>
	<td><?php echo $tmp->subsectorname;?></td>
	<td align="center"><a href="<?php echo site_url('admin/input_ref_status');?>">Edit</a></td>
	<td align="center"><a href="<?php echo site_url('admin/input_ref_status');?>">New</a></td>
</tr>	
<?php endforeach;?>
<?php endif;?>
<tr>

</table>