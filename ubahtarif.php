<?php

		  require "template.php";

    

	  
	if(isset($_POST["simpan"]) ) {
	   if( ubahtarif($_POST) > 0 ) {
		echo "
			 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Perubahan data telah disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='tarif.php'; 
                  }); 
			 </script>
		";
	   }
	   else {
	    echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'Data gagal ditambahkan', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='tarif.php'; 
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
		<h3 class="text-center mb-4 mt-2">UBAH DATA TARIF</h3>

    <?php 
        if(isset($_GET["id_kendaraan"])){
            $id_kendaraan  = mysqli_escape_string($koneksi, $_GET["id_kendaraan"]);
            $data          = query("SELECT * FROM tb_tarif WHERE id_kendaraan = '$id_kendaraan'")[0];
     ?>
			
    <div class="card" style="width: 23rem;">
      <div class="card-body text-white" style="background-color:#015c92">
        <h5 class="card-title">Kendaraan: <?=$data["Kendaraan"];?></h5>
          <form action="ubahtarif.php" method="post">
              <div class="form-group">
                  <input type="text" name="id_kendaraan"  class="form-control" value="<?=$data["id_kendaraan"];?>" hidden >
                  <div class="input-group">
                     <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroup-sizing-default">1 Jam</span>
                     </div>
                     <input type="text" name="tarif_1"  class="form-control" autocomplete="off" value="<?=$data["tarif_1"];?>" >
                  </div><br>
                  <div class="input-group">
                     <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroup-sizing-default">2 Jam</span>
                     </div>
                     <input type="text" name="tarif_2"  class="form-control" autocomplete="off" value="<?=$data["tarif_2"];?>" >
                  </div><br>
                  <div class="input-group">
                     <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroup-sizing-default">3 Jam</span>
                     </div>
                     <input type="text" name="tarif_3"  class="form-control" autocomplete="off" value="<?=$data["tarif_3"];?>" >
                  </div><br>
                  <div class="input-group">
                     <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroup-sizing-default">> 3 Jam</span>
                     </div>
                     <input type="text" name="tarif_4"  class="form-control" autocomplete="off" value="<?=$data["tarif_4"];?>" >
                  </div><br>
                  <div class="input-group">
                     <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroup-sizing-default">> 24 Jam</span>
                     </div>
                     <input type="text" name="tarif_5"  class="form-control" autocomplete="off" value="<?=$data["tarif_5"];?>" >
                  </div><br>
                  <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                         <a href="tarif.php" name="batal" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</a> 
                    </div>
                  </form>
      </div>
    </div>
  <?php   } ?>

 </center>
    
   

</body>
</html>


