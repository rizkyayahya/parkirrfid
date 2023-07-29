<?php 	
require "template.php";

$dataslot = query("SELECT * FROM tb_slot");

if(isset($_POST["submit"]))  {
    if(tambahSlot($_POST) > 0 ){    
            echo "
                 <script> 
                  Swal.fire({ 
                  title: 'BERHASIL',
                  text: 'Data Telah disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                      window.location.href='dataslot.php'; 
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
                window.location.href='dataslot.php'; 
            }); 
         </script>
        ";
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
 		<h3 class="mb-4">DATA SLOT PARKIR</h3>

 <div class="row mb-3 table-responsive-sm">
    <div class="col mb-1">
      <div class="btn-group">
          <button type="button" class="tambah btn btn-danger mx-2" href="#tambahslot" data-toggle="modal"data-target="#tambahslot"><i class="fa fa-plus"></i></button>
           <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-map-marked-alt"></i></button>
           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="slotroda2.php?template=template.php"><i class="fa fa-bicycle"></i> Roda 2</a>
              <a class="dropdown-item" href="slotroda4.php?template=template.php"><i class="fa fa-car-side"></i> Roda 4</a>
              <a class="dropdown-item" href="slotroda6.php?template=template.php"><i class="fa fa-truck"></i> Roda 6</a>
           </div>
        </div>
      </div>
   </div>
   <div class="col mb-1 mr-5">
       <div class="form-group">
            <input class="form-control" id="keywordslot" placeholder="Masukkan Keyword Pencarian..." autocomplete="off" type="text" style="width: 17rem;">
       </div>
   </div>
  </div>

<div id="tabelslot">
 <div class="table-responsive-sm">
	<table class="table table-bordered table-hover  table-striped" style="width:55rem;">
	   <tr class="text-center text-white" style="background-color:#2d82b5"> 
		   <th>No.</th>
		   <th>Waktu</th>
		   <th>Slot Parkir</th>
		   <th>Kendaraan</th>
		   <th>Status</th>
       <th>User</th>
		   <th>Aksi</th>
	   </tr>
	<?php $i =1;
	      foreach ($dataslot as $slot) : 
	 ?>	
	   <tr>
		   <td class="text-center"><?= $i; ?></td>
		   <td class="text-center"><?= $slot["Waktu"];?></td>
		   <td class="text-center"><?= $slot["id_slot"];?></td>
           
           <?php 	
           		if ($slot["id_kendaraan"] == 1) {
           		   $kendaraan = '<i class="fa fa-bicycle"></i>';
           		}
           		if ($slot["id_kendaraan"] == 2) {
           		   $kendaraan = '<i class="fa fa-car-side"></i>';
           		}
           		if ($slot["id_kendaraan"] == 3) {
           		   $kendaraan = '<i class="fa fa-truck"></i>';
           		}
                echo '<td class="text-center">'.$kendaraan.'</td>';
            ?>
		   <td class="text-center"><?= $slot["Status"];?></td>
       <?php 
              if ($slot["id_card"] != "") {
                 echo ' <td class="text-center">'.$slot["id_card"].'</td>';
              }
              else{
                echo ' <td class="text-center">---</td>';
              }
        ?>
		   <td class="text-center">
		   	  <a class="hapus btn btn-danger btn-sm alert_hapus" href="hapus.php?id_slot=<?=$slot["id_slot"];?>"><i class="fa fa-trash"></i></a>
		   </td>
	   </tr>
	   <?php $i++; ?>
	  <?php endforeach; ?>
	</table>
 </div>
</div>

 <!-- Modal Tambah Slot -->
<div class="modal fade" id="tambahslot" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-plus"></i> TAMBAH SLOT</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="dataslot.php">
        <div class="modal-body">
      	  <div class="form-group">
              <div class="input-group mb-3">
        				 <input class="form-control" name="id_slot" type="text" autocomplete="off" placeholder="Masukkan Nama Slot" required>
        			 </div>
               <div class="input-group mb-3">
                  <select class="custom-select" name="id_kendaraan" id="inputGroupSelect01">
                    <option selected>Pilih Jenis Kendaraan</option>
                    <option value="1">Roda 2</option>
                    <option value="2">Roda 4</option>
                    <option value="3">Roda 6</option>
                  </select>
                </div>
               <input type="text" name="Status" value="kosong" hidden>
          </div>
        </div>  
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-plus"></i> Submit </button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>

</div>
 	</center>

     <script>
        var keyword = document.getElementById('keywordslot');
        var tabelslot = document.getElementById('tabelslot');
        
          keyword.addEventListener('keyup', function() {
              var xhr = new XMLHttpRequest();

              xhr.onreadystatechange = function() {
                  if(xhr.readyState == 4 && xhr.status == 200){
                   tabelslot.innerHTML = xhr.responseText;
                  }
              }

              xhr.open('GET', 'js/tabelslot.php?keywordslot='+keyword.value, true);
              xhr.send();
          });
      </script>

 </body>
 </html>