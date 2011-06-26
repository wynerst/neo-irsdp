<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Modify Consultant Data</h2>
<hr />

<?php

$form_dest = 'admin/modify_konsultan';
$nama = array(
              'name'        => 'nama',
              'class'   	=> 'long',
              'value'       => set_value('nama')             
            );
            
$jenis = array(
              'name'        => 'jenis',
              'class'   	=> 'small',
              'value'       => set_value('deskripsi')             
            );        
            
$alamat = array(
              'name'        => 'alamat',
              'class'   	=> 'long3',
              'value'       => set_value('alamat')             
            );

$telpon = array(
              'name'        => 'telpon',
              'class'   	=> 'small',
              'value'       => set_value('telpon')             
            );

$fax = array(
              'name'        => 'fax',
              'class'   	=> 'small',
              'value'       => set_value('fax')             
            );

$hp = array(
              'name'        => 'hp',
              'class'   	=> 'small',
              'value'       => set_value('hp')             
            );

$email = array(
              'name'        => 'email',
              'class'   	=> 'medium',
              'value'       => set_value('email')             
            );
			
$website = array(
              'name'        => 'website',
              'class'   	=> 'medium',
              'value'       => set_value('website')
			);
			

// edit mode

if(isset($konsultan))
{
	$form_dest .= '/'.$konsultan->row('idperusahaan');
	$nama['value'] = $konsultan->row('nama');
	$jenis['value'] = $konsultan->row('jenis');
	$alamat['value'] = $konsultan->row('alamat');
	$telpon['value'] = $konsultan->row('telpon');
	$fax['value'] = $konsultan->row('fax');
	$hp['value'] = $konsultan->row('hp');
	$email['value'] = $konsultan->row('email');
	$website['value'] = $konsultan->row('website');
}                         
?>

<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td class="label">Name of Consultant (Company)</td>
	<td><?php echo form_input($nama);?></td>
</tr>
<tr>
	<td class="label">Consultant Type</td>
	<td>
	<input type="radio" name="jenis" <?php if($konsultan->row('jenis')=='Company') echo "checked=\"checked\"";?> value="Company" />Company
	<input type="radio" name="jenis" <?php if($konsultan->row('jenis')=='Individu') echo "checked=\"checked\"";?> value="Individu" />Individu
	</td>
</tr>
<tr>
	<td class="label">Address</td>
	<td><?php echo form_input($alamat);?></td>
</tr>
<tr>
	<td class="label">Fixed Phone</td>
	<td><?php echo form_input($telpon);?></td>
</tr>
<tr>
	<td class="label">Facsimile Number</td>
	<td><?php echo form_input($fax);?></td>
</tr>
<tr>
	<td class="label">Mobile Phone</td>
	<td><?php echo form_input($hp);?></td>
</tr>
<tr>
	<td class="label">Email Address</td>
	<td><?php echo form_input($email);?></td>
</tr>
<tr>
	<td class="label">Website</td>
	<td><?php echo form_input($website);?></td>
</tr>
<tr>
	<td class="label">Status</td>
	<td>
		<input type="radio" name="status" value="1" <?php if($konsultan->row('status')=='1') echo "checked=\"checked\"";?> />Active
		<input type="radio" name="status" value="0" <?php if($konsultan->row('status')=='0') echo "checked=\"checked\"";?> />Not Active
	</td>
</tr>
<?php
if(isset($konsultan)) echo form_hidden('idperusahaan', $konsultan->row('idperusahaan'));
?>

<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('admin/list_konsultan');?>'" value="Cancel" />
	</th>
</tr>

</table>
<?php echo form_close();?>