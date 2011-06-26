<?php if($this->session->flashdata('form_submit_status')!=""): ?>
	<div class="form_submit_status">
		<?php echo $this->session->flashdata('form_submit_status');?>
	</div>
<?php endif;?>

<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Edit Loan Data</h2>
<hr />

<?php
$form_dest = 'admin/edit_loan';
if(isset($user))
{
	$form_dest .= '/'.$user->row('idloan');
	$kategori['value'] = $user->row('kategori');
	$catatan['value'] = $user->row('catatan');
	$loan_grand['value'] = $user->row('loan_grand');
	$loan['value'] = $user->row('loan');
	$grand['value'] = $user->row('grand');
	$category1['value'] = $user->row('category1');
}                         
?>

<?php
foreach($loan->result() as $tmp)
{
?>

<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Loan Category</td>
	<td><input type="text" class="small3" name="kategori" value="<?php echo $tmp->kategori;?>" /></td>
</tr>
<tr>
	<td class="label">Information Loan</td>
	<td><input type="text" class="long3" name="catatan" value="<?php echo $tmp->catatan;?>" /></td>
</tr>
<tr>
	<td class="label">Loan Grand</td>
	<td><input type="text" class="small" name="loan_grand" value="<?php echo $tmp->loan_grand;?>" /></td>
</tr>
<tr>
	<td class="label">Loan</td>
	<td><input type="text" class="small" name="loan" value="<?php echo $tmp->loan;?>" /></td>
</tr>
<tr>
	<td class="label">Grand</td>
	<td><input type="text" class="small" name="grand" value="<?php echo $tmp->grand;?>" /></td>
</tr>
<tr>
	<td class="label">Category</td>
	<td><input type="text" class="small3" name="category1" value="<?php echo $tmp->category1;?>" /><input type="text" class="small3" style="display:none;" name="idloan" value="<?php echo $tmp->idloan;?>" /></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_loan');?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>
<?php } ?>