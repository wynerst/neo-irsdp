<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Adding New Consultant</h2>
<hr />

<?php

$form_dest = 'admin/add_konsultan';
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
	<input type="radio" name="jenis" checked="checked" value="Company" />Company
	<input type="radio" name="jenis" value="Individu" />Individu
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
		<input type="radio" name="status" value="1" />Active
		<input type="radio" name="status" value="0" checked="checked" />Not Active
	</td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Data" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
<?php echo form_close();?>