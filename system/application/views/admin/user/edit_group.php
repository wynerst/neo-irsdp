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
$form_dest = 'admin/edit_group';
if(isset($user))
{
	$form_dest .= '/'.$user->row('idgroup');
	$group['value'] = $user->row('group');
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
	<td class="label">Group Name</td>
	<td><input type="text" class="long" name="group" value="<?php echo $tmp->group;?>"  />	
		<input type="text" name="idgroup" value="<?php echo $tmp->idgroup;?>" style="visibility:hidden;"  /></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_group');?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>
<?php } ?>