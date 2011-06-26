<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>style.css"/>

<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<div class="lightbox">
	<h2><?php echo $detil->row('nama');?></h2>
	
	<div class="properties">
		<table>
			<tr>
				<td class="table_label">PIN/PPP Book Code</td>
				<td width="10px">:</td>
				<td>
					<?php echo ($detil->row('pin')=="")? "- ":$detil->row('pin');
					echo '/';
					echo ($detil->row('ppp_book_code')=="")? " -":$detil->row('ppp_book_code');
					?>
				</td>
				<td width="200px">&nbsp;</td>
				<td class="table_label">Project Type</td>
				<td width="10px">:</td>
				<td><?php echo ($detil->row('tipe_proyek')==1)? "Solicited":"Unsolicited";?></td>				
			</tr>		
			<tr>
				<td class="table_label">Sector</td>
				<td>:</td>
				<td><?php echo $detil->row('subsectorname');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Entry Date</td>
				<td>:</td>
				<td><?php echo nice_date($detil->row('tgl_diisi'));?></td>
			</tr>		
			<tr>
				<td class="table_label">Proposed Agency</td>
				<td>:</td>
				<td><?php echo $detil->row('usulan_lpd');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location</td>
				<td>:</td>
				<td><?php echo $detil->row('lokasi');?></td>
			</tr>
		</table>
	</div>	
</div>

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>No.</th>
	<th>Contract Phase</th>
	<th>Adminstrative Approval</th>
	<th>Technical Approval</th>
	<th>Payment Step</th>
	<th>Total Disbursement (Rupiah)</th>
	<th>Total Disbursement (Dollar)</th>
	<th>Grand Total (Dollar)</th>
	<!-- <th>Already Paid (%)</th> -->
	<th></th>
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
	
	$tmp_total_rupiah = $tmp_total_dollar = 0;
	$payment_count = $this->irsdp_model->get_payment_step_count($tmp->idkontrak_flow,'kontrak_step');
	$total_rupiah = $this->irsdp_model->get_contract_value_total($tmp->idkontrak_flow,'kontrak_step', 'rupiah');
	$total_dollar = $this->irsdp_model->get_contract_value_total($tmp->idkontrak_flow,'kontrak_step', 'dollar');
	$paid_rupiah = $this->irsdp_model->get_contract_value_paid($tmp->idkontrak_flow,'kontrak_step', 'rupiah');
	$paid_dollar = $this->irsdp_model->get_contract_value_paid($tmp->idkontrak_flow,'kontrak_step', 'dollar');
	$grand_total = $this->irsdp_model->get_contract_value_grand_total($tmp->idkontrak_flow,'kontrak_step');
	
	if($total_rupiah!="") 
	{ 
		$tmp_total_rupiah = $total_rupiah; 
		$total_rupiah = number_format($total_rupiah, 0);
	}
	else $total_rupiah = "-";

	if($total_dollar!="") 
	{ 
		$tmp_total_dollar = $total_dollar; 
		$total_dollar = number_format($total_dollar, 0);
	}
	else $total_dollar = "-";
	
	if($grand_total!="") $grand_total = number_format($grand_total, 0);
	else $grand_total = "0";
		
	if($paid_rupiah!="") $paid_rupiah = number_format(($paid_rupiah/$tmp_total_rupiah)*100, 0);
	else $paid_rupiah = "0";
	$paid_rupiah .= " %";
	
	if($paid_dollar!="") $paid_dollar = number_format(($paid_dollar/$tmp_total_dollar)*100, 0);
	else $paid_dollar = "0";	
	$paid_dollar .= " %";
	?>
	
	<td align="center"><?php echo humanize($pas_tpl['status']);?></td>
	<td align="center"><?php echo humanize($tas_tpl['status']);?></td>
	<td align="center"><?php echo $payment_count;?></td>
	<td align="center"><?php echo $total_rupiah." (".$paid_rupiah.")";?></td>
	<td align="center"><?php echo $total_dollar." (".$paid_dollar.")";?></td>
	<td align="center"><?php echo $grand_total;?></td>
	<td align="center">
		<?php if($payment_count==0): /* inisialisasi nilai kontrak */ ?>
		<a href="<?php echo site_url('petugas/inisialisasi_nilai_kontrak/'.$tmp->idproject_profile.'/'.$tmp->idkontrak_flow);?>">
		<img src="<?php echo $this->config->item('img_path');?>/edit.png" width="20" height="20" title="Inisialisasi nilai kontrak" />
		</a>		
		<?php else:?>
		<a href="<?php echo site_url('petugas/detil_nilai_keuangan/'.$tmp->idproject_profile.'/'.$tmp->idkontrak_flow);?>">
		<img src="<?php echo $this->config->item('img_path');?>/view.png" width="20" height="20" title="Detail"/>
		</a>
		<?php endif;?>
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