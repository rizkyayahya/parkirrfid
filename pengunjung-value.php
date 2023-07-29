<?php 

    require "koneksidb.php";

    $date = date("Y-m-d");
    $datapengunjung = query("SELECT * FROM tb_pengunjung WHERE Tanggal = '$date' ORDER BY no DESC");


 ?>

 <!DOCTYPE html>
 <html>
 <head>
  <title></title>
  <!--  -->
 </head>
 <body>

<div class="table-responsive-sm">
<table class="table table-bordered table-striped table-hover" style="width:80rem;">
   <tr class="text-center text-white" style="background-color:#2d82b5"> 
   <td>No.</td>
   <td>Nama Pengunjung</td>
   <td>Tanggal</td>
   <td>Jam Masuk</td>
   <td>Jam Keluar</td>
   <td>Durasi</td>
   <td>Kendaraan</td>
   <td>Tarif</td>
   <td>Status</td>
   
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

       $diff = time() - $pengunjung["Masuk"];

       $datatarif    = query("SELECT * FROM tb_tarif WHERE id_kendaraan = '$id_kendaraan'")[0];

        if ($diff <= 3600){ // 0 - 1 jam
          $tarif = $datatarif["tarif_1"];
        }
        else if($diff > 3600 AND $diff <= 7200){ // 1 - 2 jam
          $tarif = $datatarif["tarif_2"];
        }
        else if($diff > 7200 AND $diff <= 10800){ // 2 - 3 jam
          $tarif = $datatarif["tarif_3"];
        }
        else if($diff > 10800 AND $diff <= 86400){ // 3 - 24 jam
          $jam   = ($diff - 10800)/3600;
          $tarif = $datatarif["tarif_3"] + (ceil($jam) * $datatarif["tarif_4"]); 
        }
        else if($diff > 86400) { // > 24 jam
           $selisih  = date_diff(date_create(), date_create($pengunjung["Tanggal"].date("H:i:s")));
           $waktu    = $selisih->h.":".$selisih->i.":".$selisih->s;
           $hari     = $diff/86400;
           $tarif    = (floor($hari)*$datatarif["tarif_5"]) + ($selisih->h*$datatarif["tarif_4"]);
        }
    
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
         $status = '<td class="text-center text-danger">Proses</td>';
         echo '<td class="text-center">00:00:00</td>
               <td class="text-center">'.date("H:i:s", $diff - $det).'</td>';
       }
       else{
         $status = '<td class="text-center text-success">Selesai</td>';
         echo '<td class="text-center">'.$Keluar.'</td>
               <td class="text-center">'.$Durasi.'</td>';
       }
  
         foreach ($datakendaraan as $kendaraan) {
            echo '<td class="text-center">'.$kendaraan["Kendaraan"].'</td>';
         }

       if ($pengunjung["Tarif"] == 0) {
        echo '<td class="text-center">Rp. '.number_format($tarif).'</td>';
       }
       else{
         echo '<td class="text-center">Rp. '.number_format($pengunjung["Tarif"]).'</td>';
       }
       echo $status;
    ?>
    
   </tr>
   <?php $i++; ?>
   <?php endforeach; ?>

</table>
</div>


 
 </body>
 </html>