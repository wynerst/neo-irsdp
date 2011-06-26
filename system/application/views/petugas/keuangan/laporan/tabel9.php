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
<tr>
	<th rowspan="3">PIN</th>
	<th rowspan="3">Project Name</th>
	<th rowspan="3">Cat</th>
	<th colspan="6">Implementor / Partners</th>
	<th colspan="2">PCSS</th>
	<th rowspan="3">Type of Disbursement</th>
	<th colspan="4">Amount of Disbursement</th>
	<th colspan="2">Source Fund</th>
	<th colspan="4">Disbursement Monitoring</th>
	<th colspan="2">Cumulative</th>
</tr>
<tr>
	<th rowspan="2">Company Name</th>
	<th rowspan="2">No. Contract</th>
	<th rowspan="2">Date of Contract</th>
	<th colspan="2">Amount of Contract (Exclude Tax)</th>
	<th rowspan="2">Time Period (Month)</th>

	<th rowspan="2">No</th>
	<th rowspan="2">Date</th>
	
	<th rowspan="2">IDR</th>
	<th rowspan="2">Equivalent</th>
	<th rowspan="2">USD</th>
	<th rowspan="2">Total USD</th>

	<th rowspan="2">Loan ADB</th>
	<th rowspan="2">Grant GOV</th>	

	<th rowspan="2">Date of Document to PMU</th>
	<th rowspan="2">Date of Document to KPPN</th>
	<th rowspan="2">Date of Document to ADB</th>
	<th rowspan="2">Date of ADB Liquid funds</th>	

	<th rowspan="2">IDR</th>
	<th rowspan="2">USD</th>		
</tr>

<tr>
	<th>IDR</th>
	<th>USD</th>
</tr>
<?php 
$group = "";
$subgroup = "";
$contract_value['idr'] = $contract_value['usd'] = 0;

if(count($report)>0):
$contract_value['usd_equiv'] = $no = $disb_percent_total = 0;
$subcontract_value['idr'] = $subcontract_value['usd'] = $subcontract_value['usd_equiv'] = 0;
$proj_value['idr'] = $proj_value['usd'] = $proj_value['total_usd'] = 0;
$kontrak['idr'] = $kontrak['usd'] = 0;
$disb['idr'] = $disb['equivalent'] = $disb['usd'] = $disb['total_usd'] = $disb['sub_usd'] = 0;
$disb['tot_idr'] = $disb['tot_equivalent'] = $disb['tot_usd'] = $disb['tot_total_usd'] = $disb['tot_loan'] = $disb['tot_grant'] = 0; 
$disb['loan'] = $disb['grant'] = 0;
$percentage['idr'] = $percentage['usd'] = 0;

foreach($report as $tmp):
$row = count($tmp['consultant']) +1;


?>
<tr valign="top">
<?php
	if (!empty($subgroup) AND $subgroup != $tmp['pin']) {
	$contract_value['idr'] += $proj_value['idr'];
	$contract_value['usd'] += $proj_value['usd'];
	$disb['tot_idr'] += $disb['idr']; 
	$disb['tot_equivalent'] += $disb['equivalent'];
	$disb['tot_usd'] += $disb['usd'];
	$disb['tot_total_usd'] += $disb['total_usd'];
	$disb['tot_loan'] += $disb['loan'];
	$disb['tot_grant'] += $disb['grant'];
?>
<tr>
	<th>&nbsp;</th>
	<th colspan="5">Sub-TOTAL</th>
	<th align="right"><?php echo number_format($proj_value['idr']);?></th>
	<th align="right"><?php echo number_format($proj_value['usd']);?></th>
	<th>&nbsp;</th>		
	<th>&nbsp;</th>	
	<th>&nbsp;</th>	
	<th>&nbsp;</th>
	<th align="right"><?php echo number_format($disb['idr']);?></th>
	<th align="right"><?php echo number_format($disb['equivalent']);?></th>
	<th align="right"><?php echo number_format($disb['usd']);?></th>
	<th align="right"><?php echo number_format($disb['total_usd']);?></th>
	<th align="right"><?php echo number_format($disb['loan']);?></th>
	<th align="right"><?php echo number_format($disb['grant']);?></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>		
	<th>&nbsp;</th>
<?php
	if (!empty($proj_value['idr'])) {
		$percentage['idr'] = percentage($disb['idr'], $proj_value['idr'])."%";
	} else {
		$percentage['idr'] = "0%";
	}
	if (!empty($proj_value['usd'])) {
		$percentage['usd'] = percentage($disb['usd'], $proj_value['usd'])."%";
	} else {
		$percentage['usd'] = "0%";
	}

?>
	<th><?php echo $percentage['idr'];?></th>		
	<th><?php echo $percentage['usd'];?></th>
	
</tr>
<?php
	$proj_value['idr'] = $proj_value['usd'] = $proj_value['total_usd'] = $subcontract_value['usd_equiv'] = $disb['sub_usd'] = 0;
	$disb['idr'] = $disb['equivalent'] = $disb['usd'] = $disb['total_usd'] = $disb['loan'] = $disb['grant'] = 0;
	}
	if ($group == $tmp['pin']) {
?>
	<td rowspan="<?php echo $row;?>" align="center">&nbsp;</td>
	<td rowspan="<?php echo $row;?>">&nbsp;</td>
	<td align="center" rowspan="<?php echo $row;?>">&nbsp;</td>
<?php
	}
	else
	{
	$group = $tmp['pin'];
	$subgroup = $tmp['pin'];
?>
	<td rowspan="<?php echo $row;?>" align="center"><?php echo $tmp['pin'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo $tmp['project_name'];?></td>
	<td align="center" rowspan="<?php echo $row;?>"><?php echo empty($tmp['category'])? '-' : $tmp['category'];?></td>
<?php
	}
?>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['nama_kontraktor'])? '-' : $tmp['nama_kontraktor'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['no_kontrak'])? '-' :  $tmp['no_kontrak'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['tgl_disetujui'])? '-' : $tmp['tgl_disetujui'];?></td>
	<td rowspan="<?php echo $row;?>" align="right"><?php echo number_format($tmp['anggaran_idr']);?></td>
	<td rowspan="<?php echo $row;?>" align="right"><?php echo number_format($tmp['anggaran_usd']);?></td>
	<?php $proj_value['idr'] += $tmp['anggaran_idr']; $proj_value['usd'] += $tmp['anggaran_usd']; $proj_value['total_usd'] += $tmp['anggaran_total_usd'];?>
	<td align="center" rowspan="<?php echo $row;?>"><?php echo empty($tmp['total_bln'])? '-' : $tmp['total_bln'];?></td>
	<td align="center" rowspan="<?php echo $row;?>"><?php echo empty($tmp['pcss_no'])? '-' : $tmp['pcss_no'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['pcss_date'])? '-' : $tmp['pcss_date'];?></td>

	<?php 
	if($tmp['consultant'])
	{
		foreach($tmp['consultant'] as $key => $pay):
		$contract_value['usd_equiv'] += $pay['eq_idr_usd'] + $pay['nilai_dollar'];
		$disb['idr'] += $pay['nilai_disetujui_rupiah'];
		$disb['equivalent'] += $pay['nilai_disetujui_eq_idr_usd'];
		$disb['usd'] += $pay['nilai_disetujui_dollar'];
		$disb['total_usd'] += $pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar'];
		$disb['sub_usd'] += $pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar'];
		$disb['loan'] += $pay['loan_adb_usd'];
		$disb['grant'] += $pay['grant_gov_usd'];
		$disb_percent = percentage($pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar'],$pay['eq_idr_usd'] + $pay['nilai_dollar']);
		$disb_percent_total += $disb_percent;
?>
	<tr valign="top">
	<td ><?php echo $pay['detil_status'];?></td>
	<td align="right"><?php echo number_format($pay['nilai_disetujui_rupiah']);?></td>
	<td align="right"><?php echo number_format($pay['nilai_disetujui_eq_idr_usd']);?></td>
	<td align="right"><?php echo number_format($pay['nilai_disetujui_dollar']);?></td>
	<td align="right"><?php echo number_format($pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar']);?></td>
	<td align="right"><?php echo number_format($pay['loan_adb_usd']);?></td>
	<td align="right"><?php echo number_format($pay['grant_gov_usd']);?></td>
	<td align="center"><?php echo short_date($pay['tgl_permohonan']);?></td>
	<td align="center"><?php echo short_date($pay['tgl_dikirim']);?></td>
	<td align="center"><?php echo short_date($pay['tgl_disetujui']);?></td>
	<td align="center"><?php echo short_date($pay['dibayarkan']);?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
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
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">-</td>
	<?php
	}
	?>
	
</tr>

<?php
	endforeach;
?>
<tr>
	<th>&nbsp;</th>
	<th colspan="5">Sub-TOTAL</th>
	<th align="right"><?php echo number_format($proj_value['idr']);?></th>
	<th align="right"><?php echo number_format($proj_value['usd']);?></th>
	<th>&nbsp;</th>		
	<th>&nbsp;</th>	
	<th>&nbsp;</th>	
	<th>&nbsp;</th>
	<th align="right"><?php echo number_format($disb['idr']);?></th>
	<th align="right"><?php echo number_format($disb['equivalent']);?></th>
	<th align="right"><?php echo number_format($disb['usd']);?></th>
	<th align="right"><?php echo number_format($disb['total_usd']);?></th>
	<th align="right"><?php echo number_format($disb['loan']);?></th>
	<th align="right"><?php echo number_format($disb['grant']);?></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>		
	<th>&nbsp;</th>
<?php
	$contract_value['idr'] += $proj_value['idr'];
	$contract_value['usd'] += $proj_value['usd'];
	$disb['tot_idr'] += $disb['idr']; 
	$disb['tot_equivalent'] += $disb['equivalent'];
	$disb['tot_usd'] += $disb['usd'];
	$disb['tot_total_usd'] += $disb['total_usd'];
	$disb['tot_loan'] += $disb['loan'];
	$disb['tot_grant'] += $disb['grant'];

	if (!empty($proj_value['idr'])) {
		$percentage['idr'] = percentage($disb['idr'], $proj_value['idr'])."%";
	} else {
		$percentage['idr'] = "0%";
	}
	if (!empty($proj_value['usd'])) {
		$percentage['usd'] = percentage($disb['usd'], $proj_value['usd'])."%";
	} else {
		$percentage['usd'] = "0%";
	}
?>
	<th><?php echo $percentage['idr'];?></th>		
	<th><?php echo $percentage['usd'];?></th>
	
</tr>
<?php
	$proj_value['idr'] = $proj_value['usd'] = $proj_value['total_usd'] = $subcontract_value['usd_equiv'] = $disb['sub_usd'] = 0;
	$disb['idr'] = $disb['equivalent'] = $disb['usd'] = $disb['total_usd'] = $disb['loan'] = $disb['grant'] = 0;
	$percentage['idr'] = percentage($disb['tot_idr'], $contract_value['idr'])."%";
	$percentage['usd'] = percentage($disb['tot_usd'], $contract_value['usd'])."%";
?>
<tr>
	<th>&nbsp;</th>
	<th colspan="5">TOTAL</th>
	<th align="right"><?php echo number_format($contract_value['idr']);?></th>
	<th align="right"><?php echo number_format($contract_value['usd']);?></th>
	<th>&nbsp;</th>		
	<th>&nbsp;</th>	
	<th>&nbsp;</th>	
	<th>&nbsp;</th>
	<th align="right"><?php echo number_format($disb['tot_idr']);?></th>
	<th align="right"><?php echo number_format($disb['tot_equivalent']);?></th>
	<th align="right"><?php echo number_format($disb['tot_usd']);?></th>
	<th align="right"><?php echo number_format($disb['tot_total_usd']);?></th>
	<th align="right"><?php echo number_format($disb['tot_loan']);?></th>
	<th align="right"><?php echo number_format($disb['tot_grant']);?></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>		
	<th>&nbsp;</th>
	<th><?php echo $percentage['idr'];?></th>		
	<th><?php echo $percentage['usd'];?></th>
</tr>

<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
</table>
