<div class="lightbox">
	<h2><?php echo $proyek->row('nama');?></h2>
	
	<div class="properties">
		<table width="100%">
			<tr>
				<td class="table_label">PIN/PPP Book Code</td>
				<td width="10px">:</td>
				<td>
					<?php echo ($proyek->row('pin')=="")? "- ":$proyek->row('pin');
					echo '/';
					echo ($proyek->row('ppp_book_code')=="")? " -":$proyek->row('ppp_book_code');
					?>
				</td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Project Type</td>
				<td width="10px">:</td>
				<td><?php echo ($proyek->row('tipe_proyek')==1)? "Unsolicited":"Solicited";?></td>				
			</tr>		
			<tr>
				<td class="table_label">Date Proposed</td>
				<td width="10px">:</td>
				<td><?php echo nice_date($proyek->row('tgl_usulan'));?></td>
				<td width="20%">&nbsp;</td>
				<td class="table_label">Date Entry</td>
				<td width="10px">:</td>
				<td><?php echo nice_date($proyek->row('tgl_diisi'));?></td>
			</tr>		
			<tr>
				<td class="table_label">Proposing Agency</td>
				<td width="10px">:</td>
				<td><?php echo $proyek->row('usulan_lpd');?></td>
				<td>&nbsp;</td>
				<td class="table_label">Project Location</td>
				<td width="10px">:</td>
				<td><?php echo $proyek->row('lokasi');?></td>
			</tr>
		</table>
	</div>	
</div>

<?php echo form_open($this->uri->uri_string());?>
<table class="nicetable">
<tr>
	<th colspan="2">Input Project Info</th>
</tr>

<?php foreach($proyek->result() as $tmp):?>
<tr>
	<td class="label"><?php echo $tmp->label;?></td>
	<td><input class="long2" type="text" name="<?php echo $tmp->tag;?>" value="<?php echo $tmp->value; ?>" /></td>
</tr>
<?php endforeach;?>
<tr>
	<th colspan="2">
	<input type="submit" value="Save Changes" />
	&nbsp;
	<input type="button" onclick="location.href='<?php echo site_url('petugas/detil_proyek').'/'.$this->uri->segment(3);?>'" value="Cancel" />
	</th>
</tr>
</table>
<?php echo form_close();?>