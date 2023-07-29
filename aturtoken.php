<?php   
  require "template.php";

  $id_card    = $_SESSION['id_card']; 
  $data       = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];

  //Cek tombol simpan apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan token
    if(aturToken($_POST) > 0) {
            echo "
           <script>
                Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data telah berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='aturtoken.php'; 
                  }); 
           </script>
                ";      
    }
    else {
          echo "
            <script> 
             Swal.fire({ 
                title: 'OOPS', 
                text: 'Data telah gagal disimpan!!!', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='aturtoken.php'; 
                }); 
             </script>
            ";
    }
 }  
      

 

 ?>

 <!DOCTYPE html>
 <html>
 <head>
  <title> </title>
 </head>
 <body>
  <center>
    <h3 class="mb-4 mt-2">AUTENTIKASI</h3>

     <div class="container my-4">
    <form method="post" action="aturtoken.php"> 
      <div class="table-responsive-sm">
             <table class="table" style="width:40rem;">
              <tr class="text-white" style="background-color:#2d82b5">
                <th class="text-center">Variabel</th>
                <th class="text-center">Autentikasi</th>
              </tr>
              <tr>
                <td>Telegram</td>
                <td><input type="text" class="form-control"name = "TOKEN" autocomplete="off" value="<?=$pengaturan["Token_bot"]?>"></td>
              </tr>
              <tr>
                <td>Web</td>
                <td><input type="text" class="form-control"name = "web" autocomplete="off" value="<?=$pengaturan["Token_web"]?>"></td>
              </tr>

              <tr>
                <td>Password</td>
                <td><input type="password" class="form-control"name = "Password" autocomplete="off" placeholder="Masukkan Password" required></td>
              </tr>
                 <input type="text" name="id_card" value="<?=$id_card;?>" hidden>
             </table>
          </div>
         <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
         <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button>
          </form>
    </div>     

  </center>

 </body>
 </html>