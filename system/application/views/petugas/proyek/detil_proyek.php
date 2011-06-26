<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>style.css"/>

<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<?php if($this->uri->segment(4,0)!=="fullscreen"):?>
<h2>Project Detail</h2>
<hr />

<div id="full-right">
	<ul>
	<?php 
			if($this->uri->segment(2,0)=="detil_proyek"):
				echo "<li><a href=\"".site_url('petugas/detil_proyek/'.$this->uri->segment(3,0))."\" class=\"detail-proyek\">Detail Report</a></li>
					<li><a href=\"".site_url('petugas/detil_proyek_ringkas/'.$this->uri->segment(3,0))."\">Summary Report</a></li>
					<li><a href=\"".site_url('petugas/detil_proyek/'.$this->uri->segment(3,0).'/fullscreen')."\" target=\"_blank\">Fullscreen</a></li>";
			else:
				echo "<li><a href=\"".site_url('petugas/detil_proyek/'.$this->uri->segment(3,0))."\">Detail Report</a></li>
					<li><a href=\"".site_url('petugas/detil_proyek_ringkas/'.$this->uri->segment(3,0))."\" class=\"detail-proyek\">Summary Report</a></li>
					<li><a href=\"".site_url('petugas/detil_proyek_ringkas/'.$this->uri->segment(3,0).'/fullscreen')."\" target=\"_blank\">Fullscreen</a></li>";
			
			endif;

	endif;
	?>
	</ul>
</div>
<?php if($detil->num_rows()>0):?>
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
				<td><?php echo ($detil->row('tipe_proyek')==1)? "Unsolicited":"Solicited";?></td>				
			</tr>		
			<tr>
				<td class="table_label">Date Proposed</td>
				<td width="10px">:</td>
				<td><?php echo nice_date($detil->row('tgl_usulan'));?></td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Date Entry</td>
				<td width="10px">:</td>
				<td><?php echo nice_date($detil->row('tgl_diisi'));?></td>
			</tr>		
			<tr>
				<td class="table_label">Proposing Agency</td>
				<td width="10px">:</td>
				<td><?php echo $detil->row('usulan_lpd');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location</td>
				<td width="10px">:</td>
				<td><?php echo $detil->row('lokasi');?></td>
			</tr>
			<tr>
				<td class="table_label" valign="top">Consulting Firm</td>
				<td width="10px" valign="top">:</td>
				<td colspan="4">

<?php
if($kontraktor->num_rows()>0) {
	$data_kontraktor = $kontraktor->result_array();
	foreach ($data_kontraktor as $detilkontraktor) {
		echo $detilkontraktor['nama'] . " (". $detilkontraktor['tahapan'] .")<br />";
	}
	unset($detilkontraktor);
} else {
	echo "&nbsp;";
}
?>
			</tr>
		</table>
	</div>	
	<h2>Project Info</h2>
	<div class="properties">
		<div>
			<div style="float: left"></div>
			<div style="float: right">
			<?php
			if($this->uri->segment(4)!='fullscreen')
			{
				if (count($proyek_info->result()) > 0) {
					//echo anchor('petugas/modify_project_info/'.$this->uri->segment(3), 'Modify Project Info');
					echo "<a href='".site_url('petugas/modify_project_info').'/'.$this->uri->segment(3)."'><img src='".$this->config->item('icon_path').'pencil.png'."' />&nbsp;Modify Project Info</a>";
				} else {
					// hyperlink ke add project info
					echo "&nbsp;";
				}
			}
			?>
			</div>
		</div>
		
		<table width="100%">
			<?php if($proyek_info->num_rows > 0)
			{
				foreach($proyek_info->result() as $proj_info):?>
			<tr>
				<td class="table_label" width="250px"><?php echo $proj_info->label;?></td>
				<td width="10px">:</td>
				<td><?php echo $proj_info->value;?></td>
			</tr>			
			<?php endforeach;
			}
			else
			{	?>
			<tr>
				<td colspan="3"><i>none</i></td>
			</tr>
			<?php } ?>
		</table>
	</div>	
</div>

<?php else:?>
<div class="lightbox">
	<h2>Sorry, project detail is not for public consumption</h2>
	
	<div class="properties">
		<table width="100%">
			<tr>
				<td class="table_label">PIN/PPP Book Code</td>
				<td width="10px">:</td>
				<td>-</td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Project Type</td>
				<td width="10px">:</td>
				<td>-</td>				
			</tr>		
			<tr>
				<td class="table_label">Date Proposed</td>
				<td width="10px">:</td>
				<td>-</td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Date Entry</td>
				<td width="10px">:</td>
				<td>-</td>
			</tr>		
			<tr>
				<td class="table_label">Proposing Agency</td>
				<td width="10px">:</td>
				<td>-</td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location</td>
				<td width="10px">:</td>
				<td>-</td>
			</tr>
		</table>
	</div>	
</div>



<?php endif; ?>
<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th rowspan="3">No.</th>
	<th rowspan="3">Project info</th>
	<th colspan="5">Administration</th>
	<?php if($this->uri->segment(4,0)!=="fullscreen"):?>
		<th colspan="5">Technical</th>
		<th rowspan="3"></th>
	<?php else:?>
		<th colspan="6">Technical</th>
	<?php endif;?>
</tr>

<tr>
	<th rowspan="2" class="sub_header">Status</th>
	<th rowspan="2" class="sub_header">Date</th>
	<?php if($this->uri->segment(4,0)!=="fullscreen"):?>
		<th colspan="3" class="sub_header">Follow Up</th>
	<?php else:?>		
		<th colspan="4" class="sub_header">Follow Up</th>
	<?php endif;?>
	<th rowspan="2" class="sub_header">Status</th>
	<th rowspan="2" class="sub_header">Date</th>	
	<th colspan="3" class="sub_header">Follow Up</th>
</tr>

<tr>
	<th class="sub_header">Action</th>
	<th class="sub_header">PIC</th>
	<th class="sub_header">Date</th>	
	<th class="sub_header">Action</th>
	<th class="sub_header">PIC</th>
	<?php if($this->uri->segment(4,0)!=="fullscreen"):?>	
		<th class="sub_header">Date</th>	
	<?php else:?>
		<th colspan="2" class="sub_header">Date</th>	
	<?php endif;?>
		
</tr>

<?php if($detil->num_rows()>0): $no=$detil->num_rows() + 1;?>
<?php foreach($detil->result() as $tmp): ?>
<tr valign="top">
	<td align="center"><?php echo --$no.'.';?></td>
	<td><?php echo $tmp->detil_status;?> (<?php echo $tmp->kode_status;?>)</td>
	
	<?php
	/* FIXME (Should not be here) */
	// ambil status dari pas dan tas
	$pas = $this->irsdp_model->get_status_proyek($tmp->idproj_flow, 'pas');
	$tas = $this->irsdp_model->get_status_proyek($tmp->idproj_flow, 'tas');

	//echo "<pre>";
	//print_r($pas->result_array());
	//echo "</pre>";	
	
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
	
	<td><?php echo humanize($pas_tpl['status']);?></td>
	<td align="center"><?php echo nice_date($pas->row('tgl_mulai'));?></td>
	<td><?php echo $pas_tpl['fu_action'];?></td>
	<td align="center"><?php echo $pas_tpl['fu_pic'];?></td>	
	<td align="center"><?php echo nice_date($pas_tpl['fu_date']);?></td>
	
	<td><?php echo humanize($tas_tpl['status']);?></td>
	<td align="center"><?php echo nice_date($tas->row('tgl_mulai'));?></td>
	<td><?php echo $tas_tpl['fu_action'];?></td>
	<td align="center"><?php echo $tas_tpl['fu_pic'];?></td>	
	<?php if($this->uri->segment(4,0)!=="fullscreen"):?>	
		<td align="center"><?php echo nice_date($tas_tpl['fu_date']);?></td>
		<td align="center">
			<a href="<?php echo site_url('petugas/detil_status_proyek/'.$tmp->idproject_profile.'/'.$tmp->idproj_flow);?>">
				<img src="<?php echo $this->config->item('icon_path');?>zoom.png" title="Detail"/>
			</a>
		</td>
	<?php else:?>
		<td colspan="2" align="center"><?php echo nice_date($tas_tpl['fu_date']);?></td>
	<?php endif;?>
	
</tr>	
<?php endforeach;?>
<?php else: ?>
<tr><td align="center" colspan="15"><em>No data available</em></td></tr>
<?php endif;?>
<tr>
	<th colspan="15">&nbsp;</th>
</tr>
</table>
