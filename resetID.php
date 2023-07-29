<?php

require "template.php";


if(isset($_POST["simpan"]) ) {
    
	if( resetID($_POST) > 0 ) {
      $pesan="ID anda telah direset menjadi ".$_POST["idbaru"];
		echo "
			 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'ID Anggota berhasil direset',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='dataanggota.php'; 
                  }); 
			 </script>";
	   }
	   else {
	    echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'ID Anggota gagal direset', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='dataanggota.php'; 
            }); 
         </script>";
	   }
      if ($_POST['Sw_user'] == 1) {
        kirimPesan($_POST["id_chat"], $pesan, $pengaturan["Token_bot"]);
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
		<h3 class="text-center mb-4 mt-2">RESET ID ANGGOTA</h3>

    <?php 
        if(isset($_GET["id_card"])){
            $id_card  = $_GET["id_card"];
            $data     = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];
     ?>
			
<div class="card" style="width: 23rem;">
  <div class="card-body text-white" style="background-color:#015c92">
        <form action="resetID.php" method="post">
          <div class="idmasuk"></div><br>
          <table class="table table-bordered text-white">
              <tr>
                <th>ID Card</th>
                <td><?=$data["id_card"];?></td>
                <input type="text" name="id_card" value="<?=$data["id_card"];?>" hidden>
              </tr>
              <tr>
                <th>ID Chat</th>
                <td><?=$data["id_chat"];?></td>
              </tr>
              <tr>
                <th>Nama</th>
                <td><?=$data["Nama"];?></td>
              </tr>
              <tr>
                <th>Saldo</th>
                <td>Rp. <?= number_format($data["Saldo"]);?></td>
              </tr>
              <input type="text" name="id_chat" value="<?=$data["id_chat"];?>" hidden>
              <input type="text" name="Sw_user" value="<?=$data["Sw_user"];?>" hidden>
          </table>
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


