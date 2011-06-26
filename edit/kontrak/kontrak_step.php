<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Kontrak Step-Set Urutan</title>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<?php
/**
 *
 * Contoh penggunaan form
 *
 */

// file sysconfig sebaiknya berada di paling atas kode
require '../sysconfig.inc.php';

// masukan file library form
require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'form_maker'.DIRECTORY_SEPARATOR.'simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_file_upload.inc.php';

// ini akan terjadi saat submit
if (isset($_POST['simpanData'])) {

	unset($data);
    // cek validitas form
	if (isset($_POST['idlap_monitor'])) {
		$idlap_monitor = $_POST['idlap_monitor'];
	}

	$data['idproject_profile'] = $_POST['idproject_profile'];
	$data['idref_status'] = $_POST['idref_status'];
	$data['tgl_batas'] = $_POST['tgl_batas'];
	$data['hari_kerja'] = $_POST['hari_kerja'];
	$data['hari_kalender'] = $_POST['hari_kalender'];
	$data['tgl_update'] = $_POST['tgl_update'];
	$data['tgl_input'] = $_POST['tgl_input'];

	// lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	if (isset($idlap_monitor)) {
		$insert = $sql_op->update('lap_monitor', $data, 'idlap_monitor='.$idlap_monitor);
	} else {
		$insert = $sql_op->insert('lap_monitor', $data);
	}
	if ($insert) {
		echo '<script type="text/javascript">alert(\'Data updated/inserted!.\');</script>';
	} else {
		echo '<script type="text/javascript">alert(\'Error.\');</script>';
		die();
	}

} else {

	IF (isset($_GET['id'])) {
	
		if ($_GET['id']>0) {
			$list = $dbs->query('SELECT * FROM ref_kontrak WHERE idref_kontrak='.$_GET['id']);
			$rec_status = $list->fetch_assoc();
		}
		
		// buat instance objek form
		$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

		// atribut atribut tambahan
		$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
		$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
		$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
		$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
		$form->table_content_attr = 'class="alterCell2"';

		// Status detil
		$form->addTextField('text', 'detil_status', 'Detil Status', isset($rec_status)?$rec_status['detil_status']:'', 'style="width: 20%;"');
		
		// Next_step
		$form->addTextField('text', 'next_step', 'Tahap kontrak berikut', isset($rec_status)?$rec_status['next_step']:'', 'style="width: 20%;"');

		// tahap inisiasi
		$array_radio[] = array('0', 'Bukan tahap awal');
		$array_radio[] = array('1', 'Permulaan tahap');
		$form->addRadio('inisialisasi', 'Inisialisasi', $array_radio, isset($rec_status)?$rec_status['inisialisasi']:0);

		if (isset($_GET['id'])) {
			$form->addHidden('idref_kontrak', isset($rec_status)?$rec_status['idref_kontrak']:'');
		}

		// Menu Nav
	?>
		<p align="right">
		<a href='../list.php'>Project List</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_step.php'>Tahapan Kontrak</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_set.php'>SET Tahapan Kontrak</a>&nbsp;
		</p>
		<p><h2>Rujukan - Detil tahapan pembayaran dalam kontrak</h2></p>
	<?php

		echo "<p id='content'>";
		echo $form->printOut();
		echo "</p>";
		
	} else {
		// Menu Nav
	?>
		<p align="right">
		<a href='../list.php'>Project List</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_step.php'>Tahapan Kontrak</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_set.php'>SET Tahapan Kontrak</a>&nbsp;
		<span align='right'><form method='post'>
		<input type='text' name='find'>
		<input type='submit' value='Search'>
		</form></span>
		</p>
		<p><h2>Rujukan - Detil tahapan pembayaran dalam kontrak</h2></p>
	<?php

	if (isset($_POST['find']) AND !empty($_POST['find'])) {
		$cari = $_POST['find'];
	}

    // table spec
    $table_spec = 'ref_kontrak AS rk';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('rk.*',
		'concat("<a href=\'kontrak_step.php?id=", rk.idref_kontrak, "\'>Edit</a> | <a href=\'kontrak_step.php?id=0",
		"\'>New</a>") AS \'Status\'');

	$datagrid->setSQLorder('rk.idref_kontrak ASC');
	if (isset($cari)) {
		$datagrid->setSQLCriteria('rk.detil_status LIKE "%'.$cari.'%"');
	}
    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20);
    echo $datagrid_result;

	}
}
?>

</body>
</html>
