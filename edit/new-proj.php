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
    $nama = trim($_POST['nama']);
    $pin = trim($_POST['pin']);
    if (empty($nama) or empty($pin)) {
        echo '<script type="text/javascript">alert(\'Nama Proyek dan PIN tidak boleh kosong!\');</script>';
    }
	
	unset($data);

	$data['pin'] = trim($_POST['pin']);
	$data['nama'] = $nama;
	$data['ppp_book_code'] = trim($_POST['ppp']);
	$data['usulan_lpd'] = trim($_POST['lpd']);
	$data['lokasi'] = trim($_POST['lokasi']);
	$data['bpsid_propinsi'] = trim($_POST['bpsid_propinsi']);
	$data['id_kategori'] = trim($_POST['id_kategori']);
	$data['id_loan'] = trim($_POST['id_loan']);
	$data['surat_lpd']= trim($_POST['surat_lpd']);
	$data['appr_dprd'] = trim($_POST['appr_dprd']);
	$data['ppp_form'] = trim($_POST['ppp_form']);
	$data['doc_fs'] = trim($_POST['doc_fs']);
	$data['tgl_usulan'] = trim($_POST['tgl_usulan']);
	$data['tgl_diisi'] =  date('Y-m-d H:i:s');
	$data['tgl_revisi'] = date('Y-m-d H:i:s');
	$data['idoperator'] = trim($_POST['idoperator']);
	$data['last_idref_status'] = trim($_POST['last_idref_status']);
	$data['prafs_tender'] = trim($_POST['prafs_tender']);	
	$data['trans_tender'] = trim($_POST['trans_tender']);
	$data['tipe_proyek'] = trim($_POST['tipe_proyek']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->insert('project_profile', $data);
    if ($insert) {
	    echo '<script type="text/javascript">alert(\'New Project created!\');</script>';
	    //echo '<script type="text/javascript">UpdateOk();</script>';
	    //echo '<script type="text/javascript">Msg(\'Sukses\');</script>';
		//header ("location: /senayan3-stable14");
	} else {
	    echo '<script type="text/javascript">alert(\'Error.\');</script>';
	    //echo '<script type="text/javascript">errUpdate('.$sql_op->error.');</script>';
	    //echo '<script type="text/javascript">Msg('.$sql_op->error.');</script>';
	}
	
}

// buat instance objek form
$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

// atribut atribut tambahan
$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

// pin
$form->addTextField('text', 'pin', 'PIN', '', 'style="width: 40%;"');

// ppp
$form->addTextField('text', 'ppp', 'PPP Book Code', '', 'style="width: 40%;"');

// nama
$form->addTextField('text', 'nama', 'Nama Proyek', '', 'style="width: 100%;"');

// lpd
$form->addTextField('text', 'lpd', 'Lembaga Pengusul', '', 'style="width: 100%;"');

// Tanggal Usulan
$form->addTextField('text', 'tgl_usulan', 'Tanggal Usulan', '', 'style="width: 40%;"');

// Lokasi
$form->addTextField('text', 'lokasi', 'Lokasi proyek', '', 'style="width: 100%;"');

// Propionsi
$prop = $dbs->query('SELECT * FROM master_propinsi');
unset($array_dropdown);
while ($record = $prop->fetch_assoc()) {
	$array_dropdown[] = array($record['id_propinsi'], $record['nama_propinsi']);
}
$form->addSelectList('bpsid_propinsi', 'Propinsi', $array_dropdown, '');

// Kategori
$kategori = $dbs->query('SELECT * FROM kategori');
unset($array_dropdown);
while ($record = $kategori->fetch_assoc()) {
	$array_dropdown[] = array($record['idkategori'], $record['sectorCode'].'-'.$record['sectorName'].': '.$record['subsectorname']);
}
$form->addSelectList('id_kategori', 'Kategori', $array_dropdown, '');

// Loan
unset($array_radio);
$array_radio[] = array('1', 'Loan');
$array_radio[] = array('2', 'Grant');
$form->addRadio('id_loan', 'Sumber dana', $array_radio, '1');

// Surat Lembaga
unset($array_radio);
$array_radio[] = array('0', 'Tdk ada');
$array_radio[] = array('1', 'Ada');
$form->addRadio('surat_lpd', 'Pengantar Lembaga', $array_radio, '0');

// Persetujuan Dprd
unset($array_radio);
$array_radio[] = array('0', 'Tdk ada');
$array_radio[] = array('1', 'Ada');
$form->addRadio('appr_dprd', 'Persetujuan DPRD', $array_radio, '0');

// Dokumen proposal PPP
unset($array_radio);
$array_radio[] = array('0', 'Tdk ada');
$array_radio[] = array('1', 'Ada');
$form->addRadio('ppp_form', 'Dokumen Proposal PPP', $array_radio, '0');

// Tipe proyek
unset($array_dropdown);
$array_dropdown[] = array('0','Unsolicited');
$array_dropdown[] = array('1', 'Solicited');
$form->addSelectList('tipe_proyek', 'Tipe Proyek', $array_dropdown, '0');

// Status Terakhir Proyek
$status = $dbs->query('SELECT * FROM ref_status');
unset($array_dropdown);
while ($record = $status->fetch_assoc()) {
	$array_dropdown[] = array($record['idref_status'], '('.$record['kode_status'].') '. substr($record['detil_status'],0,50));
}
$form->addSelectList('last_idref_status', 'Status ', $array_dropdown, '');

// jenis tender prafs
unset($array_radio);
$array_radio[] = array('0', 'Belum ada');
$array_radio[] = array('1', 'QCBS');
$array_radio[] = array('2', 'CQS');
$form->addRadio('prafs_tender', 'Jenis tender PRA-FS', $array_radio, '0');

// jenis tender transaction
unset($array_radio);
$array_radio[] = array('0', 'Belum ada');
$array_radio[] = array('1', 'QCBS');
$array_radio[] = array('2', 'CQS');
$form->addRadio('trans_tender', 'Jenis tender Transaction', $array_radio, '0');

// tambahkan element form file
$form->addTextField('file', 'doc_fs', 'File Document FS');

// hidden
$form->addHidden('idoperator', 9999);

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

echo "<p id='content'>";
echo $form->printOut();
echo "</p>";
?>
</body>
</html>