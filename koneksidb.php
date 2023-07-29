<?php

$server       = "localhost";
$user         = "root";
$password     = "";
$database     = "parkirrfid"; //Silakan ganti dengan nama database anda

$koneksi      = mysqli_connect($server, $user, $password, $database);


function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query );
    $box = [];
    while( $siswa = mysqli_fetch_assoc($result) ){
    $box[] = $siswa;
    }
    return $box;
}

$pengaturan = query("SELECT * FROM tb_pengaturan")[0];
$Token_bot  = $pengaturan["Token_bot"];

//Zona Waktu
$Zona = 'Asia/Makassar'; //Silakan disesuaikan dengan zona waktu wilayah masing-masing
date_default_timezone_set($Zona);

  if ($Zona == 'Asia/Jakarta') { //WIB
    $det = 25200; //7 jam 
  }
  else if ($Zona == 'Asia/Makassar') { //WITA
    $det = 28800; //8 jam 
  }
  else if ($Zona == 'Asia/Jayapura') { //WIT
    $det = 32400; //9 jam 
  }


function tambahanggota ($post) {
      global $koneksi;
      $id_card   = htmlspecialchars($post ['idbaru']);
      $id_chat   = htmlspecialchars($post ['id_chat']);
      $Nama      = htmlspecialchars($post ['Nama']);
      $Gender    = htmlspecialchars($post ['Gender']);
      $Saldo     = htmlspecialchars($post ['Kredit']);
      $Level     = $post ["Level"];
      $password  = password_hash($post ["idbaru"], PASSWORD_DEFAULT);
      $Sw_user   = 1;
      $date      = date("Y-m-d");
      $status    = 1;
      $Ket       = $post["Ket"];

        //insert data ke tb_anggota
      $query = "INSERT INTO tb_anggota VALUES 
               ('$id_card', '$id_chat ','$Nama', '$Gender', '$Saldo', '$Sw_user', '$date', '$status',
                '$password', '$Level')"; 
      mysqli_query($koneksi, $query);
      return mysqli_affected_rows($koneksi);
    }


    function ubahanggota ($post) {
      global $koneksi;
      $id_card = htmlspecialchars($post ['id_card']);
      $id_chat = htmlspecialchars($post ['id_chat']);
      $Nama    = htmlspecialchars($post ['Nama']);
      $Gender  = htmlspecialchars($post ['Gender']);
     
             //update data ke tb_anggota
      $query = "UPDATE tb_anggota SET id_chat = '$id_chat', Nama = '$Nama', Gender   = '$Gender'
                WHERE id_card  = '$id_card'";  
   
           mysqli_query($koneksi, $query);
           return mysqli_affected_rows($koneksi);
    }

    function tagLokasi ($post) {
      global $koneksi;
      $id_card = htmlspecialchars($post ['id_card']);
      $lokasi  = htmlspecialchars($post ['lokasi']);
      
      //update data ke tb_slot
      $query = "UPDATE tb_slot SET id_card = '$id_card' WHERE id_slot  = '$lokasi'";  
   
           mysqli_query($koneksi, $query);
           return mysqli_affected_rows($koneksi);
    }

    function ubahtarif($post) {
      global $koneksi;
      $id_kendaraan = $post["id_kendaraan"];
      $tarif_1      = htmlspecialchars($post ['tarif_1']);
      $tarif_2      = htmlspecialchars($post ['tarif_2']);
      $tarif_3      = htmlspecialchars($post ['tarif_3']);
      $tarif_4      = htmlspecialchars($post ['tarif_4']);
      $tarif_5      = htmlspecialchars($post ['tarif_5']);
             //update data ke tb_tarif
      $query = "UPDATE tb_tarif SET tarif_1 = '$tarif_1', tarif_2 = '$tarif_2', tarif_3 = '$tarif_3', 
                tarif_4 = '$tarif_4', tarif_5 = '$tarif_5' WHERE id_kendaraan  = '$id_kendaraan'";  
   
           mysqli_query($koneksi, $query);
           return mysqli_affected_rows($koneksi);
    }

            function aturToken ($post) {
              global $koneksi;
              $id_card    = htmlspecialchars($post ["id_card"]);
              $anggota    = query("SELECT * FROM tb_anggota WHERE id_card  = '$id_card'")[0];
              $Token_bot  = htmlspecialchars($post ['TOKEN']);
              $Token_web  = htmlspecialchars($post ['web']);
              $Password   = mysqli_real_escape_string($koneksi, $post["Password"]);
              
              //cek password
              if(password_verify($Password, $anggota["Password"])){
                //insert data ke tabel_pengaturan
                $query = "UPDATE tb_pengaturan SET 
                         Token_bot   = '$Token_bot', Token_web = '$Token_web'";  
                mysqli_query($koneksi, $query);
                return mysqli_affected_rows($koneksi);
              }
            }

            function resetPassword ($post) {
                global $koneksi;
                $ID         =  $post ["ID"];
                $anggota    =  query("SELECT * FROM tb_anggota WHERE id_card  = '$ID'")[0];
                $passbaru   =  mysqli_real_escape_string($koneksi, $post["passbaru"]);
                $passbaru2  =  mysqli_real_escape_string($koneksi, $post["passbaru2"]);

                 //cek password
                 if($passbaru == $passbaru2 ){
                    $password = password_hash($passbaru, PASSWORD_DEFAULT);//enkripsi password
                    //set password baru ke tabel_anggota
                    $query = "UPDATE tb_anggota SET Password = '$password' 
                              WHERE id_card = '$ID'";
                    mysqli_query($koneksi, $query);
                    return mysqli_affected_rows($koneksi);
                  }
            }

             function aturAdmin ($post) {
                global $koneksi;
                $id_card    =  htmlspecialchars($post ["id_card"]);
                $anggota    =  query("SELECT * FROM tb_anggota WHERE id_card  = '$id_card'")[0];
                $id_chat    =  htmlspecialchars($post ["id_chat"]);
                $Password   =  mysqli_real_escape_string($koneksi, $post["Password"]);
              
                 //cek password
                 if(password_verify($Password, $anggota["Password"])){
                    $query = "UPDATE tb_anggota SET id_chat = '$id_chat' 
                             WHERE id_card  = '$id_card'";
                    mysqli_query($koneksi, $query);
                    return mysqli_affected_rows($koneksi);
                  }
            }

            function ubahPassword ($post) {
                global $koneksi;
                $id_card    =  $post ["id_card"];
                $anggota    =  query("SELECT * FROM tb_anggota WHERE id_card  = '$id_card'")[0];
                $passlama   =  mysqli_real_escape_string($koneksi, $post["passlama"]);
                $passbaru   =  mysqli_real_escape_string($koneksi, $post["passbaru"]);
                $passbaru2  =  mysqli_real_escape_string($koneksi, $post["passbaru2"]);

                 //cek password
                 if(password_verify($passlama, $anggota["Password"]) AND $passbaru == $passbaru2 ){
                    $password = password_hash($passbaru, PASSWORD_DEFAULT);//enkripsi password
                    //set password baru ke tabel_anggota
                    $query = "UPDATE tb_anggota SET Password = '$password' 
                              WHERE id_card = '$id_card'";
                    mysqli_query($koneksi, $query);
                    return mysqli_affected_rows($koneksi);
                  }
            }
            
           function topup ($post) {
              global $koneksi;
              $Status   = htmlspecialchars($post ['Status']);
              $id_card  = htmlspecialchars($post ['idbaru']);
              $Saldo    = htmlspecialchars($post ['Saldo']);
              $Kredit   = htmlspecialchars($post ['Kredit']);
              $saldonew = $Saldo + $Kredit;
              $Ket      = $post ['Ket'];

              if ($Status == 1) {
                 $query = "UPDATE tb_anggota SET Saldo = '$saldonew' WHERE id_card  = '$id_card'";
                 mysqli_query($koneksi, $query);
                 return mysqli_affected_rows($koneksi);
              }
         }

         function Transfer($post){
            global $koneksi;
            $Password         = mysqli_real_escape_string($koneksi, $post["Password"]);
            $id_penerima      = htmlspecialchars($post ['id_penerima']);
            $id_pengirim      = htmlspecialchars($post ['id_pengirim']);
            $Nominal          = htmlspecialchars($post ['Nominal']);
            $Saldo_pengirim   = htmlspecialchars($post ['Saldo_pengirim']);
            $Saldo_pengirim_2 = $Saldo_pengirim - $Nominal;
            // select data penerima
            $Data_penerima    = query("SELECT * FROM tb_anggota WHERE id_card = '$id_penerima'")[0];
            $Nama_penerima    = $Data_penerima["Nama"];
            $Saldo_penerima   = $Data_penerima["Saldo"];
            $Saldo_penerima_2 = $Saldo_penerima + $Nominal;
            //select data pengirim
            $Data_pengirim    = query("SELECT * FROM tb_anggota WHERE id_card = '$id_pengirim'")[0];
            $Nama_pengirim    = $Data_pengirim["Nama"];
            //Keterangan
            $Ket_penerima     = "Transfer dari ".$Nama_pengirim." (ID ".$id_pengirim.")";
            $Ket_pengirim     = "Transfer ke ".$Nama_penerima." (ID ".$id_penerima.")";
            //data password
            $datapassword     = query("SELECT * FROM tb_anggota WHERE id_card = '$id_pengirim'")[0];

              if (password_verify($Password, $datapassword["Password"])) {
                //insert Kredit Penerima
                $Kredit = "INSERT INTO tb_transaksi (id_card, Kredit,  Saldo, Ket)
                           VALUES ('$id_penerima', '$Nominal', '$Saldo_penerima_2', '$Ket_penerima')";

                //insert Debet Pengirim
                $Debet = "INSERT INTO tb_transaksi (id_card, Debet,  Saldo, Ket)
                          VALUES ('$id_pengirim', '$Nominal', '$Saldo_pengirim_2', '$Ket_pengirim')";

                //Update Saldo Penerima
                $updatesaldo_penerima = "UPDATE tb_anggota SET Saldo = '$Saldo_penerima_2' 
                                        WHERE id_card  = '$id_penerima'";

                //Update Saldo Pengirim
                $updatesaldo_pengirim = "UPDATE tb_anggota SET Saldo = '$Saldo_pengirim_2' 
                                        WHERE id_card  = '$id_pengirim'";
                
                mysqli_query($koneksi, $Kredit);
                mysqli_query($koneksi, $Debet);
                mysqli_query($koneksi, $updatesaldo_penerima);
                mysqli_query($koneksi, $updatesaldo_pengirim);
                return mysqli_affected_rows($koneksi);
              }
          }

          function tambahSlot($post){
            global $koneksi;
            $id_kendaraan = htmlspecialchars($post ['id_kendaraan']);
            $id_slot      = htmlspecialchars($post ['id_slot']);
            $Status       = htmlspecialchars($post ['Status']);
            
            // insert data ke tb_slot
             $query = "INSERT INTO tb_slot (id_slot, Status, id_kendaraan)
                       VALUES ('$id_slot', '$Status', $id_kendaraan)";
            
                   mysqli_query($koneksi, $query);
                   return mysqli_affected_rows($koneksi);
          }

         function Kredit($post){
            global $koneksi;
            $id_card   = htmlspecialchars($post ['idbaru']);
            $Kredit    = htmlspecialchars($post ['Kredit']);
            $Saldo     = htmlspecialchars($post ['Saldo']);
            $saldonew  = $Kredit + $Saldo;
            $Ket       = htmlspecialchars($post ['Ket']);
            // insert data ke tb_transaksi
             $query = "INSERT INTO tb_transaksi (id_card, Kredit,  Saldo, Ket)
                       VALUES ('$id_card', '$Kredit', '$saldonew', '$Ket')";
            
                   mysqli_query($koneksi, $query);
                   return mysqli_affected_rows($koneksi);
          }

          function Debet($Tarif, $Saldo, $id_card, $ket){
            global $koneksi;
            // insert data ke tb_transaksi
             $query = "INSERT INTO tb_transaksi (id_card, Debet,  Saldo, Ket)
                       VALUES ('$id_card', '$Tarif', '$Saldo', '$ket')";
            
                   mysqli_query($koneksi, $query);
                   return mysqli_affected_rows($koneksi);
          }

           function updatesaldo($Saldo, $id_card){
            global $koneksi;
            // update data ke tb_anggota
              $query = "UPDATE tb_anggota SET Saldo = '$Saldo' WHERE id_card  = '$id_card'";
              mysqli_query($koneksi, $query);
              return mysqli_affected_rows($koneksi);
          }

          function resetID($post){
            global $koneksi;
            $id_baru = htmlspecialchars($post['idbaru']);
            $id_card = htmlspecialchars($post['id_card']); 
            // update data ke tb_anggota
              $query = "UPDATE tb_anggota SET id_card = '$id_baru' WHERE id_card  = '$id_card'";
              mysqli_query($koneksi, $query);
              return mysqli_affected_rows($koneksi);
          }

          function updateSlot($id_slot, $Status){
            global $koneksi;
            // update data ke tb_slot
              $query = "UPDATE tb_slot SET Status = '$Status' WHERE id_slot = '$id_slot'";
              mysqli_query($koneksi, $query);
              return mysqli_affected_rows($koneksi);
          }
       
        function tapMasuk($id_card, $date, $Masuk, $id_kendaraan){
          global $koneksi;
          $sql  = "INSERT INTO tb_pengunjung (id_card, Tanggal, Masuk, Keluar, id_kendaraan, Tarif) VALUES ('$id_card', '$date', '$Masuk', '', '$id_kendaraan', '')";
          $koneksi->query($sql);
          return;
        }

        function tapKeluar($id_card, $Keluar, $Tarif, $no){
          global $koneksi;
          $sql     = "UPDATE tb_pengunjung SET Keluar = '$Keluar', Tarif = '$Tarif' 
                      WHERE no = '$no'";
          $sql2    = "UPDATE tb_slot SET id_card = '' WHERE id_card = '$id_card'";
          $koneksi->query($sql);
          $koneksi->query($sql2);
          return;
        }
      
      function ubahStatus ($Status, $id_card){
            global $koneksi;;
            $sql     = "UPDATE tb_anggota SET Status = '$Status' WHERE id_card = '$id_card'";
            $koneksi->query($sql);
            return;
        }

     
        function hapusanggota ($id_card) {
            global $koneksi;
            mysqli_query($koneksi, "DELETE FROM tb_anggota WHERE id_card = '$id_card'");

            return mysqli_affected_rows($koneksi);
        }
        function hapusslot ($id_slot) {
            global $koneksi;
            mysqli_query($koneksi, "DELETE FROM tb_slot WHERE id_slot = '$id_slot'");

            return mysqli_affected_rows($koneksi);
        }

        //function kirim pesan telegram
        function kirimPesan($id_chat, $pesan, $Token_bot) {
          $url = "https://api.telegram.org/bot".$Token_bot."/sendMessage?parse_mode=markdown&chat_id=". $id_chat;
              $url = $url."&text=".urlencode($pesan);
              $ch  = curl_init();
              $optArray = array(
                      CURLOPT_URL => $url,
                      CURLOPT_RETURNTRANSFER => true
              );
              curl_setopt_array($ch, $optArray);
              $result = curl_exec($ch);
              curl_close($ch);
          }

 ?>