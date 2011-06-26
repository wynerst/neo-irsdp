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

<h2>Edit City Properties</h2>
<hr />

<?php
$form_dest = 'admin/edit_kabupaten';
if(isset($kabupaten))
{
	$form_dest .= '/'.$kabupaten->row('id_kabupaten');
	$nama_kabupaten['value'] = $kabupaten->row('nama_kabupaten');
	$id_propinsi['value'] = $kabupaten->row('id_propinsi');
}                         
?>

<?php
foreach($kabupaten->result() as $tmp)
{
?>

<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">City Name</td>
	<td><input type="text" class="long" name="nama_kabupaten" value="<?php echo $tmp->nama_kabupaten;?>"  />		
		<input type="text" name="id_kabupaten" value="<?php echo $tmp->id_kabupaten;?>" style="visibility:hidden;"  /><</td>
</tr>
<tr>
	<td class="label">Province</td>
	<td><select type="text" name="id_propinsi" />	
	<option value="">-- select province --</option>
	<?php
		$query = $this->db->get('master_propinsi');	
		foreach($query->result() as $row)
		{
			if($tmp->id_propinsi==$row->id_propinsi)
				echo "<option value=".$row->id_propinsi." selected=\"selected\">&nbsp;".$row->nama_propinsi."</option>";
			else
				echo "<option value=".$row->id_propinsi." >&nbsp;".$row->nama_propinsi."</option>";				
		}
	?>
	</select></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_kabupaten');?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>
<?php } ?>