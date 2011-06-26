<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Status/Problem --> Quick add/edit</title>
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
$messages ="";
if (isset($_POST['simpanData'])) {
    // cek validitas form
    $idcerita = trim($_POST['idcerita']);
    $idproj_flow = trim($_POST['idproj_flow']);
    if (empty($idcerita) or empty($idproj_flow)) {
        echo '<script type="text/javascript">alert(\'Data cerita dan project step tidak boleh kosong!\');</script>';
		$messages ='<a href="milestone-list.php">Kembali ke daftar cerita</a>';
		die();
    }
	
	unset($data);

	$data['idcerita'] = $idcerita;
	$data['idproj_flow'] = $idproj_flow;
	$data['tgl_cerita'] = trim($_POST['tgl_cerita']);
	$data['deskripsi'] =  trim($_POST['deskripsi']);
	$data['follow_up'] =  trim($_POST['follow_up']);
//	$data['idpic'] = trim($_POST['idpic']);
//	$data['idstatuskontrak'] = trim($_POST['idstatuskontrak']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->update('cerita', $data, 'idcerita='.$_POST['idcerita']);
    if ($insert) {
	    echo '<script type="text/javascript">alert(\'Data cerita diperbaiki!\');</script>';
	    //echo '<script type="text/javascript">UpdateOk();</script>';
	    //echo '<script type="text/javascript">Msg(\'Sukses\');</script>';
		//header ("location: /senayan3-stable14");
		$messages ='<a href="milestone-list.php">Kembali ke daftar cerita</a>';
	} else {
	    echo '<script type="text/javascript">alert(\'Error update.\');</script>';
	    //echo '<script type="text/javascript">errUpdate('.$sql_op->error.');</script>';
	    //echo '<script type="text/javascript">Msg('.$sql_op->error.');</script>';
		$messages ='<a href="milestone-list.php">Kembali ke daftar cerita</a>';
	}
	
}

if (isset($_POST['tambahData'])) {
    // cek validitas form
    $idproj_flow = trim($_POST['idproj_flow']);
    if (empty($idproj_flow)) {
        echo '<script type="text/javascript">alert(\'Data cerita dan project step tidak boleh kosong!\');</script>';
		die();
    }
	
	unset($data);

	$data['idproj_flow'] = $idproj_flow;
	$data['tgl_cerita'] = trim($_POST['tgl_cerita']);
	$data['deskripsi'] =  trim($_POST['deskripsi']);
	$data['follow_up'] =  trim($_POST['follow_up']);
	$data['idpic'] = trim($_POST['idpic']);
	$data['idstatuskontrak'] = trim($_POST['idstatuskontrak']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->insert('cerita', $data);
    if ($insert) {
	    echo '<script type="text/javascript">alert(\'Data cerita ditambahkan!\');</script>';
		$messages ='<a href="milestone-list.php">Kembali ke daftar cerita</a>';
	} else {
	    echo '<script type="text/javascript">alert(\'Error Add.\');</script>';
		$messages ='<a href="milestone-list.php">Kembali ke daftar cerita</a>';
	}
	
}

IF (isset($_GET['id'])) {
	$query1 = $dbs->query('SELECT * FROM cerita WHERE idcerita='. $_GET['id']);
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

	// ref_status
	$table_spec = 'cerita as c LEFT JOIN proj_flow_status as pfs ON c.idproj_flow = pfs.idproj_flow_status
		LEFT JOIN proj_flow as pf ON pfs.idproj_flow = pf.idproj_flow
		LEFT JOIN project_profile as pp ON pf.idproject_profile = pp.idproject_profile
		LEFT JOIN ref_status as rs ON pf.idref_status = rs.idref_status
		LEFT JOIN pic as u ON c.idpic = u.idpic';
	$setSQLColumn = 'rs.kode_status, rs.detil_status';
	$setSQLCriteria = 'c.idcerita =' . $default['idcerita'];
	$ref_status = $dbs->query('SELECT ' . $setSQLColumn . ' FROM ' . $table_spec . ' WHERE ' . $setSQLCriteria . ' LIMIT 0,1');
	while ($record = $ref_status->fetch_assoc()) {
		$form->addAnything('Tahapan proyek', $record['kode_status'] . ' - ' . $record['detil_status']);
	}

	// idpic
	$pic = $dbs->query('SELECT * FROM pic WHERE idpic='.$default['idpic']);
	while ($record = $pic->fetch_assoc()) {
		$form->addAnything('Login Petugas', $record['nama']);
	}

	// tgl_cerita
	$form->addTextField('text', 'tgl_cerita', 'Tanggal', $default['tgl_cerita'], 'style="width: 20%;"');

	// deskripsi
	$form->addTextField('textarea', 'deskripsi', 'Description', $default['deskripsi'], 'style="width: 90%;" rows="3"');

	// follow_up
	$form->addTextField('textarea', 'follow_up', 'Follow Up', $default['follow_up'], 'style="width: 90%;" rows="2"');

	//hidden
		$form->addHidden('idcerita', $default['idcerita']);
		$form->addHidden('idproj_flow', $default['idproj_flow']);
		$form->addHidden('idstatuskontrak', $default['idstatuskontrak']);
		$form->addHidden('idpic', $default['idpic']);

	$messages = $form->printOut();

} elseif (isset($_GET['del']) AND (! empty($_GET['del']))) {
	$del_id = $_GET['del'];

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$delete = $sql_op->delete('cerita', 'idcerita='.$del_id);
    if ($delete) {
	    echo '<script type="text/javascript">alert(\'Data cerita dihapus!\');</script>';
	    //echo '<script type="text/javascript">UpdateOk();</script>';
	    //echo '<script type="text/javascript">Msg(\'Sukses\');</script>';
		//header ("location: /senayan3-stable14");
	} else {
	    echo '<script type="text/javascript">alert(\'Error update.\');</script>';
	    //echo '<script type="text/javascript">errUpdate('.$sql_op->error.');</script>';
	    //echo '<script type="text/javascript">Msg('.$sql_op->error.');</script>';
	}
	$messages ='<a href="milestone-list.php">Kembali ke daftar cerita</a>';

} else {
	$messages = '<em>Data proyek harus lengkap untuk editing...<em><br />';
	$messages .='<a href="milestone-list.php">Kembali ke daftar cerita</a>';
}

// Menu Nav
?>
<p align="right">
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
<a href='milestone-list.php'>Project Summary/Milestone</a>&nbsp;&nbsp;|
</p>
<?php

echo "<p id='content' align='center'>";
echo $messages;;
echo "</p>";

?>
</body>
</html>