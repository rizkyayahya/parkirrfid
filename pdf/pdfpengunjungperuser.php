<?php 

require "../koneksidb.php"; 
session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("location:../index.php");
    exit;
}

$id_card = mysqli_escape_string($koneksi, $_GET["id_card"]);
$Nama    = mysqli_escape_string($koneksi, $_GET["Nama"]);

$Tanggal1      = mysqli_escape_string($koneksi, $_GET["Tanggal1"]);
$Tanggal2      = mysqli_escape_string($koneksi, $_GET["Tanggal2"]);

$data = query("SELECT * FROM tb_pengunjung WHERE id_card = '$id_card' AND Tanggal BETWEEN '$Tanggal1' AND '$Tanggal2' ORDER BY no DESC");

// Require composer autoload
require '../vendor/autoload.php';

// Define a default Landscape page size/format by name
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
                        'format' => 'A4-L',
                        'margin_top' => 0
                      ]);

$cetak = '<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<br>
  <center>
   <p><h2>REKAMAN PARKIR</h2></p>
   <table>
      <tr>
        <th>ID Card :</th>
        <td>'.$id_card.'</td>
        <th>Nama :</th>
        <td>'.$Nama.'</td>
      </tr>
   </table>
  <table border = "1" cellpadding = "8" cellspacing = "0">
   <tr>
   <th>No.</th>
   <th>Tanggal</th>
   <th>Jam Masuk</th>
   <th>Jam Keluar</th>
   <th>Durasi</th>
   <th>Kendaraan</th>
   <th>Tarif</th>
   </tr>';
    
    $i = 1;
    foreach ($data as $pengunjung) {
       $id_kendaraan  = $pengunjung["id_kendaraan"];
       $tgl_diff      = strtotime($pengunjung["Tanggal"]); //Konversi Tanggal ke detik
       $tgl           = date("d F Y", $tgl_diff); //konversi detik jadi tanggal format d F Y
       $Masuk         = date("H:i:s", $pengunjung["Masuk"]); //konversi detik ke jam -> Masuk
       $Keluar        = date("H:i:s", $pengunjung["Keluar"]); //konversi detik ke jam -> Keluar
       $durasi_diff   = $pengunjung["Keluar"] - $pengunjung["Masuk"];
       $Durasi        = date("H:i:s", $durasi_diff - $det); //konversi detik ke jam -> Durasi
       $datakendaraan = query("SELECT * FROM tb_tarif WHERE id_kendaraan = '$id_kendaraan'");
    	
      $cetak .= '<tr>
    			       <td>'.$i.'</td>
                 <td>'.$tgl.'</td>
                 <td>'.$Masuk.'</td>';
              
       if ($pengunjung["Keluar"] == 0) {
          $cetak.= '<td class="text-center">00:00:00</td>
                    <td class="text-center">00:00:00</td>';
       }
       else{
          $cetak.= '<td class="text-center">'.$Keluar.'</td>
                    <td class="text-center">'.$Durasi.'</td>';
       }
  
         foreach ($datakendaraan as $kendaraan) {
             $cetak.= '<td class="text-center">'.$kendaraan["Kendaraan"].'</td>';
         }

         $cetak.='<td> Rp. '.number_format($pengunjung["Tarif"]).'</td>
    	     </tr>';
       $i++;
    }
$cetak .= '</table>
            </center>
               </body>
         </html>';


// Write some HTML code:
$mpdf->WriteHTML($cetak);
// Output a PDF file directly to the browser
$mpdf->Output('Rekaman Parkir '.$Nama.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>