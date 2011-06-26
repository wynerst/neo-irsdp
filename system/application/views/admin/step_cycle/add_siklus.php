<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>New Step Cycle Registration</h2>
<hr />

<?php echo form_open('admin/add_siklus');?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>

<tr>
	<td class="label">Step Phase</td>
	<td><select name="tahap">
	<option value="">-- select phase --</option>
	<?php 
		$query = $this->db->get('ref_status_tahapan');
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->id_tahapan." >&nbsp;".$row->id_tahapan.".&nbsp;&nbsp;".$row->nama_tahapan."</option>";
		}
	?></select></td>
</tr>

<tr>
	<td class="label">Step Status</td>
	<td><select name="status">
	<option value="">-- select status --</option>
	<?php 
		$this->db->orderby('id_status', 'asc');
		$query = $this->db->get('ref_status_proyek');
		foreach($query->result() as $row)
		{
			echo "<option value=".substr($row->id_status,1)." >&nbsp;".substr($row->id_status,0,1).".".substr($row->id_status,1).".&nbsp;&nbsp;".$row->nama_status."</option>";
		}
	?></select></td>
</tr>

<tr>
	<td class="label">Sequensial ID from Step Cycle</td>
	<td><input type="text" class="small3" name="id_detil" /></td>
</tr>

<tr>
	<td class="label">Step Name and Detail</td>
	<td><input type="text" class="long3" name="detil_status" /></td>
</tr>
<tr>
	<td class="label">Code (Sequence ID from Agency)</td>
	<td><input type="text" class="small2" name="kode_status" /></td>
</tr>
<tr>
	<td class="label">Form</td>
	<td><input type="text" class="small" name="formulir" /></td>
</tr>
<tr>
	<td class="label">User PIC in Charge</td>
	<td><select name="idpic">
	<option value="">-- select user --</option>
	<?php 
		$this->db->orderby('nama', 'desc');
		$query = $this->db->get('pic');
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idpic." >&nbsp;".$row->nama."</option>";
		}
	?></select></td>
</tr>
<tr>
	<td class="label">Next Step</td>
	<td><select name="next_step">
	<option value="">-- select next step --</option>
	<option value="0">-- end of step (no next step) -- </option>
	<?php 		
		$this->db->order_by('tahap', 'asc');
		$this->db->order_by('status', 'asc');
		$this->db->order_by('id_detil', 'asc');
		
		$query = $this->db->get('ref_status');
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idref_status." >&nbsp;".$row->tahap.".".$row->status.".".$row->id_detil.".&nbsp;&nbsp;".$row->kode_status."</option>";
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">Step of Contract</td>
	<td><select name="kontrak_step">
	<option value="0">&nbsp;0&nbsp;</option>
	<?php 		
		for($i=1; $i<=10; $i++)
		{
			echo "<option value=".$i." >&nbsp;".$i."&nbsp;</option>";
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">Flag in Report</td>
	<td>
		<input type="radio" name="laporan_flag" value="0" checked="true" />&nbsp;private
		<input type="radio" name="laporan_flag" value="<?php echo $this->irsdp_model->count_distinct(4)+1; ?>" />&nbsp;public
	</td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Submit" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
<?php echo form_close();?>