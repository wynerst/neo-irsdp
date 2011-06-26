<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>style.css"/>

<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<div class="lightbox">
	<h2><?php echo $detil->row('nama');?></h2>
	
	<div class="properties">
		<table width="100%">
			<tr>
				<td class="table_label">PIN/PPP Book Code</td>
				<td width="10px">:</td>
				<td>
					<?php echo ($detil->row('pin')=="")? "- ":$detil->row('pin');
					echo '/';
					echo ($detil->row('ppp_book_code')=="")? " -":$detil->row('ppp_book_code');
					?>
				</td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Project Type</td>
				<td width="10px">:</td>
				<td><?php echo ($detil->row('tipe_proyek')==1)? "Solicited":"Unsolicited";?></td>				
			</tr>		
			<tr>
				<td class="table_label">Sector</td>
				<td width="10px">:</td>
				<td><?php echo $detil->row('subsectorname');?></td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Entry Date</td>
				<td width="10px">:</td>
				<td><?php echo nice_date($detil->row('tgl_diisi'));?></td>
			</tr>		
			<tr>
				<td class="table_label">Proposed Agency</td>
				<td width="10px">:</td>
				<td><?php echo $detil->row('usulan_lpd');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location</td>
				<td width="10px">:</td>
				<td><?php echo $detil->row('lokasi');?></td>
			</tr>
		</table>
	</div>	
</div>

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th rowspan="2">No.</th>
	<th rowspan="2">Contract Phase</th>
	<th rowspan="2">Report</th>
	<th rowspan="2">Product</th>
	<th rowspan="2">Due Date</th>
	<th rowspan="2">Adminstrative Approval</th>
	<th rowspan="2">Technical Approval</th>
	<th colspan="2">Milestone</th>
	<th rowspan="2"></th>
</tr>

<tr>
	<th class="sub_header">Project Time</th>
	<th class="sub_header">Amount</th>
</tr>

<?php if($detil->num_rows()>0): $no=$detil->num_rows() +1;?>
<?php foreach($detil->result() as $tmp): ?>
<tr valign="top">
	<td align="center"><?php echo --$no.'.';?></td>
	<td><?php echo $tmp->detil_status;?></td>
	
	<?php
	/* FIXME (Should not be here) */
	// ambil status dari pas dan tas
	$pas = $this->irsdp_model->get_status_proyek_terkontrak($tmp->idkontrak_flow, 'pas');
	$tas = $this->irsdp_model->get_status_proyek_terkontrak($tmp->idkontrak_flow, 'tas');
		
	// Build template
	$pas_tpl['status'] = $pas->row('status_akhir');
	$tas_tpl['status'] = $tas->row('status_akhir');
	$pas_tpl['fu_action'] = $tas_tpl['fu_action'] = '-';
	$pas_tpl['fu_pic'] = $tas_tpl['fu_pic'] = '-';
	$pas_tpl['fu_date'] = $tas_tpl['fu_date'] = '';
	
	if($pas->row('status_akhir')=='pending')
	{
		$pas_tpl['status'] = $pas->row('status_akhir').'<br />'.$pas->row('deskripsi');
		$pas_tpl['fu_action'] = $pas->row('follow_up');
		$pas_tpl['fu_pic'] = $pas->row('idoperator'); /* FIXME */
		$pas_tpl['fu_date'] = $pas->row('tgl_akhir');
	}
	
	if($tas->row('status_akhir')=='pending')
	{
		$tas_tpl['status'] = $tas->row('status_akhir').'<br />'.$tas->row('deskripsi');
		$tas_tpl['fu_action'] = $tas->row('follow_up');
		$tas_tpl['fu_pic'] = $tas->row('idoperator'); /* FIXME */
		$tas_tpl['fu_date'] = $tas->row('tgl_akhir');
	}	
	?>
	
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center"><?php echo nice_date($tmp->tanggal_rencana);?></td>
	<td align="center"><?php if($pas_tpl['status']) echo humanize($pas_tpl['status']);
												else echo "-";?></td>
	<td align="center"><?php if($tas_tpl['status'])echo humanize($tas_tpl['status']);
												else echo "-";?></td>
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="center">
		<a href="<?php echo site_url('petugas/detil_status_proyek_terkontrak/'.$tmp->idproject_profile.'/'.$tmp->idkontrak_flow);?>">
		<img src="<?php echo $this->config->item('img_path');?>/view.png" width="20" height="20" title="Detail"/>
		</a>
	</td>
</tr>	
<?php endforeach;?>
<?php else: ?>
<tr><td align="center" colspan="15"><em>No Data Available</em></td></tr>
<?php endif;?>
<tr>
	<th colspan="15">&nbsp;</th>
</tr>
</table>