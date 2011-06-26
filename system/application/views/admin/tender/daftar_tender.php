<?php if($this->session->flashdata('form_submit_status')!=""): ?>
<div class="form_submit_status">
<?php echo $this->session->flashdata('form_submit_status');?>
</div>
<?php endif;?>

<h2>Tender List</h2>
<hr />
<?php echo form_open('admin/list_tender');?>
<div style="float: left">
	Search Tender&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_tender');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add New Tender</a></li>
	</ul>
</div>
<br /><br />


<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th>No</th>
	<th>PIN</th>
	<th>Project</th>
	<th>Description</th>
	<th>Tender type</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>PIC</th>
	<th>&nbsp;</th>
</tr>

<?php if($tender->num_rows()>0)
{
$no=0;
foreach($tender->result() as $tmp): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="center"><?php echo $this->irsdp_model->get_pinproj_for_tender($tmp->idproj);?></td>
	<td align="left"><?php echo $this->irsdp_model->get_namaproj_for_tender($tmp->idproj);?></td>
	<td align="left"><?php echo $tmp->deskripsi;?></td>
	<td align="center"><?php echo $tmp->tipe_tender;?></td>
	<td align="center"><?php echo $tmp->tgl_mulai;?></td>
	<td align="center"><?php echo $tmp->tgl_selesai;?></td>
	<td align="center"><?php echo $this->irsdp_model->get_user_by_id_for_tender($tmp->penanggung_jawab);?></td>
	<td align="center"><a href="<?php echo site_url('admin/detail_tender/'.$tmp->idtender_data);?>">Detail</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/modify_tender/'.$tmp->idtender_data);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_tender/'.$tmp->idtender_data);?>">Delete</a></td>
</tr>	
<?php endforeach;?>
<tr>
	<td colspan="9" align="center"><?php echo $paging;?></td>
</tr>
<?php }
else
{
?>
<tr>
	<td colspan="9" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<th colspan="9">&nbsp;</th>
</tr>

</table>