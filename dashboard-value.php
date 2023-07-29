<?php 

require "koneksidb.php";

//Waktu
$date  = date('Y-m-d');
$diff  = strtotime($date); 
$tgl_f = date("d F Y", $diff);
$clock = date('H:i:s');

//Total Anggota
$query      = "SELECT * FROM tb_anggota WHERE Level = 'Anggota'";
$result     = mysqli_query($koneksi, $query);
$anggota    = mysqli_num_rows($result);

//Total Anggota Baru Hari Ini
$query2     = "SELECT * FROM tb_anggota WHERE Tanggal ='$date' AND Level = 'Anggota'";
$result2    = mysqli_query($koneksi, $query2);
$angg_baru  = mysqli_num_rows($result2);

//Total Anggota Aktif
$query3     = "SELECT * FROM tb_anggota WHERE Status = 1 AND Level = 'Anggota'";
$result3    = mysqli_query($koneksi, $query3);
$angg_aktif = mysqli_num_rows($result3);

//Total Anggota Terblokir
$query4      = "SELECT * FROM tb_anggota WHERE Status = 0 AND Level = 'Anggota'";
$result4     = mysqli_query($koneksi, $query4);
$angg_blokir = mysqli_num_rows($result4);


//Total Slot Terisi
$query5   = "SELECT * FROM tb_pengunjung WHERE Keluar = 0";
$result5  = mysqli_query($koneksi, $query5);
$terisi   = mysqli_num_rows($result5);

//Total Slot Kosong
$query6    = "SELECT * FROM tb_slot";
$result6   = mysqli_query($koneksi, $query6);
$kapasitas = mysqli_num_rows($result6);
$kosong    = $kapasitas - $terisi;

// Roda 2
$data_r2_kapasitas = "SELECT * FROM tb_slot WHERE id_kendaraan = 1";
$r2_res_kapasitas  = mysqli_query($koneksi, $data_r2_kapasitas);
$r2_kapasitas      = mysqli_num_rows($r2_res_kapasitas);

// Roda 4
$data_r4_kapasitas = "SELECT * FROM tb_slot WHERE id_kendaraan = 2";
$r4_res_kapasitas  = mysqli_query($koneksi, $data_r4_kapasitas);
$r4_kapasitas      = mysqli_num_rows($r4_res_kapasitas);

// Roda 6
$data_r6_kapasitas = "SELECT * FROM tb_slot WHERE id_kendaraan = 3";
$r6_res_kapasitas  = mysqli_query($koneksi, $data_r6_kapasitas);
$r6_kapasitas      = mysqli_num_rows($r6_res_kapasitas);

$data_0  = "SELECT * FROM tb_pengunjung WHERE Keluar = 0 AND id_kendaraan   = 1"; //Roda 2 
$data_1  = "SELECT * FROM tb_pengunjung WHERE Keluar = 0 AND id_kendaraan   = 2"; //Roda 4
$data_2  = "SELECT * FROM tb_pengunjung WHERE Keluar = 0 AND id_kendaraan   = 3"; //Roda 6

$res_0  = mysqli_query($koneksi, $data_0); 
$res_1  = mysqli_query($koneksi, $data_1); 
$res_2  = mysqli_query($koneksi, $data_2);
$slot_isi_0 = mysqli_num_rows($res_0); $slot_kos_0 = $r2_kapasitas - $slot_isi_0;  
$slot_isi_1 = mysqli_num_rows($res_1); $slot_kos_1 = $r4_kapasitas - $slot_isi_1;
$slot_isi_2 = mysqli_num_rows($res_2); $slot_kos_2 = $r6_kapasitas - $slot_isi_2;


//Total Topup Hari ini
$Waktu_1  = date("Y-m-d 00:00:00"); 
$Waktu_2  = date("Y-m-d 23:59:59");
$query7   = "SELECT * FROM tb_transaksi WHERE Kredit > 0 AND Waktu BETWEEN '$Waktu_1' AND '$Waktu_2'";
$result7  = mysqli_query($koneksi, $query7);
$topup    = mysqli_num_rows($result7);

//Total Nominal Top up hari ini
$query8   = "SELECT SUM(Kredit) AS 'topup' FROM tb_transaksi WHERE Waktu BETWEEN '$Waktu_1' AND '$Waktu_2'";
$result8  = mysqli_query($koneksi, $query8);
$nominal  = mysqli_fetch_array($result8);

//Roda 2 Hari ini
$query9  = "SELECT * FROM tb_pengunjung WHERE Tanggal = '$date' AND id_kendaraan = 1";
$result9 = mysqli_query($koneksi, $query9);
$roda2  = mysqli_num_rows($result9);

//Roda 4 Hari ini
$query10  = "SELECT * FROM tb_pengunjung WHERE Tanggal = '$date' AND id_kendaraan = 2";
$result10 = mysqli_query($koneksi, $query10);
$roda4  = mysqli_num_rows($result10);

//Roda 6 Hari ini
$query11  = "SELECT * FROM tb_pengunjung WHERE Tanggal = '$date' AND id_kendaraan = 3";
$result11 = mysqli_query($koneksi, $query11);
$roda6    = mysqli_num_rows($result11);

//Total Pengunjung
$query12     = "SELECT * FROM tb_pengunjung WHERE Tanggal = '$date'";
$result12    = mysqli_query($koneksi, $query12);
$pengunjung  = mysqli_num_rows($result12);

 ?>


 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<center>

<div class="container" style="max-width: 100rem;">

  <div class="row">

    <div class="col-sm py-2">
      <div class="card text-white" style="background-color:#3B5284;">
        <div class="card-header" style="font-size:20px;">Waktu Saat Ini</div>
        <div class="card-body" style="font-size: 40px;"><i class="fa fa-clock"></i> <?=$clock;?></div>
        <div class="card-footer" style="font-size:20px;">
            <i class="mx-3 fa fa-calendar"> <?=$tgl_f;?></i>
        </div>
      </div>
    </div>

    <div class="col-sm py-2">
      <div class="card text-white" style="background-color:#2C6975;">
        <div class="card-header" style="font-size:20px;">Total Anggota</div>
        <div class="card-body" style="font-size: 40px;"><i class="fa fa-user"></i> <?=$anggota;?></div>
        <div class="card-footer" style="font-size:20px;">
            <i class="mx-3 fa fa-user-check"> <?=$angg_aktif;?></i>
            <i class="mx-1 fa fa-user-lock"> <?=$angg_blokir;?></i>
            <i class="mx-3 fa fa-user-plus"> <?=$angg_baru;?></i>
        </div>
      </div>
    </div>

      <div class="col-sm py-2">
        <div class="card text-white" style="background-color:#706695;">
          <div class="card-header" style="font-size: 20px;">Top up Hari ini</div>
          <div class="card-body" style="font-size:40px;"><i class="fa fa-hand-holding-usd"></i> 
            <?=$topup;?>
          </div>
          <div class="card-footer" style="font-size:20px;"><i class="fa fa-money-bill-alt"></i> Rp. <?=number_format($nominal['topup']);?></div>
        </div>
      </div>

  </div>

  <div class="row">

    <div class="col-sm py-2">
        <div class="card text-white" style="background-color:#56C596;"> 
         <div class="card-header" style="font-size: 20px;">Pengunjung Hari Ini</div>
          <div class="card-body" style="font-size:40px;"><i class="fa fa-users"></i> <?=$pengunjung?></div>
          <div class="card-footer" style="font-size:20px;">
            <i class="mx-3 fa fa-bicycle"> <?=$roda2;?></i> 
            <i class="mx-1 fa fa-car-side"> <?=$roda4;?></i> 
            <i class="mx-3 fa fa-truck"> <?=$roda6;?></i>
          </div>
        </div>
      </div>

      <div class="col-sm py-2">
      <div class="card text-white" style="background-color:#EA4492;" >
        <div class="card-header" style="font-size:20px;">Total Slot Terisi</div>
        <div class="card-body" style="font-size:40px;"><i class="fa fa-sign-in-alt"></i> <?=$terisi?></div>
          <div class="card-footer" style="font-size:20px;">
            <i class="mx-3 fa fa-bicycle"> <?=$slot_isi_0;?></i> 
            <i class="mx-1 fa fa-car-side"> <?=$slot_isi_1;?></i> 
            <i class="mx-3 fa fa-truck"> <?=$slot_isi_2;?></i>
          </div>
      </div>
    </div>

      <div class="col-sm py-2">
        <div class="card text-white" style="background-color:#FD9F52;">
          <div class="card-header" style="font-size: 20px;">Total Slot Kosong</div>
          <div class="card-body" style="font-size: 40px;"><i class="fa fa-sign-out-alt"></i> <?=$kosong?></div>
          <div class="card-footer" style="font-size:20px;">
            <i class="mx-3 fa fa-bicycle"> <?=$slot_kos_0;?></i> 
            <i class="mx-1 fa fa-car-side"> <?=$slot_kos_1;?></i> 
            <i class="mx-3 fa fa-truck"> <?=$slot_kos_2;?></i>
          </div>
        </div>
      </div>
    
  </div>

</div>


 
    </div>
  </div>
</div>	

	</center>


</body>
</html>