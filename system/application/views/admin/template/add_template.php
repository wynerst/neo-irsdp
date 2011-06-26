<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<?php
$form_dest = 'admin/add_template';
?>
<h2>Add Information Template</h2>
<hr />
<?php echo form_open($form_dest);?>
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
			echo "<option value=".$row->tag." >&nbsp;[".$row->tag."] - ".$row->label."</option>";
		}
	?></select></td>
</tr>

<tr>
	<th colspan="2">
	<input type="submit" value="Add Tag to Category" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>
</table>
<?php echo form_close();?>