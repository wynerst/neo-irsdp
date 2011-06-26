<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>User Management</h2>
<hr />
<?php echo form_open('admin/list_user');?>
<div style="float: left">
	Search User&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_user');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add User</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="20px">No</th>
	<th width="100px">Username</th>
	<th width="80px">Group</th>
	<th width="120px">Consultant PIC</th>
	<th width="200px">Email</th>
	<th width="100px">No. Fixed Phone</th>
	<th width="100px">Fax</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($user->num_rows()>0){
$no=0;
foreach($user->result() as $row): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">			
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="center"><?php echo $row->nama;?></td>
	<td align="center"><?php echo $this->irsdp_model->get_group_name($row->group);?></td>
	<td align="center"><?php echo $this->irsdp_model->get_consultant_name($row->idperusahaan);?></td>
	<td align="center"><?php echo $row->email;?></td>
	<td align="center"><?php echo $row->phone;?></td>
	<td align="center"><?php echo $row->fax;?></td>
	<td align="center">
		<a href="<?php echo site_url('admin/edit_user/'.$row->idpic);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_user/'.$row->idpic);?>">Delete</a>
	</td>
</tr>	
<?php endforeach;?>
<tr class="paging">
	<td colspan="8" align="center"><?php echo $paging; ?></td>
</tr>
<?php 
}
else
{ ?>
<tr>
	<td colspan="8" align="center"><i>data not available</i></td>
</tr>
<?php } ?>
<tr>
	<th colspan="8">&nbsp;</th>
</tr>
</table>