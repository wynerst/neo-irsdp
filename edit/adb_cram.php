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
	$id = $_GET['p'];
} elseif (isset($_POST['proj'])) {
	$projid = $_POST['proj'];
}
if (isset($_GET['s'])) {
	$statid = $_GET['s'];
} elseif (isset($_POST['stat'])) {
	$statid = $_POST['stat'];
}
if (isset($_GET['find']) AND !empty($_GET['find'])) {
	$cari = $_GET['find'];
}


// ini akan terjadi saat submit
if (isset($_POST['simpanData'])) {

	if (!empty($_POST['tgl'])) {
		unset($data);

		$sql_findid = 'SELECT rspp.idstatusproject FROM ref_status_project_profile AS rspp
			LEFT JOIN proj_flow AS pf ON pf.idproj_flow = rspp.idref_status
			WHERE rspp.idproject_profile = '. $projid . ' AND pf.idref_status =' . $statid;

		$query_id = $dbs->query($sql_findid);
		if ($query_id->num_rows > 0) {
			while ($foundid = $query_id->fetch_assoc()) {

				$update_this = $foundid['idstatusproject'];
				$data['tgl_akhir'] = $_POST['tgl'];
				$data['tgl_revisi'] = date('Y-m-d');
				// lakukan pemrosesan update data...
				$sql_op = new simbio_dbop($dbs);
				$update = $sql_op->update('ref_status_project_profile', $data, 'idstatusproject='.$update_this);
				if ($update) {
					$messages .= 'Data tanggal (id:'. $update_this . ') diperbaiki!<br />';
				} else {
					$messages .= '<script type="text/javascript">alert(\'Error update.\');</script>';
				}
			}
			$messages .= '<br /><a href="../index.php/petugas/adb_report_pac/' . $projid . '" target="blank">Lihat laporan CRAM</a><br />';
		} else {
			$messages .= 'TIDAK ADA data status tahapan proyek. RE-CREATE tabel proyek lebih dahulu!';
		}
	} else {
		$messages .= 'Tanggal isi TIDAK BOLEH KOSONG!';
	}
}

	// table spec
	$table_spec = 'lap_monitor as l LEFT JOIN ref_status as rs ON rs.idref_status = l.idref_status
		LEFT JOIN project_profile as pp ON pp.idproject_profile = l.idproject_profile';

    // create datagrid
	
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('pp.nama, rs.kode_status, l.tgl_batas, l.hari_kerja, l.hari_kalender,
	concat("<form method=\"post\"><input name=\"tgl\" type=\"text\"><input name=\"simpanData\" type=\"submit\" value=\"SET tgl\">",
	"<input type=\"hidden\" name=\"proj\" value=\"", l.idproject_profile, "\">",
	"<input type=\"hidden\" name=\"stat\" value=\"", l.idref_status, "\">", "</form>") as Achieved_date');
	if (isset($projid)) {
		$datagrid->setSQLCriteria('l.idproject_profile = '. $projid);
	} elseif (isset($id)) {
		$datagrid->setSQLCriteria('l.idproject_profile = '. $id);
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
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec);

// Menu Nav
?>
<p align="right">
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
<a href='adb_cram.php'>Tgl pencapaian</a>&nbsp;&nbsp;|
<span align='right'><form method='get'>
<input type='text' name='find'>
<input type='submit' value='Search'>
</form></span>
</p>
<?php
echo "<p id='content'>";
echo $messages;
echo $datagrid_result;
echo "</p>";
?>
</body>
</html>