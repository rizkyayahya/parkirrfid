<?php

require "template.php";


	if(isset($_POST["simpan"]) ) {
    
	   if( ubahanggota($_POST) > 0 ) {
      $pesan="Data Diri Anda Telah diperbarui\n\n Nama: ".$_POST["Nama"]."\n Gender: ".$_POST["Gender"]."\n\nData diperbarui pada: \n".date("d F Y H:i:s")."\n\nSegera laporkan ke admin jika terjadi kesalahan input data. Terimakasih";
		echo "
			 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Perubahan data telah disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='dataanggota.php'; 
                  }); 
			 </script>
		";
	   }
	   else {
      $pesan = "PERINGATAN!!!\n\nAda yang berusaha mengubah data diri Anda!";
	    echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'Data gagal ditambahkan', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='dataanggota.php'; 
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
		<h3 class="text-center mb-4 mt-2">UBAH DATA ANGGOTA</h3>

    <?php 
        if(isset($_GET["id_card"])){
            $id_card  = mysqli_escape_string($koneksi, $_GET["id_card"]);
            $data     = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];
     ?>
			
    <div class="card" style="width: 23rem;">
      <div class="card-body text-white" style="background-color:#015c92">
        <h5 class="card-title">ID Card: <?=$data["id_card"];?></h5>
          <form action="ubahanggota.php" method="post">
                    <div class="form-group">
                      <input type="text" name="id_card"  class="form-control" value="<?=$data["id_card"];?>" hidden ><br>
                      <input type="text" name="id_chat"  class="form-control" placeholder="Masukkan ID Chat...." autocomplete="off" value="<?=$data["id_chat"];?>" ><br>
                      <input type="text" name="Nama"  class="form-control" placeholder="Masukkan Nama...." autocomplete="off" value="<?=$data["Nama"];?>" ><br>
                      <div class="row">
                        <?php if($data["Gender"] == "L") {
                            echo '
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Gender" value="L" checked="checked">
                                        <label class="form-check-label">Laki laki</label>
                                    </div>
                                  </div>
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Gender" value="P">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                  </div>
                                ';}

                                    else if($data["Gender"] == "P") {
                            echo '
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Gender" value="L">
                                        <label class="form-check-label">Laki laki</label>
                                    </div>
                                  </div>
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Gender" value="P" checked="checked">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                  </div>
                                ';}
                        ?>
                       </div>

                      <br>

                         <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                         <a href="dataanggota.php" name="batal" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</a> 
                    </div>
                  </form>
      </div>
    </div>
  <?php   } ?>

 </center>
    
   

</body>
</html>


