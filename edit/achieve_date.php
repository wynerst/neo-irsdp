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
if (isset($_GET['p'])) {
	$projid = $_GET['p'];
} elseif (isset($_POST['idprojec_profile'])) {
	$projid = $_POST['idprojec_profile'];
}
if (isset($_GET['s'])) {
	$statid = $_GET['s'];
} elseif (isset($_POST['idref_status'])) {
	$statid = $_POST['idref_status'];
}
if (isset($_POST['find']) AND !empty($_POST['find'])) {
	$cari = $_POST['find'];
}

// ini akan terjadi saat submit
if (isset($_POST['simpanData'])) {
    // cek validitas form
    $idref_status = trim($_POST['idref_status']);
    $idproject_profile= trim($_POST['idproject_profile']);
    if (empty($idproject_profile) or empty($idproj_flow)) {
        echo '<script type="text/javascript">alert(\'Data cerita dan project step tidak boleh kosong!\');</script>';
		die();
    }
	
	unset($data);

	$data['idref_status'] = $idref_status;
	$data['idproject_profile'] = $idproject_profile;
	$data['tgl_mulai'] = trim($_POST['tgl_mulai']);
	$data['tgl_akhir'] = trim($_POST['tgl_akhir']);
	$data['status_akhir'] =  trim($_POST['status_akhir']);
	$data['kegiatan'] =  trim($_POST['kegiatan']);
	$data['tgl_diisi'] = date('Y-m-d');
	$data['tgl_revisi'] = date('Y-m-d');
	$data['idoperator'] = trim($_POST['idoperator']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->update('proj_flow', $data, 'idproj_flow='.$_POST['idproj_flow']);
    if ($insert) {
	    $messages= '<script type="text/javascript">alert(\'Data cerita diperbaiki!\');</script>';
	} else {
	    $messages= '<script type="text/javascript">alert(\'Error update.\');</script>';
	}
	
}

IF (isset($statid) AND isset($projid)) {

	$query1 = $dbs->query('SELECT * FROM ref_status_project_profile WHERE idref_status='. $_GET['id']);
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
	$table_spec = 'ref_status as rs';
	$setSQLColumn = 'pp.nama, rs.kode_status, rs.detil_status';
	$setSQLCriteria = 'rs.idref_status =' . $statid;
	$ref_status = $dbs->query('SELECT ' . $setSQLColumn . ' FROM ' . $table_spec . ' WHERE ' . $setSQLCriteria . ' LIMIT 0,1');
	while ($record = $ref_status->fetch_assoc()) {
		// proj name
		$form->addAnything('Project name', $record['nama']);
		//ref_status
		$form->addAnything('Tahapan proyek', $record['kode_status'] . ' - ' . $record['detil_status']);
	}

	// idpic
	$pic = $dbs->query('SELECT * FROM pic WHERE idpic='.$default['idpic']);
	while ($record = $pic->fetch_assoc()) {
		$form->addAnything('Login Petugas', $record['nama']);
	}

	// status
	$form->addTextField('text', 'status', 'Kondisi/Status cerita', $default['status'], 'style="width: 80%;"');

	//hidden
		$form->addHidden('idproj_flow', $default['idproj_flow']);
		$form->addHidden('idpic', $default['idpic']);

	$messages = $form->printOut();

} elseif (isset($_GET['del']) AND ( ! empty($_GET['del']))) {
	$del_id = $_GET['del'];
    // lakukan pemrosesan data tabel
	$sql_op = new simbio_dbop($dbs);
	$delete = $sql_op->update('proj_flow', 'idproj_flow='.$_POST['idproj_flow']);
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
<a href='achieve_date.php'>Tgl pencapaian</a>&nbsp;&nbsp;|
<span align='right'><form method='post'>
<input type='text' name='find'>
<input type='submit' value='Search'>
</form></span>
</p>
<?php

   /* Cerita/Milestone -  LIST */
    // table spec
	$table_spec = 'lap_monitor as l LEFT JOIN ref_status as rs ON rs.idref_status = l.idref_status
		LEFT JOIN project_profile as pp ON pp.idproject_profile = l.idproject_profile';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('pp.nama, rs.kode_status, l.*,
	concat("<a target=\"blank\" href=\"achieve_date.php?p=", l.idproject_profile, "&s=", l.idref_status, "\"><i>edit</i></a>&nbsp|&nbsp", 
	"<a target=\"blank\" href=\"achieve_date.php?p=", l.idproject_profile, "&s=", l.idref_status, "&add=1\"><i>add</i></a>&nbsp|&nbsp")
	as Tanggal_selesai');
	if (isset($projid)) {
		$datagrid->setSQLCriteria('l.idproject_profile = '. $projid);
	}
	if (isset($statid)) {
		$datagrid->setSQLCriteria('l.idref_status = '. $statid);
	}
	if (isset($cari)) {
		$datagrid->setSQLCriteria('pp.nama LIKE \'%'. $cari . '%\'');
	}
	
	$datagrid->setSQLorder('pp.nama ASC, l.idref_status ASC');

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 200);

echo "<p id='content'>";
echo $messages;
echo $datagrid_result;
echo "</p>";
?>
</body>
</html>