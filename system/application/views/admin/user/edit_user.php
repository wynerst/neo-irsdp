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

<h2>Edit User Properties</h2>
<hr />

<?php
$form_dest = 'admin/edit_user';
if(isset($user))
{
	$form_dest .= '/'.$user->row('idpic');
	$nama['value'] = $user->row('nama');
	$group['value'] = $user->row('group');
	$email['value'] = $user->row('email');
	$phone['value'] = $user->row('phone');
	$hp['value'] = $user->row('hp');
	$fax['value'] = $user->row('fax');
}                         
?>

<?php
foreach($user->result() as $tmp)
{
?>

<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td colspan="2" class="top-manage"><a href="<?php echo site_url()."/admin/edit_password/".$tmp->idpic;?>"><img src="<?php echo $this->config->item('icon_path')."key.png";?>" />&nbsp;Change Password</a></td>
</tr>
<tr>
	<td class="label">Username</td>
	<td><input type="text" class="long" name="nama" value="<?php echo $tmp->nama;?>"  /></td>
</tr>
<tr>
	<td class="label">Group</td>
	<td><select type="text" name="group" />	
	<option value="">-- select group --</option>
	<?php
		$query = $this->db->get('group');	
		foreach($query->result() as $row)
		{
			if($tmp->group==$row->idgroup)
				echo "<option value=".$row->idgroup." selected=\"selected\">&nbsp;".$row->group."</option>";
			else
				echo "<option value=".$row->idgroup." >&nbsp;".$row->group."</option>";				
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">PIC for Consultant</td>
	<td><select type="text" name="idperusahaan" />	
	<?php
	if($row->idperusahaan==0)
			echo "<option value=\"0\" selected=\"selected\">&nbsp;-- not for consultant (internal account) -- (default)</option>";
	?>
	<?php
		$query = $this->db->get('perusahaan');	
		$i=1;
		foreach($query->result() as $row)
		{
			if($tmp->idperusahaan==$row->idperusahaan && $row->idperusahaan!=0)
				echo "<option value=".$row->idperusahaan." selected=\"selected\">&nbsp;".$i.".&nbsp;".$row->nama."</option>";
			else
				echo "<option value=".$row->idperusahaan." >&nbsp;".$i.".&nbsp;".$row->nama."</option>";
				
			$i++;
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">Email Address</td>
	<td><input type="text" class="small" name="email" value="<?php echo $tmp->email;?>" /></td>
</tr>
<tr>
	<td class="label">Phone Number (Fixed)</td>
	<td><input type="text" class="small" name="phone" value="<?php echo $tmp->phone;?>"  /></td>
</tr>
<tr>
	<td class="label">Handphone Number</td>
	<td><input type="text" class="small" name="hp" value="<?php echo $tmp->hp;?>"  /></td>
</tr>
<tr>
	<td class="label">Fax Number</td>
	<td><input type="text" class="small" name="fax" value="<?php echo $tmp->fax;?>"  />
		<input type="text" name="idpic" value="<?php echo $tmp->idpic;?>" style="visibility:hidden;"  /></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_user');?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>
<?php } ?>