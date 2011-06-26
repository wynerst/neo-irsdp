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
	<h4><?php echo $detil->row('detil_status');?></h4>
	
	<div class="properties">
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
				<td class="table_label">Proposing Agency:</td>
				<td><?php echo $detil->row('usulan_lpd');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location:</td>
				<td><?php echo $detil->row('lokasi');?></td>
			</tr>
		</table>
	</div>	
</div>

<?php
$current_contract_step = $this->irsdp_model->get_current_contract_step($detil->row('idkontrak_flow'));
if($current_contract_step==$detil->row('idref_kontrak')):
if($this->session->userdata('sub_group')=='pas' && $detil->row('status')!='done'):?>
<div class="historybox">
	<h3>Update Project Contract Status</h3>
	<?php 
	$proj_flow_check = $this->irsdp_model->check_kontrak_flow_status($detil->row('idkontrak_flow'));
	if($proj_flow_check!=3):
	?>
	<p><em>CAN NOT move to the next step before passing administrative and technical fulfilment.</em></p>
	<?php else:
		echo form_open($this->uri->uri_string());
		// Get next step
		$next_step_id = $this->irsdp_model->get_next_kontrak_step_id($detil->row('idref_kontrak'));
		if($next_step_id==0): // kontrak flow end
			$cek_status_kontrak = $this->irsdp_model->check_kontrak_flow($detil->row('idproj_flow'));
			if($cek_status_kontrak==1):
			?>
			<p><a class="big_button" href="<?php echo site_url('petugas/selesai_kontrak/'.$detil->row('idproject_profile').'/'.$detil->row('idkontrak_flow'));?>">Mark as FINISHED contract</a></p>
			<?php
			else:
			?>
			<p><em>All contract flow are done.</em></p>
			<?php
			endif;
		?>
		<?php 
		else: 
			$next_step = $this->irsdp_model->get_next_kontrak_step($next_step_id);
			$idref_kontrak = $next_step->row('idref_kontrak');
		?>
		<p>Next Step: <strong>
		<?php echo $next_step->row('detil_status');?>
		</strong></p>
		<input type="hidden" name="idproject_profile" value="<?php echo $detil->row('idproject_profile');?>" />
		<input type="hidden" name="idref_kontrak" value="<?php echo $idref_kontrak;?>" />
		<input type="hidden" name="idproj_flow" value="<?php echo $detil->row('idproj_flow');?>" />
		<input type="hidden" name="idkontrak_flow" value="<?php echo $detil->row('idkontrak_flow');?>" />
		<p><label for="tgl_rencana">Date Planned: </label>
		<input type="text" id="tgl_rencana" name="tgl_rencana" style="border: 1px solid #ccc; padding: 5px;" class="small" /></p>
		<input type="submit" name="submit_step" value="Move to the next step" />		
		<?php	
		endif;
		?>
	
	<?php 
	echo form_close();
	endif;
	?>
</div>
<?php 
	endif;
endif;
?>

<?php
if($current_contract_step==$detil->row('idref_kontrak')):
if($detil->row('status')!='done'):
	if($this->session->userdata('sub_group')=='pas'):
?>
	<div class="historybox">
		<h3>Administrative Fulfilment</h3>
		<?php 
		// Count problem
		$pas_prob = $this->irsdp_model->count_problem_step_kontrak($detil->row('idkontrak_flow'), 'pas');
		if($pas_prob>0):
		?>
		<p><em>CAN NOT approved the Administrtive part before closing all problems.</em></p>
		<?php else:
			$kontrak_flow_status = $this->irsdp_model->get_kontrak_flow_status($detil->row('idkontrak_flow'), 'pas');
			if($kontrak_flow_status!='done'):
		?>
			<p><em>NOT PASSED.</em></p>
			<p><a class="big_button" href="<?php echo site_url('petugas/set_kontrak_flow_status/'.$detil->row('idproject_profile').'/'.$detil->row('idkontrak_flow'));?>">Mark as PASSED</a></p>
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
		$pas_prob = $this->irsdp_model->count_problem_step_kontrak($detil->row('idkontrak_flow'), 'tas');
		if($pas_prob>0):
		?>
		<p><em>CAN NOT approved Technical part before closing all problems.</em></p>
		<?php else:
			$kontrak_flow_status = $this->irsdp_model->get_kontrak_flow_status($detil->row('idkontrak_flow'), 'tas');
			if($kontrak_flow_status!='done'):
		?>
			<p><em>NOT PASSED.</em></p>
			<p><a class="big_button" href="<?php echo site_url('petugas/set_kontrak_flow_status/'.$detil->row('idproject_profile').'/'.$detil->row('idkontrak_flow'));?>">Mark as PASSED</a></p>
			<?php else:?>
			<p><em>PASSED.</em></p>
			<?php endif;?>		
		<?php endif;?>
	</div>

	<?php elseif($this->session->userdata('sub_group')=='konsultan'): ?>
	<div class="historybox">
		<h3>Consultant Part</h3>
		<?php 
		// Count problem
		$pas_prob = $this->irsdp_model->count_problem_step_kontrak($detil->row('idkontrak_flow'), 'konsultan');
		if($pas_prob>0):
		?>
		<p><em>CAN NOT continue flow before closing all problems.</em></p>
		<?php else:
			$kontrak_flow_status = $this->irsdp_model->get_kontrak_flow_status($detil->row('idkontrak_flow'), 'konsultan');
			if($kontrak_flow_status!='done'):
		?>
			<p><em>PASSED.</em></p>
			<p><a class="big_button" href="<?php echo site_url('petugas/set_kontrak_flow_status/'.$detil->row('idproject_profile').'/'.$detil->row('idkontrak_flow'));?>">Mark as PASSED</a></p>
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
	<!--its me doing this-->
	<h3>Project Problem and Follow-Up</h3>
	<?php 
	$no=0;
	if($cerita->num_rows()!=0):?>
	<table width="100%" class="nicetable" cellspacing="0" cellpading="0">
		<tr>
			<th width="10px">No</th>
			<th width="150px">Last Action</th>
			<th width="30px">Start Date</th>
			<th width="30px">End Date</th>
			<th width="200px">Problem Description</th>
			<th width="200px">Action</th>
			<th width="100px">Status</th>
		</tr>
	<?php foreach($cerita->result() as $cer): ?>	
		<tr class="<?php 
								if($no%2==0) 
									echo "nice-ganjil";
								else if($cer->status_akhir=='pending')
									echo "nice-merah";
								else
									echo "nice-genap";
								
							?>">
			<td align="center"><?php echo ++$no; ?></td>
			<td align="center"><?php echo nice_date($cer->tgl_cerita);?> by <?php echo $cer->nama;?></td>
			<td align="center"><?php echo nice_date($cer->tgl_mulai);?></td>
			<td align="center"><?php echo nice_date($cer->tgl_akhir);?></td>
			<td><?php echo $cer->deskripsi;?></td>
			<td><?php echo $cer->follow_up;?></td>
			<td align="center"><?php 
					if($cer->status_akhir=='pending')
						echo "<span style='color:#ff0000;'><img src='".$this->config->item('icon_path').'accept.png'."' style=\"vertical-align:text-bottom;\"  />&nbsp;".strtoupper($cer->status_akhir)."</span><br />";
					else if($cer->status_akhir=='done')
						echo "<img src='".$this->config->item('icon_path').'accept.png'."' style=\"vertical-align:text-bottom;\"  />&nbsp;".humanize($cer->status_akhir);
					else
						echo humanize($cer->status_akhir);
					
					if($cer->status_akhir!='done' && $this->session->userdata('id_user')==$cer->idoperator)
					{
						echo "<br /><a href='".site_url('petugas/set_problem_status_kontrak/'.$detil->row('idproject_profile').'/'.$detil->row('idkontrak_flow').'/'.$cer->idstatuskontrak)."'><img src='".$this->config->item('icon_path').'wand.png'."' style=\"vertical-align:text-bottom;\"  />&nbsp;Close Problem</a>";
					}
					?>
			</td>
		</tr>
		
	<?php endforeach; ?>
	<?php else:?>
		<tr><td colspan="7"><em>No Data Available</em></td></tr>
	<?php endif;?>		
	</table>	
	<!--up here-->
	
	
	<?php if($current_contract_step==$detil->row('idkontrak_flow')):?>
	
	<div class="commentbox">
		<h3>Project Document(s)</h3>
		<?php if($dokumen->num_rows()!=0):?>
		<?php foreach($dokumen->result() as $dok): ?>
			<div class="history_entry">
			<img align="left" style="margin-right: 5px;" src="<?php echo $this->config->item('img_path')?>files_icon.gif" />
			<a href="<?php echo $this->config->item('docs_path').$dok->nama_berkas;?>"><?php echo $dok->nama_berkas;?></a> on <?php echo nice_date($dok->tgl_upload);?> by <?php echo $dok->nama;?></div>
		<?php endforeach; ?>
		<?php else:?>
			<p><em>No Document(s)</em></p>
		<?php endif;?>	

		<?php if($current_contract_step==$detil->row('idkontrak_flow')):?>
		<div class="commentbox">
			<h3>Add Document(s):</h3>
			<?php echo form_open_multipart($this->uri->uri_string());?>
			<input type="hidden" name="id_flow" value="<?php echo $detil->row('idkontrak_flow');?>" />
			<div><input style="width: 100%; padding: 10px;" type="file" name="nama_berkas" /></div><br >
			<input type="submit" name="submit_dokumen" value="Submit" />		
			<?php echo form_close();?>
		</div>
		<?php endif;?>
	</div>
	
	
	<div class="commentbox">
		<h3>Add New status/problem description and follow-up:</h3>
		<?php echo form_open($this->uri->uri_string());?>
		<label for="tgl_mulai">Start from:</label>
		<input type="text" id="tgl_mulai" name="tgl_mulai" style="border: 1px solid #ccc; padding: 5px;" class="small"  />
		<label for="tgl_akhir">until:</label>
		<input type="text" id="tgl_akhir" name="tgl_akhir" style="border: 1px solid #ccc; padding: 5px;" class="small"  />
		<br />
		<input type="hidden" name="id_flow" value="<?php echo $detil->row('idkontrak_flow');?>" />
		<label for="deskripsi">Description of Status/Problem:</label>
		<textarea name="deskripsi" style="width: 98%; border: 1px solid #ccc; padding: 5px;"></textarea>
		<label for="follow_up">Follow-up/Action:</label>
		<textarea name="follow_up" style="width: 98%; border: 1px solid #ccc; padding: 5px;"></textarea>
		<input type="submit" name="submit_komentar" value="Submit" />		
		<?php echo form_close();?>
	</div>
	<?php endif;?>
</div>