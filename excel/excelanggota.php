<?php

require "../koneksidb.php";
session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("location:../index.php");
    exit;
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Anggota.xls");

$data = query("SELECT * FROM tb_anggota WHERE Level = 'Anggota' ORDER BY Nama ASC"); 

?>

<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title></title>
    

  </head>
<body>

<!--  -->
  <center>
    <h3>DATA ANGGOTA</h3>


<div class="table-responsive-sm mx-5">
<table class="table table-bordered table-hover table-striped">
   <tr class="text-center"> 
   <th>No.</th>
   <th>ID Card</th>
   <th>ID Chat</th>
   <th>Nama Anggota</th>
   <th width="10px">L/P</th>
   <th>Saldo</th>
   </tr>
<?php $i =1;?>

<?php foreach ($data as $anggota) :?> 
   <tr>
   <td class="text-center"><?= $i; ?></td>
   <td class="text-center"><?= $anggota["id_card"];?></td>
   <td class="text-center"><?= $anggota["id_chat"];?></td>
   <td><?= $anggota["Nama"];?></td>
   <td class="text-center"><?= $anggota["Gender"];?></td>
   <td class="text-center">Rp.<?= number_format($anggota["Saldo"]);?></td>
   
   </tr>
   <?php $i++; ?>
  <?php endforeach; ?>

</table>
</div>

</center>



</body>
</html> 