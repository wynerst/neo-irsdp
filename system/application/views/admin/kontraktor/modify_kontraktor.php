<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.4.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.accordion.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<script>
$(document).ready(function() 
{
	$("#tgl_mulai, #tgl_selesai, #pcss_date, #tgl_disetujui ").datepicker(
	{
		dateFormat: 'yy-mm-dd'
	});
});
</script>

<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Modify Contractor Data</h2>
<hr />

<?php

$form_dest = 'admin/modify_kontraktor';

// edit mode
if(isset($kontraktor))
{
	$form_dest .= '/'.$kontraktor->row('idkontraktor');
	$idkontraktor['value'] = $kontraktor->row('idkontraktor');
	$idproject_profile['value'] = $kontraktor->row('idproject_profile');
	$idperusahaan['value'] = $kontraktor->row('idperusahaan');
	$tgl_mulai['value'] = $kontraktor->row('tgl_mulai');
	$tgl_selesai['value'] = $kontraktor->row('tgl_selesai');
	$tahapan['value'] = $kontraktor->row('tahapan');
	$catatan['value'] = $kontraktor->row('catatan');
	$pcss_no['value'] = $kontraktor->row('pcss_no');
	$pcss_date['value'] = $kontraktor->row('pcss_date');
	$no_kontrak['value']= $kontraktor->row('no_kontrak');
	$tgl_disetujui['value']= $kontraktor->row('tgl_disetujui');	
	$anggaran_usd['value'] = $kontraktor->row('anggaran_usd');
	$anggaran_idr['value']= $kontraktor->row('anggaran_idr');
	$anggaran_total_usd['value']= $kontraktor->row('anggaran_total_usd');	
}                         
?>

<?php echo form_open($form_dest);
foreach($kontraktor->result() as $tmp)
{?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Project Name</td>
	<td><select name="idproject_profile">
	<option value="">-- select project --</option>
	<?php 
		$this->db->orderby('idproject_profile');
		$query = $this->db->get('project_profile');
		$no=1;
		foreach($query->result() as $row)
		{
			if($row->idproject_profile==$tmp->idproject_profile)
				echo "<option value=".$row->idproject_profile." selected=\"selected\">&nbsp;".$no++.".&nbsp;".$row->nama."</option>";
			else
				echo "<option value=".$row->idproject_profile." >&nbsp;".$no++.".&nbsp;".$row->nama."</option>";				
		}
	?></select></td>
</tr>
<tr>
	<td class="label">Choosen Consultant</td>
	<td><select name="idperusahaan">
	<option value="">-- select consultant --</option>
	<?php 
		$this->db->orderby('idperusahaan');
		$query = $this->db->get('perusahaan');
		$no=1;
		foreach($query->result() as $row)
		{
			if($row->idperusahaan==$tmp->idperusahaan)
				echo "<option value=".$row->idperusahaan." selected=\"selected\">&nbsp;".$no++.".&nbsp;".$row->nama."</option>";
			else
				echo "<option value=".$row->idperusahaan." >&nbsp;".$no++.".&nbsp;".$row->nama."</option>";
		}
	?></select></td>
</tr>
<tr>
	<td class="label">Start Date</td>
	<td><input type="text" name="tgl_mulai" id="tgl_mulai" value="<?php echo $tmp->tgl_mulai;?>" class="small2"/></td>
</tr>
<tr>
	<td class="label">End Date</td>
	<td><input type="text" name="tgl_selesai" id="tgl_selesai" value="<?php echo $tmp->tgl_selesai;?>" class="small2" /></td>
</tr>
<tr>
	<td class="label" valign="top">Tender Phase</td>
	<td>
		<input type="radio" <?php if($tmp->tahapan='1')echo "checked=\"checked\""; ?>name="tahapan" value="PraFS"  />PraFS<br />
		<input type="radio" <?php if($tmp->tahapan='1')echo "checked=\"checked\""; ?>name="tahapan" value="Transaction"  />Transaction<br />
		<input type="radio" <?php if($tmp->tahapan='1')echo "checked=\"checked\""; ?>name="tahapan" value="Investor"  />Investor
	</td>
</tr>
<tr>
	<td class="label" valign="top">PCSS Number:</td>
	<td><input type="text" name="pcss_no" class="small" value="<?php echo $tmp->pcss_no;?>" /></td>
</tr>
<tr>
	<td class="label" valign="top">PCSS Date:</td>
	<td><input type="text" name="pcss_date" id="pcss_date" class="small2" value="<?php echo $tmp->pcss_date;?>"/></td>
</tr>
<tr>
	<td class="label" valign="top">Contract Number:</td>
	<td><input type="text" name="no_kontrak" class="small" value="<?php echo $tmp->no_kontrak;?>" /></td>
</tr>
<tr>
	<td class="label">Contract Approved Date</td>
	<td><input type="text" name="tgl_disetujui" id="tgl_disetujui" class="small2" value="<?php echo $tmp->tgl_disetujui;?>" /></td>
</tr>
<tr>
	<td class="label">Contract Budget (US$)</td>
	<td><input type="text" name="anggaran_usd" class="small" value="<?php echo $tmp->anggaran_usd;?>" /></td>
</tr><tr>
	<td class="label">Contract Budget (IDR)</td>
	<td><input type="text" name="anggaran_idr" class="small" value="<?php echo $tmp->anggaran_idr;?>" /></td>
</tr><tr>
	<td class="label">Total Contract Budget (US$)</td>
	<td><input type="text" name="anggaran_total_usd" class="small" value="<?php echo $tmp->anggaran_total_usd;?>" /></td>
</tr>
<tr>
	<td class="label" valign="top">Memo for Activity</td>
	<td><textarea name="catatan" class="longtext" wrap="soft" maxlength="100000"><?php echo $tmp->catatan;?></textarea></td>
</tr>
<?php
if(isset($kontraktor)) echo form_hidden('idkontraktor', $kontraktor->row('idkontraktor'));

}
?>

<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_kontraktor');?>'" value="Cancel" />
	</th>
</tr>

</table>
<?php echo form_close();?>