$(document).ready(function(){


		//real time halaman tambahmodal.php
				setInterval(function() {
            		$('.idmasuk').load('idmasuk.php');
          							}, 100);

		//real time halaman pengunjung.php
				setInterval(function() {
            		$('.pengunjung-value').load('pengunjung-value.php');
          							}, 100);

		//real time halaman dashboard.php
				setInterval(function() {
            		$('.dashboard-value').load('dashboard-value.php');
          							}, 100);

        //real time halaman slotroda2.php
                setInterval(function() {
                    $('.slotroda2-value').load('slotroda2-value.php');
                                    }, 100);

        //real time halaman slotroda4.php
                setInterval(function() {
                    $('.slotroda4-value').load('slotroda4-value.php');
                                    }, 100);

        //real time halaman slotroda6.php
                setInterval(function() {
                    $('.slotroda6-value').load('slotroda6-value.php');
                                    }, 100);

    //real time halaman dashboard_2.php
        setInterval(function() {
                $('.dashboard_2_value').load('dashboard_2_value.php');
                        }, 100);

    //real time halaman slot.php
        setInterval(function() {
                $('.slot-value').load('slot-value.php');
                        }, 100);

		//sweet alert hapus data 
          $('.alert_hapus').on('click',function(e){

                e.preventDefault();
                var getLink = $(this).attr('href');
                Swal.fire({
                        icon : 'warning',
                        title: 'Alert',
                        text: 'Apakah yakin ingin menghapus data ini?',
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,  
                    }).then((result) => {
                       if(result.value == true){
                        document.location.href = getLink;
                    }

            });
                
            });

          //sweet alert ubah status 
          $('.alert_status').on('click',function(e){

                e.preventDefault();
                var getLink = $(this).attr('href');
                Swal.fire({
                        icon : 'warning',
                        title: 'Alert',
                        text: 'Apakah yakin ingin mengubah status data ini?',
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,  
                    }).then((result) => {
                       if(result.value == true){
                        document.location.href = getLink;
                    }

            });
                
            });


          //sweet alert logout 
          $('.alert_logout').on('click',function(e){

                e.preventDefault();
                var getLink = $(this).attr('href');
                Swal.fire({
                        icon : 'warning',
                        title: 'Alert',
                        text: 'Apakah yakin ingin logout?',
                        confirmButtonColor: '#d9534f',
                        showCancelButton: true,  
                    }).then((result) => {
                       if(result.value == true){
                        document.location.href = getLink;
                    }
            });
            });          


  });