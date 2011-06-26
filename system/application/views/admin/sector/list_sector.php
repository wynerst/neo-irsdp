<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>Project Sector Management</h2>
<hr />
<?php echo form_open('admin/list_sector');?>
<div style="float: left">
	Search Sector&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_sektor');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add Project Sector</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="20px">No</th>
	<th width="100px">Sector Code</th>
	<th width="300px">Sector Name</th>
	<th width="300px">Subsector Name</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($sektor->num_rows()>0)
{ 
$no=0; ?>
<?php foreach($sektor->result() as $tmp)
{
?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">	
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="center"><?php echo $tmp->sectorCode;?></td>
	<td>&nbsp;<?php echo $tmp->sectorName;?></td>
	<td>&nbsp;<?php echo $tmp->subsectorname;?></td>
	<td align="center"><a href="<?php echo site_url('admin/modify_sektor/'.$tmp->idkategori);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_sektor/'.$tmp->idkategori);?>">Delete</a></td>
</tr>
<?php } ?>
<tr>
	<td colspan="5" align="center"><?php echo $paging;?></td>
</tr>
<?php 
}
else
{
?>
<tr>
	<td colspan="5" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<th colspan="5">&nbsp;</th>
</tr>
</table>