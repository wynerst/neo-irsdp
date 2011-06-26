<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.2.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<script>
$(function() {
	$("#tgl_usulan").datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
</script>

<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<?php if(isset($upload_error)):?>
	<div class="validation_error">
	<?php echo $upload_error; ?>
	</div>
<?php endif;?>

<h2>Register New Project</h2>
<hr />

<?php echo form_open_multipart('petugas/input_usulan_proyek_baru');?>
<table class="nicetable">
<tr>
	<th colspan="2">PROPOSAL FORM</th>
</tr>

<tr>
	<td class="label">Project Title</td>
	<td><input class="long2" type="text" name="project_title" value="<?php echo set_value('project_title'); ?>" /></td>
</tr>

<tr>
	<td class="label">PIN</td>
	<td><input class="small" type="text" name="pin" value="<?php echo set_value('pin'); ?>" /></td>
</tr>

<tr>
	<td class="label">PPP Book Code</td>
	<td><input class="small" type="text" name="ppp_book_code" value="<?php echo set_value('ppp_book_code'); ?>" /></td>
</tr>

<tr>
	<td class="label">Category</td>
	<td>
		<select name="idkategori">
			<option value="">-- select category --</option>
			<?php foreach($kategori->result() as $tmp):?>
			<option value="<?php echo $tmp->idkategori;?>" <?php echo set_select('idkategori', $tmp->idkategori);?> >
				<?php echo $tmp->subsectorname;?>
			</option>
			<?php endforeach;?>
		</select>	
	</td>
</tr>

<tr>
	<td class="label">Project Type</td>
	<td>
		<select name="tipe_proyek">
			<option value="">-- select project type --</option>
			<option value="1" <?php echo set_select('tipe_proyek', '1');?>>Solicited</option>
			<option value="0" <?php echo set_select('tipe_proyek', '0');?>>Unsolicited</option>
		</select>	
	</td>
</tr>

<tr>
	<td class="label">Date Proposed</td>
	<td><input class="small2" type="text" id="tgl_usulan" name="tgl_usulan" value="<?php echo set_value('tgl_usulan'); ?>" /></td>
</tr>

<tr>
	<td class="label">Project Location</td>
	<td><input class="medium" type="text" name="project_location" value="<?php echo set_value('project_location'); ?>" /></td>
</tr>

<tr>
	<td class="label">Province</td>
	<td>
		<select name="province_code">
			<option value="">-- select province --</option>
			<?php foreach($propinsi->result() as $tmp):?>
			<option value="<?php echo $tmp->id_propinsi;?>" <?php echo set_select('province_code', $tmp->id_propinsi);?>>
				<?php echo $tmp->nama_propinsi;?>
			</option>
			<?php endforeach;?>
		</select>
	</td>
</tr>

<tr>
	<td class="label">Proposed Agency</td>
	<td><input class="medium" type="text" name="proposed_agency" value="<?php echo set_value('proposed_agency'); ?>" /></td>
</tr>

<tr>
	<td class="label">Dokumen Usulan</td>
	<td><input type="file" name="doc_usulan" /></td>
</tr>

<tr>
	<td class="label">Letter from Proposed Agency</td>
	<td>
		<input type="checkbox" name="surat_lpd" value="1" <?php echo set_checkbox('surat_lpd', '1');?> />&nbsp;&nbsp;(check if exist)
	</td>
</tr>

<tr>
	<td class="label">Approval Letter From DPRD</td>
	<td>
		<input type="checkbox" name="appr_dprd" value="1" <?php echo set_checkbox('appr_dprd', '1');?> />&nbsp;&nbsp;(check if exist)
	</td>
</tr>

<tr>
	<td class="label">PPP Proposal Document</td>
	<td>
		<input type="checkbox" name="ppp_form" value="1" <?php echo set_checkbox('ppp_form', '1');?> />&nbsp;&nbsp;(check if exist)
	</td>
</tr>

<tr>
	<td class="label">First Study Document</td>
	<td>
		<input type="checkbox" name="doc_fs" value="1" <?php echo set_checkbox('doc_fs', '1');?> />&nbsp;&nbsp;(check if exist)
	</td>
</tr>

<tr>
	<td class="label">Show Profile on ADB Report</td>
	<td>
		<input type="radio" name="view" value="2" checked />&nbsp;Visible
		<input type="radio" name="view" value="1" />&nbsp;Hidden
	</td>
</tr>

<tr>
	<th colspan="2">
		<input type="submit" value="Save Project" />&nbsp;
		<input type="reset" value="Reset" />	
	</th>
</tr>
</table>
<?php echo form_close();?>