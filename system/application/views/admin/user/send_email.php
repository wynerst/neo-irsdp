<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Send New Account to Consultant</h2>
<hr />

<?php ?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<?php foreach($konsultan->result() as $row)
{
	echo form_open('admin/sending_email');
?>
<tr>
	<td class="label" width="100px">Consultant</td>
	<td><?php echo $this->irsdp_model->get_consultant_name($row->idperusahaan); ?><input class="small3" type="text" name="nama" value="<?php echo $this->irsdp_model->get_consultant_name($row->idperusahaan); ?>" style="display:none" /></td>
</tr>
<tr>
	<td class="label" width="100px">Username</td>
	<td><?php echo $row->nama; ?><input class="small3" type="text" name="username" value="<?php echo $row->nama; ?>" style="display:none" /></td>
</tr>
<tr>
	<td class="label" width="100px">Password</td>
	<td><?php echo $row->password; ?><input class="small3" type="text" name="password" value="<?php echo $row->password; ?>" style="display:none" /></td>
</tr>
<tr>
	<td class="label" width="100px">Email</td>
	<td><?php echo $row->email; ?><input class="small3" type="text" name="email" value="<?php echo $row->email; ?>" style="display:none" /></td>
</tr>
<tr>
	<th colspan="2">
		<input type="submit" value="Send Email" />
		&nbsp;
		<input type="button" onclick="location.href='<?php echo site_url('admin/detail_konsultan/'.$row->idperusahaan);?>'" value="Back to Consultant" />
	</th>
</tr>
<?php echo form_close();
} ?>

</table>