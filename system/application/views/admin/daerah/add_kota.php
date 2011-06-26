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

<h2>City Registration</h2>
<hr />

<?php echo form_open('admin/add_kabupaten');?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">City Name</td>
	<td><input type="text" class="long" name="nama_kabupaten" /></td>
</tr>
<tr>
	<td class="label">Province</td>
	<td><select type="text" name="id_propinsi" />	
	<option value="">-- select province --</option>
	<?php
		$query = $this->db->get('master_propinsi');	
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->id_propinsi." >&nbsp;".$row->nama_propinsi."</option>";				
		}
	?>
	</select></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save City" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
<?php echo form_close();?>