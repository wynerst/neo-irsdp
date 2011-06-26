<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Kontrak Step - IRSDP</title>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<?php

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
	if (isset($_POST['idkontrak_flow'])) {
		$idkontrak_flow = $_POST['idkontrak_flow'];
	}

	$data['pic'] = $_POST['pic'];
	$data['kegiatan'] = $_POST['kegiatan'];
	$data['idproj_flow'] = $_POST['idproj_flow'];
	$data['tgl_rencana'] = $_POST['tgl_rencana'];
	$data['status'] = $_POST['status'];
	$data['idref_kontrak'] = $_POST['idref_kontrak'];

	// lakukan pemrosesan form di bawah ini...
	$sql_op = new simbio_dbop($dbs);
	if (isset($idkontrak_flow)) {
		$insert = $sql_op->update('kontrak_flow', $data, 'idkontrak_flow='.$idkontrak_flow);
	} else {
		$insert = $sql_op->insert('kontrak_flow', $data);
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
			$list = $dbs->query('SELECT * FROM kontrak_flow WHERE idkontrak_flow='.$_GET['id']);
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

		// Alur proyek terakhir
		$kontrak = $dbs->query('SELECT pf.idproj_flow, p.nama, p.pin, rs.detil_status, rs.kode_status
			FROM proj_flow AS pf LEFT JOIN project_profile AS P ON pf.idproject_profile = p.idproject_profile 
			LEFT JOIN ref_status AS rs ON pf.idref_status=rs.idref_status
			WHERE rs.kontrak_step = 1');
		unset($array_dropdown);
		$array_dropdown[] = array('','Pilih Steps Proyek');
		while ($record = $kontrak->fetch_assoc()) {
			$array_dropdown[] = array($record['idproj_flow'], $record['nama'].' ('.$record['pin'].') @ step '.$record['kode_status'].' - '.$record['detil_status']);
		}
		$form->addSelectList('idproj_flow', 'Awal Step Kontrak', $array_dropdown, isset($rec_status)?$rec_status['idproj_flow']:'');

		// add hidden value
		$form->addHidden('kegiatan', '');
		$form->addHidden('pic', 0);
		if (isset($_GET['id'])) {
			$form->addHidden('idkontrak_flow', $_GET['id']);
		}

		// tgl rencana
		$form->addTextField('text', 'tgl_rencana', 'Tanggal rencana', isset($rec_status)?$rec_status['tgl_rencana']:'', 'style="width: 20%;"');
		
		// status
		$form->addTextField('text', 'status', 'Status Tahapan kontrak', isset($rec_status)?$rec_status['status']:'', 'style="width: 20%;"');

		// ref_kontrak
		$kontrak = $dbs->query('SELECT * FROM ref_kontrak');
		unset($array_dropdown);
		$array_dropdown[] = array('','Pilih Steps Kontrak');
		while ($record = $kontrak->fetch_assoc()) {
			$array_dropdown[] = array($record['idref_kontrak'], $record['detil_status']);
		}
		$form->addSelectList('idref_kontrak', 'Step Kontrak', $array_dropdown, isset($rec_status)?$rec_status['idref_kontrak']:'');

		// Menu Nav
	?>
		<p align="right">
		<a href='../list.php'>Project List</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_step.php'>Tahapan Kontrak</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_set.php'>Kontrak Set</a>&nbsp;&nbsp;|
		<a href='../keuangan/termin_bayar.php'>Termin kontrak</a>&nbsp;&nbsp;|
		<a href='../keuangan/invoice.php'>Invoice kontrak</a>&nbsp;&nbsp;|
		</p>
	<?php

		echo "<p id='content'>";
		echo "<h3>Editing status.... </h3><br />";
		echo $form->printOut();
		echo "</p>";
		
	} elseif (isset($_GET['del'])) {

		$delete_id = $_GET['del'];
		$sql_op = new simbio_dbop($dbs);
		if ($delete_id <= 0) {
			echo '<script type="text/javascript">alert(\'Error. No data can be deleted.\');</script>';
		} else {
			$delete = $sql_op->delete('kontrak_flow', 'idkontrak_flow='. $delete_id);
			if ($delete) {
				echo '<script type="text/javascript">alert(\'Data dihapus!.\');</script>';
			} else {
				echo '<script type="text/javascript">alert(\'Error.\');</script>';
			}
		}
	
	} else {
	
		// Menu Nav
	?>
		<p align="right">
		<a href='../list.php'>Project List</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_step.php'>Tahapan Kontrak</a>&nbsp;&nbsp;|&nbsp;
		<a href='kontrak_set.php'>Kontrak Set</a>&nbsp;
		<span align='right'><form method='get'>
		<input type='text' name='find'>
		<input type='submit' value='Search'>
		</form></span>
		</p>
		<p><h2>Detil Tahapan-tahapan dalam Kontrak sebuah Proyek</h2></p>
	<?php

	if (isset($_GET['find']) AND !empty($_GET['find'])) {
		$cari = $_GET['find'];
	}

    // table spec
    $table_spec = 'kontrak_flow AS kf LEFT JOIN ref_kontrak AS rk ON kf.idref_kontrak=rk.idref_kontrak 
		LEFT JOIN proj_flow as pf ON kf.idproj_flow = pf.idproj_flow 
		LEFT JOIN project_profile as p ON pf.idproject_profile = p.idproject_profile
		LEFT JOIN kontraktor as k ON k.idkontraktor=kf.idkontraktor
		LEFT JOIN perusahaan as pt ON pt.idperusahaan=k.idperusahaan';

    // create datagrid
    $datagrid = new simbio_datagrid();
	if (isset($_GET['list'])) {
		$datagrid->setSQLCriteria('pf.idproject_profile='.$_GET['list']);
	}

    $datagrid->setSQLColumn('kf.idproj_flow', 'p.nama', 'pt.nama as Kontraktor', 'rk.detil_status, kf.tgl_rencana, kf.status',
		'concat("<a href=\'kontrak_list.php?id=", kf.idkontrak_flow, "\'>Edit</a>&nbsp;|&nbsp;", 
		"<a href=\'kontrak_list.php?del=", kf.idkontrak_flow, "\'>Delete</a>&nbsp;|&nbsp;",
		"<a href=\'../keuangan/termin_bayar.php?id=", kf.idkontrak_flow, "\'>Pembayaran</a>") AS \'Tahapan Kontrak\'');

	$datagrid->setSQLgroup('kf.idkontrak_flow');
	$datagrid->setSQLorder('kf.idkontrak_flow ASC');
	if (isset($cari)) {
		$datagrid->setSQLCriteria('rk.detil_status LIKE "%'.$cari.'%" OR p.nama LIKE "%'.$cari.'%" OR pt.nama LIKE "%'.$cari.'%"');
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
