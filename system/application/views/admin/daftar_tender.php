<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>PIN</th>
	<th>Project</th>
	<th>Description</th>
	<th>Tender type</th>
	<th>Date Start</th>
	<th>Date End</th>
	<th>PIC</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php if($tender->num_rows()>0):?>
<?php foreach($tender->result() as $tmp): ?>
<tr>
	<td align="center"><?php echo $tmp->pin;?></td>
	<td><?php echo $tmp->nama;?></td>
	<td><?php echo $tmp->deskripsi;?></td>
	<td><?php echo $tmp->tipe_tender;?></td>
	<td align="center"><?php echo $tmp->tgl_mulai;?></td>
	<td align="center"><?php echo $tmp->tgl_selesai;?></td>
	<td align="center"><?php echo $tmp->penanggung_jawab;?></td>
	<td align="center"><a href="<?php echo site_url('admin/input_ref_status');?>">Detail</a></td>
	<td align="center"><a href="<?php echo site_url('admin/input_ref_status');?>">New</a></td>

</tr>	
<?php endforeach;?>
<?php endif;?>
<tr>

</table>