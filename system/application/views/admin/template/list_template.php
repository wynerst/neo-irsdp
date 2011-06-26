<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>Project Templates</h2>
<hr />
<?php echo form_open('admin/list_template');?>
<div style="float: left">
	Search Template&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_template');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add Template Info</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="20px">No</th>
	<th width="200px">Project Sector Category</th>
	<th width="60px">Tag Code</th>
	<th width="400px">Tag Label Information</th>
	<th>&nbsp;</th>
</tr>

<?php if($template->num_rows()>0)
{ 
$no=0; ?>
<?php foreach($template->result() as $tmp):?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">	
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="left"><?php echo $this->irsdp_model->get_namakategori($tmp->idcategory);?></td>
	<td align="center">&nbsp;<?php echo $this->irsdp_model->get_tagcode($tmp->tag);?></td>
	<td align="left">&nbsp;<?php echo $this->irsdp_model->get_tagname($tmp->tag);?></td>
	<td align="center"><a href="<?php echo site_url('admin/modify_template/'.$tmp->idtemplate);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_template/'.$tmp->idtemplate);?>">Delete</a></td>
</tr>
<?php endforeach;?>
<tr>
	<td colspan="5" align="center"><?php echo $paging;?></td>
</tr>
<?php }
else
{
?>
<tr>
	<td colspan="4" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<th colspan="5">&nbsp;</th>
</tr>

</table>