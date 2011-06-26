<h2>Status of Realization DIPA IRSDP</h2>
<hr />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th rowspan="2">No.</th>
	<th rowspan="2">Project Component</th>
	<th rowspan="2">Cat</th>
	<th colspan="3">DIPA IRSDP</th>
</tr>
<tr>
	<th>Budget</th>
	<th>Realization</th>
	<th>%</th>	
</tr>

<?php 
if($report->num_rows()>0):
$dipa['budget'] = $dipa['realization'] = $dipa['percentage'] = $no = 0;
foreach($report->result() as $tmp):
$total_disetujui_dollar = $tmp->nilai_disetujui_dollar + $tmp->nilai_disetujui_eq_idr_usd;
$total_nilai_dollar = $tmp->nilai_dollar = $tmp->eq_idr_usd;
$dipa['budget'] += $total_nilai_dollar;
$dipa['realization'] += $total_disetujui_dollar;
$dipa['percentage'] += percentage($total_disetujui_dollar, $total_nilai_dollar);
?>
<tr valign="top">
	<td align="center"><?php echo ++$no;?></td>
	<td><?php echo $tmp->project_component;?></td>
	<td><?php echo $tmp->category;?></td>
	<td align="right"><?php echo number_format($total_nilai_dollar);?></td>
	<td align="right"><?php echo number_format($total_disetujui_dollar);?></td>
	<td align="right"><?php echo percentage($total_disetujui_dollar, $total_nilai_dollar)."%";?></td>
</tr>	
<?php endforeach;?>
<tr>
	<th colspan="2">Total Project Cost Estimate</th>
	<th></th>
	<th align="right"><?php echo number_format($dipa['budget']);?></th>
	<th align="right"><?php echo number_format($dipa['realization']);?></th>
	<th align="right"><?php echo $dipa['percentage']."%";?></th>
</tr>

<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
</table>