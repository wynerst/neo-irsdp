<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Permohonan Invoice/Pembayaran Kontrak - add/edit IRSDP</title>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<?php
require '../sysconfig.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';


    // table spec
    $table_spec = 'permohonan AS p LEFT JOIN termin_bayar as t ON p.idtermin_bayar = t.idtermin_bayar
		LEFT JOIN kontrak_flow AS kf ON t.kontrakflow_id = kf.idkontrak_flow
		LEFT JOIN ref_kontrak AS r ON r.idref_kontrak = kf.idref_kontrak
		LEFT JOIN proj_flow AS pf ON kf.idproj_flow = pf.idproj_flow
		LEFT JOIN project_profile AS pp on pf.idproject_profile = pp.idproject_profile';

if (isset($_GET['req'])) {
	$table_spec .= " WHERE pp.idproject_profile =" . $_GET['req'];
}

		// create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('p.tgl_permohonan AS TGL', 'p.nilai_permintaan_rupiah AS Inv_IDR', 'p.eq_idr_usd AS INV_eq_USD',
		'p.nilai_permintaan_dollar AS Inv_USD',
		'concat(p.nilai_disetujui_rupiah, "<br />Eq. USD", p.nilai_disetujui_eq_idr_usd) AS Approve_IDR',
		'p.nilai_disetujui_dollar AS Approve_USD', 'p.disetujui AS Disetujui', 	'p.loan_adb_usd', 'p.grant_gov_usd',
		'concat("Dikirim: ", p.tgl_dikirim, "<br />Disetujui: ", p.tgl_disetujui, "<br />Dibayar: ", p.dibayarkan) AS Tgl_Dokumen',
		'concat("IDR", t.nilai_rupiah, " (=USD ", t.eq_idr_usd, ")<br />USD ", t.nilai_dollar) AS \'Nilai Kontrak\'',
		'concat("<a href=\'invoice.php?id=", p.idpermohonan, "\'>Edit</a>&nbsp;|&nbsp;",
		"<a href=\'invoice.php?add=0\'>New</a>&nbsp;|&nbsp;",
		"<a href=\'invoice.php?del=", p.idpermohonan, "\'>Delete</a>") AS \'Permohonan/Invoice\'');

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20);

// Menu Nav
?>
<p align="right">
<a href='../tabel2.php'>Report</a>&nbsp;&nbsp;|
<a href='termin_bayar.php'>Keuangan</a>&nbsp;&nbsp;|
<a href='../list.php'>Project List</a>&nbsp;&nbsp;|
<a href='../kontrak/kontrak_list.php'>Kontrak</a>&nbsp;&nbsp;|
<a href='invoice.php'>Invoice kontrak</a>&nbsp;&nbsp;|
</p>
<p><h2>Editing Invoice/Permohonan Pembayaran Proyek</h2></p>
<?php

if (isset($_GET['id']) or isset($_GET['add'])) {

	// buat instance objek form
	$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

	// atribut atribut tambahan
	$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
	$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
	$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
	$form->table_content_attr = 'class="alterCell2"';
	
	if (isset($_GET['id'])) {
	
		$idtermin = $_GET['id'];
	
		$list = $dbs->query('SELECT p.*, pp.nama FROM permohonan AS p
			LEFT JOIN termin_bayar as t ON p.idtermin_bayar = t.idtermin_bayar
			LEFT JOIN kontrak_flow AS kf ON t.kontrakflow_id = kf.idkontrak_flow
			LEFT JOIN ref_kontrak AS r ON r.idref_kontrak = kf.idref_kontrak
			LEFT JOIN proj_flow AS pf ON kf.idproj_flow = pf.idproj_flow
			LEFT JOIN project_profile AS pp on pf.idproject_profile = pp.idproject_profile
			WHERE p.idpermohonan='.$idtermin);
			
		while ($rec_term=$list->fetch_assoc()) {
			$idpermohonan = $rec_term['idpermohonan'];
			$idtermin_bayar = $rec_term['idtermin_bayar'];
			$tgl_permohonan = $rec_term['tgl_permohonan'];
			$nilai_permintaan_rupiah = $rec_term['nilai_permintaan_rupiah'];
			$eq_idr_usd = $rec_term['eq_idr_usd'];
			$nilai_permintaan_dollar = $rec_term['nilai_permintaan_dollar'];
			$nilai_disetujui_rupiah = $rec_term['nilai_disetujui_rupiah'];
			$nilai_disetujui_eq_idr_usd = $rec_term['nilai_disetujui_eq_idr_usd'];
			$nilai_disetujui_dollar = $rec_term['nilai_disetujui_dollar'];
			$disetujui = $rec_term['disetujui'];
			$loan_adb_usd = $rec_term['loan_adb_usd'];
			$grant_gov_usd = $rec_term['grant_gov_usd'];
			$tgl_dikirim = $rec_term['tgl_dikirim'];
			$tgl_disetujui = $rec_term['tgl_disetujui'];
			$dibayarkan = $rec_term['dibayarkan'];
			$proyek = $rec_term['nama'];
		}
		
		$form->submit_button_attr = 'name="simpanData" value="Update" class="button"';

	} else {
	
		$proyek = "baru";
		$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
	}
	
	// idtermin_bayar
	$termin_bayar = $dbs->query('SELECT t.idtermin_bayar, pp.nama, rk.detil_status FROM termin_bayar AS t
		LEFT JOIN kontrak_flow as kf ON kf.idkontrak_flow = t.kontrakflow_id
		LEFT JOIN ref_kontrak as rk ON rk.idref_kontrak = kf.idref_kontrak
		LEFT JOIN proj_flow as pf ON pf.idproj_flow = kf.idproj_flow
		LEFT JOIN project_profile as pp ON pp.idproject_profile = pf.idproject_profile');
	unset($array_dropdown);
	$array_dropdown[] = array('','Pilih Termin kontrak dari Proyek');
	while ($record = $termin_bayar->fetch_assoc()) {
		$array_dropdown[] = array($record['idtermin_bayar'], $record['nama'] . " - " . $record['detil_status']);
	}
	$form->addSelectList('idtermin_bayar', 'Termin pembayaran', $array_dropdown, isset($idtermin_bayar)? $idtermin_bayar : '');

	// tgl_permohonan
	$form->addTextField('text', 'tgl_permohonan', 'Tanggal Permohonan', isset($tgl_permohonan)? $tgl_permohonan : 0, 'style="width: 20%;"');

	// nilai_permintaan_rupiah
	$form->addTextField('text', 'nilai_permintaan_rupiah', 'Nilai Permohonan IDR', isset($nilai_permintaan_rupiah)? $nilai_permintaan_rupiah : 0, 'style="width: 20%;"');

	// eq_idr_usd
	$form->addTextField('text', 'eq_idr_usd', 'Permohonan IDR dalam USD', isset($eq_idr_usd)? $eq_idr_usd : 0, 'style="width: 20%;"');

	// nilai_permintaan_dollar
	$form->addTextField('text', 'nilai_permintaan_dollar', 'Nilai Permohonan USD', isset($nilai_permintaan_dollar)? $nilai_permintaan_dollar : 0, 'style="width: 20%;"');

	// nilai_disetujui_rupiah
	$form->addTextField('text', 'nilai_disetujui_rupiah', 'Nilai disetujui IDR', isset($nilai_disetujui_rupiah)? $nilai_disetujui_rupiah : 0, 'style="width: 20%;"');

	// nilai_disetujui_eq_idr_usd
	$form->addTextField('text', 'nilai_disetujui_eq_idr_usd', 'Persetujuan IDR dalam USD', isset($nilai_disetujui_eq_idr_usd)? $nilai_disetujui_eq_idr_usd : 0, 'style="width: 20%;"');

	// nilai_disetujui_dollar
	$form->addTextField('text', 'nilai_disetujui_dollar', 'Nilai disetujui USD', isset($nilai_disetujui_dollar)? $nilai_disetujui_dollar : 0, 'style="width: 20%;"');

	// disetujui
	unset($array_radio);
	$array_radio[] = array('1', 'Disetujui');
	$array_radio[] = array('0', 'Belum disetujui');
	$form->addRadio('disetujui', 'Status Permohonan', $array_radio, isset($disetujui)? $disetujui : 0);
	
	// loan_adb_usd
	$form->addTextField('text', 'loan_adb_usd', 'Nilai Loan ADB dalam USD', isset($loan_adb_usd)? $loan_adb_usd : 0, 'style="width: 20%;"');

	// grant_gov_usd
	$form->addTextField('text', 'grant_gov_usd', 'Nilai Grant Pemerintah dalam USD', isset($grant_gov_usd)? $grant_gov_usd : 0, 'style="width: 20%;"');

	// tgl_dikirim
	$form->addTextField('text', 'tgl_dikirim', 'Dok dikirim ke ADB', isset($tgl_dikirim)? $tgl_dikirim : 0, 'style="width: 20%;"');

	// tgl_disetujui
	$form->addTextField('text', 'tgl_disetujui', 'Dok disetujui ADB', isset($tgl_disetujui)? $tgl_disetujui : 0, 'style="width: 20%;"');

	// dibayarkan
	$form->addTextField('text', 'dibayarkan', 'Tanggal dibayarkan', isset($dibayarkan)? $dibayarkan : 0, 'style="width: 20%;"');

	$form->addHidden('idpermohonan', isset($idpermohonan)? $idpermohonan : '');

	echo "<p id='content'>";
	echo "<h3>Editing pembayaran $proyek</h3>";
	echo $form->printOut();
	echo "</p>";
		
} elseif (isset($_POST['simpanData'])) {

	unset($data);

	$data['idtermin_bayar'] = $_POST['idtermin_bayar'];
	$data['kontrakflow_id'] = $_POST['kontrakflow_id'];
	$data['nilai_rupiah'] = $_POST['nilai_rupiah'];
	$data['nilai_dollar'] = $_POST['nilai_dollar'];
	$data['eq_idr_usd'] = $_POST['eq_idr_usd'];
	$data['sumber'] = $_POST['sumber'];

	$sql_op = new simbio_dbop($dbs);
	$insert = $sql_op->update('termin_bayar', $data, 'idtermin_bayar='.$_POST['idtermin_bayar']);
	if ($insert) {
		echo '<script type="text/javascript">alert(\'Data Permohonan Pembayaran Kontrak updated/inserted!\');</script>';
	} else {
		echo '<script type="text/javascript">alert(\'Error Data Permohonan Pembayaran Kontrak.\');</script>';
	}

} elseif (isset($_GET['del'])) {
	$sql_op = new simbio_dbop($dbs);
	$delete = $sql_op->delete('permohonan', 'idpermohonan='.$_GET['del']);
	if ($delete) {
		echo '<script type="text/javascript">alert(\'Data Permohonan Pembayaran Kontrak dihapus!\');</script>';
	} else {
		echo '<script type="text/javascript">alert(\'Error Data Permohonan Pembayaran Kontrak.\');</script>';
		die();
	}
	
}
    echo $datagrid_result;

?>

</body>
</html>