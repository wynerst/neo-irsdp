<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Project Summary/Problems/Stories - Quick add/edit</title>
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

if (isset($_GET['id'])) {
	$projid = "=" . $_GET['id'];
} else {
	$projid = " IS NOT NULL";
}

   /* Cerita/Milestone -  LIST */
    // table spec
	$table_spec = 'cerita as c LEFT JOIN proj_flow_status as pfs ON c.idproj_flow = pfs.idproj_flow_status
	LEFT JOIN proj_flow as pf ON pfs.idproj_flow = pf.idproj_flow
	LEFT JOIN project_profile as pp ON pf.idproject_profile = pp.idproject_profile
	LEFT JOIN ref_status as rs ON pf.idref_status = rs.idref_status
	LEFT JOIN pic as u ON c.idpic = u.idpic';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('pp.pin, pp.nama, c.tgl_cerita, c.deskripsi, c.follow_up, u.nama,
	concat("<a target=\"blank\" href=\"cerita_edit.php?id=", c.idcerita, "\"><i>edit</i></a>&nbsp|&nbsp", 
	"<a target=\"blank\" href=\"cerita_edit.php?id=", c.idcerita, "&add=1\"><i>add</i></a>&nbsp|&nbsp",
	"<a target=\"blank\" href=\"cerita_edit.php?del=", c.idcerita, "\"><i>DEL</i></a>")
	as Deskripsi_Cerita,
	concat("<a target=\"blank\" href=\"pflowstat_edit.php?id=", c.idcerita, "\"><i>", pfs.status, "</i></a>") as kondisi, 
	rs.kode_status as step_code, pf.kegiatan, 
	concat("<a target=\"blank\" href=\"proflow_edit.php?id=", pf.idproj_flow, "\"><i>", pf.tgl_rencana, "</i></a>") as tgl_rencana,
	pf.status as status_akhir');
	$datagrid->setSQLCriteria('pf.idproject_profile'. $projid);
	$datagrid->setSQLorder('pp.pin ASC, rs.kode_status ASC, c.tgl_cerita DESC');

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