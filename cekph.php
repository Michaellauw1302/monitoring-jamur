<!-- kodingan untuk membaca data  PH  air dari database -->
<?php
error_reporting();
//koneksi database
$konek = mysqli_connect("localhost", "root", "", "dbmultisensor");

//baca data dari tabel datasensor
$sql = mysqli_query($konek, "select * from multisensor order by id desc"); //data terbaru yang tampil
$data = mysqli_fetch_array($sql);
$ph = $data['ph'];

//uji apabila nilai suhu belum ada, maka anggap suhu itu = 0
if ($ph == "") $ph = 0;
echo $ph;
