<?php 

require "../koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("location:../index.php");
    exit;
}


$data = query("SELECT * FROM tb_anggota WHERE Level = 'Anggota' ORDER BY Nama ASC"); 

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
   <p><h2>DATA ANGGOTA</h2></p>
  <table border = "1" cellpadding = "8" cellspacing = "0">
   <tr align="center"> 
   <th>No.</th>
   <th>ID Card</th>
   <th>ID Chat</th>
   <th>Nama Anggota</th>
   <th width="10px">L/P</th>
   <th>Saldo Akhir</th>
   </tr>';
    
    $i = 1;
    foreach ($data as $anggota) {
      	$cetak .= '<tr>
          			   <td>'.$i.'</td>
          			   <td>'.$anggota["id_card"].'</td>
                   <td>'.$anggota["id_chat"].'</td>
          			   <td>'.$anggota["Nama"].'</td>
          			   <td>'.$anggota["Gender"].'</td>
                   <td> Rp. '.number_format($anggota["Saldo"]).'</td>
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
$mpdf->Output('data anggota.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>