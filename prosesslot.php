<?php 
require "koneksidb.php";



$dataslot = query("SELECT * FROM tb_slot");
$Token_web = mysqli_escape_string($koneksi, $_GET["Token_web"]);

if ($Token_web == $pengaturan["Token_web"]) {
    foreach ($dataslot as $slot) {
      $id_slot = $slot["id_slot"];

        if($_GET[$slot["id_slot"]] == NULL OR $_GET[$slot["id_slot"]] == 1 ){
           $Status = "kosong";
        }
        else if($_GET[$slot["id_slot"]] == 0){
           $Status = "terisi";
        }
      updateSlot($id_slot, $Status);
    }
}
else{
  echo"Token Web Tidak Sesuai";
}


 ?>