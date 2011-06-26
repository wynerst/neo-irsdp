<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Laporan ADB-Set Tanggal-IRSDP</title>
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
	
		if (isset($_GET['list'])) {
			$list = $dbs->query('SELECT * FROM lap_monitor WHERE idlap_monitor='.$_GET['list']);
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

		// Project Profile
		$status = $dbs->query('SELECT * FROM project_profile');
		unset($array_dropdown);
		while ($record = $status->fetch_assoc()) {
			$array_dropdown[] = array($record['idproject_profile'], '('.$record['pin'].') '. substr($record['nama'],0,50));
		}
		$form->addSelectList('idproject_profile', 'Proyek ', $array_dropdown, $_GET['id']);

		// Status Proyek
		$status = $dbs->query('SELECT * FROM ref_status WHERE laporan_flag > 0 ORDER BY laporan_flag');
		unset($array_dropdown);
		while ($record = $status->fetch_assoc()) {
			$array_dropdown[] = array($record['idref_status'], '('.$record['kode_status'].') '. substr($record['detil_status'],0,80));
		}
		$form->addSelectList('idref_status', 'Status ', $array_dropdown, isset($rec_status)?$rec_status['idref_status']:'');

		$form->addTextField('text', 'tgl_batas', 'Tanggal Batas', isset($rec_status)?$rec_status['tgl_batas']:date('Y-m-d'), 'style="width: 20%;"');
		$form->addTextField('text', 'hari_kerja', 'Hari Kerja', isset($rec_status)?$rec_status['hari_kerja']:'', 'style="width: 20%;"');
		$form->addTextField('text', 'hari_kalender', 'Hari Kalender', isset($rec_status)?$rec_status['hari_kalender']:'', 'style="width: 20%;"');

		$form->addHidden('tgl_input', isset($rec_status)?$rec_status['tgl_input']:date('Y-m-d H:i:s'));
		$form->addHidden('tgl_update', date('Y-m-d H:i:s'));
		if (isset($rec_status)) {
			$form->addHidden('idlap_monitor', $rec_status['idlap_monitor']);
		}


		// Menu Nav
	?>
		<p align="right">
		<a href='list.php'>Project List</a>&nbsp;&nbsp;|
		<a href='kontrak_monitor.php?id=<?php echo $_GET['id']; ?>'>List TGL</a>&nbsp;
		</p>
	<?php

		echo "<p id='content'>";
		echo $form->printOut();
		echo "</p>";
		
	} else {
		echo 'Kode proyek tidak boleh kosong...';

		// Menu Nav
	?>
		<p align="right">
		<a href='list.php'>Project List</a>&nbsp;&nbsp;|
		<a href='kontrak_monitor.php?id=<?php echo $_GET['id']; ?>'>List TGL</a>&nbsp;
		</p>
	<?php

	}
}
?>

</body>
</html>