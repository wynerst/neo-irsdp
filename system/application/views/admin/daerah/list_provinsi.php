<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>Province Management</h2>
<hr />
<?php echo form_open('admin/list_provinsi');?>
<div style="float: left">
	Search Province&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_provinsi');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add Province</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="50px">No</th>
	<th width="300px">Province Name</th>	
	<th width="300px">Cities in Area</th>
	<th width="100px">Started Project</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($provinsi->num_rows()>0)
{
$no=0;
foreach($provinsi->result() as $row): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">			
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="left"><?php echo $row->nama_propinsi;?></td>
	<td align="center"><?php if($this->irsdp_model->count_provinsi_member($row->id_propinsi) > 0) 
								echo "<strong>".$this->irsdp_model->count_provinsi_member($row->id_propinsi)."</strong>&nbsp;cities";
							 else
								echo "<i>no city in area</i>";?></td>	
	<td align="center"><?php if($this->irsdp_model->count_current_project($row->id_propinsi) > 0) 
								echo "<strong>".$this->irsdp_model->count_current_project($row->id_propinsi)."</strong>&nbsp;projects";
							 else
								echo "<i>no project</i>";?></td>	
	<td align="center">
		<a href="<?php echo site_url('admin/edit_provinsi/'.$row->id_propinsi);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_provinsi/'.$row->id_propinsi);?>">Delete</a>
	</td>
</tr>	
<?php endforeach;?>
<tr class="paging">
	<td colspan="5" align="center"><?php echo $paging; ?></td>
</tr>
<?php }
else
{
?>
<tr>
	<td colspan="5" align="center"><i>data not available</i></td>
</tr>
<?php }?>
<tr>
	<th colspan="5">&nbsp;</th>
</tr>
</table>