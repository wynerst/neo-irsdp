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
if(count($report)>0):
$kontrak['idr'] = $kontrak['usd'] = 0;
$disb['idr'] = $disb['equivalent'] = $disb['usd'] = $disb['total_usd'] = 0;
$source['loan'] = $source['grant'] = 0;
$percentage['idr'] = $percentage['usd'] = 0;

foreach($report as $tmp):
$kontrak['idr'] += $tmp['nilai_rupiah'];
$kontrak['usd'] += $tmp['nilai_dollar'];
$row = count($tmp['payment']);
?>
<tr valign="top">
	<td rowspan="<?php echo $row;?>" align="center"><?php echo $tmp['pin'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo $tmp['project_name'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['category'])? '-' : $tmp['category'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['nama_kontraktor'])? '-' : $tmp['nama_kontraktor'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['no_kontrak'])? '-' :  $tmp['no_kontrak'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['tgl_disetujui'])? '-' : $tmp['tgl_disetujui'];?></td>
	<td rowspan="<?php echo $row;?>" align="right"><?php echo number_format($tmp['anggaran_idr']);?></td>
	<td rowspan="<?php echo $row;?>" align="right"><?php echo number_format($tmp['anggaran_usd']);?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['total_bln'])? '-' : $tmp['total_bln'];?></td>

	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['pcss_no'])? '-' : $tmp['pcss_no'];?></td>
	<td rowspan="<?php echo $row;?>"><?php echo empty($tmp['pcss_date'])? '-' : $tmp['pcss_date'];?></td>

	<?php foreach($tmp['payment'] as $key => $pay):	
	$disb['idr'] += $pay['nilai_disetujui_rupiah'];
	$disb['equivalent'] += $pay['nilai_disetujui_eq_idr_usd'];
	$disb['usd'] += $pay['nilai_disetujui_dollar'];
	$disb['total_usd'] += $pay['nilai_disetujui_eq_idr_usd'] + $pay['nilai_disetujui_dollar'];
	
	$source['loan'] += $pay['loan_adb_usd'];
	$source['grant'] += $pay['grant_gov_usd'];	
	
	$percentage['idr'] += percentage($pay['nilai_disetujui_rupiah'], $tmp['nilai_rupiah']);
	$percentage['usd'] += percentage($pay['nilai_disetujui_dollar'], $tmp['nilai_dollar']);
	?>
	
	<td><?php echo $pay['detil_status'];?></td>
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
	<td><?php echo percentage($pay['nilai_disetujui_rupiah'], $tmp['nilai_rupiah'])."%";?></td>
	<td><?php echo percentage($pay['nilai_disetujui_dollar'], $tmp['nilai_dollar'])."%";?></td>
	</tr>
	<tr>
	<?php endforeach;?>
</tr>	

<?php endforeach;?>
<tr>
	<th>&nbsp;</th>
	<th colspan="5">TOTAL</th>
	<th align="right"><?php echo number_format($kontrak['idr']);?></th>
	<th align="right"><?php echo number_format($kontrak['usd']);?></th>
	<th>&nbsp;</th>		
	<th>&nbsp;</th>		
	<th align="right"><?php echo number_format($disb['idr']);?></th>
	<th align="right"><?php echo number_format($disb['equivalent']);?></th>
	<th align="right"><?php echo number_format($disb['usd']);?></th>
	<th align="right"><?php echo number_format($disb['total_usd']);?></th>
	<th align="right"><?php echo number_format($source['loan']);?></th>
	<th align="right"><?php echo number_format($source['grant']);?></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th><?php echo $percentage['idr']."%";?></th>		
	<th><?php echo $percentage['usd']."%";?></th>
</tr>

<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
</table>