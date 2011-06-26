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

<h2>Edit Password</h2>
<hr />
<?php foreach($pic->result() as $row)
{
?>
<?php echo form_open('admin/edit_password/'.$row->idpic);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Old Password</td>
	<td><input type="password" class="small" name="oldpass" /></td>
</tr>
<tr>
	<td class="label">New Password</td>
	<td><input type="password" class="small" name="pass" /><input type="type" class="small3" name="nama" value="<?php echo $row->nama;?>" style="display:none;" /></td>
</tr>
<tr>
	<td class="label">Retype New Password</td>
	<td><input type="password" class="small" name="repass" /><input type="type" class="small3" name="idpic" value="<?php echo $row->idpic;?>" style="display:none;" /></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Change Password" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/edit_user/'.$row->idpic);?>'" value="Cancel" />
	</th>
</tr>
<?php } ?>

</table>
<?php echo form_close();?>