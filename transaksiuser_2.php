<?php 

require "template_2.php";

$id_card   = $_SESSION["id_card"];
$Nama      = $_SESSION["Nama"];

$Token_bot = $pengaturan["Token_bot"];

$saldo_pengirim = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];

if(isset($_GET["Tanggal1"]) AND isset($_GET["Tanggal2"])){
  $Tanggal1  = mysqli_escape_string($koneksi, $_GET["Tanggal1"]); $Waktu1 = $Tanggal1." 00:00:00";
  $Tanggal2  = mysqli_escape_string($koneksi, $_GET["Tanggal2"]); $Waktu2 = $Tanggal2." 23:59:59";
}
else{
  $Tanggal1  = date("Y-m-d"); $Waktu1 = $Tanggal1." 00:00:00";
  $Tanggal2  = date("Y-m-d"); $Waktu2 = $Tanggal2." 23:59:59";
}

 $data = query("SELECT * FROM tb_transaksi WHERE id_card = '$id_card' AND  Waktu BETWEEN '$Waktu1' AND    '$Waktu2'ORDER BY no DESC");

if(isset($_POST["transfer"]) ) {
 	$id_penerima    = $_POST["id_penerima"];
 	$Saldo_pengirim = $_POST["Saldo_pengirim"]; 
 	$Status         = $_POST["Status"];
 	$Password       =  mysqli_real_escape_string($koneksi, $_POST["Password"]);
 if (isset(query("SELECT * FROM tb_anggota WHERE id_card = '$id_penerima'")[0])) {
	$datapenerima   = query("SELECT * FROM tb_anggota WHERE id_card = '$id_penerima'")[0];
	if ($datapenerima["id_card"] == $id_penerima AND $_POST["Nominal"] <= $Saldo_pengirim AND
        $id_penerima != $_POST["id_pengirim"]) {
		if ($Status == 0){
			echo "
	         <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Kartu Anda Telah Terblokir!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='transaksiuser_2.php'; 
		            }); 
	         </script>
	        ";
		}    
		else if($Status == 1 AND Transfer($_POST) > 0) {	
			echo "
				 <script>
					  Swal.fire({ 
	                  title: 'SELAMAT',
	                  text: 'Transfer berhasil dilakukan',
	                  icon: 'success', buttons: [false, 'OK'], 
	                  }).then(function() { 
	                  window.location.href='transaksiuser_2.php'; 
	                  }); 
				 </script>
			"; 
			 if ($datapenerima["Sw_user"] == 1) {
			   $pesan = "Anda telah menerima Transfer sebesar Rp. ".number_format($_POST["Nominal"])." dari ".$Nama." (ID ".$_POST["id_pengirim"].")";
		       kirimPesan($datapenerima["id_chat"], $pesan, $Token_bot);
		    }  
		}
		else if($Status == 1 AND Transfer($_POST) <= 0) {
			echo "
	         <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Password Anda Salah!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='transaksiuser_2.php'; 
		            }); 
	         </script>
	        ";	
		}   
	}
	else if ($datapenerima["id_card"] == $id_penerima AND $_POST["Nominal"] > $Saldo_pengirim) {
		echo "
	         <script> 
		         Swal.fire({ 
		            title: 'Saldo Anda Tidak Mencukupi', 
		            text: 'Saldo Anda Rp. $Saldo_pengirim', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='transaksiuser_2.php'; 
		            }); 
	         </script>
	        ";
	}
	else{
		echo "
	         <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Transfer gagal!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='transaksiuser_2.php'; 
		            }); 
	         </script>
	        ";
	}
  }
  else if (!isset(query("SELECT * FROM tb_anggota WHERE id_card = '$id_penerima'")[0])) {
		echo "
	         <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'ID tidak ditemukan', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='transaksiuser_2.php'; 
		            }); 
	         </script>
	        ";
	}
   else{
		echo "
	         <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Transfer gagal!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='transaksiuser_2.php'; 
		            }); 
	         </script>
	        ";
	}
}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
   <center>
 	<h3>RIWAYAT TRANSAKSI</h3>
 	<p class="mb-1"><?=$user." (ID ".$_SESSION["id_card"].")";?></p>

 	
 	 <div class="row mt-4 mb-3">
	      <div class="col">
	          <button type="button" class="tambah btn btn-danger" href="#tambahanggota" data-toggle="modal"data-target="#filter"><i class="fa fa-calendar"></i></button>
	      </div>
	      <div class="col">
	          <button type="button" class="tambah btn btn-primary" href="#transaksi" data-toggle="modal"data-target="#transaksi"><i class="fa fa-money-bill-wave"></i></button>
	      </div>
		  <div class="col">
				<div class="dropdown">
				   <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download"></i></button>
				   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				   <a class="dropdown-item" href="pdf/pdftransaksiuser.php?id_card=<?=$id_card;?>&Nama=<?=$Nama;?>&Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-pdf"></i> Export to PDF</a>
				   <a class="dropdown-item" href="excel/exceltransaksiuser.php?id_card=<?=$id_card;?>&Nama=<?=$Nama;?>&Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-excel"></i> Export to Excel</a>
				    </div>
				 </div>
          </div>
    </div>

 <div class="table-responsive-sm my-3">
 	<table class="table table-bordered table-hover table-striped" style="width:65rem;">
	   <tr class="text-center text-white" style="background-color:#2d82b5"> 
	   <th>No.</th>
	   <th width="200px">Waktu</th>
	   <th>Kredit</th>
	   <th>Debet</th>
	   <th>Saldo</th>
	   <th>Keterangan</th>
	   </tr>
	<?php $i =1;?>

	<?php foreach ($data as $transaksi) :?>
	   <tr>
	   <td class="text-center"><?= $i; ?></td>
	   <td class="text-center"><?= $transaksi["Waktu"];?></td>
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
      <form method="get" action="transaksiuser_2.php">
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

<!-- Modal Transfer  -->
<div class="modal fade" id="transaksi" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-money-bill-wave"></i> TRANSFER</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="transaksiuser_2.php" method="post">
         <div class="modal-body">
             <div class="form-group">
                 <div class="input-group mb-3">
				      <input class="form-control" name="id_penerima" type="text" autocomplete="off" placeholder="Masukkan ID Target" required>
				  </div>
				  <div class="input-group mb-3">
				       <input class="form-control" name="Nominal" type="number" autocomplete="off" placeholder="Masukkan Nominal Transfer" required>
				  </div>
				  <div class="input-group mb-3">
                    <input class="form-control" name="Password" type="password" autocomplete="off" placeholder="Masukkan Password">
                  </div>
				  <input type="text" name="id_pengirim" value="<?=$id_card;?>" hidden>
				  <input type="text" name="Saldo_pengirim" value="<?=$saldo_pengirim['Saldo'];?>" hidden>
				  <input type="text" name="Status" value="<?=$saldo_pengirim['Status'];?>" hidden>
             </div>  
         </div>
      <div class="modal-footer">
        <button type="submit" name="transfer" class="btn btn-success"><i class="fa fa-paper-plane"></i> Kirim</button>
        <button type="reset" name="reset" class="btn text-white" style="background: blue"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

 </center>
 </body>
 </html>