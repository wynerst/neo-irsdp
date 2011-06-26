<h2>View Detail Contractor</h2>
<hr />
<?php
foreach($detail->result() as $row)
{
?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">PIN Project</td>
	<td class="text"><?php echo $this->irsdp_model->get_pinproject_for_kontrak($row->idproject_profile);?></td>
</tr>
<tr>
	<td class="label">Project Name</td>
	<td class="text"><?php echo $this->irsdp_model->get_namaproject_for_kontrak($row->idproject_profile);?></td>
</tr>
<tr>
	<td class="label">Contractor Name</td>
	<td class="text"><?php echo $this->irsdp_model->get_perusahaan_for_kontrak($row->idperusahaan);?></td>
</tr>
<tr>
	<td class="label">Start Date</td>
	<td class="text"><?php echo $row->tgl_mulai;?></td>
</tr>
<tr>
	<td class="label">End Date</td>
	<td class="text"><?php echo $row->tgl_selesai;?></td>
</tr>
<tr>
	<td class="label">Tender Phase</td>
	<td class="text"><?php echo $row->tahapan;?></td>
</tr>
<tr>
	<td class="label">PCSS Number</td>
	<td class="text"><?php echo $row->pcss_no;?></td>
</tr>
<tr>
	<td class="label">PCSS Date</td>
	<td class="text"><?php echo $row->pcss_date;?></td>
</tr>
<tr>
	<td class="label">Contract Number</td>
	<td class="text"><?php echo $row->no_kontrak;?></td>
</tr>
<tr>
	<td class="label">Contract Approved Date</td>
	<td class="text"><?php echo $row->tgl_disetujui;?></td>
</tr>
<tr>
	<td class="label">Contract Budget (US$)</td>
	<td class="text"><?php echo $row->anggaran_usd;?></td>
</tr>
<tr>
	<td class="label">Contract Budget (IDR)</td>
	<td class="text"><?php echo $row->anggaran_idr;?></td>
</tr>
<tr>
	<td class="label">Total Contract Budget (US$)</td>
	<td class="text"><?php echo $row->anggaran_total_usd;?></td>
</tr>
<tr>
	<td class="label">Memo for Activity</td>
	<td class="text"><?php echo $row->catatan;?></td>
</tr>
<tr>
	<th colspan="2"><input type="button" onclick="location.href='<?php echo site_url('admin/list_kontraktor');?>'" value="Back to Contractor List" /></th>
</tr>
</table>
<?php } ?>