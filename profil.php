<?php 	
	require "template_2.php";

  $Token_bot  = $pengaturan["Token_bot"];
  $id_card    = $_SESSION['id_card']; 
  $data       = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];

//Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan admin
    if(aturAdmin($_POST) > 0) {
      $pesan = "Data ID Chat anda telah diubah\n\nID Chat: ".$_POST["id_chat"];
      if($data["Sw_user"] == 1){
         kirimpesan($_POST["id_chat"], $pesan, $Token_bot);
      }
            echo "
        <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data ID Chat berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='profil.php'; 
                  }); 
			   </script>
                ";      
    }
    else {
      $pesan = "PERINGATAN!!!\n\nAda yang berusaha mengubah ID Chat anda";
      if($data["Sw_user"] == 1){
         kirimpesan($data["id_chat"], $pesan, $Token_bot);
      }
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Data ID Chat gagal disimpan!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='profil.php'; 
		            }); 
		         </script>
		        ";
    }
 }  

 //Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["ubah"]))  { //pengaturan admin
    if(ubahPassword($_POST) > 0) {
      $pesan = "Password telah berhasil diperbarui";                  
            echo "
                 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Password telah berhasil diubah',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='profil.php'; 
                  }); 
			     </script>
                ";      
    }
    else {
        $pesan = "PERINGATAN!!!\n\nAda yang berusaha mengubah password anda";
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Password telah gagal diubah!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='profil.php'; 
		            }); 
		         </script>
		        ";
    }
      if($data["Sw_user"] == 1){
         kirimpesan($data["id_chat"], $pesan, $Token_bot);
      }
 }

 //Proses status Telegram User/Member
 if(isset($_GET["state"])){
    $state = $_GET['state'];
    $sql    = "UPDATE tb_anggota SET Sw_user = '$state' WHERE id_card = '$id_card'";
    $koneksi->query($sql);
       if($state == 1){
         $val = "ON";
       }
       else{
         $val = "OFF";
       }
     $pesan = "Notifikasi Member: ".$val;
     kirimpesan($data["id_chat"], $pesan, $Token_bot);
 }
  

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
 		<h3>PROFIL</h3>


  <div class="card mt-4" style="width:23rem;">
    <div class="card-body">
          <form action="resetID.php" method="post">
            <table class="table table-bordered table-striped">
                <tr>
                  <th><i class="fa fa-id-card"></i> ID Card</th>
                  <td><?=$data["id_card"];?></td>
                </tr>
                <tr>
                  <th><i class="fa fa-comment"></i> ID Chat</th>
                  <td><?=$data["id_chat"];?></td>
                </tr>
                <tr>
                  <th><i class="fa fa-user"></i> Nama</th>
                  <td><?=$data["Nama"];?></td>
                </tr>
                <tr>
                  <th><i class="fa fa-venus-mars"></i> Gender</th>
                  <?php   
                      if ($data["Gender"] == "L") {
                        echo '<td>Laki Laki</td>';
                      }
                      if ( $data["Gender"] == "P") {
                         echo '<td>Perempuan</td>';
                      }
                   ?>
                </tr>
                <tr>
                  <th><i class="fa fa-bell"></i> Notifikasi</th>
                  <?php if($data["Sw_user"] == 0) {
                         echo '<td><input type="checkbox" onchange="dataMember(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger"></td>';
                       }
                        else{ 
                          echo '<td><input type="checkbox" checked onchange="dataMember(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger"></td>';
                       } 
                   ?> 
                </tr>
            </table>
          <button type="button" class="btn btn-block btn-success" href="#ubahPassword" data-toggle="modal"data-target="#ubahPassword"><i class="fa fa-key"></i> Ubah Password</button>
          <button type="button" class="btn btn-block btn-warning" href="#ubahIdchat" data-toggle="modal"data-target="#ubahIDchat"><i class="fa fa-comment"></i> Ubah ID Chat</button> 
        </div>
      </form>
    </div>
  </div>


 	</center>

  <!-- Modal Atur Password -->
<div class="modal fade" id="ubahPassword" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-key"></i> UBAH PASSWORD</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="profil.php" method="post">
         <div class="modal-body">
             <div class="form-group">
                <div class="input-group mb-3">
                    <input class="form-control" name="passlama" type="password" autocomplete="off" placeholder="Masukkan Password Lama">
                </div>
                <div class="input-group mb-3">
                    <input class="form-control" name="passbaru" type="password" autocomplete="off" placeholder="Masukkan Password Baru">
                </div>
                <div class="input-group mb-3">
                    <input class="form-control" name="passbaru2" type="password" autocomplete="off" placeholder="Konfirmasi Password Baru">
                </div>
                    <input type="text" name="id_card" value="<?=$id_card;?>" hidden>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="ubah" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" name="reset" class="btn text-white" style="background: blue"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>


 	<!-- Modal Ubah ID Chat -->
<div class="modal fade" id="ubahIDchat" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-comment"></i> UBAH ID CHAT</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="profil.php" method="post">
         <div class="modal-body">
             <div class="form-group">
                <div class="input-group mb-3">
				            <input class="form-control" name="id_chat" type="text" autocomplete="off" placeholder="Masukkan ID Chat Baru">
				        </div>
				        <div class="input-group mb-3">
				            <input class="form-control" name="Password" type="password" autocomplete="off" placeholder="Masukkan Password Anda">
				        </div>
                    <input type="text" name="id_card" value="<?=$id_card;?>" hidden>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" name="reset" class="btn text-white" style="background: blue"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

 <script>
          //send data
              function dataMember(e){
              var xhr = new XMLHttpRequest();
                  if(e.checked){
                    xhr.open("GET", "profil.php?state= 1", true);
                  }
                  else{
                    xhr.open("GET", "profil.php?state= 0", true);
                  }
                xhr.send();
              }
  </script>

 </body>
 </html>