<?php 
	require "template.php";

if(isset($_GET["Tanggal1"]) AND isset($_GET["Tanggal2"])){
  $Tanggal1  = mysqli_escape_string($koneksi, $_GET["Tanggal1"]); $Waktu1 = $Tanggal1." 00:00:00";
  $Tanggal2  = mysqli_escape_string($koneksi, $_GET["Tanggal2"]); $Waktu2 = $Tanggal2." 23:59:59"; 
}
else if(!isset($_GET["Tanggal1"]) AND !isset($_GET["Tanggal2"])){
  $Tanggal1  = date("Y-m-d"); $Waktu1 = $Tanggal1." 00:00:00";
  $Tanggal2  = date("Y-m-d"); $Waktu2 = $Tanggal2." 23:59:59"; 
}

$data = query("SELECT * FROM tb_transaksi WHERE Waktu BETWEEN '$Waktu1' AND '$Waktu2'  ORDER BY no DESC");


 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  	<h3 class="mb-4 mt-2">DATA TRANSAKSI</h3>
  	

	<div class="row mt-3 mb-3 mx-1">
	      <div class="col">
	          <button type="button" class="tambah btn btn-danger" href="#tambahanggota" data-toggle="modal"data-target="#filter"><i class="fa fa-calendar"></i> Filter Tanggal</button>
	      </div>
	      <div class="col">
	      <!-- Export data -->
	      <div class="dropdown">
	        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download"></i> Export Data
	        </button>
	        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	          <a class="dropdown-item" href="pdf/pdftransaksi.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-pdf"></i> Export to PDF</a>
	          <a class="dropdown-item" href="excel/exceltransaksi.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-excel"></i> Export to Excel</a>
	        </div>
	      </div>
	    </div>
  </div>

	
<div class="table-responsive-sm">
	<table class="table table-bordered table-hover table-striped" style="width:80rem;">
	   <tr class="text-center text-white" style="background-color:#2d82b5"> 
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
	   <td class="text-center"><?= $transaksi["Ket"];?></td>
	   </tr>
	   <?php $i++; ?>
	  <?php endforeach; ?>

	</table>
</div>

  	<!-- Modal Filter Tanggal -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-calendar"></i> FILTER TANGGAL</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><br>
      <form method="get" action="transaksi.php">
      	  <span>Tanggal Awal</span>
			<input type="date" name="Tanggal1"><br><br>
		  <span>Tanggal Akhir</span>
			<input type="date" name="Tanggal2">
		  
      <div class="modal-footer">
        <button type="submit" value="Filter" class="btn btn-success"><i class="fa fa-filter"></i> Filter </button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>


  </center>	

</body>
</html>