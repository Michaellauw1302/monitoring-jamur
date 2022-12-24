<?php 
//koneksi
$konek = mysqli_connect("localhost","root","","dbmultisensor");

//baca data dari esp32
$suhu = $_GET['suhu']; //suhu itu diambil dari koding arduino http
$tanah = $_GET['tanah'];
$ph = $_GET['ph'];
$kel_tanah = $_GET['kel_tanah'];
//tambah $ph jika sudah ada

//simpan ke tabel datasensor
//setting auto increment = 1 / mengembalikan id menjadi 1 jika dikosongkan
mysqli_query($konek, "ALTER TABLE sensordata AUTO_INCREMENT=1");
//simpan data sensor ke tabel datasensor
$simpan = mysqli_query($konek, "insert into multisensor(suhu,tanah,ph,kel_tanah)values('$suhu','$tanah','$ph','$kel_tanah')");

//uji simpan untuk memberikan respon
if($simpan)
	echo "Berhasil dikirim";
else
	echo "Gagal dikirim";
 ?>