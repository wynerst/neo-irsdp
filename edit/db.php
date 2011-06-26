<?php
/**
 * Contoh query ke database
 *
 */


// file sysconfig sebaiknya berada di paling atas kode
require 'sysconfig.inc.php';

/* MYSQLI */
// kalo mau bikin koneksi database baru
// uncomment line di bawah ini
// $dbs2 = @new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
// if (mysqli_connect_error()) {
//     die('<div style="border: 1px dotted #FF0000; color: #FF0000; padding: 5px;">Error Connecting to Database. Please check your configuration</div>');
// }

// contoh query sederhana
$query1 = $dbs->query('SELECT * FROM project_profile');

// hasil temuan query
$jumlah_hasil_temuan = $query1->num_rows;

echo 'Ditemukan hasil : '.$jumlah_hasil_temuan.' judul dokumen ';
echo '<ul>';
// ambil hasil query
// looping
while ($record = $query1->fetch_assoc()) {
    echo '<li>'.$record['nama']."</li><br />\n";
}
echo '</ul>';

?>
