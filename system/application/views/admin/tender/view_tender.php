<h2>View Detail Tender</h2>
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
	<td class="label">Project ID</td>
	<td class="text"><?php echo $row->idproj;?></td>
</tr>

<tr>
	<td class="label">Description</td>
	<td class="text"><?php echo $row->deskripsi;?></td>
</tr>

<tr>
	<td class="label">Date start</td>
	<td class="text"><?php echo $row->tgl_mulai;?></td>
</tr>

<tr>
	<td class="label">Date finish</td>
	<td class="text"><?php echo $row->tgl_selesai;?></td>
</tr>
<tr>
	<td class="label">Tender type</td>
	<td class="text"><?php echo $row->tipe_tender;?></td>
</tr>
<tr>
	<td class="label">PIC</td>
	<td class="text"><?php echo $row->penanggung_jawab;?></td>
</tr>
<tr>
	<td class="label">Current project status</td>
	<td class="text"><?php echo $row->idproj_flow;?></td>
</tr>
<tr>
	<th colspan="2">&nbsp;</th>
</tr>
</table>
<?php } ?>