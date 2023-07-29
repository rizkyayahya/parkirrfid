<?php

require "../koneksidb.php";
session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("location:../index.php");
    exit;
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Transaksi.xls");


$Tanggal1  = mysqli_escape_string($koneksi, $_GET["Tanggal1"]); $Waktu1 = $Tanggal1." 00:00:00";
$Tanggal2  = mysqli_escape_string($koneksi, $_GET["Tanggal2"]); $Waktu2 = $Tanggal2." 23:59:59"; 

$data = query("SELECT * FROM tb_transaksi WHERE Waktu BETWEEN '$Waktu1' AND '$Waktu2'  ORDER BY no DESC");


?>

<!DOCTYPE html>
 <html>
 <head>
  <title></title>
 </head>
 <body>
    <center>
       <h3>DATA TRANSAKSI</h3>
<div class="table-responsive-sm">
<table class="table table-bordered table-hover  table-striped">
     <tr class="text-center text-white"> 
     <th>No.</th>
     <th width="200px">Waktu</th>
     <th>ID Card</th>
     <th>Nama Anggota</th>
     <th>Kredit</th>
     <th>Debet</th>
     <th>Saldo</th>
     <th>Keterangan</th>
     </tr>
  <?php $i =1;?>

  <?php foreach ($data as $transaksi) :
    $id_card     = $transaksi["id_card"];
    $dataanggota = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'");
  ?> 
     <tr>
     <td class="text-center"><?= $i; ?></td>
     <td class="text-center"><?= $transaksi["Waktu"];?></td>
     <td class="text-center"><?= $transaksi["id_card"];?></td>
     <?php
         foreach ($dataanggota as $anggota){ 
            echo '<td class="text-center">'.$anggota["Nama"].'</td>';
          }  
      ?>
     <td class="text-center">Rp. <?= number_format($transaksi["Kredit"]);?></td>
     <td class="text-center">Rp. <?= number_format($transaksi["Debet"]);?></td>
     <td class="text-center">Rp. <?= number_format($transaksi["Saldo"]);?></td>
     <td class="text-center"><?=$transaksi["Ket"];?></td>
     </tr>
     <?php $i++; ?>
    <?php endforeach; ?>

  </table>
</div>
    </center>
 </body>
 </html>