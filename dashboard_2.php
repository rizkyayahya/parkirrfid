<?php 
	require "template_2.php";

  
  $id_card = $_SESSION["id_card"];
  $dataanggota = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];

  if(isset($_POST["tag"]))  {
    if(tagLokasi($_POST) > 0 ) {
      if ($dataanggota["Sw_user"] == 1) {
           $pesan = "Lokasi Anda telah ditandai pada ".$_POST["lokasi"];
           kirimPesan($dataanggota["id_chat"], $pesan, $Token_bot);
        }  
            echo "
                 <script> 
                  Swal.fire({ 
                  title: 'BERHASIL',
                  text: 'Lokasi Anda Telah Ditandai',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                      window.location.href='dashboard_2.php'; 
                  }); 
                 </script>
                ";   
        }               
    else {
      echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'Lokasi Anda Gagal Ditandai!!!', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='dashboard_2.php'; 
            }); 
         </script>
        ";
    }
  } 
 ?>

 <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
<body>

  <center>
    <h3 class="mt-2">DASHBOARD</h3>
    <p class="mb-1"><?=$user." (ID ".$_SESSION["id_card"].")";?></p>

    <div class="dashboard_2_value"></div>


    
  </center>

  <!-- Modal Tag Lokasi Parkir  -->
<div class="modal fade" id="taglokasi" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-map-marker-alt"></i> TAG LOKASI PARKIR</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="dashboard_2.php" method="post">
         <div class="modal-body">
             <div class="form-group">
                 <div class="input-group mb-3">
                   <input class="form-control" name="lokasi" type="text" autocomplete="off" placeholder="Masukkan Lokasi Anda" required>
                   <input type="text" name="id_card" value="<?=$id_card;?>" hidden>
                </div>
            </div>
      <div class="modal-footer">
        <button type="submit" name="tag" class="btn btn-success"><i class="fa fa-paper-plane"></i> Submit</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

 
</body>
</html> 