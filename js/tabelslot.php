<?php 	
require "../koneksidb.php";
$keywordslot = $_GET["keywordslot"];

$dataslot    =  query("SELECT * FROM tb_slot WHERE id_slot LIKE '%$keywordslot%' OR
                id_card LIKE '%$keywordslot%'");



 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
 
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
           		   $kendaraan = '<i class="fa fa-car"></i>';
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

 	</center>

 	<script >
 		$(document).ready(function(){
 		 //sweet alert hapus data 
          $('.alert_hapus').on('click',function(e){

                e.preventDefault();
                var getLink = $(this).attr('href');
                Swal.fire({
                        icon : 'warning',
                        title: 'Alert',
                        text: 'Apakah yakin ingin menghapus data ini?',
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,  
                    }).then((result) => {
                       if(result.value == true){
                        document.location.href = getLink;
                    }

            });
                
            });
         });
 	</script>

 	<!-- My Javascript/jQuery -->
    <!-- <script src="jquery-3.4.1.min.js"></script>
    <script src="script.js"></script> -->
    
 </body>
 </html>