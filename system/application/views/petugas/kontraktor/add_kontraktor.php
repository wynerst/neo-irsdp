<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.4.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.accordion.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.jeditable.mini.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.autogrow.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.jeditable.autogrow.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<script>
$(document).ready(function() 
{
	$("#tgl_mulai, #tgl_selesai, #pcss_date, #tgl_disetujui").datepicker(
	{
		dateFormat: 'yy-mm-dd'
	});
	
	for(i=1;i<9999999;i++)
	{
		$("#tgl_"+i).datepicker({dateFormat: 'yy-mm-dd'});
	}
});
</script>

<script type="text/javascript">
$(function(){
	// start a counter for new row IDs
	// by setting it to the number
	// of existing rows
	var newRowNum = 1;

	// bind a click event to the "Add" link
	$('#addnew').click(function(){
		// increment the counter
		newRowNum += 1;
		
		$('#row_count').val(newRowNum);
						
		// get the entire "Add" row --
		// "this" refers to the clicked element
		// and "parent" moves the selection up
		// to the parent node in the DOM
		var addRow = $(this).parent().parent();
		
		// copy the entire row from the DOM
		// with "clone"
		var newRow = addRow.clone();
		
		// set the values of the inputs
		// in the "Add" row to empty strings
		$('input', addRow).val('');
		
		// replace the HTML for the "Add" link 
		// with the new row number
		$('td:first-child', newRow).html("");
		//$('td:first-child', newRow).html(newRowNum);
		
		// insert a remove link in the last cell
		//$('td:last-child', newRow).html('<a href="" class="remove">Hapus<\/a>');
		
		// loop through the inputs in the new row
		// and update the ID and name attributes
		$('input, select', newRow).each(function(i){
			var newID = newRowNum + '_' + i;
			$(this).attr('id',newID).attr('name',newID);
		});
		
		// insert the new row into the table
		// "before" the Add row
		addRow.before(newRow);
		
		// add the remove function to the new row
		$('a.remove', newRow).click(function(){
			$(this).parent().parent().remove();
			newRowNum-=1;
			return false;				
		});
	
		// prevent the default click
		return false;
	});
});
</script>



<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Choose Contractor</h2>
<hr />

<?php

$form_dest = 'petugas/add_kontraktor';
            
// edit mode

if(isset($kontraktor))
{
	$form_dest .= '/'.$kontraktor->row('idkontraktor');
	$idproject_profile['value'] = $kontraktor->row('idproject_profile');
	$idperusahaan['value'] = $kontraktor->row('idperusahaan');
	$tgl_mulai['value'] = $kontraktor->row('tgl_mulai');
	$tgl_selesai['value'] = $kontraktor->row('tgl_selesai');
	$tahapan['value'] = $kontraktor->row('tahapan');
	$catatan['value'] = $kontraktor->row('catatan');
	$pcss_no['value'] = $kontraktor->row('pcss_no');
	$pcss_date['value'] = $kontraktor->row('pcss_date');
	$no_kontrak['value']= $kontraktor->row('no_kontrak');
	$tgl_disetujui['value']= $kontraktor->row('tgl_disetujui');	
	$anggaran_total_usd['value']= $kontraktor->row('anggaran_total_usd');	
	$anggaran_usd['value']= $kontraktor->row('anggaran_usd');	
	$anggaran_idr['value']= $kontraktor->row('anggaran_idr');	
}                         
?>

<form action="<?php echo site_url($form_dest);?>" method="get">
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Project Name</td>
	<td><select name="idproject_profile">
	<option value="">-- select project --</option>
	<?php 
		$this->db->orderby('pin');
		$query = $this->db->get('project_profile');
		$no=1;
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idproject_profile." >&nbsp;".$no++.".&nbsp;[".$row->pin."] - ".$row->nama."</option>";
		}
	?></select></td>
</tr>
<tr>
	<td class="label">Choosen Consultant</td>
	<td><select name="idperusahaan">
	<option value="">-- select consultant --</option>
	<?php 
		$this->db->orderby('idperusahaan');
		$query = $this->db->get('perusahaan');
		$no=1;
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idperusahaan." >&nbsp;".$no++.".&nbsp;".$row->nama."</option>";
		}
	?></select></td>
</tr>
<tr>
	<td class="label">Start Date</td>
	<td><input type="text" name="tgl_mulai" id="tgl_mulai" class="small2"/></td>
</tr>
<tr>
	<td class="label">End Date</td>
	<td><input type="text" name="tgl_selesai" id="tgl_selesai" class="small2" /></td>
</tr>
<tr>
	<td class="label" valign="top">Tender Phase</td>
	<td><input type="radio" name="tahapan" value="PraFS"  />PraFS<br />
	<input type="radio" name="tahapan" value="Transaction"  />Transaction<br />
	<input type="radio" name="tahapan" value="Investor"  />Investor<br />
	<input type="radio" name="tahapan" value=""  />Other Projects</td>
</tr>
<tr>
	<td class="label" valign="top">PCSS Number:</td>
	<td><input type="text" name="pcss_no" class="small"  /></td>
</tr>
<tr>
	<td class="label" valign="top">PCSS Date:</td>
	<td><input type="text" name="pcss_date" id="pcss_date" class="small2" /></td>
</tr>
<tr>
	<td class="label" valign="top">Contract Number:</td>
	<td><input type="text" name="no_kontrak" class="small"  /></td>
</tr>
<tr>
	<td class="label">Contract Approved Date</td>
	<td><input type="text" name="tgl_disetujui" id="tgl_disetujui" class="small2" /></td>
</tr>
<tr>
	<td class="label">Contract Budget (US$)</td>
	<td><input type="text" name="anggaran_usd" class="small" />&nbsp;US$</td>
</tr>
<tr>
	<td class="label">Contract Budget (IDR)</td>
	<td><input type="text" name="anggaran_idr" class="small" />&nbsp;IDR</td>
</tr>
<tr>
	<td class="label">Total Contract Budget (US$)</td>
	<td><input type="text" name="anggaran_total_usd" class="small" />&nbsp;US$</td>
</tr>
<tr>
	<td class="label" valign="top">Memo for Activity</td>
	<td><textarea name="catatan" class="longtext" wrap="soft" maxlength="100000"></textarea></td>
</tr>

<tr>
	<td class="label" valign="top">Step of Contract Payment</td>
	<td>
			<input type="hidden" name="row_count" id="row_count" value="1" />
			<table id="tabdata" width="100%" class="nicetable">
				<thead>
					<tr>
						<th colspan="2">Contract Flow</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="120px"><a id="addnew" href="#">Add Payment</a></td>
						<td>Payment Label&nbsp;<input id="1_0" name="1_0" type="text" style="width:200px" />&nbsp;&nbsp;Payment Date&nbsp;<input id="tgl" name="tgl" type="text" style="width:100px" /></td>
					</tr>
				</tbody>
			</table>
	</td>
</tr>

<?php
if(isset($kontraktor)) echo form_hidden('idkontraktor', $kontraktor->row('idkontraktor'));
?>

<tr>
	<th colspan="2">
	<input type="submit" value="Choose Contractor" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
</form>