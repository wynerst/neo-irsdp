<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<?php
$form_dest = 'admin/modify_sektor';
$sectorCode = array(
              'name'        => 'sectorCode',
              'class'   	=> 'small3',
              'value'       => set_value('sectorCode')             
            );
            
$sectorName = array(
              'name'        => 'sectorName',
              'class'   	=> 'medium',
              'value'       => set_value('sectorName')             
            );        
            
$subsectorname = array(
              'name'        => 'subsectorname',
              'class'   	=> 'medium',
              'value'       => set_value('subsectorname')             
            );   

// edit mode
if(isset($sektor))
{
	$form_dest .= '/'.$sektor->row('idkategori');
	$sectorCode['value'] = $sektor->row('sectorCode');
	$sectorName['value'] = $sektor->row('sectorName');
	$subsectorname['value'] = $sektor->row('subsectorname');
}                         
?>
<h2>Modify Sector Data</h2>
<hr />
<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>

<tr>
	<td class="label">Sector Code</td>
	<td><?php echo form_input($sectorCode);?></td>
</tr>

<tr>
	<td class="label">Sector Name</td>
	<td><?php echo form_input($sectorName);?></td>
</tr>

<tr>
	<td class="label">Sub Sector Name</td>
	<td><?php echo form_input($subsectorname);?></td>
</tr>

<?php
if(isset($sektor)) echo form_hidden('idkategori', $sektor->row('idkategori'));
?>

<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_sektor');?>'" value="Cancel" />
	</th>
</tr>

</table>
<?php echo form_close();?>