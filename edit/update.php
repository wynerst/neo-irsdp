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
</body>
<?php

// file sysconfig sebaiknya berada di paling atas kode
require 'sysconfig.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

/* MYSQLI */
// kalo mau bikin koneksi database baru
// uncomment line di bawah ini
// $dbs2 = @new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
// if (mysqli_connect_error()) {
//     die('<div style="border: 1px dotted #FF0000; color: #FF0000; padding: 5px;">Error Connecting to Database. Please check your configuration</div>');
// }

if (!isset($_GET['id'])) {
	echo 'Tidak bisa dilanjutkan tanpa data lengkap proyek';
	die();
} else {

?>
<p align="right">
<a href='new-proj.php'>New Project</a>&nbsp;&nbsp;|
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
</p>
<?php

	$idset = $_GET['id'];
	$q_last = $dbs->query('SELECT last_idref_status, prafs_tender, trans_tender FROM project_profile WHERE idproject_profile ='.$idset);

	$r_last = $q_last->fetch_assoc();
	$d_last = $r_last['last_idref_status'];
	$prafs_tender = $r_last['prafs_tender'];
	$trans_tender = $r_last['trans_tender'];

	if ($d_last ==0) {
		echo "<p align='center'><span style='color: red; font-size: 14px; font-weight:bold;'>Tidak ada status terakhir proyek untuk dijadikan batas awal!!</span><br />";
		echo "<a href='javascript:history.back()'>Kembali ke halaman sebelumnya</a></p>";
		die();
	}

	// initialize class modifikasi data
	$sql_op = new simbio_dbop($dbs);

	//cek jika project flow table sudah terisi data proyek.
	$q_exist = $dbs->query('SELECT * FROM proj_flow WHERE idproject_profile='.$idset);
	$jumlah_hasil_temuan = $q_exist->num_rows;
	if ($jumlah_hasil_temuan >1) {
		if ($sql_op->delete('proj_flow', "idproject_profile=$idset")) {
			echo 'Delete Proyek flow data berhasil <br />';
		} else {
			echo 'Delete Proyek flow data GAGAL <br />';
		}
		if ($sql_op->delete_query('ps.*', 'proj_flow_status AS ps LEFT JOIN proj_flow AS pf ON pf.idproj_flow = ps.idproj_flow', "pf.idproject_profile = $idset")) {
			echo 'Delete Proyek-flow Status data berhasil <br />';
		} else {
			echo 'Delete Proyek-flow Status data GAGAL <br />';
		}
		if ($sql_op->delete_query('rfs.*', 'ref_status_project_profile AS rfs LEFT JOIN proj_flow AS pf ON pf.idproj_flow = rfs.idref_status', "pf.idproject_profile = $idset")) {
			echo 'Delete Reference Proyek-flow Status data berhasil <br />';
		} else {
			echo 'Delete Reference Proyek-flow Status data GAGAL <br />';
		}
		$sql_tmp = 'cerita LEFT JOIN ref_status_project_profile AS rfs ON rfs.idstatusproject = cerita.idproj_flow';
		if ($sql_op->delete_query('cerita.*', $sql_tmp, "rfs.idproject_profile = $idset")) {
			echo 'Delete Cerita Proyek-flow Status data berhasil <br />';
		} else {
			echo 'Delete Cerita Proyek-flow Status data GAGAL <br />';
		}
		
	}
	
	$proj_flow['idproject_profile']= $idset;
	$proj_flow['kegiatan']="";
	$proj_flow['tgl_rencana']=date('Y-m-d H:i:s');
	$proj_flow['pic']="0";
	$proj_flow['status']="on going";
	$proj_flow['idref_status']=$d_last;

//PROJ FLOW update last data 
	$insert = $sql_op->insert('proj_flow', $proj_flow);

	//update table proj_flow
	do {
	$q_steps = $dbs->query('SELECT idref_status FROM ref_status WHERE next_step ='.$d_last);
	$next_steps = $q_steps->num_rows;
		if ($next_steps >0) {
			$r_steps = $q_steps->fetch_assoc();
			$d_steps = $r_steps['idref_status'];
			$proj_flow['status']="done";
			$proj_flow['idref_status']=$d_steps;
			//echo 'Langkah berikut: ' . $d_steps . '<br />';
			$insert = $sql_op->insert('proj_flow', $proj_flow);
			if ($d_steps == 5) {
				$d_steps = 4;
				$proj_flow['idref_status']=4;
				$insert = $sql_op->insert('proj_flow', $proj_flow);
			} elseif ($d_steps == 49) {
				$d_steps = 4;
				$proj_flow['idref_status']=4;
				$insert = $sql_op->insert('proj_flow', $proj_flow);
			} elseif ($d_steps == 86) {
				$d_steps = 85;
				$proj_flow['idref_status']=85;
				$insert = $sql_op->insert('proj_flow', $proj_flow);
			} elseif ($d_steps == 131) {
				$d_steps = 85;
				$proj_flow['idref_status']=85;
				$insert = $sql_op->insert('proj_flow', $proj_flow);
			}
			if ($d_steps == 82) {
				if ($prafs_tender == 0) {
					echo '<script type="text/javascript">alert(\'Project stops abnormal for PRAFS Tender type!\');</script>';
					$d_last = 1;
				} elseif ($prafs_tender == 2) {
					$d_last = 81;
					$proj_flow['idref_status']=81;
					$insert = $sql_op->insert('proj_flow', $proj_flow);
				} elseif ($prafs_tender == 1) {
					$d_last = 48;
					$proj_flow['idref_status']=48;
					$insert = $sql_op->insert('proj_flow', $proj_flow);
				}
			} elseif ($d_steps == 165) {
				if ($trans_tender == 0) {
					echo '<script type="text/javascript">alert(\'Project stops abnormal for TRANSCATION Tender type!\');</script>';
					$d_last = 1;
				} elseif ($trans_tender == 2) {
					$d_last = 164;
					$proj_flow['idref_status']=164;
					$insert = $sql_op->insert('proj_flow', $proj_flow);
				} elseif ($trans_tender == 1) {
					$d_last = 130;
					$proj_flow['idref_status']=130;
					$insert = $sql_op->insert('proj_flow', $proj_flow);
				}
			} else {
				$d_last = $d_steps;
			}
		}
	//echo $d_last . '<br />';
	} while ($d_last >1);

	//echo "<a href='update_status.php?id=".$idset."'>Next steps update</a>";	

//PROJECT FLOW STATUS update table proj_flow_status
	$query1 = $dbs->query('SELECT * FROM proj_flow WHERE idproject_profile='.$idset);

	$jumlah_hasil_temuan = $query1->num_rows;

	$proj_status['status']="done";
	$proj_status['idpic']=1;
	$id_petugas = "Petugas PAS";

	$ref_stat_project['idproject_profile']=$idset;
	$ref_stat_project['tgl_mulai']=date('Y-m-d H:i:s');
	$ref_stat_project['tgl_akhir']=date('Y-m-d H:i:s');
	$ref_stat_project['status_akhir']="done";
	$ref_stat_project['tgl_diisi']=date('Y-m-d H:i:s');
	$ref_stat_project['tgl_revisi']=date('Y-m-d H:i:s');
	$ref_stat_project['idoperator']=1;

	//$sql_op = new simbio_dbop($dbs);
	// looping  project Status
	while ($record = $query1->fetch_assoc()) {

	// Real Update PROJ_FLOW_STATUS table project_flow
		$proj_status['idproj_flow']= $record['idproj_flow'];
		$insert = $sql_op->insert('proj_flow_status', $proj_status);
		echo 'Update step proj_flow_status ' . $record['idproj_flow'] . ', ' . $id_petugas .'<br />';

	//Real UPDATE table ref_status_proj_profile
		$ref_stat_project['idref_status']=$record['idproj_flow'];
		$insert = $sql_op->insert('ref_status_project_profile', $ref_stat_project);
		echo 'Update step ref_status_project_profile ' . $record['idproj_flow'] . ', ' . $id_petugas .'<br />';
		if ($proj_status['idpic']==1) {
			$proj_status['idpic']=3;
			$ref_stat_project['idoperator']=3;
			$id_petugas = "Petugas TAS";
		} else {
			$proj_status['idpic']=1;
			$ref_stat_project['idoperator']=1;
			$id_petugas = "Petugas PAS";
		}
		$insert = $sql_op->insert('proj_flow_status', $proj_status);
		echo 'Update step proj_flow_status ' . $record['idproj_flow'] . ', ' . $id_petugas .'<br />';
		$insert = $sql_op->insert('ref_status_project_profile', $ref_stat_project);
		echo 'Update step ref_status_project_profile' . $record['idproj_flow'] . ', ' . $id_petugas .'<br />';
	}

// UPDATE Cerita
// idcerita 	idproj_flow 	tgl_cerita 	deskripsi 	follow_up 	idpic 	idstatuskontrak
	$cerita['tgl_cerita']= date('Y-m-d');
	$cerita['deskripsi']= "Step - admin auto initialized.";
	$cerita['follow_up']= "PAS begin -auto check administrative requirement";
	$cerita['idstatuskontrak']= 0;	
	$id_petugas = "Petugas PAS";
	
	$q_cerita = $dbs->query('SELECT idstatusproject, idoperator FROM ref_status_project_profile WHERE idproject_profile ='. $idset);
	while ($r_cerita = $q_cerita->fetch_assoc()) {
		$cerita['idproj_flow']= $r_cerita['idstatusproject'];
		$cerita['idpic']= $r_cerita['idoperator'];
		if ($cerita['idpic']==1) {
			$id_petugas = "Petugas PAS";
			$cerita['deskripsi']= "Step - admin auto initialized.";
			$cerita['follow_up']= "PAS begin -auto check administrative requirement";
		} else {
			$id_petugas = "Petugas TAS";
			$cerita['deskripsi']= "Step - technical auto initialized.";
			$cerita['follow_up']= "TAS begin -auto check technical requirement";
		}
		$insert = $sql_op->insert('cerita', $cerita);
		echo 'Update stories ' . $r_cerita['idstatusproject'] . ', ' . $id_petugas .'<br />';
	}
	
}
// Menu Nav
?>
<p align="right">
<a href='new-proj.php'>New Project</a>&nbsp;&nbsp;|
<a href='list.php'>Project List</a>&nbsp;&nbsp;|
</p>

</body>
</html>