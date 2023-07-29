<?php 	
	require "template.php";

  $date = date('Y-m-d');

       if(isset($_GET["reject"])){
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap ditolak!!!', 
                text: 'Silakan cek data ID anda!!!', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='tagID.php'; 
                }); 
            </script>
              ";
      }

      else if(isset($_GET["full"])){
        $kendaraan = $_GET["kendaraan"];
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap ditolak!!!', 
                text: 'Parkiran $kendaraan Telah Penuh!!!', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='tagID.php'; 
                }); 
            </script>
              ";
    
      }

       else if(isset($_GET["masuk"])){
         $id_card  = $_GET["id_card"];
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap Masuk Diterima', 
                text: '$id_card', 
                icon: 'success', 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='pengunjung.php'; 
                }); 
            </script>
              ";
      }

      else if(isset($_GET["keluar"])){
         $id_card  = $_GET["id_card"];
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap Keluar Diterima', 
                text: '$id_card', 
                icon: 'success', 
                buttons: [false, 'OK'], 
                }).then(function() { 
                   window.location.href='pengunjung.php'; 
                }); 
            </script>
              ";
      }
      else if(isset($_GET["habis"])){
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap ditolak!!!', 
                text: 'Saldo Tidak Mencukupi!!!', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='tagID.php'; 
                }); 
            </script>
              ";
      }
      else if(isset($_GET["unmatched"])){
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap ditolak!!!', 
                text: 'Jenis Kendaraan Tidak Sesuai!!!', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='tagID.php'; 
                }); 
            </script>
              ";
      }
      

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
    <img class="img-fluid responsive-sm" src="img/rfid.jpg" alt="Responsive image" style="width:300px; height:180px;">
 		<h4>SILAKAN MASUKKAN ID CARD</h4>

 	   <div class="container my-5" style="width:20rem;">
 		<form method="get" action="prosesID.php">	
		 		<div class="form-group">
					<div class="input-group mb-3">
					  <input type="text" autocomplete="off" class="form-control"name = "id_card" placeholder="Masukkan ID Card" required>
					</div>
          <div class="input-group">
              <div class="input-group-prepend"></div>
                  <select name="id_kendaraan" class="custom-select">
                      <option selected>---Pilih Jenis Kendaraan---</option>
                        <?php
                             $Jenis = query("SELECT * FROM tb_tarif");
                             foreach ($Jenis as $i) {
                                echo "<option value=".$i['id_kendaraan'].">".$i['Kendaraan']."</option>"; 
                            } ?> 
                    </select>
                </div>
  					 <input type="text" class="form-control" name = "Token_web" value="<?=$pengaturan["Token_web"]?>" hidden>
             <input type="text" class="form-control" name = "Sensor" value="0" hidden>
		     </div>
				<button type="submit" name="kirim" class="btn btn-success"><i class="fa fa-edit"></i> Submit</button>
          </form>
          <br>
         <?php  
               if(isset($_GET["unregister"])){
                 $id_card = $_GET["id_card"];
                 echo ' 
                    <div class="alert alert-danger alert-dismissible fade show  role="alert">  
                        <h5>ID Tidak Terdaftar!!!</h5>
                            <button type="button" class="tambah btn btn-sm btn-primary" href="#tambahanggota" data-toggle="modal"data-target="#tambahanggota">Registrasi ID</button>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div> 
                   ';
              }
          ?>
		</div>     
 	</center>

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="tambahanggota" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-user-plus"></i> FORM REGISTRASI ANGGOTA</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="dataanggota.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                      <div class="idmasuk"></div><br>
                          <input class="form-control" name="id_chat" type="text" autocomplete="off" placeholder="ID Chat Bot Telegram" required><br>
                          <input class="form-control" name="Nama" type="text" autocomplete="off" placeholder="Nama Lengkap" required><br>
                          <div class="row px-5">
                            <div class="col">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="Gender" value="L" required>
                                <label class="form-check-label">Laki laki</label>
                              </div>
                            </div>
                            <div class="col">
                               <div class="form-check">
                                  <input class="form-check-input" type="radio" name="Gender" value="P" required>
                                  <label class="form-check-label">Perempuan</label>
                              </div>
                            </div>
                          </div>        
                    <br>
                    <input class="form-control" id="Kredit" name="Kredit" type="number" autocomplete="off" placeholder="Saldo Rupiah" required>
                    <input id="Kredit" name="Saldo" type="number" value = "0" hidden>
                    <input type="text" name="Level" value = "Anggota" hidden>
                    <input type="text" name="Ket" value = "Topup" hidden>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>


 </body>
 </html>