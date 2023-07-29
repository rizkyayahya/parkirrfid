<?php

require "template.php";


$data = query("SELECT * FROM tb_anggota WHERE Level = 'Anggota' ORDER BY Nama ASC"); 
$date = date('Y-m-d');

$Token_bot   = $pengaturan["Token_bot"];

//cek apakah kolom idbaru pada tabel pengaturan kosong atau tidak
if ($pengaturan["idbaru"] !== "") {
   $sql = "UPDATE tb_pengaturan SET idbaru = ''";
   $koneksi->query($sql);
}

if(isset($_POST["simpan"]))  {
    if( tambahanggota($_POST) > 0 ) {
      //kirim pesan telegram
      $id_chat = $_POST["id_chat"];
      $pesan="SELAMAT BERGABUNG!!!\nData Diri Anda Berhasil ditambahkan\n\nID: ".$_POST["idbaru"]."\nNama: ".$_POST["Nama"]."\nSaldo Awal: Rp.".number_format($_POST["Kredit"])."\nPassword: ".$_POST["idbaru"]."\n\nData ditambahkan pada: \n".date("d F Y H:i:s")."\n\nSilakan melakukan penggantian Password demi keamanan akun anda. Terimakasih";
      Kredit($_POST);
      kirimpesan($id_chat, $pesan, $Token_bot);
          
            echo "
                 <script> 
                  Swal.fire({ 
                  title: 'BERHASIL',
                  text: 'Data Telah disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                      window.location.href='dataanggota.php'; 
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
                window.location.href='dataanggota.php'; 
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

<!--  -->
  <center>
    <h3 class="mb-4 mt-2">DATA ANGGOTA</h3>
    

 <div class="row table-responsive-sm">
    <div class="col mb-2">
      <div class="btn-group">
          <button type="button" class="tambah btn btn-danger mx-2" href="#tambahanggota" data-toggle="modal"data-target="#tambahanggota"><i class="fa fa-user-plus"></i>
          </button>
          <div class="dropdown">
              <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download"></i></button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="pdf/pdfanggota.php"><i class="fa fa-file-pdf"></i> Export to PDF</a>
                  <a class="dropdown-item" href="excel/excelanggota.php"><i class="fa fa-file-excel"></i> Export to Excel</a>
              </div>
          </div>
      </div>
    </div>
    <div class="col">
          <div class="form-group">
                <input class="form-control" id="keywordanggota" placeholder="Masukkan Keyword Pencarian" autocomplete="off"  type="text" style="width: 20rem;">
          </div>
    </div>
  </div>

<div id="tabelanggota">
<div class="table-responsive-sm">
<table class="table table-bordered table-hover  table-striped"style="width:80rem;">
   <tr class="text-center text-white" style="background-color:#2d82b5"> 
   <th>No.</th>
   <th>ID Card</th>
   <th>ID Chat</th>
   <th>Nama Anggota</th>
   <th width="10px">L/P</th>
   <th>Saldo</th>
   <th width="100px">Telegram</th>
   <th width="100px">Status</th>
   <th width="120px">Opsi</th>
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
            if ($anggota["Sw_user"] == 1) {
                  echo '<td class="text-center text-success"><i class = "fa fa-toggle-on"></td>';
                }
            else{
                  echo '<td class="text-center text-danger"><i class = "fa fa-toggle-off"></td>';
            } 

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
          <a class="dropdown-item kehadiran btn btn-sm" href="pengunjungperuser.php?id_card=<?=$anggota["id_card"];?>&Nama=<?=$anggota["Nama"];?>"><i class="fa fa-clipboard"></i> Riwayat</a>
          <a class="dropdown-item ubah btn btn-sm" href="ubahanggota.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-edit"></i> Ubah</a>
          <a class="dropdown-item kehadiran btn btn-sm" href="transaksiuser.php?id_card=<?=$anggota["id_card"];?>&Nama=<?=$anggota["Nama"];?>"><i class="fa fa-hand-holding-usd"></i> Transaksi</a>
          <a class="dropdown-item topup btn btn-sm" href="topup.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-money-bill-alt"></i> Topup</a>
          <a class="dropdown-item hapus btn btn-sm alert_hapus" href="hapus.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-trash-alt"></i> Hapus</a> 
          <?php   
              if ($anggota["Status"] == 1) {
                 echo '<a class="dropdown-item ubah btn alert_status btn-sm" href="status.php?id_card='.$anggota["id_card"].'&Status=0"><i class="fa fa-lock"></i> Blokir</a>'; 
              }
              else{
                 echo '<a class="dropdown-item ubah btn alert_status btn-sm" href="status.php?id_card='.$anggota["id_card"].'&Status=1"><i class="fa fa-unlock"></i> Buka blokir</a>'; 
              }
           ?> 
           <a class="dropdown-item reset btn btn-sm" href="resetID.php?id_card=<?=$anggota["id_card"];?>"><i class="fa fa-id-card"></i> Reset ID</a>   
        </div>
      </div>
    </td>
   </tr>
   <?php $i++; ?>
  <?php endforeach; ?>

</table>
</div>
</div>

</center>

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="tambahanggota" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#2d82b5">
        <h5 class="modal-title"><i class="fa fa-user-plus"></i> REGISTRASI ANGGOTA</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="dataanggota.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                        <div class="idmasuk"></div><br> 
                          <input class="form-control" name="id_chat" type="text" autocomplete="off" placeholder="ID Chat Bot Telegram" required><br>
                          <input class="form-control" name="Nama" type="text" autocomplete="off" placeholder="Nama Lengkap" required><br>
                          <div class="row px-5">
                            <div class="col">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="Gender" value="L" required>
                                <label class="form-check-label">Laki laki</label>
                              </div>
                            </div>
                            <div class="col">
                               <div class="form-check">
                                  <input class="form-check-input" type="radio" name="Gender" value="P" required>
                                  <label class="form-check-label">Perempuan</label>
                              </div>
                            </div>
                          </div>        
                    <br>
                    <input class="form-control" id="Kredit" name="Kredit" type="number" autocomplete="off" placeholder="Saldo Rupiah" required>
                    <input id="Kredit" name="Saldo" type="number" value = "0" hidden>
                    <input type="text" name="Level" value = "Anggota" hidden>
                    <input type="text" name="Ket" value = "Topup" hidden>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

 <script>
        var keyword = document.getElementById('keywordanggota');
        var tabelanggota = document.getElementById('tabelanggota');
        
          keyword.addEventListener('keyup', function() {
              var xhr = new XMLHttpRequest();

              xhr.onreadystatechange = function() {
                  if(xhr.readyState == 4 && xhr.status == 200){
                   tabelanggota.innerHTML = xhr.responseText;
                  }
              }

              xhr.open('GET', 'js/tabelanggota.php?keywordanggota='+keyword.value, true);
              xhr.send();
          });
      </script>

</body>
</html> 
