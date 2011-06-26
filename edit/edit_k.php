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
    $idperusahaan = trim($_POST['idperusahaan']);
    $idproject_profile = trim($_POST['idproject_profile']);
    if (empty($idperusahaan) or empty($idproject_profile)) {
        echo '<script type="text/javascript">alert(\'Nama Proyek dan Perusahaan tidak boleh kosong!\');</script>';
		die();
    }
	
	unset($data);

	$data['idperusahaan'] = $idperusahaan;
	$data['idproject_profile'] = $idproject_profile;
	$data['tgl_mulai'] = trim($_POST['tgl_mulai']);
	$data['tgl_selesai'] =  trim($_POST['tgl_mulai']);
	$data['tahapan'] =  trim($_POST['tahapan']);
	$data['pcss_no'] = trim($_POST['pcss_no']);
	$data['pcss_date'] = trim($_POST['pcss_date']);
	$data['no_kontrak'] = trim($_POST['no_kontrak']);
	$data['tgl_disetujui'] = trim($_POST['tgl_disetujui']);
	$data['anggaran_total_usd'] = trim($_POST['anggaran_total_usd']);
	$data['anggaran_usd'] = trim($_POST['anggaran_usd']);
	$data['anggaran_idr'] = trim($_POST['anggaran_idr']);
	$data['catatan'] = trim($_POST['catatan']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->update('kontraktor', $data, 'idkontraktor='.$_POST['id']);
    if ($insert) {
	    echo '<script type="text/javascript">alert(\'Data kontraktor diperbaiki!\');</script>';
	    //echo '<script type="text/javascript">UpdateOk();</script>';
	    //echo '<script type="text/javascript">Msg(\'Sukses\');</script>';
		//header ("location: /senayan3-stable14");
	} else {
	    echo '<script type="text/javascript">alert(\'Error.\');</script>';
	    //echo '<script type="text/javascript">errUpdate('.$sql_op->error.');</script>';
	    //echo '<script type="text/javascript">Msg('.$sql_op->error.');</script>';
	}
	
}
IF (isset($_GET['id'])) {
$query1 = $dbs->query('SELECT * FROM kontraktor WHERE idkontraktor='. $_GET['id']);
$default = $query1->fetch_assoc();

// buat instance objek form
$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

// atribut atribut tambahan
$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';


// Project
$project = $dbs->query('SELECT * FROM project_profile');
unset($array_dropdown);
$array_dropdown[] = array('','Pilih Proyek');
while ($record = $project->fetch_assoc()) {
	$array_dropdown[] = array($record['idproject_profile'], $record['pin'].'-'.$record['nama']);
}
$form->addSelectList('idproject_profile', 'Nama Proyek', $array_dropdown, $default['idproject_profile']);

// Perusahaan
$perusahaan = $dbs->query('SELECT * FROM perusahaan');
unset($array_dropdown);
$array_dropdown[] = array('','Pilih Peserta Tender');
while ($record = $perusahaan->fetch_assoc()) {
	$array_dropdown[] = array($record['idperusahaan'], $record['nama']);
}
$form->addSelectList('idperusahaan', 'Perusahaan', $array_dropdown, $default['idperusahaan']);

// tgl_mulai
$form->addTextField('text', 'tgl_mulai', 'Tanggal mulai', $default['tgl_mulai'], 'style="width: 20%;"');

// tgl_selesai
$form->addTextField('text', 'tgl_selesai', 'Tanggal selesai', $default['tgl_selesai'], 'style="width: 20%;"');

// tahapan
unset($array_radio);
$array_radio[] = array('PraFS', 'PraFS');
$array_radio[] = array('Investor', 'Investor');
$array_radio[] = array('Transaction', 'Transaction');
$array_radio[] = array('', 'Others Project');
$form->addRadio('tahapan', 'Tahapan Tender', $array_radio, $default['tahapan']);

// pcss_no
$form->addTextField('text', 'pcss_no', 'No PCSS', $default['pcss_no'], 'style="width: 50%;"');

// pcss_date
$form->addTextField('text', 'pcss_date', 'Tanggal PCSS', $default['pcss_date'], 'style="width: 50%;"');

// no_kontrak
$form->addTextField('text', 'no_kontrak', 'No Kontrak', $default['no_kontrak'], 'style="width: 50%;"');

// tanggal_disetujui
$form->addTextField('text', 'tgl_disetujui', 'Tanggal Disetujui', $default['tgl_disetujui'], 'style="width: 50%;"');

// anggaran_total_usd
$form->addTextField('text', 'anggaran_total_usd', 'Rencana Anggaran Total (USD)', $default['anggaran_total_usd'], 'style="width: 50%;"');

// anggaran_idr
$form->addTextField('text', 'anggaran_idr', 'Nilai Anggaran Rupiah', $default['anggaran_idr'], 'style="width: 50%;"');

// anggaran_total_usd
$form->addTextField('text', 'anggaran_usd', 'Nilai Anggaran USD', $default['anggaran_usd'], 'style="width: 50%;"');


// tambahkan element form textarea
$form->addTextField('textarea', 'Catatan', 'Catatan', $default['catatan'], 'style="width: 100%;" rows="3"');

} else {
echo 'Data proyek harus lengkap untuk editing...';
die();
}

// Menu Nav
?>
<p align="right">
<a href='new-proj.php'>New Project</a>&nbsp;&nbsp;|
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
<a href='kontraktor.php'>New Contractor</a>&nbsp;&nbsp;|
<a href='list_kontraktor.php'>Contractor List</a>&nbsp;&nbsp;|
</p>
<?php

echo "<p id='content'>";
echo $form->printOut();
echo "</p>";
?>
</body>
</html>