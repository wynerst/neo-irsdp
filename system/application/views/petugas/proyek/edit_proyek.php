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

<h2>Edit Project Properties</h2>
<hr />

<?php echo form_open_multipart('petugas/edit_proyek');?>
<table class="nicetable">
<tr>
	<th colspan="2">EDIT PROJECT</th>
</tr>
<tr>
	<td class="label">Project Title</td>
	<td>
	<input type="hidden" name="idproject_profile" value="<?php echo $proyek->row('idproject_profile');?>" />
	<input class="long" type="text" name="project_title" value="<?php echo $proyek->row('nama'); ?>" /></td>
</tr>

<tr>
	<td class="label">PIN</td>
	<td><input class="small" type="text" name="pin" value="<?php echo $proyek->row('pin'); ?>" /></td>
</tr>

<tr>
	<td class="label">PPP Book Code</td>
	<td><input class="small" type="text" name="ppp_book_code" value="<?php echo $proyek->row('ppp_book_code'); ?>" /></td>
</tr>

<tr>
	<td class="label">Sector</td>
	<td>
		<?php
		foreach($kategori->result() as $tmp):
			$options[$tmp->idkategori] = $tmp->subsectorname;
		endforeach;
		echo form_dropdown('idkategori', $options, $proyek->row('id_kategori'));
		?>
	</td>
</tr>

<tr>
	<td class="label">Project Type</td>
	<td>	
		<?php
		$options = array('1' => 'Solicited', 
						'0' => 'Unsolicited',
        			);
		echo form_dropdown('tipe_proyek', $options, $proyek->row('tipe_proyek'));
		?>		
	</td>
</tr>

<tr>
	<td class="label">Tanggal Usulan</td>
	<td><input class="small" type="text" id="tgl_usulan" name="tgl_usulan" value="<?php echo $proyek->row('tgl_usulan'); ?>" /></td>
</tr>

<tr>
	<td class="label">Project Location</td>
	<td><input class="medium" type="text" name="project_location" value="<?php echo $proyek->row('lokasi'); ?>" /></td>
</tr>

<tr>
	<td class="label">Province</td>
	<td>
		<?php
		foreach($propinsi->result() as $tmp):
			$options[$tmp->id_propinsi] = $tmp->nama_propinsi;
		endforeach;
		echo form_dropdown('province_code', $options, $proyek->row('bpsid_propinsi'));
		?>
	</td>
</tr>

<tr>
	<td class="label">Proposed Agency</td>
	<td><input class="medium" type="text" name="proposed_agency" value="<?php echo $proyek->row('usulan_lpd'); ?>" /></td>
</tr>

<tr>
	<td class="label">Letter from Proposed Agency</td>
	<td>
		<?php
		$surat_lpd['name'] = 'surat_lpd';
		if($proyek->row('surat_lpd')==1) $surat_lpd['checked'] = TRUE;
	    echo form_checkbox($surat_lpd);
	    ?>	
	</td>
</tr>

<tr>
	<td class="label">Approval Letter From DPRD</td>
	<td>
		<?php
		$appr_dprd['name'] = 'appr_dprd';
		if($proyek->row('appr_dprd')==1) $appr_dprd['checked'] = TRUE;
	    echo form_checkbox($appr_dprd);
	    ?>
	</td>
</tr>

<tr>
	<td class="label">PPP Proposal Document</td>
	<td>
		<?php
		$ppp_form['name'] = 'ppp_form';
		if($proyek->row('ppp_form')==1) $ppp_form['checked'] = TRUE;
	    echo form_checkbox($ppp_form);
	    ?>	
	</td>
</tr>

<tr>
	<td class="label">First Study Document</td>
	<td>
		<?php
		$doc_fs['name'] = 'doc_fs';
		if($proyek->row('doc_fs')==1) $doc_fs['checked'] = TRUE;
	    echo form_checkbox($doc_fs);
	    ?>		
	</td>
</tr>

<tr>
	<td class="label">Project Visibility</td>
	<td>
		<input type="radio" name="view" value="2" <?php if($proyek->row('view')==2)
																								echo "checked";?> />&nbsp;Visible
		<input type="radio" name="view" value="1" <?php if($proyek->row('view')!=2)
																								echo "checked";?> />&nbsp;Hidden
	</td>
</tr>


<tr>
	<th colspan="2">
		<input type="submit" value="Save Changes" />&nbsp;
		<input type="button" onclick="location.href='<?php echo site_url('petugas/daftar_proyek');?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>