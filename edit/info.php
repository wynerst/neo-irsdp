<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	copyright 2011 by Wardiyono
	Quick add and edit data IRSDP applications
-->
<html>
<head>
<title>Detil Info - Quick add/edit</title>
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

if (isset($_POST['simpanData'])) {
    // cek validitas form
    $proyek_id = trim($_POST['proyek_id']);
    $cat_project = trim($_POST['kategori_id']);

	$query1 = $dbs->query('SELECT t.tag FROM template AS t WHERE t.idcategory=' . $cat_project . ' ORDER BY t.tag');

	unset($data);
	$data['proyek_id']= $proyek_id;

	$sql_op = new simbio_dbop($dbs);
	$delete = $sql_op->delete('isian_ruas', 'proyek_id ='. $proyek_id);

	while ($record = $query1->fetch_assoc()) {	
		// cek if tag and value is set
		$tag = $record['tag'];
		$tag_value = $_POST[$tag];
		if (!empty($tag_value)) {
			$data['tag'] = $tag;
			$data['value'] = $tag_value;
		    // lakukan pemrosesan form di bawah ini...
			$insert = $sql_op->insert('isian_ruas', $data);
		    if ($insert) {
			    echo "Tag: $tag updated!<br />";
			} else {
			    echo '<script type="text/javascript">alert(\'Error.\');</script>';
				die();
			}
		}
	}
} else {

	IF (isset($_GET['cat']) and isset($_GET['id'])) {
		$query1 = $dbs->query('SELECT t.tag, r.label, i.value FROM template AS t
			LEFT JOIN daftar_ruas AS r ON t.tag = r.tag
			LEFT JOIN isian_ruas as i ON t.tag = i.tag
			WHERE t.idcategory=' . $_GET['cat'] . ' ORDER BY t.tag');
		if ($query1->num_rows > 0) {

			// buat instance objek form
			$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

			// atribut atribut tambahan
			$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
			$form->reset_button_attr = 'name="Reset" value="Reset" class="button"';
			$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
			$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
			$form->table_content_attr = 'class="alterCell2"';

			while ($record = $query1->fetch_assoc()) {
				$form->addTextField('text', $record['tag'], $record['label'], $record['value'], 'style="width: 100%;"');
			}

			$form->addHidden('proyek_id', $_GET['id']);
			$form->addHidden('kategori_id', $_GET['cat']);

		} else {
			echo 'Data template kategori proyek tidak ditemukan...';
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
		
	} else {
		echo 'Kode proyek dan kategorinya tidak boleh kosong...';

		// Menu Nav
	?>
		<p align="right">
		<a href='new-proj.php'>New Project</a>&nbsp;&nbsp;|
		<a href='list.php'>Project List</a>&nbsp;&nbsp;|
		<a href='kontraktor.php'>New Contractor</a>&nbsp;&nbsp;|
		<a href='list_kontraktor.php'>Contractor List</a>&nbsp;&nbsp;|
		</p>
	<?php

	}
}
?>
</body>
</html>
