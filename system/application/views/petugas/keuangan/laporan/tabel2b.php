<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>style.css"/>

<style>
* {
	font-size: 11px;
} 

.nicetable th {
	font-size: 11.5px;	
}
</style>

<h2>Progress Report Of PDF - IRSDP Disbursement</h2>
<hr />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0" width="100%">
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
$group = "";

if(count($report)>0):
$contract_value['idr'] = $contract_value['usd'] = $contract_value['usd_equiv'] = $no = $disb_percent_total = 0;
$subcontract_value['idr'] = $subcontract_value['usd'] = $subcontract_value['usd_equiv'] = 0;
$kontrak['idr'] = $kontrak['usd'] = 0;
$disb['idr'] = $disb['equivalent'] = $disb['usd'] = $disb['total_usd'] = $disb['sub_usd'] = 0;
$source['loan'] = $source['grant'] = 0;
$percentage['idr'] = $percentage['usd'] = 0;

foreach($report as $tmp):
$row = count($tmp['consultant']) + 1;

?>
<tr valign="top">
<?php
	if ($group == $tmp['pin']) {
?>
	<td rowspan="<?php echo $row;?>" align="center">&nbsp;</td>
	<td rowspan="<?php echo $row;?>">&nbsp;</td>
<?php
	}
	else
	{
	$group = $tmp['pin'];
?>
	<td rowspan="<?php echo $row;?>" align="center"><?php echo ++$no;?></td>
	<td rowspan="<?php echo $row;?>"><?php echo $tmp['project_name'];?></td>
<?php
	}
?>
	<?php 
	if($tmp['consultant'])
	{
		foreach($tmp['consultant'] as $key => $pay):
		$contract_value['idr'] += $pay['nilai_rupiah'];
		$contract_value['usd'] += $pay['nilai_dollar'];
		$contract_value['usd_equiv'] += $pay['eq_idr_usd'] + $pay['nilai_dollar'];
		$subcontract_value['idr'] += $pay['nilai_rupiah'];
		$subcontract_value['usd'] += $pay['nilai_dollar'];
		$subcontract_value['usd_equiv'] += $pay['eq_idr_usd'] + $pay['nilai_dollar'];
		$disb['total_usd'] = $pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar'];
		$disb['sub_usd'] += $pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar'];
		$disb_percent = percentage($pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar'],$pay['eq_idr_usd'] + $pay['nilai_dollar']);
		$disb_percent_total += $disb_percent;
?>
	<tr valign="top">
	
	<td><?php echo $pay['nama'];?></td>
	<td align="right"><?php echo number_format($pay['nilai_rupiah']);?></td>
	<td align="right"><?php echo number_format($pay['nilai_dollar']);?></td>
	<td align="right"><?php echo number_format($pay['eq_idr_usd'] + $pay['nilai_dollar']);?></td>
	<td align="right"><?php echo $disb_percent."%";?></td>
	
	</tr>
	<?php endforeach;
	}
	else
	{
	?>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	</tr>
	<?php
	}
	?>
	
</tr>
<tr>
	<th colspan="3" align="right">Subtotal</th>
	<th align="right"><?php echo number_format($subcontract_value['idr']);?></th>
	<th align="right"><?php echo number_format($subcontract_value['usd']);?></th>
	<th align="right"><?php echo number_format($subcontract_value['usd_equiv']);?></th>
	<th align="right"><?php echo percentage($disb['sub_usd'],$subcontract_value['usd_equiv'])."%";?></th>
</tr>

<?php
	$subcontract_value['idr'] = $subcontract_value['usd'] = $subcontract_value['usd_equiv'] = $disb['sub_usd'] = 0;

	endforeach;?>
<tr>
	<th></th>
	<th>Total</th>
	<th></th>
	<th align="right"><?php echo number_format($contract_value['idr']);?></th>
	<th align="right"><?php echo number_format($contract_value['usd']);?></th>
	<th align="right"><?php echo number_format($contract_value['usd_equiv']);?></th>
	<th align="right"><?php echo percentage($disb['total_usd'],$contract_value['usd_equiv'])."%";?></th>
</tr>

<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
</table>
