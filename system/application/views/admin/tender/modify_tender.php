<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.2.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<script>
$(function() {
	$("#tgl_mulai").datepicker({
		dateFormat: 'yy-mm-dd',
	});
	$("#tgl_selesai").datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
</script>

<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Tender Management</h2>
<hr />



<?php
foreach($tender->result() as $tmp)
{
	echo form_open('admin/modify_tender/'.$tmp->idtender_data);
?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>

<tr>
	<td class="label">Project ID</td>
	<td><select name="idproj" >
	<option value="">-- select project --</option>
	<?php
		$this->db->orderby('idproject_profile', 'asc');
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
		{
			if($row->idproject_profile==$tmp->idproj)
				echo "<option value=".$row->idproject_profile." selected=\"selected\">".$row->idproject_profile.".&nbsp;".$row->nama."</option>";
			else
				echo "<option value=".$row->idproject_profile.">&nbsp;".$row->idproject_profile.".&nbsp;".$row->nama."</option>";
				
		}
	?>
	</select><input type="text" class="hide" name="idtender_data" value="<?php echo $tmp->idtender_data;?>" style="visibility:hidden;" /></td>
</tr>

<tr>
	<td class="label">Description</td>
	<td><input class="long" type="text" name="deskripsi" value="<?php echo $tmp->deskripsi;?>" /></td>
</tr>

<tr>
	<td class="label">Start Date</td>
	<td><input class="small2" id="tgl_mulai" type="text" name="tgl_mulai" value="<?php echo $tmp->tgl_mulai;?>" /></td>
</tr>

<tr>
	<td class="label">End Date</td>
	<td><input class="small2" id="tgl_selesai" type="text" name="tgl_selesai" value="<?php echo $tmp->tgl_selesai;?>" /></td>
</tr>
<tr>
	<td class="label">Tender Type</td>
	<td><input class="small" type="text" name="tipe_tender" value="<?php echo $tmp->tipe_tender;?>" /></td>
</tr>
<tr>
	<td class="label">PIC is Charge</td>
	<td><select name="penanggung_jawab" >
	<option value="">-- select pic --</option>
	<?php
		$this->db->orderby('nama', 'desc');
		$query = $this->db->get('pic');
		foreach($query->result() as $row)
		{
			if($tmp->penanggung_jawab==$row->idpic)
				echo "<option value=".$row->idpic." selected=\"selected\">".$row->nama."</option>";
			else
				echo "<option value=".$row->idpic.">&nbsp;".$row->nama."</option>";
				
		}
	?>
	</select></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_tender');?>'" value="Cancel" />
	</th>
</tr>

</table>
<?php echo form_close();?>
<?php } ?>