<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>


<?php
$form_dest = 'admin/modify_siklus';
if(isset($siklus))
{
	$form_dest .= '/'.$siklus->row('idref_status');
	$tahap['value'] = $siklus->row('tahap');
	$status['value'] = $siklus->row('status');
	$id_detil['value'] = $siklus->row('id_detil');
	$detil_status['value'] = $siklus->row('detil_status');
	$kode_status['value'] = $siklus->row('kode_status');
	$formulir['value'] = $siklus->row('formulir');
	$idpic['value'] = $siklus->row('idpic');
	$next_step['value'] = $siklus->row('next_step');	
	$kontrak_step['value'] = $siklus->row('kontrak_step');	
	$laporan_flag['value'] = $siklus->row('laporan_flag');
}                         
?>

<h2>Modify Step Cycle</h2>
<hr />

<?php 
foreach($siklus->result() as $tmp)
{
?>

<?php echo form_open($form_dest);?>
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
			if($tmp->tahap==$row->id_tahapan)
				echo "<option value=".$row->id_tahapan." selected=\"selected\">&nbsp;".$row->id_tahapan.".&nbsp;&nbsp;".$row->nama_tahapan."</option>";
			else
				echo "<option value=".$row->id_tahapan.">&nbsp;".$row->id_tahapan.".&nbsp;&nbsp;".$row->nama_tahapan."</option>";
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
			if($tmp->status==substr($row->id_status,1))
				echo "<option value=".substr($row->id_status,1)." selected=\"selected\">&nbsp;".substr($row->id_status,0,1).".".substr($row->id_status,1).".&nbsp;&nbsp;".$row->nama_status."</option>";
			else
				echo "<option value=".substr($row->id_status,1)." >&nbsp;".substr($row->id_status,0,1).".".substr($row->id_status,1).".&nbsp;&nbsp;".$row->nama_status."</option>";
		}
	?></select></td>
</tr>

<tr>
	<td class="label">Sequensial ID from Step Cycle</td>
	<td><input type="text" class="small3" name="id_detil" value="<?php echo $tmp->id_detil; ?>" />&nbsp;&nbsp;this project status have&nbsp;<b><?php echo $this->irsdp_model->count_tahap($tmp->tahap);?></b>&nbsp;step cycles</td>
</tr>

<tr>
	<td class="label">Step Name and Detail</td>
	<td><input type="text" class="long3" name="detil_status" value="<?php echo $tmp->detil_status; ?>"  /></td>
</tr>
<tr>
	<td class="label">Code (Sequence from State)</td>
	<td><input type="text" class="small2" name="kode_status" value="<?php echo $tmp->kode_status; ?>"  /></td>
</tr>
<tr>
	<td class="label">Form</td>
	<td><input type="text" class="small3" name="formulir" value="<?php if($tmp->formulir==NULL)	echo "0"; 
																	  else echo $tmp->formulir;?>"  /></td>
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
			if($tmp->idpic==$row->idpic)
				echo "<option value=".$row->idpic." selected=\"selected\">&nbsp;".$row->nama."</option>";
			else			
				echo "<option value=".$row->idpic." >&nbsp;".$row->nama."</option>";
		}
	?></select></td>
</tr>
<tr>
	<td class="label">Next Step</td>
	<td><select name="next_step">
	<option value="">-- select next step --</option>
	<option value="0" >-- end of step (no next step) -- </option>
	<?php 		
		$this->db->order_by('tahap', 'asc');
		$this->db->order_by('status', 'asc');
		$this->db->order_by('id_detil', 'asc');
		
		$query = $this->db->get('ref_status');
		foreach($query->result() as $row)
		{
			if($tmp->next_step==$row->idref_status)
				echo "<option value=".$row->idref_status." selected=\"selected\">&nbsp;".$row->tahap.".".$row->status.".".$row->id_detil.".&nbsp;&nbsp;".$row->kode_status."</option>";
			else
			{
				if($tmp->next_step==0)
					echo "<option value=\"0\" selected=\"selected\">-- end of step (no next step) -- </option>";
				else
					echo "<option value=".$row->idref_status." >&nbsp;".$row->tahap.".".$row->status.".".$row->id_detil.".&nbsp;&nbsp;".$row->kode_status."</option>";
			}
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">Step of Contract</td>
	<td><select name="kontrak_step">
	<?php 		
		for($i=0; $i<=10; $i++)
		{
			if($tmp->kontrak_step==NULL)
				echo "<option value=\"0\" selected=\"selected\">&nbsp;0&nbsp;</option>";
			else if($tmp->kontrak_step==$i)
				echo "<option value=".$i." selected=\"selected\">&nbsp;".$i."&nbsp;</option>";
			else				
				echo "<option value=".$i." >&nbsp;".$i."&nbsp;</option>";
		}
	?>
	</select></td>
</tr>
<tr>
	<td class="label">Flag in Report</td>
	<td>
	<?php
	if($tmp->laporan_flag==0)
	{
	?>
		<input type="radio" name="laporan_flag" value="0" checked="true" />&nbsp;private
		<input type="radio" name="laporan_flag" value="<?php echo substr($this->irsdp_model->get_latest_lap_flag(),0,1).(substr($this->irsdp_model->get_latest_lap_flag(),1)+1); ?>" />&nbsp;public
	<?php
	}
	else
	{
	?>
		<input type="radio" name="laporan_flag" value="0" />&nbsp;private
		<input type="radio" name="laporan_flag" checked="true" value="<?php echo $tmp->laporan_flag; ?>" />&nbsp;public
	<?php } ?>
	</td>
</tr>
<tr><td colspan="2"><input type="text" name="idref_status" id="idref_status" value="<?php echo $tmp->idref_status;?>" style="visibility:hidden;" /></td></tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/siklus_proyek');?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>
<?php } ?>