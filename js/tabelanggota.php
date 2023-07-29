<?php 

require "../koneksidb.php";
$keywordanggota = $_GET["keywordanggota"];

$data    =  query("SELECT * FROM tb_anggota WHERE id_card LIKE '%$keywordanggota%' OR id_chat LIKE '%$keywordanggota%' OR Nama LIKE '%$keywordanggota%' ORDER BY NAMA ASC");

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>

<div class="table-responsive-sm">
<table class="table table-bordered table-hover  table-striped"style="width:80rem;">
   <tr class="text-center text-white" style="background-color:#2d82b5"> 
   <th>No.</th>
   <th>ID Card</th>
   <th>ID Chat</th>
   <th>Nama Anggota</th>
   <th width="10px">L/P</th>
   <th>Saldo</th>
   <th>Status</th>
   <th width="200px">Opsi</th>
   </tr>
<?php $i =1;?>

<?php foreach ($data as $anggota) :?> 
   <tr>
   <td class="text-center"><?= $i; ?></td>
   <td class="text-center"><?= $anggota["id_card"];?></td>
   <td class="text-center"><?= $anggota["id_chat"];?></td>
   <td><?= $anggota["Nama"];?></td>
   <td class="text-center"><?= $anggota["Gender"];?></td>
   <td class="text-center">Rp.<?= number_format($anggota["Saldo"]);?></td>

        <?php   
            if ($anggota["Status"] == 1) {
              echo '<td class="text-center text-success"><i class = "fa fa-user-check"></td>';
            }
            else{
              echo '<td class="text-center text-danger"><i class = "fa fa-user-lock"></td>';
            }

         ?>

   <td align="center">
    <div class="dropdown">
      <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" style="background-color:#F8D90F"><i class="fa fa-filter"></i> Opsi</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item kehadiran btn btn-sm" href="#"><i class="fa fa-clipboard"></i> Riwayat</a>
          <a class="dropdown-item ubah btn btn-sm" href="ubahanggota.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-edit"></i> Ubah</a>
          <a class="dropdown-item kehadiran btn btn-sm" href="transaksiuser.php?id_card=<?=$anggota["id_card"];?>&Nama=<?=$anggota["Nama"];?>"><i class="fa fa-table"></i> Transaksi</a>
          <a class="dropdown-item topup btn btn-sm" href="topup.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-database"></i> Topup</a>
          <a class="dropdown-item hapus btn btn-sm alert_hapus" href="hapus.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-trash-alt"></i> Hapus</a> 
          <?php   
              if ($anggota["Status"] == 1) {
                 echo '<a class="dropdown-item ubah btn alert_status btn-sm" href="status.php?id_card='.$anggota["id_card"].'&Status=0"><i class="fa fa-lock"></i> Blokir</a>'; 
              }
              else{
                 echo '<a class="dropdown-item ubah btn alert_status btn-sm" href="status.php?id_card='.$anggota["id_card"].'&Status=1"><i class="fa fa-unlock"></i> Buka blokir</a>'; 
              }
           ?>
           <a class="dropdown-item reset btn btn-sm" href="resetid.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-key"></i> Reset ID</a>      
        </div>
      </div>
    </td>
   </tr>
   <?php $i++; ?>
  <?php endforeach; ?>

</table>
</div> 	

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
    <<!-- script src="jquery-3.4.1.min.js"></script>
    <script src="script.js"></script> -->
 
 </body>
 </html>