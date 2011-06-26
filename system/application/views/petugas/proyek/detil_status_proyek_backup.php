<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.2.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.jeditable.mini.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.autogrow.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.jeditable.autogrow.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<style type="text/css">
	.txt_editable textarea {
		padding: 5px;
		border: 1px solid #ccc;
		width: 98%; 
	}		
</style>

<script type="text/javascript">
$(function(){
	// start a counter for new row IDs
	// by setting it to the number
	// of existing rows
	var newRowNum = 1;

	// bind a click event to the "Add" link
	$('#addnew').click(function(){
		// increment the counter
		newRowNum += 1;
		
		$('#row_count').val(newRowNum);
						
		// get the entire "Add" row --
		// "this" refers to the clicked element
		// and "parent" moves the selection up
		// to the parent node in the DOM
		var addRow = $(this).parent().parent();
		
		// copy the entire row from the DOM
		// with "clone"
		var newRow = addRow.clone();
		
		// set the values of the inputs
		// in the "Add" row to empty strings
		$('input', addRow).val('');
		
		// replace the HTML for the "Add" link 
		// with the new row number
		$('td:first-child', newRow).html("");
		//$('td:first-child', newRow).html(newRowNum);
		
		// insert a remove link in the last cell
		//$('td:last-child', newRow).html('<a href="" class="remove">Hapus<\/a>');
		
		// loop through the inputs in the new row
		// and update the ID and name attributes
		$('input, select', newRow).each(function(i){
			var newID = newRowNum + '_' + i;
			$(this).attr('id',newID).attr('name',newID);
		});
		
		// insert the new row into the table
		// "before" the Add row
		addRow.before(newRow);
		
		// add the remove function to the new row
		$('a.remove', newRow).click(function(){
			$(this).parent().parent().remove();
			newRowNum-=1;
			return false;				
		});
	
		// prevent the default click
		return false;
	});
});
</script>

<script>
$(function() {
	$("#tgl_mulai, #tgl_akhir, #tgl_rencana").datepicker({
		dateFormat: 'yy-mm-dd',
	});
	$('.editable').editable('<?php echo site_url('petugas/update_followup');?>', { 
	    type      : 'autogrow',
	    cancel    : 'Cancel',
	    submit    : 'Save',
	    indicator : 'Saving...',
	    tooltip   : 'Click to edit...',
	    cssclass  : 'txt_editable',
	    onblur    : 'ignore'
	});	
});
</script>

<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<div class="lightbox">
	<h2><?php echo $detil->row('nama');?></h2>	
	<div class="properties">		
		<h4><?php echo $detil->row('detil_status')." (".$detil->row('kode_status').")";?></h4>
		<table width="100%">
			<tr>
				<td class="table_label">PIN/PPP Book Code:</td>
				<td>
					<?php echo ($detil->row('pin')=="")? "- ":$detil->row('pin');
					echo '/';
					echo ($detil->row('ppp_book_code')=="")? " -":$detil->row('ppp_book_code');
					?>
				</td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Project Type:</td>
				<td><?php echo ($detil->row('tipe_proyek')==1)? "Unsolicited":"Solicited";?></td>				
			</tr>			
			<tr>
				<td class="table_label">Date Proposed:</td>
				<td><?php echo nice_date($detil->row('tgl_usulan'));?></td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Entry Date:</td>
				<td><?php echo nice_date($detil->row('tgl_diisi'));?></td>
			</tr>		
			<tr>
				<td class="table_label">Proposed Agency</td> <!-- FIX ME : link to table proj_flow field 'idpemenang'  and become 'Consultant' --> 
				<td><?php echo $detil->row('usulan_lpd');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location:</td>
				<td><?php echo $detil->row('lokasi');?></td>
			</tr>
		</table>
	</div>	
</div>

<?php
$current_proj_step = $this->irsdp_model->get_current_step($detil->row('idproject_profile'));
if($current_proj_step==$detil->row('idref_status')):
if($this->session->userdata('sub_group')=='pas' && $detil->row('status')!='done'):?>
<div class="historybox">
	<h3>Project Status Update</h3>
	<?php 
	$proj_flow_check = $this->irsdp_model->check_proj_flow_status($detil->row('idproj_flow'));
	if($proj_flow_check!=2):
	?>
	<p><em>CAN NOT move to next step before passing administrative and technical fulfilment.</em></p>
	<?php 
	else:
		$cek_kontrak = $this->irsdp_model->is_kontrak($detil->row('idref_status'));
		$cek_status_kontrak = $this->irsdp_model->check_kontrak_flow($detil->row('idproj_flow'));
		
		if($cek_kontrak==1 && $cek_status_kontrak > 0): // jika status = kontrak dan belum terselesaikan
		?>
		<p><em>The Contract Flow had NOT been finished.</em></p>
		<?php
		else:
			echo form_open($this->uri->uri_string());
			// Get next step
			$next_step_id = $this->irsdp_model->get_next_step_id($detil->row('idref_status'));
			$is_kontrak = 0;
			if($next_step_id==0):
				$idref_status = $next_step_id;
			?>
				<input type="hidden" name="current_idref_status" value="<?php echo $current_proj_step;?>" />
			<?php 
			else: 
				$is_kontrak = $this->irsdp_model->is_kontrak($next_step_id); // cek kontrak step
				$next_step = $this->irsdp_model->get_next_step($next_step_id);
				$idref_status = $next_step->row('idref_status');
			endif;
			?>
			<p>Next Step: <strong>
			<?php 
				if($next_step_id==0) echo "Tender Processes"; /* FIXME */
				else echo $next_step->row('kode_status').' - '.$next_step->row('detil_status');
				
				if($is_kontrak==1) echo " (Contract Steps)"; /* FIXME */ ?>
			</strong></p>
			<?php if($next_step_id==0):?>
			<p>Tender Method: <input type="radio" name="jenis_tender" value="qcs" />CQS 
			<input type="radio" name="jenis_tender" value="qcbs" />QCBS</p>
			<?php elseif($is_kontrak==1):?>
			<!-- Kontrak flow -->
			<input type="hidden" name="row_count" id="row_count" value="1" />
			<table id="tabdata" width="100%" class="nicetable">
				<thead>
					<tr>
						<th colspan="2">Contract Flow</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a id="addnew" href="#">Add</a></td>
						<td><input id="1_0" name="1_0" type="text" style="width:95%" /></td>
					</tr>
				</tbody>
			</table>
			<?php endif;?>
			<input type="hidden" name="idproject_profile" value="<?php echo $detil->row('idproject_profile');?>" />
			<input type="hidden" name="idref_status" value="<?php echo $idref_status;?>" />
			<input type="hidden" name="is_kontrak" value="<?php echo $is_kontrak;?>" />
			<input type="hidden" name="idproj_flow" value="<?php echo $detil->row('idproj_flow');?>" />
			<p><label for="tgl_rencana">Date planned: </label>
			<input type="text" id="tgl_rencana" name="tgl_rencana" style="border: 1px solid #ccc; padding: 5px;" class="small" /></p>
			<input type="submit" name="submit_step" value="Move to the next step" />	
		<?php 
		echo form_close();
		endif;
	endif;
	?>
</div>
<?php 
	endif;
endif;
?>

<?php
if($current_proj_step==$detil->row('idref_status')):
if($detil->row('status')!='done'):
	if($this->session->userdata('sub_group')=='pas'):
?>
	<div class="historybox">
		<h3>Administrative Fulfilment</h3>
		<?php 
		// Count problem
		$pas_prob = $this->irsdp_model->count_problem_step($detil->row('idproj_flow'), 'pas');
		if($pas_prob>0):
		?>
		<p><em>You CAN NOT approved the Administrative part before closing all problems.</em></p>
		<?php else:
			$proj_flow_status = $this->irsdp_model->get_proj_flow_status($detil->row('idproj_flow'), 'pas');
			if($proj_flow_status!='done'):
		?>
			<p><em>NOT PASSED.</em></p>
			<p><a class="big_button" href="<?php echo site_url('petugas/set_proj_flow_status/'.$detil->row('idproject_profile').'/'.$detil->row('idproj_flow'));?>">Mark as PASSED</a></p>
			<?php else:?>
			<p><em>PASSED.</em></p>
			<?php endif;?>
		<?php endif;?>
	</div>
	
	<?php elseif($this->session->userdata('sub_group')=='tas'): ?>
	<div class="historybox">
		<h3>Technical Fulfilment</h3>
		<?php 
		// Count problem
		$pas_prob = $this->irsdp_model->count_problem_step($detil->row('idproj_flow'), 'tas');
		if($pas_prob>0):
		?>
		<p><em>You CAN NOT approved the Technical part before closing all problems.</em></p>
		<?php else:
			$proj_flow_status = $this->irsdp_model->get_proj_flow_status($detil->row('idproj_flow'), 'tas');
			if($proj_flow_status!='done'):
		?>
			<p><em>NOT PASSED.</em></p>
			<p><a class="big_button" href="<?php echo site_url('petugas/set_proj_flow_status/'.$detil->row('idproject_profile').'/'.$detil->row('idproj_flow'));?>">Mark as PASSED</a></p>
			<?php else:?>
			<p><em>PASSED.</em></p>
			<?php endif;?>		
		<?php endif;?>
	</div>
	<?php endif;?>
<?php 
	endif;
endif;
?>

<div class="historybox">
	<h3>Project Document(S)</h3>
	<?php if($dokumen->num_rows()!=0):?>
	<?php foreach($dokumen->result() as $dok): ?>
		<div class="history_entry">
		<img align="left" style="margin-right: 5px;" src="<?php echo $this->config->item('icon_path')?>page.png" />
		<a href="<?php echo $this->config->item('docs_path').$dok->nama_berkas;?>"><?php echo $dok->nama_berkas;?></a> on <?php echo nice_date($dok->tgl_upload);?> by <?php echo $dok->nama;?></div>
	<?php endforeach; ?>
	<?php else:?>
		<p><em>No Document Available</em></p>
	<?php endif;?>	

	<?php if($current_proj_step==$detil->row('idref_status')):?>
	<div class="commentbox">
		<h3>Add Document(s):</h3>
		<?php echo form_open_multipart($this->uri->uri_string());?>
		<input type="hidden" name="id_flow" value="<?php echo $detil->row('idproj_flow');?>" />
		<div><input style="width: 100%; padding: 10px;" type="file" name="nama_berkas" /></div><br >
		<input type="submit" name="submit_dokumen" value="Submit" />		
		<?php echo form_close();?>
	</div>
	<?php endif;?>
</div>

<div class="historybox">
	<h3>Project Problem and Follow-up</h3>
	<?php if($cerita->num_rows()!=0):?>
	<?php foreach($cerita->result() as $cer): 
		$entry_writable = ($this->session->userdata('id_user')==$cer->idoperator)? "entry_writable":""; ?>
		<div class="history_entry  <?php echo $entry_writable;?>">
		On <?php echo nice_date($cer->tgl_cerita);?> by <?php echo $cer->nama;?>
		<p><strong>Start from: </strong><?php echo nice_date($cer->tgl_mulai);?> <strong>until: </strong><?php echo nice_date($cer->tgl_akhir);?></p>
		<p><strong>Description of Status/Problem:</strong><br />
			<?php 
					if($cer->status_akhir!='done' && $this->session->userdata('id_user')==$cer->idoperator):
						$editable = 'editable';
					else:
						$editable = '';
					endif;
			?>
			<span id="<?php echo $cer->idcerita;?>" class="<?php echo $editable;?>"><?php echo $cer->deskripsi;?></span></p>
		<p><strong>Follow-up/Action:</strong><br />
			<?php 
					if($cer->status_akhir!='done' && $this->session->userdata('id_user')==$cer->idoperator):
						$editable = 'editable';
					else:
						$editable = '';
					endif;
			?>
			<span id="<?php echo $cer->idcerita;?>" class="<?php echo $editable;?>"><?php echo $cer->follow_up;?></span></p>
		<p style="float: left"><strong>Status:</strong><br /><?php echo humanize($cer->status_akhir);?></p>
		<?php 
		// If user have the privileges
		if($cer->status_akhir!='done' && $this->session->userdata('id_user')==$cer->idoperator):?>
		<p style="float: right"><a href="<?php echo site_url('petugas/set_problem_status/'.$detil->row('idproject_profile').'/'.$detil->row('idproj_flow').'/'.$cer->idstatusproject);?>">Close problem</a></p>
		<?php endif;?>
		<p class="clear"></p>		
		</div>
	<?php endforeach; ?>
	<?php else:?>
		<p><em>No Data Available</em></p>
	<?php endif;?>
	
	
	
	<?php if($current_proj_step==$detil->row('idref_status')):?>
	<div class="commentbox">
		<h3>Add New Status/Problem Description and Follow-up:</h3>
		<?php echo form_open($this->uri->uri_string());?>
		<label for="tgl_mulai">Start from:</label>
		<input type="text" id="tgl_mulai" name="tgl_mulai" style="border: 1px solid #ccc; padding: 5px;" class="small"  />
		<label for="tgl_akhir">until:</label>
		<input type="text" id="tgl_akhir" name="tgl_akhir" style="border: 1px solid #ccc; padding: 5px;" class="small"  />
		<br />
		<input type="hidden" name="id_flow" value="<?php echo $detil->row('idproj_flow');?>" />
		<label for="deskripsi">Description of Status/Problem:</label>
		<textarea name="deskripsi" style="width: 98%; border: 1px solid #ccc; padding: 5px;"></textarea>
		<label for="follow_up">Follow-up/Action:</label>
		<textarea name="follow_up" style="width: 98%; border: 1px solid #ccc; padding: 5px;"></textarea>
		<input type="submit" name="submit_komentar" value="Submit" />		
		<?php echo form_close();?>
	</div>
	<?php endif;?>
</div>