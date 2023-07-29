<?php 
require "template_2.php";
$data = query("SELECT * FROM tb_tarif");



	if(isset($_POST["kalkulasi"])){
		if ($_POST["id_kendaraan"] > 0) {
			    $id_kendaraan = $_POST["id_kendaraan"];
				$datatarif    = query("SELECT * FROM tb_tarif WHERE id_kendaraan = $id_kendaraan")[0];
				$kendaraan    = $datatarif["Kendaraan"];
				$waktu        = $_POST["durasi"];
				$diff         = strtotime($waktu);
				$date         = strtotime(date("Y-m-d"));
				$durasi       = $diff - $date;

				if ($durasi <= 3600) { //1 Jam
					$tarif = $datatarif["tarif_1"];
				}
				else if($durasi > 3600 AND $durasi <= 7200){ // 2 jam
					$tarif = $datatarif["tarif_2"];
				}
				else if($durasi > 7200 AND $durasi <= 10800){ // 3 jam
					$tarif = $datatarif["tarif_3"];
				}
				else if($durasi > 10800 AND $durasi <= 86400){ //3 - 24 jam
					$jam   = ($durasi - 10800)/3600;
		            $tarif = $datatarif["tarif_3"] + (ceil($jam) * $datatarif["tarif_4"]); 
				}

				echo "
		           <script> 
		             Swal.fire({ 
		                title: 'Tarif Rp.".number_format($tarif)."', 
		                text: 'Kendaraan: $kendaraan || Durasi: $waktu', 
		                icon: 'success', 
		                buttons: [false, 'OK'], 
		                }).then(function() { 
		                    window.location.href='regular.php'; 
		                }); 
		            </script>
		              ";
		}
		
         if ($_POST["id_kendaraan"] == 0) {
         	echo "
                <script> 
			         Swal.fire({ 
			            title: 'OOPS', 
			            text: 'Cek Ulang Inputan Anda!!!', 
			            icon: 'warning', 
			            dangerMode: true, 
			            buttons: [false, 'OK'], 
			            }).then(function() { 
			                window.location.href='regular.php'; 
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
 		<h3>REGULAR PARKING</h3>
 		<p class="mb-1"><?=$user." (ID ".$_SESSION["id_card"].")";?></p>


    <div class="container mt-4" style="width:23rem;">
 		<form method="post" action="regular.php">	
		 	    <div class="form-group">
		 	      <div class="input-group-prepend"></div>
					  <select name="id_kendaraan" class="custom-select">
	                      <option selected value="0">---Pilih Jenis Kendaraan---</option>
	                        <?php
	                             foreach ($data as $i) {
	                                echo "<option value=".$i['id_kendaraan'].">".$i['Kendaraan']."</option>"; 
	                            } ?> 
	                    </select>
	                 </div>
		             <div class="input-group mb-3">
		               <input class="form-control" name="durasi" type="time" placeholder="Durasi Parkir (hh:mm:ss)">
		             </div>
		        </div>
			<button type="submit" name="kalkulasi" class="btn btn-success"><i class="fa fa-calculator"></i> Kalkulasi
			</button>
		    <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset
		    </button> 
      </form>
	</div>     

 	</center>
 </body>
 </html>