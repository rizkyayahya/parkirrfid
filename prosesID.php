<?php 

require "koneksidb.php";


//Data yang diterima dari Mikrokontroller
 $id_card      = mysqli_escape_string($koneksi, $_GET["id_card"]);
 $Token_web    = mysqli_escape_string($koneksi, $_GET["Token_web"]);
 $id_kendaraan = mysqli_escape_string($koneksi, $_GET["id_kendaraan"]);
 $Sensor       = mysqli_escape_string($koneksi, $_GET["Sensor"]);

 //data kendaraan
 $kendaraan   = query("SELECT * FROM tb_tarif WHERE id_kendaraan = '$id_kendaraan'")[0];             

 //variabel waktu
 $date = date("Y-m-d");
 $time = time();
	
 //Total Pengunjung
 $kunjungan      = "SELECT * FROM tb_pengunjung WHERE id_kendaraan = '$id_kendaraan' AND Keluar = 0";
 $result         = mysqli_query($koneksi, $kunjungan);
 $jml_kendaraan  = mysqli_num_rows($result);

 //Kapasitas Slot Kosong
 $slot           = "SELECT * FROM tb_slot WHERE id_kendaraan = '$id_kendaraan' AND Status = 0";
 $result_2       = mysqli_query($koneksi, $slot);
 $slot_kosong    = mysqli_num_rows($result_2);

if (isset(query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0])) {
   $anggota     = query("SELECT * FROM tb_anggota WHERE id_card = '$id_card'")[0];
   $id_chat     = $anggota["id_chat"];
   
    if($Token_web == $pengaturan["Token_web"]){	
		 //Jika ID terdaftar, kendaraan terdeteksi, dan Slot masih tersedia
		if($id_card == $anggota["id_card"] AND $Sensor == "0" AND $anggota["Status"] == 1){
		  $pengunjung  = query("SELECT * FROM tb_pengunjung WHERE id_card = '$id_card' 
		  	             ORDER BY no DESC")[0];
          $no          = $pengunjung["no"];		
			  if (($pengunjung["Masuk"] == null AND $slot_kosong > $jml_kendaraan) OR ($pengunjung["Keluar"] != 0 AND $slot_kosong > $jml_kendaraan)) {
					$Status = "Masuk";
					$Masuk  = date("H:i:s");
					$Saldo  = $anggota["Saldo"];
					$pesan  = "---KARCIS MASUK---\n\nID: ".$id_card."\nJam Masuk: ".$Masuk."\nJam Keluar: -\nDurasi: -\nKendaraan: ".$kendaraan["Kendaraan"]."\nTarif: Rp. -\nSaldo: Rp.".number_format($Saldo)."\n\n---SELAMAT DATANG---";
					tapMasuk($id_card, $date, $time, $id_kendaraan);
					$array  = ["Status" => "Masuk", "ID" => $id_card, "Jam_Masuk" => $Masuk, "Saldo" => number_format($Saldo)];
					if ($anggota["Sw_user"] == 1) {
						kirimPesan($id_chat, $pesan, $Token_bot); 
					}
					header("Location:tagID.php?masuk&id_card=$id_card");
			  }
			  else if (($pengunjung["Keluar"] == null AND $slot_kosong <= $jml_kendaraan) OR 
			  	($pengunjung["Keluar"] != 0 AND $slot_kosong <= $jml_kendaraan)){
			       $pesan  = "Mohon Maaf Parkiran ".$kendaraan["Kendaraan"]." Telah Penuh";
				   if ($anggota["Sw_user"] == 1) {
						kirimPesan($id_chat, $pesan, $Token_bot); 
					}
				   $array  = ["Status" => "Parkiran Penuh", "Slot" => $kendaraan["Kendaraan"]];
			       header("Location: tagID.php?full&kendaraan=".$kendaraan["Kendaraan"]);
		     }
			  else if($pengunjung["Keluar"] == 0 AND $pengunjung["id_kendaraan"] == $id_kendaraan){
				  	    $anggota4  = query("SELECT * FROM tb_pengunjung WHERE id_card = '$id_card' AND 
				  	    	      Keluar = 0 ORDER BY no DESC")[0];
				  	    $diff   = $time - $anggota4["Masuk"];
				  	    $durasi = date("H:i:s", $diff - $det);
						$Status = "Keluar";
						$Masuk  = date("H:i:s", $anggota4["Masuk"]);
						$Keluar = date("H:i:s");
						$ket    = "Parkir";
                   if($diff <= 3600 AND $anggota["Saldo"] >= $kendaraan["tarif_1"]){
                        $Tarif  = $kendaraan["tarif_1"];
                        $Saldo  = $anggota["Saldo"] - $Tarif;
						$pesan  = "---KARCIS KELUAR---\n\nID: ".$id_card."\nJam Masuk: ".$Masuk."\nJam Keluar: ".$Keluar."\nDurasi: ".$durasi."\nKendaraan: ".$kendaraan["Kendaraan"]."\nTarif: Rp. ".number_format($Tarif)."\nSaldo: Rp.".number_format($Saldo)."\n\n---TERIMAKASIH KUNJUNGAN ANDA---";
						tapKeluar($id_card, $time, $Tarif, $no);
						Debet($Tarif, $Saldo, $id_card, $ket);
						updatesaldo($Saldo, $id_card);
						$array  = ["Status" => "Keluar", "ID" => $id_card, "Jam_Masuk" => $Masuk, "Jam_Keluar" => $Keluar, "Durasi" => $durasi, "Tarif" => number_format($Tarif), "Saldo" => number_format($Saldo)]; 
						header("Location:tagID.php?keluar&id_card=$id_card");
                   }
                   else if ($diff > 3600 AND $diff <= 7200 AND $anggota["Saldo"] >= $kendaraan["tarif_2"]) {
                   	    $Tarif  = $kendaraan["tarif_2"]; 
                   	    $Saldo  = $anggota["Saldo"] - $Tarif;
						$pesan  = "---KARCIS KELUAR---\n\nID: ".$id_card."\nJam Masuk: ".$Masuk."\nJam Keluar: ".$Keluar."\nDurasi: ".$durasi."\nKendaraan: ".$kendaraan["Kendaraan"]."\nTarif: Rp. ".number_format($Tarif)."\nSaldo: Rp.".number_format($Saldo)."\n\n---TERIMAKASIH KUNJUNGAN ANDA---";
						tapKeluar($id_card, $time, $Tarif, $no);
						Debet($Tarif, $Saldo, $id_card, $ket);
						updatesaldo($Saldo, $id_card);
						$array  = ["Status" => "Keluar", "Durasi" => $durasi, "Tarif" => number_format($Tarif), "Saldo" => number_format($Saldo)];
						header("Location:tagID.php?keluar&id_card=$id_card"); 
                   }
                   else if ($diff > 7200 AND $diff <= 10800 AND $anggota["Saldo"] >= $kendaraan["tarif_3"]) {
                   	    $Tarif  = $kendaraan["tarif_3"]; 
                   	    $Saldo  = $anggota["Saldo"] - $Tarif;
						$pesan  = "---KARCIS KELUAR---\n\nID: ".$id_card."\nJam Masuk: ".$Masuk."\nJam Keluar: ".$Keluar."\nDurasi: ".$durasi."\nKendaraan: ".$kendaraan["Kendaraan"]."\nTarif: Rp. ".number_format($Tarif)."\nSaldo: Rp.".number_format($Saldo)."\n\n---TERIMAKASIH KUNJUNGAN ANDA---";
						tapKeluar($id_card, $time, $Tarif, $no);
						Debet($Tarif, $Saldo, $id_card, $ket);
						updatesaldo($Saldo, $id_card);
						$array  = ["Status" => "Keluar", "ID" => $id_card, "Jam_Masuk" => $Masuk, "Jam_Keluar" => $Keluar, "Durasi" => $durasi, "Tarif" => number_format($Tarif), "Saldo" => number_format($Saldo)]; 
						header("Location:tagID.php?keluar&id_card=$id_card");
                   }
                   else if($diff > 10800 AND $diff <= 86400){
                   	    $jam   = ($diff - 10800)/3600;
                   	    $Tarif = $kendaraan["tarif_3"] + (ceil($jam) * $kendaraan["tarif_4"]); 
                   	    $Saldo = $anggota["Saldo"] - $Tarif;
                      if ($anggota["Saldo"] >= $Tarif) {
                      	    $pesan  = "---KARCIS KELUAR---\n\nID: ".$id_card."\nJam Masuk: ".$Masuk."\nJam Keluar: ".$Keluar."\nDurasi: ".$durasi."\nKendaraan: ".$kendaraan["Kendaraan"]."\nTarif: Rp. ".number_format($Tarif)."\nSaldo: Rp.".number_format($Saldo)."\n\n---TERIMAKASIH KUNJUNGAN ANDA---";
                        	tapKeluar($id_card, $time, $Tarif, $no);
							Debet($Tarif, $Saldo, $id_card, $ket);
							updatesaldo($Saldo, $id_card);
							$array  = ["Status" => "Keluar", "ID" => $id_card, "Jam_Masuk" => $Masuk, "Jam_Keluar" => $Keluar, "Durasi" => $durasi, "Tarif" => number_format($Tarif), "Saldo" => number_format($Saldo)]; 
							header("Location:tagID.php?keluar&id_card=$id_card");
                       }
                       else if ($anggota["Saldo"] < $Tarif){
                       	    $pesan  = "Mohon Maaf Saldo Anda Tidak Mencukupi\n\nTarif: Rp.".number_format($Tarif)."\nSisa Saldo: Rp.".number_format($anggota["Saldo"]);
                        	$array  = ["Status" => "Saldo Habis", "Tarif" => number_format($Tarif), "Saldo" => number_format($anggota["Saldo"])]; 
                        	header("Location:tagID.php?habis");
                       }
                   }
                   else if($diff > 86400 ){ //86400 detik = 24 Jam
                        $durasi   = date_diff(date_create(), date_create($pengunjung["Tanggal"].$Masuk));
                        $waktu    = $durasi->h.":".$durasi->i.":".$durasi->s;
                        $hari     = $diff/86400;
                   	    $Tarif    = (floor($hari)*$kendaraan["tarif_5"]) + ($durasi->h*$kendaraan["tarif_4"]); 
                   	    $Saldo    = $anggota["Saldo"] - $Tarif;
                      if ($anggota["Saldo"] >= $Tarif) {
                      	    $pesan = "---KARCIS KELUAR---\n\nID: ".$id_card."\nWaktu Masuk: ".$pengunjung["Tanggal"]." ".$Masuk."\nWaktu Keluar: ".$date." ".$Keluar."\nKendaraan: ".$kendaraan["Kendaraan"]."\nTarif: Rp. ".number_format($Tarif)."\nSaldo: Rp.".number_format($Saldo)."\n\n---TERIMAKASIH KUNJUNGAN ANDA---";
                        	tapKeluar($id_card, $time, $Tarif, $no);
							Debet($Tarif, $Saldo, $id_card, $ket);
							updatesaldo($Saldo, $id_card);
							$array  = ["Status" => "Keluar", "ID" => $id_card, "Jam_Masuk" => $Masuk, "Jam_Keluar" => $Keluar, "Durasi" => $durasi, "Tarif" => number_format($Tarif), "Saldo" => number_format($Saldo)]; 
							header("Location:tagID.php?keluar&id_card=$id_card");
                       }
                       else if ($anggota["Saldo"] < $Tarif){
                       	    $pesan  = "Mohon Maaf Saldo Anda Tidak Mencukupi\n\nTarif: Rp.".number_format($Tarif)."\nSisa Saldo: Rp.".number_format($anggota["Saldo"]);
                        	$array  = ["Status" => "Saldo Habis", "Tarif" => number_format($Tarif), "Saldo" => number_format($anggota["Saldo"])]; 
                        	header("Location:tagID.php?habis");
                       }
                   }
                   else if($anggota["Saldo"] < $kendaraan["tarif_1"] OR $anggota["Saldo"] < $kendaraan["tarif_2"] OR $anggota["Saldo"] < $kendaraan["tarif_3"]){
                   	   if ($diff <= 3600) { $Tarif = $kendaraan["tarif_1"];}
                   	   else if ($diff > 3600 AND $diff <= 7200) { $Tarif = $kendaraan["tarif_2"];}
                   	   else if ($diff > 7200 AND $diff <= 10800) { $Tarif = $kendaraan["tarif_3"];}
                   	   
                       $pesan  = "Mohon Maaf Saldo Anda Tidak Mencukupi\n\nTarif: Rp.".number_format($Tarif)."\nSisa Saldo: Rp.".number_format($anggota["Saldo"]);
                       $array  = ["Status" => "Saldo Habis", "Tarif" => number_format($Tarif), "Saldo" => number_format($anggota["Saldo"])]; 
                       header("Location:tagID.php?habis");
                   }
                    if ($anggota["Sw_user"] == 1) {
						kirimPesan($id_chat, $pesan, $Token_bot); 
					}
					//header("Location:tagID.php?habis");
			   }
			    else if($pengunjung["Keluar"] == 0 AND $pengunjung["id_kendaraan"] != $id_kendaraan){
			    	$array = ["Status" => "Unmatched Object"];
			    	header("Location:tagID.php?unmatched");
			    }	  
		}
		else if($id_card == $anggota["id_card"] AND $Sensor == "1" AND $anggota["Status"] == 1 ){
		  $array = ["Status" => "Undetected Object"];
		}
		else if($anggota["Status"] == 0 ){
		   $pesan = "Akses Parkir ditolak!!!\nKartu Anda Terblokir!!!";
		   $array = ["Status" => "Kartu Anda Terblokir!!!"];
		   kirimPesan($anggota["id_chat"], $pesan, $Token_bot);
	    }
	}
	else {
		$array = ["Status" => "Autentikasi Ditolak!!!"];
	}
}
else{
	$array = ["Status" => "ID Tidak Terdaftar"];
    $sql = "UPDATE tb_pengaturan SET idbaru = '$id_card'";
	$koneksi->query($sql);
    header("Location:tagID.php?unregister&id_card=$id_card");
}

		
	            //cetak data json ke browser
	            $response = json_encode($array);
	            echo $response;
                $koneksi->close();		
	

	


 ?>