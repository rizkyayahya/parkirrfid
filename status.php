<?php

require "template.php"; 


    if(isset($_GET["id_card"]) AND isset($_GET["Status"])){ 
        $Status  = mysqli_escape_string($koneksi, $_GET["Status"]);
        $id_card = mysqli_escape_string($koneksi, $_GET["id_card"]);
        if( ubahStatus($Status, $id_card) == NULL ) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Status Anggota Berhasil diubah',
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
                      text: 'Status Anggota Gagal diubah!!!', 
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

 

$koneksi->close();

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>';

 ?>