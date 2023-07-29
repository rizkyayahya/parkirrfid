<?php 

    require "koneksidb.php";
    session_start();
    $id_card  = $_SESSION["id_card"];
    $dataslot = query("SELECT * FROM tb_slot WHERE id_kendaraan = '1' ORDER BY id_kendaraan ASC");
    
   
	

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	<center>
 		

 <div class="row mx-1">
 	<?php 
         foreach ($dataslot as $slot) {
         	//cek jenis kendaraan
 			if ($slot["id_kendaraan"] == 1) {
				$kendaraan = "<i class='fa fa-bicycle'></i>";
			}
			if ($slot["id_kendaraan"] == 2) {
				$kendaraan = "<i class='fa fa-car-side'></i>";
			}
			if ($slot["id_kendaraan"] == 3) {
				 $kendaraan = "<i class='fa fa-truck'></i>";
			}
            //cek status slot parkir
			if ($slot["Status"] == "kosong") {
				$warna = "bg-danger";
			}
			else if ($slot["Status"] == "terisi") {
				$warna = "bg-success";
			}
			else{
				$warna = "bg-secondary";
			}
			//cek user slot parkir
			if ($slot["id_card"] == $id_card) {
				$warna = "bg-primary";
			}

 	 ?>
		  <div class="col-sm-2 my-1">
		    <div class="card <?=$warna;?>" style="width:195px;">
		      <div class="card-body">
		        <p class="card-text text-white" style="font-size: 30px;"><?=$kendaraan."<br>".$slot["id_slot"];?></i></p>
		        <p class="card-text text-white"> User : <?=$slot["id_card"];?></p>
		      </div>
		    </div>
		  </div>
	<?php } ?>
</div>



 	</center>
 </body>
 </html>