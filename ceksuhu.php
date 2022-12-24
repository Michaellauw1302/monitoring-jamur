<!-- kodingan untuk membaca data suhu dari database -->
<?php
error_reporting();
//koneksi database
$konek = mysqli_connect("localhost", "root", "", "dbmultisensor");

//baca data dari tabel datasensor
$sql = mysqli_query($konek, "select * from multisensor order by id desc"); //data terbaru yang tampil
$data = mysqli_fetch_array($sql);
$suhu = $data['suhu'];

//uji apabila nilai suhu belum ada, maka anggap suhu itu = 0
if ($suhu == "") $suhu = 0;
echo $suhu;
// perkondisian jika suhu kurang lebih dari 29.00 maka akan muncul alert suhu panas dan kipas menyala
if ($suhu >= 29.00) {
  echo "
             &#176;C<br>
		 <div class='alert alert-danger' role='alert' style='width: 100%; margin-top:2%;'>
              <div style='font-size: 12px;'>
             Suhu diatas 29&#176;C, suhu panas dan kipas menyala...
              </div>
            </div>
                  
            ";
} else
  echo "
		    &#176;C<br>
		 <div class='alert alert-primary' role='alert' style='width: 100%; margin-top:2%;'>
              <div style='font-size: 12px;'>
             Suhu di bawah 29&#176;C, suhu sejuk...
              </div>
            </div>
		  
";
