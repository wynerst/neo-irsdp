<h2>IRSDP Fund Disbursement Progress Status Per Contract</h2>
<hr />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th rowspan="2">No.</th>
	<th rowspan="2">Project Name</th>
	<th rowspan="2">Consultant Firm</th>
	<th colspan="3">Contract Value</th>	
	<th rowspan="2">% of Disbursed from Contract</th>
</tr>
<tr>
	<th>IDR</th>
	<th>USD</th>
	<th>USD Equiv</th>
</tr>

<tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
	<th>7</th>
</tr>

<?php 
if($report->num_rows()>0):
$contract_value['idr'] = $contract_value['usd'] = $contract_value['usd_equiv'] = $no = $disb_percent_total = 0;
foreach($report->result() as $tmp):
$contract_value['idr'] += $tmp->nilai_rupiah;
$contract_value['usd'] += $tmp->nilai_dollar;
$contract_value['usd_equiv'] += $tmp->eq_idr_usd + $tmp->nilai_dollar;
$disb_percent = percentage($tmp->nilai_dollar, $tmp->nilai_disetujui_eq_idr_usd + $tmp->nilai_disetujui_dollar);
$disb_percent_total += $disb_percent;
?>
<tr valign="top">
	<td align="center"><?php echo ++$no;?></td>
	<td><?php echo $tmp->project_name;?></td>
	<td><?php echo $tmp->consultan_firm;?></td>
	<td align="right"><?php echo number_format($tmp->nilai_rupiah);?></td>
	<td align="right"><?php echo number_format($tmp->nilai_dollar);?></td>
	<td align="right"><?php echo number_format($tmp->eq_idr_usd + $tmp->nilai_dollar);?></td>
	<td align="right"><?php echo $disb_percent."%";?></td>
</tr>	
<?php endforeach;?>
<tr>
	<th></th>
	<th>Total</th>
	<th></th>
	<th align="right"><?php echo number_format($contract_value['idr']);?></th>
	<th align="right"><?php echo number_format($contract_value['usd']);?></th>
	<th align="right"><?php echo number_format($contract_value['usd_equiv']);?></th>
	<th align="right"><?php echo percentage($contract_value['usd'], $contract_value['idr']+$contract_value['usd_equiv'])."%";?></th>
</tr>

<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
</table>