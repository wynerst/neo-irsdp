<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<h2>Contractors List</h2>
<hr />
<?php echo form_open('petugas/list_kontraktor');?>
<div style="float: left">
	Search Contractor&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('petugas/add_kontraktor');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Choose/ Add New Contractor</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>No</th>
	<th>PIN</th>
	<th>Project</th>
	<th>Consultant</th>
	<th>Tender Type</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($kontraktor->num_rows()>0)
{
$no=0;

foreach($kontraktor->result() as $tmp):

$rowspans = $this->irsdp_model->get_group_kontraktor($tmp->idproject_profile);
$kontraktor_per_project = $this->irsdp_model->get_kontraktor_per_project($tmp->idproject_profile);
 ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">
	<td align="center" <?php if($rowspans > 1) echo "rowspan=\"".$rowspans."\"";?>><?php echo ++$no+$this->uri->segment(3);?></td>
	<td <?php if($rowspans > 1) echo "rowspan=\"".$rowspans."\"";?>><a href="<?php echo site_url('petugas/detail_kontraktor/' . $tmp->idkontraktor);?>"><?php echo $this->irsdp_model->get_pinproject_for_kontrak($tmp->idproject_profile);?></a></td>
	<td align="left" <?php if($rowspans > 1) echo "rowspan=\"".$rowspans."\"";?>><?php echo $this->irsdp_model->get_namaproject_for_kontrak($tmp->idproject_profile);?></td>
	<?php	
	if($rowspans <= 1)
	{//jika hanya satu kontraktor
	?>
		<td><?php echo $this->irsdp_model->get_perusahaan_for_kontrak($tmp->idperusahaan);?></td>
		<td align="center"><?php echo $tmp->tahapan;?></td>
		<td align="center"><a href="<?php echo site_url('petugas/detail_kontraktor/' . $tmp->idkontraktor);?>">Detail</a>&nbsp;|&nbsp;<a href="<?php echo site_url('petugas/modify_kontraktor/' . $tmp->idkontraktor);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('petugas/hapus_kontraktor/' . $tmp->idkontraktor);?>">Delete</a></td>
		</tr>	
	<?php 
	}
	
	else //jika banyak kontraktor untuk satu project
	{
		$no2=$no+1;
		foreach($kontraktor_per_project->result() as $konproj)
		{
		$style1 = "style=\"background:#e4eefd\"";
		$style2 = "style=\"background:none\"";
		?>
		<td <?php if($no2%2==0) echo $style1;
	else echo $style2;?> ><?php echo $this->irsdp_model->get_perusahaan_for_kontrak($konproj->idperusahaan);?></td>
		<td <?php if($no2%2==0) echo $style1;
	else echo $style2;?>  align="center"><?php echo $konproj->tahapan;?></td>
		<td <?php if($no2%2==0) echo $style1;
	else echo $style2;?>  align="center"><a href="<?php echo site_url('petugas/detail_kontraktor/' . $konproj->idkontraktor);?>">Detail</a>&nbsp;|&nbsp;<a href="<?php echo site_url('petugas/modify_kontraktor/' . $konproj->idkontraktor);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('petugas/hapus_kontraktor/' . $konproj->idkontraktor);?>">Delete</a></td>
		</tr>
		<?php
		++$no2;
		} 
	}
endforeach;?>
<?php }
else
{
?>
<tr>
	<td colspan="6" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<td align="center" colspan="6"><?php echo $paging; ?></td>
</tr>
<tr>
	<th colspan="6">&nbsp;</th>
</tr>

</table>