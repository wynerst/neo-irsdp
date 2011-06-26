<?php
/
// file sysconfig sebaiknya berada di paling atas kode
require 'sysconfig.inc.php';

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
