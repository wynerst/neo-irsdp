<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<h2>Contractors List</h2>
<hr />
<?php echo form_open('admin/list_kontraktor');?>
<div style="float: left">
	Search Contractor&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_kontraktor');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Choose New Contractor</a></li>
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
foreach($kontraktor->result() as $tmp): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">
	<td align="center"><?php echo ++$no;?></td>
	<td align="center"><a href=""><?php echo $this->irsdp_model->get_pinproject_for_kontrak($tmp->idproject_profile);?></a></td>
	<td align="left"><?php echo $this->irsdp_model->get_namaproject_for_kontrak($tmp->idproject_profile);?></td>
	<td><?php echo $this->irsdp_model->get_perusahaan_for_kontrak($tmp->idperusahaan);?></td>
	<td align="center"><?php echo $tmp->tahapan;?></td>
	<td align="center"><a href="<?php echo site_url('admin/detail_kontraktor/' . $tmp->idkontraktor);?>">Detail</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/modify_kontraktor/' . $tmp->idkontraktor);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_kontraktor/' . $tmp->idkontraktor);?>">Delete</a></td>

</tr>	
<?php endforeach;?>
<tr>
	<td align="center" colspan="6"><?php echo $paging; ?></td>
</tr>
<?php }
else
{
?>
<tr>
	<td colspan="6" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<th colspan="6">&nbsp;</th>
</tr>

</table>