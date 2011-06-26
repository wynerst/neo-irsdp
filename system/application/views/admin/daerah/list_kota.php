<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>City Data Management</h2>
<hr />

<?php echo form_open('admin/list_kabupaten');?>
<div style="float: left">
	Search City&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_kabupaten');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add City</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="50px">No</th>
	<th width="300px">City Name</th>
	<th width="200px">Province</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($kab_by_key->num_rows()>0)
{
$no=0;
foreach($kab_by_key->result() as $row): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">			
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="left"><?php echo $row->nama_kabupaten;?></td>
	<td align="left"><?php echo $this->irsdp_model->get_nama_provinsi($row->id_propinsi);?></td>
	<td align="center">
		<a href="<?php echo site_url('admin/edit_kabupaten/'.$row->id_kabupaten);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_kabupaten/'.$row->id_kabupaten);?>">Delete</a>
	</td>
</tr>	
<?php endforeach;?>
<tr class="paging">
	<td colspan="4" align="center"><?php echo $paging; ?></td>
</tr>
<?php 
}
else
{ ?>
<tr>
	<td colspan="4" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<th colspan="4">&nbsp;</th>
</tr>
</table>