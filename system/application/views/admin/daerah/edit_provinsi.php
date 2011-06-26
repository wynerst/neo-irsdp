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

<h2>Edit Group</h2>
<hr />

<?php
$form_dest = 'admin/edit_provinsi';
if(isset($provinsi))
{
	$form_dest .= '/'.$provinsi->row('id_propinsi');
	$nama_propinsi['value'] = $provinsi->row('nama_propinsi');
}                         
?>

<?php
foreach($provinsi->result() as $tmp)
{
?>

<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Province Name</td>
	<td><input type="text" class="long" name="nama_propinsi" value="<?php echo $tmp->nama_propinsi;?>"  />	
		<input type="text" name="id_propinsi" value="<?php echo $tmp->id_propinsi;?>" style="visibility:hidden;"  /></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_provinsi');?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>
<?php } ?>