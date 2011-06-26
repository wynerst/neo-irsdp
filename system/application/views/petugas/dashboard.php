<h2>Project Dashboard</h2>
<hr />

<table class="nicetable">
	<tr class="headoff">
		<th colspan="2">PDF Project Selection</th>
		<th rowspan="3" class="separator">&nbsp;</th>
		
		<th colspan="3">PPC Procurement</th>		
		<th rowspan="3" class="separator">&nbsp;</th>
		
		<th colspan="3">TAC Procurement</th>	
	</tr>
	<tr>
		<th width="80px">Proposed</th>
		<th width="80px">Approved</th>
		
		<th width="60px">TOR Prep</th>
		<th width="60px">Tender</th>
		<th width="70px">Contracted</th>

		<th width="60px">TOR Prep</th>
		<th width="60px">Tender</th>
		<th width="70px">Contracted</th>		
	</tr>
	
	<tr class="count">
		<td class="dash"><?php echo anchor('petugas/daftar_proyek/selection/proposed', $sel_pro);?></td>
		<td class="dash"><?php echo anchor('petugas/daftar_proyek/selection/approved', $sel_app);?></td>
		
		<td class="dash"><?php echo anchor('petugas/daftar_proyek/ready_to_tender/pra_fs', $ready_pfs);?></td>
		<td class="dash"><?php echo anchor('petugas/daftar_proyek/ongoing_tender/pra_fs', $ong_pfs);?></td>
		<td class="dash"><?php echo anchor('petugas/daftar_proyek/contracted/pra_fs', $contract_pfs);?></td>

		<td class="dash"><?php echo anchor('petugas/daftar_proyek/ready_to_tender/transaction', $ready_trs);?></td>
		<td class="dash"><?php echo anchor('petugas/daftar_proyek/ongoing_tender/transaction', $ong_trs);?></td>
		<td class="dash"><?php echo anchor('petugas/daftar_proyek/contracted/transaction', $contract_trs);?></td>
	</tr>
</table>

<br /><br />

<table class="nicetable">
	<tr class="headoff">
		<th class="total" colspan="2">Total Disbursement</th>
	</tr>	
	<tr>
		<th>Rupiah (Rp)</th>
		<th>US Dollar ($)</th>
	</tr>
	
	<tr class="count">
		<td class="total-disbursement"><?php echo number_format($total_disb_rupiah,0,"",".").",00";?></td>
		<td class="total-disbursement"><?php echo number_format($total_disb_dollar).".00";?></td>
	</tr>
</table>

</div>
