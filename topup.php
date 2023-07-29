<?php

 require "template.php";

 $Token_bot = $pengaturan["Token_bot"];

	  
	if(isset($_POST["topup"]) ) {
	   if( topup($_POST) > 0 ) {
      $saldo_akhir = $_POST["Kredit"] + $_POST["Saldo"];
      $pesan       = "Kartu parkir anda telah berhasil dilakukan Topup sebesar Rp.".number_format($_POST["Kredit"])."\n\nSaldo Akhir = Rp. ".number_format($saldo_akhir);
      Kredit($_POST);
		echo "
			 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Topup berhasil dilakukan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='dataanggota.php'; 
                  }); 
			 </script>
		";
	   }
	   else {
      $pesan = "Hai ".$_POST["Nama"]."\n\nTopup Gagal Dilakukan!!!";
	    echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'Topup gagal!!!', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='dataanggota.php'; 
            }); 
         </script>
        ";
	   }
       if ($_POST["Sw_user"] == 1) {
         kirimPesan($_POST["id_chat"], $pesan, $Token_bot);
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
		<h3 class="text-center mb-4 mt-2">TOP UP SALDO</h3>

    <?php 
        if(isset($_GET["id_card"])){
            $id_card  = $_GET["id_card"];
            $data     = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];
            $id_chat  = $data["id_chat"]; 
            $Nama     = $data["Nama"];
            $Saldo    = $data["Saldo"];
            $Sw_user  = $data["Sw_user"];
            $Status   = $data["Status"];
     ?>
			
<div class="card" style="width: 23rem;">
  <div class="card-body text-white" style="background-color:#015c92">
    <form action="topup.php" method="post">
      <div class="form-group">
        <div class="input-group">
          <div class="table-responsive-sm">
            <table class="table text-white">
              <tr>
                <td>ID</td>
                <td>:</td>
                  <td><?=$id_card;?></td>
                  <input type="text" name="idbaru" value="<?=$id_card;?>" hidden >
              </tr>
              <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td><?=$Nama;?></td>
                  <input type="text" name="Nama"    value="<?=$Nama;?>"    hidden >
              </tr>
              <tr>
                  <td>Saldo</td>
                  <td>:</td>
                  <td>Rp.<?= number_format($Saldo);?></td>
                  <input type="text" name="Saldo"   value="<?=$Saldo;?>"   hidden >
              </tr>
               <tr>
                  <td>Topup</td>
                  <td>:</td>
                  <td><input type="number" name="Kredit" class="form-control" placeholder="Nominal..." required></td>
                  <input type="text" name="id_chat" value="<?=$id_chat;?>" hidden >
                  <input type="text" name="Sw_user" value="<?=$Sw_user;?>" hidden >
                  <input type="text" name="Status"  value="<?=$Status;?>" hidden >
                  <input type="text" name="Ket"     value="Topup" hidden >
              </tr>
            </table>
          </div>
                  <button type="submit" name="topup" class="btn btn-block" style="background: #F8D90F;"><i class="fa fa-paper-plane"></i> Top up</button>
        </div>               
     </form>
  </div>
</div>
  <?php   } ?>

 </center>
    
   

</body>
</html>


