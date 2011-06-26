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
require 'sysconfig.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';


if (isset($_GET['id'])) {
	$proyek = $_GET['id'];
}

$query_adb='SELECT l.idlap_monitor, l.idref_status, l.hari_kerja, l.tgl_batas, l.hari_kalender, rspp.tgl_mulai, rspp.tgl_akhir,
 datediff(rspp.tgl_akhir, l.tgl_batas) as \'Days\', sum(datediff(rspp.tgl_akhir, l.tgl_batas)) as \'Cummulative\', r.detil_status
FROM cerita AS c
LEFT JOIN ref_status_project_profile AS rspp ON c.idproj_flow = rspp.idstatusproject
LEFT JOIN proj_flow_status AS pfs ON pfs.idproj_flow = rspp.idref_status
LEFT JOIN proj_flow AS pf ON pf.idproj_flow = pfs.idproj_flow
LEFT JOIN lap_monitor AS l ON l.idproject_profile = pf.idproject_profile
LEFT JOIN ref_status AS r ON l.idref_status = r.idref_status ';

$query_WHERE = 'WHERE (rspp.idproject_profile = pf.idproject_profile ) AND (pf.idref_status = l.idref_status) ';
$query_GROUP = ' GROUP BY l.idlap_monitor';

?>
<p align="right">
<a href='list.php'>Project List</a>&nbsp;
</p>
<p align ="center">
<?php

if (isset($proyek)) {
	$final_q = $query_adb . $query_WHERE . 'AND l.idproject_profile = '. $proyek . $query_GROUP;
	
	$proj_query = "SELECT * FROM project_profile WHERE idproject_profile=". $proyek;
	$info_query = "SELECT t.label, i.value FROM isian_ruas AS i
		LEFT JOIN daftar_ruas as t on i.tag=t.tag WHERE i.proyek_id=" .$proyek. " AND SUBSTR(i.tag,1,2) = '00'";
	$profile = $dbs->query($proj_query);
	echo '<table border = "1"><tr><td>';
	echo '<table cellpadding="5px">';
	
	while ($rec = $profile->fetch_assoc()) {
		echo "<tr><td>Title:</td><td>" . $rec['nama']. "</td></tr>";
		echo "<tr><td>PIN</td><td>" . $rec['pin']. "</td></tr>";
		echo "<tr><td>Selection Methods:</td><td>&nbsp;</td></tr>";
		$info = $dbs->query($info_query);
		while ($inf = $info->fetch_assoc()) {
			echo "<tr><td>".$inf['label']."</td><td>".$inf['value']."</td></tr>";
		}
	}
	echo '</table></td></tr></table>';

} else {	$final_q = $query_adb . $query_WHERE . $query_GROUP;
}
$cummulative=0;
$deviasi_hari=0;
$dev_cumulative=0;


echo '<table border=\'1\' cellpadding=\'3px\'>';

echo '<tr>';
echo '<th colspan=\'2\' rowspan=\'2\'>Activity</th>';
echo '<th >Norm</th>';
echo '<th colspan=\'2\'>Planned</th>';
echo '<th colspan=\'3\'>Actual</th>';
echo '<th colspan=\'2\'>Deviation</th>';
echo '<th rowspan=\'2\'>&nbsp;Explaination and Action&nbsp;</th>';
echo '</tr>';
echo '<tr>';
echo '<th >&nbsp;Calendar Days&nbsp;</th>';
echo '<th >Dates</th>';
echo '<th >&nbsp;Calendar Days&nbsp;</th>';
echo '<th >&nbsp;Achieved Date&nbsp;</th>';
echo '<th >Days</th>';
echo '<th >&nbsp;Cummulative Days&nbsp;</th>';
echo '<th >&nbsp;Days&nbsp;</th>';
echo '<th >&nbsp;Cummulative Days&nbsp;</th>';
echo '</tr>';

$report = $dbs->query($final_q);
if ($report->num_rows > 0) {

	while ($record = $report->fetch_assoc()) {
		$cummulative += $record['Days'];
		$deviasi_hari = $record['Days'] - $record['hari_kalender'];
		$dev_cumulative += $deviasi_hari;
		echo '<tr align=\'center\'>';
		echo '<td>'.$record['idlap_monitor'].'</td>';
		echo '<td align=\'left\'>'.$record['detil_status'].'</td>';
		echo '<td>'.$record['hari_kerja'].'</td>';
		echo '<td>'.$record['tgl_batas'].'</td>';
		echo '<td>'.$record['hari_kalender'].'</td>';
		echo '<td>'.$record['tgl_akhir'].'</td>';
		echo '<td>'.$record['Days'].'</td>';
		echo '<td>'.$cummulative.'</td>';
		echo '<td>'.$deviasi_hari.'</td>';
		echo '<td>'.$dev_cumulative.'</td>';
		echo '<td>&nbsp;</td>';
	    echo '</tr>';
	}
} else {
	echo '<tr><td colspan=\'11\'>No Report</td></tr>';
}

echo '</table>';
// Menu Nav
?>
</p>
</body>
</html>