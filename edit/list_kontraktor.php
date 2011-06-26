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

   /* TOPIC LIST */
    // table spec
    $table_spec = 'kontraktor AS k LEFT JOIN project_profile AS p ON k.idproject_profile=p.idproject_profile LEFT JOIN perusahaan AS c ON k.idperusahaan = c.idperusahaan';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('p.pin AS \'PIN\'',
		'p.nama AS \'Proyek\'',
		'c.nama AS \'Perusahaan\'',
		'k.tahapan AS \'Tender\'',
		'concat("<a href=\'edit_k.php?id=", k.idkontraktor, "\'>Kontraktor</a>") AS Edit');

	$datagrid->setSQLorder('p.pin ASC, k.tahapan ASC');

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20);

// Menu Nav
?>
<p align="right">
<a href='tabel2.php'>Report</a>&nbsp;&nbsp;|
<a href='new-proj.php'>New Project</a>&nbsp;&nbsp;|
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
<a href='kontraktor.php'>New Contractor</a>&nbsp;&nbsp;|
<a href='list_kontraktor.php'>Contractor List</a>&nbsp;&nbsp;|
</p>
<?php

    echo $datagrid_result;
?>
</body>
</html>