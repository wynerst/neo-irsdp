<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Project Flow/Steps --> Quick add/edit</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
/**
 *
 * Contoh penggunaan form
 *
 */

// file sysconfig sebaiknya berada di paling atas kode
require 'sysconfig.inc.php';

// masukan file library form
require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'form_maker'.DIRECTORY_SEPARATOR.'simbio_form_table_AJAX.inc.php';
//require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'form_maker'.DIRECTORY_SEPARATOR.'simbio_form_element.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_file_upload.inc.php';

// ini akan terjadi saat submit
if (isset($_POST['simpanData'])) {
    // cek validitas form
    $idproj_flow = trim($_POST['idproj_flow']);
    $idproject_profile= trim($_POST['idproject_profile']);
    if (empty($idproject_profile) or empty($idproj_flow)) {
        echo '<script type="text/javascript">alert(\'Data cerita dan project step tidak boleh kosong!\');</script>';
		die();
    }
	
	unset($data);

	$data['idproj_flow'] = $idproj_flow;
	$data['idproject_profile'] = $idproject_profile;
	$data['tgl_rencana'] = trim($_POST['tgl_rencana']);
	$data['status'] =  trim($_POST['status']);
	$data['kegiatan'] =  trim($_POST['kegiatan']);
	$data['idref_status'] = trim($_POST['idref_status']);
//	$data['idstatuskontrak'] = trim($_POST['idstatuskontrak']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->update('proj_flow', $data, 'idproj_flow='.$_POST['idproj_flow']);
    if ($insert) {
	    echo '<script type="text/javascript">alert(\'Data cerita diperbaiki!\');</script>';
	} else {
	    echo '<script type="text/javascript">alert(\'Error update.\');</script>';
	}
	
}

IF (isset($_GET['id'])) {
$query1 = $dbs->query('SELECT * FROM proj_flow WHERE idproj_flow='. $_GET['id']);
$default = $query1->fetch_assoc();

// buat instance objek form
$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

// atribut atribut tambahan
if (isset($_GET['add'])) {
	$form->submit_button_attr = 'name="tambahData" value="Cerita Baru" class="button"';
} else {
	$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
}
$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

// Link Informataion/data 
$table_spec = 'proj_flow as pf LEFT JOIN project_profile as pp ON pf.idproject_profile = pp.idproject_profile
	LEFT JOIN ref_status as rs ON pf.idref_status = rs.idref_status';
$setSQLColumn = 'pp.nama, rs.kode_status, rs.detil_status';
$setSQLCriteria = 'pf.idproj_flow =' . $default['idproj_flow'];
$ref_status = $dbs->query('SELECT ' . $setSQLColumn . ' FROM ' . $table_spec . ' WHERE ' . $setSQLCriteria . ' LIMIT 0,1');
while ($record = $ref_status->fetch_assoc()) {
	// proj name
	$form->addAnything('Project name', $record['nama']);
	//ref_status
	$form->addAnything('Tahapan proyek', $record['kode_status'] . ' - ' . $record['detil_status']);
}

// tgl_rencana
$form->addTextField('text', 'tgl_rencana', 'Tanggal Rencana', $default['tgl_rencana'], 'style="width: 20%;"');

// status
//$form->addTextField('text', 'status', 'Status Akhir', $default['status'], 'style="width: 80%;"');
//$form->addAnything('Status Akhir', $default['status']);
// tambahkan element form drop down list
$array_dropdown[] = array('done', 'Done');
$array_dropdown[] = array('on going', 'On Going');
$array_dropdown[] = array('pending', 'Pending');
$form->addSelectList('status', 'Status Akhir', $array_dropdown, $default['status']);

// follow_up
$form->addTextField('textarea', 'kegiatan', 'Milestone/Kegiatan', $default['kegiatan'], 'style="width: 90%;" rows="2"');

//hidden
	$form->addHidden('idproj_flow', $default['idproj_flow']);
	$form->addHidden('idproject_profile', $default['idproject_profile']);
	$form->addHidden('status', $default['status']);
	$form->addHidden('idref_status', $default['idref_status']);
	$form->addHidden('pic', $default['pic']);


} else {
echo 'Data proyek flow harus lengkap untuk editing...';
die();
}

// Menu Nav
?>
<p align="right">
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
<a href='milestone-list.php'>Project Summary/Milestone</a>&nbsp;&nbsp;|
</p>
<?php

echo "<p id='content'>";
echo $form->printOut();
echo "</p>";
?>
</body>
</html>