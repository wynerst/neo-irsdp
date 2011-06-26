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
    $table_spec = 'project_profile AS p
LEFT JOIN kontraktor AS kons ON p.idproject_profile = kons.idproject_profile
LEFT JOIN proj_flow AS pf ON p.idproject_profile = pf.idproject_profile
LEFT JOIN kontrak_flow AS kf ON pf.idproj_flow = kf.idproj_flow
LEFT JOIN perusahaan AS prs ON kons.idperusahaan = prs.idperusahaan
LEFT JOIN termin_bayar AS tb ON kf.idkontrak_flow = tb.kontrakflow_id
LEFT JOIN permohonan AS per ON tb.idtermin_bayar = per.idtermin_bayar';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('SUBSTR( p.pin, 1, 2 ) AS \'PART\', p.pin, p.nama, prs.nama AS \'Consultant Firm\',
	SUM( tb.nilai_rupiah ) AS \'Contract_IDR\', SUM( tb.nilai_dollar ) AS \'Contract_USD\',
	SUM( tb.nilai_total_dollar ) AS \'USD Equiv\', SUM( per.nilai_disetujui_rupiah ) AS \'Appr_IDR\',
	SUM( per.nilai_disetujui_dollar ) AS \'Appr_USD\', SUM(per.total_disetujui_dollar)/SUM(tb.nilai_total_dollar) AS \'%\', kf.status');

	$datagrid->setSQLgroup('SUBSTR(p.pin,1,2), p.pin, p.nama');
	$datagrid->setSQLorder('p.pin ASC, p.nama ASC, per.tgl_permohonan DESC');

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20);

// Menu Nav
?>
<p align="right">
<a href='list.php'>Edit data</a>&nbsp;&nbsp;|
<a href='tabel2.php'>Tabel 2</a>&nbsp;&nbsp;|
<a href='tabel3.php'>Tabel 3</a>&nbsp;&nbsp;|
<a href='tabel4.php'>Tabel 4</a>&nbsp;&nbsp;|
<a href='tabel5.php'>Form D.</a>&nbsp;&nbsp;|
</p>
<?php

    echo $datagrid_result;
?>
</body>
</html>