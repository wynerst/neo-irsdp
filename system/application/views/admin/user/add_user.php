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

<h2>New User Registration</h2>
<hr />

<?php echo form_open('admin/add_user');?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Username</td>
	<td><input type="text" class="long" name="nama" /></td>
</tr>
<tr>
	<td class="label">Password</td>
	<td><input type="password" class="small" name="password" /></td>
</tr>
<tr>
	<td class="label">Retype Password</td>
	<td><input type="password" class="small" name="repassword" /></td>
</tr>
<tr>
	<td class="label">Group</td>
	<td><select type="text" name="group" />	
	<option value="">-- select group --</option>
	<?php
		$query = $this->db->get('group');	
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idgroup." >&nbsp;".$row->group."</option>";
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">PIC for Consultant</td>
	<td><select type="text" name="idperusahaan" />	
	<option value="0">-- not for consultant (internal account) -- (default)</option>
	<?php
		$query = $this->db->get('perusahaan');	
		$i=1;
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idperusahaan." >&nbsp;".$i.".&nbsp;".$row->nama."</option>";
			$i++;
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">Email Address</td>
	<td><input type="text" class="small" name="email" /></td>
</tr>
<tr>
	<td class="label">Phone Number (Fixed)</td>
	<td><input type="text" class="small" name="phone" /></td>
</tr>
<tr>
	<td class="label">Handphone Number</td>
	<td><input type="text" class="small" name="hp" /></td>
</tr>
<tr>
	<td class="label">Fax Number</td>
	<td><input type="text" class="small" name="fax" /></td>
</tr>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save User" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
<?php echo form_close();?>