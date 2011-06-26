<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Permohonan-Invoice Quick add/edit IRSDP</title>
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
//require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'form_maker'.DIRECTORY_SEPARATOR.'simbio_form_element.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_file_upload.inc.php';

// ini akan terjadi saat submit
if (isset($_POST['simpanData'])) {
    // cek validitas form
    $idtermin_bayar = trim($_POST['idtermin_bayar']);
    $tgl_permohonan = trim($_POST['tgl_permohonan']);
    if (empty($idtermin_bayar) or empty($tgl_permohonan)) {
        echo '<script type="text/javascript">alert(\'Data termin pembayaran dan tanggal permohonan tidak boleh kosong!\');</script>';
    }
	
	unset($data);

	$data['idtermin_bayar'] = $idtermin_bayar;
	$data['tgl_permohonan'] = $tgl_permohonan;
	$data['nilai_permintaan_rupiah'] = trim($_POST['nilai_permintaan_rupiah']);
	$data['nilai_permintaan_dollar'] = trim($_POST['nilai_permintaan_dollar']);
	$data['nilai_disetujui_rupiah'] = trim($_POST['nilai_disetujui_rupiah']);
	$data['nilai_disetujui_dollar'] = trim($_POST['nilai_disetujui_dollar']);
	$data['nilai_disetujui_eq_idr_usd'] = trim($_POST['nilai_disetujui_eq_idr_usd']);
	$data['loan_adb_usd'] = trim($_POST['loan_adb_usd']);
	$data['grant_gov_usd'] = trim($_POST['grant_gov_usd']);
	$data['disetujui'] = trim($_POST['disetujui']);
	$data['tgl_dikirim'] = trim($_POST['tgl_dikirim']);
	$data['tgl_disetujui']= trim($_POST['tgl_disetujui']);
	$data['dibayarkan'] = trim($_POST['dibayarkan']);

    // lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->insert('permohonan', $data);
    if ($insert) {
	    echo '<script type="text/javascript">alert(\'New Invoice/Permohonan created!\');</script>';
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

if (isset($_GET['id']) AND !empty($_GET['id'])) {
	$idtermin = $_GET['id'];
} else {
	$idtermin = '';
}
// idtermin_bayar
$prop = $dbs->query('SELECT tb.idtermin_bayar, pp.nama, pp.pin, rk.detil_status FROM termin_bayar as tb 
	LEFT JOIN kontrak_flow as kf ON kf.idkontrak_flow = tb.kontrakflow_id 
	LEFT JOIN proj_flow as pf ON pf.idproj_flow = kf.idproj_flow 
	LEFT JOIN project_profile as pp ON pp.idproject_profile = pf.idproject_profile
	LEFT JOIN ref_kontrak as rk ON rk.idref_kontrak = kf.idref_kontrak
	WHERE pp.nama IS NOT NULL');
unset($array_dropdown);
while ($record = $prop->fetch_assoc()) {
	$array_dropdown[] = array($record['idtermin_bayar'], $record['pin'].' - '.$record['nama'].' # '.$record['detil_status']);
}
$form->addSelectList('idtermin_bayar', 'TAHAP Termin Pembayaran', $array_dropdown, $idtermin);

// pin
$form->addTextField('text', 'tgl_permohonan', 'Tgl Invoice/Permohonan', date('Y-m-d H:i:s'), 'style="width: 40%;"');

// ppp
$form->addTextField('text', 'nilai_permintaan_rupiah', 'Nilai dalam IDR', '', 'style="width: 40%;"');
$form->addTextField('text', 'nilai_permintaan_dollar', 'Nilai dalam USD', '', 'style="width: 40%;"');

// nama
$form->addTextField('text', 'nilai_disetujui_rupiah', 'Nilai IDR disetujui', '', 'style="width: 100%;"');
$form->addTextField('text', 'nilai_disetujui_eq_idr_usd', 'Nilai IDR disetujui setara USD', '', 'style="width: 100%;"');
$form->addTextField('text', 'nilai_disetujui_dollar', 'Nilai USD disetujui', '', 'style="width: 100%;"');

// lpd
$form->addTextField('text', 'loan_adb_usd', 'Pinjaman Donor (USD)', '', 'style="width: 100%;"');
$form->addTextField('text', 'grant_gov_usd', 'Hibah Pemerintah (IDR)', '', 'style="width: 100%;"');

// persetujuan
unset($array_radio);
$array_radio[] = array('1', 'Disetujui');
$array_radio[] = array('0', 'Tidak disetujui');
$form->addRadio('disetujui', 'Persetujuan invoice tagihan', $array_radio, '0');

// Lokasi
$form->addTextField('text', 'tgl_dikirim', 'Tgl permohonan dikirim ke ADB', date('Y-m-d H:i:s'), 'style="width: 100%;"');
$form->addTextField('text', 'tgl_disetujui', 'Tgl permohonan disetujui', date('Y-m-d H:i:s'), 'style="width: 100%;"');
$form->addTextField('text', 'dibayarkan', 'Tgl invoice dibayar', date('Y-m-d H:i:s'), 'style="width: 100%;"');

// Menu Nav
?>
<p align="right">
<a href='../list.php'>Project List</a>&nbsp;&nbsp;|&nbsp;
<a href='../kontrak/kontrak_set.php'>Proyek dgn Kontrak</a>&nbsp;&nbsp;|&nbsp;
<a href='../kontrak/kontrak_step.php'>Tahapan Kontrak</a>&nbsp;&nbsp;
</p>
<?php

echo "<p id='content'>";
echo $form->printOut();
echo "</p>";
?>
</body>
</html>