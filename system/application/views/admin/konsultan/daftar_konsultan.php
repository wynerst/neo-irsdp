<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<h2>Consultants List</h2>
<hr />
<?php echo form_open('admin/list_konsultan');?>
<div style="float: left">
	Search Consultant&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_konsultan');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add New Consultant</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>No</th>
	<th>Name</th>
	<th>Type</th>
	<th>Address</th>
	<th>Phone</th>
	<th>Email</th>
	<th>Status</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($konsultan->num_rows()>0)
{
$no=0;
foreach($konsultan->result() as $tmp): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td><a href="<?php echo site_url()."/admin/detail_konsultan/".$tmp->idperusahaan; ?>"><?php echo $tmp->nama;?></a></td>
	<td align="center"><?php echo $tmp->jenis;?></td>
	<td><?php echo $tmp->alamat;?></td>
	<td align="center"><?php echo $tmp->telpon;?></td>
	<td align="center"><a href="mailto:<?php echo $tmp->email;?>"><?php echo $tmp->email;?></a></td>
	<td align="center"><?php if($tmp->status==1)
				echo "Active";
			else
				echo "Not Active";?>
	</td>
	<td align="center"><a href="<?php echo site_url('admin/detail_konsultan/' . $tmp->idperusahaan);?>">Detail</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/modify_konsultan/' . $tmp->idperusahaan);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_konsultan/' . $tmp->idperusahaan);?>">Delete</a></td>

</tr>	
<?php endforeach;?>
<tr>
	<td colspan="8" align="right"><i>"Active" means the consultant have a login account to system</i></td>
</tr>
<tr>
	<td align="center" colspan="8"><?php echo $paging; ?></td>
</tr>
<?php }
else
{
?>
<tr>
	<td colspan="8" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<th colspan="8">&nbsp;</th>
</tr>

</table>