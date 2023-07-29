<?php

require "../koneksidb.php";
session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("location:../index.php");
    exit;
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Pengunjung.xls");

 

$Tanggal1      = mysqli_escape_string($koneksi, $_GET["Tanggal1"]);
$Tanggal2      = mysqli_escape_string($koneksi, $_GET["Tanggal2"]);

$datapengunjung = query("SELECT * FROM tb_pengunjung WHERE Tanggal BETWEEN '$Tanggal1' AND '$Tanggal2' ORDER BY no DESC");

?>

<!DOCTYPE html>
 <html>
 <head>
  <title></title>
 </head>
 <body>
    <center>
       <h3>DATA PENGUNJUNG</h3>
<div class="table-responsive-sm">
<table class="table table-bordered table-striped">
   <tr class="text-center"> 
   <th>No.</th>
   <th>Nama Pengunjung</th>
   <th>Tanggal</th>
   <th>Jam Masuk</th>
   <th>Jam Keluar</th>
   <th>Durasi</th>
   <th>Kendaraan</th>
   <th>Tarif</th>
   
   </tr>
<?php 
     $i =1;
     foreach ($datapengunjung as $pengunjung) :
       $id_card       = $pengunjung["id_card"];
       $id_kendaraan  = $pengunjung["id_kendaraan"];
       $tgl_diff      = strtotime($pengunjung["Tanggal"]); //Konversi Tanggal ke detik
       $tgl           = date("d F Y", $tgl_diff); //konversi detik jadi tanggal format d F Y
       $Masuk         = date("H:i:s", $pengunjung["Masuk"]); //konversi detik ke jam -> Masuk
       $Keluar        = date("H:i:s", $pengunjung["Keluar"]); //konversi detik ke jam -> Keluar
       $durasi_diff   = $pengunjung["Keluar"] - $pengunjung["Masuk"];
       $Durasi        = date("H:i:s", $durasi_diff - $det); //konversi detik ke jam -> Durasi
       $dataanggota   = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'");
       $datakendaraan = query("SELECT * FROM tb_tarif WHERE id_kendaraan = '$id_kendaraan'");
?> 
   <tr>
   <td class="text-center"><?= $i; ?></td>
     <?php 
         foreach ($dataanggota as $anggota) {
           echo '<td>'.$anggota["Nama"].'</td>';
         }
      ?>
   <td class="text-center"><?= $tgl;?></td>
   <td class="text-center"><?= $Masuk;?></td>
    <?php   
       if ($pengunjung["Keluar"] == 0) {
         echo '<td class="text-center">00:00:00</td>
               <td class="text-center">00:00:00</td>';
       }
       else{
         echo '<td class="text-center">'.$Keluar.'</td>
               <td class="text-center">'.$Durasi.'</td>';
       }
  
         foreach ($datakendaraan as $kendaraan) {
            echo '<td class="text-center">'.$kendaraan["Kendaraan"].'</td>';
         }
    ?>
   <td class="text-center">Rp. <?= number_format($pengunjung["Tarif"]);?></td>
   </tr>
   <?php $i++; ?>
   <?php endforeach; ?>

</table>
</div>
    </center>
 </body>
 </html>