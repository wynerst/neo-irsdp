<script src="<?php echo $this->config->item('js_path');?>jquery-1.4.2.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.core.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.widget.min.js"></script>
<script src="<?php echo $this->config->item('js_path');?>jquery.ui.datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('css_path');?>jquery-ui/base/jquery.ui.all.css">

<script>
$(function() {
	$("#tgl_mulai").datepicker({
		dateFormat: 'yy-mm-dd',
	});
	$("#tgl_selesai").datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
</script>

<?php if(validation_errors()!=""):?>
	<div class="validation_error">
	<?php echo validation_errors(); ?>
	</div>
<?php endif;?>

<h2>Tender Registration</h2>
<hr />

<?php

$form_dest = 'admin/add_tender';            
$deskripsi = array(
              'name'        => 'deskripsi',
              'class'   	=> 'long2',
              'value'       => set_value('deskripsi')             
            );        
            
$tgl_mulai = array(
              'name'        => 'tgl_mulai',
			  'id'			=> 'tgl_mulai',
              'class'   	=> 'date',
              'value'       => set_value('tgl_mulai')             
            );

$tgl_selesai = array(
              'name'        => 'tgl_selesai',
			  'id'			=> 'tgl_selesai',
              'class'   	=> 'date',
              'value'       => set_value('tgl_selesai')             
            );

$tipe_tender = array(
              'name'        => 'tipe_tender',
              'class'   	=> 'small',
              'value'       => set_value('tipe_tender')             
            );     			
?>

<?php echo form_open($form_dest);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>

<tr>
	<td class="label">Project ID</td>
	<td><select name="idproj">
	<option value="">-- select project --</option>
	<?php
		$this->db->orderby('idproject_profile', 'asc');
		$query = $this->db->get('project_profile');
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idproject_profile.">&nbsp;".$row->idproject_profile.".&nbsp;".$row->nama."</option>";
				
		}
	?>
	</select></td>
</tr>

<tr>
	<td class="label">Description</td>
	<td><?php echo form_input($deskripsi);?></td>
</tr>

<tr>
	<td class="label">Start Date</td>
	<td><?php echo form_input($tgl_mulai);?></td>
</tr>

<tr>
	<td class="label">End Date</td>
	<td><?php echo form_input($tgl_selesai);?></td>
</tr>
<tr>
	<td class="label">Tender Type</td>
	<td><?php echo form_input($tipe_tender);?></td>
</tr>
<tr>
	<td class="label">PIC in Charge</td>
	<td><select name="penanggung_jawab">
	<option value="">-- select pic --</option>
	<?php
		$this->db->orderby('nama', 'desc');
		$query = $this->db->get('pic');
		foreach($query->result() as $row)
		{
			echo "<option value=".$row->idpic.">&nbsp;".$row->nama."</option>";
				
		}
	?>
	</select></td>
</tr>
<tr>
	<th colspan="2">
	<input type="submit" value="Register Tender" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
<?php echo form_close();?>