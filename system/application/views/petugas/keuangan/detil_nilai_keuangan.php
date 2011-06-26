<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.4.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.accordion.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<script>
$(document).ready(function() 
{
	$("#sent_date, #approved_date, #paid_date").datepicker(
	{
		dateFormat: 'yy-mm-dd'
	});
});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#accord, #accordion, #basic-accordion').accordion({});
	});
</script>

<div class="lightbox">
	<h2><?php echo $detil->row('nama');?></h2>
	<h4>Payment for <?php echo $detil->row('detil_status');?></h4>
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

	<div>
		<table id="title-roll">
			<tr>
				<td class="roll-payment" rowspan="2" width="60px">Payment #</td>
				<td class="roll-payment" colspan="2">Payment Request</td>
				<td class="roll-payment" rowspan="2" width="80px">Request Status</td>
				<td class="roll-payment" colspan="2">Payment Value</td>
				<td class="roll-payment" rowspan="2" width="80px">Payment Status</td>
			</tr>
			<tr>
				<td class="roll-payment" width="100px">Rupiah (Rp)</td>
				<td class="roll-payment" width="100px">US Dollar ($)</td>
				<td class="roll-payment" width="100px">Rupiah (Rp)</td>
				<td class="roll-payment" width="100px">US Dollar ($)</td>
			</tr>
		</table>
	</div>

	<?php 
	$no=0; 
	foreach($payment->result() as $tmp):
	$payment_req = $this->irsdp_model->get_payment_request($tmp->idtermin_bayar);

		if($payment_req->num_rows()>0 && $payment_req->row('disetujui')==1) 
			$payment_status = "Already Paid";
		else 
			$payment_status = "Unpaid";
	?>
	<div id="basic-accordion">
		<div>
			<table id="content-roll" cellspacing="0" cellpading="0">
				<tr>
					<td class="roll-payment" width="60px"><?php echo ++$no;?></td>
					<td class="roll-payment" width="100px"><?php echo number_format($tmp->nilai_rupiah,0,"",".").",00"; ?></td>
					<td class="roll-payment" width="100px"><?php echo number_format($tmp->nilai_dollar).".00"; ?></td>
					<td class="roll-payment" width="80px"><?php 
						if($payment_req->row('disetujui')==1) 
							$req_status = "Accepted";
						else 
							$req_status = "Not Accepted Yet";			
						?>
					<?php echo $req_status; ?>
					</td>
					<td class="roll-payment" width="100px">
						<?php 
						if($payment_req->row('nilai_disetujui_rupiah')==NULL)
							echo "-";
						else
							echo number_format($payment_req->row('nilai_disetujui_rupiah')); 						
						?>
					</td>
					<td class="roll-payment" width="100px">
						<?php 
						if($payment_req->row('nilai_disetujui_dollar')==NULL)
							echo "-";
						else
							echo number_format($payment_req->row('nilai_disetujui_dollar')); 						
						?>
					</td>
					<td class="roll-payment" width="80px"><?php echo $payment_status;?></td>
				</tr>
			</table>
		</div>
		
		<?php $number=1; 
		//jika data tersedia
		if($payment_req->num_rows()>0):?>
		<div id="fill-rolling">
			<table id="paid-roll" cellspacing="0" cellpading="0">
				<tr>
					<th class="roll-payment2" rowspan="2" width="30px" style="border-left:1px dashed #fff;">No</th>
					<th class="roll-payment2" rowspan="2" width="150px">Request Date</th>
					<th class="roll-payment2" colspan="2">Request Value</th>
					<th class="roll-payment2" rowspan="2" width="200px">Document Request</th>
					<th class="roll-payment2" rowspan="2" width="150px">Sent Date</th>
					<th class="roll-payment2" rowspan="2" width="150px">Approved Date</th>
					<th class="roll-payment2" rowspan="2" width="150px">Paid Date</th>
					<th class="roll-payment2" rowspan="2" width="150px">Request Status</th>
				</tr>
				<tr>
					<th class="roll-payment2" width="150px">Rupiah (Rp)</th>
					<th class="roll-payment2" width="150px">US Dollar ($)</th>
				</tr>
				<tr>
					<td class="roll-payment3" width="30px" style="border-left:1px dashed #333;"><?php echo $number++; ?></td>
					<td class="roll-payment3"><?php echo nice_date($payment_req->row('tgl_permohonan'));?></td>
					<td class="roll-payment3"><?php echo number_format($payment_req->row('nilai_permintaan_rupiah'));?></td>
					<td class="roll-payment3"><?php echo number_format($payment_req->row('nilai_permintaan_dollar'));?></td>
					<td class="roll-payment3">
						<a href="<?php echo $this->config->item('docs_path').$payment_req->row('nama_berkas');?>">
								<?php echo $payment_req->row('nama_berkas');?></a>
					</td>
					<td class="roll-payment3"><?php echo nice_date($payment_req->row('tgl_dikirim'));?></td>
					<td class="roll-payment3"><?php echo nice_date($payment_req->row('tgl_disetujui'));?></td>
					<td class="roll-payment3"><?php echo nice_date($payment_req->row('dibayarkan'));?></td>
					<td class="roll-payment3"><?php echo $req_status;?></td>
				</tr>
			</table>
			<?php if($req_status=="Not Accepted Yet" && $this->session->userdata('id_user')=='1'): /* FIXME */?>
				<div class="commentbox">
					<h3>Confirm payment request:</h3>
					<?php echo form_open($this->uri->uri_string());?>
					<input type="hidden" name="idpermohonan" value="<?php echo $tmp->idpermohonan;?>" />
					<p>
					<label for="sent_date">Sent Date:</label>
					<input type="text" id="sent_date" name="sent_date" />
					<label for="approved_date">Approved Date:</label>
					<input type="text" id="approved_date" name="approved_date" />
					<label for="paid_date">Paid Date:</label>
					<input type="text" id="paid_date" name="paid_date" />										
					</p>
					
					<p><label for="nilai_disetujui_rupiah">Rupiah:</label>
					<input type="text" id="nilai_disetujui_rupiah" name="nilai_disetujui_rupiah" value="<?php echo $tmp->nilai_permintaan_rupiah;?>" />
					<label for="nilai_disetujui_eq_idr_usd">IDR Equivalent:</label>
					<input type="text" id="nilai_disetujui_eq_idr_usd" name="nilai_disetujui_eq_idr_usd" />

					<label for="nilai_disetujui_dollar">Dollar:</label>
					<input type="text" id="nilai_disetujui_dollar" name="nilai_disetujui_dollar" value="<?php echo $tmp->nilai_permintaan_dollar;?>" />					
					</p>	

					<p><label for="loan_adb_usd">Loan ADB:</label>
					<input type="text" id="loan_adb_usd" name="loan_adb_usd" />
					<label for="grant_gov_usd">Grant Government:</label>
					<input type="text" id="grant_gov_usd" name="grant_gov_usd" />
					</p>						
					<input type="submit" name="submit_confirm_payment" value="Confirm Payment" />			
					<?php echo form_close();?>
				</div>		
			<?php endif;?>
		</div>
		
		<?php else:?>
		<div id="fill-rolling">
			<table id="unpaid-roll">			
				<tr>
					<td width="150px">Payment Request</td>	
					<td width="5px">:</td>
					<td width="500px" colspan="3">Not Received Yet</td>
				</tr>
				<tr>
					<td colspan="4"><hr /></td>
				</tr>
				
				<?php if($this->session->userdata('id_user')=='4'): /* FIXME */?>
				<tr>	
				<td colspan="3">
					<?php echo form_open_multipart($this->uri->uri_string());?>
					<table>
					<tr>
						<td><u>Add Payment Request</u></td>
						<td width="5px"></td>
						<td colspan="3"><input type="hidden" name="idtermin_bayar" value="<?php echo $tmp->idtermin_bayar;?>" /></td>
					</tr>
					<tr>
						<td rowspan="2" valign="top">Request Value</td>
						<td rowspan="2" width="5px"  valign="top">:</td>
						<td width="90px">Rupiah (Rp)</td>
						<td><input type="text" id="nilai_permintaan_rupiah" name="nilai_permintaan_rupiah" values="<?php echo $tmp->nilai_rupiah;?>" /></td>
					</tr>
					<tr>				
						<td width="90px">US Dollar ($)</td>
						<td><input type="text" id="nilai_permintaan_dollar" name="nilai_permintaan_dollar" values="<?php echo $tmp->nilai_dollar;?>" /></td>
					</tr>
					<tr>
						<td>Document Request</td>
						<td width="5px">:</td>
						<td colspan="2"><input type="file" name="document_request" id="document_request" /></td>
					</tr>			
					<tr>		
						<td colspan="2">&nbsp;</td>
						<td colspan="2"><input type="submit" name="submit_add_payment" value="Submit Payment Request" /></td>
					</tr>
					</table>
					<?php echo form_close();?>
				</td>	
				</tr>
				<?php endif;?>
			</table>
			</div>
		<?php endif;?>	
</div>	
<?php endforeach;?>
