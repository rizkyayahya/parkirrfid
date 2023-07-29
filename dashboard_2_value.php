<?php 

require "koneksidb.php";

session_start();

$id_card = $_SESSION["id_card"];
$date    = date("Y-m-d");

$data    = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];
$kredit  = query("SELECT * FROM tb_transaksi WHERE id_card = '$id_card' AND Kredit > 0 
           ORDER BY no DESC")[0];

if (isset(query("SELECT * FROM tb_slot WHERE id_card = '$id_card'")[0])) {
  $dataslot = query("SELECT * FROM tb_slot WHERE id_card = '$id_card'")[0];
  $lokasi   = $dataslot["id_slot"];
}
else{
   $lokasi = '
               <button type="button" class="tambah btn btn-sm btn-primary" href="#taglokasi"  data-toggle="modal"data-target="#taglokasi"><i class="fa fa-map-marker-alt"> Tag Lokasi</i>
               </button>
              ';
}



if(isset(query("SELECT * FROM tb_pengunjung WHERE id_card = '$id_card' ORDER BY no DESC")[0])){
      $data2 = query("SELECT * FROM tb_pengunjung WHERE id_card = '$id_card' ORDER BY no DESC")[0];
      $id_kendaraan  = $data2["id_kendaraan"];
      $datakendaraan = query("SELECT * FROM tb_tarif WHERE id_kendaraan = '$id_kendaraan'")[0];

      $tgl_diff      = strtotime($data2["Tanggal"]);    //Konversi Tanggal ke detik
      $tgl           = date("d F Y", $tgl_diff);        //konversi detik jadi tanggal format d F Y
      $Masuk         = date("H:i:s", $data2["Masuk"]);  //konversi detik ke jam -> Masuk
      $Keluar        = date("H:i:s", $data2["Keluar"]); //konversi detik ke jam -> Keluar
      $diff          = time() - $data2["Masuk"];

      $durasi_diff   = $data2["Keluar"] - $data2["Masuk"];
      $Durasi        = date("H:i:s", $durasi_diff - $det); //konversi detik ke jam -> Durasi

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
                 $Masuk    = date("H:i:s", $data2["Masuk"]);
                 $selisih  = date_diff(date_create(), date_create($data2["Tanggal"].$Masuk));
                 $waktu    = $selisih->h.":".$selisih->i.":".$selisih->s;
                 $hari     = $diff/86400;
                 $tarif    = (floor($hari)*$datatarif["tarif_5"]) + ($selisih->h*$datatarif["tarif_4"]);
              }


        if ($data2["Keluar"] == 0) {
             $tampil = '
                    <table class="table table-bordered table-striped">
                              <tr>
                                <th><i class="fa fa-calendar-alt"></i> Tanggal</th>
                                <td>'.$tgl.'</td>
                              </tr>
                              <tr>
                                <th><i class="fa fa-car"></i> Kendaraan</th>
                                <td>'.$datakendaraan["Kendaraan"].'</td>
                              </tr>
                              <tr>
                                <th><i class="fa fa-clock"></i> Jam Parkir</th>
                                <td>'.$Masuk.'</td>
                              </tr>
                              <tr>
                                <th><i class="fa fa-hourglass-half"></i> Durasi</th>
                                <td>'.date("H:i:s", $diff - $det).'</td>
                              </tr>
                              <tr>
                                <th><i class="fa fa-dollar-sign"></i> Tarif</th>
                                <td>Rp.'.number_format($tarif).'</td>
                              </tr>
                              <tr>
                                <th><i class="fa fa-map-marker-alt"></i> Lokasi</th>
                                <td>'.$lokasi.'</td>
                              </tr>
                          </table>';

        }
        else {
           $tampil = "--Belum ada data ditemukan--";
        }
}
else {
  $tampil = "--Belum ada data ditemukan--";
}

if (isset(query("SELECT * FROM tb_transaksi WHERE id_card = '$id_card' AND Debet > 0 
    ORDER BY no DESC")[0])) {
  
  $datadebet  = query("SELECT * FROM tb_transaksi WHERE id_card = '$id_card' AND Debet > 0 
                ORDER BY no DESC")[0];
  $debet      = $datadebet["Debet"];
}
else{
  $debet = 0;

}



		
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	<center>

    
 	<?php if ($data["Status"] == 1) { ?>	
    <div class="row">
      <div class="col">
       <div class="card mt-4" style="width:21rem;">
       	 <div class="card-header" style="background-color:#015c92; font-size: 20px; color: white;"><i class="fa fa-parking"></i>
       	  Parkir Sedang Berlangsung</div>
          <div class="card-body" style="color: black;">
            <?php 
                echo $tampil;
             ?>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mt-4" style="width:21rem;">
         <div class="card-header" style="background-color:#015c92; font-size: 20px; color: white;"><i class="fa fa-hand-holding-usd"></i>
          Data Transaksi Terakhir</div>
          <div class="card-body" style="color: black;">
            <table class="table table-bordered table-striped">
                <tr>
                    <th><i class="fa fa-sign-in-alt"></i> Kredit</th>
                    <td>Rp. <?=number_format($kredit["Kredit"]);?> </td>
                </tr>
                <tr>
                    <th><i class="fa fa-sign-out-alt"></i> Debet</th>
                    <td>Rp. <?=number_format($debet);?> </td>
                </tr>
                <tr>
                    <th><i class="fa fa-coins"></i> Saldo</th>
                    <td>Rp. <?=number_format($data["Saldo"]);?> </td>
                </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

  <?php } 
     else {
  ?>
      <i style="font-size: 80px; color: red;" class="fa fa-user-lock mt-5 mb-3"></i>
      <p style="font-weight: bold; font-size: 35px; color: red;"> Anda Telah Terblokir</p>
  <?php } ?>

 	</center>
 </body>
 </html>