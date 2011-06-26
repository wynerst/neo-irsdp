<script language="javascript" type="text/javascript" >
function confirmdelete() 
{
	var confirm = document.getElementById("idref_status");
	confirm.value = window.confirm("Are you sure you want to delete?");
	return confirm.value;
}
</script> 

<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>Project Cycles</h2>
<hr />
<?php echo form_open('admin/siklus_proyek');?>
<div style="float: left">
	Search Sector&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_siklus');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;New Step Cycle</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="20px" rowspan="2">No</th>
	<th width="100px">Phase</th>
	<th width="100px">Project Status</th>
	<th width="300px" colspan="2">Detail of Project Status</th>
	<th width="50px" rowspan="2">Code</th>
	<th width="50px" rowspan="2">Form</th>
	<th width="70px" rowspan="2">Person in Charge</th>
	<th width="70px">Flag Report</th>
	<th rowspan="2">&nbsp;</th>
</tr>
<tr>
	<th class="info-head">(total <?php echo $this->irsdp_model->count_distinct(1); ?> phases)</th>
	<th class="info-head">(total <?php echo $this->irsdp_model->count_distinct(2); ?> status)</th>
	<th class="info-head" colspan="2">(total <?php echo $this->irsdp_model->count_distinct(3); ?> steps)</th>
	<th class="info-head">(<?php echo $this->irsdp_model->count_distinct(4); ?> public)</th>
</tr>

<?php if($siklus->num_rows()>0)
{
$no=0;
foreach($siklus->result() as $tmp): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">		
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="center">
		<?php 
			echo $this->irsdp_model->get_nama_tahapan($tmp->tahap);
		?>
	</td>
	<td align="center">
		<?php 
			echo $this->irsdp_model->get_nama_status($tmp->tahap.$tmp->status);
		?>
	</td>
	<td align="center"><?php echo $tmp->id_detil;?></td>
	<td align="left"><?php echo $tmp->detil_status;?></td>
	<td align="center"><?php echo $tmp->kode_status;?></td>
	<td align="center"><?php echo $tmp->formulir;?></td>
	<td align="center"><?php echo $tmp->nama;?></td>	
	<td align="center"><?php if($tmp->laporan_flag!=0) echo "public&nbsp;(T".$tmp->laporan_flag.")";
							else echo "<i>private</i>";?></td>
	<td align="center"><a href="<?php echo site_url('admin/modify_siklus/'.$tmp->idref_status);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/delete_siklus/'.$tmp->idref_status);?>">Delete</a></td>
</tr>	
<?php endforeach;?>
<?php }
else
{ 
?>
<tr>
	<td colspan="10" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr class="paging">
	<td colspan="10" align="center"><?php echo $paging; ?></td>
</tr>
<tr>
	<th colspan="10">&nbsp;</th>
</tr>
</table>