<!-- kodingan untuk membaca data kelembaban tanah pada database -->
<?php
error_reporting();
//koneksi database
$konek = mysqli_connect("localhost", "root", "", "dbmultisensor");

//baca data dari tabel datasensor
$sql = mysqli_query($konek, "select * from multisensor order by id desc"); //data terbaru yang tampil
$data = mysqli_fetch_array($sql);
$tanah = $data['tanah'];

//uji apabila nilai suhu belum ada, maka anggap suhu itu = 0
if ($tanah == "") $tanah = 0;
echo $tanah;

if ($tanah <= 3000) {
  echo "
             RH<br>
         <div class='alert alert-primary' role='alert' style='width: 100%; margin-top:2%;'>
              <div style='font-size: 12px;'>
             Tanah masih basah...
              </div>
            </div>
                  
            ";
} else if ($tanah <= 4000) {
  echo "
            RH<br>
         <div class='alert alert-primary' role='alert' style='width: 100%; margin-top:2%;'>
              <div style='font-size: 12px;'>
             Kelembaban tanah masih cukup...
              </div>
            </div>";
} else
  echo "
          RH<br>
         <div class='alert alert-danger' role='alert' style='width: 100%; margin-top:2%;'>
              <div style='font-size: 12px;'>
             Tanah kering, nyalakan pompa...
              </div>
            </div>
    ";
