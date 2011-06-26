<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<?php
$form_dest = 'admin/modify_tag';   

// edit mode
if(isset($tagvalue))
{
	$form_dest .= '/'.$tagvalue->row('iddaftar_ruas');
	$iddaftar_ruas['value'] = $tagvalue->row('iddaftar_ruas');
	$tag['value'] = $tagvalue->row('tag');
	$label['value'] = $tagvalue->row('label');
}                        
?>
<h2>Modify Tag Data</h2>
<hr />
<?php echo form_open($form_dest);
//foreach($tag2->result() as $tmp)
//{?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>

<tr>
	<td class="label">Tag Code</td>
	<td><input type="text" name="tag" class="small3" value="<?php echo $tagvalue->row('tag');?>" /></td>
</tr>

<tr>
	<td class="label">Information Label</td>
	<td><input type="text" name="label" class="long" value="<?php echo $tagvalue->row('label');?>"  /></td>
</tr>

<?php
if(isset($tagvalue)) echo form_hidden('iddaftar_ruas', $tagvalue->row('iddaftar_ruas'));
//}
?>

<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_tag');?>'" value="Cancel" />
	</th>
</tr>

</table>
<?php echo form_close();?>