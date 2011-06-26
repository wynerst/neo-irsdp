<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.2.min.js"></script>

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

<div class="lightbox">
	<h2><?php echo $detil->row('nama');?></h2>
	
	<div class="properties">
		<table width="100%">
			<tr>
				<td class="table_label">PIN/PPP Book Code:</td>
				<td>
					<?php echo ($detil->row('pin')=="")? "- ":$detil->row('pin');
					echo '/';
					echo ($detil->row('ppp_book_code')=="")? " -":$detil->row('ppp_book_code');
					?>
				</td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Project Type:</td>
				<td><?php echo ($detil->row('tipe_proyek')==1)? "Solicited":"Unsolicited";?></td>				
			</tr>		
			<tr>
				<td class="table_label">Sector:</td>
				<td><?php echo $detil->row('subsectorname');?></td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Entry Date:</td>
				<td><?php echo nice_date($detil->row('tgl_diisi'));?></td>
			</tr>		
			<tr>
				<td class="table_label">Proposed Agency:</td>
				<td><?php echo $detil->row('usulan_lpd');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location:</td>
				<td><?php echo $detil->row('lokasi');?></td>
			</tr>
		</table>
	</div>	
</div>

<?php echo form_open($this->uri->uri_string());?>
<input type="hidden" name="row_count" id="row_count" value="1" />
<table id="tabdata" width="100%" class="nicetable">
	<thead>
		<tr>
			<th colspan="4">Contract Value for <?php echo $detil->row('detil_status');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><a id="addnew" href="#">Add</a></td>
			<td><label>Rupiah</label> <input id="1_0" name="1_0" type="text" value="0" /></td>
			<td><label>IDR Equivalent</label> <input id="1_2" name="1_2" type="text" value="0" /></td>
			<td><label>Dollar</label> <input id="1_1" name="1_1" type="text" value="0" /></td>
		</tr>
	</tbody>
</table>

<div align="center">
	<input type="hidden" name="idproject_profile" value="<?php echo $detil->row('idproject_profile');?>" />
	<input type="hidden" name="idref_kontrak" value="<?php echo $detil->row('idkontrak_flow');?>" />
	<input type="submit" name="submit_step" value="Submit" />
</div>

<?php echo form_close();?>