<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>Group Management</h2>
<hr />
<?php echo form_open('admin/list_group');?>
<div style="float: left">
	Search Group&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_group');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add Group</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="20px">No</th>
	<th width="400px">Group Name</th>
	<th width="200px">Group Member</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($group->num_rows()>0)
{
$no=0;
foreach($group->result() as $row): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">			
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="center"><?php echo $row->group;?></td>
	<td align="center"><?php if($this->irsdp_model->count_group_member($row->idgroup) > 0) 
								echo "<strong>".$this->irsdp_model->count_group_member($row->idgroup)."</strong>&nbsp;members";
							 else
								echo "<i>no member</i>";?></td>
	<td align="center">
		<a href="<?php echo site_url('admin/edit_group/'.$row->idgroup);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_group/'.$row->idgroup);?>">Delete</a>
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