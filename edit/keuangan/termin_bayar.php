<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Termin Pembayaran Kontrak - add/edit IRSDP</title>
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

	if (isset($_GET['find']) AND !empty($_GET['find'])) {
		$cari = $_GET['find'];
	}

    // table spec
    $table_spec = 'termin_bayar AS t LEFT JOIN kontrak_flow as kf ON t.kontrakflow_id = kf.idkontrak_flow 
		LEFT JOIN ref_kontrak AS r ON r.idref_kontrak = kf.idref_kontrak
		LEFT JOIN proj_flow AS pf ON pf.idproj_flow = kf.idproj_flow
		LEFT JOIN project_profile as pp ON pp.idproject_profile = pf.idproject_profile
		LEFT JOIN kontraktor as k ON k.idkontraktor = kf.idkontraktor
		LEFT JOIN perusahaan as pt ON pt.idperusahaan = k.idperusahaan';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('pp.nama AS Proyek', 'pt.nama AS Konsultan', 't.idtermin_bayar', 't.kontrakflow_id', 't.nilai_rupiah', 't.nilai_dollar', 
		't.eq_idr_usd AS \'Eq. Dollar\'', 't.sumber', 'r.detil_status',
		'concat("<a href=\'termin_bayar.php?id=", t.kontrakflow_id, "\'>Edit</a>&nbsp;|&nbsp;",
		"<a href=\'termin_bayar.php?del=", t.idtermin_bayar, "\'>Delete</a>") AS \'Data Termin Pembayaran\'',
		'concat("<a href=\'invoice.php?req=", t.idtermin_bayar, "\'>Edit</a>&nbsp;|&nbsp;",
		"<a href=\'invoice_add.php?id=", t.idtermin_bayar, "\'>Add</a>") AS \'Permohonan/Invoice\'');

	if (isset($cari)) {
		$datagrid->setSQLCriteria('pp.nama LIKE "%'.$cari.'%" OR pt.nama LIKE "%'.$cari.'%"');
	}
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
	<span align='right'><form method='get'>
	<input type='text' name='find'>
	<input type='submit' value='Search'>
	</form></span>
</p>
<p><h2>Editing Termin Pembayaran Proyek</h2></p>
<?php

if (isset($_GET['id'])) {

	$idtermin = $_GET['id'];
	
	$list = $dbs->query('SELECT t.*, r.detil_status FROM termin_bayar AS t
		LEFT JOIN kontrak_flow as kf ON t.kontrakflow_id = kf.idkontrak_flow 
		LEFT JOIN ref_kontrak AS r ON r.idref_kontrak = kf.idref_kontrak WHERE t.kontrakflow_id='.$idtermin);
	while ($rec_term=$list->fetch_assoc()) {
		$idtermin_bayar = $rec_term['idtermin_bayar'];
		$kontrakflow_id = $rec_term['kontrakflow_id'];
		$nilai_rupiah = $rec_term['nilai_rupiah'];
		$nilai_dollar = $rec_term['nilai_dollar'];
		$eq_idr_usd = $rec_term['eq_idr_usd'];
		$sumber = $rec_term['sumber'];
	}
	
	// buat instance objek form
	$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

	// atribut atribut tambahan
	$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
	$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
	$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
	$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
	$form->table_content_attr = 'class="alterCell2"';
	
	// kontrak_flow_id
	$form->addTextField('text', 'kontrakflow_id', 'Kontrak Flow ID', $kontrakflow_id, 'style="width: 20%;"');

	// nilai_rupiah
	$form->addTextField('text', 'nilai_rupiah', 'Nilai kontrak rupiah', $nilai_rupiah, 'style="width: 20%;"');

	// eq_idr_usd
	$form->addTextField('text', 'eq_idr_usd', 'Dollar setara rupiah', $eq_idr_usd, 'style="width: 20%;"');

	// nilai_dollar
	$form->addTextField('text', 'nilai_dollar', 'Nilai kontrak Dollar', $nilai_dollar, 'style="width: 20%;"');

	// sumber
	$form->addTextField('text', 'sumber', 'Sumber dana', $sumber, 'style="width: 20%;"');
	
	// idtermin_bayar
	$form->addHidden('idtermin_bayar', $idtermin_bayar);

	echo "<p id='content'>";
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
		echo '<script type="text/javascript">alert(\'Data Termin Pembayaran Kontrak updated/inserted!\');</script>';
	} else {
		echo '<script type="text/javascript">alert(\'Error Data Termin Pembayaran Kontrak.\');</script>';
	}

} elseif (isset($_GET['del'])) {
	$sql_op = new simbio_dbop($dbs);
	$delete = $sql_op->delete('termin_bayar', 'idtermin_bayar='.$_GET['del']);
	if ($delete) {
		echo '<script type="text/javascript">alert(\'Data Termin Pembayaran Kontrak dihapus!\');</script>';
	} else {
		echo '<script type="text/javascript">alert(\'Error Data Termin Pembayaran Kontrak.\');</script>';
		die();
	}
	
}
    echo $datagrid_result;

?>

</body>
</html>