<?php 
	require "template.php";

	$data = query("SELECT * FROM tb_tarif");

 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  	<h3 class="mb-4 mt-2">DATA TARIF PARKIR</h3>
  	
<div class="col-sm">
  <div class="table-responsive-sm">
	<table class="table table-bordered table-hover  table-striped" style="width:70rem;">
	   <tr class="text-center text-white" style="background-color:#2d82b5"> 
		   <th>No.</th>
		   <th>Kendaraan</th>
		   <th>1 Jam</th>
		   <th>2 Jam</th>
		   <th>3 Jam</th>
		   <th>> 3 Jam</th>
		   <th>> 24 Jam</th>
		   <th>Aksi</th>
	   </tr>
	<?php $i =1;
	      foreach ($data as $tarif) : 
	 ?>	
	   <tr>
		   <td class="text-center"><?= $i; ?></td>
		   <td class="text-center"><?= $tarif["Kendaraan"];?></td>
		   <td class="text-center">Rp. <?= number_format($tarif["tarif_1"]);?></td>
		   <td class="text-center">Rp. <?= number_format($tarif["tarif_2"]);?></td>
		   <td class="text-center">Rp. <?= number_format($tarif["tarif_3"]);?></td>
		   <td class="text-center">Rp. <?= number_format($tarif["tarif_4"]);?>/jam</td>
		   <td class="text-center">Rp. <?= number_format($tarif["tarif_5"]);?>/hari</td>
		   <td class="text-center">
		   	  <a class="ubah btn btn-success btn-sm" href="ubahtarif.php?id_kendaraan=<?=$tarif["id_kendaraan"];?>"><i class="fa fa-edit"></i></a>
		   </td>
	   </tr>
	   <?php $i++; ?>
	  <?php endforeach; ?>
	</table>
 </div>
</div>

  </center>	

</body>
</html>