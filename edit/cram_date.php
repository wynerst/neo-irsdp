<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>TGL step selesai --> Quick add/edit</title>
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


$messages = "";
if (isset($_POST['find']) AND !empty($_POST['find'])) {
	$cari = $_POST['find'];
}
if (isset($_GET['find']) AND !empty($_GET['find'])) {
	$cari = $_GET['find'];
}

if (isset($_GET['proj'])) {
	$projid = $_GET['proj'];
} elseif (isset($_POST['proj'])) {
	$projid = $_POST['proj'];
}

// ini akan terjadi saat submit
if (isset($_POST['simpanData'])) {
    // cek validitas form
    $idstatusproject = trim($_POST['idstatusproject']);
    $tgl_akhir= trim($_POST['tgl_akhir']);
    if (empty($idstatusproject) or empty($tgl_akhir) or $tgl_akhir == '0000-00-00') {
        echo '<script type="text/javascript">alert(\'Data alur dan tahapan proyek tidak boleh kosong!\');</script>';
		die();
    }
	
	unset($data);

	$data['idstatusproject'] = $idstatusproject;
	$data['tgl_mulai'] = trim($_POST['tgl_mulai']);
	$data['tgl_akhir'] = trim($_POST['tgl_akhir']);
	$data['status_akhir'] =  trim($_POST['status_akhir']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->update('ref_status_project_profile', $data, 'idstatusproject='. $idstatusproject);
    if ($insert) {
	    $messages= '<script type="text/javascript">alert(\'Data cerita diperbaiki!\');</script>';
	} else {
	    $messages= '<script type="text/javascript">alert(\'Error update.\');</script>';
	}
	
}

IF (isset($_GET['id'])) {
	$query1 = $dbs->query('SELECT * FROM ref_status_project_profile WHERE idstatusproject='. $_GET['id']);
	$default = $query1->fetch_assoc();

	// buat instance objek form
	$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

	// atribut atribut tambahan
	if (isset($_GET['add'])) {
		$form->submit_button_attr = 'name="tambahData" value="Data Baru" class="button"';
	} else {
		$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
	}
	
	$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
	$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
	$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
	$form->table_content_attr = 'class="alterCell2"';

	// Link Informataion/data 
	$table_spec = 'proj_flow_status as pfs LEFT JOIN proj_flow as pf ON pfs.idproj_flow = pf.idproj_flow
		LEFT JOIN project_profile as pp ON pf.idproject_profile = pp.idproject_profile
		LEFT JOIN ref_status as rs ON pf.idref_status = rs.idref_status';
	$setSQLColumn = 'pp.nama, rs.kode_status, rs.detil_status';

	$setSQLCriteria = 'pfs.idproj_flow_status =' . $default['idstatusproject'];
	$ref_status = $dbs->query('SELECT ' . $setSQLColumn . ' FROM ' . $table_spec . ' WHERE ' . $setSQLCriteria . ' LIMIT 0,1');
//	die('SELECT ' . $setSQLColumn . ' FROM ' . $table_spec . ' WHERE ' . $setSQLCriteria . ' LIMIT 0,1');
	while ($record = $ref_status->fetch_assoc()) {
		// proj name
		$form->addAnything('Project name', $record['nama']);
		//ref_status
		$form->addAnything('Tahapan proyek', $record['kode_status'] . ' - ' . $record['detil_status']);
	}

	// idpic
	$pic = $dbs->query('SELECT * FROM pic WHERE idpic='.$default['idoperator']);
	while ($record = $pic->fetch_assoc()) {
		$form->addAnything('Login Petugas', $record['nama']);
	}

	// status
	$form->addTextField('text', 'status_akhir', 'Kondisi/Status cerita', $default['status_akhir'], 'style="width: 80%;"');

	// mulai
	$form->addDateField('tgl_mulai', 'Tanggal Mulai', $default['tgl_mulai']);
	//akhir
	$form->addDateField('tgl_akhir', 'Tanggal Selesai', $default['tgl_akhir']);

	//hidden
		$form->addHidden('idstatusproject', $default['idstatusproject']);

	$messages = $form->printOut();

} elseif (isset($_GET['del']) AND ( ! empty($_GET['del']))) {
	$del_id = $_GET['del'];
    // lakukan pemrosesan data tabel
	$sql_op = new simbio_dbop($dbs);
	$delete = $sql_op->update('ref_status_project_profile', 'idstatusproject='.$del_id);
    if ($delete) {
	    $messages= '<script type="text/javascript">alert(\'Data proyek flow dihapus!\');</script>';
	} else {
	    $messages= '<script type="text/javascript">alert(\'Error delete.\');</script>';
	}
	
} else {
	$message = 'Data proyek flow harus lengkap untuk editing...';
	//die();
}

// Menu Nav
?>
<p align="right">
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
<a href='cram_date.php'>Acheive Date</a>&nbsp;&nbsp;|
<span align='right'><form method='get'>
<input type='text' name='find'>
<input type='submit' value='Search'>
</form></span>
</p>
<?php

   /* Cerita/Milestone -  LIST */
    // table spec
	$table_spec = 'ref_status_project_profile AS rsp LEFT JOIN project_profile AS pp ON pp.idproject_profile = rsp.idproject_profile
		LEFT JOIN proj_flow AS pf ON pf.idproj_flow=rsp.idref_status
		LEFT JOIN ref_status AS rs ON rs.idref_status=pf.idref_status';

    // create datagrid
    $datagrid = new simbio_datagrid();
//    $datagrid->setSQLColumn('pp.nama, rs.kode_status, rsp.*,
//	concat("<a target=\"blank\" href=\"cram_date.php?id=", rsp.idstatusproject, "\"><i>edit</i></a>&nbsp|&nbsp", 
//	"<a target=\"blank\" href=\"cram_date.php?id=", rsp.idstatusproject, "&add=1\"><i>add</i></a>&nbsp|&nbsp",
//	"<a target=\"blank\" href=\"cram_date.php?del=", rsp.idstatusproject, "\"><i>DEL</i></a>")
//	as Tanggal_selesai');
    $datagrid->setSQLColumn('pp.nama as Proyek, rs.kode_status, rsp.*,
	concat("<a target=\"blank\" href=\"cram_date.php?id=", rsp.idstatusproject, "\"><i>edit</i></a>&nbsp|&nbsp", 
	"<a target=\"blank\" href=\"cram_date.php?del=", rsp.idstatusproject, "\"><i>DEL</i></a>")
	as Tanggal_selesai');
	if (isset($cari)) {
		$datagrid->setSQLCriteria('pp.nama like "%'. $cari . '%"' );
	}
	$datagrid->setSQLorder('rsp.tgl_akhir ASC');

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20);

echo "<p id='content'>";
echo $messages;
echo $datagrid_result;
echo "</p>";
?>
</body>
</html>