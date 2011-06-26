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

<h2>New Loan Input</h2>
<hr />

<?php echo form_open('admin/add_loan');?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Category</td>
	<td><input type="text" class="small3" name="kategori" />&nbsp;<i>example: <b>A1</b></i></td>
</tr>
<tr>
	<td class="label">Alias Category</td>
	<td><input type="text" class="small3" name="category1" />&nbsp;<i>example: <b>1A</b> is alias for <b>A1</b></i></td>
</tr>
<tr>
	<td class="label">Information Loan</td>
	<td><input type="text" class="long3" name="catatan" /></td>
</tr>
<tr>
	<td class="label">Loan Grant</td>
	<td><input type="text" class="small" name="loan_grand" /></td>
</tr>
<tr>
	<td class="label">Loan</td>
	<td><input type="text" class="small" name="loan" />&nbsp;<i>(optional)</i></td>
</tr>
<tr>
	<td class="label">Grant</td>
	<td><input type="text" class="small" name="grand" />&nbsp;<i>(optional)</i></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Loan" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
<?php echo form_close();?>