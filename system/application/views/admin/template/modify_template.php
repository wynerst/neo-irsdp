<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<?php
$form_dest = 'admin/modify_template';   

// edit mode
if(isset($template))
{
	$form_dest .= '/'.$template->row('idtemplate');
	$tag['value'] = $template->row('tag');
	$idcategory['value'] = $template->row('idcategory');
}                        
?>
<h2>Modify Project Template</h2>
<hr />
<?php echo form_open($form_dest);
//foreach($tag2->result() as $tmp)
//{?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>

<tr>
	<td class="label">Project Sector Category</td>
	<td><select name="idcategory">
	<option value="">-- select category --</option>
	<?php 
		$this->db->orderby('sectorCode', 'asc');
		$query = $this->db->get('kategori');
		$no=1;
		foreach($query->result() as $row)
		{
			if($row->idkategori==$template->row('idcategory'))
				echo "<option value=".$row->idkategori." selected=\"selected\">&nbsp;[".$row->sectorCode." - ".$row->sectorName."] - ".$row->subsectorname."</option>";
			else
				echo "<option value=".$row->idkategori." >&nbsp;[".$row->sectorCode." - ".$row->sectorName."] - ".$row->subsectorname."</option>";
		}
	?></select></td>
</tr>

<tr>
	<td class="label">Tag Code</td>
	<td><select name="tag">
	<option value="">-- select tag --</option>
	<?php 
		$this->db->orderby('tag', 'asc');
		$query = $this->db->get('daftar_ruas');
		$no=1;
		foreach($query->result() as $row)
		{
			if($row->tag==$template->row('tag'))
				echo "<option value=".$row->tag." selected=\"selected\">&nbsp;[".$row->tag."] - ".$row->label."</option>";
			else
				echo "<option value=".$row->tag.">&nbsp;[".$row->tag."] - ".$row->label."</option>";
		}
	?></select></td>
</tr>

<?php
if(isset($template)) echo form_hidden('idtemplate', $template->row('idtemplate'));
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