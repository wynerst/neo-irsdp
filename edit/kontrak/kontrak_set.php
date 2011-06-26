<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Proyek dgn Kontrak AKTIF</title>
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

if (isset($_POST['find']) AND !empty($_POST['find'])) {
	$cari = $_POST['find'];
}

    // table spec
    $table_spec = 'project_profile AS p LEFT JOIN proj_flow as pf ON p.idproject_profile = pf.idproject_profile
		LEFT JOIN ref_status AS r ON pf.idref_status = r.idref_status';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('p.pin AS \'PIN\'', 'pf.idproj_flow',
		'p.nama AS \'Proyek\'',
		'r.kode_status AS \'Status Akhir\'',
		'concat("<a href=\'kontrak_set.php?id=", p.idproject_profile, "&cat=", pf.idproj_flow, 
		"\'>Set</a> | <a href=\'kontrak_list.php?list=", p.idproject_profile, "\'>Detail</a>") AS \'Kontrak\'');

	$datagrid->setSQLorder('p.nama ASC');
	if (isset($cari)) {
		$datagrid->setSQLCriteria('(p.nama LIKE "%'.$cari.'%" OR p.pin LIKE "%'. $cari.'%") AND r.kontrak_step = 1');
	} else {
		$datagrid->setSQLCriteria('r.kontrak_step=1');
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
<a href='../list.php'>Project List</a>&nbsp;&nbsp;|&nbsp;
<a href='kontrak_step.php'>Tahapan Kontrak</a>&nbsp;&nbsp;|&nbsp;
<a href='kontrak_set.php'>SET Tahapan Kontrak</a>&nbsp;
<span align='right'><form method='post'>
<input type='text' name='find'>
<input type='submit' value='Search'>
</form></span>
</p>
<p><h2>Proyek dalam tahapan pembayaran kontrak AKTIF</h2></p>
<?php

if (isset($_POST['simpanData'])) {
	
	// initialization process
	unset($data);
	$sql_op = new simbio_dbop($dbs);
	$stop = 1;
	
	$data['idproj_flow'] = $_POST['idproj_flow'];


	// delete existing kontrak_flow with the same id proj_flow
	$sql_cek_exist = $dbs->query('SELECT * FROM kontrak_flow AS kf WHERE kf.idproj_flow='.$data['idproj_flow']);
	if ($sql_cek_exist->num_rows > 0) {
		$hapus = $sql_op->delete('kontrak_flow', 'idproj_flow = '.$data['idproj_flow']);
		echo "Delete existing data...";
		echo '<script type="text/javascript">alert(\'Here I am! '. $data['idproj_flow'] . '.\');</script>';
	}
	
	$keep_idproj_flow = $data['idproj_flow'];
	$data['tgl_rencana'] = date('Y-m-d H:i:s');
	$data['kegiatan'] = '';
	$data['pic'] = 0;
	$data['status'] = 'done';
	$data['idref_kontrak'] = $_POST['idref_kontrak'];

	
	// set kontrak_flow tables
	$getnext = $dbs->query('SELECT * FROM ref_kontrak WHERE idref_kontrak=' . $_POST['idref_kontrak']);
	while ($recnext = $getnext->fetch_assoc()) {
		$next_step = $recnext['next_step'];
	}
	do {
		// Type of kontrak
		$kontrak = $dbs->query('SELECT * FROM ref_kontrak WHERE idref_kontrak=' . $next_step);
		while ($record = $kontrak->fetch_assoc()) {
			$insert = $sql_op->insert('kontrak_flow', $data);
			$stop = $record['next_step'];
			$next_step = $stop;
			$data['idref_kontrak'] = $record['idref_kontrak'];
		}
	} while ($stop > 0);
	$data['status'] = 'on going';
	$insert = $sql_op->insert('kontrak_flow', $data);
	
	// set kontrak_flow_status
	
	// set termin_bayar
	// - cari $keep_idproj_flow yang aktif = kontrakflow_id
	// - tanya nilai rupiah tahap tsb, nilai rupiah dlm dolar, nilai dolar, sumber
	// - update utk setiap data dengan kontrakflow_id = $keep_idproj_flow.
	// - display query info lain: - Tahapan? lihat dari 'idref_kontrak' - link ke tabel 'ref_kontrak', ambil field 'detil_status'
	
	$sql_termin_bayar = $dbs->query('SELECT kf.* FROM kontrak_flow AS kf LEFT JOIN ref_kontrak AS rk ON
		kf.idref_kontrak = rk.idref_kontrak WHERE kf.idproj_flow='.$keep_idproj_flow.' ORDER BY idkontrak_flow');

	unset($data);
	while ($rec_tb = $sql_termin_bayar->fetch_assoc()) {
		$data['kontrakflow_id'] = $rec_tb['idkontrak_flow'];
		$data['sumber'] ='Loan';
		$data['nilai_rupiah'] = '9999';
		$data['nilai_dollar'] = '9999';
		$data['eq_idr_usd']	= '9999';
		// need to ask number first....

		$insert = $sql_op->insert('termin_bayar', $data);
	}
	
		
} elseif (isset($_GET['id'])) {

	$list = $dbs->query('SELECT * FROM project_profile WHERE idproject_profile ='.$_GET['id']);
	$rec_status = $list->fetch_assoc();

	// buat instance objek form
	$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

	// atribut atribut tambahan
	$form->submit_button_attr = 'name="simpanData" value="Update" class="button"';
	$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
	$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
	$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
	$form->table_content_attr = 'class="alterCell2"';

	$infoproyek = $rec_status['nama'].' - '.$rec_status['pin'];
	// Status detil
	$form->addAnything('Project ', isset($rec_status)?$infoproyek:'');
	
	// Type of kontrak
	$kontrak = $dbs->query('SELECT * FROM ref_kontrak WHERE inisialisasi=1');
	unset($array_dropdown);
	$array_dropdown[] = array('','Pilih Steps Proyek');
	while ($record = $kontrak->fetch_assoc()) {
		$array_dropdown[] = array($record['idref_kontrak'], $record['detil_status']);
	}
	$form->addSelectList('idref_kontrak', 'Awal Step Kontrak', $array_dropdown, '');

	// add hidden value
	$form->addHidden('idproj_flow', $_GET['cat']);
	
	echo "<p id='content'>";
	echo "<h3>Set awal inisiasi tahapan proyek " .$rec_status['nama']." - ".$rec_status['pin']."</h3><br />";
	echo $form->printOut();
	echo "</p>";

}
    echo $datagrid_result;


?>
</body>
</html>