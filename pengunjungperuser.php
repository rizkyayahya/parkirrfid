<?php 

require "template.php";

$id_card = $_GET["id_card"];
$Nama    = $_GET["Nama"];

if(isset($_GET["Tanggal1"]) AND isset($_GET["Tanggal2"])){
  $Tanggal1  = $_GET["Tanggal1"];
  $Tanggal2  = $_GET["Tanggal2"];
  
}
else{
  $Tanggal1  = date("Y-m-d");
  $Tanggal2  = date("Y-m-d");
}

$data = query("SELECT * FROM tb_pengunjung WHERE id_card = '$id_card' AND  Tanggal BETWEEN '$Tanggal1' AND '$Tanggal2' ORDER BY no DESC");

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
   <center>
 	<h3>REKAMAN PARKIR</h3>
  <h5>ID Card: <?=$id_card?></h5>

 	
     <div class="row mt-4 mb-3 mx-1">
        <div class="col">
            <button type="button" class="tambah btn btn-danger" href="#tambahanggota" data-toggle="modal"data-target="#filter"><i class="fa fa-calendar"></i> Filter Tanggal</button>
        </div>
      <div class="col">
          <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download"></i> Export Data
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="pdf/pdfpengunjungperuser.php?id_card=<?=$id_card;?>&Nama=<?=$Nama;?>&Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-pdf"></i> Export to PDF</a>
                  <a class="dropdown-item" href="excel/excelpengunjungperuser.php?id_card=<?=$id_card;?>&Nama=<?=$Nama;?>&Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-excel"></i> Export to Excel</a>
                </div>
             </div>
      </div>
    </div>

<div class="table-responsive-sm">
  <table class="table table-bordered table-striped" style="width:80rem;">
   <tr class="text-center text-white" style="background-color:#2d82b5"> 
   <td>No.</td>
   <td>Tanggal</td>
   <td>Jam Masuk</td>
   <td>Jam Keluar</td>
   <td>Durasi</td>
   <td>Kendaraan</td>
   <td>Tarif</td>
   
   </tr>
		<?php 
		     $i =1;
		     foreach ($data as $pengunjung) :
		       $id_kendaraan  = $pengunjung["id_kendaraan"];
		       $tgl_diff      = strtotime($pengunjung["Tanggal"]); //Konversi Tanggal ke detik
		       $tgl           = date("d F Y", $tgl_diff); //konversi detik jadi tanggal format d F Y
		       $Masuk         = date("H:i:s", $pengunjung["Masuk"]); //konversi detik ke jam -> Masuk
		       $Keluar        = date("H:i:s", $pengunjung["Keluar"]); //konversi detik ke jam -> Keluar
		       $durasi_diff   = $pengunjung["Keluar"] - $pengunjung["Masuk"];
		       $Durasi        = date("H:i:s", $durasi_diff - $det); //konversi detik ke jam -> Durasi
		       $datakendaraan = query("SELECT * FROM tb_tarif WHERE id_kendaraan = '$id_kendaraan'");
		?> 
   <tr>
   <td class="text-center"><?= $i; ?></td>
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
      <form method="get" action="pengunjungperuser.php">
          <span>Tanggal Awal</span>
      <input type="date" name="Tanggal1"><br><br>
      <span>Tanggal Akhir</span>
      <input type="date" name="Tanggal2">
      <input type="text" name="id_card" value="<?=$id_card;?>" hidden>
      <input type="text" name="Nama" value="<?=$Nama;?>" hidden>
      
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