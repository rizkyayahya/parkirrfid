<?php 

session_start();

//cek cookie
if(isset($_COOKIE['login'])){
  if ($_COOKIE['login'] == 'true'){
     $_SESSION['login'] = true;
  }
}

 require 'koneksidb.php';

 $id_card = $_GET["ID"];
 $uniqid  = $_GET["uniqid"];

 $date_now  = date("Y-m-d");


 $TOKEN     = $pengaturan["Token_bot"];
 $data      = query("SELECT * FROM tabel_reset_password WHERE ID = '$id_card'
              AND uniqid = '$uniqid'")[0];
 $data2     = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];
 $ID_CHAT   = $data2["id_chat"];

 

 //Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["kirim"]))  { 
    if(resetPassword($_POST) > 0) {
       header("Location:index.php?reset&ID_CHAT=".$_POST["ID_CHAT"]);                   
    }
    else {
       header("Location:index.php?gagal&ID_CHAT=".$_POST["ID_CHAT"]);
    }
 } 

 else if ($data AND $data["expdate"] !== $date_now) {
   header("Location:index.php?inactive&ID_CHAT=".$data2["ID_CHAT"]);
 } 



  
 ?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

    <!-- Font Awesome -->
     <link href="fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->

    <title>Parkir RFID</title>
  </head>
  <body>

    <center>

    <h2 class="mb-4 mt-4">SISTEM PARKIR RFIDK</h2>

     <h5 class="mb-2">RESET PASSWORD</h5>
          <div class="card text-white mb-3" style="max-width: 20rem; background-color:#015c92;">
            <div class="card-body">
              <h5 class="card-title"><i class="fa fa-parking"></i> SISTEM PARKIR RFID</h5>
                 <form action="reset-password.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="password" name="passbaru" class="form-control" placeholder="Password Baru"><br>
                                <input type="password" name="passbaru2" class="form-control" placeholder="Konfirmasi Password">
                                <input type="text" name="ID" value="<?=$id_card;?>" hidden>
                                <input type="text" name="ID_CHAT" value="<?=$ID_CHAT;?>" hidden>
                            </div>
                         </div>
                     <div class="modal-footer">
                        <button type="submit" name="kirim" class="btn btn-success btn-block"><i class="fa fa-sign-in-alt"></i> Kirim</button>
                    </div>
                </form>
            </div>
          </div>
          

       <footer><strong>Copyright &copy;2020 Rizky Project</strong></footer>

     </center>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>

    <!-- My Javascript/jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/script.js"></script>

    <!-- Sweet Alert -->
    <script src="js/sweetalert2.all.min.js"></script>


  </body>
</html>