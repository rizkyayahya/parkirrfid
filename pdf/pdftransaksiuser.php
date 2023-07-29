<?php 

require "../koneksidb.php";
session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("location:../index.php");
    exit;
}

$id_card = mysqli_escape_string($koneksi, $_GET["id_card"]);
$Nama    = mysqli_escape_string($koneksi, $_GET["Nama"]);

$Tanggal1      = mysqli_escape_string($Koneksi, $_GET["Tanggal1"]); $Waktu1 = $Tanggal1." 00:00:00";
$Tanggal2      = mysqli_escape_string($Koneksi, $_GET["Tanggal2"]); $Waktu2 = $Tanggal2." 23:59:59";

 $data = query("SELECT * FROM tb_transaksi WHERE id_card = '$id_card' AND  Waktu BETWEEN '$Waktu1' AND '$Waktu2'  ORDER BY no DESC");

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
   <p><h2>REKAMAN TRANSAKSI</h2></p>
    <table class="table">
      <tr>
        <th>ID Card :</th>
        <td>'.$id_card.'</td>
        <th>Nama :</th>
        <td>'.$Nama.'</td>
      <tr>
   </table>
  <table border = "1" cellpadding = "8" cellspacing = "0">
   <tr>
     <th>No.</th>
     <th width="200px">Waktu</th>
     <th>Kredit</th>
     <th>Debet</th>
     <th>Saldo</th>
     <th>Keterangan</th>
   </tr>';
    
    $i = 1;
    foreach ($data as $transaksi) {
      $cetak.='<tr>
               <td>'.$i.'</td>
               <td>'.$transaksi["Waktu"].'</td>
               <td> Rp. '.number_format($transaksi["Kredit"]).'</td>
               <td> Rp. '.number_format($transaksi["Debet"]).'</td>
               <td> Rp. '.number_format($transaksi["Saldo"]).'</td>
               <td>'.$transaksi["Ket"].'</td>
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
$mpdf->Output('Rekaman Transaksi '.$Nama.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>