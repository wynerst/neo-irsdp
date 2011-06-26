<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Quick add/edit IRSDP</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
require 'sysconfig.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

if (isset($_POST['find']) AND !empty($_POST['find'])) {
	$cari = $_POST['find'];
}
if (isset($_GET['find']) AND !empty($_GET['find'])) {
	$cari = $_GET['find'];
}

   /* TOPIC LIST */
    // table spec
    $table_spec = 'project_profile AS p LEFT JOIN ref_status AS r ON p.last_idref_status = r.idref_status';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('p.pin AS \'PIN\'',
		'p.nama AS \'Proyek\'',
		'r.kode_status AS \'Status Akhir\'',
		'concat("<a href=\'newinfo.php?id=", p.idproject_profile, "&cat=", p.id_kategori, "\'>New</a> | <a href=\'info.php?id=", p.idproject_profile,"&cat=", p.id_kategori, "\'>InfoDetail</a>") AS \'Profile\',
		concat("<a href=\'update.php?id=", p.idproject_profile, "\'>Update</a>") AS \'Status\',
		concat("<a href=\'edit-proj.php?id=", p.idproject_profile, "\'>Proyek</a>&nbsp;|&nbsp;", 
		"<a href=\'milestone-list.php?id=", p.idproject_profile, "\'>Summary/Milestone</a>") AS Edit,
		concat("<a href=\'kontrak_tgl.php?id=", p.idproject_profile, "\'>Set TGL</a>&nbsp;|&nbsp;",
		"<a href=\'kontrak_monitor.php?id=", p.idproject_profile, "\'>Edit&nbsp;|&nbsp;</a>",
		"<a target=\'blank\' href=\'../index.php/petugas/adb_report_pac/", p.idproject_profile, "\'>Report</a>&nbsp;|") AS \'Kontrak Monitor\'');

	$datagrid->setSQLorder('p.nama ASC');
	if (isset($cari)) {
		$datagrid->setSQLCriteria('p.nama LIKE "%'.$cari.'%" OR p.pin LIKE "%'. $cari.'%"');
	}
	

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20);

// Menu Nav
?>
<p align="right">
<a href='adb_cram.php'>CRAM-Set tgl</a>&nbsp;&nbsp;|
<a href='tabel2.php'>Report</a>&nbsp;&nbsp;|
<a href='kontrak/kontrak_set.php'>Kontrak</a>&nbsp;&nbsp;|
<a href='new-proj.php'>New Project</a>&nbsp;&nbsp;|
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
<a href='kontraktor.php'>New Contractor</a>&nbsp;&nbsp;|
<a href='list_kontraktor.php'>Contractor List</a>&nbsp;
<span align='right'><form method='get'>
<input type='text' name='find'>
<input type='submit' value='Search'>
</form></span>
</p>
<?php

    echo $datagrid_result;
?>
</body>
</html>