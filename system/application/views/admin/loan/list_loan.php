<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<h2>Loan Management</h2>
<hr />
<?php echo form_open('admin/list_loan');?>
<div style="float: left">
	Search Loan&nbsp;<input type="search_all2" name="keyword" /><input type="submit" id="tombolcari" name="submit" value="Search" />
</div>
<?php echo form_close();?>	
<div id="head-right">
	<ul>
		<li><a href="<?php echo site_url('admin/add_loan');?>"><img src="<?php echo $this->config->item('icon_path')."add.png";?>" />&nbsp;Add Loan</a></li>
	</ul>
</div>
<br /><br />

<table class="nicetable" border="0" cellpadding="0" cellspacing="0">
<tr>
	<th width="30px">No</th>
	<th width="50px">Category</th>	
	<th width="50px">Alias</th>	
	<th width="400px">Information</th>
	<th width="100px">Loan Grant</th>
	<th width="100px">Loan</th>
	<th width="100px">Grant</th>
	<th>&nbsp;</th>
</tr>

<?php 
if($loan->num_rows()>0)
{
$no=0;
foreach($loan->result() as $row): ?>
<tr class="<?php if($no%2==0) echo "nice-ganjil";
	else echo "nice-genap";?>">			
	<td align="center"><?php echo (++$no + $this->uri->segment(3));?></td>
	<td align="left"><?php echo $row->kategori;?></td>
	<td align="left"><?php echo $row->category1;?></td>
	<td align="left"><?php echo $row->catatan;?></td>
	<td align="right"><?php if($row->loan_grand) echo number_format($row->loan_grand,0,"",",");
											else echo "-";?></td>
	<td align="right"><?php if($row->loan) echo number_format($row->loan,0,"",",");
											else echo "-";?></td>
	<td align="right"><?php if($row->grand) echo number_format($row->grand,0,"",",");
										   else	echo "-";?></td>
	<td align="center">
		<a href="<?php echo site_url('admin/edit_loan/'.$row->idloan);?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo site_url('admin/hapus_loan/'.$row->idloan);?>">Delete</a>
	</td>
</tr>	
<?php endforeach;?>
<tr class="paging">
	<td colspan="8" align="center"><?php echo $paging; ?></td>
</tr>
<?php }
else
{
?>
<tr>
	<td colspan="8" align="center"><i>data not available</i></td>
</tr>
<?php }?>
<tr>
	<th colspan="8">&nbsp;</th>
</tr>
</table>