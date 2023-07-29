<?php 
require "template.php";

$Tanggal1 = date("Y-m-d");
$Tanggal2 = date("Y-m-d");




?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  	<h3 class="mb-4 mt-2">DATA PENGUNJUNG</h3>
  	

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
          <a class="dropdown-item" href="pdf/pdfpengunjung.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-pdf"></i> Export to PDF</a>
          <a class="dropdown-item" href="excel/excelpengunjung.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-excel"></i> Export to Excel</a>
        </div>
      </div>
    </div>
  </div>

  	<div class="pengunjung-value"></div>

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
      <form method="get" action="pengunjung-filter.php">
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