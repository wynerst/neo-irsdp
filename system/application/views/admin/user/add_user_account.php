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

<h2>New User Registration</h2>
<hr />

<?php echo form_open('admin/add_user_account/'.$id);?>
<table class="nicetable">
<tr>
	<th colspan="2"><?php echo $form_title;?></th>
</tr>
<tr>
	<td colspan="2" class="top-manage2"><a href="<?php echo site_url()."/admin/detail_konsultan/".$id; ?>"><img src="<?php echo $this->config->item('icon_path')."/arrow_left.png"; ?>" />&nbsp;Back</a></td>
</tr>
<?php if($this->irsdp_model->get_konsultan_pic($id) > 0):?>
	<tr>
		<td colspan="2"><i>this consultant has a username already, this action will commite to make a new username</i></td>
	</tr>
	<tr>
		<td colspan="2" class="top-manage"><a href=""><img src="<?php echo $this->config->item('icon_path')."/user_edit.png"; ?>" />&nbsp;edit the old PIC account for this consultant</a></td>
	</tr>
	
	<tr>
		<td class="label">Username</td>
		<td><input type="text" class="small" name="nama" /></td>
	</tr>
	<tr>
		<td class="label">Password</td>
		<td><input type="password" class="small" name="password" /></td>
	</tr>
	<tr>
		<td class="label">Retype Password</td>
		<td><input type="password" class="small" name="repassword" /></td>
	</tr>
	<tr>
		<td colspan="2"><i>this field below was taken from PIC user account data</i></td>
	</tr>
	<tr>
		<td class="label">Group</td>
		<td>konsultan<input type="text" class="small3" name="group" style="display:none" value="4" /></td>
	</tr>
	<tr>
		<td class="label">PIC for Consultant</td>
		<td><?php echo $nama; ?><input type="text" class="small3" name="idperusahaan" style="display:none" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "idperusahaan");?>" /></td>
	</tr>
	<tr>
		<td class="label">Email Address</td>
		<td><input type="text" class="long" name="email" value="<?php echo $this->irsdp_model->get_pic_properties($this->uri->segment(3), "email"); ?>" /></td>
	</tr>
	<tr>
		<td class="label"></td>
		<td>email address must valid, because this account data will be send to consultant with plaintext username and password.</td>
	</tr>
	<tr>
		<td class="label">Phone Number (Fixed)</td>
		<td><input type="text" class="small" name="phone" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "phone"); ?>" /></td>
	</tr>
	<tr>
		<td class="label">Handphone Number</td>
		<td><input type="text" class="small" name="hp" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "hp"); ?>" /></td>
	</tr>
	<tr>
		<td class="label">Fax Number</td>
		<td><input type="text" class="small" name="fax" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "fax"); ?>" /></td>
	</tr>
<?php //endif;
else:?>
	<tr>
		<td class="label">Username</td>
		<td><input type="text" class="small" name="nama" /></td>
	</tr>
	<tr>
		<td class="label">Password</td>
		<td><input type="password" class="small" name="password" /></td>
	</tr>
	<tr>
		<td class="label">Retype Password</td>
		<td><input type="password" class="small" name="repassword" /></td>
	</tr>
	<tr>
		<td colspan="2"><i>this field below was taken from consultant data</i></td>
	</tr>
	<tr>
		<td class="label">Group</td>
		<!--value=4 terlalu berbahaya jika id konsultan berubah!!! cek database saat deploy-->
		<td>konsultan<input type="text" class="small3" name="group" style="display:none" value="4" /></td>
	</tr>
	<tr>
		<td class="label">PIC for Consultant</td>
		<td><?php echo $nama; ?><input type="text" class="small3" name="idperusahaan" style="display:none" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "idperusahaan");?>" /></td>
	</tr>
	<tr>
		<td class="label">Email Address</td>
		<td><input type="text" class="long" name="email" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "email"); ?>" /></td>
	</tr>
	<tr>
		<td class="label">Phone Number (Fixed)</td>
		<td><input type="text" class="small" name="phone" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "phone"); ?>" /></td>
	</tr>
	<tr>
		<td class="label">Handphone Number</td>
		<td><input type="text" class="small" name="hp" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "hp"); ?>" /></td>
	</tr>
	<tr>
		<td class="label">Fax Number</td>
		<td><input type="text" class="small" name="fax" value="<?php echo $this->irsdp_model->get_konsultan_properties($this->uri->segment(3), "fax"); ?>" /></td>
	</tr>
<?php endif; ?>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Consultant User" />
	&nbsp;
	<input type="reset" value="Reset" />
	</th>
</tr>

</table>
<?php echo form_close();?>