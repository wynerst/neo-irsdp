<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<?php
$form_dest = 'admin/add_tag';
?>
<h2>Modify Sector Data</h2>
<hr />
<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>

<tr>
	<td class="label">Tag Code</td>
	<td><input type="text" name="tag" class="small3" value="" /></td>
</tr>

<tr>
	<td class="label">Information Label</td>
	<td><input type="text" name="label" class="long" /></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Add Tag" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>
</table>
<?php echo form_close();?>