<div class="sub_menu_container">
<ul id="nav">
	<li><a href="<?php echo site_url()."/admin/admin_dashboard";?>">Dashboard</a></li>
	<li><a href="<?php echo site_url()."/admin/daftar_proyek";?>">Project Info</a>
		<ul>
			<li><a href="<?php echo site_url()."/admin/daftar_proyek";?>"><img src="<?php echo $this->config->item('icon_path')."report.png";?>" />&nbsp;&nbsp;Detail Project</a></li>
			<li><a href="<?php echo site_url()."/admin/list_tag";?>"><img src="<?php echo $this->config->item('icon_path')."flag_red.png";?>" />&nbsp;&nbsp;Info Tag</a></li>
			<li><a href="<?php echo site_url()."/admin/list_template";?>"><img src="<?php echo $this->config->item('icon_path')."plugin.png";?>" />&nbsp;&nbsp;Project Template</a></li>
		</ul>
	</li>
	<li><a href="<?php echo site_url()."/admin/list_tender"?>">Tender</a>
		<ul>
			<li><a href="<?php echo site_url()."/admin/list_tender";?>"><img src="<?php echo $this->config->item('icon_path')."script.png";?>" />&nbsp;&nbsp;Tender List</a></li>
			<li><a href="<?php echo site_url()."/admin/list_konsultan";?>"><img src="<?php echo $this->config->item('icon_path')."user_red.png";?>" />&nbsp;&nbsp;Consultant List</a></li>
			<li><a href="<?php echo site_url()."/admin/list_kontraktor";?>"><img src="<?php echo $this->config->item('icon_path')."award_star_gold_3.png";?>" />&nbsp;&nbsp;Contractor</a></li>
		</ul>
	</li>
	<li><a href="<?php echo site_url()."/admin/list_user"?>">User Management</a>
		<ul>
			<li><a href="<?php echo site_url()."/admin/list_user";?>"><img src="<?php echo $this->config->item('icon_path')."user.png";?>" />&nbsp;&nbsp;User List</a></li>
			<li><a href="<?php echo site_url()."/admin/list_group";?>"><img src="<?php echo $this->config->item('icon_path')."group.png";?>" />&nbsp;&nbsp;Group List</a></li>
		</ul>
	</li>
	<li><a href="<?php echo site_url()."/admin/list_sector"?>">Master List</a>
		<ul>
			<li><a href="<?php echo site_url()."/admin/list_provinsi";?>"><img src="<?php echo $this->config->item('icon_path')."world.png";?>" />&nbsp;&nbsp;Province List</a></li>
			<li><a href="<?php echo site_url()."/admin/list_kabupaten";?>"><img src="<?php echo $this->config->item('icon_path')."map.png";?>" />&nbsp;&nbsp;City List</a></li>
			<li><a href="<?php echo site_url()."/admin/list_sector";?>"><img src="<?php echo $this->config->item('icon_path')."timeline_marker.png";?>" />&nbsp;&nbsp;Project Sector</a></li>
			<li><a href="<?php echo site_url()."/admin/siklus_proyek";?>"><img src="<?php echo $this->config->item('icon_path')."bricks.png";?>" />&nbsp;&nbsp;Project Cycle</a></li>
			<li><a href="<?php echo site_url()."/admin/list_loan";?>"><img src="<?php echo $this->config->item('icon_path')."hourglass.png";?>" />&nbsp;&nbsp;Loan List</a></li>
		</ul>
	</li>
</ul>
</div>

<?php $this->load->view($main);?>