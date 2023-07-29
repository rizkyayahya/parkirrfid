<?php

require "template.php"; 


    if(isset($_GET["id_card"])){    
        if( hapusanggota($_GET ["id_card"]) > 0 ) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Data Anggota Telah dihapus',
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
                      text: 'Data gagal dihapus', 
                      icon: 'warning', 
                      dangerMode: true, 
                      buttons: [false, 'OK'], 
                      }).then(function() { 
                          window.location.href=''; 
                      }); 
             </script>
           ";
        }
  }

  if(isset($_GET["id_slot"])){    
        if( hapusslot($_GET ["id_slot"]) > 0 ) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Data Slot Telah dihapus',
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
                      text: 'Data gagal dihapus', 
                      icon: 'warning', 
                      dangerMode: true, 
                      buttons: [false, 'OK'], 
                      }).then(function() { 
                          window.location.href=''; 
                      }); 
             </script>
           ";
        }
  }

 

$koneksi->close();

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>';



 ?>