<h2>Recapitulation of Disbursment Progress of IRSDP per Fund Source</h2>
<hr />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th rowspan="2">No.</th>
	<th rowspan="2">Project Component</th>
	<th rowspan="2">Cat</th>
	<th rowspan="2">Total Loan and Grant</th>
	<th colspan="2">Allocated Fund</th>	
	<th colspan="2">Total Loan + Grant Disbursement</th>	
	<th rowspan="2">Not Yet Disbursement (Loan + Grant)</th>
</tr>
<tr>
	<th>Loan</th>
	<th>Grant</th>

	<th>Total</th>
	<th>%</th>	
</tr>

<?php 
if($report->num_rows()>0):
$total_loan_grant = $allocated['loan'] = $allocated['grant'] = $no = 0;
$disbursement['loan_grant'] = $disbursement['loan_grant_percentage'] = $not_disbursement['loan_grant'] = 0;
foreach($report->result() as $tmp):
$total_loan_grant += $tmp->loan_grand;
$allocated['loan'] += $tmp->loan;
$allocated['grant'] += $tmp->grand;

$disbursement['loan_grant'] += $tmp->grant_gov_usd + $tmp->loan_adb_usd;
$disbursement['loan_grant_percentage'] += percentage($disbursement['loan_grant'],$total_loan_grant);
$not_disbursement['loan_grant'] += $total_loan_grant - $disbursement['loan_grant'];
?>
<tr valign="top">
	<td align="center"><?php echo ++$no;?></td>
	<td><?php echo $tmp->project_component;?></td>
	<td><?php echo $tmp->category;?></td>
	<td align="right"><?php echo number_format($tmp->loan_grand);?></td>
	<td align="right"><?php echo number_format($tmp->loan);?></td>
	<td align="right"><?php echo number_format($tmp->grand);?></td>
	<td align="right"><?php echo number_format($tmp->grant_gov_usd + $tmp->loan_adb_usd);?></td>
	<td align="right"><?php echo percentage(($tmp->grant_gov_usd + $tmp->loan_adb_usd),$tmp->loan_grand)."%";?></td>
	<td align="right"><?php echo number_format($tmp->loan_grand - ($tmp->grant_gov_usd + $tmp->loan_adb_usd));?></td>
</tr>	
<?php endforeach;?>
<tr>
	<th colspan="2">Total Project Cost Estimate</th>
	<th></th>
	<th align="right"><?php echo number_format($total_loan_grant);?></th>
	<th align="right"><?php echo number_format($allocated['loan']);?></th>
	<th align="right"><?php echo number_format($allocated['grant']);?></th>
	<th align="right"><?php echo number_format($disbursement['loan_grant']);?></th>
	<th align="right"><?php echo $disbursement['loan_grant_percentage']."%";?></th>
	<th align="right"><?php echo number_format($not_disbursement['loan_grant']);?></th>
</tr>

<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
</table>