<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>View Detail Consultant</h2>
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
	<td colspan="2" class="top-manage"><a href="<?php echo site_url()."/admin/list_konsultan"; ?>"><img src="<?php echo $this->config->item('icon_path')."/arrow_left.png"; ?>" />&nbsp;Back</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo site_url()."/admin/account_konsultan/".$row->idperusahaan; ?>"><img src="<?php echo $this->config->item('icon_path')."/key_go.png"; ?>" />&nbsp;Edit or Make Login Account for this Consultant</a></td>
</tr>
<tr>
	<td class="label">Name of Consultant (Company)</td>
	<td class="text"><?php echo $row->nama;?></td>
</tr>
<tr>
	<td class="label">Consultant Type</td>
	<td class="text"><?php echo $row->jenis;?></td>
</tr>
<tr>
	<td class="label">Address</td>
	<td class="text"><?php echo $row->alamat;?></td>
</tr>
<tr>
	<td class="label">Fixed Phone</td>
	<td class="text"><?php echo $row->telpon;?></td>
</tr>
<tr>
	<td class="label">Facsimile Number</td>
	<td class="text"><?php echo $row->fax;?></td>
</tr>
<tr>
	<td class="label">Mobile Phone</td>
	<td class="text"><?php echo $row->hp;?></td>
</tr>
<tr>
	<td class="label">Email Address</td>
	<td class="text"><?php echo $row->email;?></td>
</tr>
<tr>
	<td class="label">Website</td>
	<td class="text"><?php echo $row->website;?></td>
</tr>
<tr>
	<td class="label">Status</td>
	<td class="text"><?php if($row->status==1)
								echo "Active";
							else
								echo "Not Active";?></td>
</tr>
<tr>
	<th colspan="2">&nbsp;</th>
</tr>
</table>
<?php } ?>