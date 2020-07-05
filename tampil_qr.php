<?php
	  echo '<h1 class="text-info">Bukti Kunjungan</h1>
             
            Tunjukkan pada petugas jika diminta<br>
            <img src="images/qrwithlogo.png"><br>
            <h3>'.$data['userid'].'</h3>
            <h2 class="text-success">'.$data['nama'].'</h2>
            <h3>'.$data['checktime'].'</h3>
       ';
   
    echo '<button id="cekout" type="button" class="btn btn-round btn-warning btn-lg">Keluar dari Lokasi Kunjungan</button>';
?>