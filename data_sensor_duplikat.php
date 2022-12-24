<!-- kodingan untuk halaman dashboard -->
<?php
// session start merupakan kodingan untuk mengaktifkan session 
session_start();
// perkondisian jika session tidak sama dengan name maka kana dalihkan kembali ke halaman index
if (!isset($_SESSION['name'])) { // handling if dont'have session

  header('location:../index.php');
  exit();
}
// jika sassion == name maka akan dialihkan kehalaman datasensor
$name = $_SESSION['name'];
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <title>MONITORING MULTISENSOR </title>

  <script type="text/javascript" src="jquery/jquery.min.js"></script>
  <!-- kodingan untuk meload data secara otomatis berbentuk javascript -->
  <script type="text/javascript">
    $(document).ready(function() {

      setInterval(function() {
        $('#ceksuhu').load("ceksuhu.php");
        // bikinkan file kelembaban cekkelembabanudara.php
        $('#cekkelembabanudara').load("cekkelembabanudara.php");
        $('#cektanah').load("cektanah.php");
        $('#cekph').load("cekph.php");
        $('#cekkeltanah').load("cekkeltanah.php");
      }, 1000);
    });
  </script>

</head>

<body style="background: floralwhite; mt-5">
  <div class="container mt-5 mb-5" style="text-align: center; margin-top: 10px; margin-right:20px;">

    <div class="card-header mb-5" style="text-align:center; margin-right:100px;">
      <h2 class="fw-bold text-primary">Monitoring Data Suhu, Kelembaban, dan PH Secara Realtime</h2>
    </div>
    <div style="display: flex; margin-top:10px; margin-right:100px; mt-5 ">

      <!-- menampilkan suhu -->
      <div class="card text-center " style="width: 50%">
        <div class="card-header" style="font-size: 20px; font-weight: bold; background-color: greenyellow;">
          Suhu Udara
        </div>
        <div class="card-body">
          <h1><span id="ceksuhu"> 0 </span> </h1>
        </div>
      </div>
      <!-- akhir nilai suhu -->

      <!-- menampilkan kelembaban tanah -->
      <div class="card text-center" style="width: 50%">
        <div class="card-header" style="font-size: 20px; font-weight: bold; background-color: orangered; color:white;">
          Kelembaban Udara
        </div>
        <div class="card-body">
          <h1><span id="cekkelembabanudara"> 0 </span> </h1>
        </div>
      </div>
      <!-- akhir nilai kelembaban tanah -->

      <!-- menampilkan kel tanah -->
      <div class="card text-center" style="width: 50%">
        <div class="card-header" style="font-size: 20px; font-weight: bold; background-color: orangered; color:white;">
          Kelembaban Tanah
        </div>
        <div class="card-body">

          <h1><span id="cekkeltanah"> 0 </span> </h1>
        </div>
      </div>
      <!-- akhir nilai kel tanah -->

      <!-- menampilkan kelembaban ph-->
      <div class="card text-center" style="width: 50%">
        <div class="card-header" style="font-size: 20px; font-weight: bold; background-color:skyblue; color:black;">
          Nilai PH
        </div>
        <div class="card-body">
          <h1><span id="cekph"> 0 </span> </h1>
        </div>
      </div>
      <!-- akhir nilai kelembaban ph -->

    </div>
    <!-- Opsional saja -->
    <div style="display: flex; margin-top:2px; margin-right:100px;">
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
      </svg>

      <div class="alert alert-primary d-flex align-items-center mt-5" role="alert" style="width: 50%">

        <div>
          Jika suhu >= 29.00 &#176;C, maka kipas angin akan menyala
        </div>
      </div>

      <div class="alert alert-primary d-flex align-items-center mt-5" role="alert" style="width: 50%">

        <div>
          Jika kelembaban tanah <=3000, Maka tanah masih basah<br>
            Jika kelembaban tanah <=4000, maka tanah masih cukup lembab<br>
              Selain nilai itu maka tanah kering dan air akan ditambahkan ke baglog
        </div>
      </div>

    </div>

    <div class="card-header" style="text-align:center; margin-right:100px;">
      <!-- <h2>FATMAWATI | NIM : 1810530208 | PROGRAM STUDI ILMU KOMPUTER | STMIK BUMIGORA MATARAM</h2> -->
      <a href="main_pages/index.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>


    <!--<div class="container" style="align-content: center; width:540px; margin-top:2px; background-color: seagreen; margin-right:330px;">
          <div class="card mb-3" style="max-width: 540px; align: center;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="" class="img-fluid rounded-start" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">FATMAWATI</h5>
                  <p class="card-text">NIM : 1234567890. JURUSAN : TEKNIK KOMPUTER DAN JARINGAN</p>
                  <p class="card-text"><small class="text-muted">STMIK BUMIGORA MATARAM</small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
         Batas akhir konten opsional -->



  </div>











  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>