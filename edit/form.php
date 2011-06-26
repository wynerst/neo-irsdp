<?php
/**
 *
 * Contoh penggunaan form
 *
 */

// file sysconfig sebaiknya berada di paling atas kode
require 'sysconfig.inc.php';

// ini akan terjadi saat submit
if (isset($_POST['simpanData'])) {
    // cek validitas form
    $judul = trim($_POST['judul']);
    if (empty($judul)) {
        echo '<script type="text/javascript">alert(\'Maaf!! Maaf! Tapiii Maaf!! Judul-nya ga boleh kosong!\');</script>';
        exit();
    }
    // lakukan pemrosesan form di bawah ini...
    echo '<script type="text/javascript">alert(\'Horeeee Form-nya di-submit loch!!\');</script>';
    exit();
}


// masukan file library form
require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI'.DIRECTORY_SEPARATOR.'form_maker'.DIRECTORY_SEPARATOR.'simbio_form_table_AJAX.inc.php';

// buat instance objek form
$form = new simbio_form_table_AJAX('formUtama', $_SERVER['PHP_SELF'], 'post');

// atribut atribut tambahan
$form->submit_button_attr = 'name="simpanData" value="Simpan" class="button"';
$form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

// tambahkan element form
$form->addTextField('text', 'judul', 'Judul', 'Default Value Text', 'style="width: 100%;"');

// tambahkan element form textarea
$form->addTextField('textarea', 'deskripsi', 'Deskripsi', 'Default Value Textarea', 'style="width: 100%;" rows="3"');

// tambahkan element form password
$form->addTextField('password', 'sandi', 'Kata Sandi', 'Default Value Kata Sandi', 'style="width: 50%;"');

// tambahkan element form file
$form->addTextField('file', 'upload', 'File Upload');

// tambahkan element form tombol
$form->addTextField('button', 'tombol', 'Tombol', 'Jangan Di-Tekan', 'style="border: 1px solid red;" onclick="alert(\'Ngapain Di-TEKAN!!!\')"');

// tambahkan element form radio
$array_radio[] = array('Lk', 'Laki-Laki Tulen');
$array_radio[] = array('Pr', 'Perempuan Beneran');
$array_radio[] = array('Bj', 'Belum Jelas');
$form->addRadio('gender', 'Gender', $array_radio, 'Lk');

// tambahkan element form checkbox
$array_chbox[] = array('1', 'Main PS');
$array_chbox[] = array('2', 'Mancing');
$array_chbox[] = array('3', 'Dipancing');
$array_chbox[] = array('4', 'Bikin Rusuh');
$array_chbox[] = array('5', 'Ribut');
$array_chbox[] = array('6', 'Belajar');
$array_chbox[] = array('7', 'Menabung');
$array_chbox[] = array('8', 'Makan');
$array_chbox[] = array('9', 'Tidur');
$array_chbox[] = array('10', 'Belanja di Mal');
$form->addCheckBox('hobi', 'Hoby', $array_chbox, '2');
// kalo mau multiple
// uncomment di bawah ini
// $form->addCheckBox('hobi', 'Hoby', $array_chbox, array(1, 5, 10));

// tambahkan element form drop down list
$array_dropdown[] = array('1', 'Main PS');
$array_dropdown[] = array('2', 'Mancing');
$array_dropdown[] = array('3', 'Dipancing');
$array_dropdown[] = array('4', 'Bikin Rusuh');
$array_dropdown[] = array('5', 'Ribut');
$array_dropdown[] = array('6', 'Belajar');
$array_dropdown[] = array('7', 'Menabung');
$array_dropdown[] = array('8', 'Makan');
$array_dropdown[] = array('9', 'Tidur');
$array_dropdown[] = array('10', 'Belanja di Mal');
$form->addSelectList('hobilagi', 'Hoby Sampingan', $array_dropdown, '6');
// kalo mau multiple
// uncomment di bawah ini
// $form->addSelectList('hobilagi', 'Hoby Sampingan', $array_dropdown, array(3, 7, 9), 'multiple="multiple"');

// kalo belum puas ini jalan terakhir
$string_isi = 'Hallow';
$form->addAnything('Apa Aja Dech Bisa dimasukin disini', $string_isi);

// output final form
echo $form->printOut();

?>
