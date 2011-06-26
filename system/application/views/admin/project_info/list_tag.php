<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>Project Information Tagging</h2>
<hr />
<?php echo form_open('admin/list_tag');?>
<div style="float: left">
	Search Tag&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_tag');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add New Tag</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="20px">No</th>
	<th width="100px">Tag</th>
	<th width="600px">Label</th>
	<th>&nbsp;</th>
</tr>

<?php if($tag->num_rows()>0)
{
$no=0; ?>
<?php foreach($tag->result() as $tmp):?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">	
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="center"><?php echo $tmp->tag;?></td>
	<td align="left">&nbsp;<?php echo $tmp->label;?></td>
	<td align="center"><a href="<?php echo site_url('admin/modify_tag/'.$tmp->iddaftar_ruas);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_tag/'.$tmp->iddaftar_ruas);?>">Delete</a></td>
</tr>
<?php endforeach;?>
<tr>
	<td colspan="4" align="center"><?php echo $paging;?></td>
</tr>
<?php }
else
{?>
<tr>
	<td colspan="4" align="center"><i>data not available</i></td>
</tr>
<?php }?>
<tr>
	<th colspan="4">&nbsp;</th>
</tr>

</table>