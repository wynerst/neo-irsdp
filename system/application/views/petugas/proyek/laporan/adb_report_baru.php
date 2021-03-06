<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_path');?>style.css"/>

<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>


<h2>ADB Report</h2>
<hr />
<?php
if($this->uri->segment(4)!='preview')
{
	if($this->uri->segment(2)=='adb_report_pac')
		$lap_prev='adb_pac_preview';
	else if($this->uri->segment(2)=='adb_report_tac')
		$lap_prev='adb_pac_preview';
	else
		$lap_prev='adb_all_preview';
?>
<div id="full-right">
	<ul>
		<li><a href="<?php echo site_url('petugas/'.$lap_prev.'/'.$this->uri->segment(3).'/preview'); ?>" target="_blank">Print Preview</a></li>
	</ul>
</div>
<br />
<?php } ?>

<table width="100%" class="nicetable">
	<tr>
		<th colspan="8" align="center">Consultant Recruitment Activity Monitoring (CRAM)</th>
	</tr>
<?php 
if($proyek->num_rows()>0)
{
	foreach($proyek->result() as $tmp)
	{
?>
	<tr>
		<td width="20px" align="center">A</td>
		<td width="250px">Loan No. and Tittle</td>
		<td width="10px">:</td>
		<td colspan="5"><?php echo $tmp->nama; ?></td>
	</tr>		
	<tr>
		<td align="center">B</td>
		<td>Contract Budget (US$)</td>
		<td>:</td>
		<td colspan="2">US$&nbsp;<?php if($this->irsdp_model->get_budget($tmp->idproject_profile, 3) != "-" ) 
																	echo number_format($this->irsdp_model->get_budget($tmp->idproject_profile, 3),2); 
																else 
																	echo "-"; ?></td>
		<td width="20px">&nbsp;</td>
		<td width="70px">Package:</td>
		<td width="200px" rowspan="2"><?php echo $tmp->nama; ?></td>
	</tr>		
	<tr>
		<td align="center">C</td>
		<td>Contract</td>
		<td>:</td>
		<td width="200px">US$&nbsp;<?php if($this->irsdp_model->get_budget($tmp->idproject_profile, 1) != "-" ) 
																	echo number_format($this->irsdp_model->get_budget($tmp->idproject_profile, 1),2); 
																else 
																	echo "-"; ?></td>
		<td width="200px">IDR&nbsp;<?php if($this->irsdp_model->get_budget($tmp->idproject_profile, 2) != "-" ) 
																	echo number_format($this->irsdp_model->get_budget($tmp->idproject_profile, 2),2); 
																else 
																	echo "-"; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr>
	<tr>
		<td align="center">D</td>
		<td>Selection Method</td>
		<td>:</td>
		<td colspan="2"><?php 
				if(substr($this->irsdp_model->cek_status_proyek($tmp->idproject_profile),0,1)=='Q')
					echo "QCBS";
				else if(substr($this->irsdp_model->cek_status_proyek($tmp->idproject_profile),0,1)=='C')
					echo "CBS"; 
				else
					echo "-";
			?></td>
		<td>&nbsp;</td>		
		<td colspan="2">Financing:</td>
    </tr>		
	<tr>
		<td align="center">E</td>
		<td>Type of Technical Proposal</td>
		<td>:</td>
		<td colspan="2"><?php 
				if($this->irsdp_model->cek_tipe_proyek($tmp->idproject_profile)==0)
					echo "Full";
				else
					echo "Partial";
			?></td>
		<td>&nbsp;</td>
	    <td colspan="2" rowspan="3">&nbsp;</td>
	</tr>		
	<tr>
		<td align="center">F</td>
		<td>Executing Agency (EA)</td>
		<td>:</td>
		<td colspan="2"><?php echo $this->irsdp_model->pejabat_adb_tag($tmp->idproject_profile, '0090'); ?></td>
		<td>&nbsp;</td>
    </tr>
	<tr>
		<td align="center">G</td>
		<td>EA Contact Person</td>
		<td>:</td>
		<td colspan="2"><?php echo $this->irsdp_model->pejabat_adb_tag($tmp->idproject_profile, '0091'); ?></td>
		<td>&nbsp;</td>		
    </tr>		
	<tr>
		<td align="center">H</td>
		<td>Project Monitoring Unit (PMU)</td>
		<td>:</td>
		<td colspan="2"><?php echo $this->irsdp_model->pejabat_adb_tag($tmp->idproject_profile, '0092'); ?></td>
		<td colspan="2">&nbsp;</td>
		<td>Last edited by:</td>
	</tr>		
	<tr>
		<td align="center">I</td>
		<td>Senior Project Implementation Officer</td>
		<td>:</td>
		<td colspan="2"><?php echo $this->irsdp_model->pejabat_adb_tag($tmp->idproject_profile, '0093'); ?></td>
		<td colspan="2">&nbsp;</td>
		<td rowspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td align="center">J</td>
		<td>Principal Infrastructure Specialist</td>
		<td>:</td>
		<td colspan="2"><?php echo $this->irsdp_model->pejabat_adb_tag($tmp->idproject_profile, '0094'); ?></td>
		<td colspan="2">&nbsp;</td>		
	</tr>		
	<tr>
		<td align="center">K</td>
		<td>Procurement Officer</td>
		<td>:</td>
		<td colspan="2"><?php echo $this->irsdp_model->pejabat_adb_tag($tmp->idproject_profile, '0095'); ?></td>
		<td colspan="2">&nbsp;</td>
	</tr>		
	<tr>
		<td align="center">L</td>
		<td>IRM CRAM Coordinator</td>
		<td>:</td>
		<td colspan="2"><?php echo $this->irsdp_model->pejabat_adb_tag($tmp->idproject_profile, '0096'); ?></td>
		<td colspan="2">&nbsp;</td>
	</tr>
<?php 
	} 
}
else
{
?>
	<tr>
		<td colspan="8" align="center">project is empty</td>
	</tr>
<?php 
} 
?>
</table>
<br />
<table border="0" cellpadding="0" cellspacing="0"  class="nicetable">
<tr>
	<th colspan="2" rowspan="2">Activity</th>
	<th width="40px">Norm</th>
	<th colspan="3">Planned</th>
	<th colspan="3">Actual</th>
	<th colspan="2">Deviation</th>
	<th width="100px" rowspan="2">Explanation and Action</th>
</tr>

<tr>
	<th>Calendar Days</th>
	<th width="40px">Date</th>
	<th width="40px">Calendar Days</th>
	<th width="40px">Cummulative Days</th>
	<th width="40px">Achieved Date</th>
	<th width="40px">Days</th>
	<th width="40px">Cummulative Days</th>
	<th width="40px">Days</th>
	<th width="40px">Cummulative Days</th>
</tr>
<tr>
  <td align="center" colspan="2"><strong>1</strong></td>
  <td align="center"><strong>2</strong></td>
  <td align="center"><strong>3</strong></td>
  <td align="center"><strong>4</strong></td>
  <td align="center"><strong>5</strong></td>
  <td align="center"><strong>6</strong></td>
  <td align="center"><strong>7</strong></td>
  <td align="center"><strong>8</strong></td>
  <td align="center"><strong>9</strong></td>
  <td align="center"><strong>10</strong></td>
  <td align="center"><strong>11</strong></td>
</tr>
<?php if($this->uri->segment(5)!='preview')
{
?>
<tr>
  <td align="center" colspan="2">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/1_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/1_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
  </td>
  <td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/2_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/2_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
  </td>
  <td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/3_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/3_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
  </td>
  <td align="center">
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/4_asc"; ?>" title="sort ascending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_asc.png" /></a>
		<a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))."/4_desc"; ?>" title="sort descending">
		<img src="<?php echo $this->config->item('icon_path'); ?>sort_desc.png" /></a>
  </td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
</tr>

<?php 
}
if($adb_report->num_rows()>0)
{
	$no=0;
	$cum_planned_day=0;
	$cum_actual_day=0;
	$cum_deviation_day=0;
	$total_hr_kerja=0;
	$total_hr_kalender=0;
	$total_cum_planned_days=0;
	$total_planned_days=0;
	$total_cum_actual_day=0;
	$total_deviation_days=0;
	$total_cum_deviation_day=0;
	$prev_achieved_date="";
	foreach($adb_report->result() as $row)
	{
?>
<tr>
  <td align="center"><?php echo ++$no; ?></td>
  <td width="500px"><?php echo $this->irsdp_model->get_status_adb($row->idref_status); ?></td>
  <td align="center"><?php echo $row->hari_kerja; $total_hr_kerja+=$row->hari_kerja?></td>
  <td align="center"><?php echo $row->tgl_batas; ?></td>
  <td align="center"><?php echo $row->hari_kalender; $total_hr_kalender+=$row->hari_kalender; ?></td>
  <td align="center"><?php echo $cum_planned_day+=$row->hari_kalender; $total_cum_planned_days=$cum_planned_day; ?></td>
  <td align="center"><?php echo $achive_date=$this->irsdp_model->get_achive_date($tmp->idproject_profile, $row->idref_status); ?></td>
  <td align="center">
  <?php
		if ($no > 1) {
			if (($achive_date <> "0000-00-00" AND $achive_date <> "" AND $achive_date != NULL ) AND ($prev_achieved_date <> "0000-00-00" AND $prev_achieved_date <> "")) {
				echo $planned_days=floor(abs(strtotime($prev_achieved_date)-strtotime($achive_date)) / 86400); $total_planned_days+=$planned_days;
			} else {
				echo $planned_days=0; $total_planned_days+=$planned_days;
			}
		} else {
			if ($achive_date <> "0000-00-00" AND $achive_date <> "") {
				echo $planned_days=floor(abs(strtotime($row->tgl_batas)-strtotime($achive_date)) / 86400); $total_planned_days+=$planned_days;
			} else {
			echo $planned_days=0; $total_planned_days+=$planned_days;
			}
		}
		$prev_achieved_date= $achive_date;	
  ?>
  </td>
  <td align="center"><?php echo $cum_actual_day+=$planned_days; $total_cum_actual_day=$cum_actual_day; ?></td>
  <td align="center">
  <?php
		if ($no > 1) {
			if (($achive_date <> "0000-00-00" AND $achive_date <> "" AND $achive_date <> NULL ) AND ($prev_achieved_date <> "0000-00-00" AND $prev_achieved_date <> "")) {
				echo $deviation_days=$planned_days-$row->hari_kalender; $total_deviation_days+=$deviation_days;
			} else {
				echo $deviation_days=0; $total_deviation_days+=$deviation_days;
			}
		} else {
			if ($achive_date <> "0000-00-00" AND $achive_date <> "") {
				echo $deviation_days=$planned_days-$row->hari_kalender; $total_deviation_days+=$deviation_days;
			} else {
				echo $deviation_days=0; $total_deviation_days+=$deviation_days;
			}
		} ?></td>
  <td align="center"><?php echo $cum_deviation_day+=$deviation_days; $total_cum_deviation_day=$cum_deviation_day; ?></td>
  <td><?php echo ""; ?></td>
</tr>
<?php
	}
?>
<tr>
  <th colspan="2">Total number of days</th>
  <th><?php echo $total_hr_kerja; ?></th>
  <th>&nbsp;</th>
  <th><?php echo $total_hr_kalender; ?></th>
  <th><?php echo $total_cum_planned_days; ?></th>
  <th>&nbsp;</th>
  <th><?php echo $total_planned_days; ?></th>
  <th><?php echo $total_cum_actual_day; ?></th>
  <th><?php echo $total_deviation_days; ?></th>
  <th><?php echo $total_cum_deviation_day; ?></th>
  <th><?php echo ""; ?></th>
</tr>
<?php
}
else
{
?>
<tr>
	<td colspan="12" align="center">project report is empty</td>
</tr>
<?php } ?>
<tr>
	<th colspan="12">&nbsp;</th>
</tr>
</table>
