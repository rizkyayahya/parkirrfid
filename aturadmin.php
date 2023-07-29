<?php 	
	require "template.php";

  $Token_bot  = $pengaturan["Token_bot"];
  $id_card    = $_SESSION['id_card']; 
  $data       = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];

//Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan admin
    if(aturAdmin($_POST) > 0) {
      $pesan = "Data ID Chat anda telah diubah\n\nID Chat: ".$_POST["id_chat"];
            echo "
        <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data ID Chat dan username berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='aturadmin.php'; 
                  }); 
			   </script>
                ";      
    }
    else {
      $pesan = "PERINGATAN!!!\n\nAda yang berusaha mengubah ID Chat anda";
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Data Username gagal disimpan!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='aturadmin.php'; 
		            }); 
		         </script>
		        ";
    }
    if($data["Sw_user"] == 1){
         kirimPesan($_POST["id_chat"], $pesan, $Token_bot);
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
                  window.location.href='aturadmin.php'; 
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
		                window.location.href='aturadmin.php'; 
		            }); 
		         </script>
		        ";
    }
      if($data["Sw_user"] == 1){
         kirimPesan($data["id_chat"], $pesan, $Token_bot);
      }
 }  

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
 		<h3>PANEL ADMIN</h3>

 <div class="container my-5" style="width:23rem;">
 		<form method="post" action="aturadmin.php">	
		 		<div class="form-group">
					<div class="input-group mb-3">
					  <div class="input-group-prepend"><span class="input-group-text">ID Chat</span></div>
					  <input type="text" autocomplete="off" class="form-control"name = "id_chat" placeholder="Masukkan ID Chat" value="<?=$data["id_chat"]?>">
					</div>
				    <div class="input-group mb-3">
		          <input class="form-control" name="Password" type="password" autocomplete="off" placeholder="Masukkan Password Anda">
		            </div>
		      </div>
          <input type="text" name="id_card" value="<?=$id_card;?>" hidden>
        <button type="button" class="btn btn-block btn-primary" href="#ubahPassword" data-toggle="modal"data-target="#ubahPassword"><i class="fa fa-key"></i> Ubah Password</button><br>
				<button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button> 
      </form>
	</div>     

 	</center>

 	<!-- Modal Atur Password -->
<div class="modal fade" id="ubahPassword" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title">UBAH PASSWORD</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="aturadmin.php" method="post">
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

 </body>
 </html>